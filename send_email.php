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

if (!isset($_POST['auction_id']) && !isset($_GET['auction_id']))
{
	$auction_id = $_SESSION['CURRENT_ITEM'];
}
else
{
	$auction_id = intval($_GET['auction_id']);
}
$_SESSION['CURRENT_ITEM'] = $auction_id;

if (($system->SETTINGS['contactseller'] == 'logged' && !$user->checkAuth()) || $system->SETTINGS['contactseller'] == 'never')
{
	if (isset($_SESSION['REDIRECT_AFTER_LOGIN']))
	{
		header('location: ' . $_SESSION['REDIRECT_AFTER_LOGIN']);
	}
	else
	{
		$_SESSION['LOGIN_MESSAGE'] = $MSG['646'];
		$_SESSION['REDIRECT_AFTER_LOGIN'] = 'send_email.php?id=' . $auction_id;
		header('location: user_login.php');
	}
}

// Get item description
$query = "SELECT a.user, a.title, u.nick, u.email FROM " . $DBPrefix . "auctions a
	LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
	WHERE a.id = :auc_id";
$params = array();
$params[] = array(':auc_id', $auction_id, 'int');
$db->query($query, $params);

if ($db->numrows() == 0)
{
	$TPL_error_text = $ERR_606;
}
else
{
	$auction_data = $db->result();
	$seller_id = $auction_data['user'];
	$item_title = htmlspecialchars($auction_data['title']);
	$seller_nick = $auction_data['nick'];
	$seller_email = $auction_data['email'];
}

if (isset($_POST['action']) || !empty($_POST['action']))
{
	$cleaned_question = $system->cleanvars($_POST['sender_question']);
	if ($system->SETTINGS['wordsfilter'] == 'y')
	{
		$cleaned_question = $system->filter($cleaned_question);
	}

	// Check errors
	if (isset($_POST['action']) && (!isset($_POST['sender_name']) || !isset($_POST['sender_email']) || empty($seller_nick) || empty($seller_email)))
	{
		$TPL_error_text = $ERR_032;
	}

	if (empty($cleaned_question))
	{
		$TPL_error_text = $ERR_031;
	}

	if (isset($_POST['action']) && (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['sender_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $seller_email)))
	{
		$TPL_error_text = $ERR_008;
	}
	if (empty($TPL_error_text))
	{
		$mes = $MSG['337'] . ': <i>' . $seller_nick . '</i><br><br>';
		$emailer = new email_handler();
		$emailer->assign_vars(array(
				'SENDER_NAME' => $_POST['sender_name'],
				'SENDER_QUESTION' => $cleaned_question,
				'SENDER_EMAIL' => $_POST['sender_email'],
				'SITENAME' => $system->SETTINGS['sitename'],
				'SITEURL' => $system->SETTINGS['siteurl'],
				'AID' => $auction_id,
				'TITLE' => $item_title,
				'SELLER_NICK' => $seller_nick
				));
		$item_title = htmlspecialchars($item_title);
		$subject = $MSG['335'] . ' ' . $system->SETTINGS['sitename'] . ' ' . $MSG['336'] . ' ' . $item_title;
		$from_id = (!$user->logged_in) ? $_POST['sender_email'] : $user->user_data['id'];
		$id_type = (!$user->logged_in) ? 'fromemail' : 'sentfrom';
		$emailer->email_uid = $seller_id;
		$emailer->email_sender($seller_email, 'send_email.inc.php', $subject);

		$query = "INSERT INTO " . $DBPrefix . "messages (sentto, " . $id_type . ", sentat, message, subject, question)
			VALUES (:seller_id, :from_id, :timer, :question, :title, :auc_id)";
		$params = array();
		$params[] = array(':seller_id', $seller_id, 'int');
		$params[] = array(':from_id', $from_id, 'int');
		$params[] = array(':timer', time(), 'int');
		$params[] = array(':question', $cleaned_question, 'str');
		$params[] = array(':title', $system->cleanvars(sprintf($MSG['651'], $item_title)), 'str');
		$params[] = array(':auc_id', $auction_id, 'int');
		$db->query($query, $params);
	}
}

$template->assign_vars(array(
		'MESSAGE' => (isset($mes)) ? $mes : '',
		'ERROR' => (isset($TPL_error_text)) ? $TPL_error_text : '',
		'AUCT_ID' => $auction_id,
		'SELLER_NICK' => (isset($seller_nick)) ? $seller_nick : '',
		'SELLER_EMAIL' => (isset($seller_email)) ? $seller_email : '',
		'SELLER_QUESTION' => (isset($_POST['sender_question'])) ? $_POST['sender_question'] : '',
		'ITEM_TITLE' => (isset($item_title)) ? $item_title : '',
		'EMAIL' => ($user->logged_in) ? $user->user_data['email'] : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'send_email.tpl'
		));
$template->display('body');
include 'footer.php';
