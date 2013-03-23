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

// check recaptcha is enabled
include $main_path . 'inc/captcha/recaptchalib.php';
include $main_path . 'inc/captcha/securimage.php';

if (isset($_REQUEST['id']))
{
	$_SESSION['CURRENT_ITEM'] = $_REQUEST['id'];
}

$id = intval($_SESSION['CURRENT_ITEM']);

$TPL_error_text = '';
$emailsent = 1;
// Get item data
$query = "SELECT title, category FROM " . $DBPrefix . "auctions WHERE id = " . $id;
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
if (mysql_num_rows($result) > 0)
{
	$TPL_item_title = mysql_result($result, 0, 'title');
}

$spam_html = '';
if ($system->SETTINGS['spam_register'] == 1)
{
	$resp = new Securimage();
	$spam_html = $resp->show_html();
}

if (isset($_POST['action']) && $_POST['action'] == 'sendmail')
{
	// check errors
	if (empty($_POST['sender_name']) || empty($_POST['sender_email']) || empty($_POST['friend_name']) || empty($_POST['friend_email']))
	{
		$TPL_error_text = $ERR_031;
	}

	if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['sender_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['friend_email']))
	{
		$TPL_error_text = $ERR_008;
	}
	
	if ($system->SETTINGS['spam_sendtofriend'] == 2)
	{
		$resp = recaptcha_check_answer($system->SETTINGS['recaptcha_private'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
		if (!$resp->is_valid)
		{
			$TPL_error_text = $MSG['752'];
		}
	}
	elseif ($system->SETTINGS['spam_sendtofriend'] == 1)
	{
		if (!$resp->check($_POST['captcha_code']))
		{
			$TPL_error_text = $MSG['752'];
		}
	}
	

	if (!empty($TPL_error_text))
	{
		$emailsent = 1;
	}
	else
	{
		$emailsent = 0;
		$emailer = new email_handler();
		$emailer->assign_vars(array(
				'S_NAME' => $_POST['sender_name'],
				'S_EMAIL' => $_POST['sender_email'],
				'S_COMMENT' => $_POST['sender_comment'],
				'F_NAME' => $_POST['friend_name'],
				'TITLE' => $TPL_item_title,
				'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $id,
				'SITENAME' => $system->SETTINGS['sitename'],
				'SITEURL' => $system->SETTINGS['siteurl'],
				'ADMINEMAIL' => $system->SETTINGS['adminmail']
				));
		$emailer->email_sender($_POST['friend_email'], 'friendmail.inc.php', $MSG['905']);
	}
}

if ($system->SETTINGS['spam_sendtofriend'] == 2)
{
	$capcha_text = recaptcha_get_html($system->SETTINGS['recaptcha_public']);
}
elseif ($system->SETTINGS['spam_sendtofriend'] == 1)
{
	$capcha_text = $spam_html;
}

$template->assign_vars(array(
		'ERROR' => $TPL_error_text,
		'ID' => intval($_REQUEST['id']),
		'CAPTCHATYPE' => $system->SETTINGS['spam_register'],
		'CAPCHA' => (isset($capcha_text)) ? $capcha_text : '',
		'TITLE' => $TPL_item_title,
		'FRIEND_NAME' => (isset($_POST['friend_name'])) ? $_POST['friend_name'] : '',
		'FRIEND_EMAIL' => (isset($_POST['friend_email'])) ? $_POST['friend_email'] : '',
		'YOUR_NAME' => ($user->logged_in) ? $user->user_data['name'] : '',
		'YOUR_EMAIL' => ($user->logged_in) ? $user->user_data['email'] : '',
		'COMMENT' => (isset($_POST['sender_comment'])) ? $_POST['sender_comment'] : '',
		'EMAILSENT' => $emailsent
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'friend.tpl'
		));
$template->display('body');
include 'footer.php';
?>
