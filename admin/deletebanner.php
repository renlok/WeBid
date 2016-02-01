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
$current_page = 'banners';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (!isset($_GET['banner']) || empty($_GET['banner']))
{
	header('location: managebanners.php');
	exit;
}

$banner = $_GET['banner'];
$params = array();
$params[] = array(':banner_id', $banner, 'int');

$query = "SELECT name, user FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$db->query($query, $params);
$banner_data = $db->result();
$bannername = $banner_data['name'];
$banneruser = $banner_data['user'];


$query = "DELETE FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$db->query($query, $params);
$query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = :banner_id";
$db->query($query, $params);
$query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner_id";
$db->query($query, $params);
@unlink(UPLOAD_PATH . 'banners/' . $banneruser . '/' . $bannername);

// Redirect
header('location: userbanners.php?id=' . $banneruser);
?>
