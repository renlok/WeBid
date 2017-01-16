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
if (!$user->logged_in) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_c.php';
    header('location: user_login.php');
    exit;
}
// check if the user can access this page
$user->checkSuspended();

// DELETE OPEN AUCTIONS
$catscontrol = new MPTTcategories();
$user_message = '';

$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'relist_fee'";
$db->direct_query($query);
$relist_fee = $db->result('value');

// Update
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Delete auction
    if (isset($_POST['delete']) && is_array($_POST['delete']) && count($_POST['delete']) > 0) {
        foreach ($_POST['delete'] as $k => $v) {
            $v = intval($v);
            // Pictures Gallery
            if (is_dir(UPLOAD_PATH . $v)) {
                if ($dir = opendir(UPLOAD_PATH . $v)) {
                    while ($file = readdir($dir)) {
                        if ($file != '.' && $file != '..') {
                            unlink(UPLOAD_PATH . $v . '/' . $file);
                        }
                    }
                    closedir($dir);
                    rmdir(UPLOAD_PATH . $v);
                }
            }

            $query = "UPDATE " . $DBPrefix . "counters SET closedauctions = closedauctions - 1";
            $db->direct_query($query);

            $query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $v, 'int');
            $db->query($query, $params);

            $query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $v, 'int');
            $db->query($query, $params);

            $query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $v, 'int');
            $db->query($query, $params);

            $query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $v, 'int');
            $db->query($query, $params);
        }
        $user_message .= sprintf($MSG['1145'], count($_POST['delete']));
    }
    if (isset($_POST['sell']) && is_array($_POST['sell']) && count($_POST['sell']) > 0) {
        foreach ($_POST['sell'] as $v) {
            $query = "UPDATE " . $DBPrefix . "auctions SET sold = 's' WHERE id = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $v, 'int');
            $db->query($query, $params);
        }
        include 'cron.php';
        $user_message .= sprintf($MSG['1147'], count($_POST['sell']));
    }
    // Re-list auctions
    if (isset($_POST['relist']) && is_array($_POST['relist']) && count($_POST['relist']) > 0) {
        foreach ($_POST['relist'] as $k) {
            $k = intval($k);
            $query = "SELECT duration, category, quantity FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $k, 'int');
            $db->query($query, $params);
            $AUCTION = $db->result();
            $suspend = 0;

            if ($system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees'] && $relist_fee > 0) {
                if ($system->SETTINGS['fee_type'] == 1) {
                    // charge relist fee
                    $query = "UPDATE " . $DBPrefix . "users SET balance = balance - :relist_fee WHERE id = :user_id";
                    $params = array();
                    $params[] = array(':relist_fee', $relist_fee, 'float');
                    $params[] = array(':user_id', $user->user_data['id'], 'int');
                    $db->query($query, $params);
                } else {
                    $suspend = 8;
                }
            }

            // auction ends
            $start_date = new DateTime('now', $dt->UTCtimezone);
            $start_date->add(new DateInterval('P' . $AUCTION['duration'] . 'D'));
            $auction_ends = $start_date->format('Y-m-d H:i:s');

            $query = "UPDATE " . $DBPrefix . "auctions
                      SET starts = CURRENT_TIMESTAMP,
                      ends = :ends,
                      closed = 0,
                      num_bids = 0,
                      relisted = relisted + 1,
                      current_bid = 0,
                      sold = 'n',
                      suspended = :suspended
                      WHERE id = :auc_id";
            $params = array();
            $params[] = array(':ends', $auction_ends, 'str');
            $params[] = array(':suspended', $suspend, 'int');
            $params[] = array(':auc_id', $k, 'int');
            $db->query($query, $params);

            // delete bids
            $query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $k, 'int');
            $db->query($query, $params);

            // Proxy Bids
            $query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $k, 'int');
            $db->query($query, $params);

            // Winners: only in case of reserve not reached
            $query = "DELETE FROM " . $DBPrefix . "winners WHERE auction = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $k, 'int');
            $db->query($query, $params);

            // Update COUNTERS table
            $query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
            $db->direct_query($query);

            // get category data to update it
            $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
            $params = array();
            $params[] = array(':cat_id', $AUCTION['category'], 'int');
            $db->query($query, $params);

            $parent_node = $db->result();
            $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
            // update recursive categories
            for ($i = 0; $i < count($crumbs); $i++) {
                $query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
                $db->query($query, $params);
            }
            if ($system->SETTINGS['fee_type'] == 2 && isset($relist_fee) && $relist_fee > 0) {
                header('location: pay.php?a=5');
                exit;
            }
        }
        $user_message .= sprintf($MSG['1146'], count($_POST['relist']));
        if ($relist_fee > 0) {
            $user_message .= sprintf($MSG['1148'], $system->print_money((count($_POST['relist']) * $relist_fee), true, false));
        }
    }
}

// Retrieve closed auction data from the database
$query = "SELECT COUNT(id) AS COUNT FROM " . $DBPrefix . "auctions
          WHERE user = :user_id
          AND closed = 1 AND suspended = 0
          AND (num_bids = 0 OR (num_bids > 0 AND current_bid < reserve_price AND sold = 'n'))";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$TOTALAUCTIONS = $db->result('COUNT');

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1) {
    $OFFSET = 0;
    $PAGE = 1;
} else {
    $PAGE = intval($_GET['PAGE']);
    $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);
// Handle columns sorting variables
if (!isset($_SESSION['ca_ord']) && empty($_GET['ca_ord'])) {
    $_SESSION['ca_ord'] = 'title';
    $_SESSION['ca_type'] = 'asc';
} elseif (!empty($_GET['ca_ord'])) {
    $_SESSION['ca_ord'] = $_GET['ca_ord'];
    $_SESSION['ca_type'] = $_GET['ca_type'];
} elseif (isset($_SESSION['ca_ord']) && empty($_GET['ca_ord'])) {
    $_SESSION['ca_nexttype'] = $_SESSION['ca_type'];
}

if (!isset($_SESSION['ca_nexttype']) || $_SESSION['ca_nexttype'] == 'desc') {
    $_SESSION['ca_nexttype'] = 'asc';
} else {
    $_SESSION['ca_nexttype'] = 'desc';
}

if (!isset($_SESSION['ca_type']) || $_SESSION['ca_type'] == 'desc') {
    $_SESSION['ca_type_img'] = '<img src="images/arrow_up.gif" align="center" hspace="2" border="0">';
} else {
    $_SESSION['ca_type_img'] = '<img src="images/arrow_down.gif" align="center" hspace="2" border="0">';
}

$query = "SELECT *  FROM " . $DBPrefix . "auctions
	WHERE user = :user_id
	AND closed = 1 AND suspended = 0
	AND (num_bids = 0 OR (num_bids > 0 AND reserve_price > 0 AND current_bid < reserve_price AND sold = 'n'))
	ORDER BY " . $_SESSION['ca_ord'] . " " . $_SESSION['ca_type'] . " LIMIT :offset, :perpage";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

$i = 0;
while ($item = $db->fetch()) {
    $canrelist = false;
    if (($item['current_bid'] > $item['reserve_price'])) {
        $cansell = false;
    } else {
        if ($item['reserve_price'] > 0 || $item['num_bids'] == 0) {
            $canrelist = true;
        }
        if ($item['reserve_price'] > 0 && $item['num_bids'] > 0) {
            $cansell = true;
        } else {
            $cansell = false;
        }
    }

    $template->assign_block_vars('items', array(
            'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
            'ID' => $item['id'],
            'TITLE' => htmlspecialchars($item['title']),
            'STARTS' => $dt->formatDate($item['starts']),
            'ENDS' => $dt->formatDate($item['ends']),
            'BID' => ($item['current_bid'] == 0) ? '-' : $system->print_money($item['current_bid']),
            'BIDS' => $item['num_bids'],

            'B_CANRELIST' => $canrelist,
            'B_CANSSELL' => $cansell,
            'B_HASNOBIDS' => ($item['current_bid'] == 0)
            ));

    $i++;
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
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_c.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$template->assign_vars(array(
        'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
        'ORDERCOL' => $_SESSION['ca_ord'],
        'ORDERNEXT' => $_SESSION['ca_nexttype'],
        'ORDERTYPEIMG' => $_SESSION['ca_type_img'],
        'RELIST_FEE' => $system->print_money($relist_fee),
        'RELIST_FEE_NO' => $system->print_money_nosymbol($relist_fee),
        'USER_MESSAGE' => $user_message,

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_c.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_c.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES,

        'B_AREITEMS' => ($i > 0),
        'B_RELIST_FEE' => ($relist_fee > 0 && $system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees']),
        'B_AUTORELIST' => ($system->SETTINGS['autorelist'] == 'y')
        ));

include 'header.php';
$TMP_usmenutitle = $MSG['354'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
        'body' => 'yourauctions_c.tpl'
        ));
$template->display('body');
include 'footer.php';
