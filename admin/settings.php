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
	// Data check
	if (empty($_POST['sitename']) || empty($_POST['siteurl']) || empty($_POST['adminmail']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
	}
	elseif (!is_numeric($_POST['archiveafter']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_043));
	}
	else
	{
		// Update data
		$system->writesetting(array(
			array("sitename", $_POST['sitename'], 'str'),
			array("adminmail", $_POST['adminmail'], 'str'),
			array("siteurl", $_POST['siteurl'], 'str'),
			array("copyright", $_POST['copyright'], 'str'),
			array("cron", $_POST['cron'], 'int'),
			array("archiveafter", $_POST['archiveafter'], 'int'),
			array("cache_theme", $_POST['cache_theme'], 'str'),
			array("https", $_POST['https'], 'str'),
			array("https_url", $_POST['https_url'], 'str'),
		));
		
		$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['542']));
	}
}

// general settings
loadblock($MSG['527'], $MSG['535'], 'text', 'sitename', $system->SETTINGS['sitename']);
loadblock($MSG['528'], $MSG['536'], 'text', 'siteurl', $system->SETTINGS['siteurl']);
loadblock($MSG['540'], $MSG['541'], 'text', 'adminmail', $system->SETTINGS['adminmail']);
loadblock($MSG['191'], $MSG['192'], 'text', 'copyright', $system->SETTINGS['copyright']);

// batch settings
loadblock($MSG['348'], '', '', '', '', array(), true);
loadblock($MSG['372'], $MSG['371'], 'batch', 'cron', $system->SETTINGS['cron'], array($MSG['373'], $MSG['374']));
loadblock($MSG['376'], $MSG['375'], 'days', 'archiveafter', $system->SETTINGS['archiveafter'], array($MSG['377']));

// optimisation settings
loadblock($MSG['725'], '', '', '', '', array(), true);
loadblock($MSG['726'], $MSG['727'], 'yesno', 'cache_theme', $system->SETTINGS['cache_theme'], array($MSG['030'], $MSG['029']));

// SLL settings
loadblock($MSG['1022'], '', '', '', '', array(), true);
loadblock($MSG['1023'], $MSG['1024'], 'yesno', 'https', $system->SETTINGS['https'], array($MSG['030'], $MSG['029']));
loadblock($MSG['801'], $MSG['802'], 'text', 'https_url', $system->SETTINGS['https_url']);

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['526'],
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
