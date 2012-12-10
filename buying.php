<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'common.php';

// If user is not logged in redirect to login page
if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'buying.php';
	header('location: user_login.php');
	exit;
}

// Get closed auctions with winners
$query = "SELECT DISTINCT a.qty, a.seller, a.paid, a.feedback_win, a.bid, a.auction, b.title, b.ends, b.shipping_cost, b.shipping, u.nick, u.email
		FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.seller)
		WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0
		AND a.winner = " . $user->user_data['id'] . " ORDER BY a.closingdate DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$sslurl = ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y') ? str_replace('http://', 'https://', $system->SETTINGS['siteurl']) : $system->SETTINGS['siteurl'];
$sslurl = ($system->SETTINGS['usersauth'] == 'y' && !empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;

while ($row = mysql_fetch_assoc($res))
{
	$totalcost = ($row['qty'] > 1) ? ($row['bid'] * $row['qty']) : $row['bid'];
	$totalcost = ($row['shipping'] == 2) ? $totalcost : ($totalcost + $row['shipping_cost']);

	$template->assign_block_vars('items', array(
			'AUC_ID' => $row['auction'],
			'TITLE' => $row['title'],
			'ENDS' => FormatDate($row['ends']),
			'BID' => $row['bid'],
			'FBID' => $system->print_money($row['bid']),
			'QTY' => ($row['qty'] > 0) ? $row['qty'] : 1,
			'TOTAL' => $system->print_money($totalcost),
			'B_PAID' => ($row['paid'] == 1),

			'SELLNICK' => $row['nick'],
			'SELLEMAIL' => $row['email'],
			'FB_LINK' => ($row['feedback_win'] == 0) ? '<a href="' . $sslurl . 'feedback.php?auction_id=' . $row['auction'] . '&wid=' . $user->user_data['id'] . '&sid=' . $row['seller'] . '&ws=w">' . $MSG['207'] . '</a>' : ''
			));
}

include 'header.php';
$TMP_usmenutitle = $MSG['454'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'buying.tpl'
		));
$template->display('body');
include 'footer.php';
?>