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
$current_page = 'contents';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';
include PACKAGE_PATH . 'ckeditor/ckeditor.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission and update database
	$system->writesetting("terms", ynbool($_POST['terms']), "str");
	$system->writesetting("termstext", $system->cleanvars($_POST['termstext'], true), "str");
	
	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['5084']));
}

loadblock($MSG['5082'], $MSG['5081'], 'yesno', 'terms', $system->SETTINGS['terms'], array($MSG['030'], $MSG['029']));

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

loadblock($MSG['5083'], $MSG['5080'], $CKEditor->editor('termstext', $system->SETTINGS['termstext']));

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'con',
		'TYPENAME' => $MSG['25_0018'],
		'PAGENAME' => $MSG['5075']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
