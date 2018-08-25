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

// check if looking for users auctions
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
$user_sql = isset($_GET['uid']) ? " AND a.user = " . $uid : '';

// Set offset and limit for pagination
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE'])) {
    $PAGE = intval($_GET['PAGE']);
    $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
} elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'listreportedauctions.php') {
    $PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
    $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
} else {
    $OFFSET = 0;
    $PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'listreportedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(a.id) As auctions FROM " . $DBPrefix . "auctions a
          INNER JOIN " . $DBPrefix . "reportedauctions r ON (r.auction_id = a.id)
          WHERE a.closed = 0  AND r.dismiss = false " . $user_sql;
          
$db->direct_query($query);

$num_auctions = $db->result('auctions');
$PAGES = ($num_auctions == 0) ? 1 : ceil($num_auctions / $system->SETTINGS['perpage']);


    $query = "SELECT
    reported.id,
    reported.auction_id as reported_auction,
    reported.dismiss as dismissed,
    auction.id as auction_id,
    auction.title,
    auction.starts as start_date,
    auction.ends as end_date,
    auction.suspended,
    categories.cat_name as category,
    seller.nick as seller_name,
    COUNT(w.id) as winners,
    reporter.nick as reporter_name,
    reason.reason as reason_given "
        . "FROM " . $DBPrefix . "reportedauctions reported
        RIGHT JOIN " . $DBPrefix . "auctions auction ON (reported.auction_id = auction.id)
        LEFT JOIN " . $DBPrefix . "categories categories ON (categories.cat_id = auction.category)
        INNER JOIN " . $DBPrefix . "users reporter ON (reporter.id = reported.user_id)
        INNER JOIN " . $DBPrefix . "users seller ON (seller.id = auction.user)
        INNER JOIN " . $DBPrefix . "reporting_options reason ON (reason.id = reported.reason)
        LEFT JOIN " . $DBPrefix . "auction_moderation moderation ON (auction.id = moderation.auction_id)
        LEFT JOIN " . $DBPrefix . "winners w ON (w.auction = auction.id)
        WHERE moderation.reason IS NULL AND auction.closed = 0 " . $user_sql
        . " GROUP BY reported.id, seller.nick, reporter.nick, auction.suspended, moderation.reason 
        ORDER BY auction.id
        LIMIT :offset, :perpage";
$params = array();
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$report_counter = 0;
while($row = $db->fetch()) {
    //print("Auction Title: " . $row['title'] . " Auction Id: " . $row['auction_id'] . " Category: " . $row['category'] . " Sellers Name: " . $row['seller_name'] . " Reported by: " . $row['reporter_name'] . " For this reason: " . $row['reason_given'] . "<br>");
    if (!$row['dismissed']) {
        $report_counter +=1;
    }
    $template->assign_block_vars('auctions', array(
        'ID' => $row['auction_id'],
        'TITLE' => htmlspecialchars($row['title']),
        'START_TIME' => $dt->printDateTz($row['start_date']),
        'END_TIME' => $dt->printDateTz($row['end_date']),
        'CATEGORY' => $row['category'],
        'SELLERNAME' => $row['seller_name'],
        'SUSPENDED' => $row['suspended'],
        'REPORTERNAME' => $row['reporter_name'],
        'REASONGIVEN' => trim($row['reason_given'],' '),
        'DISMISSED' => $row['dismissed'],
        'REPORTID' => $row['id'],
        'REPORTCOUNTER' => $report_counter,
        'B_HASWINNERS' => ($row['winners'] == 0) ? false : true,
        'TIMESREPORTED' => 1
        )
    );
}

// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1) {
    $LOW = $PAGE - 5;
    if ($LOW <= 0) {
        $LOW = 1;
    }
    $COUNTER = $LOW;
    while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6)) {
        $template->assign_block_vars('pages', array(
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/listreportedauctions.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$template->assign_vars(array(
        'PAGE_TITLE' => $MSG['view_reported_auctions'],
        'NUM_AUCTIONS' => $num_auctions,
        'B_SEARCHUSER' => ($uid > 0),
        //'USERNAME' => $username,

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/listreportedauctions.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/listreportedauctions.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'listreportedauctions.tpl'
        ));
$template->display('body');
include 'footer.php';
