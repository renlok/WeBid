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

if (!defined('InWeBid')) {
    exit();
}

// Check if the e-mail has to be sent or not
$query = "SELECT endemailmode FROM " . $DBPrefix . "users WHERE id = :seller_id";
$params = array();
$params[] = array(':seller_id', $Seller['id'], 'int');
$db->query($query, $params);
$emailmode = $db->result('endemailmode');

$qty_current = ($Auction['initial_quantity'] == $Auction['quantity']) ? $Auction['initial_quantity'] : $Auction['quantity'];
$qty_sold = $Auction['initial_quantity'] - $qty_current;
$qty_left = $Auction['quantity'];

$report_text = $Winner['nick'] . ' - <a href="mailto:' . $Winner['email'] . '">' . $Winner['email'] . '</a>';
$report_text .= '<br>' .$MSG['30_0086'] . $Winner['address'] . ', ' . $Winner['city'] . ', ' . $Winner['prov'] . ', ' . $Winner['zip'] . ', ' . $Winner['country'];

if ($emailmode == 'one') {
    $emailer = new email_handler();
    $emailer->assign_vars(array(
            'S_NAME' => $Seller['name'],

            'A_URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $Auction['id'],
            'A_PICURL' => ($Auction['pict_url'] != '') ? UPLOAD_FOLDER . $Auction['id'] . '/' . $Auction['pict_url'] : 'images/email_alerts/default_item_img.jpg',
            'A_TITLE' => $Auction['title'],
            'A_CURRENTBID' => $system->print_money($Auction['buy_now']),
            'A_QTY_SOLD' => $qty_sold,
            'A_QTY_LEFT' => $qty_left,
            'A_QTY_THIS_SALE' => $qty,
            'A_ENDS' => $ends_string,

            'B_REPORT' => $report_text,

            'SITE_URL' => $system->SETTINGS['siteurl'],
            'SITENAME' => $system->SETTINGS['sitename']
    ));
    $emailer->email_uid = $Seller['id'];
    $subject            = $system->SETTINGS['sitename'] . ' Some items have been sold in ' . $Auction['title'];
    $emailer->email_sender($Seller['email'], 'email_seller_partial_winner.inc.php', $subject);
}
