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

if ($emailmode == 'one') {
    $emailer = new email_handler();
    $emailer->assign_vars(array(
            'S_NAME' => $Seller['name'],
            'S_NICK' => $Seller['nick'],
            'S_EMAIL' => $Seller['email'],
            'A_TITLE' => htmlspecialchars($Auction['title']),
            'A_ID' => $Auction['id'],
            'A_END' => $ends_string,
            'A_URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $Auction['id'],
            'SITE_URL' => $system->SETTINGS['siteurl'],
            'A_PICURL' => ($Auction['pict_url'] != '') ? $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . $Auction['id'] . '/' . $Auction['pict_url'] : $system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
            'SITENAME' => $system->SETTINGS['sitename']
            ));
    $emailer->email_uid = $Seller['id'];
    $emailer->email_sender($Seller['email'], 'endauction_nowinner.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['112']);
}
