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

include 'common.php';

// Handle banners clickthrough
$query = "SELECT url FROM " . $DBPrefix . "banners WHERE id = " . intval($_GET['banner']);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$URL = mysql_result($res, 0);

// Update clickthrough counter in the database
$query = "UPDATE " . $DBPrefix . "banners set clicks = clicks + 1 WHERE id = " . intval($_GET['banner']);
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

// Redirect
header('location: ' . $URL);
exit;
?>
