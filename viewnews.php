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

$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

if ($id > 0)
{
	$query = "SELECT n.title As t, n.content As c, n.new_date, t.* FROM " . $DBPrefix . "news n
			LEFT JOIN " . $DBPrefix . "news_translated t ON (t.id = n.id)
			WHERE n.id = " . $id . " AND t.lang = '" . $language . "' AND n.suspended != 1";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	$new = mysql_fetch_array($res);
	if (!empty($new['title']) && !empty($new['content']))
	{
		$title = stripslashes($new['title']);
		$content = stripslashes($new['content']);
	}
	else
	{
		$title = stripslashes($new['t']);
		$content = stripslashes($new['c']);
	}
	$template->assign_block_vars('news', array(
			'CONT' => nl2br($content)
			));
}
else
{
	// Build news index
	$query = "SELECT n.title As t, n.new_date, t.* FROM " . $DBPrefix . "news n
			LEFT JOIN " . $DBPrefix . "news_translated t ON (t.id = n.id)
			WHERE t.lang = '" . $language . "' AND n.suspended != 1 ORDER BY n.new_date DESC, n.id DESC";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	while ($row = mysql_fetch_array($res))
	{
		if (!empty($row['title']))
		{
			$title = stripslashes($row['title']);
		}
		else
		{
			$title = stripslashes($row['t']);
		}
		$template->assign_block_vars('list', array(
				'TITLE' => $title,
				'DATE' => FormatDate($row['new_date']),
				'ID' => $row['id']
				));
	}
}

$template->assign_vars(array(
		'TITLE' => ($id > 0) ? stripslashes($new['title']) . ' ' . FormatDate($new['new_date']) : $MSG['282']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'viewnews.tpl'
		));
$template->display('body');
include 'footer.php';
?>
