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
$current_page = 'contents';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
	}
	elseif (!is_numeric($_POST['msgstoshow']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5000));
	}
	elseif (intval($_POST['msgstoshow'] == 0))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5001));
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "community
					SET name = :name,
					msgstoshow = :msgstoshow,
					active = :active
					WHERE id = :id";
		$params = array();
		$params[] = array(':name', $system->cleanvars($_POST['name']), 'str');
		$params[] = array(':msgstoshow', $_POST['msgstoshow'], 'int');
		$params[] = array(':active', $_POST['active'], 'bool');
		$params[] = array(':id', $_POST['id'], 'int');
		$db->query($query, $params);
		header('location: boards.php');
		exit;
	}
}

$id = intval($_GET['id']);

// Retrieve board's data from the database
$query = "SELECT * FROM " . $DBPrefix . "community WHERE id = :id";
$params = array();
$params[] = array(':id', $id, 'int');
$db->query($query, $params);
$board_data = $db->result();

$template->assign_vars(array(
		'NAME' => $board_data['name'],
		'MESSAGES' => $board_data['messages'],
		'LAST_POST' => ($board_data['lastmessage'] > 0) ? FormatDate($board_data['lastmessage']) : '--',
		'MSGTOSHOW' => $board_data['msgstoshow'],

		'B_ACTIVE' => ($board_data['active'] == 1),
		'B_DEACTIVE' => ($board_data['active'] == 0),
		'ID' => $id
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'editboards.tpl'
		));
$template->display('body');

include 'footer.php';
?>
