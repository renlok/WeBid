<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
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

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$query = "UPDATE ". $DBPrefix . "settings SET
			  fees = '" . $_POST['fees'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['fees'] = $_POST['fees'];
	$ERR = $MSG['247'];
}

loadblock($MSG['237'], $MSG['238'], 'yesno', 'fees', $system->SETTINGS['fees'], $MSG['030'], $MSG['029']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'fee',
		'TYPENAME' => $MSG['25_0012'],
		'PAGENAME' => $MSG['395'],
		'B_TITLES' => true
		));

$template->set_filenames(array(
		'body' => 'adminpages.html'
		));
$template->display('body');
?>
