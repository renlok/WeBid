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
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

// Data check
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
	$auc_id = intval($_POST['id']);

	// get auction data
	$query = "SELECT category, num_bids, suspended, closed FROM " . $DBPrefix . "auctions WHERE id = " . $auc_id;
	$db->direct_query($query);
	$auc_data = $db->result();

	// Delete related values
	$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = " . $auc_id;
	$db->direct_query($query);

	// delete bids
	$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = " . $auc_id;
	$db->direct_query($query);

	// Delete proxybids
	$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = " . $auc_id;
	$db->direct_query($query);

	// Delete file in counters
	$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = " . $auc_id;
	$db->direct_query($query);

	if ($auc_data['suspended'] == 0 && $auc_data['closed'] == 0)
	{
		// update main counters
		$query = "UPDATE " . $DBPrefix . "counters SET auctions = (auctions - 1), bids = (bids - " . $auc_data['num_bids'] . ")";
		$db->direct_query($query);

		// update recursive categories
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $auc_data['category'];
		$db->direct_query($query);
		$parent_node = $db->result();
		$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

		for ($i = 0; $i < count($crumbs); $i++)
		{
			$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
			$db->direct_query($query);
		}
	}

	// Delete auctions images
	if ($dir = @opendir($upload_path . $auc_id))
	{
		while ($file = readdir($dir))
		{
			if ($file != '.' && $file != '..')
			{
				@unlink($upload_path . $auc_id . '/' . $file);
			}
		}
		closedir($dir);
		@rmdir($upload_path . $auc_id);
	}

	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = " . $_GET['id'];
$db->direct_query($query);
$title = $db->result('title');

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $_GET['id'],
		'MESSAGE' => sprintf($MSG['833'], $title),
		'TYPE' => 1
		));

$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
?>