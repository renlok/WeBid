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
$current_page = 'fees';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$query = "UPDATE " . $DBPrefix . "settings SET
				taxuser = '" . $_POST['taxuser'] . "',
				tax = '" . $_POST['tax'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['taxuser'] = $_POST['taxuser'];
	$system->SETTINGS['tax'] = $_POST['tax'];
	$ERR = $MSG['1089'];
}

loadblock($MSG['1090'], $MSG['1091'], 'yesno', 'tax', $system->SETTINGS['tax'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1092'], $MSG['1093'], 'yesno', 'taxuser', $system->SETTINGS['taxuser'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0012'],
		'PAGENAME' => $MSG['1088']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
