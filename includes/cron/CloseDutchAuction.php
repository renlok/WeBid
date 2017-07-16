<?php

namespace includes\cron;


class Example extends CronBase
{
    protected $frequency = 'hourly';

    public function handle() {
        $query = closedAuctionSQL() . " AND a.auction_type = 2";
        $db->direct_query($query);
        foreach ($auction_data as $Auction) {
            // find out winners sorted by bid
            $query = "SELECT *, MAX(bid) AS maxbid
                      FROM " . $this->db->DBPrefix . "bids WHERE auction = :auc_id GROUP BY bidder
                      ORDER BY maxbid DESC, quantity DESC, id DESC";
            $params = array();
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $db->query($query, $params);

            $WINNERS_ID = array();
            $winner_array = array();
            $items_count = $Auction['quantity'];
            $items_sold = 0;
            $bidder_data = $db->fetchall(); // load every bid
            foreach ($bidder_data as $row) {
                if (!in_array($row['bidder'], $WINNERS_ID)) {
                    $winner_present = true;
                    $items_wanted = $row['quantity'];
                    $items_got = 0;
                    if ($items_wanted <= $items_count) {
                        $items_got = $items_wanted;
                    } else {
                        $items_got = $items_count;
                    }
                    $items_count -= $items_got;
                    $items_sold += $items_got;

                    // Retrieve winner nick from the database
                    $query = "SELECT id, nick, email, name, address, city, zip, prov, country
                              FROM " . $this->db->DBPrefix . "users WHERE id = :bidder LIMIT 1";
                    $params = array();
                    $params[] = array(':bidder', $row['bidder'], 'int');
                    $db->query($query, $params);
                    $Winner = $db->result();
                    // set arrays
                    $WINNERS_ID[] = $row['bidder'];
                    $Winner['maxbid'] = $row['maxbid'];
                    $Winner['quantity'] = $items_got;
                    $Winner['wanted'] = $items_wanted;
                    $winner_array[] = $Winner; // set array ready for emails
                    $report_text .= ' ' . $MSG['159'] . ' ' . $Winner['nick'];
                    if ($system->SETTINGS['users_email'] == 'n') {
                        $report_text .= ' (' . $Winner['email'] . ')';
                    }
                    $report_text .= ' ' . $items_got . ' ' . $MSG['5492'] . ', ' . $MSG['5493'] . ' ' . $system->print_money($row['bid']) . ' ' . $MSG['5495'] . ' - (' . $MSG['5494'] . ' ' . $items_wanted . ' ' . $MSG['5492'] . ')' . "\n";
                    $report_text .= ' ' . $MSG['30_0086'] . $ADDRESS . "\n";

                    $bf_paid = 1;
                    $ff_paid = 1;
                    // work out & add fee
                    if ($system->SETTINGS['fees'] == 'y') {
                        sortFees();
                    }

                    // Add winner's data to "winners" table
                    $query = "INSERT INTO " . $this->db->DBPrefix . "winners
                              (auction, seller, winner, bid, feedback_win, feedback_sel, qty, paid, bf_paid, ff_paid, shipped, auc_title, auc_shipping_cost, auc_payment) VALUES
                              (:auc_id, :seller_id, :winner_id, :current_bid, 0, 0, :items_got, 0, :bf_paid, :ff_paid, 0, :auc_title, :auc_shipping_cost, :auc_payment)";
                    $params = array();
                    $params[] = array(':auc_id', $Auction['id'], 'int');
                    $params[] = array(':seller_id', $Seller['id'], 'int');
                    $params[] = array(':winner_id', $row['bidder'], 'int');
                    $params[] = array(':items_got', $items_got, 'int');
                    $params[] = array(':current_bid', $row['maxbid'], 'float');
                    $params[] = array(':bf_paid', $bf_paid, 'int');
                    $params[] = array(':ff_paid', $ff_paid, 'int');
                    $params[] = array(':auc_title', $Auction['title'], 'str');
                    $params[] = array(':auc_shipping_cost', calculate_shipping_data($Auction), 'float');
                    $params[] = array(':auc_payment', $Auction['payment'], 'str');
                    $db->query($query, $params);
                }
                if ($items_count == 0) {
                    break;
                }
            }
        }
    }

}
