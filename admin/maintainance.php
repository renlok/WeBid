<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

require('../includes/config.inc.php');
include "loggedin.inc.php";
include $main_path . "fck/fckeditor.php";

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update") {
	// Check if the specified user exists
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = '" . $_POST['superuser'] . "'";
	$res_ = mysql_query($query);
	$system->check_mysql($res_, $query, __LINE__, __FILE__);
	if(mysql_num_rows($res_) == 0 && $_POST[active] == 'y') {
		$ERR = $ERR_025;
	} else {
		// Update database
		$query = "UPDATE " . $DBPrefix . "maintainance SET
				superuser = '" . $_POST['superuser'] . "',
				maintainancetext = '" . addslashes($_POST['maintainancetext']) . "',
				active = '" . $_POST['active'] . "'";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$system->SETTINGS['superuser'] = $_POST['superuser'];
		$system->SETTINGS['maintainancetext'] = $_POST['maintainancetext'];		
		$system->SETTINGS['active'] = $_POST['active'];
		$ERR = $MSG['_0005'];
	}
} else {
	$query = "SELECT * FROM " . $DBPrefix . "maintainance LIMIT 1";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$system->SETTINGS['superuser'] = mysql_result($res, 0, 'superuser');
	$system->SETTINGS['maintainancetext'] = mysql_result($res, 0, 'maintainancetext');		
	$system->SETTINGS['active'] = mysql_result($res, 0, 'active');
}

loadblock('', $MSG['_0002']);
loadblock($MSG['_0006'], '', 'yesno', 'active', $system->SETTINGS['active'], $MSG['030'], $MSG['029']);
loadblock($MSG['003'], '', 'text', 'superuser', $system->SETTINGS['superuser'], $MSG['030'], $MSG['029']);

$oFCKeditor = new FCKeditor('maintainancetext');
$oFCKeditor->BasePath = '../fck/';
$oFCKeditor->Value = stripslashes($system->SETTINGS['maintainancetext']);
$oFCKeditor->Width  = '550';
$oFCKeditor->Height = '400';

loadblock($MSG['_0004'], '', $oFCKeditor->CreateHtml());

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'too',
		'TYPENAME' => $MSG['5436'],
		'PAGENAME' => $MSG['_0001']
		));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
