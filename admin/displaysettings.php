<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2015 WeBid
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
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['perpage'] = intval($_POST['perpage']);
	$system->SETTINGS['thumb_list'] = intval($_POST['thumb_list']);
	$system->SETTINGS['loginbox'] = intval($_POST['loginbox']);
	$system->SETTINGS['newsbox'] = intval($_POST['newsbox']);
	$system->SETTINGS['newstoshow'] = intval($_POST['newstoshow']);
	$system->SETTINGS['lastitemsnumber'] = intval($_POST['lastitemsnumber']);
	$system->SETTINGS['hotitemsnumber'] = intval($_POST['hotitemsnumber']);
	$system->SETTINGS['endingsoonnumber'] = intval($_POST['endingsoonnumber']);
	// Update database
	$query = "UPDATE ". $DBPrefix . "settings SET
				perpage = :perpage,
				thumb_list = :thumb_list,
				lastitemsnumber = :lastitemsnumber,
				hotitemsnumber = :hotitemsnumber,
				endingsoonnumber = :endingsoonnumber,
				loginbox = :loginbox,
				newsbox = :newsbox,
				newstoshow = :newstoshow";
	$params = array();
	$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
	$params[] = array(':thumb_list', $system->SETTINGS['thumb_list'], 'int');
	$params[] = array(':lastitemsnumber', $system->SETTINGS['lastitemsnumber'], 'int');
	$params[] = array(':hotitemsnumber', $system->SETTINGS['hotitemsnumber'], 'int');
	$params[] = array(':endingsoonnumber', $system->SETTINGS['endingsoonnumber'], 'int');
	$params[] = array(':loginbox', $system->SETTINGS['loginbox'], 'int');
	$params[] = array(':newsbox', $system->SETTINGS['newsbox'], 'int');
	$params[] = array(':newstoshow', $system->SETTINGS['newstoshow'], 'int');
	$db->query($query, $params);
	$ERR = $MSG['795'];
}

loadblock($MSG['789'], $MSG['790'], 'days', 'perpage', $system->SETTINGS['perpage']);
loadblock($MSG['25_0107'], $MSG['808'], 'decimals', 'thumb_list', $system->SETTINGS['thumb_list'], array($MSG['2__0045']));

loadblock($MSG['807'], '', '', '', '', array(), true);
loadblock($MSG['5013'], $MSG['5014'], 'days', 'lastitemsnumber', $system->SETTINGS['lastitemsnumber']);
loadblock($MSG['5015'], $MSG['5016'], 'days', 'hotitemsnumber', $system->SETTINGS['hotitemsnumber']);
loadblock($MSG['5017'], $MSG['5018'], 'days', 'endingsoonnumber', $system->SETTINGS['endingsoonnumber']);
loadblock($MSG['532'], $MSG['537'], 'batch', 'loginbox', $system->SETTINGS['loginbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['533'], $MSG['538'], 'batch', 'newsbox', $system->SETTINGS['newsbox'], array($MSG['030'], $MSG['029']));
loadblock('', $MSG['554'], 'days', 'newstoshow', $system->SETTINGS['newstoshow']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['788']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
