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
    if(!isset($_POST['accesses']) && !isset($_POST['browsers']) && !isset($_POST['domains'])) {
        $ERR = $ERR_5002;
        $system->SETTINGS = $_POST;
    } else {
        if(!isset($_POST['accesses'])) $_POST['accesses'] = 'n';
        if(!isset($_POST['browsers'])) $_POST['browsers'] = 'n';
        if(!isset($_POST['domains'])) $_POST['domains'] = 'n';
        // Update database
        $query = "UPDATE " . $DBPrefix . "statssettings SET
					activate = '" . $_POST['activate'] . "',
					accesses = '" . $_POST['accesses'] . "',
					browsers = '" . $_POST['browsers'] . "',
					domains = '" . $_POST['domains'] . "'";
        $system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$ERR = $MSG['5148'];
		$system->SETTINGS = $_POST;
    }
} else {
	$query = "SELECT * FROM " . $DBPrefix . "statssettings";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$system->SETTINGS = mysql_fetch_assoc($res);
}

loadblock('', $MSG['5144']);
loadblock($MSG['5149'], '', 'yesno', 'activate', $system->SETTINGS['activate'], $MSG['030'], $MSG['029']);
loadblock('', $MSG['5150']);
loadblock('' , '', 'checkbox', 'accesses', $system->SETTINGS['accesses'], $MSG['5145']);
loadblock('' , '', 'checkbox', 'browsers', $system->SETTINGS['browsers'], $MSG['5146']);
loadblock('' , '', 'checkbox', 'domains', $system->SETTINGS['domains'], $MSG['5147']);
loadblock('', $MSG['5151']);
loadblock('', $MSG['5152'].' | '.$MSG['5153'].' | '.$MSG['5154']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'con',
		'TYPENAME' => $MSG['25_0023'],
		'PAGENAME' => $MSG['5142'],
		'TITLEBARNAME' => $MSG['5141']
		));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
