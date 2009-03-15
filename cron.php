<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if(!defined('InWeBid')) exit();

if (!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = 'cron.php';
include $include_path . "converter.inc.php";

function openLogFile ()
{
    global $logFileHandle, $logFileName, $logPath;
    global $cronScriptHTMLOutput;

    $logFileHandle = fopen ($logPath . 'cron.log', "a");
    if ($cronScriptHTMLOutput == true)
        print "<pre>\n";
}

function closeLogFile ()
{
    global $logFileHandle;
    global $cronScriptHTMLOutput;

    if ($logFileHandle)
        fclose ($logFileHandle);
    if ($cronScriptHTMLOutput)
        print "</pre>\n";
}

function printLog ($str)
{
    global $logFileHandle;
    global $cronScriptHTMLOutput;

    if ($logFileHandle) {
        if (substr($str, strlen($str) - 1, 1) != "\n")
            $str .= "\n";
        fwrite ($logFileHandle, $str);
        if ($cronScriptHTMLOutput)
            print "" . $str;
    }
}

function printLogL ($str, $level)
{
    for($i = 1;$i <= $level;++$i)
    $str = "\t" . $str;
    printLog($str);
}

function errorLog ($str)
{
    global $logFileHandle, $adminEmail;

    printLog ($str);
    closeLogFile();
    exit;
}

function errorLogSQL ()
{
    global $query;
    errorLog ("SQL query error: $query\n" . "Error: " . mysql_error());
}

function constructCategories()
{
    global $DBPrefix;
    $query = "SELECT cat_id, parent_id, sub_counter, counter
	         FROM " . $DBPrefix . "categories ORDER BY cat_id";
    $res = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_array($res)) {
        $row['updated'] = false;
        $categories[$row['cat_id']] = $row;
    }
    return $categories;
}
// initialize cron script
openLogFile();
printLog("=============== STARTING CRON SCRIPT: " . gmdate("F d, Y H:i:s"));

$categories = constructCategories();

/**
 * ------------------------------------------------------------
 * 1) "close" expired auctions
 * closing auction means:
 * a) update database:
 * + "auctions" table
 * + "categories" table - for counters
 * + "counters" table
 * b) send email to winner (if any) - passing seller's data
 * c) send email to seller (reporting if there was a winner)
 */
printLog("++++++ Closing expired auctions");
$NOW = time();
$NOWB = gmdate('Ymd');
$query = "SELECT * FROM " . $DBPrefix . "auctions
         WHERE ends <= '$NOW'
         AND ((closed = 0)
         OR (closed = 1
         AND reserve_price > 0
         AND num_bids > 0
         AND current_bid < reserve_price
         AND sold = 's'))";
$result = mysql_query($query);

if (!$result)
    errorLogSQL();
else {
    $num = mysql_num_rows($result);
    printLog($num . " auctions to close");

    $resultAUCTIONS = $result;
    $n = 1;
    while ($row = mysql_fetch_array($resultAUCTIONS)) { // loop auctions
        $n++;
        $Auction = $row;
        $Auction['description'] = strip_tags($Auction['description']);
        printLog("\nProcessing auction: " . $row['id']);
        // //======================================================
        // BEGINNING OF ITEM WATCH CODE
        // //======================================================
        // Send notification if user added auction closes
        $ended_auction_id = $row['id'];
        $title = $row['title'];

        $resultUSERS = mysql_query("SELECT name, email, item_watch FROM " . $DBPrefix . "users");
        while ($watchusers = mysql_fetch_array($resultUSERS)) {
            $usname = $watchusers['name'];
            $e_mail = $watchusers['email'];
            $keyword = $watchusers['item_watch'];
            $key = split(" ", $keyword);
            for ($j = 0; $j < count($key); $j++) {
                $match = strpos($key[$j], $ended_auction_id);
            }
            // If keyword matches with opened auction title or/and desc send user a mail
            if ($match) {
				$emailer = new email_class();
				$emailer->assign_vars(array(
						'URL' => $system->SETTINGS['siteurl'] . "item.php?mode=1&id=" . $ended_auction_id,
						'TITLE' => $title,
						'NAME' => $usname
						));
				$emailer->email_sender($e_mail, 'mail_auctionend_watchmail.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['471']);
            }
        }
        // ======================================================
        // END OF ITEM WATCH CODE
        // ======================================================
        // ************************************
        // update category tables
        // *************************************
        $cat_id = $row['category'];
        $root_cat = $cat_id;
        do {
            // update counter for this category
            $R_parent_id = $categories[$cat_id]['parent_id'];
            $R_cat_id = $categories[$cat_id]['cat_id'];
            $R_counter = intval($categories[$cat_id]['counter']);
            $R_sub_counter = intval($categories[$cat_id]['sub_counter']);
            $R_sub_counter--;
            if ($cat_id == $root_cat)
                --$R_counter;
            if ($R_counter < 0)
                $R_counter = 0;
            if ($R_sub_counter < 0)
                $R_sub_counter = 0;
            $categories[$cat_id]['counter'] = $R_counter;
            $categories[$cat_id]['sub_counter'] = $R_sub_counter;
            $categories[$cat_id]['updated'] = true;
            $cat_id = $R_parent_id;
        } while ($cat_id != 0 && isset($categories[$cat_id]));
        // update "counters" table - decrease number of auctions
        $query = "UPDATE " . $DBPrefix . "counters SET auctions=(auctions-1),
		         closedauctions=(closedauctions+1)";
        if (!mysql_query($query))
            errorLogSQL();
        // //************************************
        // //  RETRIEVE SELLER INFO FROM DATABASE
        // //*************************************
        $query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $Auction['user'];
        $result = mysql_query($query);
        if ($result) {
            if (mysql_num_rows($result) > 0) {
                mysql_data_seek ($result, 0);
                $Seller = mysql_fetch_array($result);
            } else
                $Seller = array();
        } else
            errorLogSQL();
        // //**************************************************
        // // check if there is a winner - and get his info
        // //***************************************************
        $winner_present = false;
        $query = "SELECT * FROM " . $DBPrefix . "bids WHERE auction = '" . $row['id'] . "' ORDER BY bid DESC";
        $result = mysql_query ($query);
        if ($result) {
            if (mysql_num_rows($result) > 0 && ($row['current_bid'] >= $row['reserve_price'] || $row['sold'] == 's')) {
                $decrem = mysql_num_rows($result);
                mysql_data_seek($result, 0);
                $WinnerBid = mysql_fetch_array($result);
                $WinnerBid['quantity'] = $row['quantity'];
                $winner_present = true;
                // RETRIEVE WINNER INFO FROM DATABASE
                $query = "SELECT * FROM " . $DBPrefix . "users WHERE id='" . $WinnerBid['bidder'] . "'";
                $result = mysql_query ($query);
                if ($result) {
                    if (mysql_num_rows($result) > 0) {
                        mysql_data_seek ($result, 0);
                        $Winner = mysql_fetch_array($result);
                    } else
                        $Winner = array ();
                } else
                    errorLogSQL();
            }
        } else
            errorLogSQL();
		// send email to seller - to notify him
		// create a "report" to seller depending of what kind auction is
        $atype = intval($Auction['auction_type']); 
        if ($atype == 1) {
            $WINNING_BID = $Auction['current_bid'];
            // Standard auction
            if ($winner_present) {
                $report_text = $Winner['nick'] . " (<a href='mailto:" . $Winner['email'] . "'>" . $Winner['email'] . "</a>)\n";
                if ($system->SETTINGS['winner_address'] == 'y' && $Winner['address'] != '') {
                    $report_text .= $MSG['30_0086'] . $Winner['address'] . " " . $Winner['city'] . " " . $Winner['prov'] . " " . " " . $Winner['zip'] . ", " . $Winner['country'];
                }
                // Add winner's data to "winners" table
                $query = "INSERT INTO " . $DBPrefix . "winners VALUES (NULL,'" . $Auction['id'] . "','" . $Seller['id'] . "','" . $Winner['id'] . "'," . $Auction['current_bid'] . ", '$NOW', 0, 0, 0, 1)";
                $res = mysql_query($query);
                $system->check_mysql($res, $query, __LINE__, __FILE__);
                // Update column bid in table " . $DBPrefix . "counters
                $counterbid = mysql_query("UPDATE " . $DBPrefix . "counters SET bids=(bids-$decrem)");
            } else {
                $report_text = $MSG['429'];
            }
        } else {
            // //**************************************************
            // //  		 Dutch Auction
            // //***************************************************
            unset($WINNERS_NICK);
            unset($WINNERS_EMAIL);
            unset($WINNERS_NAME);
            unset($WINNERS_QUANT);
            unset($WINNERS_BIDQUANT);
            $report_text = "";
            // find out winners sorted by bid
            $query = "SELECT *, MAX(bid) AS maxbid
					FROM " . $DBPrefix . "bids WHERE auction = " . $Auction['id'] . " GROUP BY bidder
					ORDER BY maxbid DESC , id DESC";
            $res = mysql_query ($query);
            if ($res) {
                $numDbids = mysql_num_rows($res);
                $counterbid = mysql_query("UPDATE " . $DBPrefix . "counters SET bids = (bids - $numDbids)");
                if ($numDbids == 0) {
                    $report_text = "No bids";
                } else {
                    $WINNERS_ID = array();
                    $report_text = "";
                    $WINNING_BID = $WinnerBid['maxbid'];
                    $items_count = $Auction['quantity'];
                    $items_sold = 0;
                    $row = mysql_fetch_array($res);
                    do {
                        if (!in_array($row['bidder'], $WINNERS_ID)) {
                            if ($row['maxbid'] < $WINNING_BID) {
                                $WINNING_BID = $row['maxbid'];
                            }
                            $items_wanted = $row['quantity'];
                            $items_got = 0;
                            if ($items_wanted <= $items_count) {
                                $items_got = $items_wanted;
                                $items_count -= $items_got;
                            } else {
                                $items_got = $items_count;
                                $items_count -= $items_got;
                            }
                            $items_sold += $items_got;
                            // // Retrieve winner nick from the database
                            $query = "SELECT nick,email,name,address,city,zip,prov,country FROM " . $DBPrefix . "users WHERE id='" . $row['bidder'] . "'";
                            $res_n = mysql_query($query);
                            $system->check_mysql($res_n, $query, __LINE__, __FILE__);
                            $NICK = @mysql_result($res_n, 0, "nick");
                            $EMAIL = @mysql_result($res_n, 0, "email");
                            $NAME = @mysql_result($res_n, 0, "name");
                            $ADDRESS = @mysql_result($res_n, 0, "address") . " " .
                            @mysql_result($res_n, 0, "city") . " " .
                            @mysql_result($res_n, 0, "zip") . " " .
                            @mysql_result($res_n, 0, "prov") . ", " .
                            @mysql_result($res_n, 0, "country");
                            $items_got = $items_got;
                            // // ============================
                            $WINNERS_ID[$NICK] = $row['bidder'];
                            $WINNERS_BID[$NICK] = $row['maxbid'];
                            $WINNERS_NICK[$NICK] = $NICK;
                            $WINNERS_EMAIL[$NICK] = $EMAIL;
                            $WINNERS_NAME[$NICK] = $NAME;
                            $WINNERS_QUANT[$NICK] = $items_got;
                            $WINNERS_BIDQUANT[$NICK] = $items_wanted;
                            // // ============================
                            $report_text .= " " . $MSG['159'] . " " . $NICK . " ($EMAIL) " . $items_got . ' ' . $MSG['5492'] . ', ' . $MSG['5493'] . ' ' . $system->print_money($row['bid']) . " " . $MSG['5495'] . " - (" . $MSG['5494'] . " $items_wanted " . $MSG['5492'] . ")\n";
                            if ($system->SETTINGS['winner_address'] == 'y') {
                                $report_text .= " " . $MSG['30_0086'] . $ADDRESS . "\n";
                            }
                            $report_text .= "\n";
                            $totalamount = $row['maxbid'];
                            // Add winner's data to "winners" table
                            $query = "INSERT INTO " . $DBPrefix . "winners VALUES
									 (NULL,'$Auction[id]','$Seller[id]', '$row[bidder]', $row[maxbid], '$NOW', 0, 0, 0, $items_got)";
                            $res_ = mysql_query($query);
                            $system->check_mysql($res_, $query, __LINE__, __FILE__);
                            // Update column transaction in table " . $DBPrefix . "counters
                            $counterbid = mysql_query("UPDATE " . $DBPrefix . "counters SET transactions=(transactions+1)");
                        }
                        if (!$row = mysql_fetch_array($res)) {
                            break;
                        }
                    } while (($items_count > 0) && $res);

                    $report_text .= $MSG['643'] . " " . $system->print_money($WINNING_BID);
                    printLog($report_text);
                }
            } else {
                errorLogSQL();
            }
        } // end auction ends
        printLogL ("mail to seller: " . $Seller['email'], 1);
        $i_title = $Auction['title'];

		$month = gmdate('m', $Auction['ends'] + $system->tdiff);
        $ends_string = $MSG['MON_0' . $month] . ' ' . gmdate('d, Y H:i', $Auction['ends'] + $system->tdiff);

        if ($Auction['relist'] > 0 && ($Auction['relist'] - $Auction['relisted']) > 0) {
            // Auctomatic relisting
            $_BIDSNUM = @mysql_num_rows(@mysql_query("SELECT id FROM " . $DBPrefix . "bids WHERE auction = '" . $Auction['id'] . "'"));

            if ($_BIDSNUM == 0 || ($_BIDSNUM > 0 && $Auction['reserve_price'] > 0 && !$winner_present)) {
                // Calculate start and end time
                $_STARTS = $NOW;
                $_ENDS = $NOW + $Auction['duration'] * 24 * 60 * 60;

                $close = mysql_query("DELETE " . $DBPrefix . "bids WHERE auction = " . $Auction['id']);
                $close = mysql_query("DELETE " . $DBPrefix . "proxybid WHERE itemid = " . $Auction['id']);
                $close = mysql_query("UPDATE " . $DBPrefix . "auctions SET
				                     starts = '$_STARTS',
				                     ends = '$_ENDS',
				                     current_bid = 0,
				                     num_bids = 0,
				                     relisted = relisted + 1
				                     WHERE id = " . $Auction['id']);
            } else {
                // Close auction
                $query = "UPDATE " . $DBPrefix . "auctions SET closed = 1,
				         starts = '" . $Auction['starts'] . "',
				         ends = '" . $Auction['ends'] . "',
				         sold = CASE sold WHEN 's' THEN 'y' ELSE sold END
				         WHERE id = " . $Auction['id'];
                if (!mysql_query($query))
                    errorLogSQL();
            }
        } else {
            // // Close auction
            $query = "UPDATE " . $DBPrefix . "auctions SET closed = 1,
			         starts = '" . $Auction['starts'] . "',
			         ends = '" . $Auction['ends'] . "',
			         sold = CASE sold WHEN 's' THEN 'y' ELSE sold END
			         WHERE id = " . $Auction['id'];
            if (!mysql_query($query))
                errorLogSQL();
        }
        // //======================================================
        // WINNER PRESENT FEES NEED TO BE INSERTED
        // //======================================================
        if ($winner_present) {
            // Send mail to the seller
            include $include_path . 'endauction_winner.inc.php';
            if (count($WINNERS_NICK) > 0) {
                while (list($k, $v) = each($WINNERS_NICK)) {
                    $Winner['name'] = $WINNERS_NAME[$k];
                    $Winner['email'] = $WINNERS_EMAIL[$k];
                    $Winner['nick'] = $WINNERS_NICK[$k];
                    $Winner['quantity'] = $WINNERS_QUANT[$k];
                    $Winner['wanted'] = $WINNERS_BIDQUANT[$k];
                    // Send mail to the buyer
                    include $include_path . 'endauction_youwin.inc.php';
                }
            } elseif (is_array($Winner)) {
                // Send mail to the buyer
                include $include_path . 'endauction_youwin_nodutch.inc.php';
            }
        }
        if (!$winner_present) {
            // Send mail to the seller if no winner
            if ($Seller['endemailmode'] != 'cum') {
                include $include_path . 'endauction_nowinner.inc.php';
            } else {
                // Save in the database to send later
                @mysql_query("INSERT INTO " . $DBPrefix . "pendingnotif VALUES (
								NULL, " . $Auction['id'] . ", " . $Seller['id'] . ", '',
								'" . serialize($Auction) . "', '" . serialize($Seller) . "', '" . date("Ymd") . "')");
            }
        }
    }
    if (count($categories) > 0) {
        foreach($categories as $cat_id => $category) {
            if ($category['updated']) {
                $query = "UPDATE " . $DBPrefix . "categories SET
						 counter = " . $category['counter'] . ",
						 sub_counter = " . $category['sub_counter'] . "
						 WHERE cat_id = $cat_id";
                $res = mysql_query($query);
                $category['updated'] = false;
            }
        }
    }
}

// "remove" old auctions (archive them)
printLog("\n");
printLog("++++++ Archiving old auctions");

$expireAuction = 60 * 60 * 24 * $system->SETTINGS['archiveafter']; // time of auction expiration (in seconds)
$expiredTime = time() - $expireAuction;

$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE ends <= '$expiredTime'";
$result = mysql_query($query);

if ($result) {
    $num = mysql_num_rows($result);
    printLog($num . " auctions to archive");
    if ($num > 0) {
        $resultCLOSEDAUCTIONS = $result;
        while ($row = mysql_fetch_array($resultCLOSEDAUCTIONS, MYSQL_ASSOC)) {
            $AuctionInfo = $row;
            printLogL("Processing auction: " . $AuctionInfo['id'], 0);

            $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id='" . $AuctionInfo['id'] . "'";
            if (!mysql_query($query))
                errorLogSQL();

            // delete bids for this auction
            $query = "SELECT * FROM " . $DBPrefix . "bids WHERE auction='" . $AuctionInfo['id'] . "'";
            $result = mysql_query($query);
            if ($result) {
                $num = mysql_num_rows($result);
                if ($num > 0) {
                    printLogL ($num . " bids for this auction to delete", 1);
                    $resultBIDS = $result;
                    while ($row = mysql_fetch_array($resultBIDS, MYSQL_ASSOC)) {
                        // archive this bid
                        $query = "delete from " . $DBPrefix . "bids WHERE auction='" . $row['auction'] . "'";
                        $res = mysql_query($query);
                        if (!$res)
                            errorLogSQL();
                    }
                }
            } else
                errorLogSQL();
            // // #################################################################################################
            // // Delete proxybid entries
            @mysql_query("delete from " . $DBPrefix . "proxybid WHERE itemid = " . $AuctionInfo['id']);
            // // Delete counter entries
            @mysql_query("delete from " . $DBPrefix . "auccounter WHERE auction_id = " . $AuctionInfo['id']);
            // // Delete variants entries
            // // Pictures gallery
            if (file_exists($upload_path . $AuctionInfo['id'])) {
                if ($dir = @opendir($upload_path . $AuctionInfo['id'])) {
                    while ($file = readdir($dir)) {
                        if ($file != "." && $file != "..") {
                            @unlink($upload_path . $AuctionInfo['id'] . '/' . $file);
                        }
                    }
                    closedir($dir);

                    @rmdir($upload_path . $AuctionInfo['id']);
                }
            }
            // // Picture
            @unlink($upload_path . $AuctionInfo['pict_url']);
        }
    }
} else {
    errorLogSQL();
}

// Purging thumbnails cache and not more used images
if (!file_exists($upload_path . "cache"))
    mkdir($upload_path . "cache", 0777);
if (!file_exists($upload_path . "cache/purge"))
    touch($upload_path . "cache/purge");
$purgecachetime = filectime($upload_path . "cache/purge");
if ((time() - $purgecachetime) > 86400) {
    $dir = $upload_path . "cache";
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != 'purge' && !is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > 86400)
                unlink($dir . '/' . $file);
        }
        closedir($dh);
    }
    // starting all site images purge
    $imgarray[] = $system->SETTINGS['logo'];
    $imgarray[] = $system->SETTINGS['background'];
    $result = mysql_query("SELECT pict_url from " . $DBPrefix . "auctions WHERE photo_uploaded='1'");
    while ($row = mysql_fetch_array($result, MYSQL_NUM))
    $imgarray[] = $row[0];
    $result = mysql_query("SELECT id from " . $DBPrefix . "auctions");
    $imgdir = array();
    while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        if (is_dir($uploaded_path . $row[0]))
            $imgdir[] = $row[0];
    }
    // Ordinary images purge
    $dir = $upload_path;
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "purge" && !is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > (86400 * 30) && !in_array($file, $imgarray))
                unlink($dir . '/' . $file);
        }
        closedir($dh);
    }
    // galleries dirs and files purge
    if (is_array($imgdir) && ($dh = opendir($dir))) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "banners" && $file != ".." && $file != "." && $file != "CVS" && is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > (86400 * 30) && !in_array($file, $imgdir)) {
                $ddel = $dir . '/' . $file;
                if ($ddh = opendir($ddel)) {
                    while (($fdel = readdir($ddh)) !== false) {
                        if (!is_dir($ddel . '/' . $fdel))
                            unlink($ddel . '/' . $fdel);
                    }
                    closedir($ddh);
                    rmdir($ddel);
                }
            }
        }
        closedir($dh);
    }
    // Banners purge
    $result = mysql_query("SELECT name from " . $DBPrefix . "banners");
    while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $imgarray[] = "banners/" . $result[0];
    }
    $dir = $upload_path . "banners/";
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "purge" && !is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > (86400 * 30) && !in_array('banners/' . $file, $imgarray))
                    unlink($dir . $file);
            }
            closedir($dh);
        }
    }
    touch($upload_path . "cache/purge");
}
// Update counters
include $include_path . "updatecounters.inc.php";
// finish cron script
printLog ("=========================== ENDING CRON: " . date("F d, Y H:i:s") . "\n");
closeLogFile();

?>