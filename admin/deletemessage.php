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

define('InAdmin', 1);
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$msg = intval($_REQUEST['id']);
$board_id = intval($_REQUEST['board_id']);

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE id = " . $msg;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	// Update messages counter
	$query = "UPDATE " . $DBPrefix . "community SET messages = messages - 1 WHERE id = " . $board_id;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	header('location: editmessages.php?id=' . $board_id);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: editmessages.php?id=' . $board_id);
	exit;
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $msg,
		'MESSAGE' => sprintf($MSG['834'], $msg),
		'TYPE' => 1
		));

$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
?>