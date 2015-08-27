<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
// reformat bid to valid number
$bid = round($system->input_money($_POST['bid']), 2);
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
	global $db, $DBPrefix, $system;

	if ($input_check)
		$val = $system->input_money($val);
	// get the increment value for the current bid
	$query = "SELECT increment FROM " . $DBPrefix . "increments 
			WHERE low <= :val AND high >= :val
			ORDER BY increment DESC";
	$params = array();
	$params[] = array(':val', $val, 'float');
	$db->query($query, $params);
	$increment = $db->result('increment');
	return $increment;
}

function extend_auction($id, $ends)
{
	global $system, $db, $DBPrefix;

	if ($system->SETTINGS['ae_status'] == 'y' && ($ends - $system->SETTINGS['ae_timebefore']) < time())
	{
		$query = "UPDATE " . $DBPrefix . "auctions SET ends = ends + :ae_extend WHERE id = :auc_id";
		$params = array();
		$params[] = array(':ae_extend', $system->SETTINGS['ae_extend'], 'int');
		$params[] = array(':auc_id', $id, 'int');
		$db->query($query, $params);
	}
}

// first check if valid auction ID passed
$query = "SELECT a.*, u.nick, u.email, u.id AS uId FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (a.user = u.id)
		WHERE a.id = :auc_id";
$params = array();
$params[] = array(':auc_id', $id, 'int');
$db->query($query, $params);
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

$Data = $db->result();
$item_title = $system->uncleanvars($Data['title']);
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

$query = "SELECT bid, bidder FROM " . $DBPrefix . "bids WHERE auction = :auc_id ORDER BY bid DESC, id DESC LIMIT 1";
$params = array();
$params[] = array(':auc_id', $id, 'int');
$db->query($query, $params);
if ($db->numrows() > 0)
{
	$high_bid = $db->result('bid');
	$WINNING_BIDDER = $db->result('bidder');
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
		include $include_path . 'PasswordHash.php';
		$phpass = new PasswordHash(8, false);		
		if (!($phpass->CheckPassword($_POST['password'], $user->user_data['password'])))
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
				$query = "SELECT u.id FROM " . $DBPrefix . "bids b, " . $DBPrefix . "users u WHERE b.auction = :auc_id AND b.bidder = u.id and u.suspended = 0 ORDER BY bid DESC";
				$params = array();
				$params[] = array(':auc_id', $id, 'int');
				$db->query($query, $params);
				// send outbid email if there are previous bidders and they where not you
				if ($db->numrows() > 0 && $db->result('id') != $bidder_id)
				{
					$send_email = true;
				}
				$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = num_bids + 1 WHERE id = :auc_id";
				$params = array();
				$params[] = array(':bid', $bid, 'float');
				$params[] = array(':auc_id', $id, 'int');
				$db->query($query, $params);
				// Also update bids table
				$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
				$params = array();
				$params[] = array(':bid', $bid, 'float');
				$params[] = array(':auc_id', $id, 'int');
				$params[] = array(':bidder_id', $bidder_id, 'int');
				$params[] = array(':time', $NOW, 'int');
				$params[] = array(':qty', $qty, 'int');
				$db->query($query, $params);
				extend_auction($item_id, $c);
				$bidding_ended = true;
			}
		}
		elseif ($WINNING_BIDDER == $bidder_id)
		{
			$query = "SELECT bid FROM " . $DBPrefix . "proxybid p
					LEFT JOIN " . $DBPrefix . "users u ON (p.userid = u.id)
					WHERE userid = :user_id AND itemid = :item_id ORDER BY bid DESC";
			$params = array();
			$params[] = array(':user_id', $user->user_data['id'], 'int');
			$params[] = array(':item_id', $id, 'int');
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$WINNER_PROXYBID = $db->result('bid');
				if ($WINNER_PROXYBID >= $bid)
				{
					$errmsg = $ERR_040;
				}
				else
				{
					// Just update proxy_bid
					$query = "UPDATE " . $DBPrefix . "proxybid SET bid = :newbid
							  WHERE userid = :user_id
							  AND itemid = :item_id AND bid = :oldbid";
					$params = array();
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$params[] = array(':item_id', $id, 'int');
					$params[] = array(':oldbid', $WINNER_PROXYBID, 'float');
					$params[] = array(':newbid', $bid, 'float');
					$db->query($query, $params);

					if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
					{
						$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :reserve, num_bids = num_bids + 1 WHERE id = :auc_id";
						$params = array();
						$params[] = array(':reserve', $reserve, 'float');
						$params[] = array(':auc_id', $id, 'int');
						$db->query($query, $params);
						// Also update bids table
						$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :reserve, :time, :qty)";
						$params = array();
						$params[] = array(':reserve', $reserve, 'float');
						$params[] = array(':auc_id', $id, 'int');
						$params[] = array(':bidder_id', $bidder_id, 'int');
						$params[] = array(':time', $NOW, 'int');
						$params[] = array(':qty', $qty, 'int');
						$db->query($query, $params);
					}
					extend_auction($item_id, $c);
					$bidding_ended = true;
				}
			}
		}
		if (!$bidding_ended && !isset($errmsg) && $system->SETTINGS['proxy_bidding'] == 'y')
		{
			$query = "SELECT p.userid, p.bid FROM " . $DBPrefix . "proxybid p, " . $DBPrefix . "users u WHERE itemid = :item_id AND p.userid = u.id and u.suspended = 0 ORDER by bid DESC LIMIT 1";
			$params = array();
			$params[] = array(':item_id', $id, 'int');
			$db->query($query, $params);
			if ($db->numrows() == 0) // First bid
			{
				$query = "INSERT INTO " . $DBPrefix . "proxybid VALUES (:auc_id, :bidder_id, :bid)";
				$params = array();
				$params[] = array(':auc_id', $id, 'int');
				$params[] = array(':bidder_id', $bidder_id, 'int');
				$params[] = array(':bid', $bid, 'float');
				$db->query($query, $params);

				if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
				{
					$next_bid = $reserve;
				}
				// Only updates current bid if it is a new bidder, not the current one
				$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = num_bids + 1 WHERE id = :auc_id";
				$params = array();
				$params[] = array(':auc_id', $id, 'int');
				$params[] = array(':bid', $next_bid, 'float');
				$db->query($query, $params);
				// Also update bids table
				$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
				$params = array();
				$params[] = array(':auc_id', $id, 'int');
				$params[] = array(':bidder_id', $bidder_id, 'int');
				$params[] = array(':bid', $next_bid, 'float');
				$params[] = array(':time', $NOW, 'int');
				$params[] = array(':qty', $qty, 'int');
				$db->query($query, $params);
				$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 1)";
				$db->direct_query($query);
			}
			else // This is not the first bid
			{
				$proxy_bid_data = $db->result();
				$proxy_bidder_id = $proxy_bid_data['userid'];
				$proxy_max_bid = $proxy_bid_data['bid'];

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

					$query = "INSERT INTO " . $DBPrefix . "proxybid VALUES (:auc_id, :bidder_id, :bid)";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bidder_id', $bidder_id, 'int');
					$params[] = array(':bid', $bid, 'float');
					$db->query($query, $params);

					if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
					{
						$next_bid = $reserve;
					}
					// Fake bid to maintain a coherent history
					if ($current_bid < $proxy_max_bid)
					{
						$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
						$params = array();
						$params[] = array(':auc_id', $id, 'int');
						$params[] = array(':bidder_id', $proxy_bidder_id, 'int');
						$params[] = array(':bid', $proxy_max_bid, 'float');
						$params[] = array(':time', $NOW, 'int');
						$params[] = array(':qty', $qty, 'int');
						$db->query($query, $params);
						$fakebids = 1;
					}
					else
					{
						$fakebids = 0;
					}
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bidder_id', $bidder_id, 'int');
					$params[] = array(':bid', $next_bid, 'float');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':qty', $qty, 'int');
					$db->query($query, $params);
					$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + (1 + :fakebids))";
					$params = array();
					$params[] = array(':fakebids', $fakebids, 'int');
					$db->query($query, $params);
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = (num_bids + 1 + :fakebids) WHERE id = :auc_id";
					$params = array();
					$params[] = array(':bid', $next_bid, 'float');
					$params[] = array(':fakebids', $fakebids, 'int');
					$params[] = array(':auc_id', $id, 'int');
					$db->query($query, $params);
				}
				elseif ($proxy_max_bid == $bid)
				{
					echo 0;
					$cbid = $proxy_max_bid;
					$errmsg = $MSG['701'];
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bidder_id', $bidder_id, 'int');
					$params[] = array(':bid', $bid, 'float');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':qty', $qty, 'int');
					$db->query($query, $params);
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bidder_id', $proxy_bidder_id, 'int');
					$params[] = array(':bid', $cbid, 'float');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':qty', $qty, 'int');
					$db->query($query, $params);
					$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 2)";
					$db->direct_query($query);
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = num_bids + 2 WHERE id = :auc_id";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bid', $cbid, 'float');
					$db->query($query, $params);
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
				elseif ($proxy_max_bid > $bid)
				{
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bidder_id', $bidder_id, 'int');
					$params[] = array(':bid', $bid, 'float');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':qty', $qty, 'int');
					$db->query($query, $params);
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
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bidder_id', $proxy_bidder_id, 'int');
					$params[] = array(':bid', $cbid, 'float');
					$params[] = array(':time', $NOW, 'int');
					$params[] = array(':qty', $qty, 'int');
					$db->query($query, $params);
					$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 2)";
					$db->direct_query($query);
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = num_bids + 2 WHERE id = :auc_id";
					$params = array();
					$params[] = array(':auc_id', $id, 'int');
					$params[] = array(':bid', $cbid, 'float');
					$db->query($query, $params);
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
		$query = "SELECT bid, quantity FROM " . $DBPrefix . "bids WHERE bidder = :bidder_id AND auction = :auc_id ORDER BY bid DESC LIMIT 1";
		$params = array();
		$params[] = array(':auc_id', $id, 'int');
		$params[] = array(':bidder_id', $bidder_id, 'int');
		$db->query($query, $params);
		if ($db->numrows() > 0)
		{
			$PREVIOUSBID = result();
			if (($bid * $qty) <= ($PREVIOUSBID['bid'] * $PREVIOUSBID['quantity']))
			{
				$errmsg = $ERR_059;
			}
		}
		if (!isset($errmsg))
		{
			$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
			$params = array();
			$params[] = array(':auc_id', $id, 'int');
			$params[] = array(':bidder_id', $bidder_id, 'int');
			$params[] = array(':bid', $bid, 'float');
			$params[] = array(':time', $NOW, 'int');
			$params[] = array(':qty', $qty, 'int');
			$db->query($query, $params);
			$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 1)";
			$db->direct_query($query);
			$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = num_bids + 1 WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $id, 'int');
			$params[] = array(':bid', $bid, 'float');
			$db->query($query, $params);
		}
	}
	// send emails where needed
	$query = "SELECT bidder, bid FROM " . $DBPrefix . "bids WHERE auction = :auc_id ORDER BY bid DESC";
	$params = array();
	$params[] = array(':auc_id', $id, 'int');
	$db->query($query, $params);

	// if there was a previous bidder tell them they have been outbid
	if ($db->numrows() > 1)
	{
		$OldWinner_id = $db->result('bidder');
		$new_bid = $next_bid;
		$OldWinner_bid = $system->print_money($new_bid - $increment);

		$query = "SELECT nick, name, email FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array();
		$params[] = array(':user_id', $OldWinner_id, 'int');
		$db->query($query, $params);
		$OldWinner = $db->result();

		$OldWinner_nick = $OldWinner['nick'];
		$OldWinner_name = $OldWinner['name'];
		$OldWinner_email = $OldWinner['email'];
	}
	// Update counters table with the new bid
	// Send notification if users keyword matches (Item Watch)
	$query = "SELECT id, email, name, item_watch FROM " . $DBPrefix . "users WHERE item_watch != '' AND item_watch IS NOT NULL AND id != :user_id";
	$params = array();
	$params[] = array(':user_id', $bidder_id, 'int');
	$db->query($query, $params);

	$fetch = $db->fetchall();
	foreach ($fetch as $row)
	{
		// If keyword matches with opened auction title or/and desc send user a mail
		if (strstr($row['item_watch'], strval($id)) !== false)
		{
			// Get data about the auction
			$query = "SELECT title, current_bid FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $id, 'int');
			$db->query($query, $params);
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
		$month = date('m', $c + $system->tdiff);
		$ends_string = $MSG['MON_0' . $month] . ' ' . date('d, Y H:i', $c + $system->tdiff);
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
			'TITLE' => $item_title,
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
