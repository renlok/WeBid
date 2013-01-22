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

define('InAdmin', 1);
include '../common.php';
include $include_path . 'functions_admin.php';

if (isset($_POST['action']))
{
	switch ($_POST['action'])
	{
		case 'insert':
			// Additional security check
			$query = "SELECT id FROM " . $DBPrefix . "adminusers";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				header('location: login.php');
				exit;
			}
			$md5_pass = md5($MD5_PREFIX . $_POST['password']);
			$query = "INSERT INTO " . $DBPrefix . "adminusers (username, password, hash, created, lastlogin, status) VALUES
					('" . $system->cleanvars($_POST['username']) . "', '" . $md5_pass . "', '" . get_hash() . "', '" . gmdate('Ymd') . "', '" . time() . "', 1)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Redirect
			header('location: login.php');
			exit;
		break;

		case 'login':
			if (strlen($_POST['username']) == 0 || strlen($_POST['password']) == 0)
			{
				$ERR = $ERR_047;
			}
			elseif (!preg_match('([a-zA-Z0-9]*)', $_POST['username']))
			{
				$ERR = $ERR_071;
			}
			else
			{
				$password = md5($MD5_PREFIX . $_POST['password']);
				$query = "SELECT id, hash FROM " . $DBPrefix . "adminusers WHERE username = '" . $system->cleanvars($_POST['username']) . "' and password = '" . $password . "'";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);

				if (mysql_num_rows($res) == 0)
				{
					$ERR = $ERR_048;
				}
				else
				{
					// generate a random unguessable token
					$_SESSION['csrftoken'] = md5(uniqid(rand(), true));
					$admin = mysql_fetch_array($res);
					// Set sessions vars
					$_SESSION['WEBID_ADMIN_NUMBER'] = strspn($password, $admin['hash']);
					$_SESSION['WEBID_ADMIN_PASS'] = $password;
					$_SESSION['WEBID_ADMIN_IN'] = $admin['id'];
					$_SESSION['WEBID_ADMIN_USER'] = $_POST['username'];
					$_SESSION['WEBID_ADMIN_TIME'] = time();
					// Update last login information for this user
					$query = "UPDATE " . $DBPrefix . "adminusers SET lastlogin = '" . time() . "' WHERE id = " . $admin['id'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					// Redirect
					print '<script type="text/javascript">parent.location.href = \'index.php\';</script>';
					exit;
				}
			}
		break;
	}
}

$query = "SELECT id FROM " . $DBPrefix . "adminusers LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'THEME' => $system->SETTINGS['theme'],
		'PAGE' => (mysql_num_rows($res) == 0) ? 1 : 2
		));

$template->set_filenames(array(
		'body' => 'login.tpl'
		));
$template->display('body'); 
?>