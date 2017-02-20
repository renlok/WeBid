<?php

namespace includes\cron;


class ResyncCounters extends CronBase
{
    protected $frequency = 'hourly';

    public function handle() {
        //update users counter
        $query = "SELECT COUNT(id) As COUNT FROM " . $this->db->DBPrefix . "users WHERE suspended = 0";
        $this->db->direct_query($query);
        $USERS = $this->db->result('COUNT');
        $query = "UPDATE " . $this->db->DBPrefix . "counters SET users = :USERS";
        $params = array();
        $params[] = array(':USERS', $USERS, 'int');
        $this->db->query($query, $params);

        //update suspended users counter
        $query = "SELECT COUNT(id) As COUNT FROM " . $this->db->DBPrefix . "users WHERE suspended != 0";
        $this->db->direct_query($query);
        $USERS = $this->db->result('COUNT');
        $query = "UPDATE " . $this->db->DBPrefix . "counters SET inactiveusers = :USERS";
        $params = array();
        $params[] = array(':USERS', $USERS, 'int');
        $this->db->query($query, $params);

        //update auction counter
        $query = "SELECT COUNT(id) As COUNT FROM " . $this->db->DBPrefix . "auctions WHERE closed = 0 AND suspended = 0";
        $this->db->direct_query($query);
        $AUCTIONS = $this->db->result('COUNT');
        $query = "UPDATE " . $this->db->DBPrefix . "counters SET auctions = :AUCTIONS";
        $params = array();
        $params[] = array(':AUCTIONS', $AUCTIONS, 'int');
        $this->db->query($query, $params);

        //update closed auction counter
        $query = "SELECT COUNT(id) As COUNT FROM " . $this->db->DBPrefix . "auctions WHERE closed = 1";
        $this->db->direct_query($query);
        $AUCTIONS = $this->db->result('COUNT');
        $query = "UPDATE " . $this->db->DBPrefix . "counters SET closedauctions = :AUCTIONS";
        $params = array();
        $params[] = array(':AUCTIONS', $AUCTIONS, 'int');
        $this->db->query($query, $params);

        //update suspended auctions counter
        $query = "SELECT COUNT(id) As COUNT FROM " . $this->db->DBPrefix . "auctions WHERE closed = 0 and suspended != 0";
        $this->db->direct_query($query);
        $AUCTIONS = $this->db->result('COUNT');
        $query = "UPDATE " . $this->db->DBPrefix . "counters SET suspendedauctions = :AUCTIONS";
        $params = array();
        $params[] = array(':AUCTIONS', $AUCTIONS, 'int');
        $this->db->query($query, $params);

        //update bids
        $query = "SELECT COUNT(b.id) As COUNT FROM " . $this->db->DBPrefix . "bids b
                  LEFT JOIN " . $this->db->DBPrefix . "auctions a ON (b.auction = a.id)
                  WHERE a.closed = 0 AND a.suspended = 0";
        $this->db->direct_query($query);
        $BIDS = $this->db->result('COUNT');
        $query = "UPDATE " . $this->db->DBPrefix . "counters SET bids = :BIDS";
        $params = array();
        $params[] = array(':BIDS', $BIDS, 'int');
        $this->db->query($query, $params);

        // update categories
        $catscontrol = new MPTTcategories();
        $query = "UPDATE " . $this->db->DBPrefix . "categories set counter = 0, sub_counter = 0";
        $this->db->direct_query($query);

        $query = "SELECT COUNT(*) AS COUNT, category FROM " . $this->db->DBPrefix . "auctions
                  WHERE closed = 0 AND starts <= CURRENT_TIMESTAMP AND suspended = 0 GROUP BY category";
        $this->db->direct_query($query);

        $cat_data = $this->db->fetchall();
        foreach ($cat_data as $row) {
            $row['COUNT'] = $row['COUNT'] * 1; // force it to be a number
            if ($row['COUNT'] > 0 && !empty($row['category'])) { // avoid some errors
                $query = "SELECT left_id, right_id, level FROM " . $this->db->DBPrefix . "categories WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $row['category'], 'int');
                $this->db->query($query, $params);
                $parent_node = $this->db->result();

                $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
                for ($i = 0; $i < count($crumbs); $i++) {
                    $query = "UPDATE " . $this->db->DBPrefix . "categories SET sub_counter = sub_counter + :COUNT WHERE cat_id = :cat_id";
                    $params = array();
                    $params[] = array(':COUNT', $row['COUNT'], 'int');
                    $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
                    $this->db->query($query, $params);
                }
                $query = "UPDATE " . $this->db->DBPrefix . "categories SET counter = counter + :COUNT WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':COUNT', $row['COUNT'], 'int');
                $params[] = array(':cat_id', $row['category'], 'int');
                $this->db->query($query, $params);
            }
        }

        if ($system->SETTINGS['extra_cat'] == 'y') {
            $query = "SELECT COUNT(*) AS COUNT, secondcat FROM " . $this->db->DBPrefix . "auctions
                      WHERE closed = 0 AND starts <= CURRENT_TIMESTAMP AND suspended = 0 AND secondcat != 0 GROUP BY secondcat";
            $this->db->direct_query($query);

            $cat_data = $this->db->fetchall();
            foreach ($cat_data as $row) {
                $query = "SELECT left_id, right_id, level FROM " . $this->db->DBPrefix . "categories WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $row['secondcat'], 'int');
                $this->db->query($query, $params);
                $parent_node = $this->db->result();

                $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
                for ($i = 0; $i < count($crumbs); $i++) {
                    $query = "UPDATE " . $this->db->DBPrefix . "categories SET sub_counter = sub_counter + :COUNT WHERE cat_id = :cat_id";
                    $params = array();
                    $params[] = array(':COUNT', $row['COUNT'], 'int');
                    $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
                    $this->db->query($query, $params);
                }
                $query = "UPDATE " . $this->db->DBPrefix . "categories SET counter = counter + :COUNT WHERE cat_id = :cat_id";
                $params = array();
                $params[] = array(':COUNT', $row['COUNT'], 'int');
                $params[] = array(':cat_id', $row['secondcat'], 'int');
                $this->db->query($query, $params);
            }
        }
    }

}
