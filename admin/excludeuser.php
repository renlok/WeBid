<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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

if (!isset($_REQUEST['id']))
{
	header('location: listusers.php?PAGE=' . intval($_REQUEST['offset']));
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	if ($_POST['mode'] == 'activate')
	{
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . $_POST['id'];
		$db->direct_query($query);
		$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers - 1, users = users + 1";
		$db->direct_query($query);
		$query = "SELECT name, email FROM " . $DBPrefix . "users WHERE id = " . $_POST['id'];
		$db->direct_query($query);
		$USER = $db->fetch();
		include $include_path . 'email_user_approved.php';
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 1 WHERE id = " . $_POST['id'];
		$db->direct_query($query);
		$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers + 1, users = users - 1";
		$db->direct_query($query);
	}

	header('location: listusers.php?PAGE=' . intval($_POST['offset']));
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: listusers.php?PAGE=' . intval($_POST['offset']));
	exit;
}

// load the page
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . intval($_GET['id']);
$db->direct_query($query);
$user_data = $db->fetch();

// create tidy DOB string
if ($user_data['birthdate'] == 0)
{
	$birthdate = '';
}
else
{
	$birth_day = substr($user_data['birthdate'], 6, 2);
	$birth_month = substr($user_data['birthdate'], 4, 2);
	$birth_year = substr($user_data['birthdate'], 0, 4);

	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$birthdate = $birth_month . '/' . $birth_day . '/' . $birth_year;
	}
	else
	{
		$birthdate = $birth_day . '/' . $birth_month . '/' . $birth_year;
	}
}

$mode = 'activate';
switch ($user_data['suspended'])
{
	case 0:
		$action = $MSG['305'];
		$question = $MSG['308'];
		$mode = 'suspend';
		break;
	case 8:
		$action = $MSG['515'];
		$question = $MSG['815'];
		break;
	case 10:
		$action = $MSG['299'];
		$question = $MSG['418'];
		break;
	default:
		$action = $MSG['306'];
		$question = $MSG['309'];
		break;
}

$template->assign_vars(array(
		'ACTION' => $action,
		'REALNAME' => $user_data['name'],
		'USERNAME' => $user_data['nick'],
		'EMAIL' => $user_data['email'],
		'ADDRESS' => $user_data['address'],
		'PROV' => $user_data['prov'],
		'ZIP' => $user_data['zip'],
		'COUNTRY' => $user_data['country'],
		'PHONE' => $user_data['phone'],
		'DOB' => $birthdate,
		'QUESTION' => $question,
		'MODE' => $mode,
		'ID' => $_GET['id'],
		'OFFSET' => $_GET['offset']
		));

$template->set_filenames(array(
		'body' => 'excludeuser.tpl'
		));
$template->display('body');
?>
