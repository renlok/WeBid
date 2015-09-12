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
	$system->SETTINGS['catsorting'] = $system->cleanvars($_POST['catsorting']);
	$system->SETTINGS['catstoshow'] = intval($_POST['catstoshow']);
	// Update database
	$query = " UPDATE " . $DBPrefix . "settings SET
			   catsorting = :catsorting,
			   catstoshow = :catstoshow";
	$params = array();
	$params[] = array(':catsorting', $system->SETTINGS['catsorting'], 'str');
	$params[] = array(':catstoshow', $system->SETTINGS['catstoshow'], 'int');
	$db->query($query, $params);
	$ERR = $MSG['25_0150'];
}

loadblock('', $MSG['25_0147'], 'sortstacked', 'catsorting', $system->SETTINGS['catsorting'], array($MSG['25_0148'], $MSG['25_0149']));
loadblock($MSG['30_0030'], $MSG['30_0029'], 'percent', 'catstoshow', $system->SETTINGS['catstoshow']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['25_0146']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
