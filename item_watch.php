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
include $include_path . 'browseitems.inc.php';
include $include_path . 'dates.inc.php';

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
	$match = strstr($items, $add_id);

	if (!$match)
	{
		$item_watch = trim($items . ' ' . $add_id);
		$item_watch_new = trim($item_watch);
		$query = "UPDATE " . $DBPrefix . "users SET item_watch = '" . $item_watch_new . "' WHERE id = " . $user->user_data['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$user->user_data['item_watch'] = $item_watch_new;
	}
}

// Delete item form item watch
if (isset($_GET['delete']) && !empty($_GET['delete']))
{
	$items = trim($user->user_data['item_watch']);
	$auc_id = split(' ', $items);
	for ($j = 0; $j < count($auc_id); $j++)
	{
		$match = strstr($auc_id[$j], $_GET['delete']);
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
	$query = "UPDATE " . $DBPrefix . "users SET item_watch = '" . $item_watch_new . "' WHERE id = " . $user->user_data['id'];
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$user->user_data['item_watch'] = $item_watch_new;
}

// Show results
$items = trim($user->user_data['item_watch']);

if ($items != '' && $items != null)
{
	$item = split(' ', $items);
	$itemids = '0';
	$total = count($item);
	for ($j = 0; $j < $total; $j++)
	{
		$itemids .= ',' . $item[$j];
	}
	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id IN ($itemids)";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	if (mysql_num_rows($result) > 0)
	{
		browseItems($result, false, $total, 'item_watch.php');
	}
}

include 'header.php';
$TMP_usmenutitle = $MSG['472'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'item_watch.tpl'
		));
$template->display('body');
include 'footer.php';
?>
