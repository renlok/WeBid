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

if (!defined('InAdmin')) exit();

include INCLUDE_PATH . 'calendar.inc.php';

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'THEME' => $system->SETTINGS['admin_theme'],
		'LOGO' => ($system->SETTINGS['logo']) ? '<img src="' . $system->SETTINGS['siteurl'] . 'uploaded/logo/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '">' : '&nbsp;'
		));

$template->set_filenames(array(
		'header' => 'header.tpl'
		));
$template->display('header');
