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
include $include_path.'time.inc.php';

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update") {
	if(!is_numeric($_POST['archiveafter'])) {
		$ERR = $ERR_043;
	} else {
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				  cron = " . intval($_POST['cron']) . ",
				  archiveafter = " . intval($_POST['archiveafter']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$system->SETTINGS['cron'] = $_POST['cron'];
		$system->SETTINGS['archiveafter'] = $_POST['archiveafter'];
		$ERR = $MSG['378'];
	}
}

loadblock($MSG['372'], $MSG['371'], 'batch', 'cron', $system->SETTINGS['cron'], $MSG['373'], $MSG['374']);
loadblock($MSG['376'], $MSG['375'], 'days', 'archiveafter', $system->SETTINGS['archiveafter'], $MSG['377']);

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'set',
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['348']
        ));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
