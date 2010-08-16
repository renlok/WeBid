<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'clearlog')
{
	$file = @fopen($logPath . 'error.log', 'w+');
	fclose($file);
	$ERR = $MSG['889'];
}

$data = file_get_contents($logPath . 'error.log');

if ($data == '')
{
	$data = $MSG['888'];
}
else
{
	$data = str_replace("\n", '<br>', $data);
	$data = preg_replace('/(\d{2}-\d{2}-\d{4}, \d{2}:\d{2}:\d{2}::)/s', '<b>$1</b>', $data);
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
