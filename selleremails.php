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

require('includes/config.inc.php');

if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("Location: user_login.php");
    exit;
}
// // Create new list
if (isset($_POST['action']) && $_POST['action'] == "update") {
    $query = "UPDATE " . $DBPrefix . "users SET endemailmode = '" . $system->cleanvars($_POST['endemailmod']) . "',
			  startemailmode = '" . $system->cleanvars($_POST['startemailmod']) . "', reg_date = reg_date
			  WHERE id = " . intval($_SESSION['WEBID_LOGGED_IN']);
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);
    $ERR = $MSG['25_0192'];
}

$query = "SELECT startemailmode, endemailmode FROM " . $DBPrefix . "users WHERE id = " . intval($_SESSION['WEBID_LOGGED_IN']);
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$EMAILMODE = mysql_fetch_array($result);

$template->assign_vars(array(
        'B_AUCSETUPY' => ($EMAILMODE['startemailmode'] == 'yes') ? ' checked="checked"' : '',
        'B_AUCSETUPN' => ($EMAILMODE['startemailmode'] == 'no') ? ' checked="checked"' : '',
        'B_CLOSEONE' => ($EMAILMODE['endemailmode'] == 'one') ? ' checked="checked"' : '',
        'B_CLOSEBULK' => ($EMAILMODE['endemailmode'] == 'cum') ? ' checked="checked"' : '',
        'B_CLOSENONE' => ($EMAILMODE['endemailmode'] == 'none') ? ' checked="checked"' : ''
        ));

require("header.php");
$TMP_usmenutitle = $MSG['25_0188'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'sellermails.html'
        ));
$template->display('body');
include "footer.php";

?>