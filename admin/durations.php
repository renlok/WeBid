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
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

	for ($i = 0; $i < count($rebuilt_durations); $i++)
	{
		$query = "INSERT INTO " . $DBPrefix . "durations VALUES (" . $rebuilt_days[$i] . ", '" . $system->cleanvars($rebuilt_durations[$i]) . "')";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}

	$ERR = $MSG['123'];
}

$query = "SELECT * FROM " . $DBPrefix . "durations ORDER BY days";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('dur', array(
			'ID' => $i,
			'DAYS' => $row['days'],
			'DESC' => $row['description']
			));
	$i++;
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'durations.tpl'
		));
$template->display('body');

?>