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
include $include_path . 'datacheck.inc.php';

$NOW = time();
$id = intval($_REQUEST['id']);
$bid = $_POST['bid'];
$qty = (isset($_POST['qty'])) ? intval($_POST['qty']) : 1;
$bidder_id = $user->user_data['id'];
$bidding_ended = false;

if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'bid.php?id=' . $id;
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
	header('location: ' . $sslurl . 'bid.php?id=' . $id . '&bid=' . $bid . '&qty=' . $qty);
	exit;
}

function get_increment($val, $input_check = true)
{
	global $system, $DBPrefix;

	if ($input_check)
		$val = $system->input_money($val);
	$query = "SELECT increment FROM " . $DBPrefix . "increments 
			WHERE ((low <= " . $val . " AND high >= " . $val . ")
			OR (low < " . $val . " AND high < " . $val . ")) ORDER BY increment DESC";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$increment = mysql_result($res, 0, 'increment');
	return $increment;
}

function extend_auction($id, $ends)
{
	global $system, $DBPrefix;

	if ($system->SETTINGS['ae_status'] == 'y' && ($ends - $system->SETTINGS['ae_timebefore']) < time())
	{
		$query = "UPDATE " . $DBPrefix . "auctions SET ends = ends + " . $system->SETTINGS['ae_extend'] . " WHERE id = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
	}
}

// first check if valid auction ID passed
$query = "SELECT a.*, u.nick, u.email, u.id AS uId FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (a.user = u.id)
		WHERE a.id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
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

// check user entered a bid
if (empty($bid) && !isset($errmsg))
{
	$errmsg = $ERR_072;
}

// check the bid is valid
if (!$system->CheckMoney($bid) && !isset($errmsg))
{
	$errmsg = $ERR_058;
}

// reformat bid to valid number
$bid = $system->input_money($bid);

$Data = mysql_fetch_array($res);
$item_title = $Data['title'];
$item_id = $Data['id'];
$seller_name = $Data['nick']; 
$seller_email = $Data['email'];
$atype = $Data['auction_type'];
$aquantity = $Data['quantity'];
$minimum_bid = $Data['minimum_bid'];
$customincrement = $Data['increment'];
$current_bid = $Data['current_bid'];
$pict_url_plain = $Data['pict_url'];
$reserve = $Data['reserve_price'];
$c = $Data['ends'];
$cbid = ($current_bid == 0) ? $minimum_bid : $current_bid;

if (($Data['ends'] <= time() || $Data['closed'] == 1) && !isset($errmsg))
{
	$errmsg = $ERR_614;
}
if (($Data['starts'] > time()) && !isset($errmsg))
{
	$errmsg = $ERR_073;
}
if ($aquantity < $qty)
{
	$errmsg = $ERR_608;
}

$query = "SELECT bid, bidder FROM " . $DBPrefix . "bids WHERE auction = " . $id . " ORDER BY bid DESC, id DESC LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$high_bid = mysql_result($res, 0, 'bid');
	$WINNING_BIDDER = mysql_result($res, 0, 'bidder');
	$ARETHEREBIDS = ' | <a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $id . '&history=view#history">' . $MSG['105'] . '</a>';
}
else
{
	$high_bid = $current_bid;
}

if ($customincrement > 0)
{
	$increment = $customincrement;
}
else
{
	$increment = get_increment($high_bid, false);
}

if (ceil($high_bid) == 0 || $atype == 2)
{
	$next_bid = $minimum_bid;
}
else
{
	$next_bid = $high_bid + $increment;
}

$tmpmsg = CheckBidData();
if ($tmpmsg != 0 && !isset($errmsg))
{
	$errmsg = ${'ERR_' . $tmpmsg};
}

if (isset($_POST['action']) && !isset($errmsg))
{
	if ($system->SETTINGS['usersauth'] == 'y')
	{
		if (strlen($_POST['password']) == 0)
		{
			$errmsg = $ERR_004;
		}
		$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'] . " AND password = '" . md5($MD5_PREFIX . $_POST['password']) . "'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) == 0)
		{
			$errmsg = $ERR_611;
		}
	}
	$send_email = false;
	// make the bid
	if ($atype == 1 && !isset($errmsg)) // normal auction
	{
		if ($system->SETTINGS['proxy_bidding'] == 'n')
		{
			// is it the highest bid?
			if ($current_bid < $bid)
			{
				// did you outbid someone?
				$query = "SELECT u.id FROM " . $DBPrefix . "bids b, " . $DBPrefix . "users u WHERE b.auction = " . $id . " AND b.bidder = u.id and u.suspended = 0 ORDER BY bid DESC";
				$result = mysql_query($query);
				$system->check_mysql($result, $query, __LINE__, __FILE__);
				if (mysql_num_rows($res) == 0 || mysql_result($res, 0) != $bidder_id)
				{
					$send_email = true;
				}
				$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . $bid . ", num_bids = num_bids + 1 WHERE id = " . $id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// Also update bids table
				$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . $bid . ", '" . $NOW . "', " . $qty . ")";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				extend_auction($item_id, $c);
				$bidding_ended = true;
			}
		}
		elseif ($WINNING_BIDDER == $bidder_id)
		{
			$query = "SELECT bid FROM " . $DBPrefix . "proxybid p
					LEFT JOIN " . $DBPrefix . "users u ON (p.userid = u.id)
					WHERE userid = " . $user->user_data['id'] . " AND itemid = " . $id . " ORDER BY bid DESC";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				$WINNER_PROXYBID = mysql_result($res, 0, 'bid');
				if ($WINNER_PROXYBID >= $bid)
				{
					$errmsg = $ERR_040;
				}
				else
				{
					// Just update proxy_bid
					$query = "UPDATE " . $DBPrefix . "proxybid SET bid = " . floatval($bid) . "
							  WHERE userid = " . $user->user_data['id'] . "
							  AND itemid = " . $id . " AND bid = " . $WINNER_PROXYBID;
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

					if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
					{
						$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . floatval($reserve) . ", num_bids = num_bids + 1 WHERE id = " . $id;
						$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
						// Also update bids table
						$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . floatval($reserve) . ", '" . $NOW . "', " . $qty . ")";
						$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					}
					extend_auction($item_id, $c);
					$bidding_ended = true;
				}
			}
		}
		if (!$bidding_ended && !isset($errmsg) && $system->SETTINGS['proxy_bidding'] == 'y')
		{
			$query = "SELECT * FROM " . $DBPrefix . "proxybid p, " . $DBPrefix . "users u WHERE itemid = " . $id . " AND p.userid = u.id and u.suspended = 0 ORDER by bid DESC";
			$result = mysql_query($query);
			$system->check_mysql($result, $query, __LINE__, __FILE__);
			if (mysql_num_rows($result) == 0) // First bid
			{
				$query = "INSERT INTO " . $DBPrefix . "proxybid VALUES (" . intval($id) . "," . intval($bidder_id) . "," . floatval($bid) . ")";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

				if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
				{
					$next_bid = $reserve;
				}
				// Only updates current bid if it is a new bidder, not the current one
				$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . $next_bid . ", num_bids = num_bids + 1 WHERE id = " . $id;
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// Also update bids table
				$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . floatval($next_bid) . ", '" . $NOW . "', " . $qty . ")";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 1)";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}
			else // This is not the first bid
			{
				$proxy_bidder_id = mysql_result($result, 0, 'userid');
				$proxy_max_bid = mysql_result($result, 0, 'bid');

				if ($proxy_max_bid < $bid)
				{
					if ($proxy_bidder_id != $bidder_id)
					{
						$send_email = true;
					}
					$next_bid = $proxy_max_bid + $increment;
					if (($proxy_max_bid + $increment) > $bid)
					{
						$next_bid = $bid;
					}

					$query = "INSERT INTO " . $DBPrefix . "proxybid VALUES (" . $id . ", " . $bidder_id . ", " . floatval($bid) . ")";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

					if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
					{
						$next_bid = $reserve;
					}
					// Fake bid to maintain a coherent history
					if ($current_bid < $proxy_max_bid)
					{
						$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . "," . $proxy_bidder_id . "," . floatval($proxy_max_bid) . ",'" . $NOW . "'," . $qty . ")";
						$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
						$fakebids = 1;
					}
					else
					{
						$fakebids = 0;
					}
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . floatval($next_bid) . ", '" . $NOW . "', " . $qty . ")";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + (1 + " . $fakebids . "))";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . $next_bid . ", num_bids = (num_bids + 1 + " . $fakebids . ") WHERE id = " . $id;
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				if ($proxy_max_bid == $bid)
				{
					$cbid = $proxy_max_bid;
					$errmsg = $MSG['701'];
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . floatval($bid) . ", '" . $NOW . "', " . $qty . ")";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $proxy_bidder_id . ", " . floatval($cbid) . ", '" . $NOW . "', " . $qty . ")";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 2)";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . floatval($cbid) . ", num_bids = num_bids + 2 WHERE id = " . $id;
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					if ($customincrement == 0)
					{
						// get new increment
						$increment = get_increment($cbid);
					}
					else
					{
						$increment = $customincrement;
					}
					$next_bid = $cbid + $increment;
				}
				if ($proxy_max_bid > $bid)
				{
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . floatval($bid) . ", '" . $NOW . "', " . $qty . ")";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					if ($customincrement == 0)
					{
						// get new increment
						$increment = get_increment($bid);
					}
					else
					{
						$increment = $customincrement;
					}
					if ($bid + $increment - $proxy_max_bid >= 0)
					{
						$cbid = $proxy_max_bid;
					}
					else
					{
						$cbid = $bid + $increment;
					}
					$errmsg = $MSG['701'];
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $proxy_bidder_id . ", " . floatval($cbid) . ", '" . $NOW . "', " . $qty . ")";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 2)";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . floatval($cbid) . ", num_bids = num_bids + 2 WHERE id = " . $id;
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					if ($customincrement == 0)
					{
						// get new increment
						$increment = get_increment($cbid);
					}
					else
					{
						$increment = $customincrement;
					}
					$next_bid = $cbid + $increment;
				}
			}
			extend_auction($item_id, $c);
		}
	}
	elseif ($atype == 2 && !isset($errmsg)) // dutch auction
	{
		// If the bidder already bid on this auction there new bbid must be higher
		$query = "SELECT bid, quantity FROM " . $DBPrefix . "bids WHERE bidder = " . $bidder_id . " AND auction = " . $id . " ORDER BY bid DESC LIMIT 1";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) > 0)
		{
			$PREVIOUSBID = mysql_fetch_array($res);
			if (($bid * $qty) <= ($PREVIOUSBID['bid'] * $PREVIOUSBID['quantity']))
			{
				$errmsg = $ERR_059;
			}
		}
		if (!isset($errmsg))
		{
			$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, " . $id . ", " . $bidder_id . ", " . floatval($bid) . ", '" . $NOW . "', " . $qty . ")";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 1)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = " . floatval($bid) . ", num_bids = num_bids + 1 WHERE id = " . $id;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	// send emails where needed
	$query = "SELECT bidder, bid FROM " . $DBPrefix . "bids WHERE auction = " . $id . " ORDER BY bid DESC";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);

	if (mysql_num_rows($result) > 1)
	{
		$OldWinner_id = mysql_result($result, 1, 'bidder');
		$new_bid = $next_bid;
		$OldWinner_bid = $system->print_money($new_bid - $increment);

		$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $OldWinner_id;
		$result_old_winner = mysql_query($query);
		$system->check_mysql($result_old_winner, $query, __LINE__, __FILE__);

		$OldWinner_nick = mysql_result($result_old_winner, 0, 'nick');
		$OldWinner_name = mysql_result($result_old_winner, 0, 'name');
		$OldWinner_email = mysql_result($result_old_winner, 0, 'email');
	}
	// Update counters table with the new bid
	// Send notification if users keyword matches (Item Watch)
	$query = "SELECT id, email, name, item_watch FROM " . $DBPrefix . "users WHERE item_watch != '' AND  item_watch != NULL AND id != " . $bidder_id;
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);

	while ($row = mysql_fetch_assoc($result))
	{
		// If keyword matches with opened auction title or/and desc send user a mail
		if (strstr($row['item_watch'], $id) !== false)
		{
			// Get data about the auction
			$query = "SELECT title, current_bid FROM " . $DBPrefix . "auctions WHERE id = " . intval($id);
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$emailer = new email_handler();
			$emailer->assign_vars(array(
					'REALNAME' => $row['name'],
					'TITLE' => mysql_result($res, 0, 'title'),
					'BID' => $system->print_money(mysql_result($res, 0, 'current_bid'), false),
					'AUCTION_URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $id
					));
			$emailer->email_uid = $row['id'];
			$emailer->email_sender($row['email'], 'item_watch.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['472']);
		}
	}
	// End of Item watch
	if ($send_email)
	{
		$month = gmdate('m', $c + $system->tdiff);
		$ends_string = $MSG['MON_0' . $month] . ' ' . gmdate('d, Y H:i', $c + $system->tdiff);
		$new_bid = $system->print_money($next_bid);
		// Send e-mail message
		include $include_path . 'email_outbid.php';
	}

	if (defined('TrackUserIPs'))
	{
		// log auction bid IP
		$system->log('user', 'Bid on Item', $bidder_id, $id);
	}
	$template->assign_vars(array(
			'PAGE' => 2,
			'BID_HISTORY' => (isset($ARETHEREBIDS)) ? $ARETHEREBIDS : '',
			'ID' => $id,
			'BID' => $system->print_money($bid)
			));
}

if (!isset($_POST['action']) || isset($errmsg))
{
	// just set the needed template variables
	$template->assign_vars(array(
			'PAGE' => 1,
			'ERROR' => (isset($errmsg)) ? $errmsg : '',
			'BID_HISTORY' => (isset($ARETHEREBIDS)) ? $ARETHEREBIDS : '',
			'ID' => $id,
			'IMAGE' => (!empty($pict_url_plain)) ? '<img src="getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&fromfile=' . $uploaded_path . $id . '/' . $pict_url_plain . '" border="0" align="center">' : '&nbsp;',
			'TITLE' => $item_title,
			'CURRENT_BID' => $system->print_money($cbid),
			'ATYPE' => $atype,
			'BID' => $system->print_money_nosymbol($bid),
			'NEXT_BID' => $system->print_money($next_bid),
			'QTY' => $qty,
			'TQTY' => $aquantity,
			'AGREEMENT' => sprintf($MSG['25_0086'], $system->print_money($qty * $bid)),
			'CURRENCY' => $system->SETTINGS['currency'],

			'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')
			));
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'bid.tpl'
		));
$template->display('body');
include 'footer.php';
?>
