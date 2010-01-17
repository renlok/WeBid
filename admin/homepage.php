<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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

if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
		// Handle logo upload
		$inf = GetImageSize ($_FILES['logo']['tmp_name']);
		if ($inf[2] < 1 || $inf[2] > 3) {
			print $ERR_602;
			exit;
		}
		if (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name'] != "none") {
			if ($system->move_file($_FILES['logo']['tmp_name'], $main_path . 'themes/' . $system->SETTINGS['theme'] . '/' . $_FILES['logo']['name'])) {
				$LOGOUPLOADED = true;
			} else {
				$LOGOUPLOADED = false;
			}
		}
	}

	$query = " UPDATE " . $DBPrefix . "settings SET
			   loginbox = " . $_POST['loginbox'] . ",
			   newsbox = " . $_POST['newsbox'] . ",
			   newstoshow = " . $_POST['newstoshow'] . ",";
	if ($LOGOUPLOADED) {
		$query .= "logo = '" . $_FILES['logo']['name'] . "', ";
		$system->SETTINGS['logo'] = $_FILES['logo']['name'];
	}
	$query .= "lastitemsnumber = " . intval($_POST['lastitemsnumber']) . ",
				higherbidsnumber = " . intval($_POST['higherbidsnumber']) . ",
				endingsoonnumber = " . intval($_POST['endingsoonnumber']);
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['loginbox'] = $_POST['loginbox'];
	$system->SETTINGS['newsbox'] = $_POST['newsbox'];
	$system->SETTINGS['newstoshow'] = $_POST['newstoshow'];
	$system->SETTINGS['cust_increment'] = $_POST['cust_increment'];
	$system->SETTINGS['lastitemsnumber'] = $_POST['lastitemsnumber'];
	$system->SETTINGS['higherbidsnumber'] = $_POST['higherbidsnumber'];
	$system->SETTINGS['endingsoonnumber'] = $_POST['endingsoonnumber'];
	$ERR = $MSG['5019'];
}

$logoURL = $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'];

loadblock($MSG['531'], $MSG['556'], 'image', 'logo', $system->SETTINGS['logo']);
loadblock('', $MSG['602'], 'upload', 'logo', $system->SETTINGS['logo']);
loadblock($MSG['5013'], $MSG['5014'], 'decimals', 'lastitemsnumber', $system->SETTINGS['lastitemsnumber']);
loadblock($MSG['5015'], $MSG['5016'], 'decimals', 'higherbidsnumber', $system->SETTINGS['higherbidsnumber']);
loadblock($MSG['5017'], $MSG['5018'], 'decimals', 'endingsoonnumber', $system->SETTINGS['endingsoonnumber']);
loadblock($MSG['532'], $MSG['537'], 'batch', 'loginbox', $system->SETTINGS['loginbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['533'], $MSG['538'], 'batch', 'newsbox', $system->SETTINGS['newsbox'], array($MSG['030'], $MSG['029']));
loadblock('', $MSG['554'], 'decimals', 'newstoshow', $system->SETTINGS['newstoshow']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'IMAGEURL' => $logoURL,
		'LINKURL' => $link,
		'TYPE' => 'gra',
		'TYPENAME' => $MSG['25_0009'],
		'PAGENAME' => $MSG['5005']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
