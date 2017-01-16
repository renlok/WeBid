<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) {
    exit();
}

include INCLUDE_PATH . 'calendar.inc.php';
include INCLUDE_PATH . 'maintenance.php';
include INCLUDE_PATH . 'functions_banners.php';
if (basename($_SERVER['PHP_SELF']) != 'error.php') {
    include INCLUDE_PATH . 'stats.inc.php';
}

// Get users and auctions counters
$counters = load_counters();

$page_title = (isset($page_title)) ? ' ' . $page_title : '';

// check we are using ssl
if ($system->SETTINGS['https'] == 'y' && (!isset($_SERVER['HTTPS']) || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'off'))) {
    header("Location: https://" . $system->SETTINGS['siteurl'] . $_SERVER["REQUEST_URI"]);
    exit();
}

$template->assign_vars(array(
        'DOCDIR' => $DOCDIR, // Set document direction
        'THEME' => $system->SETTINGS['theme'],
        'PAGE_TITLE' => $system->SETTINGS['sitename'] . $page_title,
        'CHARSET' => $CHARSET,
        'DESCRIPTION' => $system->SETTINGS['descriptiontag'],
        'KEYWORDS' => $system->SETTINGS['keywordstag'],
        'ACTUALDATE' => $dt->formatDate($dt->currentDatetime(), 'M d, Y H:i:s', false),
        'LOGO' => $system->SETTINGS['logo'],
        'BANNER' => ($system->SETTINGS['banners'] == 1) ? view() : '',
        'HEADERCOUNTER' => $counters,
        'SITEURL' => $system->SETTINGS['siteurl'],
        'SITENAME' => $system->SETTINGS['sitename'],
        'Q' => (isset($q)) ? $q : '',
        'SELECTION_BOX' => file_get_contents(MAIN_PATH . 'language/' . $language . '/categories_select_box.inc.php'),
        'YOURUSERNAME' => ($user->logged_in) ? $user->user_data['nick'] : '',
        'GOOGLEANALYTICS' => $system->SETTINGS['googleanalytics'],

        'B_CAN_SELL' => ($user->permissions['can_sell'] || !$user->logged_in),
        'B_LOGGED_IN' => $user->logged_in,
        'B_BOARDS' => ($system->SETTINGS['boards'] == 'y')
        ));

$template->set_filenames(array(
        'header' => 'global_header.tpl'
        ));
$template->display('header');
