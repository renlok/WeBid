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

session_start();
$error_reporting = E_ALL^E_NOTICE;
$error_reporting = E_ALL; // use this for debugging
define('InWeBid', 1);
define('TrackUserIPs', 1);
date_default_timezone_set('UTC'); // to make times more consistant

// file check &
if(!@include('includes/config.inc.php'))
{
	$install_path = (!defined('InAdmin')) ? 'install/install.php' : '../install/install.php';
	header('location: ' . $install_path);
	exit;
}

$MD5_PREFIX = (!isset($MD5_PREFIX)) ? 'fhQYBpS5FNs4' : $MD5_PREFIX; // if the user didnt set a code
$include_path = $main_path . 'includes/';
$uploaded_path = 'uploaded/';
$upload_path = $main_path . $uploaded_path;

include $include_path . 'errors.inc.php'; //error handler functions
include $include_path . 'dates.inc.php';

// classes
include $include_path . 'class_db_handle.php';
include $include_path . 'functions_global.php';
include $include_path . 'class_email_handler.php';
include $include_path . 'class_MPTTcategories.php';
include $include_path . 'class_fees.php';
include $include_path . 'class_user.php';
include $include_path . 'template.php';

// connect to the database
$db = new db_handle();
if (isset($CHARSET))
{
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $CHARSET);
}
else
{
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix);
}

$system = new global_class();
$template = new template();
$user = new user();
set_error_handler('WeBidErrorHandler', $error_reporting);

include $include_path . 'messages.inc.php';

// add auction types
$system->SETTINGS['auction_types'] = array (
	1 => $MSG['1021'],
	2 => $MSG['1020']
);

// Atuomatically login user is necessary "Remember me" option
if (!$user->logged_in && isset($_COOKIE['WEBID_RM_ID']))
{
	$query = "SELECT userid FROM " . $DBPrefix . "rememberme WHERE hashkey = :RM_ID";
	$params = array();
	$params[] = array(':RM_ID', alphanumeric($_COOKIE['WEBID_RM_ID']), 'str');
	$db->query($query, $params);
	if ($db->numrows() > 0)
	{
		// generate a random unguessable token
		$_SESSION['csrftoken'] = md5(uniqid(rand(), true));
		$id = $db->result('userid');
		$query = "SELECT hash, password FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array();
		$params[] = array(':user_id', $id, 'int');
		$db->query($query, $params);
		$password = $db->result('password');
		$_SESSION['WEBID_LOGGED_IN'] 		= $id;
		$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($password, $db->result('hash'));
		$_SESSION['WEBID_LOGGED_PASS'] 		= $password;
	}
}

if($user->logged_in)
{
	$system->tdiff = ($user->user_data['timecorrection'] + date('I')) * 3600;
	$system->ctime = time() + $system->tdiff;
}

// delete REDIRECT_AFTER_LOGIN value automatically so you are never forwarded to an old page
if(isset($_SESSION['REDIRECT_AFTER_LOGIN']) && !defined('AtLogin'))
{
	unset($_SESSION['REDIRECT_AFTER_LOGIN']);
}

$template->set_template();