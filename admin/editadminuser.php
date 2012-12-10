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
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';

unset($ERR);

$id = intval($_REQUEST['id']);
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if ((!empty($_POST['password']) && empty($_POST['repeatpassword'])) || (empty($_POST['password']) && !empty($_POST['repeatpassword'])))
	{
		$ERR = $ERR_054;
	}
	elseif ($_POST['password'] != $_POST['repeatpassword'])
	{
		$ERR = $ERR_006;
	}
	else
	{ 
		// Update
		$query = "UPDATE " . $DBPrefix . "adminusers SET";
		if (!empty($_POST['password']))
		{
			$query .= " password = '" . md5($MD5_PREFIX . $_POST['password']) . "', ";
		}
		$query .= " status = " . intval($_POST['status']) . "	WHERE id = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		header('location: adminusers.php');
		exit;
	}
}

$query = "SELECT * FROM " . $DBPrefix . "adminusers WHERE id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_data = mysql_fetch_assoc($res);

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$CREATED = substr($user_data['created'], 4, 2) . '/' . substr($user_data['created'], 6, 2) . '/' . substr($user_data['created'], 0, 4);
}
else
{
	$CREATED = substr($user_data['created'], 6, 2) . '/' . substr($user_data['created'], 4, 2) . '/' . substr($user_data['created'], 0, 4);
}

if ($user_data['lastlogin'] == 0)
{
	$LASTLOGIN = $MSG['570'];
}
else
{
	$LASTLOGIN = FormatDate($user_data['lastlogin']);
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $id,
		'USERNAME' => $user_data['username'],
		'CREATED' => $CREATED,
		'LASTLOGIN' => $LASTLOGIN,

		'B_ACTIVE' => ($user_data['status'] == 1),
		'B_INACTIVE' => ($user_data['status'] == 2)
		));

$template->set_filenames(array(
		'body' => 'editadminuser.tpl'
		));
$template->display('body');

?>