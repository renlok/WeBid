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
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $admin_ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_POST['ip']) && !empty($_POST['ip'])) {
        if ($_POST['ip'] != $admin_ip) {
            $query = "INSERT INTO " . $DBPrefix . "usersips (user, ip, type, action)
					VALUES ('NOUSER',  :user_ip, 'ban',  'deny')";
            $params = array();
            $params[] = array(':user_ip', $system->cleanvars($_POST['ip']), 'str');
            $db->query($query, $params);
            $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['ip_banned']));
        } else {
            $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_cannot_ban_self']));
        }
    }
    if (isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $k => $v) {
            $query = "DELETE FROM " . $DBPrefix . "usersips WHERE id = :ip_id";
            $params = array();
            $params[] = array(':ip_id', $v, 'int');
            $db->query($query, $params);
        }
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => sprintf($MSG['ip_bans_removed'], count($_POST['delete']))));
    }
    if (isset($_POST['accept']) && is_array($_POST['accept'])) {
        foreach ($_POST['accept'] as $k => $v) {
            $query = "UPDATE " . $DBPrefix . "usersips SET action = 'accept' WHERE id = :ip_id";
            $params = array();
            $params[] = array(':ip_id', $v, 'int');
            $db->query($query, $params);
        }
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => sprintf($MSG['ip_bans_removed'], count($_POST['accept']))));
    }
    if (isset($_POST['deny']) && is_array($_POST['deny'])) {
        foreach ($_POST['deny'] as $k => $v) {
            if ($_POST['ip'] != $admin_ip) {
                $query = "UPDATE " . $DBPrefix . "usersips SET action = 'deny' WHERE id = :ip_id";
                $params = array();
                $params[] = array(':ip_id', $v, 'int');
                $db->query($query, $params);
            } else {
                $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_cannot_ban_self']));
            }
        }
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => sprintf($MSG['ip_bans_added'], count($_POST['deny']))));
    }
}

$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE user = 'NOUSER'";
$db->direct_query($query);

while ($row = $db->fetch()) {
    $template->assign_block_vars('ips', array(
            'ID' => $row['id'],
            'IP' => $row['ip'],
            'ACTION' => $row['action']
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'banips.tpl'
        ));
$template->display('body');
include 'footer.php';
