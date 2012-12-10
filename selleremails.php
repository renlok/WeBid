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

if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'selleremails.php';
	header('location: user_login.php');
	exit;
}

// Create new list
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$query = "UPDATE " . $DBPrefix . "users SET endemailmode = '" . $system->cleanvars($_POST['endemailmod']) . "',
			  startemailmode = '" . $system->cleanvars($_POST['startemailmod']) . "',
			  emailtype = '" . $system->cleanvars($_POST['emailtype']) . "'  WHERE id = " . $user->user_data['id'];
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$ERR = $MSG['25_0192'];
	$user->user_data = array_merge($user->user_data, $_POST); //update the array
}

$template->assign_vars(array(
		'B_AUCSETUPY' => ($user->user_data['startemailmode'] == 'yes') ? ' checked="checked"' : '',
		'B_AUCSETUPN' => ($user->user_data['startemailmode'] == 'no') ? ' checked="checked"' : '',
		'B_CLOSEONE' => ($user->user_data['endemailmode'] == 'one') ? ' checked="checked"' : '',
		'B_CLOSEBULK' => ($user->user_data['endemailmode'] == 'cum') ? ' checked="checked"' : '',
		'B_CLOSENONE' => ($user->user_data['endemailmode'] == 'none') ? ' checked="checked"' : '',
		'B_EMAILTYPET' => ($user->user_data['emailtype'] == 'text') ? ' checked="checked"' : '',
		'B_EMAILTYPEH' => ($user->user_data['emailtype'] == 'html') ? ' checked="checked"' : ''
		));

include 'header.php';
$TMP_usmenutitle = $MSG['25_0188'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'sellermails.tpl'
		));
$template->display('body');
include 'footer.php';
?>
