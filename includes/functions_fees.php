<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit('Access denied');

class fees
{
	var $ASCII_RANGE;
	var $data;
	var $fee_types;

	function fees()
	{
		$this->ASCII_RANGE = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$this->fee_types = $this->get_fee_types();
	}

	function get_fee_types()
	{
		global $system, $DBPrefix;
		$query = "SELECT type FROM " . $DBPrefix . "fees GROUP BY type";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$fee_types = array();
		while ($row = mysql_fetch_assoc($res))
		{
			$fee_types[] = $row;
		}
		return $fee_types;
	}

	function add_to_account($text, $type, $amount)
	{
		global $system, $DBPrefix, $user;

		$date_values = date('z|W|m|Y', $system->ctime);
		$date_values = explode('|', $date_values);
		$query = "INSERT INTO " . $DBPrefix . "accounts VALUES (NULL, '" . $user->user_data['nick'] . "', '" . $user->user_data['name'] . "', '" . $text . "', '" . $type . "', " . time() . ", '" . $amount . "', " . $date_values[0] . ", " . $date_values[1] . ", " . $date_values[2] . ", " . $date_values[3] . ")";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}

	function hmac($key, $data)
	{
		// RFC 2104 HMAC implementation for php.
		// Creates an md5 HMAC.
		// Eliminates the need to install mhash to compute a HMAC
		// Hacked by Lance Rushing

		$b = 64; // byte length for md5
		if (strlen($key) > $b)
		{
			$key = pack("H*", md5($key));
		}
		$key  = str_pad($key, $b, chr(0x00));
		$ipad = str_pad('', $b, chr(0x36));
		$opad = str_pad('', $b, chr(0x5c));
		$k_ipad = $key ^ $ipad ;
		$k_opad = $key ^ $opad;

		return md5($k_opad  . pack("H*", md5($k_ipad . $data)));
	}

	function paypal_validate()
	{
		global $system, $_POST;

		// we ensure that the txn_id (transaction ID) contains only ASCII chars...
		$pos = strspn($_POST['txn_id'], $this->ASCII_RANGE);
		$len = strlen($_POST['txn_id']);

		if ($pos != $len)
		{
			return;
		}

		//validate payment
		$req = 'cmd=_notify-validate';

		foreach ($this->data as $key => $value)
		{
			$value = urlencode(stripslashes($value));
			$req .= '&' . $key . '=' . $value;
		}

		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

		$payment_amount = $_POST['mc_gross'];
		list($custom_id, $fee_type) = explode('WEBID', $_POST['custom']);

		if (!$fp)
		{
			$error_output = $errstr . ' (' . $errno . ')';
		}
		else
		{
			fputs ($fp, $header . $req);

			while (!feof($fp))
			{
				$res = fgets ($fp, 1024);

				if (strcmp ($res, 'VERIFIED') == 0)
				{
					$this->callback_process($custom_id, $fee_type, $payment_amount);
				}
			}
			fclose ($fp);
		}
	}

	function authnet_validate()
	{
		global $system, $_POST;

		$payment_amount = $_POST['x_amount'];

		list($custom_id, $fee_type) = explode('WEBID', $_POST['custom']);

		if ($_POST['x_response_code'] == 1)
		{
			$this->callback_process($custom_id, $fee_type, $payment_amount);
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?completed';
		}
		else
		{
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?fail';
		}

		header('location: '. $redirect_url);
		exit;
	}

	function worldpay_validate()
	{
		global $system, $_POST;

		$payment_amount = $_POST['amount'];

		list($custom_id, $fee_type) = explode('WEBID',$_POST['cartId']);

		if ($_POST['transStatus'] == 'Y')
		{
			$this->callback_process($custom_id, $fee_type, $payment_amount);
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?completed';
		}
		else
		{
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?fail';
		}

		header('location: '. $redirect_url);
		exit;
	}

	function moneybookers_validate()
	{
		global $system, $_POST;

		$payment_amount = $_POST['amount'];

		list($custom_id, $fee_type) = explode('WEBID',$_POST['trans_id']);

		if ($_POST['status'] == 2)
		{
			$this->callback_process($custom_id, $fee_type, $payment_amount);
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?completed';
		}
		else
		{
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?fail';
		}

		header('location: '. $redirect_url);
		exit;
	}

	function toocheckout_validate()
	{
		global $system, $_POST;

		$payment_amount = $_POST['total'];

		list($custom_id, $fee_type) = explode('WEBID',$_POST['cart_order_id']);

		if ($_POST['cart_order_id'] != '' && $_POST['credit_card_processed'] == 'Y')
		{
			$this->callback_process($custom_id, $fee_type, $payment_amount);
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?completed';
		}
		else
		{
			$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?fail';
		}

		header('location: '. $redirect_url);
		exit;
	}

	function callback_process($custom_id, $fee_type, $payment_amount, $currency = NULL)
	{
		global $system, $DBPrefix;

		switch ($fee_type)
		{
			case 1:
				$addquery = '';
				if ($system->SETTINGS['fee_disable_acc'] == 'y')
				{
					$query = "SELECT suspended, balance FROM " . $DBPrefix . "users WHERE id = " . $custom_id;
					$res = mysql_query($query);
					$system->check_mysql($res, $query, __LINE__, __FILE__);
					$data = mysql_fetch_assoc($res);
					// reable user account if it was disabled
					if ($data['suspended'] == 7 && ($data['balance'] + $payment_amount) >= 0)
					{
						$addquery = ', suspended = 0 ';
					}
				}
				$query = "UPDATE " . $DBPrefix . "users SET balance = balance + " . $payment_amount . $addquery . " WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 2:
				$query = "UPDATE " . $DBPrefix . "winners SET paid = 1 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 3:
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 4:
				global $user, $MSG;
				$catscontrol = new MPTTcategories();

				$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "DELETE FROM " . $DBPrefix . "userfees WHERE auc_id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

				$query = "SELECT category, title, minimum_bid, pict_url, buy_now, reserve_price, auction_type, ends
						FROM " . $DBPrefix . "auctions WHERE id = " . $custom_id;
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$auc_data = mysql_fetch_assoc($res);

				// auction data
				$auction_id = $custom_id;
				$title = $auc_data['title'];
				$atype = $auc_data['auction_type'];
				$pict_url = $auc_data['pict_url'];
				$minimum_bid = $auc_data['minimum_bid'];
				$reserve_price = $auc_data['reserve_price'];
				$buy_now_price = $auc_data['buy_now'];
				$a_ends = $auc_data['ends'];

				if ($user->user_data['startemailmode'] == 'yes')
				{
					include $include_path . 'auction_confirmation.inc.php';
				}

				// update recursive categories
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $auc_data['category'];
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$parent_node = mysql_fetch_assoc($res);
				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
			break;
			case 5:
				$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 6: //buyer fee
				$query = "UPDATE " . $DBPrefix . "winners SET bf_paid = 1 WHERE bf_paid = 0 AND auction = " . $custom_id . " AND winner = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 7: //final value fee
				$query = "UPDATE " . $DBPrefix . "winners SET ff_paid = 1 WHERE ff_paid = 0 AND auction = " . $custom_id . " AND seller = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			
		}
	}
}
?>