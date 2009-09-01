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

include 'includes/common.inc.php';

// If user is not logged in redirect to login page
if (!$user->logged_in)
{
	header('location: user_login.php');
	exit;
}

$x = (isset($_GET['x']))? $_GET['x'] : '';
$u = (isset($_GET['u']))? (int)$_GET['u'] : 0;
$replymessage = (isset($_GET['message']))? $_GET['message'] : '';
$order = (isset($_GET['order']))? $_GET['order'] : '';
$action = (isset($_GET['action']))? $_GET['action'] : '';
$messageid = (isset($_GET['id']))? $_GET['id'] : '';
$delete = (isset($_POST['delete']))? $_POST['delete'] : NULL;
$ERR = '';

if (isset($_POST['sendto']) && isset($_POST['subject']) && isset($_POST['message']))
{
	// get message info + set cookies for if an error occours
	$sendto = $system->cleanvars($_POST['sendto']);
	$_SESSION['sendto'] = $sendto;
	$subject = $system->cleanvars($_POST['subject']);
	$_SESSION['subject'] = $subject;
	$message = $system->cleanvars($_POST['message']);
	$_SESSION['messagecont'] = $message;
	// check user exists
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE nick = '" . $sendto . "'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$usercheck = mysql_num_rows($res);
	if ($usercheck == 0)
	{
		$_SESSION['message'] = $ERR_609;
		header('location: mail.php?x=1');
		exit;
	}
	$userarray = mysql_fetch_array($res);

	// check use mailbox insnt full
	$query = "SELECT * FROM " . $DBPrefix . "messages WHERE sentto = " . $userarray['id'];
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$mailboxsize = mysql_num_rows($res);
	if ($mailboxsize >= 30)
	{
		$_SESSION['message'] = sprintf($MSG['443'], $sendto);
		header('location: mail.php');
		exit;
	}

	// send message
	$nowmessage = nl2br($message);
	$query = "INSERT INTO " . $DBPrefix . "messages (sentto, sentfrom, sentat, message, subject, reply_of, question)
			VALUES (" . $userarray['id'] . ", " . $user->user_data['id'] . ", " . time() . ", '" . $nowmessage . "', '" . $subject . "', " . $_SESSION['reply_of' . $_POST['hash']] . ", " . $_SESSION['question' . $_POST['hash']] . ")";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

	if (isset($_POST['is_question']) && isset($_SESSION['reply_of' . $_POST['hash']]) && $_SESSION['reply_of' . $_POST['hash']] > 0)
	{
		$public = (isset($_POST['public'])) ? 1 : 0;
		$query = "UPDATE " . $DBPrefix . "messages SET public = " . $public . " WHERE id = " . $_SESSION['reply_of' . $_POST['hash']];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}

	if (isset($_SESSION['reply' . $_POST['hash']]))
	{
		$reply = $_SESSION['reply' . $_POST['hash']];
		$query = "UPDATE " . $DBPrefix . "messages SET replied = 1 WHERE id = " . $reply;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		unset($_SESSION['reply' . $_POST['hash']]);
	}
	// delete session of sent message
	unset($_SESSION['messagecont' . $_POST['hash']]);
	unset($_SESSION['subject' . $_POST['hash']]);
	unset($_SESSION['sendto' . $_POST['hash']]);
	unset($_SESSION['reply_of' . $_POST['hash']]);
}

if (isset($_REQUEST['deleteid']) && is_array($_REQUEST['deleteid']))
{
	$temparr = $_REQUEST['deleteid'];
	$message_id = 0;
	for ($i = 0; $i < count($temparr); $i++)
	{
		$message_id .= ',' . intval($temparr[$i]);
	}
	$query = "DELETE FROM " . $DBPrefix . "messages WHERE id IN (" . $message_id . ")";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$ERR = $MSG['444'];
}

// if sending a message
if ($x == 1)
{
	$subject = $_SESSION['subject' . $replymessage];
	$sendto = $_SESSION['sendto' . $replymessage];
	$question = false;
	// if sent from userpage
	if ($u > 0)
	{
		$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = " . intval($u);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$array = mysql_fetch_assoc($res);
		$sendto = $array['nick'];
	}

	// get convo
	if (isset($_SESSION['reply_of' . $_GET['message']]) && $_SESSION['reply_of' . $_GET['message']] != 0)
	{
		$tid = $_SESSION['reply_of' . $_GET['message']];
		$query = "SELECT sentfrom, question, public FROM " . $DBPrefix . "messages WHERE id = " . $tid;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$array = mysql_fetch_assoc($res);
		$reply_public = $array['public'];
		if ($array['question'] > 0 && $user->user_data['id'] != $array['sentfrom'])
		{
			$question = true;
		}

		$query = "SELECT sentfrom, message, question FROM " . $DBPrefix . "messages WHERE reply_of = " . $tid . " OR id = " . $tid . " ORDER BY id DESC";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$oid = 0;
		while ($row = mysql_fetch_assoc($res))
		{
			$oid = ($oid == 0) ? $row['sentfrom'] : $oid;
			$template->assign_block_vars('convo', array(
					'BGCOLOUR' => ($oid == $row['sentfrom']) ? ' background-color: #EEEEEE' : '',
					'MSG' => $row['message']
					));
		}
	}
}

// table headers
$sentfrom = '<a href="mail.php?order=3">' . $MSG['240'] . '</a>';
$whensent = '<a href="mail.php?order=1">' . $MSG['242'] . '</a>';
$title = '<a href="mail.php?order=5">' . $MSG['519'] . '</a>';

// order messages
switch ($order)
{
	case 1:
		$orderby = "ORDER BY id DESC";
		$whensent = '<a href="mail.php?order=2">' . $MSG['242'] . ' <img src="images/arrow_down.gif"></a>';
	break;
	case 2:
		$orderby = "ORDER BY id ASC";
		$whensent = '<a href="mail.php?order=1">' . $MSG['242'] . ' <img src="images/arrow_up.gif"></a>';
	break;
	case 3:
		$orderby = "ORDER BY sentfrom DESC";
		$sentfrom = '<a href="mail.php?order=4">' . $MSG['240'] . ' <img src="images/arrow_down.gif"></a>';
	break;
	case 4:
		$orderby = "ORDER BY sentfrom ASC";
		$sentfrom = '<a href="mail.php?order=3">' . $MSG['240'] . ' <img src="images/arrow_up.gif"></a>';
	break;
	case 5:
		$orderby = "ORDER BY subject DESC";
		$title = '<a href="mail.php?order=6">' . $MSG['519'] . ' <img src="images/arrow_down.gif"></a>';
	break;
	case 6:
		$orderby = "ORDER BY subject ASC";
		$title = '<a href="mail.php?order=5">' . $MSG['519'] . ' <img src="images/arrow_up.gif"></a>';
	break;
	default:
		$orderby = "ORDER BY id DESC";
	break;
}

$query = "SELECT m.*, u.nick FROM " . $DBPrefix . "messages m
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = m.sentfrom)
		WHERE sentto = '" . $user->user_data['id'] . "' " . $orderby;
// get users messages
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$messages = mysql_num_rows($res);
// display number of messages
$messagespaceused = ($messages * 4) + 1;
$messagespaceleft = (30 - $messages) * 4;
$messagesleft = 30 - $messages;

$ERR = (isset($_SESSION['message'])) ? $_SESSION['message'] : $ERR;
unset($_SESSION['message']);

$template->assign_vars(array(
		'WHENSENT' => $whensent,
		'TITLE' => $title,
		'SENTFROM' => $sentfrom,
		'MSGCOUNT' => $messages,
		'HASH' => $replymessage,
		'REPLY_X' => $x,
		'REPLY_TO' => (isset($sendto)) ? $sendto : '',
		'REPLY_SUBJECT' => (isset($subject)) ? $subject : '',
		'REPLY_PUBLIC' => (isset($reply_public) && $reply_public == 1) ? ' checked="checked"' : '',

		'B_QMKPUBLIC' => (isset($question)) ? $question : false,
		'B_CONVO' => (isset($_SESSION['reply_of' . $_GET['message']]))
		));

while ($array = mysql_fetch_array($res))
{
	$template->assign_block_vars('msgs', array(
			'SENT' => gmdate('M d, Y H:ia', $array['sentat'] + $system->tdiff),
			'ID' => $array['id'],
			'SENDER' => ($array['sentfrom'] == 0) ? 'Admin' : '<a href="profile.php?user_id=' . $array['sentfrom'] . '">' . $array['nick'] . '</a>',
			'SUBJECT' => ($array['isread'] == 0) ? '<b>' . $array['subject'] . '</b>' : $array['subject']
			));
}

include 'header.php';
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'mail.tpl'
		));
$template->display('body');
include 'footer.php';
?>
