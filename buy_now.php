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
$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$Auction = mysql_fetch_assoc($res);
// such auction does not exist
if (mysql_num_rows($res) == 0)
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
		$query = "SELECT MAX(bid) AS maxbid FROM " . $DBPrefix . "proxybid WHERE itemid = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$maxbid = mysql_result($res, 0, 'maxbid');
		if (($maxbid > 0 && $maxbid >= $Auction['reserve_price']))
		{
			$ERR = $ERR_712;
		}
	}
}

// get user's nick
$query = "SELECT nick, email, rate_sum FROM " . $DBPrefix . "users WHERE id = " . $Auction['user'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$Seller = mysql_fetch_assoc($res);

// Get current number of feedbacks
$query = "SELECT rated_user_id FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = " . $Auction['user'];
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$num_feedbacks = mysql_num_rows($result);

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
		if ($user->user_data['password'] != md5($MD5_PREFIX . $_POST['password']))
		{
			$ERR = $ERR_611;
		}
	}
	// check if buyer is not the seller
	if ($user->user_data['id'] == $Auction['user'])
	{
		$ERR = $ERR_711;
	}
	// check qty
	if (isset($qty) && $qty > $Auction['quantity'])
	{
		$ERR = $ERR_608;
	}
	// perform final actions
	if (!isset($ERR))
	{
		$query = "INSERT INTO " . $DBPrefix . "bids VALUES
				(NULL, " . $id . ", " . $user->user_data['id'] . ", " . floatval($Auction['buy_now']) . ", '" . $NOW . "', 1)";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		if (defined('TrackUserIPs'))
		{
			// log auction BIN IP
			$system->log('user', 'BIN on Item', $user->user_data['id'], $id);
		}
		if ($Auction['quantity'] == 1)
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET ends = '" . $NOW . "', num_bids = num_bids + 1, current_bid = " . floatval($Auction['buy_now']) . "
					WHERE id = " . $id;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "UPDATE " . $DBPrefix . "counters SET bids = bids + 1";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// so its not over written by the cron
			$tmpauc = $Auction;
			include 'cron.php';
			$Auction = $tmpauc;
			unset($tmpauc);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET quantity = quantity - " . $qty . " WHERE id = " . $id;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// force close if all items sold
			if (($Auction['quantity'] - $qty) == 0)
			{
				$query = "UPDATE " . $DBPrefix . "auctions SET ends = '" . $NOW . "' WHERE id = " . $id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}
			// do stuff that is important
			$query = "SELECT id, name, email FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$Winner = mysql_fetch_assoc($res);
			$bf_paid = 1;
			$ff_paid = 1;

			// work out & add fee
			if ($system->SETTINGS['fees'] == 'y')
			{
				$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = 'buyer_fee'";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$row = mysql_result($res, 0);
				$fee_type = $row['fee_type'];
				if ($row['fee_type'] == 'flat')
				{
					$fee_value = $row['value'];
				}
				else
				{
					$fee_value = ($row['value'] / 100) * floatval($Auction['buy_now']);
				}
				if ($system->SETTINGS['fee_type'] == 1 || $fee_value <= 0)
				{
					// add balance & invoice
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - " . $fee_value . " WHERE id = " . $user->user_data['id'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
							(" . $user->user_data['id'] . ", " . $id . ", " . time() . ", " . $fee_value . ", " . $fee_value . ", 1)";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				else
				{
					$bf_paid = 0;
					$query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = " . $user->user_data['id'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				// do the final value fees
				$query = "SELECT value, fee_type, fee_from, fee_to FROM " . $DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$fee_value = 0;
				while ($row = mysql_fetch_assoc($res))
				{
					if (floatval($Auction['buy_now']) >= $row['fee_from'] && floatval($Auction['buy_now']) <= $row['fee_to'])
					{
						if ($row['fee_type'] == 'flat')
						{
							$fee_value = $row['value'];
						}
						else
						{
							$fee_value = ($row['value'] / 100) * floatval($Auction['buy_now']);
						}
					}
				}
				if ($system->SETTINGS['fee_type'] == 1 || $fee_value <= 0)
				{
					// add user balance & invoice
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - " . $fee_value . " WHERE id = " . $Auction['user'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES
							(" . $Auction['user'] . ", " . $id . ", " . time() . ", " . $fee_value . ", " . $fee_value . ", 1)";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				else
				{
					$query = "UPDATE " . $DBPrefix . "users SET suspended = 5 WHERE id = " . $Auction['user'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$emailer = new email_handler();
					$emailer->assign_vars(array(
							'ID' => $Auction['id'],
							'TITLE' => $Auction['title'],
							'NAME' => $Seller['name'],
							'LINK' => $system->SETTINGS['siteurl'] . 'pay.php?a=7&auction_id=' . $Auction['id']
							));
					$emailer->email_uid = $Auction['user'];
					$emailer->email_sender($Seller['email'], 'final_value_fee.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['523']);
					$ff_paid = 0;
				}
			}

			$query = "INSERT INTO " . $DBPrefix . "winners VALUES
					(NULL, " . $id . ", " . $Auction['user'] . ", " . $Winner['id'] . ", " . $Auction['buy_now'] . ", '" . $NOW . "', 0, 0, " . $qty . ", 0, " . $bf_paid . ", " . $ff_paid . ")";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			// get end string
			$month = gmdate('m', $Auction['ends'] + $system->tdiff);
			$ends_string = $MSG['MON_0' . $month] . ' ' . gmdate('d, Y H:i', $Auction['ends'] + $system->tdiff);
			$Auction['current_bid'] = $Auction['buy_now'];
			include $include_path . 'email_endauction_youwin_nodutch.php';

			if ($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0)
			{
				$_SESSION['auction_id'] = $auction_id;
				header('location: pay.php?a=6');
				exit;
			}
		}

		$buy_done = 1;
	}
}

$additional_shipping = $Auction['additional_shipping_cost'] * ($qty - 1);
$shipping_cost = ($shipping == 1) ? ($Auction['shipping_cost'] + $additional_shipping) : 0;
$BN_total = ($Auction['bid'] * $qty) + $shipping_cost;

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $_REQUEST['id'],
		'TITLE' => $Auction['title'],
		'BN_PRICE' => $system->print_money($Auction['buy_now']),
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
?>