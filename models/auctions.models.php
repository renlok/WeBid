<?php

class Auctions
{

    public static function homeAuctions(int $by, int $now, int $limit)
    {
        global $db, $DBPrefix;
        
        if ($by == 1) {
            $set = 'BY RAND() DESC';
        } elseif($by == 2) {
            $set = 'BY starts DESC';
        } else {
            $set = 'BY ends';
        }

        $query = 'SELECT * FROM `'.$DBPrefix.'auctions` 
            WHERE `closed` = 0
            AND `suspended` = 0
            AND `starts` <= :time
            AND `featured` = 1
            ORDER '.$set.' LIMIT :limit';
        $params = array();
        $params[] = array(':time', $now, 'int');
        $params[] = array(':limit', $limit, 'int');
        $db->query($query, $params);
        $array = $db->fetch();
         if ($array) {
            return $array;
         } else {
            return false;
         }
    }

    public static function hotItem(int $now, int $limit)
    {
        global $db, $DBPrefix;
        $query = 'SELECT a.*, c.*
            FROM `'.$DBPrefix.'auctions` a
            LEFT JOIN `'.$DBPrefix.'auccounter` c ON (a.id = c.auction_id)
            WHERE `closed` = 0
            AND `suspended` = 0
            AND `starts` <= :time
            ORDER BY c.counter DESC LIMIT :limit';
        $params = array();
        $params[] = array(':time', $now, 'int');
        $params[] = array(':limit', $limit, 'int');
        $db->query($query, $params);
        $array = $db->fetch();
        if ($array) {
            return $array;
        } else {
            return false;
        }
    }

    public static function forUserId(int $auc_id, int $user_id)
    {
        global $db, $DBPrefix;
        $query = 'SELECT * FROM `'.$DBPrefix.'auctions`
            WHERE `id` = :auc_id
            AND `user` = :user_id';
        $params = array();
        $params[] = array(':auc_id', $auc_id, 'int');
        $params[] = array(':user_id', $user_id, 'int');
        $db->query($query, $params);
        return $db->result();
    }
}
