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

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$id = intval($_REQUEST['id']);
$user_id = intval($_REQUEST['user']);

if (isset($_POST['action']) && $_POST['action'] == "Yes")
{
	// delete the feedback entry
	$query = "DELETE FROM " . $DBPrefix . "feedbacks WHERE id = :feedback_id";
	$params = array();
	$params[] = array(':feedback_id', $id, 'int');
	$db->query($query, $params);
	// get the current feedback count
	$query = "SELECT SUM(rate) as FSUM, count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :user_id";
	$params = array();
	$params[] = array(':user_id', $user_id, 'int');
	$db->query($query, $params);
	$fb_data = $db->result();
	// update feedback count
	$query = "UPDATE " . $DBPrefix . "users SET rate_sum = :rate_sum, rate_num = :rate_num WHERE id = :user_id";
	$params = array();
	$params[] = array(':rate_sum', $fb_data['SUM'], 'int');
	$params[] = array(':rate_num', $fb_data['NUM'], 'int');
	$params[] = array(':user_id', $user_id, 'int');
	$db->query($query, $params);
	header('location: userfeedback.php?id=' . $user_id);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == "No")
{
	header('location: userfeedback.php?id=' . $user_id);
	exit;
}

$template->assign_vars(array(
		'ID' => $id,
		'USERID' => $user_id,
		'MESSAGE' => sprintf($MSG['848'], $id),
		'TYPE' => 2
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');

include 'footer.php';
?>