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

include 'includes/common.inc.php';
include $include_path . 'membertypes.inc.php';
foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}

if (!$user->logged_in)
{
	header('location: user_login.php');
	exit;
}

if ($user->user_data['suspended'] == 7)
{
	header('location: message.php');
	exit;
}

if (!$user->can_buy)
{
	header('location: user_menu.php');
	exit;
}

if ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
{
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
	header('location: ' . $sslurl . 'buy_now.php');
	exit;
}

ksort($memtypesarr, SORT_NUMERIC);
$NOW = time();
$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = " . intval($_REQUEST['id']);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$Auction = mysql_fetch_assoc($res);

if ($Auction['closed'] == 1)
{
	header('location: item.php?id=' . $_REQUEST['id']);
	exit;
}

// If there are bids for this auction -> error
if ($Auction['bn_only'] == 'n')
{
	if (!($Auction['buy_now'] > 0 && ($Auction['num_bids'] == 0 || ($Auction['reserve_price'] > 0 && $Auction['current_bid'] < $Auction['reserve_price']) || ($Auction['current_bid'] < $Auction['buy_now']))))
	{
		$ERR = '712';
	}
	else
	{
		$query = "SELECT MAX(bid) AS maxbid FROM " . $DBPrefix . "proxybid WHERE itemid = " . intval($_REQUEST['id']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$maxbid = mysql_result($res, 0, 'maxbid');
		if (($maxbid > 0 && $maxbid >= $Auction['reserve_price']))
		{
			$ERR = '712';
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

if ($_GET['action'] == 'buy')
{
	if ($system->SETTINGS['usersauth'] == 'y')
	{
		// check if password entered
		if (strlen($_POST['password']) == 0)
		{
			$ERR = '610';
		}
		// check if password is correct
		if ($user->user_data['password'] != md5($MD5_PREFIX . $_POST['password']))
		{
			$ERR = '611';
		}
		else
		{
			if ($user->user_data['suspended'] > 0)
			{
				$ERR = '618';
			}
		}
	}
	// check if buyer is not the seller
	if ($user->user_data['id'] == $Auction['user'])
	{
		$ERR = '711';
	}
	// perform final actions
	if (isset($ERR))
	{
		$TPL_errmsg = ${'ERR_' . $ERR} ;
	}

	if (empty($ERR))
	{
		$query = "INSERT INTO " . $DBPrefix . "bids VALUES
				(NULL, " . intval($_REQUEST['id']) . ", " . intval($user->user_data['id']) . ", " . floatval($Auction['buy_now']) . ", '" . $NOW . "', 1)";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		if ($Auction['quantity'] == 1)
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET ends = '" . $NOW . "', num_bids = num_bids + 1, current_bid = " . floatval($Auction['buy_now']) . "
					WHERE id = " . intval($_REQUEST['id']);
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
			$query = "UPDATE " . $DBPrefix . "auctions SET quantity = quantity - 1 WHERE id = " . intval($_REQUEST['id']);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// do stuff that is important
			$query = "SELECT id, name, email FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$Winner = mysql_fetch_assoc($res);

			$query = "INSERT INTO " . $DBPrefix . "winners VALUES
					(NULL, " . intval($_REQUEST['id']) . ", " . $Auction['user'] . ", " . $Winner['id'] . ", " . $Auction['buy_now'] . ", '" . $NOW . "', 0, 0, 1, 0)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// get end string
			$month = gmdate('m', $Auction['ends'] + $system->tdiff);
			$ends_string = $MSG['MON_0' . $month] . ' ' . gmdate('d, Y H:i', $Auction['ends'] + $system->tdiff);
			$Auction['current_bid'] = $Auction['buy_now'];
			include $include_path . 'endauction_youwin_nodutch.inc.php';
		}

		$buy_done = 1;
	}
}

$template->assign_vars(array(
		'ERROR' => (isset($TPL_errmsg)) ? $TPL_errmsg : '',
		'ID' => $_REQUEST['id'],
		'TITLE' => $Auction['title'],
		'BN_PRICE' => $system->print_money($Auction['buy_now']),
		'SELLER' => ' <a href="profile.php?user_id=' . $Auction['user'] . '"><b>' . $Seller['nick'] . '</b></a>',
		'SELLERNUMFBS' => '<b>(' . $total_rate . ')</b>',
		'FBICON' => $TPL_rate_radio,

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