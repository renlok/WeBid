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

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$id = intval($_REQUEST['id']);

// Data check
if (empty($id) || $id <= 0)
{
	header('location: listusers.php?PAGE=' . intval($_REQUEST['offset']));
	exit;
}

$has_auctions = false;
$has_bids = false;
if (isset($_POST['action']) && $_POST['action'] == "Yes")
{
	$catscontrol = new MPTTcategories();

	// Check if the users has some auction
	$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE user = :user_id";
	$params = array();
	$params[] = array(':user_id', $id, 'int');
	$db->query($query, $params);
	$num_auctions = $db->result('COUNT');

	if ($num_auctions > 0)
	{
		$has_auctions = true;
	}

	// Check if the user is BIDDER in some auction
	$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "bids WHERE bidder = :user_id";
	$params = array();
	$params[] = array(':user_id', $id, 'int');
	$db->query($query, $params);
	$num_bids = $db->result('COUNT');

	if ($num_bids > 0)
	{
		$has_bids = true;
	}

	// check if user is suspended or not
	$query = "SELECT suspended FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $id, 'int');
	$db->query($query, $params);
	$suspended = $db->result('suspended');

	// delete user
	$query = "DELETE FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $id, 'int');
	$db->query($query, $params);

	if ($has_auctions)
	{
		// update categories table
		$query = "SELECT c.level, c.left_id, c.right_id FROM " . $DBPrefix . "auctions a
				LEFT JOIN " . $DBPrefix . "categories c ON (a.category = c.cat_id)
				WHERE a.user = :user_id";
		$params = array();
		$params[] = array(':user_id', $id, 'int');
		$db->query($query, $params);
		$auction_data = $db->fetchall();
		foreach ($auction_data as $row)
		{
			$crumbs = $catscontrol->get_bread_crumbs($row['left_id'], $row['right_id']);
			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
		}

		// delete user's auctions
		$query = "DELETE FROM " . $DBPrefix . "auctions WHERE user = :user_id";
		$params = array();
		$params[] = array(':user_id', $id, 'int');
		$db->query($query, $params);
	}

	if ($has_bids)
	{
		// update auctions table
		$query = "SELECT a.id, a.current_bid, b.bid FROM " . $DBPrefix . "bids b
				LEFT JOIN " . $DBPrefix . "auctions a ON (b.auction = a.id)
				WHERE b.bidder = :user_id ORDER BY b.bid DESC";
		$params = array();
		$params[] = array(':user_id', $id, 'int');
		$db->query($query, $params);
		$bid_data = $db->fetchall();
		foreach ($bid_data as $row)
		{
			$params = array();
			// check if user is highest bidder
			if ($row['current_bid'] == $row['bid'])
			{
				$query = "SELECT bid FROM " . $DBPrefix . "bids WHERE auction = :auc_id ORDER BY bid DESC LIMIT 1, 1";
				$params[] = array(':auc_id', $row['id'], 'int');
				$db->query($query, $params);
				$next_bid = $db->result('bid');
				// set new highest bid
				$params = array();
				$extra = ", current_bid = :next_bid, current_bid_id = :current_bid_id";
				$params[] = array(':next_bid', $next_bid, 'float');
				$params[] = array(':current_bid_id', $row['id'], 'int');
			}
			$query = "UPDATE " . $DBPrefix . "auctions SET num_bids = num_bids - 1" . $extra . " WHERE id = :auc_id";
			$params[] = array(':auc_id', $row['id'], 'int');
			$db->query($query, $params);
		}

		// delete bids
		$query = "DELETE FROM " . $DBPrefix . "bids WHERE bidder = :user_id";
		$params = array();
		$params[] = array(':user_id', $id, 'int');
		$db->query($query, $params);
	}

	// Update user counters
	if ($suspended == 0)
	{
		$query = "UPDATE " . $DBPrefix . "counters set users = users - 1, bids = bids - :num_bids, auctions = auctions - :num_auctions";
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "counters set inactiveusers = inactiveusers - 1, bids = bids - :num_bids, auctions = auctions - :num_auctions";
	}
	$params = array();
	$params[] = array(':num_bids', $num_bids, 'int');
	$params[] = array(':num_auctions', $num_auctions, 'int');
	$db->query($query, $params);

	header('location: listusers.php');
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == "No")
{
	header('location: listusers.php');
	exit;
}

// Check if the users has some auction
$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE user = :user_id";
$params = array();
$params[] = array(':user_id', $id, 'int');
$db->query($query, $params);
$num_auctions = $db->result('COUNT');

if ($num_auctions > 0)
{
	$error_message = $MSG['420'];
	$i = 0;
	while ($row = $db->fetch())
	{
		if ($i >= 10)
			break;
		$has_auctions = true;
		$error_message .= $row['id'] . ' - <a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['id'] . '" target="_blank">' . $row['title'] . '</a><br>';
		$i++;
	}
	if ($num_auctions != $i)
	{
		$error_message .= '<p>' . sprintf($MSG['568'], $num_auctions - $i) . '</p>';
	}

	$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $error_message));
}

// Check if the user is BIDDER in some auction
$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "bids WHERE bidder = :user_id";
$params = array();
$params[] = array(':user_id', $id, 'int');
$db->query($query, $params);
$num_bids = $db->result('COUNT');

if ($num_bids > 0)
{
	$has_bids = true;

	$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => sprintf($MSG['421'], $num_bids)));
}

$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $id, 'int');
$db->query($query, $params);
$username = $db->result('nick');

$template->assign_vars(array(
		'ID' => $id,
		'MESSAGE' => sprintf($MSG['835'], $username),
		'TYPE' => 1
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');

include 'footer.php';
?>
