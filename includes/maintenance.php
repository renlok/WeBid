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

if (basename($_SERVER['PHP_SELF']) != 'user_login.php')
{
	// Check if we are in Maintainance mode
	// And if the logged in user is the superuser
	$query = "SELECT * FROM " . $DBPrefix . "maintainance";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	
	if (mysql_num_rows($res) > 0)
	{
		$MAINTAINANCE = mysql_fetch_array($res);
		if ($MAINTAINANCE['active'] == 'y' && ($user->user_data['nick'] != $MAINTAINANCE['superuser'] && $user->user_data['id'] != $MAINTAINANCE['superuser']))
		{
			print $MAINTAINANCE['maintainancetext'];
			exit;
		}
	}
}
?>