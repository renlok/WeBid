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
include 'loggedin.inc.php';

$TOTAL_PAGEVIEWS = 0;
$TOTAL_UNIQUEVISITORS = 0;
$TOTAL_USERSESSIONS = 0;

// Retrieve data
$query = "SELECT pageviews FROM " . $DBPrefix . "currentaccesses ORDER BY pageviews DESC LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$MAX = mysql_result($res, 0);

$query = "SELECT * FROM " . $DBPrefix . "currentaccesses ORDER BY day ASC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while ($row = mysql_fetch_array($res)) {
	$TOTAL_PAGEVIEWS += $month['pageviews'];
	$TOTAL_UNIQUEVISITORS += $month['uniquevisitiors'];
	$TOTAL_USERSESSIONS += $month['usersessions'];
	$template->assign_block_vars('sitestats', array(
			'DATE' => $row['day'] . '/' . $row['month'] . '/' . $row['year'],
			'PAGEVIEWS' => $row['pageviews'],
			'PAGEVIEWS_WIDTH' => ($row['pageviews'] * 100) / $MAX,
			'UNIQUEVISITORS' => $row['uniquevisitiors'],
			'UNIQUEVISITORS_WIDTH' => ($row['uniquevisitiors'] * 100) / $MAX,
			'USERSESSIONS' => $row['usersessions'],
			'USERSESSIONS_WIDTH' => ($row['usersessions'] * 100) / $MAX
			));
}

$template->assign_vars(array(
		'SITENAME' => $system->SETTINGS['sitename'],
		'TOTAL_PAGEVIEWS' => $TOTAL_PAGEVIEWS,
		'TOTAL_UNIQUEVISITORS' => $TOTAL_UNIQUEVISITORS,
		'TOTAL_USERSESSIONS' => $TOTAL_USERSESSIONS,
		'STATSMONTH' => gmdate('F Y')
		));

$template->set_filenames(array(
		'body' => 'viewaccessstats.tpl'
		));
$template->display('body');
?>