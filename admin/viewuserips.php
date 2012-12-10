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

$id = intval($_REQUEST['id']);
$uloffset = intval($_REQUEST['offset']);
if (isset($_POST['action']) && $_POST['action'] == 'update')
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

$query = "SELECT COUNT(*) As ips FROM " . $DBPrefix . "usersips WHERE user = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_ips = mysql_result($res, 0, 'ips');

// Handle pagination
if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '')
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = $_GET['PAGE'];
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
$PAGES = ($num_ips == 0) ? 1 : ceil($num_ips / $system->SETTINGS['perpage']);

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
	$bg = '';
	while ($row = mysql_fetch_assoc($res))
	{
		$bgcolour = ($bgcolour == '#FFFFFF') ? '#EEEEEE' : '#FFFFFF';
		$template->assign_block_vars('ips', array(
				'TYPE' => $row['type'],
				'ID' => $row['id'],
				'IP' => $row['ip'],
				'ACTION' => $row['action'],
				'BG' => $bg
				));
		$bg = ($bg == '') ? 'class="bg"' : '';
	}
}

// get pagenation
$url_id = 'id=' . $id;
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/viewuserips.php?' . $url_id . '&PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ID' => $id,
		'NICK' => $USER['nick'],
		'LASTLOGIN' => date('Y-m-d H:i:s', strtotime($USER['lastlogin']) + $system->tdiff),
		'OFFSET' => $uloffset,

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/viewuserips.php?' . $url_id . '&PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/viewuserips.php?' . $url_id . '&PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

$template->set_filenames(array(
		'body' => 'viewuserips.tpl'
		));
$template->display('body');
?>
