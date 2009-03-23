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
include $include_path . "countries.inc.php";

if (isset($_POST['action']) && $_POST['action'] == "ok") {
    if (isset($_POST['TPL_username'])) {
        $username = $system->cleanvars($_POST['TPL_username']);
        $query = "SELECT email, id, name FROM " . $DBPrefix . "users WHERE nick = '" . $username . "' OR email = '" . $username . "' LIMIT 1";
        $res = mysql_query($query);
        $system->check_mysql($res, $query, __LINE__, __FILE__);
		
        if (mysql_num_rows($res) > 0) {
            // Generate a new random password and mail it to the user
            $email = mysql_result($res, 0, 'email');
            $id = mysql_result($res, 0, 'id');
			$name = mysql_result($res, 0, 'name');
            $newpass = substr(uniqid(md5(time())), 0, 6);
            // send message
			$emailer = new email_class();
			$emailer->assign_vars(array(
					'REALNAME' => $name,
					'NEWPASS' => $newpass,
					'SITENAME' => $system->SETTINGS['sitename']
					));
			$emailer->email_uid = $id;
			$emailer->email_sender($email, 'mail_newpasswd.inc.php', $MSG['024']);
            // Update database
            $query = "UPDATE " . $DBPrefix . "users SET password = '" . md5($MD5_PREFIX . $newpass) . "' WHERE id = " . $id;
            $system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
        } else {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_100;
        }
    } else {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_112;
    }
}

$template->assign_vars(array(
		'L_ERROR' => (isset($errmsg)) ? '<p class="errfont">' . $TPL_errmsg . '</p>' : '',
		'L_MSG' => $MGS_2__0039,
		'L_UNAME' => $MGS_2__0040,
		
		'USERNAME' => (isset($username)) ? $username : '',
		
		'B_FIRST' => (!isset($_POST['action']) || (isset($_POST['action']) && isset($TPL_errmsg)))
		));

include "header.php";
$template->set_filenames(array(
        'body' => 'forgotpasswd.html'
        ));
$template->display('body');
include "footer.php";

?>