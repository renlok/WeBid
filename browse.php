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

include 'includes/common.inc.php';
include $include_path . 'auctionstoshow.inc.php';
include $include_path . 'dates.inc.php';
include $main_path . 'language/' . $language . '/categories.inc.php';
$catscontrol = new MPTTcategories();

// Get parameters from the URL
$params['id'] = (isset($_GET['id'])) ? $_GET['id'] : 0;
$id = intval($params['id']);

if ($id != 0)
{
	$query = "SELECT right_id, left_id FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$parent_node = mysql_fetch_assoc($res);
	$children = $catscontrol->get_children_list($parent_node['left_id'], $parent_node['right_id']);
	$childarray = array($id);
	foreach ($children as $k => $v)
	{
		$childarray[] = $v['cat_id'];
	}
	$catalist = '(';
	$catalist .= implode(',', $childarray);
	$catalist .= ')';
}
$NOW = time();

/*
specified category number
look into table - and if we don't have such category - redirect to full list
*/
$bool = false;
if ($id != 0)
{
	$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$category = mysql_fetch_array($result);
	$bool = (mysql_num_rows($result) == 0);
}

if ($bool)
{
	// redirect to global categories list
	header ('location: browse.php?id=0');
	exit;
}
else
{
	// Retrieve the translated category name
	if ($id == 0)
	{
		$TPL_categories_string = $MSG['2__0027'];
		$par_id = 0;
	}
	else
	{
		$par_id = $category['parent_id'];
		$TPL_categories_string = '';
		$crumbs = $catscontrol->get_bread_crumbs($category['left_id'], $category['right_id']);
		for ($i = 0; $i < count($crumbs); $i++)
		{
			if ($crumbs[$i]['cat_id'] > 0)
			{
				if ($i > 1)
				{
					$TPL_categories_string .= ' &gt; ';
				}
				$TPL_categories_string .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';
			}
		}
	}

	// get list of subcategories of this category
	$subcat_count = 0;
	$query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = " . $id . " ORDER BY cat_name";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$need_to_continue = 1;
	$cycle = 1;

	$TPL_main_value = '';
	while ($row = mysql_fetch_array($result))
	{
		++$subcat_count;
		if ($cycle == 1)
		{
			$TPL_main_value .= '<tr align="left">' . "\n";
		}
		$sub_counter = (int)$row['sub_counter'];
		$cat_counter = (int)$row['counter'];
		if ($sub_counter != 0)
		{
			$count_string = ' (' . $sub_counter . ')';
		}
		else
		{
			if ($cat_counter != 0)
			{
				$count_string = ' (' . $cat_counter . ')';
			}
			else
			{
				$count_string = '';
			}
		}
		if ($row['cat_colour'] != '')
		{
			$BG = 'bgcolor=' . $row['cat_colour'];
		}
		else
		{
			$BG = '';
		}
		// Retrieve the translated category name
		$row['cat_name'] = $category_names[$row['cat_id']];
		$catimage = (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '';
		$TPL_main_value .= "\t" . '<td ' . $BG . ' WIDTH="33%">' . $catimage . '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . $count_string . '</a></td>' . "\n";

		++$cycle;
		if ($cycle == 4)
		{
			$cycle = 1;
			$TPL_main_value .= '</tr>' . "\n";
		}
	}

	if ($cycle >= 2 && $cycle <= 3)
	{
		while ($cycle < 4)
		{
			$TPL_main_value .= '	<td width="33%">&nbsp;</td>' . "\n";
			++$cycle;
		}
		$TPL_main_value .= '</tr>' . "\n";
	}

	// determine limits for SQL query
	$lines = 30;
	$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
	$left_limit = ($page - 1) * $lines;

	// retrieve records corresponding to passed page number
	$page = (int)$page;
	if ($page == 0) $page = 1;
	$lines = (int)$lines;
	if ($lines == 0) $lines = 50;

	$insql = ($id != 0) ? "category IN " . $catalist . " AND" : '';

	// get total number of records
	$qs = "SELECT count(*) FROM " . $DBPrefix . "auctions
			WHERE $insql starts <= " . $NOW . "
			AND closed = 0
			AND private = 'n'
			AND suspended = 0";
	if (!empty($_POST['catkeyword']))
	{
		$qs .= " AND title like '%" . $system->cleanvars($_POST['catkeyword']) . "%'";
	}
	$rsl = mysql_query($qs);
	$system->check_mysql($rsl, $qs, __LINE__, __FILE__);

	$hash = mysql_fetch_array($rsl);
	$total = !$hash[0] ? 1 : (int)$hash[0];
	// Handle pagination
	$TOTALAUCTIONS = $total;

	if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1)
	{
		$OFFSET = 0;
		$PAGE = 1;
	}
	else
	{
		$PAGE = $_REQUEST['PAGE'];
		$OFFSET = ($PAGE - 1) * $LIMIT;
	}
	$PAGES = ceil($TOTALAUCTIONS / $LIMIT);

	$qs = "SELECT * FROM " . $DBPrefix . "auctions
			WHERE $insql starts <= " . $NOW . "
			AND closed = 0
			AND private = 'n'
			AND suspended = 0";
	if (!empty($_POST['catkeyword']))
	{
		$qs .= " AND title LIKE '%" . $system->cleanvars($_POST['catkeyword']) . "%'";
	}
	$qs .= " ORDER BY ends ASC LIMIT " . intval($OFFSET) . "," . intval($LIMIT);

	$result = mysql_query($qs);
	$system->check_mysql($result, $qs, __LINE__, __FILE__);

	include $include_path . 'browseitems.inc.php';
	browseItems($result, 'browse.php');

	$template->assign_vars(array(
			'TOP_HTML' => $TPL_main_value,
			'CAT_STRING' => $TPL_categories_string
			));
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'browsecats.tpl'
		));
$template->display('body');
include 'footer.php';
?>