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

// Data check
if (!isset($_REQUEST['id'])) {
    header('location: adminusers.php');
    exit;
}

$id = intval($_REQUEST['id']);
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if ((!empty($_POST['password']) && empty($_POST['repeatpassword'])) || (empty($_POST['password']) && !empty($_POST['repeatpassword']))) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_054));
    } elseif ($_POST['password'] != $_POST['repeatpassword']) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_006));
    } else {
        // Update
        $query = "UPDATE " . $DBPrefix . "adminusers SET";
        $params = array();
        if (!empty($_POST['password'])) {
            include PACKAGE_PATH . 'PasswordHash.php';
            $phpass = new PasswordHash(8, false);
            $query .= " password = :password, ";
            $params[] = array(':password', $phpass->HashPassword($_POST['password']), 'str');
        }
        $query .= " status = :status WHERE id = :admin_id";
        $params[] = array(':status', $_POST['status'], 'bool');
        $params[] = array(':admin_id', $id, 'int');
        $db->query($query, $params);
        header('location: adminusers.php');
        exit;
    }
}

$query = "SELECT * FROM " . $DBPrefix . "adminusers WHERE id = :admin_id";
$params = array();
$params[] = array(':admin_id', $id, 'int');
$db->query($query, $params);
$user_data = $db->result();

// Data check
if (!$user_data) {
    header('location: adminusers.php');
    exit;
}

if ($user_data['lastlogin'] == $user_data['created']) {
    $LASTLOGIN = $MSG['570'];
} else {
    $LASTLOGIN = $dt->printDateTz($user_data['lastlogin']);
}

$template->assign_vars(array(
        'ID' => $id,
        'USERNAME' => $user_data['username'],
        'CREATED' => $dt->printDateTz($user_data['created']),
        'LASTLOGIN' => $LASTLOGIN,

        'B_ACTIVE' => ($user_data['status'] == 1),
        'B_INACTIVE' => ($user_data['status'] == 0)
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'editadminuser.tpl'
        ));
$template->display('body');

include 'footer.php';
