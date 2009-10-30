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

if ($_POST['action'] == 'update')
{
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings set
			boards = '" . $_POST['boards'] . "',
			boardslink = '" . $_POST['boardslink'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$ERR = $MSG['5051'];
	$system->SETTINGS['boards'] = $_POST['boards'];
	$system->SETTINGS['boardslink'] = $_POST['boardslink'];
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'BOARDS_YES' => ($system->SETTINGS['boards'] == 'y') ? ' checked' : '',
		'BOARDS_NO' => ($system->SETTINGS['boards'] == 'n') ? ' checked' : '',
		'BOARDS_LINK_YES' => ($system->SETTINGS['boardslink'] == 'y') ? ' checked' : '',
		'BOARDS_LINK_NO' => ($system->SETTINGS['boardslink'] == 'n') ? ' checked' : ''
		));

$template->set_filenames(array(
		'body' => 'boardsettings.tpl'
		));
$template->display('body');
?>