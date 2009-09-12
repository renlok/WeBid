<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'includes/common.inc.php';

// If user is not logged in redirect to login page
if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'outstanding.php';
	header('location: user_login.php');
	exit;
}

$query = "SELECT a.id, a.title, a.shipping_cost, w.bid FROM " . $DBPrefix . "winners w
		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = w.auction)
		WHERE w.paid = 0 AND w.winner = " . $user->user_data['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('to_pay', array(
			'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['id'],
			'TITLE' => $row['title'],
			'SHIPPING' => $system->print_money($row['shipping_cost']),
			'BID' => $system->print_money($row['bid']),
			'TOTAL' => $system->print_money($row['shipping_cost'] + $row['bid']),
			'ID' => $row['id']
			));
}

$query = "SELECT balance FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_balance = mysql_result($res, 0);

$template->assign_vars(array(
		'USER_BALANCE' => $system->print_money($user_balance),
		'PAY_BALANCE' => $system->print_money_nosymbol(($user_balance < 0) ? 0 - $user_balance : 0),
		'CURRENCY' => $system->SETTINGS['currency']
		));

include 'header.php';
$TMP_usmenutitle = $MSG['453'];
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'outstanding.tpl'
		));
$template->display('body');
include 'footer.php';
?>
