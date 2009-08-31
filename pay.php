<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
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
	header('location: user_login.php');
	exit;
}

$query = "SELECT * FROM " . $DBPrefix . "gateways LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$gayeway_data = mysql_fetch_assoc($res);

switch($_GET['a'])
{
	case 1: // add to account balance
		$pp_paytoemail = $gayeway_data['paypal_address'];
		$payvalue = $system->input_money($_POST['pfval']);
		$custoncode = $user->user_data['id'] . 'WEBID1';
		$message = sprintf($MSG['582'], $system->print_money_nosymbol($payvalue));
		$title = '';
		break;
	case 2:
		$query = "SELECT w.id, a.title, a.shipping_cost, w.bid, u.paypal_email FROM " . $DBPrefix . "auctions a
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
		$pp_paytoemail = $data['paypal_email'];
		$payvalue = $data['shipping_cost'] + $data['bid'];
		$custoncode = $data['id'] . 'WEBID2';
		$message = sprintf($MSG['581'], $system->print_money_nosymbol($payvalue));
		$title = '';
		break;
	case 3: // pay signup fee (live mode)
		if (!isset($_SESSION['signup_id']) || !is_int($_SESSION['signup_id']) || $_SESSION['signup_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}
		$pp_paytoemail = $gayeway_data['paypal_address'];
		$query = "SELECT type FROM " . $DBPrefix . "fees WHERE type = 'signup_fee'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$payvalue = mysql_result($res, 0);
		$custoncode = $_SESSION['signup_id'] . 'WEBID3';
		$message = sprintf($MSG['583'], $system->print_money_nosymbol($payvalue));
		$title = '';
		break;
	case 4: // pay auction fee (live mode)
		if (!isset($_SESSION['auction_id']) || !is_int($_SESSION['auction_id']) || $_SESSION['auction_id'] < 1 || $system->SETTINGS['fee_type'] != 2)
		{
			header('location: index.php');
			exit;
		}
		$pp_paytoemail = $gayeway_data['paypal_address'];
		$query = "SELECT amt FROM " . $DBPrefix . "userfees WHERE auc_id = " . $_SESSION['auction_id'] . " AND user_id = " . $user->user_data['id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$payvalue = mysql_result($res, 0, 'amt');
		$custoncode = $_SESSION['auction_id'] . 'WEBID4';
		$message = sprintf($MSG['590'], $system->print_money_nosymbol($payvalue));
		$title = '';
		break;
	case 5: // pay relist fee (live mode)
		$pp_paytoemail = $gayeway_data['paypal_address'];
		// number of auctions to relist
		$query = "SELECT COUNT(*) FROM " . $DBPrefix . "auctions WHERE suspended = 8 AND user_id = " . $user->user_data['id'];
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
		$message = sprintf($MSG['591'], $system->print_money_nosymbol($payvalue));
		$title = '';
		break;
}

$template->assign_vars(array(
		'TOP_MESSAGE' => $message,
		'B_ENPAYPAL' => ($gayeway_data['paypal_active'] && !empty($pp_paytoemail)),
		'PP_PAYTOEMAIL' => $pp_paytoemail,
		'PAY_VAL' => $payvalue,
		'CURRENCY' => $system->SETTINGS['currency'],
		'TITLE' => $title,
		'CUSTOM_CODE' => $custoncode
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'pay.tpl'
		));
$template->display('body');
include 'footer.php';
?>
