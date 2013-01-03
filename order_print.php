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

// is this an auction invoice or fee invoice
$auction = false;
if (isset($_POST['pfval']) && isset($_POST['pfwon']))
{
	$auction = true;
	// check input data
	if (intval($_POST['pfval']) == 0 || intval($_POST['pfwon']) == 0)
	{
		invaildinvoice();
	}
}
else
{
	// check input data
	if (intval($_GET['id']) == 0 || !isset($_GET['id']))
	{
		invaildinvoice();
	}
}

if ($auction)
{
	// get auction data
	$query = "SELECT w.id, w.winner, w.closingdate As date, a.id AS auc_id, a.title, a.shipping_cost, a.shipping, w.bid, w.qty,	a.user As seller_id
			FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
			WHERE a.id = " . intval($_POST['pfval']) . " AND w.id = " . intval($_POST['pfwon']);
}
else
{
	// get fee data
	$query = "SELECT * FROM " . $DBPrefix . "useraccounts WHERE id = " . intval($_GET['id']);
}
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

// check its real
if (mysql_num_rows($res) < 1)
{
	invaildinvoice();
}

$data = mysql_fetch_assoc($res);

if ($auction)
{
	// sort out auction data
	$seller = getSeller($data['seller_id']);
	$winner = getAddressWinner($data['winner']);
	$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];
	$payvalue = ($data['shipping'] == 1) ? $data['shipping_cost'] + ($data['bid'] * $data['qty']) : ($data['bid']* $data['qty']);
	$payvalueperitem = $data['bid'];
	$paysubtotal = ($data['bid']* $data['qty']);
	$shipping_cost = ($data['shipping'] == 1) ? $data['shipping_cost'] : 0;

	// build winners address
	$winner_address = '';
	$winner_address .= (!empty($winner['address'])) ? '<br>' . $winner['address'] : '';
	$winner_address .= (!empty($winner['city'])) ? '<br>' . $winner['city'] : '';
	$winner_address .= (!empty($winner['prov'])) ? '<br>' . $winner['prov'] : '';
	$winner_address .= (!empty($winner['country'])) ? '<br>' . $winner['country'] : '';
	$winner_address .= (!empty($winner['zip'])) ? '<br>' . $winner['zip'] : '';

	$data['shippingtaxable'] = 'n'; // NEEDS TO BE SET TO AN ADMIN OPTION
	// ------------------ NEEDS CLEANING
	if ($data['shippingtaxable'] == 'y')
	{
		$potageinclvat = vat($shipping_cost);
		$postagevat = $potageinclvat - $shipping_cost;
		$postageexclvat = $shipping_cost;
	}
	else
	{
		$potageinclvat = $shipping_cost;
		$postagevat =  0;
	}
	$totalvat = $payvalue / 6;
	$vattotalinc = $totalvat - $postagevat;
	$subtotal = $payvalue - $vattotalinc - $potageinclvat;
	$totalinc = vat($subtotal);
	$unitpriceincl = $totalinc / $data['qty'];
	$unitexcl = $subtotal / $data['qty'];
	// ------------------ NEEDS CLEANING

	// auction specific details
	$template->assign_vars(array(
			'AUCTION_TITLE' => strtoupper($title),
			'ITEM_QUANTITY' => $data['qty'],

			'UNIT_PRICE' => $system->print_money($unitexcl), // auction price
			'UNIT_PRICE_WITH_TAX' => $system->print_money($unitpriceincl),// auction price & tax
			'TOTAL' => $system->print_money($subtotal), // total invoice
			'TOTAL_WITH_TAX' => $system->print_money($totalinc) // total invoice & tax
			));
}
else
{
	$seller = getSeller($user->user_data['id']); // used as user: ??
	$winner_address = '';
	$shipping_cost = 0;
	$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['766'] . '#' . $data['id'];
	$payvalue = $data['total'];
	// create fee data ready for template & get totals
	$totals = setfeetemplate($data);

	// fee specific details
	$template->assign_vars(array(
			'TOTAL' => $system->print_money($totals[1]),
			'TOTAL_WITH_TAX' => $system->print_money($totals[0])
			));
}

$template->assign_vars(array(
		'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
		'LANGUAGE' => $language,
		'SENDER' => $seller,
		'WINNER_NICK' => $winner['nick'],
		'WINNER_ADDRESS' => $winner_address,
		'AUCTION_ID' => $data['auc_id'],
		'SHIPPING_METHOD' => "N/A", // NEEDS FIXING
		'INVOICE_DATE' => gmdate('d/m/Y', $data['date'] + $system->tdiff),
		'SALE_ID' => (($auction) ? 'AUC' : 'FEE') . $data['id'],
		// tax start
		'TAX' => "20%", // NEEDS FIXING
		'SHIPPING_COST' => $system->print_money($shipping_cost),
		'VAT_TOTAL' => $system->print_money($totalvat),
		'TOTAL_SUM' => $system->print_money($payvalue),
		// tax end
		'B_INVOICE' => true,

		'B_IS_AUCTION' => $auction
		));

$template->set_filenames(array(
		'body' => 'order_invoice.tpl'
		));
$template->display('body');
?>
