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

if (isset($_GET['id']) && !isset($_POST['action']))
{
	$query = "SELECT suspended, nick FROM " . $DBPrefix . "users WHERE id = " . intval($_GET['id']);
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	if (mysql_num_rows($result) == 0)
	{
		$errmsg = $ERR_025;
	}
	elseif (!isset($_GET['hash']) || md5($MD5_PREFIX . $system->uncleanvars(mysql_result($result, 0, 'nick'))) != $_GET['hash'])
	{
		$errmsg = $ERR_033;
	}
	elseif (mysql_result($result, 0, 'suspended') == 0)
	{
		$errmsg = $ERR_039;
	}
	elseif (mysql_result($result, 0, 'suspended') == 2)
	{
		$errmsg = $ERR_039;
	}

	if (isset($errmsg))
	{
		$page = 'error';
	}
	else
	{
		$page = 'confirm';
	}
}

if (!isset($_GET['id']) && !isset($_POST['action']))
{
	$errmsg = $ERR_025;
	$page = 'error';
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['249'])
{
	$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = " . intval($_POST['id']);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (md5($MD5_PREFIX . mysql_result($res, 0, 'nick')) == $_POST['hash'])
	{
		// User wants to confirm his/her registration
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = " . intval($_POST['id']) . " AND suspended = 8";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		$query = "UPDATE " . $DBPrefix . "counters SET users = users + 1, inactiveusers = inactiveusers - 1";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

		// login user
		$query = "SELECT id, hash, password FROM " . $DBPrefix . "users WHERE id = " . intval($_POST['id']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) > 0)
		{
			$password = mysql_result($res, 0, 'password');
			$_SESSION['WEBID_LOGGED_IN'] 		= mysql_result($res, 0, 'id');
			$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($password, mysql_result($res, 0, 'hash'));
			$_SESSION['WEBID_LOGGED_PASS'] 		= $password;
			// Update "last login" fields in users table
			$query = "UPDATE " . $DBPrefix . "users SET lastlogin = '" . gmdate("Y-m-d H:i:s") . "' WHERE id = " . $_SESSION['WEBID_LOGGED_IN'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = " . $_SESSION['WEBID_LOGGED_IN'] . " AND ip = '" . $_SERVER['REMOTE_ADDR'] . "'";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
						(NULL, '" . $_SESSION['WEBID_LOGGED_IN'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', 'after', 'accept')";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}
		}

		$page = 'confirmed';
	}
	else
	{
		$errmsg = $ERR_033;
		$page = 'error';
	}
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['250'])
{
	$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = " . intval($_POST['id']);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (md5($MD5_PREFIX . mysql_result($res, 0, 'nick')) == $_POST['hash'])
	{
		// User doesn't want to confirm hid/her registration
		$query = "DELETE FROM " . $DBPrefix . "users WHERE id = " . intval($_POST['id']) . " AND suspended = 8";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers - 1";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$page = 'refused';
	}
	else
	{
		$errmsg = $ERR_033;
		$page = 'error';
	}
}

$template->assign_vars(array(
		'ERROR' => (isset($errmsg)) ? $errmsg : '',
		'USERID' => (isset($_GET['id'])) ? $_GET['id'] : '',
		'HASH' => (isset($_GET['hash'])) ? $_GET['hash'] : '',
		'PAGE' => $page
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
include 'footer.php';
?>
