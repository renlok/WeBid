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
include $include_path . 'fonts.inc.php';
include $main_path . 'fck/fckeditor.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$query = " UPDATE " . $DBPrefix . "settings SET
			   showacceptancetext = " . $_POST['showacceptancetext'] . ",
			   acceptancetext = '" . mysql_escape_string($_POST['acceptancetext']) . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['showacceptancetext'] = $_POST['showacceptancetext'];
	$system->SETTINGS['acceptancetext'] = $_POST['acceptancetext'];
	$ERR = $MSG['25_0111'];
}


loadblock($MSG['534'], $MSG['539'], 'batch', 'showacceptancetext', $system->SETTINGS['showacceptancetext'], $MSG['030'], $MSG['029']);

$oFCKeditor = new FCKeditor('acceptancetext');
$oFCKeditor->BasePath = '../fck/';
$oFCKeditor->Value = stripslashes($system->SETTINGS['acceptancetext']);
$oFCKeditor->Width  = '550';
$oFCKeditor->Height = '400';

loadblock($MSG['5078'], $MSG['5080'], $oFCKeditor->CreateHtml());

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'use',
		'TYPENAME' => $MSG['25_0010'],
		'PAGENAME' => $MSG['25_0110']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
