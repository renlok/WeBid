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
		global $system;

		$sandbox = false; // set to true to enabled sandbox mode
		// we ensure that the txn_id (transaction ID) contains only ASCII chars...
		$pos = strspn($this->data['txn_id'], $this->ASCII_RANGE);
		$len = strlen($this->data['txn_id']);

		if ($pos != $len)
		{
			return;
		}

		//validate payment
		$req = 'cmd=_notify-validate';

		foreach ($this->data as $key => $value)
		{
			// Handle escape characters, which depends on setting of magic quotes  
			if(get_magic_quotes_gpc())
				$value = urlencode(stripslashes($value));
			else
				$value = urlencode($value);
			$req .= '&' . $key . '=' . $value;
		}

		// Post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		if (!$sandbox)
		{
			$header .= "Host: www.paypal.com\r\n";
		}
		else
		{
			$header .= "Host: www.sandbox.paypal.com\r\n";
		}
		$header .= "Content-Length: " . strlen($req) . "\r\n";
		$header .= "Connection: close\r\n\r\n";  

		if (!$sandbox)
		{
			if (!empty($system->SETTINGS['https_url']))
			{
				// connect via SSL
				$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
			}
			else
			{
				// connect via HTTP
				$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
			}
		}
		else
		{
			if (!empty($system->SETTINGS['https_url']))
			{
				// connect via SSL
				$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
			}
			else
			{
				// connect via HTTP
				$fp = fsockopen ('www.sandbox.paypal.com', 443, $errno, $errstr, 30);
			}
		}

		if (!$fp)
		{
			$error_output = $errstr . ' (' . $errno . ')';
		}
		else
		{
			// Assign posted variables to local variables
			$payment_status = $this->data['payment_status'];
			$payment_amount = floatval ($this->data['mc_gross']);
			list($custom_id, $fee_type) = explode('WEBID', $this->data['custom']);

			fputs ($fp, $header . $req);

			while (!feof($fp))
			{
				$resl = trim(fgets ($fp, 1024));

				if (strcmp ($resl, 'VERIFIED') == 0)
				{
					// We can do various checks to make sure nothing is wrong  
					// Check that receiver_email is your Primary PayPal email and   
					// that txn_id has not been previously processed
					if ($payment_status == 'Completed')
					{
						// everything seems to be OK
						$this->callback_process($custom_id, $fee_type, $payment_amount);
					}
				}
				else if (strcmp ($resl, 'INVALID') == 0)
				{
					// payment failed
				}
			}
			fclose ($fp);
		}
	}

	function authnet_validate()
	{
		global $system;

		$payment_amount = floatval ($this->data['x_amount']);

		list($custom_id, $fee_type) = explode('WEBID', $this->data['custom']);

		if ($this->data['x_response_code'] == 1)
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
		global $system;

		$payment_amount = floatval ($this->data['amount']);

		list($custom_id, $fee_type) = explode('WEBID',$this->data['cartId']);

		if ($this->data['transStatus'] == 'Y')
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
		global $system;

		$payment_amount = floatval ($this->data['amount']);

		list($custom_id, $fee_type) = explode('WEBID',$this->data['trans_id']);

		if ($this->data['status'] == 2)
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
		global $system;

		$payment_amount = floatval ($this->data['total']);

		list($custom_id, $fee_type) = explode('WEBID',$this->data['cart_order_id']);

		if ($this->data['cart_order_id'] != '' && $this->data['credit_card_processed'] == 'Y')
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
			case 1: // add to account balance
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
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, date, balance, total, paid) VALUES
						(" . $custom_id . ", " . time() . ", " . $payment_amount . ", " . $payment_amount . ", 1)";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 2: // pay for an item
				$query = "UPDATE " . $DBPrefix . "winners SET paid = 1 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 3: // pay signup fee (live mode)
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, date, signup, total, paid) VALUES
						(" . $custom_id . ", " . time() . ", " . $payment_amount . ", " . $payment_amount . ", 1)";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 4: // pay auction fee (live mode)
				global $user, $MSG;
				$catscontrol = new MPTTcategories();

				$query = "SELECT auc_id FROM " . $DBPrefix . "useraccounts WHERE useracc_id = " . $custom_id;
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$auc_id = mysql_result($res, 0, 'auc_id');
				$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = " . $auc_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "useraccounts SET paid = 1 WHERE auc_id = " . $auc_id . " AND setup > 0";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "useraccounts SET paid = 1 WHERE useracc_id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

				$query = "SELECT category, title, minimum_bid, pict_url, buy_now, reserve_price, auction_type, ends
						FROM " . $DBPrefix . "auctions WHERE id = " . $auc_id;
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$auc_data = mysql_fetch_assoc($res);

				// auction data
				$auction_id = $auc_id;
				$title = $auc_data['title'];
				$atype = $auc_data['auction_type'];
				$pict_url = $auc_data['pict_url'];
				$minimum_bid = $auc_data['minimum_bid'];
				$reserve_price = $auc_data['reserve_price'];
				$buy_now_price = $auc_data['buy_now'];
				$a_ends = $auc_data['ends'];

				if ($user->user_data['startemailmode'] == 'yes')
				{
					include $include_path . 'email_auction_confirmation.php';
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
			case 5: // pay relist fee (live mode)
				$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = " . $custom_id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, relist, total, paid) VALUES
						(" . $custom_id . ", " . $custom_id . ", " . time() . ", " . $payment_amount . ", " . $payment_amount . ", 1)";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 6:  // pay buyer fee (live mode)
				$query = "UPDATE " . $DBPrefix . "winners SET bf_paid = 1 WHERE bf_paid = 0 AND auction = " . $custom_id . " AND winner = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
						(" . $user->user_data['id'] . ", " . $custom_id . ", " . time() . ", " . $payment_amount . ", " . $payment_amount . ", 1)";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			case 7: // pay final value fee (live mode)
				$query = "UPDATE " . $DBPrefix . "winners SET ff_paid = 1 WHERE ff_paid = 0 AND auction = " . $custom_id . " AND seller = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $user->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES
						(" . $user->user_data['id'] . ", " . $custom_id . ", " . time() . ", " . $payment_amount . ", " . $payment_amount . ", 1)";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			break;
			
		}
	}
}
?>