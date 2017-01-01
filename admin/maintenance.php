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
$current_page = 'tools';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';
include PACKAGE_PATH . 'ckeditor/ckeditor.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Check if the specified user exists
    $superuser = $_POST['superuser'];
    $query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = :nick";
    $params = array();
    $params[] = array(':nick', $superuser, 'str');
    $db->query($query, $params);
    if ($db->numrows() == 0 && $_POST['maintenancemodeactive'] == 1) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_025));
    } else {
        $system->writesetting("superuser", $superuser, 'string');
        $system->writesetting("maintenance_text", $system->cleanvars($_POST['maintenancetext'], true), 'string');
        $system->writesetting("maintenance_mode_active", $_POST['maintenancemodeactive'], 'bool');

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['maintenance_settings_updated']));
    }
}

loadblock($MSG['enable_maintenance_mode'], $MSG['enable_maintenance_mode_explain'], 'bool', 'maintenancemodeactive', $system->SETTINGS['maintenance_mode_active'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['username'], '', 'text', 'superuser', $system->SETTINGS['superuser'], array($MSG['yes'], $MSG['no']));

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

loadblock($MSG['maintenance_mode_msg'], '', $CKEditor->editor('maintenancetext', $system->SETTINGS['maintenance_text']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['5436'],
        'PAGENAME' => $MSG['maintenance_settings']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
