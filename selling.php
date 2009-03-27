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
// Get closed auctions with winners
$query = "SELECT a.auction, b.title, b.ends
		 FROM " . $DBPrefix . "winners a, " . $DBPrefix . "auctions b
		 WHERE a.auction = b.id AND (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0 AND b.user = " . $user->user_data['id'] . "
		 GROUP BY b.id ORDER BY a.closingdate DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$sslurl = ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y') ? str_replace('http://', 'https://', $system->SETTINGS['siteurl']) : $system->SETTINGS['siteurl'];
$bgColor = "#EBEBEB";
$i = 0;
while ($row = mysql_fetch_array($res)) {
    $template->assign_block_vars('a', array(
            'TITLE' => $row['title'],
            'ENDS' => FormatDate($row['ends']),
            'AUCTIONID' => $row['auction']
            ));
    // Build winners array
    $query = "SELECT w.*, u.nick, u.email FROM " . $DBPrefix . "winners w
			LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.winner)
			WHERE w.auction = " . $row['auction'];
    $rr = mysql_query($query);
    $system->check_mysql($rr, $query, __LINE__, __FILE__);
    while ($winner = mysql_fetch_array($rr)) {
        $bgColor = ($bgColor == "#EBEBEB") ? "#FFFFFF" : "#EBEBEB";
        $fblink = ($winner['feedback_win'] == 0) ? '(<a href="' . $sslurl . 'feedback.php?auction_id=' . $row['auction'] . '&wid=' . $winner['winner'] . '&sid=' . $winner['seller'] . '&ws=w">' . $MSG['207'] . '</a>)' : '';
        $template->assign_block_vars('a.w', array(
                'BGCOLOUR' => $bgColor,
                'BID' => $winner['bid'],
                'BIDF' => $system->print_money($winner['bid']),
                'QTY' => $winner['qty'],
                'NICK' => $winner['nick'],
                'WINNERID' => $winner['winner'],
                'EMAIL' => $winner['email'],
                'FB' => $fblink
                ));
        $i++;
    }
}

$template->assign_vars(array(
        'NUM_WINNERS' => $i
        ));

require("header.php");
$TMP_usmenutitle = $MSG['453'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'selling.html'
        ));
$template->display('body');
include "footer.php";

?>