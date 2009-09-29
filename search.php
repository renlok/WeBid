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
include $main_path . 'language/' . $language . '/categories.inc.php';
include $include_path . 'dates.inc.php';

$NOW = time();

$query = $system->cleanvars(trim($_GET['q']));

if (strlen($query) == 0)
{
	$template->assign_vars(array(
			'ERROR' => $ERR_037,
			'NUM_AUCTIONS' => 0,
			'TOP_HTML' => ''
			));
}
else
{
	$sql = "SELECT * FROM " . $DBPrefix . "auctions WHERE " . $qp1 . "
			(title LIKE '%" . $query . "%' OR id = " . intval($query) . ")
			AND closed = 0 AND suspended = 0 AND starts <= " . $NOW . " AND ends > " . $NOW;

	// retrieve records corresponding to passed page number
	$PAGE = (int)$_GET['page'];
	if ($PAGE == 0) $PAGE = 1;
	$lines = 50;

	// determine limits for SQL query
	$left_limit = ($PAGE - 1) * $lines;

	/* get total number of records */
	$rsl = mysql_query($sql);
	$system->check_mysql($rsl, $sql, __LINE__, __FILE__);

	$hash = mysql_fetch_array($rsl);
	$total = (int)$hash[0];

	/* get number of pages */
	$PAGES = (int)($total / $lines);
	if (($total % $lines) > 0)
		++$PAGES;

	$query = $sql . " ORDER BY ends LIMIT " . $left_limit . ", " . $lines;
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);

	$query = $sql . " AND featured = 'y' ORDER BY ends LIMIT " . intval(($PAGE - 1) * 5) . ", 5";
	$feat_res = mysql_query($query);
	$system->check_mysql($feat_res, $query, __LINE__, __FILE__);

	// to be sure about items format, I've unified the call
	include $include_path . 'browseitems.inc.php';
	browseItems($result, $feat_res, 'search.php');
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'search.tpl'
		));
$template->display('body');
include 'footer.php';
?>
