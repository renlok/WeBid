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

// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'mail.php';
	header('location: user_login.php');
	exit;
}

$mailbox_space = 60; // how many messages you can have
$x = (isset($_GET['x']))? $_GET['x'] : '';
$user_id = (isset($_GET['u']))? intval($_GET['u']) : 0; // user_id
$replymessage = (isset($_GET['message']))? $_GET['message'] : '';
$order = (isset($_GET['order']))? $_GET['order'] : '';
$action = (isset($_GET['action']))? $_GET['action'] : '';
$messageid = (isset($_GET['id']))? $_GET['id'] : '';
$delete = (isset($_POST['delete']))? $_POST['delete'] : NULL;
$email = false;

if (isset($_POST['sendto']) && isset($_POST['subject']) && isset($_POST['message']))
{
	// get message info + set cookies for if an error occours
	$_SESSION['sendto'] = $sendto = $system->cleanvars($_POST['sendto']);
	$_SESSION['subject'] = $subject = $system->cleanvars($_POST['subject']);
	$_SESSION['messagecont'] = $message = $system->cleanvars($_POST['message']);

	// check user exists
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE nick = :sendtouser";
	$params = array();
	$params[] = array(':sendtouser', $sendto, 'str');
	$db->query($query, $params);
	if ($db->numrows() == 0) // no such user
	{
		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $sendto))
		{
			$_SESSION['message'] = $ERR_609;
			header('location: mail.php?x=1');
			exit;
		}
		else
		{
			$email = true;
		}
	}

	$nowmessage = nl2br($message);
	if (!$email)
	{
		$userarray = $db->result();

		// check use mailbox insnt full
		$query = "SELECT * FROM " . $DBPrefix . "messages WHERE sentto = :user_id";
		$params = array();
		$params[] = array(':user_id', $userarray['id'], 'int');
		$db->query($query, $params);
		if ($db->numrows() >= $mailbox_space)
		{
			$_SESSION['message'] = sprintf($MSG['443'], $sendto);
			header('location: mail.php');
			exit;
		}
	}
	else
	{
		// send the email
		$emailer = new email_handler();
		$from_email = ($system->SETTINGS['users_email'] == 'n') ? $user->user_data['email'] : $system->SETTINGS['adminmail'];
		$emailer->email_basic($subject, $sendto, $nowmessage, $from_email);
	}

	// send message
	$id_type = ($email) ? 'fromemail' : 'sentto';
	$query = "INSERT INTO " . $DBPrefix . "messages (" . $id_type . ", sentfrom, sentat, message, subject, reply_of, question)
			VALUES (:to_ids, :sender_id, :times, :nowmessages, :subjects, :reply_of_hash, :question_hash)";
	$params = array();
	$params[] = array(':to_ids', ($email) ? $sendto : $userarray['id'], 'bool');
	$params[] = array(':sender_id', $user->user_data['id'], 'int');
	$params[] = array(':times', time(), 'int');
	$params[] = array(':nowmessages', $nowmessage, 'str');
	$params[] = array(':subjects', $subject, 'str');
	$params[] = array(':reply_of_hash', $_SESSION['reply_of' . $_POST['hash']], 'int');
	$params[] = array(':question_hash', $_SESSION['question' . $_POST['hash']], 'int');
	$db->query($query, $params);

	// Track IP
	if (defined('TrackUserIPs'))
	{
		$system->log('user', 'Post Private Message', $user->user_data['id'], $db->lastInsertId());
	}

	if (isset($_POST['is_question']) && isset($_SESSION['reply_of' . $_POST['hash']]) && $_SESSION['reply_of' . $_POST['hash']] > 0)
	{
		$public = (isset($_POST['public'])) ? 1 : 0;
		$query = "UPDATE " . $DBPrefix . "messages SET public = :public_mes WHERE id = :mes_id";
		$params = array();
		$params[] = array(':public_mes', $public, 'int');
		$params[] = array(':mes_id', $_SESSION['reply_of' . $_POST['hash']], 'str');
		$db->query($query, $params);
	}

	if (isset($_SESSION['reply' . $_POST['hash']]))
	{
		$reply = $_SESSION['reply' . $_POST['hash']];
		$query = "UPDATE " . $DBPrefix . "messages SET replied = 1 WHERE id = :message_id";
		$params = array();
		$params[] = array(':message_id', $reply, 'int');
		$db->query($query, $params);
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
	$db->direct_query($query);
	$_SESSION['message'] = $MSG['444'];
}

// if sending a message
if ($x == 1)
{
	$subject = $_SESSION['subject' . $replymessage];
	$sendto = $_SESSION['sendto' . $replymessage];
	$question = false;
	// if sent from userpage
	if ($user_id > 0)
	{
		$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array();
		$params[] = array(':user_id', $u, 'int');
		$db->query($query, $params);
		$sendto = $db->result('nick');
	}

	// get convo
	if (isset($_SESSION['reply_of' . $_GET['message']]) && $_SESSION['reply_of' . $_GET['message']] != 0)
	{
		$tid = $_SESSION['reply_of' . $_GET['message']];
		$query = "SELECT sentfrom, question, public FROM " . $DBPrefix . "messages WHERE id = :message_id";
		$params = array();
		$params[] = array(':message_id', $tid, 'int');
		$db->query($query, $params);
		$message_data = $db->result();
		$reply_public = $message_data['public'];
		if ($message_data['question'] > 0 && $user->user_data['id'] != $message_data['sentfrom'])
		{
			$question = true;
		}

		$query = "SELECT sentfrom, message, question FROM " . $DBPrefix . "messages WHERE reply_of = :message_id1 OR id = :message_id2 ORDER BY id DESC";
		$params = array();
		$params[] = array(':message_id1', $tid, 'int');
		$params[] = array(':message_id2', $tid, 'int');
		$db->query($query, $params);
		$oid = 0;
		while ($row = $db->fetch())
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
		WHERE sentto = :user_id " . $orderby;
// get users messages
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$messages = $db->numrows();
// display number of messages
$messagespaceused = ($messages * 4) + 1;
$messagespaceleft = ($mailbox_space - $messages) * 4;
$messagesleft = $mailbox_space - $messages;

$ERR = (isset($_SESSION['message'])) ? $_SESSION['message'] : '';
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
		'B_CONVO' => (isset($_SESSION['reply_of' . $replymessage]))
		));

while ($array = $db->fetch())
{
	$sender = ($array['sentfrom'] == 0) ? 'Admin' : '<a href="profile.php?user_id=' . $array['sentfrom'] . '">' . $array['nick'] . '</a>';
	$sender = (!empty($array['fromemail'])) ? $array['fromemail'] : $sender;
	$template->assign_block_vars('msgs', array(
			'SENT' => date('M d, Y H:ia', $array['sentat'] + $system->tdiff),
			'ID' => $array['id'],
			'SENDER' => $sender,
			'SUBJECT' => ($array['isread'] == 0) ? '<b>' . $array['subject'] . '</b>' : $array['subject']
			));
}

include 'header.php';
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'mail.tpl'
		));
$template->display('body');
include 'footer.php';
