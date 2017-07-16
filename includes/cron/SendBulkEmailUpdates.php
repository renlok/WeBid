<?php

namespace includes\cron;

class SendBulkEmailUpdates extends CronBase
{
    protected $frequency = 'weekly';

    public function handle() {
        global $MSG;
        $query = "SELECT id, name, email FROM " . $this->db->DBPrefix . "users WHERE endemailmode = 'cum'";
        $this->db->direct_query($query);

        $pending_to_delete = [];
        $user_data = $this->db->fetchall();
        foreach ($user_data as $row) {
            $query = "SELECT * FROM " . $this->db->DBPrefix . "pendingnotif WHERE seller_id = :seller_id";
            $params = array();
            $params[] = array(':seller_id', $row['id'], 'int');
            $this->db->query($query, $params);

            if ($this->db->numrows() > 0) {
                $pending_data = $this->db->fetchall();
                $report_winner = 0;
                $report = "<table cellspacing='0' cellpadding='10' border='1'>";
                $report .= "<tr><th colspan='2'><h4><br>" . $MSG['BUY_NOW_ONLY_TPL_0100'] . "</h4></th></tr>";
                $report .= "<tr><th>" . $MSG['168'] . "</th><th>" . $MSG['453'] . "</th></tr>";
                foreach ($pending_data as $pending) {
                    $pending_to_delete[] = $pending['id'];
                    $Auction = unserialize($pending['auction']);
                    $Seller = unserialize($pending['seller']);
                    $report .= "<tr><td width='250'>" . $Auction['title'] . "<br>(ID: " . $Auction['id'] . ")</td>";
                    if (strlen($pending['winners']) > 0) {
                        $report .= "<td width='250'>" . $pending['winners'] . "</td></tr>";
                        $report_winner = 1;
                    } else {
                        $report .= "<td width='280'>" . $MSG['1032'] . "</td></tr>";
                    }
                }
                $report .= "</table>";
                include INCLUDE_PATH . 'email/endauction_cumulative.php';
            }
        }
        if (count($pending_to_delete) > 0) {
            $query = "DELETE FROM " . $this->db->DBPrefix . "pendingnotif WHERE id IN (" . implode(',', $pending_to_delete) . ")";
            $this->db->direct_query($query);
        }
    }
}
