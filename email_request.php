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

// Get auction_id from sessions variables
if (isset($_REQUEST['auction_id']))
{
	$auction_id = $_SESSION['CURRENT_ITEM'] = intval($_REQUEST['auction_id']);
}
elseif (isset($_SESSION['CURRENT_ITEM']))
{
	$auction_id = $_SESSION['CURRENT_ITEM'];
}

if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'email_request.php';
	header('location: user_login.php');
	exit;
}

$query = "SELECT id, email, nick FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $_REQUEST['user_id'], 'int');
$db->query($query, $params);
$user_info = $db->result();
$user_id = $user_info['id'];
$email = $user_info['email'];
$username = $user_info['nick'];

$sent = false;
if (isset($_POST['action']) && $_POST['action'] == 'proceed')
{
	if (empty($_POST['TPL_text']))
	{
		$ERR = $ERR_031;
	}
	elseif ($auction_id < 0 || empty($auction_id))
	{
		$ERR = $ERR_622;
	}
	else
	{
		$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auction_id";
		$params = array();
		$params[] = array(':auction_id', $auction_id, 'int');
		$db->query($query, $params);
		if ($db->numrows() == 0)
		{
			$ERR = $ERR_622;
		}
		else
		{
			$item_title = htmlspecialchars($db->result('title'));
			$from_email = ($system->SETTINGS['users_email'] == 'n') ? $user->user_data['email'] : $system->SETTINGS['adminmail'];
			// Send e-mail message
			$subject = $MSG['335'] . ' ' . $system->SETTINGS['sitename'] . ' ' . $MSG['336'] . ' ' . $item_title;
			$message = $MSG['084'] . ' ' . $MSG['240'] . ': ' . $from_email . "\n\n" . $_POST['TPL_text'];
			$emailer = new email_handler();
			$emailer->email_uid = $user_id;
			$emailer->email_basic($subject, $email, nl2br($message), $user->user_data['name'] . '<' . $from_email . '>');
			// send a copy to their mesasge box
			$message = nl2br($system->cleanvars($message));
			$query = "INSERT INTO " . $DBPrefix . "messages (sentto, sentfrom, sentat, message, subject)
					VALUES (:id, :user_id, :times, :message, :subject)";
			$params = array();
			$params[] = array(':id', $user_id, 'int');
			$params[] = array(':user_id', $user->user_data['id'], 'int');
			$params[] = array(':times', time(), 'int');
			$params[] = array(':message', $message, 'str');
			$subject = $system->cleanvars(sprintf($MSG['651'], $item_title));
			if (strlen($subject) > 255)
			{
				$pos = strpos($subject, ' ', 200);
				$subject = substr($subject, 0, $pos) . '...';
			}
			$params[] = array(':subject', $subject, 'str');
			$db->query($query, $params);
			$sent = true;
		}
	}
}

$template->assign_vars(array(
		'B_SENT' => $sent,
		'ERROR' => (isset($TPL_error_text)) ? $TPL_error_text : '',
		'USERID' => $user_id,
		'USERNAME' => $username,
		'AUCTION_ID' => $auction_id,
		'MSG_TEXT' => (isset($_POST['TPL_text'])) ? $_POST['TPL_text'] : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'email_request.tpl'
		));
$template->display('body');
include 'footer.php';
