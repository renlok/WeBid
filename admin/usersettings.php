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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$system->writesetting("usersauth", $_POST['usersauth'], 'str');
	$system->writesetting("activationtype", $_POST['usersconf'], 'int');
	$ERR = $MSG['895'];

	$system->SETTINGS['usersauth'] = $_POST['usersauth'];
	$system->SETTINGS['activationtype'] = $_POST['usersconf'];
}

loadblock($MSG['25_0151'], $MSG['25_0152'], 'yesnostacked', 'usersauth', $system->SETTINGS['usersauth'], array($MSG['2__0066'], $MSG['2__0067']));
loadblock($MSG['25_0151_a'], $MSG['25_0152_a'], 'select3num', 'usersconf', $system->SETTINGS['activationtype'], array($MSG['25_0152_b'], $MSG['25_0152_c'], $MSG['25_0152_d']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['894']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>