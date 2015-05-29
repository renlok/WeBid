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

define('InAdmin', 1);
$current_page = 'auctions';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . 'language/' . $language . '/categories.inc.php';

if (!isset($_REQUEST['id']))
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$catscontrol = new MPTTcategories();
	$id = intval($_POST['id']);

	// get auction data
	$query = "SELECT category, closed, suspended FROM " . $DBPrefix . "auctions WHERE id = " . $id;
	$db->direct_query($query);
	$auc_data = $db->fetch();

	if ($auc_data['suspended'] > 0)
	{
		// update auction table
		$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 0 WHERE id = " . $id;
		$db->direct_query($query);

		if ($auc_data['closed'] == 1)
		{
			$query = "UPDATE " . $DBPrefix . "counters SET suspendedauctions = (suspendedauctions - 1), closedauctions = (closedauctions + 1)";
			$db->direct_query($query);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "counters SET suspendedauctions = (suspendedauctions - 1), auctions = (auctions + 1)";
			$db->direct_query($query);

			// update recursive categories
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $auc_data['category'];
			$db->direct_query($query);
			$parent_node = $db->fetch();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
				$db->direct_query($query);
			}
		}
	}
	else
	{
		// suspend auction
		$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 1 WHERE id = " . $id;
		$db->direct_query($query);

		if ($auc_data['closed'] == 1)
		{
			$query ="UPDATE " . $DBPrefix . "counters SET suspendedauctions = (suspendedauctions + 1), closedauctions = (closedauctions - 1)";
			$db->direct_query($query);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "counters SET suspendedauctions = (suspendedauctions + 1), auctions = (auctions - 1)";
			$db->direct_query($query);

			// update recursive categories
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $auc_data['category'];
			$db->direct_query($query);
			$parent_node = $db->fetch();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
				$db->direct_query($query);
			}
		}
	}

	$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$query = "SELECT u.nick, a.title, a.starts, a.description, a.category, d.description as duration,
		a.suspended, a.current_bid, a.quantity, a.reserve_price
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "durations d ON (d.days = a.duration)
		WHERE a.id = " . $_GET['id'];
$db->direct_query($query);
$auc_data = $db->fetch();

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$date = date('m/d/Y', $auc_data['starts'] + $system->tdiff);
}
else
{
	$date = date('d/m/Y', $auc_data['starts'] + $system->tdiff);
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'PAGE_TITLE' => ($auc_data['suspended'] > 0) ? $MSG['322'] : $MSG['321'],
		'ID' => $_GET['id'],
		'TITLE' => $auc_data['title'],
		'NICK' => $auc_data['nick'],
		'STARTS' => $date,
		'DURATION' => $auc_data['duration'],
		'CATEGORY' => $category_names[$auc_data['category']],
		'DESCRIPTION' => stripslashes($auc_data['description']),
		'CURRENT_BID' => $system->print_money($auc_data['current_bid']),
		'QTY' => $auc_data['quantity'],
		'RESERVE_PRICE' => $system->print_money($auc_data['reserve_price']),
		'SUSPENDED' => $auc_data['suspended'],
		'OFFSET' => $_REQUEST['offset']
		));

$template->set_filenames(array(
		'body' => 'excludeauction.tpl'
		));
$template->display('body');
?>
