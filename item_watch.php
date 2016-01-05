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
include $include_path . 'browseitems.inc.php';

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	header("location: user_login.php");
	exit;
}

// Auction id is present, now update table
if (isset($_GET['add']) && !empty($_GET['add']))
{
	$add_id = intval($_GET['add']);
	// Check if this item is not already added
	$items = trim($user->user_data['item_watch']);
	$match = strstr($items, strval($add_id));

	if (!$match)
	{
		$item_watch = trim($items . ' ' . $add_id);
		$item_watch_new = trim($item_watch);
		$query = "UPDATE " . $DBPrefix . "users SET item_watch = :item_watch_new WHERE id = :user_id";
		$params = array();
		$params[] = array(':item_watch_new', $system->cleanvars($item_watch_new), 'str');
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$db->query($query, $params);
		$user->user_data['item_watch'] = $item_watch_new;
	}
}

// Delete item form item watch
if (isset($_GET['delete']) && !empty($_GET['delete']))
{
	$items = trim($user->user_data['item_watch']);
	$auc_id = explode(' ', $items);
	for ($j = 0; $j < count($auc_id); $j++)
	{
		$match = strstr($auc_id[$j], strval($_GET['delete']));
		if ($match)
		{
			$item_watch = $item_watch;
		}
		else
		{
			$item_watch = $auc_id[$j] . ' ' . $item_watch;
		}
	}
	$item_watch_new = trim($item_watch);
	$query = "UPDATE " . $DBPrefix . "users SET item_watch = :item_watch_new WHERE id = :user_id";
	$params = array();
	$params[] = array(':item_watch_new', $system->cleanvars($item_watch_new), 'str');
	$params[] = array(':user_id', $user->user_data['id'], 'int');
	$db->query($query, $params);
	$user->user_data['item_watch'] = $item_watch_new;
}

// Show results
$items = trim($user->user_data['item_watch']);

if ($items != '' && $items != null)
{
	$item = explode(' ', $items);
	$itemids = '0';
	$total = count($item);
	for ($j = 0; $j < $total; $j++)
	{
		$itemids .= ',' . $item[$j];
	}
	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id IN (" . $itemids . ")";
	$db->direct_query($query);
	$total = $db->numrows();
	browseItems($query, $params, '', '', $total, 'item_watch.php');
}

include 'header.php';
$TMP_usmenutitle = $MSG['472'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'item_watch.tpl'
		));
$template->display('body');
include 'footer.php';
