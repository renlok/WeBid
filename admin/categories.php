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

$catscontrol = new MPTTcategories();

function search_cats($parent_id, $level)
{
	global $DBPrefix, $catscontrol;
	$root = $catscontrol->get_virtual_root();
	$tree = $catscontrol->display_tree($root['left_id'], $root['right_id'], '|___');
	foreach ($tree as $k => $v)
	{
		$catstr .= ",\n" . $k . " => '" . $v . "'";
	}
	return $catstr;
}

function rebuild_cat_file()
{
	global $system, $main_path, $DBPrefix;
	$query = "SELECT cat_id, cat_name, parent_id FROM " . $DBPrefix . "categories ORDER BY cat_name";
	$result = mysql_query($query);
	$cats = array();
	while ($catarr = mysql_fetch_array($result))
	{
		$cats[$catarr['cat_id']] = $catarr['cat_name'];
		$allcats[] = $catarr;
	}
	
	$output = "<?php\n";
	$output.= "$" . "category_names = array(\n";
	
	$num_rows = count($cats);
	
	$i = 0;
	foreach ($cats as $k => $v)
	{
		$output .= "$k => '$v'";
		$i++;
		if ($i < $num_rows)
			$output .= ",\n";
		else
			$output .= "\n";
	}
	
	$output .= ");\n\n";
	
	$output .= "$" . "category_plain = array(\n0 => ''";
	
	$output .= search_cats(0, 0);
	
	$output .= ");\n?>";
	
	$handle = fopen ($main_path . "language/" . $system->SETTINGS['defaultlanguage'] . "/categories.inc.php", "w");
	fputs($handle, $output);
}

if (isset($_POST['action']))
{
	//update all categories that arnt being deleted
	foreach ($_POST['categories'] as $k => $v)
	{
		if (!isset($_POST['delete'][$k]))
		{
			$query = "UPDATE " . $DBPrefix . "categories SET cat_name = '" . $system->cleanvars($_POST['categories'][$k]) . "',
					cat_colour = '" . mysql_escape_string($_POST['colour'][$k]) . "', cat_image = '" . mysql_escape_string($_POST['image'][$k]) . "'
					WHERE cat_id = " . intval($k);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	//delete categories that are
	foreach ($_POST['delete'] as $k => $v)
	{
		//never delete categories without using this function it will mess up your database big time
		$catscontrol->delete(intval($k));
	}
	print_r($_POST);
	//add category if need be
	if (!empty($_POST['new_category']) && isset($_POST['parent']))
	{
		$add_data = array(
			'cat_name' => $system->cleanvars($_POST['new_category']),
			'cat_colour' => $_POST['cat_colour'],
			'cat_image' => $_POST['cat_image']
			);
		$catscontrol->add($_POST['parent'], 0, $add_data);
	}
	rebuild_cat_file();
	include 'util_cc1.php';
}

//show the page... 
$parent = (!isset($_GET['parent'])) ? 0 : intval($_GET['parent']);

$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $parent;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$parent_node = mysql_fetch_assoc($res);

$crumb_string = '';
if ($parent != 0)
{
	$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	for ($i = 0; $i < count($crumbs); $i++)
	{
		if ($i > 0)
		{
			$crumb_string .= ' > ';
		}
		$crumb_string .= '<a href="categories.php?parent=' . $crumbs[$i]['cat_id'] . '">' . $crumbs[$i]['cat_name'] . '</a>';
	}
}

$colourrow[0] = '#FFFFFF';
$colourrow[1] = '#EEEEEE';
$c = 0;
$children = $catscontrol->get_children($parent_node['left_id'], $parent_node['right_id'], $parent_node['level']);
for ($i = 0; $i < count($children); $i++)
{
	$child = $children[$i];
	$template->assign_block_vars('cats', array(
			'CAT_ID' => $child['cat_id'],
			'CAT_NAME' => $system->uncleanvars($child['cat_name']),
			'CAT_COLOUR' => $child['cat_colour'],
			'CAT_IMAGE' => $child['cat_image'],
			'ROW_COLOUR' => $colourrow[$c],
			
			'B_CAN_DELETE' => ($child['left_id'] == ($child['right_id'] - 1) && $child['sub_counter'] == 0)
			));
	$c = ($c == 1) ? 0 : 1;
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'CRUMBS' => $crumb_string,
		'PARENT' => $parent
		));

$template->set_filenames(array(
		'body' => 'categories.html'
		));
$template->display('body');
?>