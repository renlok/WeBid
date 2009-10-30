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

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$query = "UPDATE ". $DBPrefix . "settings SET
			  proxy_bidding = '" . $_POST['proxy_bidding'] . "',
			  edit_starttime = '" . $_POST['edit_starttime'] . "',
			  cust_increment = " . $_POST['cust_increment'] . ",
			  hours_countdown = '" . $_POST['hours_countdown'] . "',
			  ao_hpf_enabled = '" . $_POST['ao_hpf_enabled'] . "',
			  ao_hi_enabled = '" . $_POST['ao_hi_enabled'] . "',
			  ao_bi_enabled = '" . $_POST['ao_bi_enabled'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['edit_starttime'] = $_POST['edit_starttime'];
	$system->SETTINGS['cust_increment'] = $_POST['cust_increment'];
	$system->SETTINGS['hours_countdown'] = $_POST['hours_countdown'];
	$system->SETTINGS['ao_hpf_enabled'] = $_POST['ao_hpf_enabled'];
	$system->SETTINGS['ao_hi_enabled'] = $_POST['ao_hi_enabled'];
	$system->SETTINGS['ao_bi_enabled'] = $_POST['ao_bi_enabled'];
	$system->SETTINGS['proxy_bidding'] = $_POST['proxy_bidding'];
	$ERR = $MSG['5088'];
}

loadblock($MSG['427'], $MSG['428'], 'yesno', 'proxy_bidding', $system->SETTINGS['proxy_bidding'], $MSG['030'], $MSG['029']);
loadblock($MSG['5090'], $MSG['5089'], 'batch', 'edit_starttime', $system->SETTINGS['edit_starttime'], $MSG['030'], $MSG['029']);
loadblock($MSG['068'], $MSG['070'], 'batch', 'cust_increment', $system->SETTINGS['cust_increment'], $MSG['030'], $MSG['029']);
loadblock($MSG['5091'], $MSG['5095'], 'days', 'hours_countdown', $system->SETTINGS['hours_countdown'], $MSG['25_0037']);
loadblock($MSG['142'], $MSG['157'], 'yesno', 'ao_hpf_enabled', $system->SETTINGS['ao_hpf_enabled'], $MSG['030'], $MSG['029']);
loadblock($MSG['162'], $MSG['164'], 'yesno', 'ao_hi_enabled', $system->SETTINGS['ao_hi_enabled'], $MSG['030'], $MSG['029']);
loadblock($MSG['174'], $MSG['194'], 'yesno', 'ao_bi_enabled', $system->SETTINGS['ao_bi_enabled'], $MSG['030'], $MSG['029']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['5087']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
