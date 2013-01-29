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
if (!$user->is_logged_in() && $_GET['a'] != 3)
{
	header('location: user_login.php');
	exit;
}

$query = "SELECT * FROM " . $DBPrefix . "gateways LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$gateway_data = mysql_fetch_assoc($res);

$fees = new fees;

switch($_GET['a'])
{
	case 1: // add to account balance
		$pp_paytoemail = $gateway_data['paypal_address'];
		$an_paytoid = $gateway_data['authnet_address'];
		$an_paytopass = $gateway_data['authnet_password'];
		$wp_paytoid = $gateway_data['worldpay_id'];
		$tc_paytoid = $gateway_data['toocheckout_id'];
		$mb_paytoemail = $gateway_data['moneybookers_address'];
		$payvalue = $system->input_money($_POST['pfval']);
		$custoncode = $user->user_data['id'] . 'WEBID1';
		$message = sprintf($MSG['582'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['935'];
		$fees->add_to_account($MSG['935'], 'balance', $payvalue);
		break;
	case 2: // pay for an item
		$query = "SELECT w.id, a.title, a.shipping_cost, a.shipping_cost_additional, a.shipping, w.bid, u.paypal_email, u.authnet_id, u.authnet_pass,
				u.id As uid, u.nick, a.payment, u.worldpay_id, u.toocheckout_id, u.moneybookers_email, w.qty
				FROM " . $DBPrefix . "auctions a
				LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
				LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)
				WHERE a.id = " . intval($_POST['pfval']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		// check its real
		if (mysql_num_rows($res) < 1)
		{
			header('location: outstanding.php');
			exit;
		}

		$data = mysql_fetch_assoc($res);
		$payment = explode(', ', $data['payment']);
		$pp_paytoemail = (in_array('paypal', $payment)) ? $data['paypal_email'] : '';
		$extrastring = sprintf($MSG['778'], $data['uid'], $data['nick']);
		$an_paytoid = (in_array('authnet', $payment)) ? $data['authnet_id'] : '';
		$an_paytopass = (in_array('authnet', $payment)) ? $data['authnet_pass'] : '';
		$wp_paytoid = (in_array('worldpay', $payment)) ? $data['worldpay_id'] : '';
		$tc_paytoid = (in_array('toocheckout', $payment)) ? $data['toocheckout_id'] : '';
		$mb_paytoemail = (in_array('moneybookers', $payment)) ? $data['moneybookers_email'] : '';
		$additional_shipping = $data['additional_shipping_cost'] * ($data['qty'] - 1);
		$shipping_cost = ($shipping == 1) ? ($data['shipping_cost'] + $additional_shipping) : 0;
		$payvalue = ($data['bid'] * $data['qty']) + $shipping_cost;
		$custoncode = $data['id'] . 'WEBID2';
		$message = sprintf($MSG['581'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];
		break;
	case 3: // pay signup fee (live mode)
		if (!isset($_SESSION['signup_id']) || !is_int($_SESSION['signup_id']) || $_SESSION['signup_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}
		$pp_paytoemail = $gateway_data['paypal_address'];
		$an_paytoid = $gateway_data['authnet_address'];
		$an_paytopass = $gateway_data['authnet_password'];
		$wp_paytoid = $gateway_data['worldpay_id'];
		$tc_paytoid = $gateway_data['toocheckout_id'];
		$mb_paytoemail = $gateway_data['moneybookers_address'];
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'signup_fee'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$payvalue = mysql_result($res, 0);
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
		$pp_paytoemail = $gateway_data['paypal_address'];
		$an_paytoid = $gateway_data['authnet_address'];
		$an_paytopass = $gateway_data['authnet_password'];
		$wp_paytoid = $gateway_data['worldpay_id'];
		$tc_paytoid = $gateway_data['toocheckout_id'];
		$mb_paytoemail = $gateway_data['moneybookers_address'];
		$query = "SELECT total, useracc_id FROM " . $DBPrefix . "useraccounts WHERE auc_id = " . $_SESSION['auction_id'] . " AND user_id = " . $user->user_data['id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$payvalue = mysql_result($res, 0, 'total');
		$invoice_id = mysql_result($res, 0, 'useracc_id');
		$custoncode = $invoice_id . 'WEBID4';
		$message = sprintf($MSG['590'], $system->print_money($payvalue));
		$title = $system->SETTINGS['sitename'] . ' - ' . $MSG['432'];
		$fees->add_to_account($MSG['432'], 'setup', $payvalue);
		break;
	case 5: // pay relist fee (live mode)
		$pp_paytoemail = $gateway_data['paypal_address'];
		$an_paytoid = $gateway_data['authnet_address'];
		$an_paytopass = $gateway_data['authnet_password'];
		$wp_paytoid = $gateway_data['worldpay_id'];
		$tc_paytoid = $gateway_data['toocheckout_id'];
		$mb_paytoemail = $gateway_data['moneybookers_address'];
		// number of auctions to relist
		$query = "SELECT COUNT(*) FROM " . $DBPrefix . "auctions WHERE suspended = 8 AND user = " . $user->user_data['id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$count = mysql_result($res, 0);
		// get relist fee
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'relist_fee'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$relist_fee = mysql_result($res, 0);
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
		$pp_paytoemail = $gateway_data['paypal_address'];
		$an_paytoid = $gateway_data['authnet_address'];
		$an_paytopass = $gateway_data['authnet_password'];
		$wp_paytoid = $gateway_data['worldpay_id'];
		$tc_paytoid = $gateway_data['toocheckout_id'];
		$mb_paytoemail = $gateway_data['moneybookers_address'];
		$query = "SELECT current_bid FROM " . $DBPrefix . "auctions WHERE id = " . $_SESSION['auction_id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$final_value = mysql_result($res, 0);
		$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = 'buyer_fee'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$row = mysql_result($res, 0);
		if ($row['fee_type'] == 'flat')
		{
			$fee_value = $row['value'];
		}
		else
		{
			$fee_value = ($row['value'] / 100) * floatval($final_value);
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
		$pp_paytoemail = $gateway_data['paypal_address'];
		$an_paytoid = $gateway_data['authnet_address'];
		$an_paytopass = $gateway_data['authnet_password'];
		$wp_paytoid = $gateway_data['worldpay_id'];
		$tc_paytoid = $gateway_data['toocheckout_id'];
		$mb_paytoemail = $gateway_data['moneybookers_address'];
		$query = "SELECT current_bid FROM " . $DBPrefix . "auctions WHERE user = " . $user->user_data['id'] . " AND id = " . $_SESSION['auction_id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$final_value = mysql_result($res, 0);
		$query = "SELECT * FROM " . $DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		while ($row = mysql_fetch_assoc($res))
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

$sequence = rand(1, 1000);
$timestamp = time();
$pay_val = $system->input_money($system->print_money_nosymbol($payvalue));
$template->assign_vars(array(
		'TOP_MESSAGE' => $message,
		// enabled gateways
		'B_ENPAYPAL' => ($gateway_data['paypal_active'] == 1 && !empty($pp_paytoemail)),
		'B_ENAUTHNET' => ($gateway_data['authnet_active'] == 1 && !empty($an_paytoid) && !empty($an_paytopass)),
		'B_ENWORLDPAY' => ($gateway_data['worldpay_active'] == 1 && !empty($wp_paytoid)),
		'B_ENTOOCHECK' => ($gateway_data['toocheckout_active'] == 1 && !empty($tc_paytoid)),
		'B_ENMONEYBOOKERS' => ($gateway_data['moneybookers_active'] == 1 && !empty($mb_paytoemail)),
		// paypal
		'PP_PAYTOEMAIL' => $pp_paytoemail,
		// authorize.net
		'AN_PAYTOID' => $an_paytoid,
		'AN_PAYTOPASS' => $an_paytopass,
		'AN_KEY' => ($gateway_data['authnet_active'] == 1) ? $fees->hmac($an_paytopass, $an_paytoid . "^" . $sequence . "^" . $timestamp . "^" . $pay_val . "^" . $system->SETTINGS['currency']) : '',
		'AN_SEQUENCE' => $sequence,
		// worldpay
		'WP_PAYTOID' => $wp_paytoid,
		// 2checkout
		'TC_PAYTOID' => $tc_paytoid,
		// moneybookers
		'MB_PAYTOEMAIL' => $mb_paytoemail,
		// item values
		'PAY_VAL' => $pay_val,
		'CURRENCY' => $system->SETTINGS['currency'],
		'TITLE' => $title,
		'CUSTOM_CODE' => $custoncode,
		'TIMESTAMP' => $timestamp,

		'TOUSER_STRING' => (isset($extrastring)) ? $extrastring : '',
		'B_TOUSER' => ($_GET['a'] == 2)
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'pay.tpl'
		));
$template->display('body');
include 'footer.php';
?>
