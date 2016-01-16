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
			$db->direct_query($query);
			if ($db->numrows() > 0)
			{
				header('location: login.php');
				exit;
			}
			if ($_POST['password'] != $_POST['repeat_password'])
			{
				$ERR = $ERR_006;
			}
			else
			{
				include $include_path . 'PasswordHash.php';
				$phpass = new PasswordHash(8, false);
				$query = "INSERT INTO " . $DBPrefix . "adminusers (username, password, hash, created, lastlogin, status) VALUES
						(:username, :password, :hash, :created, :lastlogin, 1)";
				$params = array();
				$params[] = array(':username', $system->cleanvars($_POST['username']), 'str');
				$params[] = array(':password', $phpass->HashPassword($_POST['password']), 'str');
				$params[] = array(':hash', get_hash(), 'str');
				$params[] = array(':created', date('Ymd'), 'str');
				$params[] = array(':lastlogin', time(), 'int');
				$db->query($query, $params);
				// Redirect
				header('location: login.php');
				exit;
			}
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
				include $include_path . 'PasswordHash.php';
				$phpass = new PasswordHash(8, false);
				$query = "SELECT id, hash, password FROM " . $DBPrefix . "adminusers WHERE username = :username";
				$params = array();
				$params[] = array(':username', $system->cleanvars($_POST['username']), 'str');
				$db->query($query, $params);
				$admin = $db->result();
				if ($db->numrows() == 0 || !($phpass->CheckPassword($_POST['password'], $admin['password'])))
				{
					$ERR = $ERR_048;
				}
				else
				{
					// generate a random unguessable token
					$_SESSION['csrftoken'] = md5(uniqid(rand(), true));
					// Set sessions vars
					$_SESSION['WEBID_ADMIN_NUMBER'] = strspn($admin['password'], $admin['hash']);
					$_SESSION['WEBID_ADMIN_PASS'] = $admin['password'];
					$_SESSION['WEBID_ADMIN_IN'] = $admin['id'];
					$_SESSION['WEBID_ADMIN_USER'] = $_POST['username'];
					$_SESSION['WEBID_ADMIN_TIME'] = $system->ctime;
					// Update last login information for this user
					$query = "UPDATE " . $DBPrefix . "adminusers SET lastlogin = :lastlogin WHERE id = :admin_id";
					$params = array();
					$params[] = array(':lastlogin', time(), 'int');
					$params[] = array(':admin_id', $admin['id'], 'int');
					$db->query($query, $params);
					// Redirect
					print '<script type="text/javascript">parent.location.href = \'index.php\';</script>';
					exit;
				}
			}
		break;
	}
}

$query = "SELECT id FROM " . $DBPrefix . "adminusers LIMIT 1";
$db->direct_query($query);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'THEME' => $system->SETTINGS['theme'],
		'L_COPY_YEAR' => date("Y"),
		'PAGE' => ($db->numrows() == 0) ? 1 : 2
		));

$template->set_filenames(array(
		'body' => 'login.tpl'
		));
$template->display('body');
?>
