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

include 'common.php';

// If user is not logged in redirect to login page
if (!$user->checkAuth()) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'invoices.php';
    header('location: user_login.php');
    exit;
}

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1) {
    $OFFSET = 0;
    $PAGE = 1;
} else {
    $PAGE = intval($_GET['PAGE']);
    $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

// count the pages
$query = "SELECT COUNT(useracc_id) As COUNT  FROM " . $DBPrefix . "useraccounts
		WHERE user_id = :user_id AND total > 0";
$params = array(
    array(':user_id', $user->user_data['id'], 'int'),
);
$db->query($query, $params);
$TOTALINVOICES = $db->result('COUNT');
$PAGES = ($TOTALINVOICES == 0) ? 1 : ceil($TOTALINVOICES / $system->SETTINGS['perpage']);

// get this page of data
$query = "SELECT ua.*, a.title FROM " . $DBPrefix . "useraccounts ua
		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = ua.auc_id)
		WHERE ua.user_id = :user_id AND ua.total > 0
		LIMIT :OFFSET, :perpage";
$params = array(
    array(':user_id', $user->user_data['id'], 'int'),
    array(':OFFSET', $OFFSET, 'int'),
    array(':perpage', $system->SETTINGS['perpage'], 'int'),
);
$db->query($query, $params);

while ($row = $db->fetch()) {
    // build invoice info
    $info = '';
    $auc_id = false;
    if ($row['setup'] != 0) {
        $info .= $MSG['432'] . ' ' . $system->print_money($row['setup']) . '<br>';
        $auc_id = true;
    }
    if ($row['featured'] != 0) {
        $info .= $MSG['433'] . ' ' . $system->print_money($row['featured']) . '<br>';
        $auc_id = true;
    }
    if ($row['bold'] != 0) {
        $info .= $MSG['439'] . ' ' . $system->print_money($row['bold']) . '<br>';
        $auc_id = true;
    }
    if ($row['highlighted'] != 0) {
        $info .= $MSG['434'] . ' ' . $system->print_money($row['highlighted']) . '<br>';
        $auc_id = true;
    }
    if ($row['subtitle'] != 0) {
        $info .= $MSG['803'] . ' ' . $system->print_money($row['subtitle']) . '<br>';
        $auc_id = true;
    }
    if ($row['relist'] != 0) {
        $info .= $MSG['437'] . ' ' . $system->print_money($row['relist']) . '<br>';
        $auc_id = true;
    }
    if ($row['reserve'] != 0) {
        $info .= $MSG['440'] . ' ' . $system->print_money($row['reserve']) . '<br>';
        $auc_id = true;
    }
    if ($row['buynow'] != 0) {
        $info .= $MSG['436'] . ' ' . $system->print_money($row['buynow']) . '<br>';
        $auc_id = true;
    }
    if ($row['picture'] != 0) {
        $info .= $MSG['435'] . ' ' . $system->print_money($row['picture']) . '<br>';
        $auc_id = true;
    }
    if ($row['extracat'] != 0) {
        $info .= $MSG['804'] . ' ' . $system->print_money($row['extracat']) . '<br>';
        $auc_id = true;
    }
    if ($row['signup'] != 0) {
        $info .= $MSG['768'] . ' ' . $system->print_money($row['signup']) . '<br>';
    }
    if ($row['buyer'] != 0) {
        $info .= $MSG['775'] . ' ' . $system->print_money($row['buyer']) . '<br>';
        $auc_id = true;
    }
    if ($row['finalval'] != 0) {
        $info .= $MSG['791'] . ' ' . $system->print_money($row['finalval']) . '<br>';
        $auc_id = true;
    }
    if ($row['balance'] != 0) {
        $info .= $MSG['935'] . ' ' . $system->print_money($row['balance']) . '<br>';
    }

    if ($auc_id) {
        if (empty($row['title'])) {
            $info = '<strong>' . $MSG['1034'] . ': ' . $row['auc_id'] . '</strong><br>' . $info;
        } else {
            $info = '<strong><a href="item.php?id=' . $row['auc_id'] . '">' . $row['title'] . '</a></strong><br>' . $info;
        }
    }

    $template->assign_block_vars('topay', array(
            'INVOICE' => $row['useracc_id'],
            'AUC_ID' => $row['auc_id'],
            'DATE' => $dt->formatDate($row['date']),
            'INFO' => $info,
            'TOTAL' => $system->print_money($row['total']),
            'PAID' => ($row['paid'] == 1), // true if paid
            'PDF' => $system->SETTINGS['siteurl'] . 'item_invoice.php?id=' . $row['auc_id']
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
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'invoices.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$_SESSION['INVOICE_RETURN'] = 'invoices.php';
$template->assign_vars(array(
        'CURRENCY' => $system->SETTINGS['currency'],

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'invoices.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'invoices.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES
        ));

include 'header.php';
$TMP_usmenutitle = $MSG['1059'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
        'body' => 'invoices.tpl'
        ));
$template->display('body');
include 'footer.php';
