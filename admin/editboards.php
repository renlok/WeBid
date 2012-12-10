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
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == 'update')
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
		$query = "UPDATE " . $DBPrefix . "community
				  SET name = '" . $system->cleanvars($_POST['name']) . "',
				  msgstoshow = " . intval($_POST['msgstoshow']) . ",
				  active = " . intval($_POST['active']) . "
				  WHERE id = " . intval($_POST['id']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		header('location: boards.php');
		exit;
	}
}

$id = intval($_GET['id']);

// Retrieve board's data from the database
$query = "SELECT * FROM " . $DBPrefix . "community WHERE id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$board_data = mysql_fetch_assoc($res);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'NAME' => $board_data['name'],
		'MESSAGES' => $board_data['messages'],
		'LAST_POST' => ($board_data['lastmessage'] > 0) ? FormatDate($board_data['lastmessage']) : '--',
		'MSGTOSHOW' => $board_data['msgstoshow'],

		'B_ACTIVE' => ($board_data['active'] == 1),
		'B_DEACTIVE' => ($board_data['active'] == 2),
		'ID' => $id
		));

$template->set_filenames(array(
		'body' => 'editboards.tpl'
		));
$template->display('body');

?>