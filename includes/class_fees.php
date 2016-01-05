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
		global $system, $DBPrefix, $db;
		$query = "SELECT type FROM " . $DBPrefix . "fees GROUP BY type";
		$db->direct_query($query);
		$fee_types = array();
		while ($row = $db->result())
		{
			$fee_types[] = $row;
		}
		return $fee_types;
	}

	function add_to_account($text, $type, $amount)
	{
		global $system, $DBPrefix, $user, $db;

		$date_values = date('z|W|m|Y');
		$date_values = explode('|', $date_values);
		$query = "INSERT INTO " . $DBPrefix . "accounts VALUES (NULL, :user_nick, :user_name, :user_text, :user_type, :user_time, :user_amount, " . $date_values[0] . ", " . $date_values[1] . ", " . $date_values[2] . ", " . $date_values[3] . ")";
		$params = array();
		$params[] = array(':user_nick', $user->user_data['nick'], 'str');
		$params[] = array(':user_name', $user->user_data['name'], 'str');
		$params[] = array(':user_text', $text, 'str');
		$params[] = array(':user_type', $type, 'str');
		$params[] = array(':user_time', time(), 'int');
		$params[] = array(':user_amount', $amount, 'int');
		$db->query($query, $params);
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

		$sandbox = ($system->SETTINGS['paypal_sandbox']);
		$https = ($system->SETTINGS['https'] == 'y') ? true : false;
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
			if ($https == true)
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
			if ($https == true)
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
					$redirect_url = $system->SETTINGS['siteurl'] . 'validate.php?fail';
					header('location: '. $redirect_url);
					exit;
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

	function moneybookers_validate() // now called skrill
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
		global $system, $DBPrefix, $db;

		switch ($fee_type)
		{
			case 1: // add to account balance
				$addquery = '';
				if ($system->SETTINGS['fee_disable_acc'] == 'y')
				{
					$query = "SELECT suspended, balance FROM " . $DBPrefix . "users WHERE id = :custom_id";
					$params = array();
					$params[] = array(':custom_id', $custom_id, 'int');
					$db->query($query, $params);
					$data = $db->result();
					// reable user account if it was disabled
					if ($data['suspended'] == 7 && ($data['balance'] + $payment_amount) >= 0)
					{
						$addquery = ', suspended = 0 ';
					}
				}
				$query = "UPDATE " . $DBPrefix . "users SET balance = balance + :payment" . $addquery . " WHERE id = :user_id";
				$params[] = array(':payment', $payment_amount, 'float');
				$params[] = array(':user_id', $custom_id, 'int');
				$db->query($query, $params);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, date, balance, total, paid) VALUES
						(:user_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array();
				$params[] = array(':user_id', $custom_id, 'int');
				$params[] = array(':time_stamp', time(), 'int');
				$params[] = array(':payment', $payment_amount, 'float');
				$params[] = array(':extra_payment', $payment_amount, 'float');
				$db->query($query, $params);
			break;
			case 2: // pay for an item
				$query = "UPDATE " . $DBPrefix . "winners SET paid = 1 WHERE id = :custom_id";
				$params = array();
				$params[] = array(':custom_id', $custom_id, 'int');
				$db->query($query, $params);
			break;
			case 3: // pay signup fee (live mode)
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = :custom_id";
				$params = array();
				$params[] = array(':custom_id', $custom_id, 'int');
				$db->query($query, $params);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, date, signup, total, paid) VALUES
						(:get_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array();
				$params[] = array(':get_id', $custom_id, 'int');
				$params[] = array(':time_stamp', time(), 'int');
				$params[] = array(':payment', $payment_amount, 'float');
				$params[] = array(':extra_payment', $payment_amount, 'float');
				$db->query($query, $params);
			break;
			case 4: // pay auction fee (live mode)
				global $user, $MSG;
				$catscontrol = new MPTTcategories();

				$query = "SELECT auc_id FROM " . $DBPrefix . "useraccounts WHERE useracc_id = :useracc_id";
				$params = array();
				$params[] = array(':useracc_id', $custom_id, 'int');
				$db->query($query, $params);
				$auc_id = $db->result('auc_id');

				$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = :auc_id";
				$params = array();
				$params[] = array(':auc_id', $auc_id, 'int');
				$db->query($query, $params);

				$query = "UPDATE " . $DBPrefix . "useraccounts SET paid = 1 WHERE auc_id = :auc_id AND setup > 0";
				$params = array();
				$params[] = array(':auc_id', $auc_id, 'int');
				$db->query($query, $params);

				$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
				$db->direct_query($query);

				$query = "UPDATE " . $DBPrefix . "useraccounts SET paid = 1 WHERE useracc_id = :custom_id";
				$params = array();
				$params[] = array(':custom_id', $custom_id, 'int');
				$db->query($query, $params);

				$query = "SELECT category, title, minimum_bid, pict_url, buy_now, reserve_price, auction_type, ends
					FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
				$params = array();
				$params[] = array(':auc_id', $auc_id, 'int');
				$db->query($query, $params);
				$auc_data = $db->result();

				// auction data
				$auction_id = $auc_id;
				$title = $system->uncleanvars($auc_data['title']);
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
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $auc_data['category'], 'int');
				$db->query($query, $params);
				$parent_node = $db->result();
				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
					$params = array();
					$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
					$db->query($query, $params);
				}
			break;
			case 5: // pay relist fee (live mode)
				$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = :custom_id";
				$params = array();
				$params[] = array(':custom_id', $custom_id, 'int');
				$db->query($query, $params);
				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, relist, total, paid) VALUES
						(:user_id, :auc_id, :date, :relist, :total, 1)";
				$params = array();
				$params[] = array(':user_id', $custom_id, 'int');
				$params[] = array(':auc_id', $custom_id, 'int');
				$params[] = array(':date', time(), 'int');
				$params[] = array(':relist', $payment_amount, 'float');
				$params[] = array(':total', $payment_amount, 'float');
				$db->query($query, $params);
			break;
			case 6:  // pay buyer fee (live mode)
				$query = "UPDATE " . $DBPrefix . "winners SET bf_paid = 1 WHERE bf_paid = 0 AND auction = :auction_id AND winner = :winner_id";
				$params = array();
				$params[] = array(':auction_id', $custom_id, 'int');
				$params[] = array(':winner_id', $user->user_data['id'], 'int');
				$db->query($query, $params);

				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = :user_id";
				$params = array();
				$params[] = array(':user_id', $user->user_data['id'], 'int');
				$db->query($query, $params);

				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
						(:user_id, :auc_id, :time_stamp, :buyer, :total, 1)";
				$params = array();
				$params[] = array(':user_id', $user->user_data['id'], 'int');
				$params[] = array(':auc_id', $custom_id, 'int');
				$params[] = array(':time_stamp', time(), 'int');
				$params[] = array(':buyer', $payment_amount, 'float');
				$params[] = array(':total', $payment_amount, 'float');
				$db->query($query, $params);
			break;
			case 7: // pay final value fee (live mode)
				$query = "UPDATE " . $DBPrefix . "winners SET ff_paid = 1 WHERE ff_paid = 0 AND auction = :auction_id AND seller = :user_id";
				$params = array();
				$params[] = array(':auction_id', $custom_id, 'int');
				$params[] = array(':user_id', $user->user_data['id'], 'int');
				$db->query($query, $params);

				$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = :user_id";
				$params = array();
				$params[] = array(':user_id', $user->user_data['id'], 'int');
				$db->query($query, $params);

				// add invoice
				$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES
						(:user_id, :auc_id, :time_stamp, :finalval, :total, 1)";
				$params = array();
				$params[] = array(':user_id', $user->user_data['id'], 'int');
				$params[] = array(':auc_id', $custom_id, 'int');
				$params[] = array(':time_stamp', $system->ctime, 'int');
				$params[] = array(':finalval', $payment_amount, 'float');
				$params[] = array(':total', $payment_amount, 'float');
				$db->query($query, $params);
			break;

		}
	}
}