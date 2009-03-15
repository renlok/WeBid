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
    if($_POST['maxpicturesize'] == 0) {
		$ERR = $ERR_707;
		$system->SETTINGS['maxuploadsize'] = $_POST['maxpicturesize'];
	} elseif(!empty($_POST['maxpicturesize']) && !ereg("^[0-9]+$",$_POST['maxpicturesize'])) {
		$ERR = $ERR_708;
		$system->SETTINGS = $_POST;
	} else {
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				  maxuploadsize = " . ($_POST['maxpicturesize'] * 1024);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$ERR = $MSG['5006'];
		$system->SETTINGS['maxuploadsize'] = $_POST['maxpicturesize'] * 1024;
	}
}

loadblock($MSG['671'], $MSG['25_0187'], 'kbytes', 'maxpicturesize', ($system->SETTINGS['maxuploadsize'] / 1024), $MSG['672']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'set',
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['25_0186']
		));

$template->set_filenames(array(
		'body' => 'adminpages.html'
		));
$template->display('body');
?>
