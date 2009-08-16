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

if (!defined('InWeBid')) exit();

if (!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = 'cron.php';

function openLogFile()
{
	global $logFileHandle, $logPath;

	$logFileHandle = fopen($logPath . 'cron.log', "a");
}

function closeLogFile()
{
	global $logFileHandle;

	if ($logFileHandle)
		fclose ($logFileHandle);
}

function printLog($str)
{
	global $logFileHandle;

	if ($logFileHandle)
	{
		if (substr($str, strlen($str) - 1, 1) != "\n")
			$str .= "\n";
		fwrite ($logFileHandle, $str);
	}
}

function printLogL($str, $level)
{
	for ($i = 1; $i <= $level; ++$i)
	$str = "\t" . $str;
	printLog($str);
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
$result_auction = mysql_query($query);
$system->check_mysql($result_auction, $query, __LINE__, __FILE__);

$num = mysql_num_rows($result_auction);
printLog($num . " auctions to close");
$count_auctions = $num;
$n = 1;
while ($Auction = mysql_fetch_array($result_auction)) // loop auctions
{
	$n++;
	$Auction['description'] = strip_tags($Auction['description']);
	printLog("\nProcessing auction: " . $Auction['id']);

	// Send notification to all users watching this auction
	$query = "SELECT name, email, item_watch, id FROM " . $DBPrefix . "users WHERE item_watch LIKE '% " . $Auction['id'] . " %'";
	$resultUSERS = mysql_query($query);
	$system->check_mysql($resultUSERS, $query, __LINE__, __FILE__);
	while ($watchusers = mysql_fetch_array($resultUSERS))
	{
		$usname = $watchusers['name'];
		$e_mail = $watchusers['email'];
		$keys = explode(' ', $watchusers['item_watch']);
		// If keyword matches with opened auction title or/and desc send user a mail
		if (in_array($Auction['id'], $keys))
		{
			$emailer = new email_class();
			$emailer->assign_vars(array(
					'URL' => $system->SETTINGS['siteurl'] . 'item.php?mode=1&id=' . $Auction['id'],
					'TITLE' => $Auction['title'],
					'NAME' => $usname
					));
			$emailer->email_uid = $watchusers['id'];
			$emailer->email_sender($e_mail, 'auctionend_watchmail.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['471']);
		}
	}

	// RETRIEVE SELLER INFO FROM DATABASE
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $Auction['user'] . " LIMIT 1";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	if (mysql_num_rows($result) > 0)
	{
		$Seller = mysql_fetch_array($result);
	}
	else
	{
		$Seller = array();
	}

	// check if there is a winner - and get his info
	$winner_present = false;
	$query = "SELECT u.* FROM " . $DBPrefix . "bids b
			LEFT JOIN " . $DBPrefix . "users u ON (b.bidder = u.id)
			WHERE auction = '" . $Auction['id'] . "' ORDER BY bid DESC";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$decrem = mysql_num_rows($result);

	// send email to seller - to notify him
	// create a "report" to seller depending of what kind auction is
	$atype = intval($Auction['auction_type']); 
	if ($atype == 1)
	{
		if ($decrem && ($Auction['current_bid'] >= $Auction['reserve_price'] || $Auction['sold'] == 's'))
		{
			mysql_data_seek($result, 0);
			$Winner = mysql_fetch_array($result);
			$Winner['quantity'] = $Auction['quantity'];
			$winner_present = true;
		}
		$WINNING_BID = $Auction['current_bid'];
		// Standard auction
		if ($winner_present)
		{
			$report_text = $Winner['nick'] . ' (<a href="mailto:' . $Winner['email'] . '">' . $Winner['email'] . '</a>)' . "\n";
			if ($system->SETTINGS['winner_address'] == 'y' && $Winner['address'] != '')
			{
				$report_text .= $MSG['30_0086'] . $Winner['address'] . ' ' . $Winner['city'] . ' ' . $Winner['prov'] . ' ' . $Winner['zip'] . ', ' . $Winner['country'];
			}
			// Add winner's data to "winners" table
			$query = "INSERT INTO " . $DBPrefix . "winners VALUES
			(NULL, '" . $Auction['id'] . "', '" . $Seller['id'] . "', '" . $Winner['id'] . "', " . $Auction['current_bid'] . ", '" . $NOW . "', 0, 0, 1, 0)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		else
		{
			$report_text = $MSG['429'];
		}
	}
	else
	{
		// Dutch Auction
		unset($WINNERS_NICK, $WINNERS_EMAIL, $WINNERS_NAME, $WINNERS_QUANT, $WINNERS_BIDQUANT);
		$report_text = '';
		// find out winners sorted by bid
		$query = "SELECT *, MAX(bid) AS maxbid
				FROM " . $DBPrefix . "bids WHERE auction = " . $Auction['id'] . " GROUP BY bidder
				ORDER BY maxbid DESC, quantity DESC, id DESC";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		if ($decrem == 0)
		{
			$report_text = 'No bids';
		}
		else
		{
			$WINNERS_ID = array();
			$report_text = '';
			$items_count = $Auction['quantity'];
			$items_sold = 0;
			$WINNING_BID = 0;
			$row = mysql_fetch_array($res);
			do
			{
				if (!in_array($row['bidder'], $WINNERS_ID))
				{
					if ($row['maxbid'] < $WINNING_BID)
					{
						$WINNING_BID = $row['maxbid'];
					}
					$items_wanted = $row['quantity'];
					$items_got = 0;
					if ($items_wanted <= $items_count)
					{
						$items_got = $items_wanted;
						$items_count -= $items_got;
					}
					else
					{
						$items_got = $items_count;
						$items_count -= $items_got;
					}
					$items_sold += $items_got;
					// Retrieve winner nick from the database
					$query = "SELECT nick, email, name, address, city, zip, prov, country FROM " . $DBPrefix . "users WHERE id = " . $row['bidder'] . " LIMIT 1";
					$res_n = mysql_query($query);
					$system->check_mysql($res_n, $query, __LINE__, __FILE__);
					$Winner = mysql_fetch_assoc($res_n);
					$NICK = $Winner['nick'];
					$EMAIL = $Winner['email'];
					$NAME = $Winner['name'];
					$ADDRESS = $Winner['address'] . ' ' . $Winner['city'] . ' ' . $Winner['zip'] . ' ' . $Winner['prov'] . ', ' . $Winner['country'];
					$items_got = $items_got;
					// set arrays
					$WINNERS_ID[$NICK] = $row['bidder'];
					$WINNERS_BID[$NICK] = $row['maxbid'];
					$WINNERS_NICK[$NICK] = $NICK;
					$WINNERS_EMAIL[$NICK] = $EMAIL;
					$WINNERS_NAME[$NICK] = $NAME;
					$WINNERS_QUANT[$NICK] = $items_got;
					$WINNERS_BIDQUANT[$NICK] = $items_wanted;
					// ============================
					$report_text .= ' ' . $MSG['159'] . ' ' . $NICK . ' (' . $EMAIL . ') ' . $items_got . ' ' . $MSG['5492'] . ', ' . $MSG['5493'] . ' ' . $system->print_money($row['bid']) . ' ' . $MSG['5495'] . ' - (' . $MSG['5494'] . ' ' . $items_wanted . ' ' . $MSG['5492'] . ')' . "\n";
					if ($system->SETTINGS['winner_address'] == 'y') {
						$report_text .= ' ' . $MSG['30_0086'] . $ADDRESS . "\n";
					}
					$totalamount = $row['maxbid'];
					// Add winner's data to "winners" table
					$query = "INSERT INTO " . $DBPrefix . "winners VALUES
					(NULL, '" . $Auction['id'] . "', '" . $Seller['id'] . "', '" . $row['bidder'] . "', " . $row['maxbid'] . ", '" . $NOW . "', 0, 0, " . $items_got . ", 0)";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				if (!$row = mysql_fetch_array($res))
				{
					break;
				}
			} while (($items_count > 0) && $res);

			$report_text .= $MSG['643'] . ' ' . $system->print_money($WINNING_BID);
			printLog($report_text);
		}
	} // end auction ends
	printLogL ("mail to seller: " . $Seller['email'], 1);

	$month = gmdate('m', $Auction['ends'] + $system->tdiff);
	$ends_string = $MSG['MON_0' . $month] . ' ' . gmdate('d, Y H:i', $Auction['ends'] + $system->tdiff);

	$close_auction = false;
	if ($Auction['relist'] > 0 && ($Auction['relist'] - $Auction['relisted']) > 0)
	{
		// Auctomatic relisting
		$query = "SELECT id FROM " . $DBPrefix . "bids WHERE auction = '" . $Auction['id'] . "'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$_BIDSNUM = mysql_num_rows($res);

		if ($_BIDSNUM == 0 || ($_BIDSNUM > 0 && $Auction['reserve_price'] > 0 && !$winner_present))
		{
			// Calculate end time
			$_ENDS = $NOW + $Auction['duration'] * 24 * 60 * 60;

			$query = "DELETE " . $DBPrefix . "bids WHERE auction = " . $Auction['id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "DELETE " . $DBPrefix . "proxybid WHERE itemid = " . $Auction['id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "UPDATE " . $DBPrefix . "auctions SET starts = '" . $NOW . "', ends = '" . $_ENDS . "',
					current_bid = 0, num_bids = 0, relisted = relisted + 1 WHERE id = " . $Auction['id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$count_auctions--;
		}
		else
		{
			$close_auction = true;
		}
	}
	else
	{
		$close_auction = true;
	}

	if ($close_auction)
	{
		// update category tables
		$cat_id = $Auction['category'];
		$root_cat = $cat_id;
		while ($cat_id != -1 && isset($categories[$cat_id]))
		{
			// update counter for this category
			$R_counter = intval($categories[$cat_id]['counter']) - 1;
			$R_sub_counter = intval($categories[$cat_id]['sub_counter']) - 1;
			if ($cat_id == $root_cat)
				--$R_counter;
			if ($R_counter < 0)
				$R_counter = 0;
			if ($R_sub_counter < 0)
				$R_sub_counter = 0;
			$categories[$cat_id]['counter'] = $R_counter;
			$categories[$cat_id]['sub_counter'] = $R_sub_counter;
			$categories[$cat_id]['updated'] = true;
			if ($cat_id == $categories[$cat_id]['parent_id']) // incase something messes up
				break;
			$cat_id = $categories[$cat_id]['parent_id'];
		}

		// Close auction
		$query = "UPDATE " . $DBPrefix . "auctions SET closed = 1,
				 sold = CASE sold WHEN 's' THEN 'y' ELSE sold END
				 WHERE id = " . $Auction['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}

	// WINNER PRESENT
	if ($winner_present)
	{
		// Send mail to the seller
		include $include_path . 'endauction_winner.inc.php';
		if (isset($WINNERS_NICK) && is_array($WINNERS_NICK) && count($WINNERS_NICK) > 0)
		{
			foreach ($WINNERS_NICK as $k => $v)
			{
				$Winner['name'] = $WINNERS_NAME[$k];
				$Winner['email'] = $WINNERS_EMAIL[$k];
				$Winner['nick'] = $WINNERS_NICK[$k];
				$Winner['quantity'] = $WINNERS_QUANT[$k];
				$Winner['wanted'] = $WINNERS_BIDQUANT[$k];
				// Send mail to the buyer
				include $include_path . 'endauction_youwin.inc.php';
			}
		}
		elseif (is_array($Winner))
		{
			// Send mail to the buyer
			include $include_path . 'endauction_youwin_nodutch.inc.php';
		}
	}
	else
	{
		// Send mail to the seller if no winner
		if ($Seller['endemailmode'] != 'cum')
		{
			include $include_path . 'endauction_nowinner.inc.php';
		}
		else
		{
			// Save in the database to send later
			$query = "INSERT INTO " . $DBPrefix . "pendingnotif VALUES
			(NULL, " . $Auction['id'] . ", " . $Seller['id'] . ", '', '" . serialize($Auction) . "', '" . serialize($Seller) . "', '" . gmdate('Ymd') . "')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	// Update bid counter
	$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids - " . $decrem . ")";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
}

$query = "UPDATE " . $DBPrefix . "counters SET auctions = (auctions - " . $count_auctions . "), closedauctions = (closedauctions + " . $count_auctions . ")";
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

if (count($categories) > 0)
{
	foreach ($categories as $cat_id => $category)
	{
		if ($category['updated'])
		{
			$query = "UPDATE " . $DBPrefix . "categories SET
					 counter = " . $category['counter'] . ",
					 sub_counter = " . $category['sub_counter'] . "
					 WHERE cat_id = " . $cat_id;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
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
$system->check_mysql($result, $query, __LINE__, __FILE__);

$num = mysql_num_rows($result);
printLog($num . " auctions to archive");
if ($num > 0)
{
	while ($AuctionInfo = mysql_fetch_assoc($result))
	{
		printLogL("Processing auction: " . $AuctionInfo['id'], 0);

		// delete auction
		$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = '" . $AuctionInfo['id'] . "'";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// delete bids for this auction
		$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction='" . $AuctionInfo['id'] . "'";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// Delete proxybid entries
		$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = " . $AuctionInfo['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// Delete counter entries
		$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = " . $AuctionInfo['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// Delete all images
		if (file_exists($upload_path . $AuctionInfo['id']))
		{
			if ($dir = @opendir($upload_path . $AuctionInfo['id']))
			{
				while ($file = readdir($dir))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink($upload_path . $AuctionInfo['id'] . '/' . $file);
					}
				}
				closedir($dir);
				@rmdir($upload_path . $AuctionInfo['id']);
			}
		}
	}
}

// send cumunalative emails
$query = "SELECT id, name, email FROM " . $DBPrefix . "users WHERE endemailmode = 'cum'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while($row = mysql_fetch_array($res))
{
	$query = "SELECT * FROM " . $DBPrefix . "pendingnotif WHERE thisdate < '" . gmdate('Ymd') . "' AND seller_id = " . $row['id'];
	$res_ = mysql_query($query);
	$system->check_mysql($res_, $query, __LINE__, __FILE__);

	while($pending = mysql_fetch_array($res_))
	{
		$Auction = unserialize($pending['auction']);
		$Seller = unserialize($pending['seller']);
		$report .= "-------------------------------------------------------------------------\n" . 
					$Auction['title'] . "\n" . 
					"-------------------------------------------------------------------------\n";
		if(strlen($pending['winners']) > 0)
		{
			$report .= $MSG['453'] . ':' . "\n" . $pending['winners'] . "\n\n";
		}
		else
		{
			$report .= $MSG['1032']."\n\n";
		}
		$query = "DELETE FROM " . $DBPrefix . "pendingnotif WHERE id = " . $pending['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	include $include_path . "endauction_cumulative.inc.php";
}

// Purging thumbnails cache
if (!file_exists($upload_path . 'cache'))
{
	mkdir($upload_path . 'cache', 0777);
}

if (!file_exists($upload_path . 'cache/purge'))
{
	touch($upload_path . 'cache/purge');
}

$purgecachetime = filectime($upload_path . 'cache/purge');
if ((time() - $purgecachetime) > 86400)
{
	$dir = $upload_path . 'cache';
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if ($file != 'purge' && !is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > 86400)
				unlink($dir . '/' . $file);
		}
		closedir($dh);
	}
	touch($upload_path . 'cache/purge');
}

// finish cron script
printLog ("=========================== ENDING CRON: " . gmdate('F d, Y H:i:s') . "\n");
closeLogFile();

?>