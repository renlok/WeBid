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

define('ErrorPage', 1);
include 'common.php';

if (isset($_SESSION['msg_title']) && isset($_SESSION['msg_body'])) {
    $title = $_SESSION['msg_title'];
    $body = $_SESSION['msg_body'];
} elseif ($user->logged_in && $user->user_data['suspended'] == 7) {
    $title = $MSG['753'];
    $body = $MSG['754'];
} elseif ($user->logged_in && $user->user_data['suspended'] == 6) {
    $query = "SELECT a.title, a.id FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "winners w ON (w.auction = a.id)
			WHERE w.bf_paid = 0 AND w.winner = :user_id";
    $params = array();
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);
    $auction_data = $db->result();
    $title = $MSG['753'];
    $url =  $system->SETTINGS['siteurl'] . 'pay.php?a=6&auction_id=' . $auction_data['id'];
    $body = sprintf($MSG['777'], htmlspecialchars($auction_data['title']), $url);
} elseif ($user->logged_in && $user->user_data['suspended'] == 5) {
    $query = "SELECT a.title, a.id FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "winners w ON (w.auction = a.id)
			WHERE w.ff_paid = 0 AND w.seller = :user_id";
    $params = array();
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);
    $auction_data = $db->result();
    $title = $MSG['753'];
    $url = $system->SETTINGS['siteurl'] . 'pay.php?a=7&auction_id=' . $auction_data['id'];
    $body = sprintf($MSG['796'], htmlspecialchars($auction_data['title']), $url);
} else {
    header('location: index.php');
    exit;
}

$template->assign_vars(array(
        'TITLE_MESSAGE' => $title,
        'BODY_MESSAGE' => $body
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'message.tpl'
        ));
$template->display('body');
include 'footer.php';
