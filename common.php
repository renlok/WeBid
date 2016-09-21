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
date_default_timezone_set('UTC'); // to make times more consistent
$error_reporting = E_ALL^E_NOTICE;
$error_reporting = E_ALL; // use this for debugging
define('InWeBid', true);
define('TrackUserIPs', true);

// file check &
if(!@include('includes/config.inc.php'))
{
	$install_path = (!defined('InAdmin')) ? 'install/install.php' : '../install/install.php';
	header('location: ' . $install_path);
	exit;
}

$MD5_PREFIX = (!isset($MD5_PREFIX)) ? 'fhQYBpS5FNs4' : $MD5_PREFIX; // if the user didn't set a code

//define the paths
define('MAIN_PATH', $main_path);
define('CACHE_PATH', MAIN_PATH . 'cache/');
define('INCLUDE_PATH', MAIN_PATH . 'includes/');
define('PACKAGE_PATH', MAIN_PATH . 'includes/packages/');
define('UPLOAD_FOLDER', 'uploaded/');
define('UPLOAD_PATH', MAIN_PATH . UPLOAD_FOLDER);
define('IMAGE_CACHE_PATH', UPLOAD_PATH . 'cache/');

include INCLUDE_PATH . 'errors.inc.php'; //error handler functions
include INCLUDE_PATH . 'dates.inc.php';

// classes
include INCLUDE_PATH . 'database/Database.php';
include INCLUDE_PATH . 'database/DatabasePDO.php';
include INCLUDE_PATH . 'functions_global.php';
include INCLUDE_PATH . 'class_email_handler.php';
include INCLUDE_PATH . 'class_MPTTcategories.php';
include INCLUDE_PATH . 'class_fees.php';
include INCLUDE_PATH . 'User.php';
include INCLUDE_PATH . 'template/Template.php';

// connect to the database
$db = new DatabasePDO();
if (isset($CHARSET))
{
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $CHARSET);
}
else
{
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix);
}

$system = new global_class();
$template = new Template();
$user = new User();
include INCLUDE_PATH . 'messages.inc.php';
$system->loadAuctionTypes();
set_error_handler('WeBidErrorHandler', $error_reporting);

if($user->logged_in)
{
	$system->tdiff = $system->getUserOffset(time(), $user->user_data['timezone']);
	$system->ctime = $system->getUserTimestamp(time(), $user->user_data['timezone']) + $system->tdiff;
}

// delete REDIRECT_AFTER_LOGIN value automatically so you are never forwarded to an old page
if(isset($_SESSION['REDIRECT_AFTER_LOGIN']) && !defined('AtLogin'))
{
	unset($_SESSION['REDIRECT_AFTER_LOGIN']);
}

$template->set_template();