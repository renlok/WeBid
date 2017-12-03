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

if (!isset($_REQUEST['id'])) {
    header('location: listusers.php');
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == "Yes") {
    $query = "SELECT name, email, suspended FROM " . $DBPrefix . "users WHERE id = :user_id";
    $params = array();
    $params[] = array(':user_id', $_POST['id'], 'int');
    $db->query($query, $params);
    $USER = $db->result();

    if ($_POST['mode'] == 'activate') {
        $query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = :user_id";
        $params = array();
        $params[] = array(':user_id', $_POST['id'], 'int');
        $db->query($query, $params);
        $query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers - 1, users = users + 1";
        $db->direct_query($query);

        $was_suspended = ($USER['suspended'] == 1 ? true : false);

        if (!$was_suspended) {
            include INCLUDE_PATH . 'email/user_approved.php';
        } else {
            include INCLUDE_PATH . 'email/user_reactivated.php';
        }
    } else {
        $query = "UPDATE " . $DBPrefix . "users SET suspended = 1 WHERE id = :user_id";
        $params = array();
        $params[] = array(':user_id', $_POST['id'], 'int');
        $db->query($query, $params);
        $query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers + 1, users = users - 1";
        $db->direct_query($query);

        include INCLUDE_PATH . 'email/user_suspended.php';
    }

    header('location: listusers.php');
    exit;
} elseif (isset($_POST['action']) && $_POST['action'] == "No") {
    header('location: listusers.php');
    exit;
}

// load the page
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $_GET['id'], 'int');
$db->query($query, $params);
$user_data = $db->result();

// create tidy DOB string
if ($user_data['birthdate'] == 0) {
    $birthdate = '';
} else {
    $birth_day = substr($user_data['birthdate'], 6, 2);
    $birth_month = substr($user_data['birthdate'], 4, 2);
    $birth_year = substr($user_data['birthdate'], 0, 4);

    if ($system->SETTINGS['datesformat'] == 'USA') {
        $birthdate = $birth_month . '/' . $birth_day . '/' . $birth_year;
    } else {
        $birthdate = $birth_day . '/' . $birth_month . '/' . $birth_year;
    }
}

$mode = 'activate';
switch ($user_data['suspended']) {
    case 0:
        $action = $MSG['suspend_user'];
        $question = $MSG['suspend_user_confirm'];
        $mode = 'suspend';
        break;
    case 10:
    case 8:
        $action = $MSG['activate_user'];
        $question = $MSG['activate_user_confirm'];
        break;
    default:
        $action = $MSG['reactivate_user'];
        $question = $MSG['reactivate_user_confirm'];
        break;
}

$template->assign_vars(array(
        'ACTION' => $action,
        'REALNAME' => $user_data['name'],
        'USERNAME' => $user_data['nick'],
        'EMAIL' => $user_data['email'],
        'ADDRESS' => $user_data['address'],
        'PROV' => $user_data['prov'],
        'ZIP' => $user_data['zip'],
        'COUNTRY' => $user_data['country'],
        'PHONE' => $user_data['phone'],
        'DOB' => $birthdate,
        'QUESTION' => $question,
        'MODE' => $mode,
        'ID' => $_GET['id']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'excludeuser.tpl'
        ));
$template->display('body');
include 'footer.php';
