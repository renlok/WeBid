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
include 'loggedin.inc.php';

$TOTAL_PAGEVIEWS = 0;
$TOTAL_UNIQUEVISITORS = 0;
$TOTAL_USERSESSIONS = 0;

// Retrieve data
$query = "SELECT pageviews FROM " . $DBPrefix . "accesseshistoric ORDER BY pageviews DESC LIMIT 1";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$MAX = mysql_result($res, 0);

$query = "SELECT * FROM " . $DBPrefix . "accesseshistoric ORDER BY year DESC, month DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($month = mysql_fetch_assoc($res))
{
	$TOTAL_PAGEVIEWS += $month['pageviews'];
	$TOTAL_UNIQUEVISITORS += $month['uniquevisitiors'];
	$TOTAL_USERSESSIONS += $month['usersessions'];
	$template->assign_block_vars('sitestats', array(
			'DATE' => $month['month'] . '/' . $month['year'],
			'PAGEVIEWS' => $month['pageviews'],
			'PAGEVIEWS_WIDTH' => ($month['pageviews'] * 100) / $MAX,
			'UNIQUEVISITORS' => $month['uniquevisitiors'],
			'UNIQUEVISITORS_WIDTH' => ($month['uniquevisitiors'] * 100) / $MAX,
			'USERSESSIONS' => $month['usersessions'],
			'USERSESSIONS_WIDTH' => ($month['usersessions'] * 100) / $MAX
			));
}

$template->assign_vars(array(
		'SITENAME' => $system->SETTINGS['sitename'],
		'TOTAL_PAGEVIEWS' => $TOTAL_PAGEVIEWS,
		'TOTAL_UNIQUEVISITORS' => $TOTAL_UNIQUEVISITORS,
		'TOTAL_USERSESSIONS' => $TOTAL_USERSESSIONS
		));

$template->set_filenames(array(
		'body' => 'accessstatshistoric.html'
		));
$template->display('body');
?>