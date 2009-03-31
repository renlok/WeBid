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

if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (isset($_FILES['logo']['tmp_name'])) {
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
			   newstoshow = " . $_POST['newstoshow'] . ",
			   cust_increment = " . $_POST['cust_increment'] . ", ";
	if ($LOGOUPLOADED) {
		$query .= "logo = '" . $_FILES['logo']['name'] . "', ";
		$system->SETTINGS['logo'] = $_FILES['logo']['name'];
	}
	$query .= "lastitemsnumber = " . intval($_POST['lastitemsnumber']) . ",
				higherbidsnumber = " . intval($_POST['higherbidsnumber']) . ",
				endingsoonnumber = " . intval($_POST['endingsoonnumber']) . ",
				pagewidth = " . intval($_POST['pagewidth']) . ",
				pagewidthtype = '" . $_POST['pagewidthtype'] . "',
				alignment = '" . $_POST['alignment'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['loginbox'] = $_POST['loginbox'];
	$system->SETTINGS['newsbox'] = $_POST['newsbox'];
	$system->SETTINGS['newstoshow'] = $_POST['newstoshow'];
	$system->SETTINGS['cust_increment'] = $_POST['cust_increment'];
	$system->SETTINGS['lastitemsnumber'] = $_POST['lastitemsnumber'];
	$system->SETTINGS['higherbidsnumber'] = $_POST['higherbidsnumber'];
	$system->SETTINGS['endingsoonnumber'] = $_POST['endingsoonnumber'];
	$system->SETTINGS['pagewidth'] = $_POST['pagewidth'];
	$system->SETTINGS['pagewidthtype'] = $_POST['pagewidthtype'];
	$system->SETTINGS['alignment'] = $_POST['alignment'];
	$ERR = $MSG['5019'];
}

$logoURL = $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'];

$ALIGNMENT = array(
	'left' => 'Left',
	'center' => 'Center',
	'right' => 'Right');

$WIDTHTYPE = array(
	'perc' => '%',
	'fixed' => 'pixels');

loadblock($MSG['531'], $MSG['556'], 'image', 'logo', $system->SETTINGS['logo']);
loadblock('', $MSG['602'], 'upload', 'logo', $system->SETTINGS['logo']);
$selectsetting = $system->SETTINGS['alignment'];
loadblock($MSG['1056'], $MSG['1057'], generateSelect('alignment', $ALIGNMENT));
loadblock($MGS_2__0051, $MGS_2__0052, 'decimals', 'pagewidth', $system->SETTINGS['pagewidth']);
$selectsetting = $system->SETTINGS['pagewidthtype'];
loadblock('', '', generateSelect('pagewidthtype', $WIDTHTYPE));
loadblock($MSG['5013'], $MSG['5014'], 'decimals', 'lastitemsnumber', $system->SETTINGS['lastitemsnumber']);
loadblock($MSG['5015'], $MSG['5016'], 'decimals', 'higherbidsnumber', $system->SETTINGS['higherbidsnumber']);
loadblock($MSG['5017'], $MSG['5018'], 'decimals', 'endingsoonnumber', $system->SETTINGS['endingsoonnumber']);
loadblock($MSG['532'], $MSG['537'], 'batch', 'loginbox', $system->SETTINGS['loginbox'], $MSG['030'], $MSG['029']);
loadblock($MSG['533'], $MSG['538'], 'batch', 'newsbox', $system->SETTINGS['newsbox'], $MSG['030'], $MSG['029']);
loadblock('', $MSG['554'], 'decimals', 'newstoshow', $system->SETTINGS['newstoshow']);
loadblock($MSG['068'], $MSG['070'], 'batch', 'cust_increment', $system->SETTINGS['cust_increment'], $MSG['030'], $MSG['029']);

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
		'body' => 'adminpages.html'
		));
$template->display('body');
?>
