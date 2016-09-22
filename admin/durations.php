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
	// update durations table
	$rebuilt_durations = array();
	$rebuilt_days = array();

	foreach ($_POST['new_durations'] as $k => $v)
	{
		if ((isset($_POST['delete']) && !in_array($k, $_POST['delete']) || !isset($_POST['delete'])) && !empty($_POST['new_durations'][$k]) && !empty($_POST['new_days'][$k]))
		{
			$rebuilt_durations[] = $_POST['new_durations'][$k];
			$rebuilt_days[] = $_POST['new_days'][$k];
		}
	}

	$query = "DELETE FROM " . $DBPrefix . "durations";
	$db->direct_query($query);

	for ($i = 0; $i < count($rebuilt_durations); $i++)
	{
		$query = "INSERT INTO " . $DBPrefix . "durations VALUES (:day_count, :day_string)";
		$params = array();
		$params[] = array(':day_count', $rebuilt_days[$i], 'int');
		$params[] = array(':day_string', $rebuilt_durations[$i], 'str');
		$db->query($query, $params);
	}

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['123']));
}

$query = "SELECT * FROM " . $DBPrefix . "durations ORDER BY days";
$db->direct_query($query);

$i = 0;
while ($row = $db->fetch())
{
	$template->assign_block_vars('dur', array(
			'ID' => $i,
			'DAYS' => $row['days'],
			'DESC' => $row['description']
			));
	$i++;
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'durations.tpl'
		));
$template->display('body');

include 'footer.php';
?>