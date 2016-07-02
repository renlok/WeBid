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
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission & update database
	$system->writesetting("perpage",  $_POST['perpage'], 'int');
	$system->writesetting("featuredperpage",  $_POST['featuredperpage'], 'int');
	$system->writesetting("thumb_list",  $_POST['thumb_list'], 'int');
	$system->writesetting("loginbox", $_POST['loginbox'], 'int');
	$system->writesetting("newsbox", $_POST['newsbox'], 'int');
	$system->writesetting("newstoshow",$_POST['newstoshow'], 'int');
	$system->writesetting("homefeaturednumber", $_POST['homefeaturednumber'], 'int');
	$system->writesetting("lastitemsnumber", $_POST['lastitemsnumber'], 'int');
	$system->writesetting("hotitemsnumber",  $_POST['hotitemsnumber'], 'int');
	$system->writesetting("endingsoonnumber", $_POST['endingsoonnumber'], 'int');

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['795']));
}

loadblock($MSG['789'], $MSG['790'], 'days', 'perpage', $system->SETTINGS['perpage']);
loadblock('', $MSG['max_featured_items'], 'days', 'featuredperpage', $system->SETTINGS['featuredperpage']);
loadblock($MSG['25_0107'], $MSG['808'], 'decimals', 'thumb_list', $system->SETTINGS['thumb_list'], array($MSG['2__0045']));

loadblock($MSG['807'], '', '', '', '', array(), true);
loadblock($MSG['5011'], $MSG['5012'], 'days', 'homefeaturednumber', $system->SETTINGS['homefeaturednumber']);
loadblock($MSG['5013'], $MSG['5014'], 'days', 'lastitemsnumber', $system->SETTINGS['lastitemsnumber']);
loadblock($MSG['5015'], $MSG['5016'], 'days', 'hotitemsnumber', $system->SETTINGS['hotitemsnumber']);
loadblock($MSG['5017'], $MSG['5018'], 'days', 'endingsoonnumber', $system->SETTINGS['endingsoonnumber']);
loadblock($MSG['532'], $MSG['537'], 'batch', 'loginbox', $system->SETTINGS['loginbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['533'], $MSG['538'], 'batch', 'newsbox', $system->SETTINGS['newsbox'], array($MSG['030'], $MSG['029']));
loadblock('', $MSG['554'], 'days', 'newstoshow', $system->SETTINGS['newstoshow']);

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['788']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
