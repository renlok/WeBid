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
include "../includes/config.inc.php";
include "loggedin.inc.php";
?>
<link rel='stylesheet' type='text/css' href='style.css' />
<?php
if($_GET['show'] == "stats") {
	include "./home.stats.php";
} else {
	include "./home.installation.php";
}
?>