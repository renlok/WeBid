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


define('InAdmin', 1);
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$id = intval($_REQUEST['id']);
$user_id = intval($_REQUEST['user']);

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$query = "DELETE FROM " . $DBPrefix . "feedbacks WHERE id = " . $id;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$query = "SELECT SUM(rate) as FSUM, count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = " . $user_id;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$fb_data = mysql_fetch_assoc($res);
	$query = "UPDATE " . $DBPrefix . "users SET rate_sum = " . $fb_data['SUM'] . ", rate_num = " . $fb_data['NUM'] . " WHERE id = " . $user_id;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	header('location: userfeedback.php?id=' . $user_id);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: userfeedback.php?id=' . $user_id);
	exit;
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $id,
		'USERID' => $user_id,
		'MESSAGE' => sprintf($MSG['848'], $id),
		'TYPE' => 2
		));

$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');

?>