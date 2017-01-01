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
$current_page = 'stats';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if (isset($_POST['activate']) && $_POST['activate'] == 'y' && (!isset($_POST['accesses']) && !isset($_POST['browsers']) && !isset($_POST['domains']))) {
        $template->assign_block_vars('alerts', array('TYPE' => 'warning', 'MESSAGE' => $MSG['error_stat_type_missing']));
        $statssettings['activate'] = 'n';
        $statssettings['accesses'] = 'n';
        $statssettings['browsers'] = 'n';
    } else {
        if (!isset($_POST['accesses'])) {
            $_POST['accesses'] = 'n';
        }
        if (!isset($_POST['browsers'])) {
            $_POST['browsers'] = 'n';
        }
        if (!isset($_POST['domains'])) {
            $_POST['domains'] = 'n';
        }
        // Update database
        $query = "UPDATE " . $DBPrefix . "statssettings SET
                  activate = :activate,
                  accesses = :accesses,
                  browsers = :browsers";
        $params = array();
        $params[] = array(':activate', $_POST['activate'], 'str');
        $params[] = array(':accesses', $_POST['accesses'], 'str');
        $params[] = array(':browsers', $_POST['browsers'], 'str');
        $db->query($query, $params);
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['statistics_settings_updated']));
        $statssettings = $_POST;
    }
} else {
    $query = "SELECT * FROM " . $DBPrefix . "statssettings";
    $db->direct_query($query);
    $statssettings = $db->result();
}

loadblock('', $MSG['statistics_explain']);
loadblock($MSG['enable_statistics'], '', 'yesno', 'activate', $statssettings['activate'], array($MSG['yes'], $MSG['no']));
loadblock('', $MSG['stat_types_explain']);
loadblock('', '', 'checkbox', 'accesses', $statssettings['accesses'], array($MSG['enable_user_access_stats']));
loadblock('', '', 'checkbox', 'browsers', $statssettings['browsers'], array($MSG['enable_browser_stats']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0023'],
        'PAGENAME' => $MSG['5142']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
