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
	if($_POST['auctions'] != 'y') $_POST['auctions'] = 'n';
	if($_POST['users'] != 'y') $_POST['users'] = 'n';
	if($_POST['online'] != 'y') $_POST['online'] = 'n';
	// Update database
	$query = "UPDATE " . $DBPrefix . "counterstoshow SET
			  auctions = '" . $_POST['auctions'] . "',
			  users = '" . $_POST['users'] . "',
			  online = '" . $_POST['online'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$COUNTERSTOSHOW['auctions'] = $_POST['auctions'];
	$COUNTERSTOSHOW['users'] = $_POST['users'];
	$COUNTERSTOSHOW['online'] = $_POST['online'];
	$ERR = $MGS_2__0063;
}

$query = "SELECT * FROM " . $DBPrefix . "counterstoshow";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if(mysql_num_rows($res) > 0) {
	$COUNTERSTOSHOW = mysql_fetch_array($res);
}

loadblock($MGS_2__0062, $MGS_2__0058);
loadblock($MGS_2__0060, '', 'checkbox', 'auctions', $COUNTERSTOSHOW['auctions']);
loadblock($MGS_2__0061, '', 'checkbox', 'users', $COUNTERSTOSHOW['users']);
loadblock($MGS_2__0059, '', 'checkbox', 'online', $COUNTERSTOSHOW['online']);

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['2__0057']
        ));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
