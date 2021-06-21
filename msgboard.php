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

include 'common.php';

unset($ERR);
if ($system->SETTINGS['boards'] == 'n')
{
	header('location: index.php');
}

// Is the seller logged in?
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'boards.php';
	header('location: user_login.php');
	exit;
}

if (isset($_POST['board_id']))
{
	$board_id = intval($_POST['board_id']);
}
elseif (isset($_GET['board_id']))
{
	$board_id = intval($_GET['board_id']);
}

$show = (isset($_GET['show'])) ? $_GET['show'] : '';

if (!isset($board_id) || is_array($board_id) || empty($board_id) || $board_id == 0)
{
	header('location: boards.php');
	exit;
}

$NOW = time();

$query = "SELECT id FROM " . $DBPrefix . "comm_messages WHERE boardid = :board_id";
$params = array();
$params[] = array(':board_id', $board_id, 'int');
$db->query($query, $params);
$TOTALMSGS = $db->numrows();

if (isset($_POST['action']) && empty($_POST['newmessage']))
{
	$ERR = $ERR_624;
}

// Insert new message in the database
if (isset($_POST['action']) && $_POST['action'] == 'insertmessage' && !empty($_POST['newmessage']))
{
	if ($system->SETTINGS['wordsfilter'] == 'y')
	{
		$message = strip_tags($system->filter($_POST['newmessage']));
	}
	else
	{
		$message = strip_tags($_POST['newmessage']);
	}
	$query = "INSERT INTO " . $DBPrefix . "comm_messages VALUES
			(NULL, :board_id, :now, :user_id, :user_nick, :message)";
	$params = array();
	$params[] = array(':board_id', $_POST['board_id'], 'int');
	$params[] = array(':now', $NOW, 'int');
	$params[] = array(':user_id', $user->user_data['id'], 'int');
	$params[] = array(':user_nick', $user->user_data['nick'], 'str');
	$params[] = array(':message', $system->cleanvars($message), 'str');
	$db->query($query, $params);

	// Track IP
	if (defined('TrackUserIPs'))
	{
		$system->log('user', 'Post Public Message', $user->user_data['id'], $db->lastInsertId());
	}
	// Update messages counter and lastmessage date
	$query = "UPDATE " . $DBPrefix . "community
			SET messages = messages + 1, lastmessage = :lastmessage WHERE id = :board_id";
	$params = array();
	$params[] = array(':lastmessage', $NOW, 'int');
	$params[] = array(':board_id', $board_id, 'int');
	$db->query($query, $params);
	header('location: ' . $_SERVER['HTTP_REFERER']);
}

// retrieve message board title
$query = "SELECT name, active, msgstoshow FROM " . $DBPrefix . "community WHERE id = :board_id";
$params = array();
$params[] = array(':board_id', $board_id, 'int');
$db->query($query, $params);
$info = $db->result();
$BOARD_TITLE = $info['name'];
$BOARD_ACTIVE = $info['active'];
$BOARD_LIMIT = $info['msgstoshow'];

if (!isset($_GET['PAGE']))
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = $_GET['PAGE'];
	$OFFSET = ($PAGE - 1) * $BOARD_LIMIT;
}
$PAGES = ceil($TOTALMSGS / $BOARD_LIMIT);
if (!$PAGES) $PAGES = 1;

if ($BOARD_ACTIVE == 2)
{
	header('location: boards.php');
	exit;
}

if ($show == 'all')
{
	$SQL_LIMIT = '';
}
else
{
	$SQL_LIMIT = " LIMIT $OFFSET, $BOARD_LIMIT";
}

// Retrieve messages for this message board
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE boardid = :board_id ORDER BY msgdate DESC $SQL_LIMIT";
$params = array();
$params[] = array(':board_id', $board_id, 'int');
$db->query($query, $params);

if ($db->numrows() > 0)
{
	$k = 0;
	while ($messages = $db->fetch())
	{
		$template->assign_block_vars('msgs', array(
				'MSG' => nl2br($messages['message']),
				'USERNAME' => $messages['username'],
				'POSTED' => FormatDate($messages['msgdate']),
				'BGCOLOUR' => (!($k % 2)) ? '' : 'class="alt-row"',
				));
		$k++;
	}
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'msgboard.php?PAGE=' . $COUNTER . '&board_id=' . $board_id . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}
// Count message
$query = "SELECT id FROM " . $DBPrefix . "comm_messages";
$db->direct_query($query);
$COUNT = $db->numrows();

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'BOARD_NAME' => $BOARD_TITLE,
		'BOARD_ID' => $board_id,
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'msgboard.php?PAGE=' . $PREV . '&board_id=' . $board_id . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'msgboard.php?PAGE=' . $NEXT . '&board_id=' . $board_id . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

// Build the bottom navigation line for the template
if ($COUNT > $BOARD_LIMIT && $show != 'all')
{
	$NAVIGATION = '<a href="' . $system->SETTINGS['siteurl'] . 'msgboard.php?show=all&offset=' . $_REQUEST['offset'] . '&board_id=' . $_REQUEST['board_id'] . '">' . $MSG['5062'] . '</a> (' . $COUNT . ')';
}
elseif ($show == 'all')
{
	$NAVIGATION = '<a href="' . $system->SETTINGS['siteurl'] . 'msgboard.php?board_id=' . $_REQUEST['board_id'] . '&offset=' . $_REQUEST['offset'] . '">&lt;&lt; ' . $MSG['270'] . '</a> ';
}
else
{
	$NAVIGATION = '';
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'msgboard.tpl'
		));
$template->display('body');
include 'footer.php';
