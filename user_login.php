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

define('AtLogin', 1);
include 'common.php';

if (isset($_SESSION['LOGIN_MESSAGE'])) {
    $ERR = $_SESSION['LOGIN_MESSAGE'];
    unset($_SESSION['LOGIN_MESSAGE']);
}

if (isset($_POST['action']) && isset($_POST['username']) && isset($_POST['password'])) {
    include PACKAGE_PATH . 'PasswordHash.php';
    $phpass = new PasswordHash(8, false);
    $query = "SELECT id, hash, suspended, password, password_type FROM " . $DBPrefix . "users WHERE nick = :nick OR email = :email";
    $params = array();
    $params[] = array(':nick', $system->cleanvars($_POST['username']), 'str');
    $params[] = array(':email', $system->cleanvars($_POST['username']), 'str');
    $db->query($query, $params);
    $user_data = $db->result();

    if ($user_data['password_type'] == 0 && $user_data['password'] == md5($MD5_PREFIX . $_POST['password'])) {
        $query = "UPDATE " . $DBPrefix . "users SET password = :password, password_type = 1 WHERE id = :user_id";
        $params = array();
        $params[] = array(':password', $phpass->HashPassword($_POST['password']), 'int');
        $params[] = array(':user_id', $user_data['id'], 'int');
        $db->query($query, $params);

        $query = "SELECT id, hash, suspended, password, password_type FROM " . $DBPrefix . "users WHERE nick = :nick OR email = :email";
        $params = array();
        $params[] = array(':nick', $system->cleanvars($_POST['username']), 'str');
        $params[] = array(':email', $system->cleanvars($_POST['username']), 'str');
        $db->query($query, $params);
        $user_data = $db->result();
    }

    if ($phpass->CheckPassword($_POST['password'], $user_data['password'])) {
        // generate a random unguessable token
        $_SESSION['csrftoken'] = md5(uniqid(rand(), true));

        if ($user_data['suspended'] == 9) {
            $_SESSION['signup_id'] = $user_data['id'];
            header('location: pay.php?a=3');
            exit;
        }

        if ($user_data['suspended'] == 1) {
            $ERR = $ERR_618;
        } elseif ($user_data['suspended'] == 8) {
            $ERR = $ERR_620;
        } elseif ($user_data['suspended'] == 10) {
            $ERR = $ERR_621;
        } else {
            $_SESSION['WEBID_LOGGED_IN']        = $user_data['id'];
            $_SESSION['WEBID_LOGGED_NUMBER']    = strspn($user_data['password'], $user_data['hash']);
            $_SESSION['WEBID_LOGGED_PASS']        = $user_data['password'];
            // Update "last login" fields in users table
            $query = "UPDATE " . $DBPrefix . "users SET lastlogin = CURRENT_TIMESTAMP WHERE id = :user_id";
            $params = array();
            $params[] = array(':user_id', $user_data['id'], 'int');
            $db->query($query, $params);
            // Remember me option
            if (isset($_POST['rememberme'])) {
                $remember_key = md5(time());
                $query = "INSERT INTO " . $DBPrefix . "rememberme VALUES (:user_id, :remember_key)";
                $params = array();
                $params[] = array(':remember_key', $remember_key, 'str');
                $params[] = array(':user_id', $user_data['id'], 'int');
                $db->query($query, $params);
                setcookie('WEBID_RM_ID', $remember_key, time() + (3600 * 24 * 365));
            }
            $query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = :user_id AND ip = :user_ip";
            $params = array();
            $params[] = array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str');
            $params[] = array(':user_id', $user_data['id'], 'int');
            $db->query($query, $params);
            if ($db->numrows() == 0) {
                $query = "INSERT INTO " . $DBPrefix . "usersips (user, ip, type, action)
						VALUES (:user_id, :user_ip, 'login', 'accept')";
                $params = array();
                $params[] = array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str');
                $params[] = array(':user_id', $user_data['id'], 'int');
                $db->query($query, $params);
            }

            // delete your old session
            if (isset($_COOKIE['WEBID_ONLINE'])) {
                $query = "DELETE from " . $DBPrefix . "online WHERE SESSION = :SESSION";
                $params = array();
                $params[] = array(':SESSION', alphanumeric($_COOKIE['WEBID_ONLINE']), 'str');
                $db->query($query, $params);
            }

            if (in_array($user_data['suspended'], array(5, 6, 7))) {
                header('location: message.php');
                exit;
            }

            if (isset($_SESSION['REDIRECT_AFTER_LOGIN'])) {
                $URL = str_replace('\r', '', str_replace('\n', '', $_SESSION['REDIRECT_AFTER_LOGIN']));
                unset($_SESSION['REDIRECT_AFTER_LOGIN']);
            } else {
                $URL = 'user_menu.php';
            }

            header('location: ' . $URL);
            exit;
        }
    } else {
        $ERR = $ERR_038;
    }
}

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'USER' => (isset($_POST['username'])) ? $_POST['username'] : ''
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'user_login.tpl'
        ));
$template->display('body');
include 'footer.php';
