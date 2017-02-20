<?php

namespace includes\cron;


class PurgeOldData extends CronBase
{
    protected $frequency = 'daily';

    public function handle() {
        global $system;
        if ($system->SETTINGS['prune_unactivated_users'] == 1) {
            // prune unactivated user accounts
            $this->printLog("++++++ Prune unactivated user accounts");

            $query = "SELECT COUNT(id) as COUNT FROM " . $this->db->DBPrefix . "users WHERE reg_date <= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL " . $system->SETTINGS['prune_unactivated_users_days'] . " DAY) AND suspended = 8";
            $this->db->direct_query($query);

            $pruneCount = $this->db->result('COUNT');
            $this->printLog($pruneCount . " accounts to prune");
            if ($pruneCount > 0) {
                $query = "DELETE FROM " . $this->db->DBPrefix . "users WHERE reg_date <= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL " . $system->SETTINGS['prune_unactivated_users_days'] . " DAY) AND suspended = 8";
                $this->db->direct_query($query);

                $query = "UPDATE " . $this->db->DBPrefix . "counters SET inactiveusers = inactiveusers - " . $pruneCount;
                $this->db->direct_query($query);
            }
        }

        // "remove" old auctions (archive them)
        if ($system->SETTINGS['archiveafter'] > 0)
        {
            $this->printLog("++++++ Archiving old auctions");

            $query = "SELECT id FROM " . $this->db->DBPrefix . "auctions WHERE ends <= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL " . $system->SETTINGS['archiveafter'] . " DAY)";
            $this->db->direct_query($query);

            $num = $this->db->numrows();
            $this->printLog($num . " auctions to archive");
            if ($num > 0) {
                $auction_data = $this->db->fetchall();
                foreach ($auction_data as $AuctionInfo) {
                    $this->printLog("Processing auction: " . $AuctionInfo['id'], 1);

                    // delete auction
                    $query = "DELETE FROM " . $this->db->DBPrefix . "auctions WHERE id = :auc_id";
                    $params = array();
                    $params[] = array(':auc_id', $AuctionInfo['id'], 'int');
                    $this->db->query($query, $params);

                    // delete bids for this auction
                    $query = "DELETE FROM " . $this->db->DBPrefix . "bids WHERE auction = :auc_id";
                    $params = array();
                    $params[] = array(':auc_id', $AuctionInfo['id'], 'int');
                    $this->db->query($query, $params);

                    // Delete proxybid entries
                    $query = "DELETE FROM " . $this->db->DBPrefix . "proxybid WHERE itemid = :auc_id";
                    $params = array();
                    $params[] = array(':auc_id', $AuctionInfo['id'], 'int');
                    $this->db->query($query, $params);

                    // Delete counter entries
                    $query = "DELETE FROM " . $this->db->DBPrefix . "auccounter WHERE auction_id = :auc_id";
                    $params = array();
                    $params[] = array(':auc_id', $AuctionInfo['id'], 'int');
                    $this->db->query($query, $params);

                    // Delete all images
                    if (is_dir(UPLOAD_PATH . $AuctionInfo['id'])) {
                        if ($dir = opendir(UPLOAD_PATH . $AuctionInfo['id'])) {
                            while ($file = readdir($dir)) {
                                if ($file != '.' && $file != '..') {
                                    @unlink(UPLOAD_PATH . $AuctionInfo['id'] . '/' . $file);
                                }
                            }
                            closedir($dir);
                            rmdir(UPLOAD_PATH . $AuctionInfo['id']);
                        }
                    }
                }
            }
        }
    }

}
