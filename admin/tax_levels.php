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
include 'loggedin.inc.php';

// add or edit a value
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $seller_countries = '';
    $buyer_countries = '';
    if (!empty($_POST['seller_countries']) && is_array($_POST['seller_countries'])) {
        $seller_countries = implode(' ', $_POST['seller_countries']);
    }
    if (!empty($_POST['buyer_countries']) && is_array($_POST['buyer_countries'])) {
        $buyer_countries = implode(' ', $_POST['buyer_countries']);
    }

    if (!empty($_POST['tax_name'])) {
        if ($_POST['tax_id'] != '') {
            $query = "UPDATE " . $DBPrefix . "tax SET
                      tax_name = :tax_name,
                      tax_rate = :tax_rate,
                      countries_seller = :countries_seller,
                      countries_buyer = :countries_buyer
                      WHERE id = :tax_id";
            $params = array();
            $params[] = array(':tax_name', $system->cleanvars($_POST['tax_name']), 'str');
            $params[] = array(':tax_rate', $system->cleanvars($_POST['tax_rate']), 'str');
            $params[] = array(':countries_seller', $system->cleanvars($seller_countries), 'str');
            $params[] = array(':countries_buyer', $system->cleanvars($buyer_countries), 'str');
            $params[] = array(':tax_id', $_POST['tax_id'], 'int');
            $db->query($query, $params);
        } else {
            $query = "INSERT INTO " . $DBPrefix . "tax (tax_name, tax_rate, countries_seller, countries_buyer) VALUES
                      (:tax_name, :tax_rate, :countries_seller, :countries_buyer)";
            $params = array();
            $params[] = array(':tax_name', $system->cleanvars($_POST['tax_name']), 'str');
            $params[] = array(':tax_rate', $system->cleanvars($_POST['tax_rate']), 'str');
            $params[] = array(':countries_seller', $system->cleanvars($seller_countries), 'str');
            $params[] = array(':countries_buyer', $system->cleanvars($buyer_countries), 'str');
            $db->query($query, $params);
        }
    } else {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_002));
    }
}

// update site fee
if (isset($_POST['action']) && $_POST['action'] == 'sitefee') {
    $query = "UPDATE " . $DBPrefix . "tax SET fee_tax = 0";
    $db->direct_query($query);
    $query = "UPDATE " . $DBPrefix . "tax SET fee_tax = 1 WHERE id = :tax_id";
    $params = array();
    $params[] = array(':tax_id', $_POST['site_fee'], 'int');
    $db->query($query, $params);
}

$tax_seller_data = array();
$tax_buyer_data = array();
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
    $query = "SELECT * FROM " . $DBPrefix . "tax WHERE id = :tax_id";
    $params = array();
    $params[] = array(':tax_id', $_GET['id'], 'int');
    $db->query($query, $params);
    $data = $db->result();
    $tax_seller_data = explode(' ', $data['countries_seller']);
    $tax_buyer_data = explode(' ', $data['countries_buyer']);
}

if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $query = "DELETE FROM " . $DBPrefix . "tax WHERE id = :tax_id";
    $params = array();
    $params[] = array(':tax_id', $_GET['id'], 'int');
    $db->query($query, $params);
    header('location: tax_levels.php');
}

// get tax levels
$query = "SELECT * FROM " . $DBPrefix . "tax";
$db->direct_query($query);
while ($row = $db->fetch()) {
    $template->assign_block_vars('tax_rates', array(
            'ID' => $row['id'],
            'TAX_NAME' => $row['tax_name'],
            'TAX_RATE' => floatval($row['tax_rate']),
            'TAX_SELLER' => $row['countries_seller'],
            'TAX_BUYER' => $row['countries_buyer'],
            'TAX_SITE_RATE' => $row['fee_tax']
            ));
}

// get countries and make a list
$query = "SELECT * FROM " . $DBPrefix . "countries";
$db->direct_query($query);
$tax_seller = '';
$tax_buyer = '';
while ($row = $db->fetch()) {
    if (in_array($row['country'], $tax_seller_data)) {
        $tax_seller .= '<option value="' . $row['country'] . '" selected="selected">' . $row['country'] . '</option>';
    } else {
        $tax_seller .= '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';
    }
    if (in_array($row['country'], $tax_buyer_data)) {
        $tax_buyer .= '<option value="' . $row['country'] . '" selected="selected">' . $row['country'] . '</option>';
    } else {
        $tax_buyer .= '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';
    }
}

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TAX_ID' => (isset($data['id'])) ? $data['id'] : '',
        'TAX_NAME' => (isset($data['tax_name'])) ? $data['tax_name'] : '',
        'TAX_RATE' => (isset($data['tax_rate'])) ? $data['tax_rate'] : '',
        'TAX_SELLER' => $tax_seller,
        'TAX_BUYER' => $tax_buyer
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'tax_levels.tpl'
        ));
$template->display('body');
include 'footer.php';
