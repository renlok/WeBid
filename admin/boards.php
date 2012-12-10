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
$current_page = 'contents';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

// Delete boards
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		$v = intval($v);
		$query = "DELETE FROM " . $DBPrefix . "community WHERE id = " . $v;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE boardid = " . $v;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	$ERR = $MSG['5044'];
}

// get list of boards
$query = "SELECT * FROM " . $DBPrefix . "community ORDER BY name";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res))
{
	$template->assign_block_vars('boards', array(
			'ID' => $row['id'],
			'NAME' => $row['name'],
			'ACTIVE' => $row['active'],
			'MSGTOSHOW' => $row['msgstoshow'],
			'MSGCOUNT' => $row['messages']
			));
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'boards.tpl'
		));
$template->display('body');

?>