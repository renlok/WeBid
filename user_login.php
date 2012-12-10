<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
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

$NOW = time();

if ($system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
{
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
	$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;
	header('location: ' . $sslurl . 'user_login.php');
	exit;
}

if (isset($_POST['action']) && isset($_POST['username']) && isset($_POST['password']))
{
	$password = md5($MD5_PREFIX . $_POST['password']);
	$query = "SELECT id, hash, suspended FROM " . $DBPrefix . "users WHERE
			nick = '" . $system->cleanvars($_POST['username']) . "'
			AND password = '" . $password . "'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		// generate a random unguessable token
		$_SESSION['csrftoken'] = md5(uniqid(rand(), true));
		$user_data = mysql_fetch_assoc($res);
		if ($user_data['suspended'] == 9)
		{
			$_SESSION['signup_id'] = $user_data['id'];
			header('location: pay.php?a=3');
			exit;
		}

		if ($user_data['suspended'] == 1)
		{
			$ERR = $ERR_618;
		}
		elseif ($user_data['suspended'] == 8)
		{
			$ERR = $ERR_620;
		}
		elseif ($user_data['suspended'] == 10)
		{
			$ERR = $ERR_621;
		}
		else
		{
			$_SESSION['WEBID_LOGGED_IN'] 		= $user_data['id'];
			$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($password, $user_data['hash']);
			$_SESSION['WEBID_LOGGED_PASS'] 		= $password;
			// Update "last login" fields in users table
			$query = "UPDATE " . $DBPrefix . "users SET lastlogin = '" . gmdate("Y-m-d H:i:s") . "' WHERE id = " . $user_data['id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Remember me option
			if (isset($_POST['rememberme']))
			{
				$remember_key = md5(time());
				$query = "INSERT INTO " . $DBPrefix . "rememberme VALUES (" . $user_data['id'] . ", '" . $remember_key . "')";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				setcookie('WEBID_RM_ID', $remember_key, time() + (3600 * 24 * 365));
			}
			$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = " . $user_data['id'] . " AND ip = '" . $_SERVER['REMOTE_ADDR'] . "'";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
						(NULL, '" . $user_data['id'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', 'after','accept')";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}

			// delete your old session
			if (isset($_COOKIE['WEBID_ONLINE']))
			{
				$query = "DELETE from " . $DBPrefix . "online WHERE SESSION = '" . strip_non_an_chars($_COOKIE['WEBID_ONLINE']) . "'";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}

			if (in_array($user_data['suspended'], array(5, 6, 7)))
			{
				header('location: message.php');
				exit;
			}

			if (isset($_SESSION['REDIRECT_AFTER_LOGIN']))
			{
				$URL = str_replace('\r', '', str_replace('\n', '', $_SESSION['REDIRECT_AFTER_LOGIN']));
				unset($_SESSION['REDIRECT_AFTER_LOGIN']);
			}
			else
			{
				$URL = 'user_menu.php';
			}

			header('location: ' . $URL);
			exit;
		}
	}
	else
	{
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
?>
