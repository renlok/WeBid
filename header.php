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

if (!defined('InWeBid')) exit();

include $include_path . 'maintainance.php';
include $include_path . 'functions_banners.php';
if (basename($_SERVER['PHP_SELF']) != 'error.php')
	include $include_path . 'stats.inc.php';

$jsfiles = 'js/jquery.js;js/jquery.lightbox.js;';
$jsfiles .= (basename($_SERVER['PHP_SELF']) == 'sell.php') ? ';js/calendar.php' : '';

// Get users and auctions counters
$counters = load_counters();

$page_title = (isset($page_title)) ? ' ' . $page_title : '';

$sslurl = $system->SETTINGS['siteurl'];
if ($system->SETTINGS['https'] == 'y')
{
	$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
}
// for images/ccs/javascript etc on secure pages
$incurl = (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') ? $system->SETTINGS['siteurl'] : $sslurl;

$template->assign_vars(array(
		'DOCDIR' => $DOCDIR, // Set document direction
		'THEME' => $system->SETTINGS['theme'],
		'PAGE_TITLE' => $system->SETTINGS['sitename'] . $page_title,
		'CHARSET' => $CHARSET,
		'DESCRIPTION' => stripslashes($system->SETTINGS['descriptiontag']),
		'KEYWORDS' => stripslashes($system->SETTINGS['keywordstag']),
		'JSFILES' => $jsfiles,
		'LOADCKEDITOR' => (basename($_SERVER['PHP_SELF']) == 'sell.php'),
		'ACTUALDATE' => ActualDate(),
		'LOGO' => ($system->SETTINGS['logo']) ? '<img src="' . $incurl . 'uploaded/logo/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '">' : '&nbsp;',
		'BANNER' => ($system->SETTINGS['banners'] == 1) ? view() : '',
		'HEADERCOUNTER' => $counters,
		'SITEURL' => $system->SETTINGS['siteurl'],
		'SSLURL' => $sslurl,
		'ASSLURL' => ($system->SETTINGS['https'] == 'y' && $system->SETTINGS['usersauth'] == 'y') ? $sslurl : $system->SETTINGS['siteurl'],
		'INCURL' => $incurl,
		'Q' => (isset($q)) ? $q : '',
		'SELECTION_BOX' => file_get_contents($main_path . 'language/' . $language . '/categories_select_box.inc.php'),
		'YOURUSERNAME' => ($user->logged_in) ? $user->user_data['nick'] : '',
		'GOOGLEANALYTICS' => $system->SETTINGS['googleanalytics'],

		'B_CAN_SELL' => ($user->can_sell || !$user->logged_in),
		'B_LOGGED_IN' => $user->logged_in,
		'B_BOARDS' => ($system->SETTINGS['boards'] == 'y')
		));

$template->set_filenames(array(
		'header' => 'global_header.tpl'
		));
$template->display('header');