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

include 'common.php';

// Handle banners clickthrough
$query = "SELECT url FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $_GET['banner'], 'int');
$db->query($query, $params);
$URL = $db->result('url');

// Update clickthrough counter in the database
$query = "UPDATE " . $DBPrefix . "banners set clicks = clicks + 1 WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $_GET['banner'], 'int');
$db->query($query, $params);

// Redirect
header('location: ' . $URL);
exit;