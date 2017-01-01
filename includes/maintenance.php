<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (basename($_SERVER['PHP_SELF']) != 'user_login.php') {
    // Check if we are in Maintainance mode
    // And if the logged in user is the superuser
    if ($system->check_maintenance_mode()) {
        echo $system->SETTINGS['maintenance_text'];
        exit;
    }
}
