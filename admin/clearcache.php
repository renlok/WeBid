<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2015 WeBid
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
$current_page = 'interface';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (is_dir($main_path . 'cache'))
	{
		$dir = opendir($main_path . 'cache');
		while (($myfile = readdir($dir)) !== false)
		{
			if ($myfile != '.' && $myfile != '..' && $myfile != 'index.php')
			{
				unlink($main_path . 'cache/' . $myfile);
			}
		}
		closedir($dir);
	}
	$ERR = $MSG['30_0033'];
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl']
		));

$template->set_filenames(array(
		'body' => 'clearcache.tpl'
		));
$template->display('body');
?>
