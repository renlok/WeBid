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

session_start();
define('InWeBid', 1);
include('config.inc.php');

$MD5_PREFIX = 'fhQYBpS5FNs4';
$include_path = $main_path . 'includes/'; 
$uploaded_path = 'uploaded/';
$upload_path = $main_path . $uploaded_path; 
$logPath = $main_path . 'logs/';

include $include_path . "fonts.inc.php"; //fonts data dump
include $include_path . "errors.inc.php"; //error handler functions
include $include_path . "dates.inc.php";

// classes
include $include_path . "functions_global.php";
include $include_path . "functions_email.php";
include $include_path . "functions_user.php";
include $include_path . "template.php";

$system = new global_class();
$template = new template();
$user = new user();
set_error_handler('WeBidErrorHandler');

include $include_path . "messages.inc.php";

// Atuomatically login user is necessary "Remember me" option
if (!$user->logged_in && isset($_COOKIE['WEBID_RM_ID']))
{
	$query = "SELECT userid FROM " . $DBPrefix . "rememberme WHERE hashkey = '" . mysql_escape_string($_COOKIE['WEBID_RM_ID']) . "'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$id = mysql_result($res, 0, 'userid');
		$query = "SELECT hash, password FROM " . $DBPrefix . "users WHERE id = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$password = mysql_result($res, 0, 'password');
		$_SESSION['WEBID_LOGGED_IN'] 		= $id;
		$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($password, mysql_result($res, 0, 'hash'));
		$_SESSION['WEBID_LOGGED_PASS'] 		= $password;
	}
}

$template->set_template();
?>