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
$current_page = 'fees';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$system->writesetting("taxuser", $_POST['taxuser'],"str");
	$system->writesetting("tax", $_POST['tax'],"str");
	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['1089']));
}

loadblock($MSG['1090'], $MSG['1091'], 'yesno', 'tax', $system->SETTINGS['tax'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1092'], $MSG['1093'], 'yesno', 'taxuser', $system->SETTINGS['taxuser'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0012'],
		'PAGENAME' => $MSG['1088']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
