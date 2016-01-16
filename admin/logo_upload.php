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

/***************************************************************************
 *   Script based on popular MOD "Logo Upload Via Admin" by nay27uk
 ***************************************************************************/

define('InAdmin', 1);
$current_page = 'interface';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);
if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
		// Handle logo upload
		$inf = GetImageSize ($_FILES['logo']['tmp_name']);
		if ($inf[2] < 1 || $inf[2] > 3) {
			print $ERR_602;
			exit;
		}
		if (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name'] != "none") {
			if ($system->move_file($_FILES['logo']['tmp_name'], $main_path . 'uploaded/logo/'  . $_FILES['logo']['name'])) {
				$LOGOUPLOADED = true;
			} else {
				$LOGOUPLOADED = false;
			}
		}
	}
	$v = $_FILES['logo']['name'];
		$params = array();
	$params[] = array(':logo', $v , 'str');
	
	$query = " UPDATE " . $DBPrefix . "settings SET logo = :logo ";
	$db->query($query,$params);
		
	$system->SETTINGS['logo'] = $_FILES['logo']['name'];
}
$logoURL = $system->SETTINGS['siteurl'] . 'uploaded/logo/' . $system->SETTINGS['logo'];
loadblock($MSG['531'], $MSG['556'], 'image', 'logo', $system->SETTINGS['logo']);
loadblock('', $MSG['602'], 'upload', 'logo', $system->SETTINGS['logo']);
$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'IMAGEURL' => $logoURL,
		));
$template->set_filenames(array(
		'body' => 'logo_upload.tpl'
		));
$template->display('body');