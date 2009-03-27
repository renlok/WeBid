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

include "includes/common.inc.php";

unset($_SESSION['WEBID_LOGGED_IN'], $_SESSION['WEBID_LOGGED_NUMBER'], $_SESSION['WEBID_LOGGED_PASS']);
if (isset($_COOKIE['WEBID_RM_ID'])) {
	$query = "DELETE FROM " . $DBPrefix . "rememberme WHERE hashkey = '" . $_COOKIE['WEBID_RM_ID'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	setcookie('WEBID_RM_ID', '', time() - 3600);
}

header("location: " . $system->SETTINGS['siteurl'] . "index.php");
exit;

?>