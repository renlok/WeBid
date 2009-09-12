<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$banneruser = $_GET['user'];
$banner = $_GET['banner'];
$name = $_GET['name'];

$query = "DELETE FROM " . $DBPrefix . "banners WHERE id = " . $banner;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
$query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = " . $banner;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
$query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = " . $banner;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
@unlink($upload_path . 'banners/' . $banneruser . '/' . $name);

// Redirect
header('location: userbanners.php?id=' . $banneruser);
?>