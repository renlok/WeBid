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

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	foreach ($_POST['payment'] as $payment)
	{
		if (isset($payment['delete']))
		{
			$query = "DELETE FROM " . $DBPrefix . "payment_options WHERE id = :id";
			$params = [[':id', $payment['id'], 'int']];
			$db->query($query, $params);
		}
		else
		{
			// clean the clean name
			if ($payment['clean'] == '')
			{
				$payment['clean'] = strtolower($payment['name']);
			}
			$payment['clean'] = preg_replace("/[^a-z]/", '', $payment['clean']);
			$query = "UPDATE " . $DBPrefix . "payment_options
					SET name = :name,
					displayname = :displayname
					WHERE id = :id";
			$params = [
				[':id', $payment['id'], 'int'],
				[':name', $payment['name'], 'str'],
				[':displayname', $payment['clean'], 'str'],
			];
			$db->query($query, $params);
		}
	}

	if ($_POST['new_payments'] != '' && $_POST['new_payments_clean'] != '')
	{
		$query = "INSERT INTO " . $DBPrefix . "payment_options (name, displayname, is_gateway) VALUES (:name, :displayname, 0)";
		$params = [
			[':name', $payment['name'], 'str'],
			[':displayname', $payment['clean'], 'str'],
		];
		$db->query($query, $params);
	}

	$ERR = $MSG['093'];
}

$query = "SELECT * FORM " . $DBPrefix . "payment_options WHERE is_gateway = 0";
$db->direct_query($query);
$payment_options = $db->fetchAll();
foreach ($payment_options as $payment_type)
{
	$template->assign_block_vars('payments', array(
			'NAME' => $payment_type['displayname'],
			'CLEAN' => $payment_type['name'],
			'ID' => $payment_type['id']
			));
}


$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'payments.tpl'
		));
$template->display('body');

include 'footer.php';
?>
