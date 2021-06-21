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

if (!isset($_GET['banner']))
	exit();

$banner = $_GET['banner'];
$CATEGORIES = $KEYWORDS = '';

// Retrieve filters
$query = "SELECT c.cat_name FROM " . $DBPrefix . "bannerscategories b
		LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = b.category)
		WHERE banner = :banner";
$params = array();
$params[] = array(':banner', $banner, 'int');
$db->query($query, $params);

if ($db->numrows() > 0)
{
	while ($row = $db->fetch())
	{
		$CATEGORIES .= '<p>' . $row['cat_name'] . '</p>';
	}
}
$query = "SELECT keyword FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner";
$params = array();
$params[] = array(':banner', $banner, 'int');
$db->query($query, $params);
$count = $db->numrows();

if ($count > 0)
{
	while ($row = $db->fetch())
	{
		$KEYWORDS .= '<p>' . $row['keyword'] . '</p>';
	}
}
?>

<html>
<head>
<title>Banner filters</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#ffffff">
<center>
	<p><b>
	Banner filter</b> </p>
	<p align="center"><a href="javascript:window.close()" class="bluelink">Close</a></p>
	<table width="352" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#eeeeee"><?php echo $MSG['_0053']; ?></td>
	</tr>
	<tbody>
	<tr>
		<td><?php echo $CATEGORIES; ?></td>
	</tr>
	<tr>
		<td bgcolor="#ffffff">&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#eeeeee"><?php echo $MSG['_0054']; ?></td>
	</tr>
	<tr>
		<td><?php echo $KEYWORDS; ?></td>
	</tr>
	</tbody>
	</table>
	</center>
	<p align="center"><a href="javascript:window.close()" class="bluelink">Close</a></p>
</body>
</html>