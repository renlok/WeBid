<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
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
$catscontrol = new MPTTcategories();

// Get parameters from the URL
$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
$_SESSION['browse_id'] = $id;
$all_items = true;

$params = array();
if ($id != 0) {
    $query = "SELECT right_id, left_id FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
    $params[] = array(':cat_id', $id, 'int');
} else {
    $query = "SELECT right_id, left_id, cat_id FROM " . $DBPrefix . "categories WHERE left_id = 1";
}

$db->query($query, $params);
$parent_node = $db->result();
$id = (isset($parent_node['cat_id'])) ? $parent_node['cat_id'] : $id;
$catalist = '';
if ($parent_node['left_id'] != 1) {
    $children = $catscontrol->get_children_list($parent_node['left_id'], $parent_node['right_id']);
    $childarray = array($id);
    foreach ($children as $k => $v) {
        $childarray[] = $v['cat_id'];
    }
    $catalist = '(';
    $catalist .= implode(',', $childarray);
    $catalist .= ')';
    $all_items = false;
}

/*
specified category number
look into table - and if we don't have such category - redirect to full list
*/
$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
$params = array();
$params[] = array(':cat_id', $id, 'int');
$db->query($query, $params);
$category = $db->result();

if ($db->numrows() == 0) {
    // redirect to global categories list
    header('location: browse.php?id=0');
    exit;
} else {
    // Retrieve the translated category name
    $cat_id = $category['cat_id'];
    $current_cat_name = $category_names[$cat_id];
    $TPL_categories_string = '';
    $crumbs = $catscontrol->get_bread_crumbs($category['left_id'], $category['right_id']);
    for ($i = 0; $i < count($crumbs); $i++) {
        if ($crumbs[$i]['cat_id'] > 0) {
            if ($i > 0) {
                $TPL_categories_string .= ' &gt; ';
            }
            $TPL_categories_string .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';
        }
    }

    // get list of subcategories of this category
    $subcat_count = 0;
    $query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = :parent_id ORDER BY cat_name";
    $params = array();
    $params[] = array(':parent_id', $id, 'int');
    $db->query($query, $params);
    $need_to_continue = 1;
    $cycle = 1;

    $TPL_main_value = '';
    while ($row = $db->fetch()) {
        ++$subcat_count;
        if ($cycle == 1) {
            $TPL_main_value .= '<tr align="left">' . "\n";
        }
        $sub_counter = $row['sub_counter'];
        $cat_counter = $row['counter'];
        if ($sub_counter != 0) {
            $count_string = ' (' . $sub_counter . ')';
        } else {
            if ($cat_counter != 0) {
                $count_string = ' (' . $cat_counter . ')';
            } else {
                $count_string = '';
            }
        }
        if ($row['cat_colour'] != '') {
            $BG = 'bgcolor=' . $row['cat_colour'];
        } else {
            $BG = '';
        }
        // Retrieve the translated category name
        $row['cat_name'] = $category_names[$row['cat_id']];
        $catimage = (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '';
        $TPL_main_value .= "\t" . '<td class="cattd" ' . $BG . ' WIDTH="33%">' . $catimage . '<a class="catclass" href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . $count_string . '</a></td>' . "\n";

        ++$cycle;
        if ($cycle == 4) {
            $cycle = 1;
            $TPL_main_value .= '</tr>' . "\n";
        }
    }

    if ($cycle >= 2 && $cycle <= 3) {
        while ($cycle < 4) {
            $TPL_main_value .= '	<td width="33%">&nbsp;</td>' . "\n";
            ++$cycle;
        }
        $TPL_main_value .= '</tr>' . "\n";
    }

    $insql = "(category IN " . $catalist;
    if ($system->SETTINGS['extra_cat'] == 'y') {
        $insql .= " OR secondcat IN " . $catalist;
    }
    $insql = (!$all_items) ? $insql . ") AND" : '';

    // get total number of records
    $query = "SELECT count(*) as COUNT FROM " . $DBPrefix . "auctions
			WHERE " . $insql . " starts <= CURRENT_TIMESTAMP
			AND closed = 0
			AND suspended = 0";
    $params = array();
    if (!empty($_POST['catkeyword'])) {
        $query .= " AND title LIKE :title";
        $params[] = array(':title', '%' . $system->cleanvars($_POST['catkeyword']) . '%', 'str');
    }
    $db->query($query, $params);
    $TOTALAUCTIONS = $db->result('COUNT');

    // Handle pagination
    if (!isset($_GET['PAGE']) || intval($_GET['PAGE']) <= 1 || empty($_GET['PAGE'])) {
        $OFFSET = 0;
        $PAGE = 1;
    } else {
        $PAGE = intval($_GET['PAGE']);
        $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
    }
    $PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);

    $query = "SELECT * FROM " . $DBPrefix . "auctions
			WHERE " . $insql . " starts <= CURRENT_TIMESTAMP
			AND closed = 0
			AND suspended = 0";
    $params = array();
    if (!empty($_POST['catkeyword'])) {
        $query .= " AND title LIKE :title";
        $params[] = array(':title', '%' . $system->cleanvars($_POST['catkeyword']) . '%', 'str');
    }
    $query .= " ORDER BY ends ASC LIMIT :offset, :perpage";
    $params[] = array(':offset', $OFFSET, 'int');
    $params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');

    // get featured items
    $query_feat = "SELECT * FROM " . $DBPrefix . "auctions
			WHERE " . $insql . " starts <= CURRENT_TIMESTAMP
			AND closed = 0
			AND suspended = 0
			AND featured = 1";
    $params_feat = array();
    if (!empty($_POST['catkeyword'])) {
        $query_feat .= " AND title LIKE :title";
        $params_feat[] = array(':title', '%' . $system->cleanvars($_POST['catkeyword']) . '%', 'str');
    }
    $query_feat .= " ORDER BY ends ASC LIMIT :offset, " . $system->SETTINGS['featuredperpage'];
    $params_feat[] = array(':offset', (($PAGE - 1) * $system->SETTINGS['featuredperpage']), 'int');

    include INCLUDE_PATH . 'browseitems.inc.php';
    browseItems($query, $params, $query_feat, $params_feat, $TOTALAUCTIONS, 'browse.php', 'id=' . $id);

    $template->assign_vars(array(
            'ID' => $id,
            'TOP_HTML' => $TPL_main_value,
            'CAT_STRING' => $TPL_categories_string,
            'NUM_AUCTIONS' => $TOTALAUCTIONS
            ));
}

$page_title = $current_cat_name;
include 'header.php';
$template->set_filenames(array(
        'body' => 'browsecats.tpl'
        ));
$template->display('body');
include 'footer.php';
