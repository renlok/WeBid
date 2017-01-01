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

$item_title = htmlspecialchars($Auction['title']);

$emailer = new email_handler();
$emailer->assign_vars(array(
        'W_NAME' => $Winner['name'],

        'A_PICURL' => ($Auction['pict_url'] != '') ? UPLOAD_FOLDER . $Auction['id'] . '/' . $Auction['pict_url'] : 'images/email_alerts/default_item_img.jpg',
        'A_URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $Auction['id'],
        'A_TITLE' => $Auction['title'],
        'A_CURRENTBID' => $system->print_money($Auction['buy_now']),
        'A_QUANTITY' => $qty,
        'A_ENDS' => $ends_string,

        'S_NICK' => $Seller['nick'],
        'S_EMAIL' => $Seller['email'],

        'SITE_URL' => $system->SETTINGS['siteurl'],
        'SITENAME' => $system->SETTINGS['sitename']
        ));
$emailer->email_uid = $Winner['id'];
$emailer->email_sender($Winner['email'], 'endauction_multi_item_win.inc.php', $system->SETTINGS['sitename'] .  'You Won ' . $item_title);
