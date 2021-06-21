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

if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'selleremails.php';
	header('location: user_login.php');
	exit;
}

// Create new list
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// check values
	if (in_array($_POST['endemailmod'], array('one', 'cum', 'none')) && in_array($_POST['startemailmod'], array('yes', 'no')) && in_array($_POST['emailtype'], array('html', 'text')))
	{
		$query = "UPDATE " . $DBPrefix . "users SET endemailmode = :endemailmod,
					startemailmode = :startemailmod,
					emailtype = :emailtype WHERE id = :user_id";
		$params = array(
			array(':endemailmod', $_POST['endemailmod'], 'str'),
			array(':startemailmod', $_POST['startemailmod'], 'str'),
			array(':emailtype', $_POST['emailtype'], 'str'),
			array(':user_id', $user->user_data['id'], 'int'),
		);
		$db->query($query, $params);
		$ERR = $MSG['25_0192'];
		$user->user_data = array_merge($user->user_data, $_POST); //update the array
	}
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
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'sellermails.tpl'
		));
$template->display('body');
include 'footer.php';
