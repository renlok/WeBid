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

include 'includes/common.inc.php';

$query = "SELECT id, title FROM " . $DBPrefix . "news WHERE suspended = 0 ORDER BY new_date";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while ($new = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('news', array(
			'TITLE' => stripslashes($new['title']),
			'ID' => $new['id']
			));
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'view_allnews.tpl'
		));
$template->display('body');
include 'footer.php';
?>
