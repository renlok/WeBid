<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['contactseller'] = $system->cleanvars($_POST['contactseller']);
	$system->SETTINGS['users_email'] = ynbool($_POST['users_email']);
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET contactseller = :contactseller, users_email = :users_email";
	$params = array();
	$params[] = array(':contactseller', $system->SETTINGS['contactseller'], 'str');
	$params[] = array(':users_email', $system->SETTINGS['users_email'], 'str');
	$db->query($query, $params);
	$ERR = $MSG['25_0155'];
}

loadblock($MSG['25_0216'], $MSG['25_0217'], 'select3contact', 'contactseller', $system->SETTINGS['contactseller'], array($MSG['25_0218'], $MSG['25_0219'], $MSG['25_0220']));
loadblock($MSG['30_0085'], $MSG['30_0084'], 'yesno', 'users_email', $system->SETTINGS['users_email'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['25_0216']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
