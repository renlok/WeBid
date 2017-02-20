<?php

namespace includes\cron;


class AutoRelistAuctions extends CronBase
{
    protected $frequency = 'hourly';

    public function handle() {
        $query = "SELECT duration, id FROM " . $this->db->DBPrefix . "auctions
                  WHERE ends <= CURRENT_TIMESTAMP
                  AND suspended = 0
                  AND relist > 0
                  AND (relist - relisted) > 0
                  AND (num_bids = 0 OR (current_bid <= reserve_price))";
        $this->db->direct_query($query);
        foreach ($auction_data as $Auction) {
            // Calculate end time
            $start_date = new DateTime('now', $this->dt->UTCtimezone);
            $start_date->add(new DateInterval('P' . $Auction['duration'] . 'D'));
            $auction_ends = $start_date->format('Y-m-d H:i:s');

            $query = "UPDATE " . $this->db->DBPrefix . "auctions SET starts = CURRENT_TIMESTAMP, ends = :ends,
                      current_bid = 0, num_bids = 0, relisted = relisted + 1 WHERE id = :auc_id";
            $params = array();
            $params[] = array(':ends', $auction_ends, 'str');
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $this->db->query($query, $params);

            // delete old bids
            $query = "DELETE FROM " . $this->db->DBPrefix . "bids WHERE auction = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $this->db->query($query, $params);
            $query = "DELETE FROM " . $this->db->DBPrefix . "proxybid WHERE itemid = :auc_id";
            $params = array();
            $params[] = array(':auc_id', $Auction['id'], 'int');
            $this->db->query($query, $params);
        }
    }

}
