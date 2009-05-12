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

if (isset($_POST['action']) && $_POST['action'] == 'sendmail')
{
	// --Check errors
	if (empty($_POST['sender_name']) || empty($_POST['sender_email']) || empty($_POST['friend_name']) || empty($_POST['friend_email']))
	{
		$TPL_error_text = $ERR_031;
	}

	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['sender_email']) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['friend_email']))
	{
		$TPL_error_text = $ERR_008;
	}

	if (!empty($TPL_error_text))
	{
		$emailsent = 1;
	}
	else
	{
		$emailsent = 0;
		include $include_path . 'friend_confirmation.inc.php';
		$emailer = new email_class();
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

$template->assign_vars(array(
		'ERROR' => $TPL_error_text,
		'ID' => intval($_REQUEST['id']),
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
