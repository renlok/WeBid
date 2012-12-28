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
include $include_path . 'membertypes.inc.php';

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	header('location: user_login.php');
	exit;
}

function getSeller($user_id)
{
	global $system, $DBPrefix;

	$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = " . $user_id;
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$seller_nick = mysql_result($result, 0);

	return $seller_nick;
}	
function getAddressWinner($user_id)
{
	global $system, $DBPrefix;

	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = '" . (int)$user_id . "'";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$result = mysql_fetch_array($result);
	$address_data = array(
		//'user_id'   => $result['id'],
		'nick'      => $result['nick'],
		'name'      => $result['name'],
		'company'   => (isset($result['company'])) ? $result['company'] : '',
		'address'   => $result['address'],
		'city'      => $result['city'],
		'prov'      => $result['prov'],
		'postcode'  => $result['zip'],
		'country'   => $result['country'],
		//'email'     => $result['email'],
	);
	return $address_data;
}

$query = "SELECT w.id, w.winner, w.closingdate, a.id AS auctid, a.title, a.subtitle, a.shipping_cost, a.shipping, w.bid, w.qty,	u.id As seller_id, u.rate_sum 
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)
		WHERE a.id = " . intval($_POST['pfval']) . " AND w.id = " . intval($_POST['pfwon']) ;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

// check its real
if (mysql_num_rows($res) < 1)
{
	if (isset($_SESSION['INVOICE_RETURN']))
	{
		header('location: ' . $_SESSION['INVOICE_RETURN']);
	}
	else
	{
		header('location: invoices.php');
	}
	exit;
}

$data = mysql_fetch_assoc($res);
$seller = getSeller($data['seller_id']);
$winner = getAddressWinner($data['winner']);
$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];
$payvalue = ($data['shipping'] == 1) ? $data['shipping_cost'] + ($data['bid']* $data['qty']) : ($data['bid']* $data['qty']);
$payvalueperitem = $data['bid'];
$paysubtotal = ($data['bid']* $data['qty']);
$shipping_cost = ($data['shipping'] == 1) ? $data['shipping_cost'] : '0';
//-----------rating	start	
foreach ($membertypes as $idm => $memtypearr)
{$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;}
ksort($memtypesarr, SORT_NUMERIC);
$TPL_rate_ratio_value = '';
	foreach ($memtypesarr as $k => $l)
	{
		if ($k >= $data['rate_sum'] || $l++ == (count($memtypesarr) - 1))
		{
			$TPL_rate_ratio_value = "images/icons/" . $l['icon'] ."";
			break;
		}
	} 
//------------rating end	

$vat = 20; // NEEDS TO BE SET TO AN ADMIN OPTION
function vat($price)
{
	global $system, $vat;
    $price_with_vat = $price + ($vat * ($price / 100));
    $price_with_vat = round($price_with_vat, $system->SETTINGS['moneydecimals']);
    return $price_with_vat;
}

function vatexcluding($gross)
{
	global $system, $vat;
	$multiplier = ($vat + 100) / 100;
	$net = $gross / $multiplier;
	return number_format($net, $system->SETTINGS['moneydecimals']);
}

$data['shippingtaxable'] = 'n'; // NEEDS TO BE SET TO AN ADMIN OPTION

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

$template->assign_vars(array(
		'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
		'LANGUAGE' => $language,
		'SENDER' => $seller,
		'WINNER' => $winner['nick'],
		'AUCTION_TITLE' => strtoupper($title),
		'AUCTION_ID' => $data['auctid'],
		'RATE_SUM' => $data['rate_sum'],
		'RATE_RATIO' => $TPL_rate_ratio_value,
		'SHIPPING_METHOD' => "N/A", // NEEDS FIXING
		'PAYMENT_METHOD' => "N/A", // NEEDS FIXING
		'SALE_DATE' => "N/A", // NEEDS FIXING
		'SUBTITLE' => $data['subtitle'],
		'CLOSING_DATE' => ArrangeDateNoCorrection($data['closingdate']),
		'INVOICE_DATE' => gmdate('d/m/Y', $data['closingdate'] + $system->tdiff),
		'ITEM_QUANTITY' => $data['qty'],
		'SALE_ID' => $data['id'],
		'BIDSINGLE' => $system->print_money($data['bid']),
		// tax start
		'TAX' => "20%",    
		'UNIT_PRICE' => $system->print_money($unitexcl),
		'UNIT_PRICE_WITH_TAX' => $system->print_money($unitpriceincl),
		'TOTAL' => $system->print_money($subtotal),
		'TOTAL_WITH_TAX' => $system->print_money($totalinc),
		'SHIPPING_COST' => $system->print_money($shipping_cost),
		'VAT_TOTAL' => $system->print_money($totalvat),
		'TOTAL_SUM' => $system->print_money($payvalue),
		// tax end
		'ORDERS' => 1,   //can link to an if statment or something to show else part in html
));

$template->set_filenames(array(
		'body' => 'order_invoice.tpl'
		));
$template->display('body');
?>
