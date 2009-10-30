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

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['sizetype']))
	{
		$ERR = $ERR_047;
	}
	elseif ($_POST['sizetype'] == 'fix' && (empty($_POST['width']) || empty($_POST['height'])))
	{
		$ERR = $ERR_047;
	}
	elseif ($_POST['sizetype'] == 'fix' && (!ereg("^[0-9]+$", $_POST['width']) || !ereg("^[0-9]+$", $_POST['height'])))
	{
		$ERR = $MSG['_0020'];
	}
	else
	{
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				banner_sizetype = '" . $_POST['sizetype'] . "',
				banner_width = " . intval($_POST['width']) . ",
				banner_height = " . intval($_POST['height']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$ERR = $MSG['600'];
	}
	$system->SETTINGS['banner_sizetype'] = $_POST['sizetype'];
	$system->SETTINGS['banner_width'] = $_POST['width'];
	$system->SETTINGS['banner_height'] = $_POST['height'];
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'BANNER_SIZE_ANY' => ($system->SETTINGS['banner_sizetype'] == 'any') ? ' checked' : '',
		'BANNER_SIZE_FIX' => ($system->SETTINGS['banner_sizetype'] == 'any') ? ' checked' : '',
		'BANNER_WIDTH' => $system->SETTINGS['banner_width'],
		'BANNER_HEIGHT' => $system->SETTINGS['banner_height']
		));

$template->set_filenames(array(
		'body' => 'bannersettings.tpl'
		));
$template->display('body');

?>