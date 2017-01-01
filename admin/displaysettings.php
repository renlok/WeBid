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

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // clean submission & update database
    $system->writesetting("perpage",  $_POST['perpage'], 'int');
    $system->writesetting("featuredperpage",  $_POST['featuredperpage'], 'int');
    $system->writesetting("thumb_list",  $_POST['thumb_list'], 'int');
    $system->writesetting("loginbox", $_POST['loginbox'], 'int');
    $system->writesetting("newsbox", $_POST['newsbox'], 'int');
    $system->writesetting("newstoshow", $_POST['newstoshow'], 'int');
    $system->writesetting("homefeaturednumber", $_POST['homefeaturednumber'], 'int');
    $system->writesetting("lastitemsnumber", $_POST['lastitemsnumber'], 'int');
    $system->writesetting("hotitemsnumber",  $_POST['hotitemsnumber'], 'int');
    $system->writesetting("endingsoonnumber", $_POST['endingsoonnumber'], 'int');

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['display_settings_updated']));
}

loadblock($MSG['show_per_page'], $MSG['show_per_page_explain'], 'days', 'perpage', $system->SETTINGS['perpage']);
loadblock($MSG['max_featured_items'], $MSG['max_featured_items_explain'], 'days', 'featuredperpage', $system->SETTINGS['featuredperpage']);
loadblock($MSG['thumbnail_size'], $MSG['thumbnail_size_explain'], 'decimals', 'thumb_list', $system->SETTINGS['thumb_list'], array($MSG['pixels']));

loadblock($MSG['front_page_settings'], '', '', '', '', array(), true);
loadblock($MSG['home_page_featured'], $MSG['home_page_featured_explain'], 'days', 'homefeaturednumber', $system->SETTINGS['homefeaturednumber']);
loadblock($MSG['home_page_recent'], $MSG['home_page_recent_explain'], 'days', 'lastitemsnumber', $system->SETTINGS['lastitemsnumber']);
loadblock($MSG['home_page_hot'], $MSG['home_page_hot_explain'], 'days', 'hotitemsnumber', $system->SETTINGS['hotitemsnumber']);
loadblock($MSG['home_page_ending_soon'], $MSG['home_page_ending_soon_explain'], 'days', 'endingsoonnumber', $system->SETTINGS['endingsoonnumber']);
loadblock($MSG['home_page_login'], $MSG['home_page_login_explain'], 'batch', 'loginbox', $system->SETTINGS['loginbox'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['home_page_news'], $MSG['home_page_news_explain'], 'batch', 'newsbox', $system->SETTINGS['newsbox'], array($MSG['yes'], $MSG['no']));
loadblock('', $MSG['number_news_shown'], 'days', 'newstoshow', $system->SETTINGS['newstoshow']);

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['5142'],
        'PAGENAME' => $MSG['display_settings']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
