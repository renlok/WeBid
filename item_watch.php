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

include 'common.php';
include INCLUDE_PATH . 'browseitems.inc.php';

// If user is not logged in redirect to login page
if (!$user->checkAuth()) {
    header("location: user_login.php");
    exit;
}

$user_message = '';

// Auction id is present, now update table
if (isset($_GET['add']) && !empty($_GET['add'])) {
    $add_id = intval($_GET['add']);
    // Check if this item is not already added
    $items = trim($user->user_data['item_watch']);
    $arr_items = explode(' ', $items);

    if (!in_array($add_id, $arr_items)) {
        $item_watch = trim($items . ' ' . $add_id);
        $item_watch_new = trim($item_watch);
        $query = "UPDATE " . $DBPrefix . "users SET item_watch = :item_watch_new WHERE id = :user_id";
        $params = array();
        $params[] = array(':item_watch_new', $system->cleanvars($item_watch_new), 'str');
        $params[] = array(':user_id', $user->user_data['id'], 'int');
        $db->query($query, $params);
        $user->user_data['item_watch'] = $item_watch_new;
        $user_message .= $MSG['item_watch_item_added'];
    } else {
        $user_message .= $MSG['item_watch_not_added'];
    }
}

// Delete item form item watch
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $item_to_delete = $_GET['delete'];
    $currently_watched_items = explode(' ', trim($user->user_data['item_watch']));

    $items_to_watch = array();

    for ($j = 0; $j < count($currently_watched_items); $j++) {
        if ($currently_watched_items[$j] != $item_to_delete) {
            array_push($items_to_watch, $currently_watched_items[$j]);
        }
    }

    $query = "UPDATE " . $DBPrefix . "users SET item_watch = :item_watch WHERE id = :user_id";
    $params = array();
    $params[] = array(':item_watch', implode(' ', $items_to_watch), 'str');
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);
    $user->user_data['item_watch'] = implode(' ', $items_to_watch);
    $user_message .= $MSG['item_watch_item_removed'];
}

// Show results
$items = trim($user->user_data['item_watch']);

if ($items != '' && $items != null) {
    $itemids = str_replace(' ', ',', $items);
    $query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id IN (" . $itemids . ")";
    $db->direct_query($query);
    $total = $db->numrows();
    browseItems($query, null, '', '', $total, 'item_watch.php');
}

$template->assign_vars(array(
        'USER_MESSAGE' => $user_message
        ));

include 'header.php';
$TMP_usmenutitle = $MSG['472'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
        'body' => 'item_watch.tpl'
        ));
$template->display('body');
include 'footer.php';
