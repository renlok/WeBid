<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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

if (isset($_GET['id']) && isset($_GET['hash']) && !isset($_POST['action']))
{
	$query = "SELECT suspended, hash FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_GET['id'], 'int');
	$db->query($query, $params);
	$user_data = $db->result();

	if ($db->numrows() == 0)
	{
		$errmsg = $ERR_025;
	}
	elseif (!isset($_GET['hash']) || md5($MD5_PREFIX . $user_data['hash']) != $_GET['hash'])
	{
		$errmsg = $ERR_033;
	}
	elseif ($user_data['suspended'] == 0)
	{
		$errmsg = $ERR_039;
	}
	elseif ($user_data['suspended'] == 2)
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

if (isset($_POST['action']) && $_POST['action'] == "Confirm")
{
	$query = "SELECT hash FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_POST['id'], 'int');
	$db->query($query, $params);
	$user_data = $db->result();

	if (md5($MD5_PREFIX . $user_data['hash']) == $_POST['hash'])
	{
		// User wants to confirm his/her registration
		$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = :user_id AND suspended = 8";
		$params = array();
		$params[] = array(':user_id', $_POST['id'], 'int');
		$db->query($query, $params);

		$query = "UPDATE " . $DBPrefix . "counters SET users = users + 1, inactiveusers = inactiveusers - 1";
		$db->direct_query($query);

		// login user
		$query = "SELECT id, hash, password FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array();
		$params[] = array(':user_id', $_POST['id'], 'int');
		$db->query($query, $params);
		if ($db->numrows() > 0)
		{
			$login_data = $db->result();
			$password = $login_data['password'];
			$_SESSION['WEBID_LOGGED_IN'] 		= $login_data['id'];
			$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($password, $login_data['hash']);
			$_SESSION['WEBID_LOGGED_PASS'] 		= $password;

			// Update "last login" fields in users table
			$query = "UPDATE " . $DBPrefix . "users SET lastlogin = :lastlogin WHERE id = :user_id";
			$params = array();
			$params[] = array(':lastlogin', date("Y-m-d H:i:s"), 'str');
			$params[] = array(':user_id', $_SESSION['WEBID_LOGGED_IN'], 'int');
			$db->query($query, $params);

			$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = :user_id AND ip = :ip";
			$params = array();
			$params[] = array(':user_id', $_SESSION['WEBID_LOGGED_IN'], 'int');
			$params[] = array(':ip', $_SERVER['REMOTE_ADDR'], 'str');
			$db->query($query, $params);
			if ($db->numrows() == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
						(NULL, :user_id, :ip, 'after', 'accept')";
				$params = array();
				$params[] = array(':user_id', $_SESSION['WEBID_LOGGED_IN'], 'int');
				$params[] = array(':ip', $_SERVER['REMOTE_ADDR'], 'str');
				$db->query($query, $params);
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

if (isset($_POST['action']) && $_POST['action'] == "Refuse")
{
	$query = "SELECT hash FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_POST['id'], 'int');
	$db->query($query, $params);
	if (md5($MD5_PREFIX . $db->result('hash')) == $_POST['hash'])
	{
		// User doesn't want to confirm the registration
		$query = "DELETE FROM " . $DBPrefix . "users WHERE id = :user_id AND suspended = 8";
		$params = array();
		$params[] = array(':user_id', $_POST['id'], 'int');
		$db->query($query, $params);

		$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers - 1";
		$db->direct_query($query);
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
