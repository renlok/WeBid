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

include 'includes/common.inc.php';

if ($system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
{
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
	header('Location: ' . $sslurl . 'user_login.php');
	exit;
}

$NOW = time();

if (isset($_POST['action']) && isset($_POST['username']) && isset($_POST['password']))
{
	$password = md5($MD5_PREFIX . $_POST['password']);
	$query = "SELECT id, hash FROM " . $DBPrefix . "users WHERE
			nick = '" . $system->cleanvars($_POST['username']) . "'
			AND password = '" . $password . "' AND suspended = 0";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$_SESSION['WEBID_LOGGED_IN'] 		= mysql_result($res, 0, 'id');
		$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($password, mysql_result($res, 0, 'hash'));
		$_SESSION['WEBID_LOGGED_PASS'] 		= $password;
		// Update "last login" fields in users table
		$query = "UPDATE " . $DBPrefix . "users SET lastlogin = '" . gmdate("Y-m-d H:i:s") . "' WHERE id = " . $_SESSION['WEBID_LOGGED_IN'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		// Remember me option
		if ($_POST['rememberme'] == 1)
		{
			$remember_key = md5(time());
			$query = "INSERT INTO " . $DBPrefix . "rememberme VALUES (" . mysql_result($res, 0, 'id') . ", '" . addslashes($remember_key) . "')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			setcookie('WEBID_RM_ID', $remember_key, time() + (3600 * 24 * 365));
		}
		$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = " . $_SESSION['WEBID_LOGGED_IN'] . " AND ip = '" . $_SERVER['REMOTE_ADDR'] . "'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
					(NULL, '" . $_SESSION['WEBID_LOGGED_IN'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', 'after','accept')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		// delete your old session
		if (isset($_COOKIE['WEBID_ONLINE']))
		{
			$query = "DELETE from " . $DBPrefix . "online WHERE SESSION = '" . $_COOKIE['WEBID_ONLINE'] . "'";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	else
	{
		$_SESSION['loginerror'] = $ERR_038;
	}
}
else
{
	$_SESSION['loginerror'] = $ERR_038;
}

header('location: index.php');
exit;
?>
