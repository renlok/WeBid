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

$extra_sql = '';

// Get the posted variables if this is a new search.
if (isset($_POST['auctionid'])) {
    $_SESSION['searchauctionsauctionid'] = intval($_POST['auctionid']);
}
if (isset($_POST['usernick'])) {
    $_SESSION['usernick'] = $_POST['usernick'];
}
if (isset($_POST['userid'])) {
    $_SESSION['searchauctionsuid'] = intval($_POST['userid']);
}
if (isset($_POST['titlekeywords'])) {
    $_SESSION['searchauctionstitlekeywords'] = $_POST['titlekeywords'];
}
if (isset($_POST['auctiontype'])) {
    $_SESSION['searchauctionsauctiontype'] = intval($_POST['auctiontype']);
}
$auction_sql=$usernick_sql=$user_sql=$titlekeywords_sql = '';
if (isset($_SESSION['searchauctionsauctionid']) && $_SESSION['searchauctionsauctionid'] > 0) {
    $auction_sql = " AND a.id = " . intval($_SESSION['searchauctionsauctionid']);
}
if (isset($_SESSION['usernick']) && $_SESSION['usernick'] != '') {
    $usernick_sql = " AND u.nick = '" . $_SESSION['usernick'] . "'" ;
}
if (isset($_SESSION['searchauctionsuid']) && $_SESSION['searchauctionsuid'] > 0) {
    $user_sql = " AND a.user = " . intval($_SESSION['searchauctionsuid']);
}
if (isset($_SESSION['searchauctionstitlekeywords']) && $_SESSION['searchauctionstitlekeywords'] != '') {
    $titlekeywords_sql = " AND INSTR(LCASE(a.title), '" . strtolower($_SESSION['searchauctionstitlekeywords']) . "') > 0";
}
$auctiontype_sql = "a.id > 0";
if (!empty($_SESSION['searchauctionsauctiontype'])) {
    switch ($_SESSION['searchauctionsauctiontype']) {
        case 1:    // open auctions
            $auctiontype_sql = "a.closed = 0 and a.suspended = 0";
        break;
        case 2: // closed auctions
            $auctiontype_sql = "a.closed = 1";
        break;
        case 3:    // suspended auctions
            $auctiontype_sql = "a.suspended != 0";
        break;
        default:            // all auctions
            $auctiontype_sql = "";
    }
}
// If a new search is posted, you need to unset $_SESSION['RETURN_LIST_OFFSET'] to get page 1.
if (isset($_POST['auctionid'])) {
    unset($_SESSION['RETURN_LIST_OFFSET']);
}

// Set offset and limit for pagination
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE'])) {
    $PAGE = intval($_GET['PAGE']);
    $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
} elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'searchauctions.php') {
    $PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
    $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
} else {
    $OFFSET = 0;
    $PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'searchauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(a.id) As auctions FROM " . $DBPrefix . "auctions a INNER JOIN " . $DBPrefix . "users u
          ON (u.id = a.user) WHERE " . $auctiontype_sql . $auction_sql . $usernick_sql . $user_sql . $titlekeywords_sql;
$db->direct_query($query);
$num_auctions = $db->result('auctions');
$PAGES = ($num_auctions == 0) ? 1 : ceil($num_auctions / $system->SETTINGS['perpage']);

$query = "SELECT a.id, u.nick, a.title, a.starts, a.ends, a.suspended, c.cat_name FROM " . $DBPrefix . "auctions a
          INNER JOIN " . $DBPrefix . "users u ON (u.id = a.user)
          LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = a.category)
          WHERE " . $auctiontype_sql . $auction_sql . $usernick_sql . $user_sql . $titlekeywords_sql . "
          ORDER BY nick, starts, title LIMIT :offset, :perpage";
$params = array();
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

while ($row = $db->fetch()) {
    $template->assign_block_vars('auctions', array(
            'SUSPENDED' => $row['suspended'],
            'ID' => $row['id'],
            'TITLE' => htmlspecialchars($row['title']),
            'START_TIME' => $dt->printDateTz($row['starts']),
            'END_TIME' => $dt->printDateTz($row['ends']),
            'USERNAME' => $row['nick'],
            'CATEGORY' => $row['cat_name'],
            'B_HASWINNERS' => false
            ));
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
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/searchauctions.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

// Set the HTML for the auction type radio buttons.
/*
    This creates an array of the values for the radio buttons for each option type to the language file names for each.
    0 = all auctions
    1 = open auctions (includes suspended)
    2 = closed auctions (includes suspended)
    3 = suspended auctions
*/
$types = array(0 => '619a', 1 => '619', 2 => '204', 3 => '2__0056');
$auctiontypeshtml = '';
foreach ($types as $key => $val) {
    if (isset($_SESSION['searchauctionsauctiontype']) && $key == $_SESSION['searchauctionsauctiontype']) {
        $auctiontypeshtml .= '<input type="radio" name="auctiontype" value="' . $key . '" checked="checked"> ' . str_ireplace('auctions', '', $MSG[$val]) . ' ';
    } else {
        $auctiontypeshtml .= '<input type="radio" name="auctiontype" value="' . $key . '"> ' . str_ireplace('auctions', '', $MSG[$val]) . ' ';
    }
}

$template->assign_vars(array(
        'PAGE_TITLE' => $MSG['search_auctions'],
        'NUM_AUCTIONS' => $num_auctions,
        'B_SEARCHUSER' => ((isset($_SESSION['searchauctionsuid']) && $_SESSION['searchauctionsuid'] > 0) || (isset($_SESSION['usernick']) && $_SESSION['usernick'] != '')) ? true : false,
        'USERNICK' => isset($_SESSION['usernick'])? $_SESSION['usernick'] : '',
        'AUCTIONID' => isset($_SESSION['searchauctionsauctionid'])? $_SESSION['searchauctionsauctionid'] : '',
        'USERID' => isset($_SESSION['searchauctionsuid'])?  $_SESSION['searchauctionsuid'] : '',
        'TITLEKEYWORDS' => isset($_SESSION['searchauctionstitlekeywords'])? $_SESSION['searchauctionstitlekeywords'] : '',
        'AUCTIONTYPE' => $auctiontypeshtml,
        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/searchauctions.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/searchauctions.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'searchauctions.tpl'
        ));
$template->display('body');
include 'footer.php';
