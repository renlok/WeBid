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
	// clean submission and update database
	$system->writesetting("descriptiontag", $system->cleanvars($_POST['descriptiontag']),"str");
	$system->writesetting("keywordstag", $system->cleanvars($_POST['keywordstag']),"str");
	
	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['25_0185']));
}

loadblock($MSG['25_0180'], $MSG['25_0182'], 'textarea', 'descriptiontag', $system->SETTINGS['descriptiontag']);
loadblock($MSG['25_0181'], $MSG['25_0184'], 'textarea', 'keywordstag', $system->SETTINGS['keywordstag']);

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['25_0178']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
