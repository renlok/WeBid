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
include "loggedin.inc.php";

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update") {
	// Data check
	if(empty($_POST['thumb_show'])) {
		$ERR = $ERR_047;
	} else {
		$query = "UPDATE " . $DBPrefix . "settings SET
				thumb_show = " . intval($_POST['thumb_show']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$system->SETTINGS['thumb_show'] = $_POST['thumb_show'];
		$ERR = $MGS_2__0046;
	}
}

loadblock('', $MGS_2__0043);
loadblock($MSG['25_0107'], '', 'decimals', 'thumb_show', $system->SETTINGS['thumb_show'], $MGS_2__0045);

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'gra',
		'TYPENAME' => $MSG['25_0009'],
		'PAGENAME' => $MSG['2__0042']
        ));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
