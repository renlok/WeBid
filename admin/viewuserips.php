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
$uloffset = intval($_REQUEST['offset']);
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

$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE user = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_ips = mysql_result($res, 0, 'ips');

// Handle pagination
if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1 || $_GET['PAGE'] == '')
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = $_GET['PAGE'];
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
$PAGES = ceil($num_ips / $system->SETTINGS['perpage']);
if (!isset($PAGES) || $PAGES < 1) $PAGES = 1;

$query = "SELECT nick, lastlogin FROM " . $DBPrefix . "users WHERE id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$USER = mysql_fetch_array($res);
}

$query = "SELECT id, type, ip, action FROM " . $DBPrefix . "usersips WHERE user = " . $id .
		" LIMIT " . $OFFSET . ", " . $system->SETTINGS['perpage'];
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

$LOW = $PAGE - 5;
if ($LOW <= 0) $LOW = 1;
$COUNTER = $LOW;
$pagenation = '';
while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
{
	if ($PAGE == $COUNTER)
	{
		$pagenation .= '<b>' . $COUNTER . '</b>&nbsp;&nbsp;';
	}
	else
	{
		$pagenation .= '<a href="viewuserips.php?PAGE=' . $COUNTER . '&id=' . $id . '&offset=' . $uloffset . '"><u>' . $COUNTER . '</u></a>&nbsp;&nbsp;';
	}
	$COUNTER++;
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ID' => $id,
		'NICK' => $USER['nick'],
		'LASTLOGIN' => date('Y-m-d H:i:s', strtotime($USER['lastlogin']) + $system->tdiff),
		'OFFSET' => $uloffset,

		'B_MULPAG' => ($PAGES > 1),
		'NEXT' => intval($PAGE + 1),
		'PREV' => intval($PAGE - 1),
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,
		'PAGENA' => $pagenation
		));

$template->set_filenames(array(
		'body' => 'viewuserips.tpl'
		));
$template->display('body');
?>
