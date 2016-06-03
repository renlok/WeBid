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
	// Update database
	$system->writesetting("aboutus", ynbool($_POST['aboutus']), "str");
	$system->writesetting("aboutustext", $system->cleanvars($_POST['aboutustext'], true), "str");

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['5079']));
}

loadblock($MSG['5077'], $MSG['5076'], 'yesno', 'aboutus', $system->SETTINGS['aboutus'], array($MSG['030'], $MSG['029']));

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

loadblock($MSG['5078'], $MSG['5080'], $CKEditor->editor('aboutustext', $system->SETTINGS['aboutustext']));

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0018'],
		'PAGENAME' => $MSG['5074']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
