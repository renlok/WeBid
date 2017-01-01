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
$current_page = 'auctions';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

// Data check
if (!isset($_REQUEST['id'])) {
    $URL = $_SESSION['RETURN_LIST'];
    header('location: ' . $URL);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == "Yes") {
    $catscontrol = new MPTTcategories();
    $auc_id = intval($_POST['id']);
    // uses same parameters in every query
    $params = array();
    $params[] = array(':auc_id', $auc_id, 'int');

    // get auction data
    $query = "SELECT category, num_bids, suspended, closed FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
    $db->query($query, $params);
    $auc_data = $db->result();

    if ($auc_data['suspended'] == 2) {
        $query = "DELETE FROM `" . $DBPrefix . "auction_moderation` WHERE auction_id = :auc_id";
        $db->query($query, $params);
    }

    // Delete related values
    $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
    $db->query($query, $params);

    // delete bids
    $query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
    $db->query($query, $params);

    // Delete proxybids
    $query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
    $db->query($query, $params);

    // Delete file in counters
    $query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = :auc_id";
    $db->query($query, $params);

    if ($auc_data['suspended'] == 0 && $auc_data['closed'] == 0) {
        // update main counters
        $query = "UPDATE " . $DBPrefix . "counters SET auctions = (auctions - 1), bids = (bids - :num_bids)";
        $params = array();
        $params[] = array(':num_bids', $auc_data['num_bids'], 'int');
        $db->query($query, $params);

        // update recursive categories
        $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
        $params = array();
        $params[] = array(':cat_id', $auc_data['category'], 'int');
        $db->query($query, $params);

        $parent_node = $db->result();
        $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

        for ($i = 0; $i < count($crumbs); $i++) {
            $query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
            $params = array();
            $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
            $db->query($query, $params);
        }
    }

    // Delete auctions images
    if (is_dir(UPLOAD_PATH . $auc_id)) {
        if ($dir = opendir(UPLOAD_PATH . $auc_id)) {
            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..') {
                    @unlink(UPLOAD_PATH . $auc_id . '/' . $file);
                }
            }
            closedir($dir);
            rmdir(UPLOAD_PATH . $auc_id);
        }
    }

    $URL = $_SESSION['RETURN_LIST'];
    //unset($_SESSION['RETURN_LIST']);
    header('location: ' . $URL);
    exit;
} elseif (isset($_POST['action']) && $_POST['action'] == "No") {
    $URL = $_SESSION['RETURN_LIST'];
    //unset($_SESSION['RETURN_LIST']);
    header('location: ' . $URL);
    exit;
}

$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
$params = array();
$params[] = array(':auc_id', $_GET['id'], 'int');
$db->query($query, $params);
$title = $db->result('title');

$template->assign_vars(array(
        'ID' => $_GET['id'],
        'MESSAGE' => sprintf($MSG['confirm_auction_delete'], $title),
        'TYPE' => 1
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'confirm.tpl'
        ));
$template->display('body');
include 'footer.php';
