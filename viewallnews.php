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

$query = "SELECT id, title FROM " . $DBPrefix . "news WHERE suspended = 0 ORDER BY new_date";
$db->direct_query($query);

while ($row = $db->fetch())
{
	$template->assign_block_vars('news', array(
			'TITLE' => $row['title'],
			'ID' => $row['id']
			));
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'viewallnews.tpl'
		));
$template->display('body');
include 'footer.php';