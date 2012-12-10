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
$current_page = 'banners';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

// Delete users and banners if necessary
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		$query = "DELETE FROM " . $DBPrefix . "banners WHERE user = " . $v;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "DELETE FROM " . $DBPrefix . "bannersusers WHERE id = " . $v;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
}

// Retrieve users from the database
$query = "SELECT u.*, COUNT(b.user) as count FROM " . $DBPrefix . "bannersusers u
		LEFT JOIN " . $DBPrefix . "banners b ON (b.user = u.id)
		GROUP BY u.id ORDER BY u.name";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$bg = '';
while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('busers', array(
			'ID' => $row['id'],
			'NAME' => $row['name'],
			'COMPANY' => $row['company'],
			'EMAIL' => $row['email'],
			'NUM_BANNERS' => $row['count'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'managebanners.tpl'
		));
$template->display('body');
?>
