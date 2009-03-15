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

include "includes/config.inc.php";
include $include_path . "auctionstoshow.inc.php";

$NOW = time();
$NOWB = gmdate("Ymd");
// // If user is not logged in redirect to login page
if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("Location: user_login.php");
    exit;
}
// // DELETE OR CLOSE OPEN AUCTIONS
if (isset($_POST['action']) && $_POST['action'] == "delopenauctions") {
    if (is_array($_POST['O_delete'])) {
        while (list($k, $v) = each($_POST['O_delete'])) {
            $v = str_replace('..', '', htmlspecialchars($v));
            // // Pictures Gallery
            if (file_exists($upload_path . "/$v")) {
                if ($dir = @opendir($upload_path . "/$v")) {
                    while ($file = readdir($dir)) {
                        if ($file != "." && $file != "..") {
                            @unlink($upload_path . "/$v" . $file);
                        }
                    }
                    closedir($dir);

                    @rmdir($upload_path . "/$v");
                }
            }

            $query = "SELECT photo_uploaded,pict_url FROM " . $DBPrefix . "auctions WHERE id='$v'";
            $res_ = mysql_query($query);
            $system->check_mysql($res_, $query, __LINE__, __FILE__);

            if (mysql_num_rows($res_) > 0) {
                $pict_url = mysql_result($res_, 0, "pict_url");
                $photo_uploaded = mysql_result($res_, 0, "photo_uploaded");
                // Uploaded picture
                if ($photo_uploaded) {
                    @unlink($upload_path . $pict_url);
                }
            }
            // Auction
            $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // Update counters
            include $include_path . "updatecounters.inc.php";
        }
    }

    if (is_array($_POST['closenow'])) {
        while (list($k, $v) = each($_POST['closenow'])) {
            // Update end time to "now"
            @mysql_query("UPDATE " . $DBPrefix . "auctions SET ends='" . $NOW . "' WHERE id='$v'");
        }

        include "closeauctions.php";
    }
}

if (isset($_POST['action']) && $_POST['action'] == "sell") {
    // // Delete auction
    if (is_array($_POST['delete'])) {
        while (list($k, $v) = each($_POST['delete'])) {
            // // Pictures Gallery
            if (file_exists($upload_path . "/$v")) {
                if ($dir = @opendir($upload_path . "/$v")) {
                    while ($file = readdir($dir)) {
                        if ($file != "." && $file != "..") {
                            @unlink($upload_path . "/$v" . $file);
                        }
                    }
                    closedir($dir);

                    @rmdir($upload_path . "/$v");
                }
            }

            $query = "SELECT photo_uploaded,pict_url FROM " . $DBPrefix . "auctions WHERE id='$v'";
            $res_ = mysql_query($query);
            $system->check_mysql($res_, $query, __LINE__, __FILE__);

            if (mysql_num_rows($res_) > 0) {
                $pict_url = mysql_result($res_, 0, "pict_url");
                $photo_uploaded = mysql_result($res_, 0, "photo_uploaded");
                // // Uploaded picture
                if ($photo_uploaded) {
                    @unlink($upload_path . $pict_url);
                }
            }
            // // Auction
            $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
        }
    }
}
// // relist selected auction (if any)
if (isset($_POST['action']) && $_POST['action'] == "update") {
    // // Delete auction
    if (is_array($_POST['delete'])) {
        while (list($k, $v) = each($_POST['delete'])) {
            // // Pictures Gallery
            if (file_exists($upload_path . $v)) {
                if ($dir = @opendir($upload_path . $v)) {
                    while ($file = readdir($dir)) {
                        if ($file != "." && $file != "..") {
                            unlink($upload_path . $v . '/' . $file);
                        }
                    }
                    closedir($dir);

                    @rmdir($upload_path . $v);
                }
            }

            $query = "SELECT photo_uploaded,pict_url FROM " . $DBPrefix . "auctions WHERE id='$v'";
            $res_ = mysql_query($query);
            $system->check_mysql($res_, $query, __LINE__, __FILE__);

            if (mysql_num_rows($res_) > 0) {
                $pict_url = mysql_result($res_, 0, "pict_url");
                $photo_uploaded = mysql_result($res_, 0, "photo_uploaded");
                // // Uploaded picture
                if ($photo_uploaded) {
                    @unlink($upload_path . $pict_url);
                }
            }
            // //
            $query = "UPDATE " . $DBPrefix . "counters SET closedauctions=(closedauctions-1)";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // //
            $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Bids
            $decremsql = mysql_query("select * FROM " . $DBPrefix . "bids WHERE auction='$v'");
            $decrem = mysql_num_rows($decremsql);
            $query = "DELETE FROM " . $DBPrefix . "bids WHERE auction='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Proxy Bids
            $query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
        }
    }
    // // Re-list auctions
    if (is_array($_POST['relist'])) {
        while (list($k, $v) = each($relist)) {
            $TODAY = gmdate("YmdHis");
            // auction ends
            $WILLEND = time() + $duration[$k] * 24 * 60 * 60;
            $WILLEND = gmdate("YmdHis", $WILLEND);
            $current_bid = $system->input_money(0.00);
            $query = "UPDATE ". $DBPrefix . "auctions set starts='$TODAY',
											  ends='$WILLEND',
											  duration=$duration[$k],
											  current_bid=$current_bid,
											  closed=0
											  WHERE id='$k'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Bids
            $decremsql = mysql_query("select * FROM " . $DBPrefix . "bids WHERE auction='$v'");
            $decrem = mysql_num_rows($decremsql);
            $query = "DELETE FROM " . $DBPrefix . "bids WHERE auction='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Proxy Bids
            $query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Winners
            $query = "DELETE FROM " . $DBPrefix . "winners WHERE auction='$v'";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Unset EDITED_AUCTIONS array (set in edit_auction.php)
            unset($_SESSION['EDITED_AUCTIONS']);
            // -- Update COUNTERS table
            $query = "UPDATE ". $DBPrefix . "counters set auctions=(auctions+1),closedauctions=(closedauctions-1) ";
            $RR = mysql_query($query);
            $system->check_mysql($RR, $query, __LINE__, __FILE__);
            // // Get category
            $query = "select category from " . $DBPrefix . "auctions WHERE id='$v'";
            $RRR = mysql_query($query);
            $CATEGORY = mysql_result($RRR, 0, "category");
            // // and increase category counters
            $ct = $CATEGORY;
            $row = mysql_fetch_array(mysql_query("SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=$ct"));
            $counter = $row['counter'] + 1;
            $subcoun = $row['sub_counter'] + 1;
            $parent_id = $row['parent_id'];
            mysql_query("UPDATE " . $DBPrefix . "categories SET counter=$counter, sub_counter=$subcoun WHERE cat_id=$ct");
            // update recursive categories
            while ($parent_id != 0) {
                // update this parent's subcounter
                $rw = mysql_fetch_array(mysql_query("SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=$parent_id"));
                $subcoun = $rw['sub_counter'] + 1;
                mysql_query("UPDATE " . $DBPrefix . "categories SET sub_counter=$subcoun WHERE cat_id=$parent_id");
                // get next parent
                $parent_id = intval($rw['parent_id']);
            }
        }
    }
}
// // Retrieve active auctions from the database
$TOTALAUCTIONS = mysql_result(mysql_query("select count(id) as COUNT from " . $DBPrefix . "auctions WHERE user=" . $_SESSION['WEBID_LOGGED_IN'] . " and suspended<>0"), 0, "COUNT");

if (!isset($_GET['PAGE']) || $_GET['PAGE'] < 0 || empty($_GET['PAGE'])) {
    $OFFSET = 0;
    $PAGE = 1;
} else {
    $OFFSET = ($_GET['PAGE'] - 1) * $LIMIT;
    $PAGE = $_GET['PAGE'];
}
$PAGES = ceil($TOTALAUCTIONS / $LIMIT);
if (!$PAGES) $PAGES = 1;
$_SESSION['backtolist_page'] = $PAGE;
$_SESSION['backtolist'] = 'yourauctions_s.php';
// Handle columns sorting variables
if (!isset($_SESSION['sa_ord']) && empty($_GET['sa_ord'])) {
    $_SESSION['sa_ord'] = "title";
    $_SESSION['sa_type'] = "asc";
} elseif (!empty($_GET['sa_ord'])) {
    $_SESSION['sa_ord'] = str_replace('..', '', addslashes(htmlspecialchars($_GET['sa_ord'])));
    $_SESSION['sa_type'] = str_replace('..', '', addslashes(htmlspecialchars($_GET['sa_type'])));
} elseif (isset($_SESSION['sa_ord']) && empty($_GET['sa_ord'])) {
    $_SESSION['sa_nexttype'] = $_SESSION['sa_type'];
}
if ($_SESSION['sa_nexttype'] == "desc") {
    $_SESSION['sa_nexttype'] = "asc";
} else {
    $_SESSION['sa_nexttype'] = "desc";
}
if ($_SESSION['sa_type'] == "desc") {
    $_SESSION['sa_type_img'] = "<img src=\"images/arrow_up.gif\" align=\"center\" hspace=\"2\" border=\"0\" />";
} else {
    $_SESSION['sa_type_img'] = "<img src=\"images/arrow_down.gif\" align=\"center\" hspace=\"2\" border=\"0\" />";
}

$query = "SELECT id,title,current_bid,starts,ends,minimum_bid,duration,relist,relisted
			FROM " . $DBPrefix . "auctions
			WHERE user=" . $_SESSION['WEBID_LOGGED_IN'] . "
			AND suspended<>0 order by " . $_SESSION['sa_ord'] . " " . $_SESSION['sa_type'] . "
			LIMIT $OFFSET,$LIMIT";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
while ($item = mysql_fetch_array($res)) {
    $template->assign_block_vars('items', array(
            'BGCOLOUR' => ($i % 2) ? '#FFCCFF' : '#EEEEEE',
            'ID' => $item['id'],
            'TITLE' => $item['title'],
            'STARTS' => FormatDate($item['starts']),
            'ENDS' => FormatDate($item['ends']),
            'BID' => $system->print_money($item['current_bid']),
            'BIDS' => $item['num_bids'],
            'RELIST' => $item['relist'],
            'RELISTED' => $item['relisted'],

            'B_HASNOBIDS' => ($item['current_bid'] == 0)
            ));
    $i++;
}
// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1) {
    $LOW = $PAGE - 5;
    if ($LOW <= 0) $LOW = 1;
    $COUNTER = $LOW;
    while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6)) {
        $template->assign_block_vars('pages', array(
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_s.php?PAGE=' . $COUNTER . '&id=' . $id . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$template->assign_vars(array(
        'BGCOLOUR' => ($i % 2) ? '#FFCCFF' : '#EEEEEE',
        'TBLHEADERCOLOUR' => $system->SETTINGS['tableheadercolor'],
        'ORDERCOL' => $_SESSION['sa_ord'],
        'ORDERNEXT' => $_SESSION['sa_nexttype'],
        'ORDERTYPEIMG' => $_SESSION['sa_type_img'],

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_s.php?PAGE=' . $PREV . '&id=' . $id . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_s.php?PAGE=' . $NEXT . '&id=' . $id . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES,

        'B_AREITEMS' => ($i > 0)
        ));

include "header.php";
$TMP_usmenutitle = $MSG['2__0056'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'yourauctions_s.html'
        ));
$template->display('body');
include "footer.php";

?>