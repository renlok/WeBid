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
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'outstanding.php';
	header('location: user_login.php');
	exit;
}

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1)
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "winners
		WHERE paid = 0 AND winner = " . $user->user_data['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$TOTALAUCTIONS = mysql_result($res, 0, 'COUNT');
$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);

$query = "SELECT w.auction As id, w.id As winid, a.title, a.shipping_cost, w.bid, w.qty, a.shipping_cost_additional FROM " . $DBPrefix . "winners w
		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = w.auction)
		WHERE w.paid = 0 AND w.winner = " . $user->user_data['id'] . "
		LIMIT " . intval($OFFSET) . "," . $system->SETTINGS['perpage'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('to_pay', array(
			'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['id'],
			'TITLE' => $row['title'],
			'SHIPPING' => ($row['shipping'] == 2) ? $system->print_money($row['shipping_cost']) : $system->print_money(0),
			'ADDITIONAL_SHIPPING_COST' => $system->print_money($row['additional_shipping_cost'] * ($row['qty'] - 1)),
			'ADDITIONAL_SHIPPING' => $system->print_money($row['additional_shipping_cost']),
			'ADDITIONAL_SHIPPING_QUANTITYS' => $row['qty'] - 1,
			'QUANTITY' => $row['qty'],
			'BID' => $system->print_money($row['bid'] * $row['qty']),
			'TOTAL' => $system->print_money($row['shipping_cost'] + ($row['bid'] * $row['qty']) + ($row['additional_shipping_cost'] * ($row['qty'] - 1))),
			'ID' => $row['id'],
			'WINID'=> $row['winid'],

			'B_NOTITLE' => (empty($row['title']))
			));
}

// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$query = "SELECT balance FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_balance = mysql_result($res, 0);

$_SESSION['INVOICE_RETURN'] = 'outstanding.php';
$template->assign_vars(array(
		'USER_BALANCE' => $system->print_money($user_balance),
		'PAY_BALANCE' => $system->print_money_nosymbol(($user_balance < 0) ? 0 - $user_balance : 0),
		'CURRENCY' => $system->SETTINGS['currency'],

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

include 'header.php';
$TMP_usmenutitle = $MSG['422'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'outstanding.tpl'
		));
$template->display('body');
include 'footer.php';
?>
