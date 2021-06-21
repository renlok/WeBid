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

$id = intval($_GET['id']);
$gparams = array();
$gparams[] = array(':id', $id, 'int');

if (isset($_POST['action']) && $_POST['action'] == 'purge')
{
	if (is_numeric($_POST['days']))
	{
		// Build date
		$DATE = time() - $_POST['days'] * 3600 * 24;
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE msgdate <= :msgdate AND boardid = :id";
		$params = $gparams;
		$params[] = array(':msgdate', $DATE, 'int');
		$db->query($query, $params);
		// Update counter
		$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "comm_messages WHERE boardid = :id";
		$db->query($query, $gparams);
		$message_count = $db->result('COUNTER');
		$query = "UPDATE " . $DBPrefix . "community SET messages = :message_count WHERE id = :id";
		$params = $gparams;
		$params[] = array(':message_count', $message_count, 'int');
		$db->query($query, $params);
	}
}

// Retrieve board name for breadcrumbs
$query = "SELECT name FROM " . $DBPrefix . "community WHERE id = :id";
$db->query($query, $gparams);
$board_name = $db->result('name');

// Retrieve board's messages from the database
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE boardid = :id";
$db->query($query, $gparams);

$bg = '';
while ($msg_data = $db->fetch())
{
	$template->assign_block_vars('msgs', array(
			'ID' => $msg_data['id'],
			'MESSAGE' => nl2br($msg_data['message']),
			'POSTED_BY' => $msg_data['username'],
			'POSTED_AT' => FormatDate($msg_data['msgdate']),
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->assign_vars(array(
		'BOARD_NAME' => $board_name,
		'ID' => $id
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'editmessages.tpl'
		));
$template->display('body');

include 'footer.php';
?>