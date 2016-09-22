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
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_GET['resend']) && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$query = "SELECT id, nick, name, email, hash FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_GET['id'], 'int');
	$db->query($query, $params);
	if ($db->numrows() > 0)
	{
		$USER = $db->result();

		$emailer = new email_handler();
		$emailer->assign_vars(array(
				'SITENAME' => $system->SETTINGS['sitename'],
				'SITEURL' => $system->SETTINGS['siteurl'],
				'ADMINMAIL' => $system->SETTINGS['adminmail'],
				'CONFIRMURL' => $system->SETTINGS['siteurl'] . 'confirm.php?id=' . $USER['id'] . '&hash=' . md5($MD5_PREFIX . $USER['hash']),
				'C_NAME' => $USER['name']
				));
		$emailer->email_uid = $USER['id'];
		$emailer->email_sender($USER['email'], 'usermail.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['098']);
		$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['059']));
	}
}

if (isset($_GET['payreminder']) && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$query = "SELECT id, name, email, balance FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_GET['id'], 'int');
	$db->query($query, $params);
	if ($db->numrows() > 0)
	{
		$USER = $db->result();

		$emailer = new email_handler();
		$emailer->assign_vars(array(
				'SITENAME' => $system->SETTINGS['sitename'],
				'LINK' => $system->SETTINGS['siteurl'] . 'outstanding.php',
				'C_NAME' => $USER['name'],
				'BALANCE' => $USER['balance']
				));
		$emailer->email_uid = $USER['id'];
		$emailer->email_sender($USER['email'], 'payment_reminder.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['766']);
		$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['765']));
	}
}

if (isset($_GET['usersfilter']))
{
	$_SESSION['usersfilter'] = $_GET['usersfilter'];
	switch($_GET['usersfilter'])
	{
		case 'all':
			unset($_SESSION['usersfilter']);
			unset($Q);
		break;
		case 'active':
			$Q = 0;
		break;
		case 'admin':
			$Q = 1;
		break;
		case 'confirmed':
			$Q = 8;
		break;
		case 'fee':
			$Q = 9;
		break;
		case 'admin_approve':
			$Q = 10;
		break;
	}
}
elseif (!isset($_GET['usersfilter']) && isset($_SESSION['usersfilter']))
{
	switch($_SESSION['usersfilter'])
	{
		case 'active':
			$Q = 0;
		break;
		case 'admin':
			$Q = 1;
		break;
		case 'confirmed':
			$Q = 8;
		break;
		case 'fee':
			$Q = 9;
		break;
		case 'admin_approve':
			$Q = 10;
		break;
	}
}
else
{
	unset($_SESSION['usersfilter']);
	unset($Q);
}

// Retrieve active users from the database
$params = array();
if (isset($Q))
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users WHERE suspended = " . $Q;
}
elseif (isset($_POST['keyword']))
{
	$keyword = $system->cleanvars($_POST['keyword']);
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users
			WHERE name LIKE :name OR nick LIKE :nick OR email LIKE :email";
	$params[] = array(':name', '%' . $keyword . '%', 'str');
	$params[] = array(':nick', '%' . $keyword . '%', 'str');
	$params[] = array(':email', '%' . $keyword . '%', 'str');
}
else
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users";
}
$db->query($query, $params);
$TOTALUSERS = $db->result('COUNT');
// get page limits
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'listusers.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'listusers.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;
$PAGES = ($TOTALUSERS == 0) ? 1 : ceil($TOTALUSERS / $system->SETTINGS['perpage']);

$params = array();
if (isset($Q))
{
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE suspended = " . $Q;
}
elseif (isset($_POST['keyword']))
{
	$query = "SELECT * FROM " . $DBPrefix . "users
			WHERE name LIKE :name OR nick LIKE :nick OR email LIKE :email";
	$params[] = array(':name', '%' . $keyword . '%', 'str');
	$params[] = array(':nick', '%' . $keyword . '%', 'str');
	$params[] = array(':email', '%' . $keyword . '%', 'str');
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "users";
}
$query .= " ORDER BY nick"; // ordered by
$query .= " LIMIT :offset, :perpage";
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$bg = '';


$db->query($query, $params);

while ($row = $db->fetch())
{
	$template->assign_block_vars('users', array(
			'ID' => $row['id'],
			'NICK' => $row['nick'],
			'NAME' => $row['name'],
			'COUNTRY' => $row['country'],
			'EMAIL' => $row['email'],
			'NEWSLETTER' => ($row['nletter'] == 1) ? $MSG['030'] : $MSG['029'],
			'SUSPENDED' => $row['suspended'],
			'BALANCE' => $system->print_money($row['balance']),
			'BALANCE_CLEAN' => $row['balance'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

// get pagenation
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/listusers.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'TOTALUSERS' => $TOTALUSERS,
		'USERFILTER' => (isset($_SESSION['usersfilter'])) ? $_SESSION['usersfilter'] : '',

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/listusers.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/listusers.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'listusers.tpl'
		));
$template->display('body');
include 'footer.php';
?>
