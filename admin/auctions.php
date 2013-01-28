<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if ($_POST['status'] == 'enabled' && (!is_numeric($_POST['timebefore']) || !is_numeric($_POST['extend'])))
	{
		$ERR = $MSG['2_0038'];
	}
	elseif ($_POST['maxpicturesize'] == 0)
	{
		$ERR = $ERR_707;
	}
	elseif (!empty($_POST['maxpicturesize']) && !intval($_POST['maxpicturesize']))
	{
		$ERR = $ERR_708;
	}
	elseif (!empty($_POST['maxpictures']) && !intval($_POST['maxpictures']))
	{
		$ERR = $ERR_706;
	}
	else
	{
		// Update database
		$query = "UPDATE ". $DBPrefix . "settings SET
				  proxy_bidding = '" . $_POST['proxy_bidding'] . "',
				  edit_starttime = '" . $_POST['edit_starttime'] . "',
				  cust_increment = " . $_POST['cust_increment'] . ",
				  hours_countdown = '" . $_POST['hours_countdown'] . "',
				  ao_hpf_enabled = '" . $_POST['ao_hpf_enabled'] . "',
				  ao_hi_enabled = '" . $_POST['ao_hi_enabled'] . "',
				  ao_bi_enabled = '" . $_POST['ao_bi_enabled'] . "',
				  subtitle = '" . $_POST['subtitle'] . "',
				  extra_cat = '" . $_POST['extra_cat'] . "',
				  autorelist = '" . $_POST['autorelist'] . "',
				  autorelist_max = '" . $_POST['autorelist_max'] . "',
				  ae_status = '" . $_POST['status'] . "',
				  ae_timebefore = " . intval($_POST['timebefore']) . ",
				  ae_extend = " . intval($_POST['extend']) . ",
				  picturesgallery = " . $_POST['picturesgallery'] . ",
				  maxpictures = " . $_POST['maxpictures'] . ",
				  maxuploadsize = " . ($_POST['maxpicturesize'] * 1024) . ",
				  thumb_show = " . intval($_POST['thumb_show']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$ERR = $MSG['5088'];
	}
	$system->SETTINGS['edit_starttime'] = $_POST['edit_starttime'];
	$system->SETTINGS['cust_increment'] = $_POST['cust_increment'];
	$system->SETTINGS['hours_countdown'] = $_POST['hours_countdown'];
	$system->SETTINGS['ao_hpf_enabled'] = $_POST['ao_hpf_enabled'];
	$system->SETTINGS['ao_hi_enabled'] = $_POST['ao_hi_enabled'];
	$system->SETTINGS['ao_bi_enabled'] = $_POST['ao_bi_enabled'];
	$system->SETTINGS['proxy_bidding'] = $_POST['proxy_bidding'];
	$system->SETTINGS['subtitle'] = $_POST['subtitle'];
	$system->SETTINGS['extra_cat'] = $_POST['extra_cat'];
	$system->SETTINGS['autorelist'] = $_POST['autorelist'];
	$system->SETTINGS['autorelist_max'] = $_POST['autorelist_max'];

	$system->SETTINGS['ae_status'] = $_POST['status'];
	$system->SETTINGS['ae_timebefore'] = $_POST['timebefore'];
	$system->SETTINGS['ae_extend'] = $_POST['extend'];

	$system->SETTINGS['picturesgallery'] = $_POST['picturesgallery'];
	$system->SETTINGS['maxpictures'] = $_POST['maxpictures'];
	$system->SETTINGS['maxuploadsize'] = $_POST['maxpicturesize'] * 1024;
	$system->SETTINGS['thumb_show'] = $_POST['thumb_show'];
}

loadblock($MSG['427'], $MSG['428'], 'yesno', 'proxy_bidding', $system->SETTINGS['proxy_bidding'], array($MSG['030'], $MSG['029']));
loadblock($MSG['5090'], $MSG['5089'], 'batch', 'edit_starttime', $system->SETTINGS['edit_starttime'], array($MSG['030'], $MSG['029']));
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

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['5087']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
