<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2015 WeBid
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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . 'ckeditor/ckeditor.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['terms'] = ynbool($_POST['terms']);
	$system->SETTINGS['termstext'] = $system->cleanvars($_POST['termstext']);
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET
			terms = :terms,
			termstext = :termstext";
	$params = array();
	$params[] = array(':terms', $system->SETTINGS['terms'], 'str');
	$params[] = array(':termstext', $system->SETTINGS['termstext'], 'str');
	$db->query($query, $params);
	$ERR = $MSG['5084'];
}

loadblock($MSG['5082'], $MSG['5081'], 'yesno', 'terms', $system->SETTINGS['terms'], array($MSG['030'], $MSG['029']));

$CKEditor = new CKEditor();
$CKEditor->basePath = $main_path . 'ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

loadblock($MSG['5083'], $MSG['5080'], $CKEditor->editor('termstext', $system->uncleanvars($system->SETTINGS['termstext'])));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'con',
		'TYPENAME' => $MSG['25_0018'],
		'PAGENAME' => $MSG['5075']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
