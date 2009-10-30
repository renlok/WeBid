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

$id = intval($_REQUEST['id']);
if ($_POST['action'] == 'update')
{
	if (is_array($_POST['accept']))
	{
		foreach ($_POST['accept'] as $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'accept' WHERE id = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	if (is_array($_POST['deny']))
	{
		foreach ($_POST['deny'] as $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'deny' WHERE id = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
}

$query = "SELECT nick, lastlogin FROM " . $DBPrefix . "users WHERE id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$USER = mysql_fetch_array($res);
}

$query = "SELECT id, type, ip, action FROM " . $DBPrefix . "usersips WHERE user = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$bgcolour = '#FFFFFF';
	while ($row = mysql_fetch_assoc($res))
	{
		$bgcolour = ($bgcolour == '#FFFFFF') ? '#EEEEEE' : '#FFFFFF';
		$template->assign_block_vars('ips', array(
				'BGCOLOUR' => $bgcolour,
				'TYPE' => $row['type'],
				'ID' => $row['id'],
				'IP' => $row['ip'],
				'ACTION' => $row['action']
				));
	}
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ID' => $id,
		'NICK' => $USER['nick'],
		'LASTLOGIN' => date('Y-m-d H:i:s', strtotime($USER['lastlogin']) + $system->tdiff)
		));

$template->set_filenames(array(
		'body' => 'viewuserips.tpl'
		));
$template->display('body');
?>
