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

require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update") {
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET
			  datesformat = '" . $_POST['datesformat'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['datesformat'] = $_POST['datesformat'];
	$ERR = $MSG['384'];
}

loadblock($MSG['380'], $MSG['379'], 'datestacked', 'datesformat', $system->SETTINGS['datesformat'], $MSG['382'], $MSG['383']);

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['363']
        ));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
