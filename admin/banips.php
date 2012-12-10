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
$current_page = 'users';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (!empty($_POST['ip']))
	{
		$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
				(NULL, 'NOUSER',  '" . $_POST['ip'] . "', 'next',  'deny')";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	if (is_array($_POST['delete']))
	{
		foreach ($_POST['delete'] as $k => $v)
		{
			$query = "DELETE FROM " . $DBPrefix . "usersips WHERE id = " . intval($v);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	if (is_array($_POST['accept']))
	{
		foreach ($_POST['accept'] as $k => $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'accept' WHERE id = " . intval($v);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	if (is_array($_POST['deny']))
	{
		foreach ($_POST['deny'] as $k => $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'deny' WHERE id = " . intval($v);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
}

$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE user = 'NOUSER'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$bg = '';
while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('ips', array(
			'ID' => $row['id'],
			'IP' => $row['ip'],
			'ACTION' => $row['action'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->set_filenames(array(
		'body' => 'banips.tpl'
		));
$template->display('body');
?>