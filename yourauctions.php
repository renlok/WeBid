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
// // If user is not logged in redirect to login page
if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("Location: user_login.php");
    exit;
}

$NOW = time();
$NOWB = gmdate("Ymd");
// DELETE OR CLOSE OPEN AUCTIONS
if (isset($_POST['action']) && $_POST['action'] == "delopenauctions") {
    if (is_array($_POST['O_delete'])) {
        while (list($k, $v) = each($_POST['O_delete'])) {
            $v = str_replace('..', '', htmlspecialchars($v));
            // // Pictures Gallery
            if (file_exists($upload_path . $v)) {
                if ($dir = @opendir($upload_path . $v)) {
                    while ($file = readdir($dir)) {
                        if ($file != "." && $file != "..") {
                            @unlink($upload_path . $v . '/' . $file);
                        }
                    }
                    closedir($dir);

                    @rmdir($upload_path . $v);
                }
            }

            $query = "SELECT photo_uploaded,pict_url FROM " . $DBPrefix . "auctions WHERE id=" . intval($v);
            $res_ = mysql_query($query);
            $system->check_mysql($res_, $query, __LINE__, __FILE__);
            if (mysql_num_rows($res_) > 0) {
                $pict_url = mysql_result($res_, 0, "pict_url");
                $photo_uploaded = mysql_result($res_, 0, "photo_uploaded");
                if ($photo_uploaded) {
                    @unlink($upload_path . $pict_url);
                }
            }
            // // Delete Invited Users List and Black Lists associated with this auction ---------------------------
            @mysql_query("DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id=" . intval($v));
            // // Auction
            $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id=" . intval($v);
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            // // Update counters
            include $include_path . "updatecounters.inc.php";
        }
    }

    if (is_array($_POST['closenow'])) {
        while (list($k, $v) = each($_POST['closenow'])) {
            // Update end time to "now"
            @mysql_query("UPDATE " . $DBPrefix . "auctions SET ends = '" . $NOW . "', starts = starts, relist = relisted WHERE id = " . intval($v));
        }
        include "cron.php";
    }
}
// Retrieve active auctions from the database
$TOTALAUCTIONS = mysql_result(mysql_query("SELECT count(id) AS COUNT FROM " . $DBPrefix . "auctions WHERE user='" . $_SESSION['WEBID_LOGGED_IN'] . "' AND closed=0 AND starts<=" . $NOW . " AND suspended=0"), 0, "COUNT");

if (!isset($_GET['PAGE']) || $_GET['PAGE'] <= 1 || $_GET['PAGE'] == "") {
    $OFFSET = 0;
    $PAGE = 1;
} else {
    $OFFSET = ($_GET['PAGE'] - 1) * $LIMIT;
    $PAGE = $_GET['PAGE'];
}
$PAGES = ceil($TOTALAUCTIONS / $LIMIT);
if (!$PAGES) $PAGES = 1;
$_SESSION['backtolist_page'] = $PAGE;
// Handle columns sorting variables
if (!isset($_SESSION['oa_ord']) && empty($_GET['oa_ord'])) {
    $_SESSION['oa_ord'] = "title";
    $_SESSION['oa_type'] = "asc";
} elseif (!empty($_GET['oa_ord'])) {
    $_SESSION['oa_ord'] = str_replace('..', '', addslashes(htmlspecialchars($_GET['oa_ord'])));
    $_SESSION['oa_type'] = str_replace('..', '', addslashes(htmlspecialchars($_GET['oa_type'])));
} elseif (isset($_SESSION['oa_ord']) && empty($_GET['oa_ord'])) {
    $_SESSION['oa_nexttype'] = $_SESSION['oa_type'];
}
if ($_SESSION['oa_nexttype'] == "desc") {
    $_SESSION['oa_nexttype'] = "asc";
} else {
    $_SESSION['oa_nexttype'] = "desc";
}
if ($_SESSION['oa_type'] == "desc") {
    $_SESSION['oa_type_img'] = "<img src=\"images/arrow_up.gif\" align=\"center\" hspace=\"2\" border=\"0\" />";
} else {
    $_SESSION['oa_type_img'] = "<img src=\"images/arrow_down.gif\" align=\"center\" hspace=\"2\" border=\"0\" />";
}

$query = "SELECT DISTINCT id,title,current_bid,starts,ends,minimum_bid,duration,relist,relisted,num_bids,suspended
			FROM " . $DBPrefix . "auctions
			WHERE user = '" . $_SESSION['WEBID_LOGGED_IN'] . "'
			AND closed = 0
			AND starts <= '" . $NOW . "'
			AND suspended = 0
			ORDER BY " . $_SESSION['oa_ord'] . " " . $_SESSION['oa_type'] . " LIMIT " . intval($OFFSET) . "," . intval($LIMIT);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
while ($item = mysql_fetch_array($res)) {
    if ($item['num_bids'] > 0) {
        $query = "SELECT b.bid AS maxbid, b.bidder, u.nick FROM " . $DBPrefix . "bids b
				LEFT JOIN " . $DBPrefix . "users u ON (u.id = b.bidder) WHERE b.auction=" . intval($item['id']) . " ORDER BY b.bid DESC, b.id DESC LIMIT 1";
        $result_ = mysql_query ($query) ;
        $system->check_mysql($result_, $query, __LINE__, __FILE__);
        if (mysql_num_rows($result_) > 0) {
            $high_bid = mysql_result ($result_, 0, "maxbid");
            $bidderid = mysql_result ($result_, 0, "bidder");
            $bidder = mysql_result ($result_, 0, "nick");
        }
    } else {
        $bidder = '';
        $bidderid = '';
    }
    // Retrieve counter
    $query = "SELECT counter FROM " . $DBPrefix . "auccounter WHERE auction_id = " . intval($item['id']);
    $res_c = mysql_query($query);
    $system->check_mysql($res_c, $query, __LINE__, __FILE__);
    if (mysql_num_rows($res_c) > 0) {
        $viewcounter = mysql_result($res_c, 0, "counter");
    } else {
        $viewcounter = 0;
    }

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
            'BIDDER' => $bidder,
            'BIDDERID' => $bidderid,
            'COUNTER' => $viewcounter,

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
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions.php?PAGE=' . $COUNTER . '&id=' . $id . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$template->assign_vars(array(
        'BGCOLOUR' => ($i % 2) ? '#FFCCFF' : '#EEEEEE',
        'TBLHEADERCOLOUR' => $system->SETTINGS['tableheadercolor'],
        'ORDERCOL' => $_SESSION['oa_ord'],
        'ORDERNEXT' => $_SESSION['oa_nexttype'],
        'ORDERTYPEIMG' => $_SESSION['oa_type_img'],

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions.php?PAGE=' . $PREV . '&id=' . $id . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions.php?PAGE=' . $NEXT . '&id=' . $id . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES,

        'B_AREITEMS' => ($i > 0)
        ));

include "header.php";
$TMP_usmenutitle = $MSG['619'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'yourauctions.html'
        ));
$template->display('body');
include "footer.php";

?>