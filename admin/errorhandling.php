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
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . 'ckeditor/ckeditor.php';
include $include_path . 'htmLawed.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['errortext'] = htmLawed($_POST['errortext'], array('safe'=>1));
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET errortext = :errortext";
	$params = array();
	$params[] = array(':errortext', $system->SETTINGS['errortext'], 'str');
	$db->query($query, $params);
	$ERR = $MSG['413'];
}

$CKEditor = new CKEditor();
$CKEditor->basePath = $main_path . 'ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

loadblock($MSG['411'], $MSG['410'], $CKEditor->editor('errortext', $system->uncleanvars($system->SETTINGS['errortext'])));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['409']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
