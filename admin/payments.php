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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

function ToBeDeleted($index)
{
	if (!isset($_POST['delete']))
		return false;

	$i = 0;
	while ($i < count($_POST['delete']))
	{
		if ($_POST['delete'][$i] == $index) return true;
		$i++;
	}
	return false;
}


if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Build new payments array
	$rebuilt_array = array();
	for ($i = 0; $i < count($_POST['new_payments']); $i++)
	{
		if (!ToBeDeleted($i) && strlen($_POST['new_payments'][$i]) != 0)
		{
			$rebuilt_array[] = $_POST['new_payments'][$i];
		}
	}

	$system->writesetting("payment_options", serialize($rebuilt_array), "str");
	$ERR = $MSG['093'];
}

$payment_options = unserialize($system->SETTINGS['payment_options']);
foreach ($payment_options as $k => $v)
{
	$template->assign_block_vars('payments', array(
			'PAYMENT' => $v,
			'ID' => $k
			));
}


$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'payments.tpl'
		));
$template->display('body');

?>