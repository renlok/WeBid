<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
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
		WHERE paid = 0 AND winner = :winner_id";
$params = array();
$params[] = array(':winner_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$TOTALAUCTIONS = $db->result('COUNT');
$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);

$query = "SELECT w.id, w.winner, w.auc_title, w.auc_shipping_cost, a.shipping_cost, w.bid, w.qty, w.auction As auc_id, a.additional_shipping_cost, a.shipping FROM " . $DBPrefix . "winners w
		JOIN " . $DBPrefix . "auctions a ON (a.id = w.auction)
		WHERE w.paid = 0 AND w.winner = :user_id
		LIMIT :OFFSET, :per_page";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':OFFSET', $OFFSET, 'int');
$params[] = array(':per_page', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

while ($row = $db->fetch())
{
	$shipping_data = calculate_shipping_data($row, $row['qty'], false);
	$template->assign_block_vars('to_pay', array(
			'ID' => $row['id'],
			'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['auc_id'],
			'TITLE' => htmlspecialchars($row['auc_title']),
			'PAY_SHIPPING' => ($row['shipping'] == 1),
			'SHIPPING' => $system->print_money($shipping_data['shipping_cost']),
			'ADDITIONAL_SHIPPING_COST' => $system->print_money($shipping_data['additional_shipping_cost']),
			'TOTAL_SHIPPING_COST' => $system->print_money($shipping_data['shipping_total']),
			'ADDITIONAL_SHIPPING' => $system->print_money($row['additional_shipping_cost']),
			'ADDITIONAL_SHIPPING_PLAIN' => $row['additional_shipping_cost'],
			'ADDITIONAL_SHIPPING_QUANTITYS' => $row['qty'] - 1,
			'QUANTITY' => $row['qty'],
			'BID' => $system->print_money($row['bid'] * $row['qty']),
			'TOTAL' => $system->print_money(($row['bid'] * $row['qty']) + $shipping_data['shipping_total']),
			'AUC_ID' => $row['auc_id'],
			'WINID'=> $row['id'],

			'B_NOTITLE' => (empty($row['auc_title']))
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

$query = "SELECT balance FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$user_balance = $db->result('balance');

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
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'outstanding.tpl'
		));
$template->display('body');
include 'footer.php';
