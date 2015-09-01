<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// update users
	if ($system->SETTINGS['fee_max_debt'] < $_POST['fee_max_debt'])
	{
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE suspended = 7 AND balance > :fee_max_debt";
		$params = array();
		$params[] = array(':fee_max_debt', $_POST['fee_max_debt'], 'int');
		$db->query($query, $params);
	}
	// Update database
	$query = "UPDATE ". $DBPrefix . "settings SET
			  fees = :fees,
			  fee_type = :fee_type,
			  fee_max_debt = :fee_max_debt
			  fee_signup_bonus = :fee_signup_bonus,
			  fee_disable_acc = :fee_disable_acc,
			  paypal_sandbox = :pp_sandbox,
			  worldpay_sandbox = :wp_sandbox,
			  moneybookers_sandbox = :mb_sandbox,
			  authnet_sandbox = :ah_sandbox,
			  checkout_sandbox = :co_sandbox";
	$params = array();
	$params[] = array(':fees', $_POST['fees'], 'str');
	$params[] = array(':fee_type', $_POST['fee_type'], 'int');
	$params[] = array(':fee_max_debt', $system->input_money($_POST['fee_max_debt']), 'int');
	$params[] = array(':fee_signup_bonus', $system->input_money($_POST['fee_signup_bonus']), 'int');
	$params[] = array(':fee_disable_acc', $_POST['fee_disable_acc'], 'str');
	$params[] = array(':pp_sandbox', $_POST['disable_pp_sandbox'], 'str');
	$params[] = array(':wp_sandbox', $_POST['disable_wp_sandbox'], 'str');
	$params[] = array(':mb_sandbox', $_POST['disable_mb_sandbox'], 'str');
	$params[] = array(':ah_sandbox', $_POST['disable_ah_sandbox'], 'str');
	$params[] = array(':co_sandbox', $_POST['disable_co_sandbox'], 'str');
	$db->query($query, $params);
	$system->SETTINGS['fees'] = $_POST['fees'];
	$system->SETTINGS['fee_type'] = $_POST['fee_type'];
	$system->SETTINGS['fee_max_debt'] = $_POST['fee_max_debt'];
	$system->SETTINGS['fee_signup_bonus'] = $_POST['fee_signup_bonus'];
	$system->SETTINGS['fee_disable_acc'] = $_POST['fee_disable_acc'];
	$system->SETTINGS['paypal_sandbox'] = $_POST['disable_pp_sandbox'];
	$system->SETTINGS['worldpay_sandbox'] = $_POST['disable_wp_sandbox'];
	$system->SETTINGS['moneybookers_sandbox'] = $_POST['disable_mb_sandbox'];
	$system->SETTINGS['authnet_sandbox'] = $_POST['disable_ah_sandbox'];
	$system->SETTINGS['checkout_sandbox'] = $_POST['disable_co_sandbox'];
	$ERR = $MSG['761'];
}

loadblock($MSG['395'], $MSG['397'], 'yesno', 'fees', $system->SETTINGS['fees'], array($MSG['759'], $MSG['760']));
loadblock($MSG['729'], $MSG['730'], 'batchstacked', 'fee_type', $system->SETTINGS['fee_type'], array($MSG['731'], $MSG['732']));

loadblock($MSG['1154'], '', '', '', '', array(), true);
loadblock($MSG['1155'], $MSG['1156'], 'bool', 'disable_pp_sandbox', $system->SETTINGS['paypal_sandbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1157'], $MSG['1158'], 'bool', 'disable_wp_sandbox', $system->SETTINGS['worldpay_sandbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1159'], $MSG['1160'], 'bool', 'disable_mb_sandbox', $system->SETTINGS['moneybookers_sandbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1161'], $MSG['1162'], 'bool', 'disable_ah_sandbox', $system->SETTINGS['authnet_sandbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1163'], $MSG['1164'], 'bool', 'disable_co_sandbox', $system->SETTINGS['checkout_sandbox'], array($MSG['030'], $MSG['029']));

loadblock($MSG['733'], '', '', '', '', array(), true);
loadblock($MSG['734'], $MSG['735'], 'days', 'fee_max_debt', $system->SETTINGS['fee_max_debt']);
loadblock($MSG['736'], $MSG['737'], 'days', 'fee_signup_bonus', $system->SETTINGS['fee_signup_bonus']);
loadblock($MSG['738'], $MSG['739'], 'yesno', 'fee_disable_acc', $system->SETTINGS['fee_disable_acc'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0012'],
		'PAGENAME' => $MSG['395'],
		'B_TITLES' => true
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
