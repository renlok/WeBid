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
$current_page = 'banners';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

// Data check
if (!isset($_REQUEST['id'])) {
    header('location: managebanners.php');
    exit;
}

$id = $_REQUEST['id'];

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
        $USER = $_POST;
    } elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_008));
        $USER = $_POST;
    } else {
        // Update database
        $query = "UPDATE " . $DBPrefix . "bannersusers SET
                  name = :name,
                  company = :company,
                  email = :email
                  WHERE id = :id";
        $params = array();
        $params[] = array(':name', $_POST['name'], 'str');
        $params[] = array(':company', $_POST['company'], 'str');
        $params[] = array(':email', $_POST['email'], 'str');
        $params[] = array(':id', $id, 'int');
        $db->query($query, $params);
        header('location: managebanners.php');
        exit;
    }
} else {
    $query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = :id";
    $params = array();
    $params[] = array(':id', $id, 'int');
    $db->query($query, $params);
    if ($db->numrows() > 0) {
        $USER = $db->result();
    }
}

$template->assign_vars(array(
        'ID' => $id,
        'NAME' => (isset($USER['name'])) ? $USER['name'] : '',
        'COMPANY' => (isset($USER['company'])) ? $USER['company'] : '',
        'EMAIL' => (isset($USER['email'])) ? $USER['email'] : ''
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'editbanneruser.tpl'
        ));
$template->display('body');
include 'footer.php';
