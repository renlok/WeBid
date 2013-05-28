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

if (!defined('InWeBid')) exit();

function printLog($str)
{
	global $system;

	if (defined('LogCron') && LogCron == true)
	{
		$system->log('cron', $str);
	}
}

function printLogL($str, $level)
{
	for ($i = 1; $i <= $level; ++$i)
		$str = "\t" . $str;
	printLog($str);
}

function constructCategories()
{
	global $DBPrefix, $system;

	$query = "SELECT cat_id, parent_id, sub_counter, counter
			 FROM " . $DBPrefix . "categories ORDER BY cat_id";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	while ($row = mysql_fetch_array($res))
	{
		$row['updated'] = false;
		$categories[$row['cat_id']] = $row;
	}
	return $categories;
}

function sendWatchEmails($id)
{
	global $DBPrefix, $system;

	$query = "SELECT name, email, item_watch, id FROM " . $DBPrefix . "users WHERE item_watch LIKE '% " . $id . " %'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	while ($watchusers = mysql_fetch_array($res))
	{
		$keys = explode(' ', $watchusers['item_watch']);
		// If keyword matches with opened auction title or/and desc send user a mail
		if (in_array($id, $keys))
		{
			$emailer = new email_handler();
			$emailer->assign_vars(array(
					'URL' => $system->SETTINGS['siteurl'] . 'item.php?mode=1&id=' . $id,
					'TITLE' => $Auction['title'],
					'NAME' => $watchusers['name']
					));
			$emailer->email_uid = $watchusers['id'];
			$emailer->email_sender($watchusers['email'], 'auctionend_watchmail.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['471']);
		}
	}	
}

function sortFees()
{
	global $DBPrefix, $system, $Winner, $Seller, $Auction, $buyer_emails;
	global $endauc_fee, $buyer_fee, $buyer_fee_type, $bf_paid, $ff_paid;

	if ($system->SETTINGS['fee_type'] == 1 || $buyer_fee <= 0)
	{
		if ($buyer_fee_type == 'flat')
		{
			$fee_value = $buyer_fee;
		}
		else
		{
			$fee_value = ($buyer_fee / 100) * floatval($Auction['current_bid']);
		}
		// add balance & invoice
		$query = "UPDATE " . $DBPrefix . "users SET balance = balance - " . $buyer_fee . " WHERE id = " . $Winner['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
				(" . $Winner['id'] . ", " . $Auction['id'] . ", " . time() . ", " . $buyer_fee . ", " . $buyer_fee . ", 1)";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	else
	{
		$bf_paid = 0;
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = " . $Winner['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$buyer_emails[] = array(
			'name' => $Winner['name'],
			'email' => $Winner['email'],
			'uid' => $Winner['id'],
			'id' => $Auction['id'],
			'title' => $Auction['title']
			);
	}

	$fee_value = 0;
	for ($i = 0; $i < count($endauc_fee); $i++)
	{
		if ($Auction['current_bid'] >= $endauc_fee[$i]['fee_from'] && $Auction['current_bid'] <= $endauc_fee[$i]['fee_to'])
		{
			if ($endauc_fee[$i]['fee_type'] == 'flat')
			{
				$fee_value = $endauc_fee[$i]['value'];
			}
			else
			{
				$fee_value = ($endauc_fee[$i]['value'] / 100) * $Auction['current_bid'];
			}
		}
	}

	// insert final value fees
	if ($system->SETTINGS['fee_type'] == 1 || $fee_value <= 0)
	{
		// add balance & invoice
		$query = "UPDATE " . $DBPrefix . "users SET balance = balance - " . $fee_value . " WHERE id = " . $Seller['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES
				(" . $Seller['id'] . ", " . $Auction['id'] . ", " . time() . ", " . $fee_value . ", " . $fee_value . ", 1)";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	else
	{
		$ff_paid = 0;
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 5 WHERE id = " . $Seller['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$seller_emails[] = array(
			'name' => $Seller['name'],
			'email' => $Seller['email'],
			'uid' => $Seller['id'],
			'id' => $Auction['id'],
			'title' => $Auction['title']
			);
	}	
}
?>