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

if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email']))
	{
		$ERR = $ERR_047;
	}
	elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
	{
		$ERR = $ERR_008;
	}
	else
	{
		// Update database
		$query = "INSERT INTO " . $DBPrefix . "bannersusers VALUES
		(NULL, '" . mysql_real_escape_string($_POST['name']) . "', '" . mysql_real_escape_string($_POST['company']) . "', '" . $_POST['email'] . "')";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$ID = mysql_insert_id();
		header('location: userbanners.php?id=' . $ID);
		exit;
	}
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'NAME' => (isset($_POST['name'])) ? $_POST['name'] : '',
		'COMPANY' => (isset($_POST['company'])) ? $_POST['company'] : '',
		'EMAIL' => (isset($_POST['email'])) ? $_POST['email'] : ''
		));

$template->set_filenames(array(
		'body' => 'newbanneruser.tpl'
		));
$template->display('body');
?>
