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
$current_page = 'fees';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// clean submission
	$system->SETTINGS['invoice_yellow_line'] = $system->cleanvars($_POST['invoice_yellow_line']);
	$system->SETTINGS['invoice_thankyou'] = $system->cleanvars($_POST['invoice_thankyou']);
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET
				invoice_yellow_line = :invoice_yellow_line,
				invoice_thankyou = :invoice_thankyou";
	$params = array();
	$params[] = array(':invoice_yellow_line', $system->SETTINGS['terms'], 'str');
	$params[] = array(':invoice_thankyou', $system->SETTINGS['termstext'], 'str');
	$db->query($query, $params);
	$ERR = $MSG['1095'];
}

loadblock($MSG['1096'], $MSG['1097'], 'text', 'invoice_yellow_line', $system->uncleanvars($system->SETTINGS['invoice_yellow_line']));
loadblock($MSG['1098'], $MSG['1099'], 'text', 'invoice_thankyou', $system->uncleanvars($system->SETTINGS['invoice_thankyou']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['25_0012'],
		'PAGENAME' => $MSG['1094']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
