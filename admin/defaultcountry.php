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
include $include_path . 'countries.inc.php';

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update") {
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET defaultcountry = '" . $_POST['country'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$system->SETTINGS['defaultcountry'] = $_POST['country'];
	$ERR = $MSG['5323'];
}

function generateSelect($name = '', $countries = array()) {
	global $system;
	$html = '<select name="' . $name . '">';
	foreach($countries as $k => $v) {
		if($v == $system->SETTINGS['defaultcountry']){
			$html .= '<option value="' . $v . '" selected>' . $v . '</option>';
		} else {
			$html .= '<option value="' . $v . '">' . $v . '</option>';
		}
	}
	$html .= '</select>';
	return $html;
}

loadblock($MSG['5322'], $MSG['5321'], generateSelect('country', $countries));

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['5322'],
		'DROPDOWN' => $html
        ));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
