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
    // clean submission
    $system->writesetting("counter_auctions", isset($_POST['auctions'])? 'y' : 'n', "str");
    $system->writesetting("counter_users", isset($_POST['users'])? 'y' : 'n', "str");
    $system->writesetting("counter_online",  isset($_POST['online'])? 'y' : 'n', "str");

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['counter_settings_updated']));
}

loadblock($MSG['counters_shown'], $MSG['counters_shown_explain']);
loadblock($MSG['counters_active'], '', 'checkbox', 'auctions', $system->SETTINGS['counter_auctions']);
loadblock($MSG['counters_registered'], '', 'checkbox', 'users', $system->SETTINGS['counter_users']);
loadblock($MSG['counters_online'], '', 'checkbox', 'online', $system->SETTINGS['counter_online']);

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0008'],
        'PAGENAME' => $MSG['counter_settings']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
