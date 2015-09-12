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
$current_page = 'banners';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['banners'] = intval($_POST['banners']);
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET banners = :banners";
	$params = array();
	$params[] = array(':banners', $system->SETTINGS['banners'], 'int');
	$db->query($query, $params);
	$ERR = $MSG['600'];
}

loadblock($MSG['597'], '', 'batch', 'banners', $system->SETTINGS['banners'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'TYPENAME' => $MSG['25_0011'],
		'PAGENAME' => $MSG['5205']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
