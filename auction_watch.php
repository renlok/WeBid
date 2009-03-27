<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

require('includes/common.inc.php');
// If user is not logged in redirect to login page
if (!$user->logged_in) {
    header("Location: user_login.php");
    exit;
}
// Auction id is present, now update table
if (isset($_GET['insert']) && $_GET['insert'] == "true" && !empty($_REQUEST['add'])) {
    $requestadd = $system->cleanvars($_REQUEST['add']);
    // Check if this keyword is not already added
    $query = "SELECT auc_watch FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
    $result = mysql_query($query);
    $system->check_mysql($result, $query, __LINE__, __FILE__);
    $auctions = trim(mysql_result($result, 0, 'auc_watch'));
    if (!empty($auctions)) {
        $match = strstr($auctions, $requestadd);
        $auctions = $auctions;
    } else {
        $auctions = '';
    }

    if (!$match) {
        $auction_watch = trim($auctions . ' ' . $requestadd);
        $auction_watch_new = trim($auction_watch);
        $query = "UPDATE " . $DBPrefix . "users SET auc_watch = '$auction_watch_new' WHERE id = " . $user->user_data['id'];
        $result = mysql_query($query);
        $system->check_mysql($result, $query, __LINE__, __FILE__);
    }
}
// Delete auction from auction watch
if (isset($_GET['delete'])) {
    $query = "SELECT auc_watch FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
    $result = mysql_query($query);
    $system->check_mysql($result, $query, __LINE__, __FILE__);
    $auctions = trim(mysql_result ($result, 0, "auc_watch"));

    $auc_id = split(" ", $auctions);
    for ($j = 0; $j < count($auc_id); $j++) {
        $match = strstr($auc_id[$j], $_GET['delete']);
        if ($match) {
            $auction_watch = $auction_watch;
        } else {
            $auction_watch = $auc_id[$j] . ' ' . $auction_watch;
        }
    }
    $auction_watch_new = trim($auction_watch);
    $query = "UPDATE " . $DBPrefix . "users SET auc_watch = '$auction_watch_new' WHERE id = " . $user->user_data['id'];
    $result = mysql_query($query);
    $system->check_mysql($result, $query, __LINE__, __FILE__);
}

$query = "SELECT auc_watch FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$auctions = trim(mysql_result ($result, 0, 'auc_watch'));

if ($auctions != '') {
    $auction = split(' ', $auctions);
    for ($j = 0; $j < count($auction); $j++) {
        $template->assign_block_vars('items', array(
                'ITEM' => $auction[$j],
                'ITEMENCODE' => urlencode($auction[$j])
                ));
    }
}

include "header.php";
$TMP_usmenutitle = $MSG['471'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'auction_watch.html'
        ));
$template->display('body');
include "footer.php";

?>