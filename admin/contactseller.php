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
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == "update") {
	$query = "UPDATE " . $DBPrefix . "settings SET contactseller = '" . $_POST['contactseller'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['contactseller'] = $_POST['contactseller'];
	$ERR = $MSG['25_0155'];
}

loadblock('', $MSG['25_0217'], 'select3contact', 'contactseller', $system->SETTINGS['contactseller'], $MSG['25_0218'], $MSG['25_0219'], $MSG['25_0220']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['25_0216']
		));

$template->set_filenames(array(
		'body' => 'adminpages.html'
		));
$template->display('body');
?>
