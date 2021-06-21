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
	if ($_POST['status'] == 'enabled' && (!is_numeric($_POST['timebefore']) || !is_numeric($_POST['extend'])))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['2_0038']));
	}
	elseif ($_POST['maxpicturesize'] == 0)
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_707));
	}
	elseif (!empty($_POST['maxpicturesize']) && !intval($_POST['maxpicturesize']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_708));
	}
	elseif (!empty($_POST['maxpictures']) && !intval($_POST['maxpictures']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_706));
	}
	else
	{
		$system->writesetting("proxy_bidding",ynbool($_POST['proxy_bidding']), 'str');
		$system->writesetting("edit_starttime", $_POST['edit_starttime'], 'int');
		$system->writesetting("edit_endtime", $_POST['edit_endtime'], 'int');
		$system->writesetting("cust_increment", $_POST['cust_increment'], 'int');
		$system->writesetting("hours_countdown", $_POST['hours_countdown'], 'int');
		$system->writesetting("ao_hpf_enabled", ynbool($_POST['ao_hpf_enabled']), 'str');
		$system->writesetting("ao_hi_enabled", ynbool($_POST['ao_hi_enabled']), 'str');
		$system->writesetting("ao_bi_enabled", ynbool($_POST['ao_bi_enabled']), 'str');
		$system->writesetting("subtitle", ynbool($_POST['subtitle']), 'str');
		$system->writesetting("extra_cat", ynbool($_POST['extra_cat']), 'str');
		$system->writesetting("autorelist", ynbool($_POST['autorelist']), 'str');
		$system->writesetting("autorelist_max", $_POST['autorelist_max'], 'int');
		$system->writesetting("ae_status", ynbool($_POST['status']), 'str');
		$system->writesetting("ae_timebefore", $_POST['timebefore'], 'int');
		$system->writesetting("ae_extend", $_POST['extend'], 'int');
		$system->writesetting("picturesgallery", $_POST['picturesgallery'], 'int');
		$system->writesetting("maxpictures", $_POST['maxpictures'], 'int');
		$system->writesetting("maxuploadsize", ($_POST['maxpicturesize'] * 1024), 'int');
		$system->writesetting("thumb_show", $_POST['thumb_show'], 'int');
		$system->writesetting("gallery_max_width_height", $_POST['gallery_max_width_height'], 'int');

		$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['5088']));
	}
}

loadblock($MSG['427'], $MSG['428'], 'yesno', 'proxy_bidding', $system->SETTINGS['proxy_bidding'], array($MSG['030'], $MSG['029']));
loadblock($MSG['5090'], $MSG['5089'], 'batch', 'edit_starttime', $system->SETTINGS['edit_starttime'], array($MSG['030'], $MSG['029']));
loadblock($MSG['allow_custom_end_date'], $MSG['allow_custom_end_date_explain'], 'batch', 'edit_endtime', $system->SETTINGS['edit_endtime'], array($MSG['030'], $MSG['029']));
loadblock($MSG['068'], $MSG['070'], 'batch', 'cust_increment', $system->SETTINGS['cust_increment'], array($MSG['030'], $MSG['029']));
loadblock($MSG['5091'], $MSG['5095'], 'days', 'hours_countdown', $system->SETTINGS['hours_countdown'], array($MSG['25_0037']));

loadblock($MSG['897'], '', '', '', '', array(), true);
loadblock($MSG['142'], $MSG['157'], 'yesno', 'ao_hpf_enabled', $system->SETTINGS['ao_hpf_enabled'], array($MSG['030'], $MSG['029']));
loadblock($MSG['162'], $MSG['164'], 'yesno', 'ao_hi_enabled', $system->SETTINGS['ao_hi_enabled'], array($MSG['030'], $MSG['029']));
loadblock($MSG['174'], $MSG['194'], 'yesno', 'ao_bi_enabled', $system->SETTINGS['ao_bi_enabled'], array($MSG['030'], $MSG['029']));
loadblock($MSG['797'], $MSG['798'], 'yesno', 'subtitle', $system->SETTINGS['subtitle'], array($MSG['030'], $MSG['029']));
loadblock($MSG['799'], $MSG['800'], 'yesno', 'extra_cat', $system->SETTINGS['extra_cat'], array($MSG['030'], $MSG['029']));
loadblock($MSG['849'], $MSG['850'], 'yesno', 'autorelist', $system->SETTINGS['autorelist'], array($MSG['030'], $MSG['029']));
loadblock($MSG['851'], $MSG['852'], 'days', 'autorelist_max', $system->SETTINGS['autorelist_max']);

// auction extension options
loadblock($MSG['2_0032'], '', '', '', '', array(), true); // :O
loadblock($MSG['2_0034'], $MSG['2_0039'], 'yesno', 'status', $system->SETTINGS['ae_status'], array($MSG['030'], $MSG['029']));
$string = $MSG['2_0035'] . '<input type="text" name="extend" value="' . $system->SETTINGS['ae_extend'] . '" size="5">' . $MSG['2_0036'] . '<input type="text" name="timebefore" value="' . $system->SETTINGS['ae_timebefore'] . '" size="5">' . $MSG['2_0037'];
loadblock('', $string, '');

// picture gallery options
loadblock($MSG['663'], '', '', '', '', array(), true);
loadblock($MSG['665'], $MSG['664'], 'batch', 'picturesgallery', $system->SETTINGS['picturesgallery'], array($MSG['030'], $MSG['029']));
loadblock($MSG['666'], '', 'days', 'maxpictures', $system->SETTINGS['maxpictures']);
loadblock($MSG['671'], $MSG['25_0187'], 'decimals', 'maxpicturesize', ($system->SETTINGS['maxuploadsize'] / 1024), array($MSG['672']));
loadblock($MSG['25_0107'], $MSG['896'], 'decimals', 'thumb_show', $system->SETTINGS['thumb_show'], array($MSG['2__0045']));
loadblock($MSG['gallery_image_max_size'], $MSG['gallery_image_max_size_explain'], 'decimals', 'gallery_max_width_height', $system->SETTINGS['gallery_max_width_height'], array($MSG['2__0045']));

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['5087']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
