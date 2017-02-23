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

function printLog($str)
{
    global $system;

    if (defined('LogCron') && LogCron == true) {
        $system->log('cron', $str);
    }
}

function printLogL($str, $level)
{
    for ($i = 1; $i <= $level; ++$i) {
        $str = "\t" . $str;
    }
    printLog($str);
}

function constructCategories()
{
    global $DBPrefix, $db;

    $query = "SELECT cat_id, parent_id, sub_counter, counter
				FROM " . $DBPrefix . "categories ORDER BY cat_id";
    $db->direct_query($query);

    while ($row = $db->fetch()) {
        $row['updated'] = false;
        $categories[$row['cat_id']] = $row;
    }
    return $categories;
}

function sendWatchEmails($id)
{
    global $DBPrefix, $system, $db;

    $query = "SELECT name, email, item_watch, id FROM " . $DBPrefix . "users WHERE item_watch LIKE :item_watch";
    $params = array();
    $params[] = array(':item_watch', '% ' . $id . ' %', 'str');
    $db->query($query, $params);

    while ($watchusers = $db->fetch()) {
        $keys = explode(' ', $watchusers['item_watch']);
        // If keyword matches with opened auction title or/and desc send user a mail
        if (in_array($id, $keys)) {
            $emailer = new email_handler();
            $emailer->assign_vars(array(
                    'URL' => $system->SETTINGS['siteurl'] . 'item.php?mode=1&id=' . $id,
                    'TITLE' => htmlspecialchars($Auction['title']),
                    'NAME' => $watchusers['name']
                    ));
            $emailer->email_uid = $watchusers['id'];
            $emailer->email_sender($watchusers['email'], 'auctionend_watchmail.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['471']);
        }
    }
}

function sortFees()
{
    global $DBPrefix, $system, $Winner, $Seller, $Auction, $buyer_emails;
    global $endauc_fee, $buyer_fee, $buyer_fee_type, $bf_paid, $ff_paid, $db;

    if ($buyer_fee > 0) {
        // is the winner fee exempt
        $query = "SELECT COUNT(no_fees) As no_fees FROM " . $DBPrefix . "groups WHERE id IN (" . $Winner['groups'] . ") AND no_fees = 1";
        $db->direct_query($query);
        $winner_no_fees = $db->result('no_fees');

        if (!$winner_no_fees) {
            if ($system->SETTINGS['fee_type'] == 1) {
                if ($buyer_fee_type == 'flat') {
                    $fee_value = $buyer_fee;
                } else {
                    $fee_value = ($buyer_fee / 100) * floatval($Auction['current_bid']);
                }
                // add balance & invoice
                $query = "UPDATE " . $DBPrefix . "users SET balance = balance - :buyer_fee WHERE id = :winner_id";
                $params = array();
                $params[] = array(':buyer_fee', $fee_value, 'float');
                $params[] = array(':winner_id', $Winner['id'], 'int');
                $db->query($query, $params);
                $query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, buyer, total, paid)
                        VALUES (:winner_id, :auc_id, :buyer_fee, :buyer_fee, 1)";
                $params = array();
                $params[] = array(':buyer_fee', $fee_value, 'float');
                $params[] = array(':winner_id', $Winner['id'], 'int');
                $params[] = array(':auc_id', $Auction['id'], 'int');
                $db->query($query, $params);
            } elseif ($system->SETTINGS['fee_type'] == 2) {
                $bf_paid = 0;
                $query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = :winner_id";
                $params = array();
                $params[] = array(':winner_id', $Winner['id'], 'int');
                $db->query($query, $params);
                $buyer_emails[] = array(
                    'name' => $Winner['name'],
                    'email' => $Winner['email'],
                    'uid' => $Winner['id'],
                    'id' => $Auction['id'],
                    'title' => htmlspecialchars($Auction['title'])
                );
            }
        }
    }

    $fee_value = 0;
    for ($i = 0; $i < count($endauc_fee); $i++) {
        if ($Auction['current_bid'] >= $endauc_fee[$i]['fee_from'] && $Auction['current_bid'] <= $endauc_fee[$i]['fee_to']) {
            if ($endauc_fee[$i]['fee_type'] == 'flat') {
                $fee_value = $endauc_fee[$i]['value'];
            } else {
                $fee_value = ($endauc_fee[$i]['value'] / 100) * $Auction['current_bid'];
            }
        }
    }

    if ($fee_value > 0) {
        // is the seller fee exempt
        $query = "SELECT COUNT(no_fees) As no_fees FROM " . $DBPrefix . "groups WHERE id IN (" . $Seller['groups'] . ") AND no_fees = 1";
        $db->direct_query($query);
        $seller_no_fees = $db->result('no_fees');

        if (!$seller_no_fees) {
            // insert final value fees
            if ($system->SETTINGS['fee_type'] == 1) {
                // add balance & invoice
                $query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee_value WHERE id = :seller_id";
                $params = array();
                $params[] = array(':fee_value', $fee_value, 'float');
                $params[] = array(':seller_id', $Seller['id'], 'int');
                $db->query($query, $params);
                $query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, finalval, total, paid)
                        VALUES (:seller_id, :auc_id, :fee_value, :fee_value, 1)";
                $params = array();
                $params[] = array(':fee_value', $fee_value, 'float');
                $params[] = array(':seller_id', $Seller['id'], 'int');
                $params[] = array(':auc_id', $Auction['id'], 'int');
                $db->query($query, $params);
            } elseif ($system->SETTINGS['fee_type'] == 2) {
                $ff_paid = 0;
                $query = "UPDATE " . $DBPrefix . "users SET suspended = 5 WHERE id = :seller_id";
                $params = array();
                $params[] = array(':seller_id', $Seller['id'], 'int');
                $db->query($query, $params);
                $seller_emails[] = array(
                    'name' => $Seller['name'],
                    'email' => $Seller['email'],
                    'uid' => $Seller['id'],
                    'id' => $Auction['id'],
                    'title' => htmlspecialchars($Auction['title'])
                );
            }
        }
    }
}
