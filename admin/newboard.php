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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

// Insert new message board
if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	if (empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active']))
	{
		$ERR = $ERR_047;
	}
	elseif (!is_numeric($_POST['msgstoshow']))
	{
		$ERR = $ERR_5000;
	}
	elseif (intval($_POST['msgstoshow'] == 0))
	{
		$ERR = $ERR_5001;
	}
	else
	{
		$query = "INSERT INTO " . $DBPrefix . "community VALUES (NULL, :name, 0, 0, :msgstoshow, :active)";
		$params = array();
		$params[] = array(':name', $system->cleanvars($_POST['name']), 'str');
		$params[] = array(':msgstoshow', intval($_POST['msgstoshow']), 'int');
		$params[] = array(':active', $_POST['active'], 'int');
		$db->query($query, $params);
		header('location: boards.php');
		exit;
	}
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : '',

		'NAME' => (isset($_POST['name'])) ? $_POST['name'] : '',
		'MSGTOSHOW' => (isset($_POST['msgstoshow'])) ? $_POST['msgstoshow'] : '',
		'B_ACTIVE' => ((isset($_POST['active']) && $_POST['active'] == 1) || !isset($_POST['active'])),
		'B_DEACTIVE' => (isset($_POST['active']) && $_POST['active'] == 2)
		));

$template->set_filenames(array(
		'body' => 'newboard.tpl'
		));
$template->display('body');

?>