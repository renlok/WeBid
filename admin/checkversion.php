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
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

if (!($handle = @fopen('http://www.webidsupport.com/version.txt', 'r')))
{
	$ERR = $ERR_25_0002;
	$realversion = 'Unknown';
}
else
{
	$realversion = fread($handle, 5);
	fclose($handle);
}

if ($realversion != $system->SETTINGS['version'])
{
	$myversion = '<span style="color:#ff0000;">' . $system->SETTINGS['version'] . '</span>';
	$text = $MSG['30_0211'];
}
else
{
	$myversion = '<span style="color:#00ae00;">' . $system->SETTINGS['version'] . '</span>';
	$text = $MSG['30_0212'];
}

$output =<<<EOD
$error
Your Version: <b>$myversion</b><br>
Current Version: $realversion<br>
$text
EOD;

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? '<p>' . $ERR . '</p>' : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TEXT' => $text,
		'MYVERSION' => $myversion,
		'REALVERSION' => $realversion
		));

$template->set_filenames(array(
		'body' => 'checkversion.tpl'
		));
$template->display('body');
?>
