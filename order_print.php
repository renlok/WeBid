<?php 
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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

// first chanck if from admin
if (!(isset($_GET['hash']) && $_SESSION['INVOICE_RETURN'] == 'admin/invoice.php' && $_GET['hash'] == $_SESSION['WEBID_ADMIN_NUMBER']))
{
	// If user is not logged in redirect to login page
	if (!$user->is_logged_in())
	{
		header('location: user_login.php');
		exit;
	}
}

// is this an auction invoice or fee invoice
$auction = false;
if (isset($_POST['pfval']) && isset($_POST['pfwon']))
{
	$auction = true;
	// check input data
	if (intval($_POST['pfval']) == 0 || intval($_POST['pfwon']) == 0)
	{
		invalidinvoice();
	}
}
else
{
	// check input data
	if (intval($_GET['id']) == 0 || !isset($_GET['id']))
	{
		invalidinvoice();
	}
}

$vat = 20; // NEEDS TO BE SET TO AN ADMIN OPTION
if ($auction)
{
	// get auction data
	$query = "SELECT w.id, w.winner, w.closingdate As date, a.id AS auc_id, a.title, a.shipping_cost, a.shipping_cost_additional, a.shipping, a.shipping_terms, w.bid, w.qty, a.user As seller_id, a.tax, a.taxinc
			FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
			WHERE a.id = :auc_id AND w.id = :winner_id";
	$params = array();
	$params[] = array(':auc_id', $_POST['pfval'], 'int');
	$params[] = array(':winner_id', $_POST['pfwon'], 'int');
	$db->query($query, $params);
}
else
{
	// get fee data
	$query = "SELECT * FROM " . $DBPrefix . "useraccounts WHERE useracc_id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_GET['id'], 'int');
	$db->query($query, $params);
}

// check its real
if ($db->numrows() < 1)
{
	invalidinvoice();
}

$data = $db->fetch();

if ($auction)
{
	// sort out auction data
	$seller = getSeller($data['seller_id']);
	$winner = getAddressWinner($data['winner']);
	$vat = getTax(true, $winner['country'], $seller['country']);
	$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];
	$additional_shipping = $data['shipping_cost_additional'] * ($data['qty'] - 1);
	$shipping_cost = ($data['shipping'] == 1) ? ($data['shipping_cost'] + $additional_shipping) : 0;
	$paysubtotal = ($data['bid']* $data['qty']);
	$payvalue = $paysubtotal + $shipping_cost;

	// build winners address
	$winner_address = '';
	$winner_address .= (!empty($winner['address'])) ? '<br>' . $winner['address'] : '';
	$winner_address .= (!empty($winner['city'])) ? '<br>' . $winner['city'] : '';
	$winner_address .= (!empty($winner['prov'])) ? '<br>' . $winner['prov'] : '';
	$winner_address .= (!empty($winner['country'])) ? '<br>' . $winner['country'] : '';
	$winner_address .= (!empty($winner['zip'])) ? '<br>' . $winner['zip'] : '';

	if ($data['tax'] == 'n') // no tax
	{
		$unitexcl = $unitpriceincl = $paysubtotal;
		$subtotal = $totalinc = $payvalue;
		$vat = 0;
	}
	else
	{
		if ($data['taxinc'] == 'y') // tax is included in price
		{
			$unitexcl = vatexcluding($paysubtotal); // auction price - tax
			$unitpriceincl = $paysubtotal; // auction price & tax
			$subtotal = vatexcluding($payvalue); // total invoice - tax
			$totalinc = $payvalue; // total invoice & tax
		}
		else
		{
			$unitexcl = $paysubtotal; // auction price - tax
			$unitpriceincl = vat($paysubtotal); // auction price & tax
			$subtotal = $payvalue; // total invoice - tax
			$totalinc = vat($payvalue); // total invoice & tax
		}
	}

	$totalvat = $totalinc - $subtotal;
	$unitpriceincl = $totalinc / $data['qty'];
	$unitexcl = $subtotal / $data['qty'];

	// auction specific details
	$template->assign_vars(array(
			'AUCTION_TITLE' => strtoupper($title),
			'ITEM_QUANTITY' => $data['qty'],

			'UNIT_PRICE' => $system->print_money($unitexcl, true, false), // auction price
			'UNIT_PRICE_WITH_TAX' => $system->print_money($unitpriceincl, true, false),// auction price & tax
			'TOTAL' => $system->print_money($subtotal, true, false), // total invoice
			'TOTAL_WITH_TAX' => $system->print_money($totalinc, true, false) // total invoice & tax
			));
}
else
{
	$seller = getSeller($user->user_data['id']); // used as user: ??
	$vat = getTax(true, $seller['country']);
	$winner_address = '';
	$data['shipping_terms'] = '';
	$shipping_cost = 0;
	$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['766'] . '#' . $data['id'];
	$payvalue = $data['total'];
	// create fee data ready for template & get totals
	$totals = setfeetemplate($data);

	// fee specific details
	$template->assign_vars(array(
			'TOTAL' => $system->print_money($totals[1], true, false),
			'TOTAL_WITH_TAX' => $system->print_money($totals[0], true, false)
			));
}

$template->assign_vars(array(
		'DOCDIR' => $DOCDIR,
		'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
		'CHARSET' => $CHARSET,
		'LANGUAGE' => $language,
		'SENDER' => $seller['nick'],
		'WINNER_NICK' => $winner['nick'],
		'WINNER_ADDRESS' => $winner_address,
		'AUCTION_ID' => $data['auc_id'],
		'SHIPPING_METHOD' => (empty($data['shipping_terms'])) ? strtoupper($MSG['000']) : $data['shipping_terms'],
		'INVOICE_DATE' => gmdate('d/m/Y', $data['date'] + $system->tdiff),
		'SALE_ID' => (($auction) ? 'AUC' : 'FEE') . $data['id'],
		// tax start
		'TAX' => $vat . '%',
		'SHIPPING_COST' => $system->print_money($shipping_cost, true, false),
		'VAT_TOTAL' => $system->print_money($totalvat, true, false),
		'TOTAL_SUM' => $system->print_money($payvalue, true, false),
		// tax end
		'YELLOW_LINE' => $system->SETTINGS['invoice_yellow_line'],
		'THANKYOU' => $system->SETTINGS['invoice_thankyou'],

		'B_INVOICE' => true,
		'B_IS_AUCTION' => $auction
		));

$template->set_filenames(array(
		'body' => 'order_invoice.tpl'
		));
$template->display('body');
?>
