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

ob_start('ob_gzhandler');
header("Content-type: text/javascript");
if (isset($_GET['js']))
{
	$js = explode(';', $_GET['js']);
	foreach ($js as $val)
	{
		if (is_file($val))
		{
			echo file_get_contents($val);
			echo "\n";
		}
	}
}
ob_end_flush();
?>