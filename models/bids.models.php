<?php

class Bids
{

    public static function ignoreBids(int $auc_id)
    {
        global $db, $DBPrefix;
        $query = "SELECT id FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
        $params = array();
        $params[] = array(':auc_id', $auc_id, 'int');
        $db->query($query, $params);
        if ($db->numrows() > 0) {
            return true;
        } else {
            return false;
        }
    }


}
