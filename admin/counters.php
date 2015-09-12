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
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['counter_auctions'] = isset($_POST['auctions'])? 'y' : 'n';
	$system->SETTINGS['counter_users']    = isset($_POST['users'])? 'y' : 'n';
	$system->SETTINGS['counter_online']   = isset($_POST['online'])? 'y' : 'n';
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET
			  counter_auctions = :counter_auctions,
			  counter_users = :counter_users,
			  counter_online = :counter_online";
	$params = array();
	$params[] = array(':counter_auctions', $system->SETTINGS['counter_auctions'], 'str');
	$params[] = array(':counter_users', $system->SETTINGS['counter_users'], 'str');
	$params[] = array(':counter_online', $system->SETTINGS['counter_online'], 'str');
	$db->query($query, $params);
	$ERR = $MSG['2__0063'];
}

loadblock($MSG['2__0062'], $MSG['2__0058']);
loadblock($MSG['2__0060'], '', 'checkbox', 'auctions', $system->SETTINGS['counter_auctions']);
loadblock($MSG['2__0061'], '', 'checkbox', 'users', $system->SETTINGS['counter_users']);
loadblock($MSG['2__0059'], '', 'checkbox', 'online', $system->SETTINGS['counter_online']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['2__0057']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>