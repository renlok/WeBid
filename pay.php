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
if (!$user->checkAuth() && $_GET['a'] != 3)
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	header('location: user_login.php');
	exit;
}

$fees = new fees;

$paying_fee = true;
switch($_GET['a'])
{
	case 1: // add to account balance
		$payvalue = $system->input_money($_POST['pfval']);
		$custoncode = $user->user_data['id'] . 'WEBID1';
		$message = sprintf($MSG['582'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['935'];
		$fees->add_to_account($MSG['935'], 'balance', $payvalue);
		break;
	case 2: // pay for an item
		$query = "SELECT w.id, w.seller, a.title, a.shipping_cost, a.additional_shipping_cost, a.shipping, w.bid,
				u.id As uid, u.nick, a.payment, w.qty
				FROM " . $DBPrefix . "winners w
				LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = w.auction)
				LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)
				WHERE w.id = :pfval AND w.winner = :user_id";
		$params = array();
		$params[] = array(':pfval', $_POST['pfval'], 'int');
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$db->query($query, $params);

		// check its real
		if ($db->numrows() < 1)
		{
			header('location: outstanding.php');
			exit;
		}
		$data = $db->result();

		$payment = explode(', ', $data['payment']);
		$query = "SELECT * FROM " . $DBPrefix . "payment_options po LEFT JOIN " . $DBPrefix . "usergateways ug ON (po.id = ug.gateway_id AND ug.user_id = :user_id) WHERE po.is_gateway = 1";
		$params = array();
		$params[] = array(':user_id', $data['seller'], 'int');
		$db->query($query, $params);
		$user_gateways = array();
		while ($gateway = $db->fetch())
		{
			$user_gateways[$gateway['name']] = $gateway;
		}

		$extrastring = sprintf($MSG['778'], $data['uid'], $_POST['pfval'], $data['nick']);
		$additional_shipping = $data['additional_shipping_cost'] * ($data['qty'] - 1);
		$shipping_cost = ($data['shipping'] == 1) ? ($data['shipping_cost'] + $additional_shipping) : 0;
		$payvalue = ($data['bid'] * $data['qty']) + $shipping_cost;
		$custoncode = $data['id'] . 'WEBID2';
		$message = sprintf($MSG['581'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . htmlspecialchars($data['title']);
		$paying_fee = false;
		break;
	case 3: // pay signup fee (live mode)
		if (!isset($_SESSION['signup_id']) || !is_int($_SESSION['signup_id']) || $_SESSION['signup_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'signup_fee'";
		$db->direct_query($query);
		$payvalue = $db->result('value');
		$custoncode = $_SESSION['signup_id'] . 'WEBID3';
		$message = sprintf($MSG['583'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['430'];
		$fees->add_to_account($MSG['768'], 'signup_fee', $payvalue);
		break;
	case 4: // pay auction fee (live mode)
		if (isset($_GET['auction_id']))
		{
			$_SESSION['auction_id'] = intval($_GET['auction_id']);
		}
		if (!isset($_SESSION['auction_id']) || $_SESSION['auction_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}
		$query = "SELECT total, useracc_id FROM " . $DBPrefix . "useraccounts WHERE auc_id = :auc_id AND user_id = :user_id";
		$params = array();
		$params[] = array(':auc_id', $_SESSION['auction_id'], 'int');
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$db->query($query, $params);
		$payvalue = $db->result('total');
		$invoice_id = $db->result('useracc_id');
		$custoncode = $invoice_id . 'WEBID4';
		$message = sprintf($MSG['590'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['432'];
		$fees->add_to_account($MSG['432'], 'setup', $payvalue);
		break;
	case 5: // pay relist fee (live mode)
		// number of auctions to relist
		$query = "SELECT COUNT(*) As COUNT FROM " . $DBPrefix . "auctions WHERE suspended = 8 AND user = :user_id";
		$params = array();
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$db->query($query, $params);
		$count = $db->result('COUNT');

		// get relist fee
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'relist_fee'";
		$db->direct_query($query);
		$relist_fee = $db->result('value');
		$payvalue = $relist_fee * $count;
		$custoncode = $user->user_data['id'] . 'WEBID5';
		$message = sprintf($MSG['591'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['437'];
		$fees->add_to_account($MSG['437'], 'relist_fee', $payvalue);
		break;
	case 6: // pay buyer fee (live mode)
		if (isset($_GET['auction_id']))
		{
			$_SESSION['auction_id'] = intval($_GET['auction_id']);
		}
		if (!isset($_SESSION['auction_id']) || $_SESSION['auction_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}
		$query = "SELECT current_bid FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $user->user_data['id'], 'int');
		$db->query($query, $params);
		$final_value = $db->result('current_bid');

		$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = 'buyer_fee'";
		$db->direct_query($query);
		$fee_data = $db->result();
		if ($fee_data['fee_type'] == 'flat')
		{
			$fee_value = $fee_data['value'];
		}
		else
		{
			$fee_value = ($fee_data['value'] / 100) * floatval($final_value);
		}
		$custoncode = $_SESSION['auction_id'] . 'WEBID6';
		$message = sprintf($MSG['776'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['775'];
		$fees->add_to_account($MSG['775'], 'buyer_fee', $payvalue);
		break;
	case 7: // pay final value fee (live mode)
		if (isset($_GET['auction_id']))
		{
			$_SESSION['auction_id'] = intval($_GET['auction_id']);
		}
		if (!isset($_SESSION['auction_id']) || $_SESSION['auction_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}

		// get final sell price
		$query = "SELECT current_bid FROM " . $DBPrefix . "auctions WHERE user = :user_id AND id = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $_SESSION['auction_id'], 'int');
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$db->query($query, $params);
		$final_value = $db->result('current_bid');

		$query = "SELECT * FROM " . $DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
		$db->direct_query($query);
		while ($row = $db->fetch())
		{
			if ($final_value > $row['fee_from'] && $final_value < $row['fee_to'])
			{
				if ($row['fee_type'] == 'flat')
				{
					$payvalue = $row['value'];
				}
				else
				{
					$payvalue = ($row['value'] / 100) * $final_value;
				}
			}
		}
		$custoncode = $_SESSION['auction_id'] . 'WEBID7';
		$message = sprintf($MSG['776'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['791'];
		$fees->add_to_account($MSG['791'], 'endauc_fee', $payvalue);
		break;
}

// load the payment gateways
$query = "SELECT * FROM " . $DBPrefix . "payment_options WHERE is_gateway = 1";
$db->direct_query($query);
$sequence = rand(1, 1000);
$timestamp = time();
$pay_val = $system->input_money($system->print_money_nosymbol($payvalue));

while ($gateway = $db->fetch())
{
	$address = ($paying_fee) ? $gateway['gateway_admin_address'] : $user_gateways[$gateway['name']]['address'];
	$password = ($paying_fee) ? $gateway['gateway_admin_password'] : $user_gateways[$gateway['name']]['password'];

	$template->assign_block_vars('gateways', array(
		'B_ACTIVE' => ($paying_fee) ? $gateway['gateway_active'] : (in_array($gateway['name'], $payment) && isset($user_gateways[$gateway['name']])),
		'NAME' => $gateway['name'],
		'DISPLAY_NAME' => $gateway['displayname'],

		'PAY_ADDRESS' => ($paying_fee) ? $gateway['gateway_admin_address'] : $user_gateways[$gateway['name']]['address'],
		'PAY_PASSWORD' => ($paying_fee) ? $gateway['gateway_admin_password'] : $user_gateways[$gateway['name']]['password'],

		// TODO: need a better way to deal with these
		'AN_SEQUENCE' => $sequence,
		'AN_KEY' => ($gateway['name'] == 'authnet') ? $fees->hmac($password, $address . "^" . $sequence . "^" . $timestamp . "^" . $pay_val . "^" . $system->SETTINGS['currency']) : '',
		));
}

$template->assign_vars(array(
		'TOP_MESSAGE' => $message,
		'SANDBOX' => $system->SETTINGS['payment_gateway_sandbox'],
		// item values
		'PAY_VAL' => $pay_val,
		'CURRENCY' => $system->SETTINGS['currency'],
		'TITLE' => $title,
		'CUSTOM_CODE' => $custoncode,
		'TIMESTAMP' => $timestamp,
		'NO_ONLINE_GATEWAYS' => ($db->numrows() < 1),
		'TOUSER_STRING' => (isset($extrastring)) ? $extrastring : '',
		'B_TOUSER' => ($_GET['a'] == 2)
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'pay.tpl'
		));
$template->display('body');
include 'footer.php';
