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

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

function ToBeDeleted($index)
{
    global $delete;

    if (in_array($index, $delete)) {
        return true;
    }
    return false;
}

if (isset($_POST['action']) && $_POST['action'] = 'update') {
    $ids = $_POST['id'];
    $increments = $_POST['increments'];
    $lows = $_POST['lows'];
    $highs = $_POST['highs'];
    $delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
    $errors = false;

    for ($i = 0; $i < count($increments); $i++) {
        if (!empty($lows[$i]) && !empty($highs[$i]) && !empty($increments[$i]) && !ToBeDeleted($ids[$i])) {
            if (!$system->CheckMoney($lows[$i]) || !$system->CheckMoney($highs[$i]) || !$system->CheckMoney($increments[$i])) {
                $errors = true;
                $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_030));
            }
            if ($lows[$i] > $highs[$i]) {
                $errors = true;
                $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_from_must_be_less_than_to']));
            }
        }
    }

    if (!$errors) {
        for ($i = 0; $i < count($increments); $i++) {
            if (!ToBeDeleted($ids[$i])) {
                if (!(intval($lows[$i]) == 0 && intval($highs[$i]) == 0 && intval($increments[$i]) == 0)) {
                    if (!isset($ids[$i]) || empty($ids[$i])) {
                        $query = "INSERT INTO " . $DBPrefix . "increments VALUES
                                  (NULL, :low, :high, :inc)";
                        $params = array();
                        $params[] = array(':low', $system->input_money($lows[$i]), 'float');
                        $params[] = array(':high', $system->input_money($highs[$i]), 'float');
                        $params[] = array(':inc', $system->input_money($increments[$i]), 'float');
                        $db->query($query, $params);
                    } else {
                        $query = "UPDATE " . $DBPrefix . "increments SET
                                  low = :low,
                                  high = :high,
                                  increment = :inc
                                  WHERE id = :inc_id";
                        $params = array();
                        $params[] = array(':low', $system->input_money($lows[$i]), 'float');
                        $params[] = array(':high', $system->input_money($highs[$i]), 'float');
                        $params[] = array(':inc', $system->input_money($increments[$i]), 'float');
                        $params[] = array(':inc_id', $ids[$i], 'int');
                        $db->query($query, $params);
                    }
                }
            } else {
                $query = "DELETE FROM " . $DBPrefix . "increments WHERE id = :inc_id";
                $params = array();
                $params[] = array(':inc_id', $ids[$i], 'int');
                $db->query($query, $params);
            }
        }
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['increments_updated']));
    }
}

$query = "SELECT * FROM " . $DBPrefix . "increments ORDER BY low";
$db->direct_query($query);

while ($row = $db->fetch()) {
    $template->assign_block_vars('increments', array(
            'ID' => $row['id'],
            'HIGH' => $system->print_money_nosymbol($row['high']),
            'LOW' => $system->print_money_nosymbol($row['low']),
            'INCREMENT' => $system->print_money_nosymbol($row['increment'])
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'increments.tpl'
        ));
$template->display('body');
include 'footer.php';
