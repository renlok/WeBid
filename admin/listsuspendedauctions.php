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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';

unset($ERR);

// Set offset and limit for pagination
$limit = 20;
if (!$_GET['offset'])
{
	$offset = 0;
}
else
{
	$offset = $_GET['offset'];
}
$_SESSION['RETURN_LIST'] = 'listsuspendedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $offset;

$query = "SELECT COUNT(id) As auctions FROM " . $DBPrefix . "auctions WHERE suspended != 0";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_auctions = mysql_result($res, 0, 'auctions');

$query = "SELECT a.id, u.nick, a.title, a.starts, a.ends, a.suspended, c.cat_name FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = a.category)
		WHERE a.suspended != 0 ORDER BY nick LIMIT " . $offset . ", " . $limit;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$bgcolour = '#FFFFFF';
while ($row = mysql_fetch_assoc($res))
{
	$bgcolour = ($bgcolour == '#FFFFFF') ?  '#EEEEEE' : '#FFFFFF';
	$template->assign_block_vars('auctions', array(
			'BGCOLOUR' => $bgcolour,
			'SUSPENDED' => $row['suspended'],
			'ID' => $row['id'],
			'TITLE' => $row['title'],
			'START_TIME' => ArrangeDateNoCorrection($row['starts']),
			'END_TIME' => ArrangeDateNoCorrection($row['ends']),
			'USERNAME' => $row['nick'],
			'CATEGORY' => $row['cat_name']
			));
}

$num_pages = ceil($num_auctions / $limit);
$pagnation = '';
for ($i = 0; $i < $num_pages; $i++)
{
	$of = ($i * $limit);
	if ($of != $offset)
	{
		$pagnation .= '<a href="listsuspendedauctions.php?offset=' . $of . '" class="navigation">' . ($i + 1) . '</a>';
	}
	else
	{
		$pagnation .= $i + 1;
	}
	if (($i + 1) < $num_pages) $pagnation .= ' | ';
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'PAGE_TITLE' => $MSG['5227'],
		'NUM_AUCTIONS' => $num_auctions,
		'SITEURL' => $system->SETTINGS['siteurl'],
		'OFFSET' => $offset,
		'PAGNATION' => $pagnation
		));

$template->set_filenames(array(
		'body' => 'listauctions.tpl'
		));
$template->display('body');
?>
