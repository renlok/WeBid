<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include "includes/config.inc.php";

if (isset($_GET['id']) && !isset($_POST['action'])) {
    $query = "SELECT suspended, nick FROM " . $DBPrefix . "users WHERE id = " . intval($_GET['id']);
    $result = mysql_query($query);
    $system->check_mysql($result, $query, __LINE__, __FILE__);
    if (mysql_num_rows($result) == 0) {
        $errmsg = $ERR_025;
    } elseif (!isset($_GET['hash']) || md5(mysql_result($result, 0, 'nick')) != $_GET['hash']) {
        $errmsg = $ERR_033;
    } elseif (mysql_result($result, 0, 'suspended') == 0) {
        $errmsg = $ERR_039;
    } elseif (mysql_result($result, 0, 'suspended') == 2) {
        $errmsg = $ERR_039;
    }

    if (isset($errmsg)) {
        $page = 'error';
    } else {
        $page = 'confirm';
    }
}

if (!isset($_GET['id']) && !isset($_POST['action'])) {
    $errmsg = $ERR_025;
    $page = 'error';
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['249']) {
    // -- User wants to confirm his/her registration
    $query = "UPDATE " . $DBPrefix . "users SET suspended = 0, reg_date = reg_date WHERE id = " . intval($_POST['id']) . " and suspended = 8";
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);

    $counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET users = users + 1, inactiveusers = inactiveusers - 1");
    $page = 'confirmed';
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['250']) {
    // -- User doesn't want to confirm hid/her registration
    $query = "DELETE FROM " . $DBPrefix . "users WHERE id=" . intval($_POST['id']);
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);
    $counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers - 1");
    $page = 'refused';
}

$template->assign_vars(array(
        'ERROR' => (isset($errmsg)) ? $errmsg : '',
        'USERID' => (isset($_GET['id'])) ? $_GET['id'] : '',
        'PAGE' => $page
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'confirm_account.html'
        ));
$template->display('body');
include "footer.php";
?>