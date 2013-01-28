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
include $include_path . 'functions_invoices.php';

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	header('location: user_login.php');
	exit;
}

$sender = getSeller($user->user_data['id']);
$query = "SELECT w.id, w.winner, w.closingdate, a.id AS auc_id, a.title, w.qty,	w.seller As uid 
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
		WHERE a.id = " . intval($_POST['pfval']) . " AND w.id =". intval($_POST['pfwon']) ;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

// check its real
if (mysql_num_rows($res) < 1)
{
	invaildinvoice(true);
}

$data = mysql_fetch_assoc($res);
$winner = getAddresswinner($data['winner']);

// build winners address
$winner_address = '';
$winner_address .= (!empty($winner['address'])) ? '<br>' . $winner['address'] : '';
$winner_address .= (!empty($winner['city'])) ? '<br>' . $winner['city'] : '';
$winner_address .= (!empty($winner['prov'])) ? '<br>' . $winner['prov'] : '';
$winner_address .= (!empty($winner['country'])) ? '<br>' . $winner['country'] : '';
$winner_address .= (!empty($winner['zip'])) ? '<br>' . $winner['zip'] : '';

$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];

$template->assign_vars(array(
		'DOCDIR' => $DOCDIR,
		'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
		'CHARSET' => $CHARSET,
		'LANGUAGE' => $language,
		'SENDER' => $sender['nick'],
		'WINNER_NICK' => $winner['nick'],
		'WINNER_ADDRESS' => $winner_address,
		'AUCTION_TITLE' => strtoupper($title),
		'AUCTION_ID' => $data['auc_id'],
		'SHIPPING_METHOD' => "N/A", // NEEEDS FIXING
		'PAYMENT_METHOD' => "N/A", // NEEEDS FIXING
		'CLOSING_DATE' => ArrangeDateNoCorrection($data['closingdate']),
		'PAYMENT' => $data['payment'],
		'ITEM_QUANTITY' => $data['qty'],
		'B_INVOICE' => true
		));

$template->set_filenames(array(
		'body' => 'order_packingslip.tpl'
		));
$template->display('body');
?>
