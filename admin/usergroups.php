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

$edit = false;
$can_delete = false;

if (isset($_GET['action']) && !isset($_POST['action']))
{
	if ($_GET['action'] == 'edit' && isset($_GET['id']))
	{
		$query = "SELECT * FROM ". $DBPrefix . "groups WHERE id = :groupid";
		$params = array();
		$params[] = array(':groupid', $_GET['id'], 'int');
		$db->query($query, $params);
		$group = $db->result();

		$can_delete = ($group['auto_join'] == 0);

		$template->assign_vars(array(
				'GROUP_ID' => $group['id'],
				'EDIT_NAME' => $group['group_name'],
				'CAN_SELL_Y' => ($group['can_sell'] == 1) ? 'selected="true"' : '',
				'CAN_SELL_N' => ($group['can_sell'] == 0) ? 'selected="true"' : '',
				'CAN_BUY_Y' => ($group['can_buy'] == 1) ? 'selected="true"' : '',
				'CAN_BUY_N' => ($group['can_buy'] == 0) ? 'selected="true"' : '',
				'AUTO_JOIN_Y' => ($group['auto_join'] == 1) ? 'selected="true"' : '',
				'AUTO_JOIN_N' => ($group['auto_join'] == 0) ? 'selected="true"' : '',
				'USER_COUNT' => $group['count'],
				'NOT_DEFAULT_GROUP' => $can_delete
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
		$query = "SELECT id FROM ". $DBPrefix . "groups WHERE auto_join = 1";
		$db->direct_query($query);
		$auto_join = false;
		while ($row = $db->fetch())
		{
			if ($row['id'] != $_POST['id'])
			{
				$auto_join = true;
			}
		}
		if (!$auto_join)
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_050));
		}
	}
	if (($_GET['action'] == 'edit' || (isset($_GET['id']) && is_numeric($_GET['id']))) && !isset($ERR))
	{
		if ($_GET['action'] == 'edit' && isset($_POST['remove']))
		{
			// prevent removal of webid default Group 1 or Group 2
			if(intval($_POST['id']) == 1 || intval($_POST['id']) == 2)
			{
				$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['cannot_delete_default_user_groups']));
			}
			else
			{
				$query = "DELETE FROM " . $DBPrefix . "groups WHERE id = :group_id";
				$params = array();
				$params[] = array(':group_id', $_POST['id'], 'int');
				$db->query($query, $params);
				$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['user_group_deleted']));
			}
		}
		else
		{
			if (empty($_POST['group_name']))
			{
				$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['user_group_name_empty_update']));
			}
			else
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
		}
	}
	if ($_GET['action'] == 'new' || empty($_GET['id']))
	{
		if (empty($_POST['group_name']))
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['user_group_name_empty_new']));
		}
		else
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
}

$groups_array = array();
$groups_unknown = array();
$query = "SELECT groups, id, nick FROM ". $DBPrefix . "users";
$db->direct_query($query);

while ($row = $db->fetch())
{
	if (!empty($row['groups']))
	{
		$exploded_groups = explode(',', $row['groups']);
		foreach ($exploded_groups as $group_id)
		{
			if (!isset($groups_array[$group_id]))
			{
				$groups_array[$group_id] = 1;
			}
			else
			{
				$groups_array[$group_id]++;
			}
		}
	}
	else
	{
		$groups_unknown[] = $row;
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
			'USER_COUNT' => isset($groups_array[$row['id']]) ? $groups_array[$row['id']] : 0 // $row['count']
			));
	unset($groups_array[$row['id']]);
	// TODO: automatically control user group count when users join/leave groups
}

// non assigned users
if (!empty($groups_unknown))
{
	$template->assign_block_vars('groups_unknown', array(
			'ID' => $MSG['empty_line'],
			'NAME' => $MSG['empty_line'],
			'USER_COUNT' => !empty($groups_array['unknown']) ? $groups_array['unknown']  : 0
			));

	foreach ($groups_unknown as $k => $v)
	{
		$template->assign_block_vars('groups_unknown.list_users', array(
				'ID' =>  $v['id'],
				'NAME' => $v['nick'],
				'TYPE' => 1
				));
	}
}

// assigned to non existstant groups
if (!empty($groups_array))
{
	foreach ($groups_array as $k => $v)
	{
		$template->assign_block_vars('groups_unknown', array(
				'ID' => $k,
				'NAME' => $MSG['text_unknown'],
				'USER_COUNT' => $v
				));
		$query = "SELECT groups, id, nick FROM ". $DBPrefix . "users WHERE groups LIKE :group_name";
		$params = array();
		$params[] = array(':group_name', '%' . $k . '%', 'str');
		$db->query($query, $params);
		// TODO: automatically remove users from groups when the group is deleted

		while ($row = $db->fetch())
		{
			$template->assign_block_vars('groups_unknown.list_users', array(
					'ID' =>  $row['id'],
					'NAME' => $row['nick'],
					'TYPE' => 2
					));
		}
	}
}

$template->assign_vars(array(
		'GROUPS_UNKNOWN' => (count($groups_unknown) > 0),
		'B_EDIT' => $edit,
		'NOT_DEFAULT_GROUP' => $can_delete
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'usergroups.tpl'
		));
$template->display('body');
include 'footer.php';
?>
