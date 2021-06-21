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
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['defaultlanguage']))
{
	// clean submission and update database
	$system->writesetting("defaultlanguage", $system->cleanvars($_POST['defaultlanguage']),"str");
	
	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['multilingual_support_settings_updated']));
}

$html = '';
if (is_array($LANGUAGES))
{
	reset($LANGUAGES);
	foreach ($LANGUAGES as $k => $v)
	{
		$html .= '<input type="radio" name="defaultlanguage" value="' . $k . '"' . (($system->SETTINGS['defaultlanguage'] == $k) ? ' checked="checked"' : '') . '>
		<img src="../images/flags/' . $k . '.gif" hspace="2">
		' . $v . (($system->SETTINGS['defaultlanguage'] == $k) ? '&nbsp;' . $MSG['2__0005'] : '') . '<br>';
	}
}

loadblock($MSG['2__0004'], $MSG['2__0003'], $html);

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['2__0002']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>