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
$current_page = 'fees';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

$links = array(
	'paypal' => 'http://paypal.com/',
	'authnet' => 'http://authorize.net/',
	'worldpay' => 'http://rbsworldpay.com/',
	'moneybookers' => 'http://moneybookers.com/',
	'toocheckout' => 'http://2checkout.com/'
	);
$variables = array(
	'paypal_address' => $MSG['720'],
	'authnet_address' => $MSG['773'],
	'authnet_password' => $MSG['774'],
	'worldpay_address' => $MSG['824'],
	'moneybookers_address' => $MSG['825'],
	'toocheckout_address' => $MSG['826']
	);

$query = "SELECT * FROM " . $DBPrefix . "gateways LIMIT 1";
$db->direct_query($query);
$gateway_data = $db->result();

$gateways = explode(',', $gateway_data['gateways']);

if (isset($_POST['action']))
{
	// build the sql
	$params = array();
	$query = 'UPDATE ' . $DBPrefix . 'gateways SET ';
	for ($i = 0; $i < count($gateways); $i++)
	{
		if ($i != 0)
			$query .= ', ';
		$gateway = $gateways[$i];
		$query .= $gateway . '_active = :active' . $gateway . ', ';
		$query .= $gateway . '_required = :required' . $gateway . ', ';
		$query .= $gateway . (in_array($gateway, array('worldpay', 'toocheckout')) ? "_id" : "_address") . " = :address" . $gateway;
		$params[] = array(':active' . $gateway, (isset($_POST[$gateway . '_active']) ? 1 : 0), 'int');
		$params[] = array(':required' . $gateway, (isset($_POST[$gateway . '_required']) ? 1 : 0), 'int');
		$params[] = array(':address' . $gateway, $_POST[$gateway . '_address'], 'str');
		if (isset($_POST[$gateway . '_password']))
		{
			$query .= ', ' . $gateway . "_password = :password" . $gateway;
			$params[] = array(':password' . $gateway, $_POST[$gateway . '_password'], 'str');
			$gateway_data[$gateway . '_password'] = $_POST[$gateway . '_password'];
		}
		$gateway_data[$gateway . '_active'] = (isset($_POST[$gateway . '_active']) ? 1 : 0);
		$gateway_data[$gateway . '_required'] = (isset($_POST[$gateway . '_required']) ? 1 : 0);
		$gateway_data[$gateway . '_address'] = $_POST[$gateway . '_address'];
	}
	$db->query($query, $params);
	$ERR = $MSG['762'];
}

for ($i = 0; $i < count($gateways); $i++)
{
	$gateway = $gateways[$i];
	$template->assign_block_vars('gateways', array(
			'NAME' => $system->SETTINGS['gateways'][$gateway],
			'PLAIN_NAME' => $gateway,
			'ENABLED' => ($gateway_data[$gateway . '_active'] == 1) ? 'checked' : '',
			'REQUIRED' => ($gateway_data[$gateway . '_required'] == 1) ? 'checked' : '',
			'ADDRESS' => (isset($gateway_data[$gateway . '_address']) ? $gateway_data[$gateway . '_address'] : $gateway_data[$gateway . '_id']),
			'PASSWORD' => (isset($gateway_data[$gateway . '_password'])) ? $gateway_data[$gateway . '_password'] : '',
			'WEBSITE' => $links[$gateway],
			'ADDRESS_NAME' => $variables[$gateway . '_address'],
			'ADDRESS_PASS' => (isset($variables[$gateway . '_password'])) ? $variables[$gateway . '_password'] : '',

			'B_PASSWORD' => (isset($gateway_data[$gateway . '_password']))
			));
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'fee_gateways.tpl'
		));
$template->display('body');

?>