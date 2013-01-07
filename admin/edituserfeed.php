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
$current_page = 'users';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);
$id = intval($_GET['id']);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$user = intval($_POST['user']);
	$query = "UPDATE " . $DBPrefix . "feedbacks SET 
		  rate = '" . $_POST['aTPL_rate'] . "', 
		  feedback = '" . mysql_escape_string($_POST['TPL_feedback']) . "'
		  WHERE id = " . $id;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

	// Update user's record
	$query = "SELECT SUM(rate) as FSUM, count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks
			  WHERE rated_user_id = " . $user;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$SUM = mysql_result($res, 0, 'FSUM');
	$NUM = mysql_result($res, 0, 'FNUM');

	$query = "UPDATE " . $DBPrefix . "users SET rate_sum = " . $SUM . ", rate_num = " . $NUM . " WHERE id = " . $user;
	$ERR = $MSG['183'];
}

$query = "SELECT u.nick, u.id, f.rater_user_nick, f.feedback, f.rate FROM " . $DBPrefix . "feedbacks f
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = f.rated_user_id) WHERE f.id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$feedback = mysql_fetch_assoc($res);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'RATED_USER' => $feedback['nick'],
		'RATED_USER_ID' => $feedback['id'],
		'RATER_USER' => $feedback['rater_user_nick'],
		'FEEDBACK' => $feedback['feedback'],
		'SEL1' => ($feedback['rate'] == 1),
		'SEL2' => ($feedback['rate'] == 0),
		'SEL3' => ($feedback['rate'] == -1)
		));
		
$template->set_filenames(array(
		'body' => 'edituserfeed.tpl'
		));
$template->display('body');
?>
