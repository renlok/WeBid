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
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';

$NOW = time();

$term = trim($_GET['q']);
$cat_id = intval($_GET['id']);

if (strlen($term) == 0)
{
	$template->assign_vars(array(
			'ERROR' => $ERR_037,
			'NUM_AUCTIONS' => 0,
			'TOP_HTML' => ''
			));
}
else
{
	$catSQL = '';
	if ($cat_id > 0)
	{
		$catscontrol = new MPTTcategories();
		$query = "SELECT right_id, left_id FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
		$params = array();
		$params[] = array(':cat_id', $cat_id, 'int');
		$db->query($query, $params);
		$parent_node = $db->result();
		$children = $catscontrol->get_children_list($parent_node['left_id'], $parent_node['right_id']);
		$childarray = array($cat_id);
		foreach ($children as $k => $v)
		{
			$childarray[] = $v['cat_id'];
		}
		$catalist = '(';
		$catalist .= implode(',', $childarray);
		$catalist .= ')';
		$catSQL = " AND (category IN " . $catalist;
		if ($system->SETTINGS['extra_cat'] == 'y')
		{
			$catSQL .= " OR secondcat IN " . $catalist;
		}
		$catSQL .= ")";
	}
	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE
			(title LIKE :title OR id = :auc_id)
			" . $catSQL . "
			AND closed = 0 AND suspended = 0 AND starts <= :time AND ends > :time";
	$params = array();
	$params[] = array(':title', '%' . $system->cleanvars($term) . '%', 'str');
	$params[] = array(':auc_id', $term, 'int');
	$params[] = array(':time', $NOW, 'int');
	$db->query($query, $params);

	// get total number of records
	$total = $db->numrows();

	// retrieve records corresponding to passed page number
	$PAGE = isset($_GET['PAGE']) ? intval($_GET['PAGE']) : 1;
	if ($PAGE == 0) $PAGE = 1;

	// determine limits for SQL query
	$left_limit = ($PAGE - 1) * $system->SETTINGS['perpage'];

	// get number of pages
	$PAGES = ceil($total / $system->SETTINGS['perpage']);

	$query_feat = $query . " AND featured = 'y' ORDER BY ends LIMIT :offset, 5";
	$params_feat = $params;
	$params_feat[] = array(':offset', (($PAGE - 1) * 5), 'int');

	$query = $query . " ORDER BY ends LIMIT :offset, :perpage";
	$params[] = array(':offset', $left_limit, 'int');
	$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');

	// to be sure about items format, I've unified the call
	include INCLUDE_PATH . 'browseitems.inc.php';
	browseItems($query, $params, $query_feat, $params_feat, $total, 'search.php', 'q=' . $term . '&id=' . $cat_id);
}

$template->assign_vars(array(
			'ERROR' => null
			));

include 'header.php';
$template->set_filenames(array(
		'body' => 'search.tpl'
		));
$template->display('body');
include 'footer.php';
