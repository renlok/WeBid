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

if (!isset($_GET['id'])) {
    $URL = $_SESSION['RETURN_LIST'];
    header('location: ' . $URL);
    exit;
}

$id = intval($_GET['id']);

// Retrieve auction's data
$query = "SELECT a.title, a.minimum_bid, a.starts, a.ends, a.auction_type, u.name, u.nick FROM " . $DBPrefix . "auctions a
          LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
          WHERE a.id = :id";
$params = array();
$params[] = array(':id', $id, 'int');
$db->query($query, $params);
if ($db->numrows() == 0) {
    $URL = $_SESSION['RETURN_LIST'];
    header('location: ' . $URL);
    exit;
}

$AUCTION = $db->result();

// Retrieve winners
$query = "SELECT w.bid, w.qty, u.name, u.nick FROM " . $DBPrefix . "winners w
          LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.winner)
          WHERE w.auction = :id";
$params = array();
$params[] = array(':id', $id, 'int');
$db->query($query, $params);
$winners = false;
while ($row = $db->fetch()) {
    $winners = true;
    $template->assign_block_vars('winners', array(
        'W_NICK' => $row['nick'],
        'W_NAME' => $row['name'],
        'BID' => $system->print_money($row['bid']),
        'QTY' => $row['qty']
        ));
}

// Retrieve bids
$query = "SELECT b.bid, b.quantity, u.name, u.nick FROM " . $DBPrefix . "bids b
          LEFT JOIN " . $DBPrefix . "users u ON (u.id = b.bidder)
          WHERE b.auction = :id";
$params = array();
$params[] = array(':id', $id, 'int');
$db->query($query, $params);
$bids = false;
while ($row = $db->fetch()) {
    $bids = true;
    $template->assign_block_vars('bids', array(
        'W_NICK' => $row['nick'],
        'W_NAME' => $row['name'],
        'BID' => $system->print_money($row['bid']),
        'QTY' => $row['quantity']
        ));
}

$template->assign_vars(array(
        'ID' => $id,
        'TITLE' => $AUCTION['title'],
        'S_NICK' => $AUCTION['nick'],
        'S_NAME' => $AUCTION['name'],
        'MIN_BID' => $system->print_money($AUCTION['minimum_bid']),
        'STARTS' => $dt->formatDate($AUCTION['starts']),
        'ENDS' => $dt->formatDate($AUCTION['ends']),
        'AUCTION_TYPE' => $system->SETTINGS['auction_types'][$AUCTION['auction_type']],

        'B_WINNERS' => $winners,
        'B_BIDS' => $bids
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'viewwinners.tpl'
        ));
$template->display('body');
include 'footer.php';
