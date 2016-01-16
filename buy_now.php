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
include $include_path . 'membertypes.inc.php';
foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}

$id = intval($_REQUEST['id']);

if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'buy_now.php?id=' . $id;
	header('location: user_login.php');
	exit;
}

if (in_array($user->user_data['suspended'], array(5, 6, 7)))
{
	header('location: message.php');
	exit;
}

if (!$user->can_buy)
{
	$_SESSION['TMP_MSG'] = $MSG['819'];
	header('location: user_menu.php');
	exit;
}

if ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
{
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
	$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;
	header('location: ' . $sslurl . 'buy_now.php?id=' . $id);
	exit;
}

unset($ERR);
ksort($memtypesarr, SORT_NUMERIC);
$NOW = time();

$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
$params = array();
$params[] = array(':auc_id', $id, 'int');
$db->query($query, $params);

$Auction = $db->result();

// such auction does not exist
if ($db->numrows() == 0)
{
	$template->assign_vars(array(
			'TITLE_MESSAGE' => $MSG['415'],
			'BODY_MESSAGE' => $ERR_606
			));
	include 'header.php';
	$template->set_filenames(array(
			'body' => 'message.tpl'
			));
	$template->display('body');
	include 'footer.php';
	exit; // kill the page
}

if ($Auction['closed'] == 1)
{
	header('location: item.php?id=' . $_REQUEST['id']);
	exit;
}
if ($Auction['starts'] > time())
{
	$ERR = $ERR_073;
}

// If there are bids for this auction -> error
if ($Auction['bn_only'] == 'n')
{
	if (!($Auction['buy_now'] > 0 && ($Auction['num_bids'] == 0 || ($Auction['reserve_price'] > 0 && $Auction['current_bid'] < $Auction['reserve_price']) || ($Auction['current_bid'] < $Auction['buy_now']))))
	{
		$ERR = $ERR_712;
	}
	else
	{
		$query = "SELECT MAX(bid) AS maxbid FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $id, 'int');
		$db->query($query, $params);
		$maxbid = $db->result('maxbid');
		if (($maxbid > 0 && $maxbid >= $Auction['reserve_price']))
		{
			$ERR = $ERR_712;
		}
	}
}

// get user's details
$query = "SELECT id, name, nick, email, rate_sum FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $Auction['user'], 'int');
$db->query($query, $params);
$Seller = $db->result();

// Get current total rate value for user
$total_rate = $Seller['rate_sum'];

$i = 0;
foreach ($memtypesarr as $k => $l)
{
	if ($k >= $total_rate || $i++ == (count($memtypesarr) - 1))
	{
		$TPL_rate_radio = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
		break;
	}
}

$qty = (isset($_REQUEST['qty'])) ? intval($_REQUEST['qty']) : 1;

$buy_done = 0;
if (isset($_POST['action']) && $_POST['action'] == 'buy')
{
	if ($system->SETTINGS['usersauth'] == 'y')
	{
		// check if password entered
		if (strlen($_POST['password']) == 0)
		{
			$ERR = $ERR_610;
		}
		// check if password is correct
		include $include_path . 'PasswordHash.php';
		$phpass = new PasswordHash(8, false);
		if (!($phpass->CheckPassword($_POST['password'], $user->user_data['password'])))
		{
			$ERR = $ERR_611;
		}
	}
	// check if buyer is not the seller
	if ($user->user_data['id'] == $Auction['user'])
	{
		$ERR = $ERR_711;
	}
	// check auction still has items left to buy
	if (isset($qty) && $qty > $Auction['quantity'])
	{
		$ERR = $ERR_608;
	}
	else if (!isset($qty) || $qty < 1)
	{
		$ERR = $ERR_601;
	}
	// perform final actions
	if (!isset($ERR))
	{
		$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :user_id, :buy_now, :time, :qty)";
		$params = array();
		$params[] = array(':auc_id', $id, 'int');
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$params[] = array(':buy_now', $Auction['buy_now'], 'float');
		$params[] = array(':time', $NOW, 'int');
		$params[] = array(':qty', $qty, 'int');
		$db->query($query, $params);
		$current_bid_id = $db->lastInsertId();
		if (defined('TrackUserIPs'))
		{
			// log auction BIN IP
			$system->log('user', 'BIN on Item', $user->user_data['id'], $id);
		}
		if ($Auction['bn_only'] != 'y')
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET ends = :time, bn_sale = 1, num_bids = num_bids + 1, current_bid = :buy_now, current_bid_id = :current_bid_id WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $id, 'int');
			$params[] = array(':buy_now', $Auction['buy_now'], 'float');
			$params[] = array(':current_bid_id', $current_bid_id, 'int');
			$params[] = array(':time', $NOW, 'int');
			$db->query($query, $params);
			$query = "UPDATE " . $DBPrefix . "counters SET bids = bids + 1";
			$db->direct_query($query);
			// so its not over written by the cron
			$tmpauc = $Auction;
			include 'cron.php';
			$Auction = $tmpauc;
			unset($tmpauc);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET quantity = quantity - :quantity WHERE id = :auc_id";
			$params = array();
			$params[] = array(':quantity', $qty, 'int');
			$params[] = array(':auc_id', $id, 'int');
			$db->query($query, $params);
			// force close if all items sold
			if (($Auction['quantity'] - $qty) == 0)
			{
				$query = "UPDATE " . $DBPrefix . "auctions SET ends = :time, bn_sale = 1, current_bid = :current_bid, current_bid_id = :current_bid_id, sold = 'y', num_bids = num_bids + 1, closed = 1 WHERE id = :auc_id";
				$params = array();
				$params[] = array(':time', $NOW, 'int');
				$params[] = array(':auc_id', $id, 'int');
				$params[] = array(':current_bid', $Auction['buy_now'], 'int');
				$params[] = array(':current_bid_id', $current_bid_id, 'int');
				$db->query($query, $params);
			}
			// do stuff that is important
			$query = "SELECT id, name, nick, email, address, city, prov, zip, country FROM " . $DBPrefix . "users WHERE id = :user_id";
			$params = array();
			$params[] = array(':user_id', $user->user_data['id'], 'int');
			$db->query($query, $params);
			$Winner = $db->result();
			$bf_paid = 1;
			$ff_paid = 1;

			// work out & add fee
			if ($system->SETTINGS['fees'] == 'y')
			{
				$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = 'buyer_fee'";
				$db->direct_query($query);
				$row = $db->result();
				$fee_type = $row['fee_type'];
				if ($row['fee_type'] == 'flat')
				{
					$fee_value = $row['value'] * $qty;
				}
				else
				{
					$fee_value = ($row['value'] / 100) * floatval($Auction['buy_now']) * $qty;
				}
				if ($system->SETTINGS['fee_type'] == 1 || $fee_value <= 0)
				{
					// add balance & invoice
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee_value WHERE id = :user_id";
					$params = array();
					$params[] = array(':fee_value', $fee_value, 'int');
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$db->query($query, $params);
					$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
							(:user_id, :auc_id, :time, :buyer, :total, 1)";
					$params = array();
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':buyer', $fee_value, 'int');
					$params[] = array(':total', $fee_value, 'int');
					$db->query($query, $params);
				}
				else
				{
					$bf_paid = 0;
					$query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = :user_id";
					$params = array();
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$db->query($query, $params);
				}
				// do the final value fees
				$query = "SELECT value, fee_type, fee_from, fee_to FROM " . $DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
				$db->direct_query($query);
				$fee_value = 0;
				while ($row = $db->fetch())
				{
					if (floatval($Auction['buy_now']) >= $row['fee_from'] && floatval($Auction['buy_now']) <= $row['fee_to'])
					{
						if ($row['fee_type'] == 'flat')
						{
							$fee_value = $row['value'] * $qty;
						}
						else
						{
							$fee_value = ($row['value'] / 100) * floatval($Auction['buy_now']) * $qty;
						}
					}
				}
				if ($system->SETTINGS['fee_type'] == 1 || $fee_value <= 0)
				{
					// add user balance & invoice
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee_value WHERE id = :user_id";
					$params = array();
					$params[] = array(':fee_value', $fee_value, 'int');
					$params[] = array(':user_id', $Auction['user'], 'int');
					$db->query($query, $params);
					$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES
							(:user_id, :auc_id, :time, :finalval, :total, 1)";
					$params = array();
					$params[] = array(':user_id', $Auction['user'], 'int');
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':finalval', $fee_value, 'int');
					$params[] = array(':total', $fee_value, 'int');
					$db->query($query, $params);
				}
				else
				{
					$query = "UPDATE " . $DBPrefix . "users SET suspended = 5 WHERE id = :user_id";
					$params = array();
					$params[] = array(':user_id', $Auction['user'], 'int');
					$db->query($query, $params);
					$emailer = new email_handler();
					$emailer->assign_vars(array(
							'ID' => $Auction['id'],
							'TITLE' => $system->uncleanvars($Auction['title']),
							'NAME' => $Seller['name'],
							'LINK' => $system->SETTINGS['siteurl'] . 'pay.php?a=7&auction_id=' . $Auction['id']
							));
					$emailer->email_uid = $Auction['user'];
					$emailer->email_sender($Seller['email'], 'final_value_fee.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['523']);
					$ff_paid = 0;
				}
			}
			// work out shipping cost
			$query = "INSERT INTO " . $DBPrefix . "winners
					(auction, seller, winner, bid, closingdate, feedback_win, feedback_sel, qty, paid, bf_paid, ff_paid, shipped, auc_title, auc_shipping_cost, auc_payment) VALUES
					(:auc_id, :seller_id, :winner_id, :buy_now, :time, 0, 0, :quantity, 0, :bf_paid, :ff_paid, 0, :auc_title, :auc_shipping_cost, :auc_payment)";
			$params = array();
			$params[] = array(':auc_id', $id, 'int');
			$params[] = array(':seller_id', $Auction['user'], 'int');
			$params[] = array(':winner_id', $Winner['id'], 'int');
			$params[] = array(':buy_now', $Auction['buy_now'], 'float');
			$params[] = array(':time', $NOW, 'int');
			$params[] = array(':quantity', $qty, 'int');
			$params[] = array(':bf_paid', $bf_paid, 'float');
			$params[] = array(':ff_paid', $ff_paid, 'float');
			$params[] = array(':auc_title', $Auction['title'], 'str');
			$params[] = array(':auc_shipping_cost', calculate_shipping_data($Auction), 'float');
			$params[] = array(':auc_payment', $Auction['payment'], 'str');
			$db->query($query, $params);
			$winner_id = $db->lastInsertId();

			// get end string
			$month = date('m', $Auction['ends'] + $system->tdiff);
			$ends_string = $MSG['MON_0' . $month] . ' ' . date('d, Y H:i', $Auction['ends'] + $system->tdiff);
			$Auction['current_bid'] = $Auction['buy_now'];
			include $include_path . 'endauction_mutli_item_win.php';
			include $include_path . 'email_seller_partial_winner.php';

			if ($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0)
			{
				$_SESSION['auction_id'] = $auction_id;
				header('location: pay.php?a=6');
				exit;
			}

			if ($Auction['initial_quantity'] == 1 || ($Auction['quantity'] - $qty) == 0)
			{
				$tmpauc = $Auction;
				include 'cron.php';
				$Auction = $tmpauc;
				unset($tmpauc);
			}
		}

		$buy_done = 1;
	}
}

$additional_shipping = $Auction['shipping_cost_additional'] * ($qty - 1);
$shipping_cost = ($Auction['shipping'] == 1) ? ($Auction['shipping_cost'] + $additional_shipping) : 0;
$BN_total = ($Auction['buy_now'] * $qty) + $shipping_cost;

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $_REQUEST['id'],
		'WINID' => $winner_id,
		'TITLE' => $system->uncleanvars($Auction['title']),
		'BN_PRICE' => $system->print_money($Auction['buy_now']),
		'SHIPPINGCOST' => ($shipping_cost >  0) ? $system->print_money($shipping_cost) : 0,
		'BN_TOTAL' => $system->print_money($BN_total),
		'SELLER' => ' <a href="profile.php?user_id=' . $Auction['user'] . '"><b>' . $Seller['nick'] . '</b></a>',
		'SELLERNUMFBS' => '<b>(' . $total_rate . ')</b>',
		'FBICON' => $TPL_rate_radio,
		'LEFT' => $Auction['quantity'],

		'B_QTY' => ($Auction['quantity'] > 1),
		'B_NOTBOUGHT' => ($buy_done != 1),
		'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'buy_now.tpl'
		));
$template->display('body');
require('footer.php');
