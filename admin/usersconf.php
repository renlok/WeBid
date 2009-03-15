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

require('../includes/config.inc.php');
include "loggedin.inc.php";

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update") {
	$query = "UPDATE " . $DBPrefix . "settings SET
			activationtype = " . $_POST['usersconf'];
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['activationtype'] = $_POST['usersconf'];
	$ERR = $MSG['25_0155'];
}

loadblock('', $MSG['25_0152_a'], 'select3num', 'usersconf', $system->SETTINGS['activationtype'], $MSG['25_0152_b'], $MSG['25_0152_c'], $MSG['25_0152_d']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['25_0151_a']
		));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
