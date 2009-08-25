<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
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

unset($ERR);

if (isset($_GET['resend']) && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$query = "SELECT id, nick, name, email FROM " . $DBPrefix . "users WHERE id = " . $_GET['id'];
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$USER = mysql_fetch_assoc($res);

		$emailer = new email_class();
		$emailer->assign_vars(array(
				'SITENAME' => $system->SETTINGS['sitename'],
				'SITEURL' => $system->SETTINGS['siteurl'],
				'ADMINMAIL' => $system->SETTINGS['adminmail'],
				'CONFIRMURL' => $system->SETTINGS['siteurl'] . 'confirm.php?id=' . $USER['id'] . '&hash=' . md5($USER['nick']),
				'C_NAME' => $USER['name']
				));
		$emailer->email_uid = $USER['id'];
		$emailer->email_sender($USER['email'], 'usermail.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['098']);
		$ERR = $MSG['059'];
	}
}

if (isset($_GET['payreminder']) && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$query = "SELECT id, name, email, balance FROM " . $DBPrefix . "users WHERE id = " . $_GET['id'];
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$USER = mysql_fetch_assoc($res);

		$emailer = new email_class();
		$emailer->assign_vars(array(
				'SITENAME' => $system->SETTINGS['sitename'],
				'LINK' => $system->SETTINGS['siteurl'] . 'outstanding.php',
				'C_NAME' => $USER['name'],
				'BALANCE' => $USER['balance']
				));
		$emailer->email_uid = $USER['id'];
		$emailer->email_sender($useremail, 'payment_reminder.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['766']);
		$ERR = $MSG['765'];
	}
}

if ($_POST['usersfilter'] == 'all')
{
	unset($_SESSION['usersfilter']);
	unset($Q);
}
elseif (isset($_POST['usersfilter']))
{
	switch($_POST['usersfilter'])
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
	}
	$_SESSION['usersfilter'] = $_POST['usersfilter'];
}
elseif (!isset($_POST['usersfilter']) && isset($_SESSION['usersfilter']))
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
	}
}
else
{
	unset($_SESSION['usersfilter']);
	unset($Q);
}

// Retrieve active auctions from the database
if (isset($Q))
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users WHERE suspended = " . $Q;
}
elseif (isset($_POST['keyword']))
{
	$keyword = $system->cleanvars($_POST['keyword']);
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users
			WHERE name LIKE '%" . $keyword . "%' OR nick LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%'";
}
else
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users";
}
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$TOTALUSERS = mysql_result($res, 0);

// Set offset and limit for pagination
$LIMIT = 30;

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1 || !$_GET['PAGE'])
{
	$OFFSET = 0;
	$PAGE = 1;
} else {
	$PAGE = $_GET['PAGE'];
	$OFFSET = ($_GET['PAGE'] - 1) * $LIMIT;
}
$PAGES = ceil($TOTALUSERS / $LIMIT);
$_SESSION['RETURN_LIST'] = 'listusers.php';
$_SESSION['RETURN_LIST_PAGE'] = intval($PAGE);

if (isset($Q))
{
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE suspended = " . $Q . " ORDER BY nick LIMIT " . $OFFSET . ", " . $LIMIT;
}
elseif (isset($_POST['keyword']))
{
	$query = "SELECT * FROM " . $DBPrefix . "users
			WHERE name LIKE '%" . $keyword . "%' OR nick LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%'
			ORDER BY nick LIMIT " . $OFFSET . ", " . $LIMIT;
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "users ORDER BY nick LIMIT " . $OFFSET . ", " . $LIMIT;
}
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$bgcolour = '#FFFFFF';
while ($row = mysql_fetch_assoc($res))
{
	$bgcolour = ($bgcolour == '#FFFFFF') ? '#EEEEEE' : '#FFFFFF';
	$template->assign_block_vars('users', array(
			'BGCOLOUR' => $bgcolour,
			'ID' => $row['id'],
			'NICK' => $row['nick'],
			'NAME' => $row['name'],
			'COUNTRY' => $row['country'],
			'EMAIL' => $row['email'],
			'NEWSLETTER' => ($row['nletter'] == 1) ? $MSG['030'] : $MSG['029'],
			'SUSPENDED' => $row['suspended'],
			'BALANCE' => $system->print_money($row['balance'], false)
			));
}

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
				'COUNTER' => $COUNTER
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'TOTALUSERS' => $TOTALUSERS,
		'USERFILTER' => $_SESSION['usersfilter'],

		'PAGE' => $PAGE,
		'PAGES' => $PAGES,
        'PREV' => $PREV,
        'NEXT' => $NEXT
		));
		
$template->set_filenames(array(
		'body' => 'listusers.tpl'
		));
$template->display('body');
?>
