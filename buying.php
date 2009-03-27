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

// If user is not logged in redirect to login page
if (!$user->logged_in) {
    header("Location: user_login.php");
    exit;
}

// Get closed auctions with winners
$query = "SELECT a.auction, a.seller, a.winner, a.feedback_sel, a.bid, b.id, b.current_bid, b.title, b.ends, a.qty, u.nick, u.email, b.shipping_cost
		FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.seller)
		WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0 AND a.winner = " . $user->user_data['id'] . "
		GROUP BY b.id ORDER BY a.closingdate DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_id = $user->user_data['id'];
$sslurl = ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y') ? str_replace('http://', 'https://', $system->SETTINGS['siteurl']) : $system->SETTINGS['siteurl'];
while ($row = mysql_fetch_array($res)) {
    $template->assign_block_vars('items', array(
            'ID' => $row['id'],
            'TITLE' => $row['title'],
            'ENDS' => FormatDate($row['ends']),
            'BID' => $row['current_bid'],
            'FBID' => $system->print_money($row['current_bid']),
            'BIDS' => $row['num_bids'],
            'QTY' => ($row['qty'] > 0) ? $row['qty'] : 1,
            'TOTAL' => ($row['qty'] > 1) ? $system->print_money($row['current_bid'] * $row['qty'] + $row['shipping_cost']) : $system->print_money($row['current_bid'] + $row['shipping_cost']),

            'SELLNICK' => $row['nick'],
            'SELLEMAIL' => $row['email'],
            'FB_LINK' => ($row['feedback_sel'] == 0) ? '<a href="' . $sslurl . 'feedback.php?auction_id=' . $row['id'] . '&wid=' . $row['winner'] . '&sid=' . $row['seller'] . '&ws=s">' . $MSG['207'] . '</a>' : ''
            ));
}

require("header.php");
$TMP_usmenutitle = $MSG['454'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'buying.html'
        ));
$template->display('body');
include "footer.php";
?>