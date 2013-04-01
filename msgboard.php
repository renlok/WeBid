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

include 'common.php';

unset($ERR);
if ($system->SETTINGS['boards'] == 'n')
{
	header('location: index.php');
}

// Is the seller logged in?
if (!$user->is_logged_in())
{
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

if (!isset($board_id) || is_array($board_id) || empty($board_id) || $board_id == 0)
{
	header('location: boards.php');
	exit;
}

$NOW = time();

$query = "SELECT id FROM " . $DBPrefix . "comm_messages WHERE boardid = " . $board_id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

if (isset($_POST['action']) && empty($_POST['newmessage']))
{
	$ERR = $ERR_624;
}

$TOTALMSGS = mysql_num_rows($res);
// Insert new message in the database
if (isset($_POST['action']) && $_POST['action'] == 'insertmessage' && !empty($_POST['newmessage'])) {
	if ($system->SETTINGS['wordsfilter'] == 'y')
	{
		$message = strip_tags($system->filter($_POST['newmessage']));
	}
	else
	{
		$message = strip_tags($_POST['newmessage']);
	}
	$query = "INSERT INTO " . $DBPrefix . "comm_messages VALUES
			(NULL, " . intval($_POST['board_id']) . ", '$NOW', " . $user->user_data['id'] . ",
			'" . $user->user_data['nick'] . "', '" . $system->cleanvars($message) . "')";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	// Track IP
	if (defined('TrackUserIPs'))
	{
		$system->log('user', 'Post Public Message', $user->user_data['id'], mysql_insert_id());
	}
	// Update messages counter and lastmessage date
	$query = "UPDATE " . $DBPrefix . "community
			SET messages = messages + 1, lastmessage = '$NOW' WHERE id = " . $board_id;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	header('location: ' . $_SERVER['HTTP_REFERER']);
}

// retrieve message board title
$query = "SELECT name, active, msgstoshow FROM " . $DBPrefix . "community WHERE id = " . $board_id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$BOARD_TITLE = mysql_result($res, 0, 'name');
$BOARD_ACTIVE = mysql_result($res, 0, 'active');
$BOARD_LIMIT = mysql_result($res, 0, 'msgstoshow');

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

if (isset($_GET['show']) && $_GET['show'] == 'all')
{
	$SQL_LIMIT = '';
}
else
{
	$SQL_LIMIT = " LIMIT $OFFSET, $BOARD_LIMIT";
}
// Retrieve messages for this message board
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE boardid = " . $board_id . " ORDER BY msgdate DESC $SQL_LIMIT";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

if (mysql_num_rows($res) > 0)
{
	$k = 0;
	while ($messages = mysql_fetch_array($res))
	{
		$template->assign_block_vars('msgs', array(
				'MSG' => nl2br(stripslashes($messages['message'])),
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
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$COUNT = mysql_num_rows($res);

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
if ($COUNT > $BOARD_LIMIT && (!isset($_GET['show']) || $_GET['show'] != 'all'))
{
	$NAVIGATION = '<a href="' . $system->SETTINGS['siteurl'] . 'msgboard.php?show=all&offset=' . $_REQUEST['offset'] . '&board_id=' . $_REQUEST['board_id'] . '">' . $MSG['5062'] . '</a> (' . $COUNT . ')';
}
elseif ($_GET['show'] == 'all')
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
?>
