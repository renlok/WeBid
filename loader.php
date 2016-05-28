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

ob_start('ob_gzhandler');
header("Content-type: text/javascript");
include 'includes/checks/files.php';
if (isset($_GET['js']))
{
	$js = explode(';', $_GET['js']);
	foreach ($js as $val)
	{
		$ext = substr($val, strrpos($val, '.') + 1);
		if ($ext == 'php')
		{
			if (check_file($val))
			{
				include $val;
			}
		}
		elseif ($ext == 'js' || $ext == 'css')
		{
			if (check_file($val) && is_file($val))
			{
				echo file_get_contents($val);
				echo "\n";
			}
		}
	}
}
ob_end_flush();

function check_file($file)
{
	global $file_allowed;
	$tmp = $file_allowed;
	$folders = explode('/', $file);
	foreach ($folders as $val)
	{
		if (isset($tmp[$val]))
		{
			$tmp = $tmp[$val];
		}
		else
		{
			return false;
		}
	}
	return true;
}