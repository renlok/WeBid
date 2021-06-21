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
$current_page = 'banners';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission and update database
	$system->writesetting("banners", intval($_POST['banners']), "int");

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['600']));
}

loadblock($MSG['597'], $MSG['_0014'], 'batch', 'banners', $system->SETTINGS['banners'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
		'TYPENAME' => $MSG['25_0011'],
		'PAGENAME' => $MSG['_0008'] . ' : ' . $MSG['5205']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
