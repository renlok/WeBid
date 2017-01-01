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
$current_page = 'contents';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

// Data check
if (!isset($_REQUEST['id']) || !isset($_REQUEST['msg'])) {
    header('location: boards.php');
    exit;
}

$msg = intval($_REQUEST['msg']);
$board_id = intval($_REQUEST['id']);

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if (!isset($_POST['message']) || empty($_POST['message'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
    } else {
        $query = "UPDATE " . $DBPrefix . "comm_messages SET message = :message WHERE id = :id";
        $params = array();
        $params[] = array(':message', $system->cleanvars($_POST['message']), 'str');
        $params[] = array(':id', $_POST['msg'], 'int');
        $db->query($query, $params);
        header("Location: editmessages.php?id=" . $_POST['id']);
        exit;
    }
}

// Retrieve board name for breadcrumbs
$query = "SELECT name FROM " . $DBPrefix . "community WHERE id = :board_id";
$params = array();
$params[] = array(':board_id', $board_id, 'int');
$db->query($query, $params);
$board_name = $db->result('name');

// Retrieve message from the database
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE id = :id";
$params = array();
$params[] = array(':id', $msg, 'int');
$db->query($query, $params);
$data = $db->result();

$template->assign_vars(array(
        'BOARD_NAME' => $board_name,
        'MESSAGE' => nl2br((isset($_POST['message'])) ? $_POST['message'] : $data['message']),
        'USER' => ($data['user'] > 0) ? $data['username'] : $MSG['5061'],
        'POSTED' => $dt->formatDate($data['msgdate']),
        'BOARD_ID' => $board_id,
        'MSG_ID' => $msg
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'editmessage.tpl'
        ));
$template->display('body');
include 'footer.php';
