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
    
    if (isset($_POST['reporting']['allow_reporting'])) {
        $system->writesetting("allow_reporting", $_POST['reporting']['allow_reporting'], 'bool');
    } else {
        $system->writesetting("allow_reporting", false, 'bool');
    }
    
    if (isset($_POST['reporting'])) {
        foreach ($_POST['reporting'] as $reporting_id => $reporting) {
            if (isset($_POST['delete']) && in_array($reporting_id, $_POST['delete'])) {
                $query = "UPDATE " . $DBPrefix . "reporting_options
                            SET removed = :removed
                            WHERE id = :id";
                $params = [
                           [':id', $reporting['id'], 'int'],
                           [':removed', true, 'bool'],
                           ];
                $db->query($query, $params);
            } else {
                $query = "UPDATE " . $DBPrefix . "reporting_options
                          SET reason = :reason,
                          WHERE id = :id";
                $params = [
                    [':id', $reporting['id'], 'int'],
                    [':reason', $reporting['reason'], 'str'],
                ];
                $db->query($query, $params);
            }
        }
    }

    if ($_POST['new_reason'] != '') {
        $reason = $_POST['new_reason'];
        $query = "INSERT INTO " . $DBPrefix . "reporting_options (reason) VALUES (:reason)";
        $params = [
            [':reason', $reason, 'str'],
        ];
        $db->query($query, $params);
    }

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['reasons_updated']));
}


$query = "SELECT * FROM " . $DBPrefix . "reporting_options WHERE removed = false";
$db->direct_query($query);
while ($reason_type = $db->fetch()) {
    $template->assign_block_vars('reporting', array(
        'REASON' => $reason_type['reason'],
        'ID' => $reason_type['id']
        ));
}


$template->assign_vars(array('ALLOW' => $system->SETTINGS['allow_reporting']));



include 'header.php';
$template->set_filenames(array(
        'body' => 'auctionreporting.tpl'
        ));
$template->display('body');
include 'footer.php';
