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

$item_title = htmlspecialchars($item_title);

$emailer = new email_handler();
$emailer->assign_vars(array(
        'SITE_URL' => $system->SETTINGS['siteurl'],
        'SITENAME' => $system->SETTINGS['sitename'],

        'C_NAME' => $OldWinner_name,

        'N_BID' => $new_bid,

        'A_TITLE' => $item_title,
        'A_ENDS' => $ends_string,
        'A_PICURL' => ($pict_url_plain != '') ? UPLOAD_FOLDER . $item_id . '/' . $pict_url_plain : 'images/email_alerts/default_item_img.jpg',
        'A_URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $item_id
        ));
$emailer->email_uid = $OldWinner_id;
$emailer->email_sender($OldWinner_email, 'no_longer_winner.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['906'] . ': ' . $item_title);
