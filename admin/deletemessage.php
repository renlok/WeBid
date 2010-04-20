<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$msg = intval($_REQUEST['msg']);
$board_id = intval($_REQUEST['id']);

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == 'delete')
{
	$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE id = " . $msg;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	// Update messages counter
	$query = "UPDATE " . $DBPrefix . "community SET messages = messages - 1 WHERE id = " . $board_id;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	header('location: editmessages.php?id=' . $board_id);
	exit;
}
else
{
	// Retrieve message from the database
	$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE id = " . $msg;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$data = mysql_fetch_assoc($res);
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'MESSAGE' => nl2br($data['message']),
		'USER' => ($data['user'] > 0) ? $data['username'] : $MSG['5061'],
		'POSTED' => FormatDate($data['msgdate']),
		'BOARD_ID' => $board_id,
		'MSG_ID' => $msg
		));

$template->set_filenames(array(
		'body' => 'deletemessage.tpl'
		));
$template->display('body');
?>