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
$current_page = 'users';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);
$edit = false;

if (isset($_GET['action']) && !isset($_POST['action']))
{
	if ($_GET['action'] == 'edit' && isset($_GET['id']))
	{
		$query = "SELECT * FROM ". $DBPrefix . "groups WHERE id = :groupid";
		$params = array();
		$params[] = array(':groupid', $_GET['id'], 'int');
		$db->query($query, $params);
		$group = $db->result();
		$template->assign_vars(array(
				'GROUP_ID' => $group['id'],
				'EDIT_NAME' => $group['group_name'],
				'CAN_SELL_Y' => ($group['can_sell'] == 1) ? 'selected="true"' : '',
				'CAN_SELL_N' => ($group['can_sell'] == 0) ? 'selected="true"' : '',
				'CAN_BUY_Y' => ($group['can_buy'] == 1) ? 'selected="true"' : '',
				'CAN_BUY_N' => ($group['can_buy'] == 0) ? 'selected="true"' : '',
				'AUTO_JOIN_Y' => ($group['auto_join'] == 1) ? 'selected="true"' : '',
				'AUTO_JOIN_N' => ($group['auto_join'] == 0) ? 'selected="true"' : '',
				'USER_COUNT' => $group['count']
				));
		$edit = true;
	}
	if ($_GET['action'] == 'new')
	{
		$template->assign_vars(array(
				'USER_COUNT' => 0
				));
		$edit = true;
	}
}

if (isset($_POST['action']))
{
	$auto_join = true;
	// check other groups are auto-join as every user needs a group
	if ($_POST['auto_join'] == 0)
	{
		$query = "SELECT * FROM ". $DBPrefix . "groups WHERE auto_join = 1";
		$db->direct_query($query);
		$auto_join = false;
		while ($row = $db->fetch())
		{
			if ($row['id'] != $_POST['id'])
			{
				$auto_join = true;
			}
		}
		$ERR = $ERR_050;
	}
	if ($_GET['action'] == 'edit' || is_numeric($_GET['id']))
	{
		$query = "UPDATE ". $DBPrefix . "groups SET
				group_name = :group_name,
				count = :count,
				can_sell = :can_sell,
				can_buy = :can_buy,
				auto_join = :auto_join
				WHERE id = :group_id";
		$params = array();
		$params[] = array(':group_name', $system->cleanvars($_POST['group_name']), 'str');
		$params[] = array(':count', $_POST['user_count'], 'int');
		$params[] = array(':can_sell', $_POST['can_sell'], 'int');
		$params[] = array(':can_buy', $_POST['can_buy'], 'int');
		$params[] = array(':auto_join', (($auto_join) ? $_POST['auto_join'] : 1), 'int');
		$params[] = array(':group_id', $_POST['id'], 'int');
		$db->query($query, $params);
	}
	if ($_GET['action'] == 'new' || empty($_GET['id']))
	{
		$query = "INSERT INTO ". $DBPrefix . "groups (group_name, count, can_sell, can_buy, auto_join) VALUES
				(:group_name, :count, :can_sell, :can_buy, :auto_join)";
		$params = array();
		$params[] = array(':group_name', $system->cleanvars($_POST['group_name']), 'str');
		$params[] = array(':count', $_POST['user_count'], 'int');
		$params[] = array(':can_sell', $_POST['can_sell'], 'int');
		$params[] = array(':can_buy', $_POST['can_buy'], 'int');
		$params[] = array(':auto_join', (($auto_join) ? $_POST['auto_join'] : 1), 'int');
		$db->query($query, $params);
	}
}

$query = "SELECT * FROM ". $DBPrefix . "groups";
$db->direct_query($query);

while ($row = $db->fetch())
{
	$template->assign_block_vars('groups', array(
			'ID' => $row['id'],
			'NAME' => $row['group_name'],
			'CAN_SELL' => ($row['can_sell'] == 1) ? $MSG['030'] : $MSG['029'],
			'CAN_BUY' => ($row['can_buy'] == 1) ? $MSG['030'] : $MSG['029'],
			'AUTO_JOIN' => ($row['auto_join'] == 1) ? $MSG['030'] : $MSG['029'],
			'USER_COUNT' => $row['count']
			));
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'B_EDIT' => $edit
		));

$template->set_filenames(array(
		'body' => 'usergroups.tpl'
		));
$template->display('body');
?>