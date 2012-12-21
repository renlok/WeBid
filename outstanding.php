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

$query = "SELECT w.auction As id, w.id As winid, a.title, a.shipping_cost, w.bid, w.qty FROM " . $DBPrefix . "winners w
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
			'SHIPPING' => $system->print_money($row['shipping_cost']),
			'BID' => $system->print_money($row['bid'] * $row['qty']),
			'TOTAL' => $system->print_money($row['shipping_cost'] + ($row['bid'] * $row['qty'])),
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

$query = "SELECT a.id, a.auc_id, a.date, a.setup, a.featured, a.bold, a.highlighted, a.subtitle, a.relist, a.reserve, a.buynow, a.image, a.extcat, a.total, u.paid
	FROM " . $DBPrefix . "useraccounts a
    LEFT JOIN " . $DBPrefix . "userfees u ON (u.auc_id = a.auc_id)
    WHERE a.user_id = " . $user->user_data['id'];
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);

while ($row = mysql_fetch_assoc($res_))
{
	$DATE = $row['date'] + $system->tdiff;
	if ($row['paid'] == 0)
	{
		$paid = "NOT PAID";
		$tick = "<img src='images/niezap.png'>";
	}
	if ($row['paid'] == 1)
	{
		$paid = "PAID";
		$tick = "<img src='images/zaplac.png'>";
	}

	$template->assign_block_vars('topay', array(
	'INVOICE' => $row['id'],
	'ID' => $row['auc_id'],
	'DATE' => ArrangeDateNoCorrection($DATE),
	'FEE_SETUP' => ($row['setup'] == 0) ? ' - ' : $system->print_money($row['setup']),
	'FEE_FEATURED' => ($row['featured'] == 0) ? ' - ' : $system->print_money($row['featured']),
	'FEE_BOLD_ITEM' => ($row['bold'] == 0) ? ' - ' : $system->print_money($row['bold']),
	'FEE_HIGHLITED' => ($row['highlighted'] == 0) ? ' - ' : $system->print_money($row['highlighted']),
	'FEE_SUBTITLE' => ($row['subtitle'] == 0) ? ' - ' : $system->print_money($row['subtitle']),
	'RELIST_TOTAL' => ($row['relist'] == 0) ? ' - ' : $system->print_money($row['relist']),
	'FEE_RP' => ($row['reserve'] == 0) ? ' - ' : $system->print_money($row['reserve']),
	'FEE_BN' => ($row['buynow'] == 0) ? ' - ' : $system->print_money($row['buynow']),
	'PIC_TOTAL' => ($row['image'] == 0) ? ' - ' : $system->print_money($row['image']),
	'EXTRA_CAT_FEE' => ($row['extcat'] == 0) ? ' - ' : $system->print_money($row['extcat']),
	'FEE_VALUE_F' => $system->print_money($row['total']),
	'PAID' => $paid,
	'TICK' => $tick,
	'PDF' => $system->SETTINGS['siteurl'] . 'item_invoice.php?id=' . $row['auc_id'],
	));
}

$query = "SELECT balance FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_balance = mysql_result($res, 0);

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
