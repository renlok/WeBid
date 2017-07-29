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

if (!isset($_SERVER['SCRIPT_NAME'])) {
    $_SERVER['SCRIPT_NAME'] = 'cron.php';
}

include INCLUDE_PATH . 'functions_cron.php';

// initialize cron script
printLog('=============== STARTING CRON SCRIPT: ' . date('F d, Y H:i:s'));

$categories = constructCategories();

/**
 * ------------------------------------------------------------
 * 1) "close" expired auctions
 * closing auction means:
 * a) update database:
 * + "auctions" table
 * + "categories" table - for counters
 * + "counters" table
 * b) send email to winner (if any) - passing seller's data
 * c) send email to seller (reporting if there was a winner)
 */
printLog('++++++ Closing expired auctions');
$buyer_emails = array();
$seller_emails = array();

// get buyer fee
$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = 'buyer_fee'";
$db->direct_query($query);
$row = $db->result();
$buyer_fee = (isset($row['value'])) ? $row['value'] : 0;
$buyer_fee_type = (isset($row['fee_type'])) ? $row['fee_type'] : 'flat';

// get closed auction fee
$query = "SELECT * FROM " . $DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
$db->direct_query($query);
$endauc_fee = array();
while ($row = $db->fetch()) {
    $endauc_fee[] = $row;
}

// get a list of all ended auctions
$query = "SELECT a.*, u.email, u.endemailmode, u.nick, u.payment_details, u.name, u.groups
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (a.user = u.id)
		WHERE a.ends <= CURRENT_TIMESTAMP
		AND ((a.closed = 0)
		OR (a.closed = 1
		AND a.reserve_price > 0
		AND a.num_bids > 0
		AND a.current_bid < a.reserve_price
		AND a.sold = 's'))";
$db->direct_query($query);

$count_auctions = $num = $db->numrows();
printLog($num . ' auctions to close');

$n = 1;
$auction_data = $db->fetchall();
foreach ($auction_data as $Auction) { // loop auctions
    $n++;
    $report_text = '';
    printLog("\n" . 'Processing auction: ' . $Auction['id']);
    $Auction['description'] = strip_tags($Auction['description']);

    // Send notification to all users watching this auction
    sendWatchEmails($Auction['id'], $Auction['title']);

    // set seller array
    $Seller = array(
        'id' => $Auction['user'],
        'email' => $Auction['email'],
        'endemailmode' => $Auction['endemailmode'],
        'nick' => $Auction['nick'],
        'payment_details' => $Auction['payment_details'],
        'name' => $Auction['name'],
        'groups' => $Auction['groups']
    );

    // get an order list of bids of the item (high to low)
    $winner_present = false;
    $query = "SELECT u.* FROM " . $DBPrefix . "bids b
			LEFT JOIN " . $DBPrefix . "users u ON (b.bidder = u.id)
			WHERE auction = :auc_id ORDER BY b.bid DESC, b.quantity DESC, b.id DESC";
    $params = array();
    $params[] = array(':auc_id', $Auction['id'], 'int');
    $db->query($query, $params);
    $num_bids = $db->numrows();

    // send email to seller - to notify him
    // create a "report" to seller depending of what kind auction is
    // Standard auction
    if ($Auction['auction_type'] == 1) {
        if ($num_bids > 0 && ($Auction['current_bid'] >= $Auction['reserve_price'] || $Auction['sold'] == 's')) {
            $Winner = $db->result();
            $Winner['quantity'] = $Auction['quantity'];
            $WINNING_BID = $Auction['current_bid'];
            $winner_present = true;
        }

        if ($winner_present && $Auction['bn_only'] == 0) {
            $report_text = $Winner['nick'] . "\n";
            if ($system->SETTINGS['users_email'] == 'n') {
                $report_text .= ' (<a href="mailto:' . $Winner['email'] . '">' . $Winner['email'] . '</a>)' . "\n";
            }
            if ($Winner['address'] != '') {
                $report_text .= $MSG['30_0086'] . $Winner['address'] . ' ' . $Winner['city'] . ' ' . $Winner['prov'] . ' ' . $Winner['zip'] . ', ' . $Winner['country'];
            }
            $bf_paid = 1; // buyer fee payed?
            $ff_paid = 1; // auction end fee payed?
            // work out & add fee
            if ($system->SETTINGS['fees'] == 'y') {
                sortFees();
            }

            // Add winner's data to "winners" table
            $query = "INSERT INTO " . $DBPrefix . "winners
				(auction, seller, winner, bid, feedback_win, feedback_sel, qty, paid, bf_paid, ff_paid, shipped, auc_title, auc_shipping_cost, auc_payment) VALUES
				(:auc_id, :seller_id, :winner_id, :current_bid, 0, 0, 1, 0, :bf_paid, :ff_paid, 0, :auc_title, :auc_shipping_cost, :auc_payment)";
            $params = array();
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $params[] = array(':seller_id', $Seller['id'], 'int');
            $params[] = array(':winner_id', $Winner['id'], 'int');
            $params[] = array(':current_bid', $Auction['current_bid'], 'float');
            $params[] = array(':bf_paid', $bf_paid, 'int');
            $params[] = array(':ff_paid', $ff_paid, 'int');
            $params[] = array(':auc_title', $Auction['title'], 'str');
            $params[] = array(':auc_shipping_cost', calculate_shipping_data($Auction), 'float');
            $params[] = array(':auc_payment', $Auction['payment'], 'str');
            $db->query($query, $params);
        } elseif ($winner_present && $Auction['bn_only']) {
            $query = "SELECT b.bidder, b.quantity, u.nick, u.email, u.name, u.address, u.city, u.zip, u.prov, u.country
					FROM " . $DBPrefix . "bids b
					LEFT JOIN " . $DBPrefix . "users u ON (u.id = b.bidder)
					WHERE b.auction = :auc_id
					ORDER BY b.bid DESC, b.bidwhen ASC, b.id DESC";
            $params = array();
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $db->query($query, $params);

            $WINNERS_ID = array();
            $winner_array = array();
            $bid_data = $db->fetchall();
            foreach ($bid_data as $row) {
                $Winner = array(
                    'id' => $row['bidder'],
                    'nick' => $row['nick'],
                    'email' => $row['email'],
                    'name' => $row['name'],
                    'address' => $row['address'],
                    'city' => $row['city'],
                    'zip' => $row['zip'],
                    'prov' => $row['prov'],
                    'country' => $row['country']);
                // set arrays
                $WINNERS_ID[] = $row['bidder'];
                $Winner['maxbid'] = $Auction['buy_now'];
                $items_got = $row['quantity'];
                $winner_array[] = $Winner; // set array ready for emails
                $report_text .= ' ' . $MSG['131'] . ' ' . $Winner['nick'];
                if ($system->SETTINGS['users_email'] != 'n') {
                    $report_text .= ' (' . $Winner['email'] . ')';
                }
                $report_text .= ' ' . $MSG['5492'] . ' ' . $items_got . "<br>\n";
                $report_text .= ' ' . $MSG['30_0086'] . $Winner['address'] .' ' . $Winner['city'] . ' '.$Winner['country'] ."<br><br>\n\n";
            }
        } else {
            $report_text = $MSG['429'];
        }
    }
    printLogL('mail to seller: ' . $Seller['email'], 1);

    $ends_string = $dt->printDateTz($Auction['ends']);

    $close_auction = true;

    if ($Auction['suspended'] != 0) {
        $count_auctions--;
    }

    if ($close_auction) {
        // Close auction
        if ($Auction['sold'] != 's' and $Auction['num_bids'] > 0 and $Auction['reserve_price'] > 0 and $Auction['current_bid'] < $Auction['reserve_price']) {
            $query = "UPDATE " . $DBPrefix . "auctions SET closed = 1, sold = 'n' WHERE id = :auc_id";
        } else {
            $query = "UPDATE " . $DBPrefix . "auctions SET closed = 1, sold = 'y' WHERE id = :auc_id";
        }
        $params = array();
        $params[] = array(':auc_id', $Auction['id'], 'int');
        $db->query($query, $params);
    }

    if ($winner_present) {
        if ($Auction['bn_only'] == 0 && $Auction['auction_type'] != 2) {
            // Send mail to the seller
            $added_winner_names = array();
            if (is_array($Winner)) {
                // Send mail to the buyer
                $added_winner_names[] = $Winner['nick'] . ' (<a href="mailto:' . $Winner['email'] . '">' . $Winner['email'] . '</a>)';
                include INCLUDE_PATH . 'email/endauction_youwin_nodutch.php';
            }
            if ($Seller['endemailmode'] != 'cum') {
                include INCLUDE_PATH . 'email/endauction_winner.php';
            } else {
                // Add in the database to send later as cumulitave email to seller
                $added_winner_names_cs = implode(",<br>", $added_winner_names);
                $query = "INSERT INTO " . $DBPrefix . "pendingnotif (auction_id, seller_id, winners, auction, seller)
                          VALUES (:auc_id, :seller_id, :winner_names, :auc_data, :seller_data)";
                $params = array();
                $params[] = array(':auc_id', $Auction['id'], 'int');
                $params[] = array(':seller_id', $Seller['id'], 'int');
                $params[] = array(':winner_names', $added_winner_names_cs, 'str');
                $params[] = array(':auc_data', serialize($Auction), 'str');
                $params[] = array(':seller_data', serialize($Seller), 'str');
                $db->query($query, $params);
            }
        }
        // elseif bn_only == y
        else {
            // emails for buyers already sent in buy_now.php
            // email to seller for partial items already sent in buy_now.php
            // prepare to send auction closed to seller
            // retreive buyers
            if (isset($winner_array) && is_array($winner_array) && count($winner_array) > 0) {
                $added_winner_names = array();
                foreach ($winner_array as $key => $value) {
                    if ($Auction['auction_type'] == 2) {
                        // Send mail to the buyer
                        $Winner = $value;
                        include INCLUDE_PATH . 'email/endauction_youwin.php';
                    }
                    $added_winner_names[] = $value['nick'] . ' (<a href="mailto:' . $value['email'] . '">' . $value['email'] . '</a>)';
                }
                $added_winner_names_cs = implode(",<br>", $added_winner_names);

                // Send mail to the seller
                if ($Seller['endemailmode'] != 'cum') {
                    $report_text = $added_winner_names_cs;
                    include INCLUDE_PATH . 'email/seller_end_buynowonly.php';
                } else {
                    // Add in the database to send later as cumulitave email to seller
                    $query = "INSERT INTO " . $DBPrefix . "pendingnotif (auction_id, seller_id, winners, auction, seller)
							VALUES (:auc_id, :seller_id, :winner_names, :auc_data, :seller_data)";
                    $params = array();
                    $params[] = array(':auc_id', $Auction['id'], 'int');
                    $params[] = array(':seller_id', $Seller['id'], 'int');
                    $params[] = array(':winner_names', $added_winner_names_cs, 'str');
                    $params[] = array(':auc_data', serialize($Auction), 'str');
                    $params[] = array(':seller_data', serialize($Seller), 'str');
                    $db->query($query, $params);
                }
            }
        }
    } else {
        // Send mail to the seller if no winner
        if ($Seller['endemailmode'] != 'cum') {
            include INCLUDE_PATH . 'email/endauction_nowinner.php';
        } else {
            // Save in the database to send later
            $query = "INSERT INTO " . $DBPrefix . "pendingnotif (auction_id, seller_id, winners, auction, seller)
					VALUES (:auc_id, :seller_id, '', :auction_data, :seller_data)";
            $params = array();
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $params[] = array(':seller_id', $Seller['id'], 'int');
            $params[] = array(':auction_data', serialize($Auction), 'str');
            $params[] = array(':seller_data', serialize($Seller), 'str');
            $db->query($query, $params);
        }
    }
    // Update bid counter
    $query = "UPDATE " . $DBPrefix . "counters SET bids = (bids - :num_bids)";
    $params = array();
    $params[] = array(':num_bids', $num_bids, 'int');
    $db->query($query, $params);
}

$query = "UPDATE " . $DBPrefix . "counters SET auctions = (auctions - :num_aucsa), closedauctions = (closedauctions + :num_aucsb)";
$params = array();
$params[] = array(':num_aucsa', $count_auctions, 'int');
$params[] = array(':num_aucsb', $count_auctions, 'int');
$db->query($query, $params);

// TODO needs rewriting
/*

*/
if (count($categories) > 0) {
    foreach ($categories as $cat_id => $category) {
        if ($category['updated']) {
            $query = "UPDATE " . $DBPrefix . "categories SET
						counter = :counter,
						sub_counter = :sub_counter
						WHERE cat_id = :cat_id";
            $params = array();
            $params[] = array(':counter', $category['counter'], 'int');
            $params[] = array(':sub_counter', $category['sub_counter'], 'int');
            $params[] = array(':cat_id', $cat_id, 'int');
            $db->query($query, $params);
        }
    }
}

// send buyer fee emails
if ($buyer_fee > 0) {
    for ($i = 0; $i < count($buyer_emails); $i++) {
        $emailer = new email_handler();
        $emailer->assign_vars(array(
                'ID' => $buyer_emails[$i]['id'],
                'TITLE' => htmlspecialchars($buyer_emails[$i]['title']),
                'NAME' => $buyer_emails[$i]['name'],
                'LINK' => $system->SETTINGS['siteurl'] . 'pay.php?a=6&auction_id=' . $Auction['id']
                ));
        $emailer->email_uid = $buyer_emails[$i]['uid'];
        $emailer->email_sender($buyer_emails[$i]['email'], 'buyer_fee.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['522']);
    }
}
for ($i = 0; $i < count($seller_emails); $i++) {
    $emailer = new email_handler();
    $emailer->assign_vars(array(
            'ID' => $seller_emails[$i]['id'],
            'TITLE' => htmlspecialchars($seller_emails[$i]['title']),
            'NAME' => $seller_emails[$i]['name'],
            'LINK' => $system->SETTINGS['siteurl'] . 'pay.php?a=7&auction_id=' . $Auction['id']
            ));
    $emailer->email_uid = $seller_emails[$i]['uid'];
    $emailer->email_sender($seller_emails[$i]['email'], 'final_value_fee.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['523']);
}

// finish cron script
printLog("=========================== ENDING CRON: " . date('F d, Y H:i:s') . "\n");
