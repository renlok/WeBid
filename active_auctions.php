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

require('includes/common.inc.php');
include $include_path . 'auctionstoshow.inc.php';
include $include_path . 'dates.inc.php';

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
} elseif ($user->logged_in) {
    $user_id = $user->user_data['id'];
} else {
    header('location: user_login.php');
    exit;
}

$NOW = time();

// get number of active auctions for this user
$query = "SELECT count(id) AS auctions FROM " . $DBPrefix . "auctions
      WHERE user = " . $user_id . "
      AND closed = 0
      AND starts <= '" . $NOW . "' ";
if ($system->SETTINGS['adultonly'] == 'y' && !$user->logged_in) {
    $query .= "AND adultonly = 'n'";
}

$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$num_auctions = mysql_result($result, 0, 'auctions');
// Handle pagination
$TOTALAUCTIONS = $num_auctions;
if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1 || $_GET['PAGE'] == "") {
    $OFFSET = 0;
    $PAGE = 1;
} else {
    $PAGE = $_GET['page'];
    $OFFSET = ($PAGE - 1) * $LIMIT;
}
$PAGES = ceil($TOTALAUCTIONS / $LIMIT);
if (!isset($PAGES) || $PAGES < 1) $PAGES = 1;

$qs = "SELECT * FROM " . $DBPrefix . "auctions
	WHERE user = " . $user_id . "
	AND closed = 0
	AND starts <= '" . $NOW . "' ";
if ($system->SETTINGS['adultonly'] == 'y' && !$user->logged_in) {
    $qs .= "AND adultonly='n' ";
}
$qs .= "ORDER BY ends ASC LIMIT $OFFSET, $LIMIT";
$result = mysql_query ($qs);
$system->check_mysql($result, $qs, __LINE__, __FILE__);

$bgColor = "#EBEBEB";
while ($row = mysql_fetch_array($result)) {
    $bid = $row['current_bid'];
    $starting_price = $row['current_bid'];

    if ($bgColor == "#EBEBEB")
        $bgColor = "#FFFFFF";
    else
        $bgColor = "#EBEBEB";

    if (strlen($row['pict_url']) > 0) {
        $row['pict_url'] = $system->SETTINGS['siteurl'] . "getthumb.php?w=" . $system->SETTINGS['thumb_show'] . "&fromfile=" . $uploaded_path . $row['id'] . "/" . $row['pict_url'];
    } else {
        $row['pict_url'] = $system->SETTINGS['siteurl'] . "images/nopicture.gif";
    }

    // number of bids for this auction
    $query = "SELECT bid FROM " . $DBPrefix . "bids WHERE auction=" . $row['id'];
    $tmp_res = mysql_query ($query);
    $system->check_mysql($tmp_res, $query, __LINE__, __FILE__);
    $num_bids = mysql_num_rows($tmp_res);

    $difference = $row['ends'] - time();

    $template->assign_block_vars('auctions', array(
            'BGCOLOUR' => $bgColor,
            'ID' => $row['id'],
            'PIC_URL' => $row['pict_url'],
            'TITLE' => $row['title'],
            'BNIMG' => ($row['bn_only'] == 'n') ? 'buy_it_now.gif' : 'bn_only.png',
            'BNVALUE' => $row['buy_now'],
            'BNFORMAT' => $system->print_money($row['buy_now']),
            'BIDVALUE' => $row['minimum_bid'],
            'BIDFORMAT' => $system->print_money($row['minimum_bid']),
            'RESERVE' => ($row['reserve_price'] > 0) ? '<img src="images/r.gif" alt="reserve set">' : '',
            'NUM_BIDS' => $num_bids,
            'TIMELEFT' => FormatTimeLeft($difference),

            'B_BUY_NOW' => ($row['buy_now'] > 0 && ($row['current_bid'] == 0 || ($row['reserve_price'] > 0 && $row['current_bid'] < $row['reserve_price'])))
            ));

    $auctions_count++;
}

if ($auctions_count == 0) {
    $template->assign_block_vars('no_auctions', array());
}

/* get this user's nick */
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = $user_id";
$result = mysql_query ($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
if (mysql_num_rows($result) > 0)
    $TPL_user_nick = mysql_result($result, 0, 'nick');
else
    $TPL_user_nick = "";

$LOW = $PAGE - 5;
if ($LOW <= 0) $LOW = 1;
$COUNTER = $LOW;
$pagenation = '';
while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6)) {
    if ($PAGE == $COUNTER) {
        $pagenation .= "<b>$COUNTER</b>&nbsp;&nbsp;";
    } else {
        $pagenation .= '<a href="active_auctions.php?PAGE=' . $COUNTER . '&user_id=' . $user_id . '"><u>' . $COUNTER . '</u></a>&nbsp;&nbsp;';
    }
    $COUNTER++;
}

$template->assign_vars(array(
        'B_MULPAG' => ($PAGES > 1),
        'B_NOTLAST' => ($PAGE < $PAGES),
        'B_NOTFIRST' => ($PAGE > 1),

		'USER_RSSFEED' => sprintf($MSG['932'], $TPL_user_nick),
        'USER_ID' => $user_id,
        'USERNAME' => $TPL_user_nick,
        'THUMBWIDTH' => $system->SETTINGS['thumb_show'],
        'NEXT' => intval($PAGE + 1),
        'PREV' => intval($PAGE - 1),
        'PAGE' => $PAGE,
        'PAGES' => $PAGES,
        'PAGENA' => $pagenation
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'auctions_active.html'
        ));
$template->display('body');
include "footer.php";

?>