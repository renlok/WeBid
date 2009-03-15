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

if(isset($_POST['action']) && $_POST['action'] == "update") {
	if(empty($_POST['theme'])) {
		$ERR = $ERR_707;
	} else {
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				theme = '" . $_POST['theme'] . "'";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$system->SETTINGS['theme'] = $_POST['theme'];
		$ERR = $MSG['26_0005'];
	}
}

if ($dir = @opendir(realpath($main_path . 'themes'))) {
	while (($atheme = readdir($dir)) !== false) {
		if ($atheme != '.' && $atheme != '..' && $atheme != 'CVS' && is_dir(realpath($main_path . 'themes') . '/' . $atheme)) {
			$THEMES[] = $atheme;
		}
	}
	@closedir($dir);
}

$selectsetting = $system->SETTINGS['theme'];
loadblock($MSG['26_0003'], $MSG['26_0004'], generateSelect('theme', $THEMES));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'gra',
		'TYPENAME' => $MSG['25_0009'],
		'PAGENAME' => $MSG['26_0002']
		));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
