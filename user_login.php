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

include 'includes/common.inc.php';
include $include_path . 'countries.inc.php';

if ($system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
{
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
	header('location: ' . $sslurl . 'user_login.php');
	exit;
}

$template->assign_vars(array(
		'L_ERROR' => (isset($errmsg)) ? $errmsg : '',
		'USER' => (isset($_POST['username'])) ? $_POST['username'] : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'user_login.tpl'
		));
$template->display('body');
include 'footer.php';
?>
