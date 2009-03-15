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

include('data.inc.php');
$PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF']);
if(isset($_SESSION['WEBID_LOGGED_IN_USERNAME'])) 
	$_SESSION['WEBID_LOGGED_IN_USERNAME'] = addslashes($_SESSION['WEBID_LOGGED_IN_USERNAME']);

$MD5_PREFIX = 'fhQYBpS5FNs4';
$include_path = $main_path . 'includes/'; 
$uploaded_path = 'uploaded/';
$upload_path = $main_path . $uploaded_path; 
$logPath = $main_path . 'logs/';
$cronScriptHTMLOutput = FALSE;
if(!isset($error)){
	unset($_SESSION['SESSION_ERROR']);
	$_SESSION['SESSION_ERROR'] = array();
}

include $include_path . "functions_global.php";
$system = new global_class();

include $include_path . "fonts.inc.php"; //fonts data dump
include $include_path . "errors.inc.php"; //error handler functions
include $include_path . "messages.inc.php";
include $include_path . "dates.inc.php";
include $include_path . "functions_email.php";
set_error_handler('WeBidErrorHandler');

// Atuomatically login user is necessary "Remember me" option
if(!isset($_SESSION['WEBID_LOGGED_IN']) && isset($_COOKIE['WEBID_RM_ID'])) {
	$query = "SELECT userid FROM " . $DBPrefix . "rememberme WHERE hashkey = '".addslashes($_COOKIE['WEBID_RM_ID'])."'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if(mysql_num_rows($res) > 0){
		$id = mysql_result($res,0,"userid");
		$query = "SELECT email, nick, name FROM " . $DBPrefix . "users WHERE id = ".$id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$_SESSION['WEBID_LOGGED_IN'] = $id;
		$_SESSION['WEBID_LOGGED_EMAIL'] = mysql_result($res,0,"email"); 
		$_SESSION['WEBID_LOGGED_NAME'] = mysql_result($res,0,"name");
		$_SESSION['WEBID_LOGGED_IN_USERNAME'] = mysql_result($res,0,"nick");
	}
}

include $include_path . "template.php";
$template = new template();
$template->set_template();
?>