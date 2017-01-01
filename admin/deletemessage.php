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

if (!isset($_REQUEST['board_id']) || !isset($_REQUEST['id'])) {
    $URL = $_SESSION['RETURN_LIST'];
    //unset($_SESSION['RETURN_LIST']);
    header('location: ' . $URL);
    exit;
}

$msg_id = intval($_REQUEST['id']);
$board_id = intval($_REQUEST['board_id']);

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == "Yes") {
    $query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE id = :msg_id";
    $params = array();
    $params[] = array(':msg_id', $msg_id, 'int');
    $db->query($query, $params);
    // Update messages counter
    $query = "UPDATE " . $DBPrefix . "community SET messages = messages - 1 WHERE id = :board_id";
    $params = array();
    $params[] = array(':board_id', $board_id, 'int');
    $db->query($query, $params);
    header('location: editmessages.php?id=' . $board_id);
    exit;
} elseif (isset($_POST['action']) && $_POST['action'] == "No") {
    header('location: editmessages.php?id=' . $board_id);
    exit;
}

$template->assign_vars(array(
        'ID' => $msg_id,
        'MESSAGE' => sprintf($MSG['confirm_msg_delete'], $msg_id),
        'TYPE' => 1
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'confirm.tpl'
        ));
$template->display('body');
include 'footer.php';
