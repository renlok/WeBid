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
include 'loggedin.inc.php';

if (!isset($_GET['banner']) || empty($_GET['banner']))
{
	header('location: managebanners.php');
	exit;
}

$banner = $_GET['banner'];

$query = "SELECT name, user FROM " . $DBPrefix . "banners WHERE id = " . $banner;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$bannername = mysql_result($res, 0, 'name');
$banneruser = mysql_result($res, 0, 'user');


$query = "DELETE FROM " . $DBPrefix . "banners WHERE id = " . $banner;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
$query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = " . $banner;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
$query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = " . $banner;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
@unlink($upload_path . 'banners/' . $banneruser . '/' . $bannername);

// Redirect
header('location: userbanners.php?id=' . $banneruser);
?>