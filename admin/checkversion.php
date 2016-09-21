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

define('InAdmin', 1);
$current_page = 'tools';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (!($realversion = load_file_from_url('http://www.webidsupport.com/version.txt')))
{
	$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_25_0002));
	$realversion = 'Unknown';
}

if (version_compare($system->SETTINGS['version'], $realversion, "<"))
{ 
	$myversion = '<span style="color:#ff0000;">' . $system->SETTINGS['version'] . '</span>';
	$text = $MSG['30_0211'];
}
else
{ 
	$myversion = '<span style="color:#00ae00;">' . $system->SETTINGS['version'] . '</span>';
	$text = $MSG['30_0212']; 
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TEXT' => $text,
		'MYVERSION' => $myversion,
		'REALVERSION' => $realversion
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'checkversion.tpl'
		));
$template->display('body');
include 'footer.php';
?>
