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
$current_page = 'banners';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);
$id = $_REQUEST['id'];

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email']))
	{
		$ERR = $ERR_047;
		$USER = $_POST;
	}
	elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
	{
		$ERR = $ERR_008;
		$USER = $_POST;
	}
	else
	{
		// Update database
		$query = "UPDATE " . $DBPrefix . "bannersusers SET
				  name = '" . mysql_escape_string($_POST['name']) . "',
				  company = '" . mysql_escape_string($_POST['company']) . "',
				  email = '" . mysql_escape_string($_POST['email']) . "'
				  WHERE id = " . $id;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		header('location: managebanners.php');
		exit;
	}
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id=$id";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$USER = mysql_fetch_assoc($res);
	}
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $id,
		'NAME' => (isset($USER['name'])) ? $USER['name'] : '',
		'COMPANY' => (isset($USER['company'])) ? $USER['company'] : '',
		'EMAIL' => (isset($USER['email'])) ? $USER['email'] : ''
		));

$template->set_filenames(array(
		'body' => 'editbanneruser.tpl'
		));
$template->display('body');
?>