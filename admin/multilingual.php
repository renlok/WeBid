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
$current_page = 'settings';
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['defaultlanguage']))
{
	$query = "UPDATE " . $DBPrefix . "settings SET defaultlanguage = '" . $_POST['defaultlanguage'] . "'";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$system->SETTINGS['defaultlanguage'] = $_POST['defaultlanguage'];
}

$html = '';
if (is_array($LANGUAGES))
{
	reset($LANGUAGES);
	foreach ($LANGUAGES as $k => $v){
		$html .= '<input type="radio" name="defaultlanguage" value="' . $k . '"' . (($system->SETTINGS['defaultlanguage'] == $k) ? ' checked="checked"' : '') . '>
	<img src="../includes/flags/' . $k . '.gif" hspace="2">
	' . $v . (($system->SETTINGS['defaultlanguage'] == $k) ? '&nbsp;' . $MSG['2__0005'] : '') . '<br>';
	}
}

loadblock($MGS_2__0004, $MGS_2__0003, $html);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['2__0002']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>