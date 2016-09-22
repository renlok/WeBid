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

// Delete boards
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		$query = "DELETE FROM " . $DBPrefix . "community WHERE id = :id";
		$params = array(array(':id', $v, 'int'));
		$db->query($query, $params);
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE boardid = :id";
		$params = array(array(':id', $v, 'int'));
		$db->query($query, $params);
	}

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['5044']));
}

// get list of boards
$query = "SELECT * FROM " . $DBPrefix . "community ORDER BY name";
$db->direct_query($query);
while ($row = $db->fetch())
{
	$template->assign_block_vars('boards', array(
			'ID' => $row['id'],
			'NAME' => $row['name'],
			'ACTIVE' => $row['active'],
			'MSGTOSHOW' => $row['msgstoshow'],
			'MSGCOUNT' => $row['messages']
			));
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'boards.tpl'
		));
$template->display('body');

include 'footer.php';
?>