<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
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

$query = "SELECT * FROM " . $DBPrefix . "gateways LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$gateway_data = mysql_fetch_assoc($res);

$gateways = explode(',', $gateway_data['gateways']);

for ($i = 0; $i < count($gateways); $i++)
{
	$gateway = $gateways[$i];
	$template->assign_block_vars('gateways', array(
			'NAME' => $gateway,
			'ENABLED' => $gateway_data[$gateway . '_active'],
			'REQUIRED' => $gateway_data[$gateway . '_required'],
			'ADDRESS' => $gateway_data[$gateway . '_address']
			));
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($errmsg)) ? $errmsg : ''
		));

$template->set_filenames(array(
		'body' => 'fee_gateways.tpl'
		));
$template->display('body');
?>
