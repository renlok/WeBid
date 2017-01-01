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
$current_page = 'fees';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include INCLUDE_PATH . 'config/gateways.php';
include 'loggedin.inc.php';

$query = "SELECT * FROM " . $DBPrefix . "payment_options WHERE is_gateway = 1";
$db->direct_query($query);
$gateway_data = $db->fetchAll();

if (isset($_POST['action'])) {
    // build the sql
    foreach ($gateway_data as $k => $gateway) {
        if (isset($_POST[$gateway['name']])) {
            $query = "UPDATE " . $DBPrefix . "payment_options SET
                      gateway_admin_address = :gateway_admin_address,
                      gateway_admin_password = :gateway_admin_password,
                      gateway_required = :gateway_required,
                      gateway_active = :gateway_active
                      WHERE id = :id";
            $params = array();
            $params[] = array(':gateway_admin_address', $_POST[$gateway['name']]['address'], 'str');
            $params[] = array(':gateway_admin_password', $_POST[$gateway['name']]['password'], 'str');
            $params[] = array(':gateway_required', (isset($_POST[$gateway['name']]['required']) ? 1 : 0), 'bool');
            $params[] = array(':gateway_active', (isset($_POST[$gateway['name']]['active']) ? 1 : 0), 'bool');
            $params[] = array(':id', $_POST[$gateway['name']]['id'], 'int');
            $db->query($query, $params);
            $gateway_data[$k]['gateway_admin_address'] = $_POST[$gateway['name']]['address'];
            $gateway_data[$k]['gateway_admin_password'] = $_POST[$gateway['name']]['password'];
            $gateway_data[$k]['gateway_required'] = (isset($_POST[$gateway['name']]['required']) ? 1 : 0);
            $gateway_data[$k]['gateway_active'] = (isset($_POST[$gateway['name']]['active']) ? 1 : 0);
        }
    }
    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['gateway_settings_update']));
}

foreach ($gateway_data as $gateway) {
    $template->assign_block_vars('gateways', array(
            'GATEWAY_ID' => $gateway['id'],
            'NAME' => $gateway['displayname'],
            'PLAIN_NAME' => $gateway['name'],
            'ENABLED' => ($gateway['gateway_active'] == 1) ? 'checked' : '',
            'REQUIRED' => ($gateway['gateway_required'] == 1) ? 'checked' : '',
            'ADDRESS' => $gateway['gateway_admin_address'],
            'PASSWORD' => $gateway['gateway_admin_password'],
            'WEBSITE' => $gateway_links[$gateway['name']],
            'ADDRESS_NAME' => isset($address_string[$gateway['name']]) ? $address_string[$gateway['name']] : $gateway['name'],
            'PASSWORD_NAME' => isset($password_string[$gateway['name']]) ? $password_string[$gateway['name']] : '',

            'B_PASSWORD' => isset($password_string[$gateway['name']])
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'fee_gateways.tpl'
        ));
$template->display('body');

include 'footer.php';
