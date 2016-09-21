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
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$system->writesetting("usersauth", $_POST['usersauth'], 'str');
	$system->writesetting("activationtype", $_POST['usersconf'], 'int');
	$system->writesetting("prune_unactivated_users", $_POST['prune_unactivated_users'], 'bool');
	$system->writesetting("prune_unactivated_users_days", $_POST['prune_unactivated_users_days'], 'int');
	$system->writesetting("bidding_visable_to_guest", $_POST['bidding_visable_to_guest'], 'bool');
	$system->writesetting("email_admin_on_signup", $_POST['email_admin_on_signup'], 'bool');
	$system->writesetting("user_request_seller_permission", $_POST['user_request_seller_permission'], 'bool');

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['895']));
}

loadblock($MSG['25_0151'], $MSG['25_0152'], 'yesnostacked', 'usersauth', $system->SETTINGS['usersauth'], array($MSG['2__0066'], $MSG['2__0067']));
loadblock($MSG['25_0151_a'], $MSG['25_0152_a'], 'select3num', 'usersconf', $system->SETTINGS['activationtype'], array($MSG['25_0152_b'], $MSG['25_0152_c'], $MSG['25_0152_d']));

loadblock($MSG['prune_unactivated_users'], $MSG['prune_unactivated_users_explain'], 'bool', 'prune_unactivated_users', $system->SETTINGS['prune_unactivated_users'], array($MSG['759'], $MSG['760']));
loadblock($MSG['prune_unactivated_users_days'], $MSG['prune_unactivated_users_days_explain'], 'days', 'prune_unactivated_users_days', $system->SETTINGS['prune_unactivated_users_days'], array($MSG['377']));

loadblock($MSG['bidding_visable_to_guest'], $MSG['bidding_visable_to_guest_explain'], 'bool', 'bidding_visable_to_guest', $system->SETTINGS['bidding_visable_to_guest'], array($MSG['759'], $MSG['760']));
loadblock($MSG['email_admin_on_signup'], $MSG['email_admin_on_signup_explain'], 'bool', 'email_admin_on_signup', $system->SETTINGS['email_admin_on_signup'], array($MSG['759'], $MSG['760']));
loadblock($MSG['user_request_seller_permission'], $MSG['user_request_seller_permission_explain'], 'bool', 'user_request_seller_permission', $system->SETTINGS['user_request_seller_permission'], array($MSG['759'], $MSG['760']));

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['894']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
