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
    if (isset($_POST['payment'])) {
        foreach ($_POST['payment'] as $payment_id => $payment) {
            if (in_array($payment_id, $_POST['delete'])) {
                $query = "DELETE FROM " . $DBPrefix . "payment_options WHERE id = :id";
                $params = [[':id', $payment['id'], 'int']];
                $db->query($query, $params);
            } else {
                // clean the clean name
                if ($payment['clean'] == '') {
                    $payment['clean'] = $payment['name'];
                }
                $payment['clean'] = preg_replace("/[^a-z]/", '', strtolower($payment['clean']));
                $query = "UPDATE " . $DBPrefix . "payment_options
                          SET name = :name,
                          displayname = :displayname
                          WHERE id = :id";
                $params = [
                    [':id', $payment['id'], 'int'],
                    [':name', $payment['clean'], 'str'],
                    [':displayname', $payment['name'], 'str'],
                ];
                $db->query($query, $params);
            }
        }
    }

    if ($_POST['new_payments'] != '') {
        $display_name = $_POST['new_payments'];
        $clean_name = $_POST['new_payments_clean'];
        if ($clean_name == '') {
            $clean_name = $display_name;
        }
        $clean_name = preg_replace("/[^a-z]/", '', strtolower($clean_name));
        $query = "INSERT INTO " . $DBPrefix . "payment_options (name, displayname, is_gateway) VALUES (:name, :displayname, 0)";
        $params = [
            [':name', $clean_name, 'str'],
            [':displayname', $display_name, 'str'],
        ];
        $db->query($query, $params);
    }

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['payment_methods_updated']));
}

$query = "SELECT * FROM " . $DBPrefix . "payment_options WHERE is_gateway = 0";
$db->direct_query($query);
while ($payment_type = $db->fetch()) {
    $template->assign_block_vars('payments', array(
            'NAME' => $payment_type['displayname'],
            'CLEAN' => $payment_type['name'],
            'ID' => $payment_type['id']
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'payments.tpl'
        ));
$template->display('body');
include 'footer.php';
