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

// Delete users and banners if necessary
if (isset($_POST['delete']) && is_array($_POST['delete'])) {
    foreach ($_POST['delete'] as $k => $v) {
        $params = array();
        $params[] = array(':user_id', $v, 'int');
        $query = "DELETE FROM " . $DBPrefix . "banners WHERE user = :user_id";
        $db->query($query, $params);
        $query = "DELETE FROM " . $DBPrefix . "bannersusers WHERE id = :user_id";
        $db->query($query, $params);
    }
}

// Retrieve users from the database
$query = "SELECT u.*, COUNT(b.user) as count FROM " . $DBPrefix . "bannersusers u
          LEFT JOIN " . $DBPrefix . "banners b ON (b.user = u.id)
          GROUP BY u.id ORDER BY u.name";
$db->direct_query($query);

while ($row = $db->fetch()) {
    $template->assign_block_vars('busers', array(
            'ID' => $row['id'],
            'NAME' => $row['name'],
            'COMPANY' => $row['company'],
            'EMAIL' => $row['email'],
            'NUM_BANNERS' => $row['count']
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'managebanners.tpl'
        ));
$template->display('body');
include 'footer.php';
