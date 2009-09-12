<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . "fck/fckeditor.php";

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == "update") {
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET
			terms = '" . $_POST['terms'] . "',
			termstext = '" . mysql_escape_string($_POST['termstext']) . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['terms'] = $_POST['terms'];
	$system->SETTINGS['termstext'] = $_POST['termstext'];
	$ERR = $MSG['5084'];
}
loadblock($MSG['5082'], $MSG['5081'], 'yesno', 'terms', $system->SETTINGS['terms'], $MSG['030'], $MSG['029']);

$oFCKeditor = new FCKeditor('termstext');
$oFCKeditor->BasePath = '../fck/';
$oFCKeditor->Value = stripslashes($system->SETTINGS['termstext']);
$oFCKeditor->Width  = '550';
$oFCKeditor->Height = '400';

loadblock($MSG['5083'], $MSG['5080'], $oFCKeditor->CreateHtml());

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
