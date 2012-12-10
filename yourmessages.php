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

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourmessages.php';
	header('location: user_login.php');
	exit;
}

$messageid = intval($_GET['id']);
// check message is to user
$query = "SELECT m.*, u.nick FROM " . $DBPrefix . "messages m
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = m.sentfrom)
		WHERE m.sentto = " . $user->user_data['id'] . " AND m.id = " . $messageid;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$check = mysql_num_rows($res);

if ($check == 0)
{
	$_SESSION['message'] = $ERR_070;
	header('location: mail.php');
}

$array = mysql_fetch_array($res);
$sent = gmdate('M d, Y H:ia', $array['sentat'] + $system->tdiff);
$subject = $array['subject'];
$message = $array['message'];
$hash = md5(rand(1, 9999));
$array['message'] = str_replace('<br>', '', $array['message']);

if ($array['sentfrom'] == 0 && !empty($array['fromemail']))
{
	$sendusername = $array['fromemail'];
	$senderlink = $sendusername;
}
elseif ($array['sentfrom'] == 0 && empty($array['fromemail']))
{
	$sendusername = $MSG['110'];
	$senderlink = $sendusername;
}
else
{
	$sendusername = $array['nick'];
	$senderlink = '<a href="profile.php?user_id=1&auction_id=' . $array['sentfrom'] . '">' . $sendusername . '</a>';
}

// Update message
$query = "UPDATE " . $DBPrefix . "messages SET isread = 1 WHERE id = " . $messageid;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

// set session for reply
$_SESSION['subject' . $hash] = (substr($subject, 0, 3) == 'Re:') ? $subject : 'Re: ' . $subject;
$_SESSION['sendto' . $hash] = $sendusername;
$_SESSION['reply' . $hash] = $messageid;
$_SESSION['reply_of' . $hash] = ($array['reply_of'] == 0) ? $messageid : $array['reply_of'];
$_SESSION['question' . $hash] = $array['question'];

$template->assign_vars(array(
		'SUBJECT' => $subject,
		'SENDERNAME' => (isset($senderlink)) ? $senderlink : $sendusername,
		'SENT' => $sent,
		'MESSAGE' => $message,
		'ID' => $messageid,
		'HASH' => $hash
		));

include 'header.php';
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourmessages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
