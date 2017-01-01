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

include 'common.php';

function generatePassword($length = 8)
{
    // all possible characters to put in password
    $chars = 'abcdfghjklmnpqrstvwxyzABCDFGHJKLMNPQRSTVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

if (isset($_POST['action']) && $_POST['action'] == 'ok') {
    if (isset($_POST['TPL_username']) && isset($_POST['TPL_email'])) {
        $query = "SELECT email, id, name FROM " . $DBPrefix . "users WHERE nick = :username AND email = :email LIMIT 1";
        $params = array();
        $params[] = array(':username', $system->cleanvars($_POST['TPL_username']), 'str');
        $params[] = array(':email', $system->cleanvars($_POST['TPL_email']), 'str');
        $db->query($query, $params);

        if ($db->numrows() > 0) {
            // Generate a new random password and mail it to the user
            $user_data = $db->result();
            $email = $user_data['email'];
            $id = $user_data['id'];
            $name = $user_data['name'];
            $newpass = generatePassword();
            // send message
            $emailer = new email_handler();
            $emailer->assign_vars(array(
                    'REALNAME' => $name,
                    'NEWPASS' => $newpass,
                    'SITENAME' => $system->SETTINGS['sitename']
                    ));
            $emailer->email_uid = $id;
            $emailer->email_sender($email, 'newpasswd.inc.php', $MSG['024']);
            // Update database
            $query = "UPDATE " . $DBPrefix . "users SET password = :password WHERE id = :user_id";
            // hash password
            include PACKAGE_PATH . 'PasswordHash.php';
            $phpass = new PasswordHash(8, false);
            $params = array();
            $params[] = array(':password', $phpass->HashPassword($newpass), 'str');
            $params[] = array(':user_id', $id, 'int');
            $db->query($query, $params);
        } else {
            $ERR = $ERR_076;
        }
    } else {
        $ERR = $ERR_112;
    }
}

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'USERNAME' => (isset($username)) ? $username : '',
        'EMAIL' => (isset($email)) ? $email : '',
        'B_FIRST' => (!isset($_POST['action']) || (isset($_POST['action']) && isset($ERR)))
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'forgotpasswd.tpl'
        ));
$template->display('body');
include 'footer.php';
