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
$current_page = 'tools';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'clearlog')
{
	$query = "DELETE FROM " . $DBPrefix . "logs WHERE type = 'error'";
	$db->direct_query($query);
	$ERR = $MSG['889'];
}

$data = '';
$query = "SELECT * FROM " . $DBPrefix . "logs WHERE type = 'error'";
$db->direct_query($query);
while ($row = $db->fetch())
{
	$data .= '<strong>' . date('d-m-Y, H:i:s', $row['timestamp'] + $system->tdiff) . '</strong>: ' . $row['message'] . '<br>';
}

if ($data == '')
{
	$data = $MSG['888'];
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERRORLOG' => $data
		));

$template->set_filenames(array(
		'body' => 'errorlog.tpl'
		));
$template->display('body');
?>
