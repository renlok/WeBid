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
include INCLUDE_PATH . 'config/timezones.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$system->writesetting("timezone", $_POST['timezone'], "str");
	$system->writesetting("datesformat", $_POST['datesformat'], "str");
	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['347']));
}

$selectsetting = $system->SETTINGS['timezone'];
$html = generateSelect('timezone', $timezones);

//load the template
loadblock($MSG['363'], $MSG['379'], 'datestacked', 'datesformat', $system->SETTINGS['datesformat'], array($MSG['382'], $MSG['383']));
loadblock($MSG['346'], $MSG['345'], 'dropdown', 'timezone', $system->SETTINGS['timezone']);

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['344'],
		'DROPDOWN' => $html
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
