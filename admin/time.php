<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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
	// Update database
	$system->writesetting("timecorrection", floatval($_POST['timecorrection']),"str");
	$system->writesetting("datesformat", $_POST['datesformat'],"str");
	$ERR = $MSG['347'];
}

$TIMECORRECTION = array();
for ($i = 12; $i > -13; $i--)
{
	$TIMECORRECTION[$i] = $MSG['TZ_' . $i];
}

$selectsetting = $system->SETTINGS['timecorrection'];

$html = generateSelect('timecorrection', $TIMECORRECTION);

//load the template
loadblock($MSG['363'], $MSG['379'], 'datestacked', 'datesformat', $system->SETTINGS['datesformat'], array($MSG['382'], $MSG['383']));
loadblock($MSG['346'], $MSG['345'], 'dropdown', 'timecorrection', $system->SETTINGS['timecorrection']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'OPTIONHTML' => $html,
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['344'],
		'DROPDOWN' => $html
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
