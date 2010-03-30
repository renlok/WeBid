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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';

unset($ERR);

// Set offset and limit for pagination
if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '')
{
	$OFFSET = 0;
	$PAGE = 1;
}
elseif (!isset($_SESSION['RETURN_LIST_OFFSET']) || $_SESSION['RETURN_LIST_OFFSET'] == '')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

$_SESSION['RETURN_LIST'] = 'listclosedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(id) As auctions FROM " . $DBPrefix . "auctions WHERE closed = 1 AND suspended = 0";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_auctions = mysql_result($res, 0, 'auctions');

$query = "SELECT a.id, u.nick, a.title, a.starts, a.ends, a.suspended, c.cat_name, COUNT(w.id) as winners FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = a.category)
		LEFT JOIN " . $DBPrefix . "winners w ON (w.auction = a.id)
		WHERE a.closed = 1 AND a.suspended = 0 GROUP BY a.id ORDER BY nick LIMIT " . $OFFSET . ", " . $system->SETTINGS['perpage'];
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
			'CATEGORY' => $row['cat_name'],
			'B_HASWINNERS' => ($row['winners'] == 0) ? false : true
			));
}

$num_pages = ceil($num_auctions / $system->SETTINGS['perpage']);
$pagnation = '';
for ($i = 0; $i < $num_pages; $i++)
{
	if (($i + 1) != $PAGE)
	{
		$user = ($uid > 0) ? '&uid=' . $uid : '';
		$pagnation .= '<a href="listclosedauctions.php?PAGE=' . ($i + 1) . $user . '" class="navigation">' . ($i + 1) . '</a>';
	}
	else
	{
		$pagnation .= $i + 1;
	}
	if (($i + 1) < $num_pages) $pagnation .= ' | ';
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'PAGE_TITLE' => $MSG['5226'],
		'NUM_AUCTIONS' => $num_auctions,
		'SITEURL' => $system->SETTINGS['siteurl'],
		'PAGE' => $PAGE,
		'PAGNATION' => $pagnation
		));

$template->set_filenames(array(
		'body' => 'listauctions.tpl'
		));
$template->display('body');
?>
