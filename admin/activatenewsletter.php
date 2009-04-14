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

define('InAdmin', 1);
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $include_path . 'fonts.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name'] != "none") {
		$TARGET = $upload_path.$_FILES['logo']['name'];
		move_uploaded_file($_FILES['logo']['tmp_name'],$TARGET);
		chmod($TARGET,0666);
		
		$LOGOUPLOADED = TRUE;
	}
	
	$query = "UPDATE " . $DBPrefix . "settings SET
			newsletter = " . intval($_POST['newsletter']);
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['newsletter'] = $_POST['newsletter'];
	$ERR = $MSG['30_0049'];
}

loadblock($MSG['603'], $MSG['604'], 'batch', 'newsletter', $system->SETTINGS['newsletter'], $MSG['030'], $MSG['029']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'use',
		'TYPENAME' => $MSG['25_0010'],
		'PAGENAME' => $MSG['25_0079']
		));

$template->set_filenames(array(
		'body' => 'adminpages.html'
		));
$template->display('body');
?>
