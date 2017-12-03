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

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$catscontrol = new MPTTcategories();

function search_cats()
{
    global $catscontrol;

    $root = $catscontrol->get_virtual_root();
    $tree = $catscontrol->display_tree($root['left_id'], $root['right_id'], '|___');
    return $tree;
}

function rebuild_cat_file()
{
    global $system, $DBPrefix, $db;
    $query = "SELECT cat_id, cat_name, parent_id FROM " . $DBPrefix . "categories ORDER BY cat_name";
    $db->direct_query($query);
    $cats = array();
    while ($catarr = $db->fetch()) {
        $cats[$catarr['cat_id']] = $catarr['cat_name'];
        $allcats[] = $catarr;
    }

    $output = "<?php\n";
    $output .= "$" . "category_names = " . var_export($cats, true) . ";\n\n";
    $output .= "$" . "category_plain = " . var_export(search_cats(), true) . ";\n";

    $handle = fopen(MAIN_PATH . 'language/' . $system->SETTINGS['defaultlanguage'] . '/categories.inc.php', 'w');
    fputs($handle, $output);
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == "Process") {
        //update all categories that arnt being deleted
        if (isset($_POST['categories']) && is_array($_POST['categories'])) {
            foreach ($_POST['categories'] as $k => $v) {
                if (!isset($_POST['delete'][$k])) {
                    $query = "UPDATE " . $DBPrefix . "categories SET
                            cat_name = :name,
                            cat_colour = :colour,
                            cat_image = :image
                            WHERE cat_id = :cat_id";
                    $params = array();
                    $params[] = array(':name', $_POST['categories'][$k], 'str');
                    $params[] = array(':colour', $_POST['colour'][$k], 'str');
                    $params[] = array(':image', $_POST['image'][$k], 'str');
                    $params[] = array(':cat_id', $k, 'int');
                    $db->query($query, $params);
                }
            }
        }
        //add category if need be
        if (!empty($_POST['new_category']) && isset($_POST['parent'])) {
            $add_data = array(
                'cat_name' => $_POST['new_category'],
                'cat_colour' => $_POST['cat_colour'],
                'cat_image' => $_POST['cat_image']
                );
            $catscontrol->add($_POST['parent'], 0, $add_data);
        }
        if (!empty($_POST['mass_add']) && isset($_POST['parent'])) {
            $add = explode("\n", $_POST['mass_add']);
            if (is_array($add)) {
                foreach ($add as $v) {
                    $add_data = array('cat_name' => $v);
                    $catscontrol->add($_POST['parent'], 0, $add_data);
                }
            }
        }
        if (isset($_POST['delete']) && is_array($_POST['delete'])) {
            // Get data from the database
            $query = "SELECT COUNT(a.id) as COUNT, c.* FROM " . $DBPrefix . "categories c
                    LEFT JOIN " . $DBPrefix . "auctions a ON ( a.category = c.cat_id )
                    WHERE c.cat_id IN (" . implode(',', $_POST['delete']) . ")
                    GROUP BY c.cat_id ORDER BY cat_name";
            $db->direct_query($query);

            while ($row = $db->fetch()) {
                $template->assign_block_vars('categories', array(
                        'ID' => $row['cat_id'],
                        'NAME' => $row['cat_name'],
                        'HAS_CHILDREN' => ($row['COUNT'] > 0 || $row['left_id'] != ($row['right_id'] - 1))
                        ));
            }
            // build message
            $template->assign_vars(array(
                    'ERROR' => (isset($ERR)) ? $ERR : ''
                    ));

            $template->set_filenames(array(
                    'body' => 'categoryconfirm.tpl'
                    ));
            $template->display('body');
            include 'footer.php';
            exit;
        }
        rebuild_cat_file();
        include 'util_cc1.php';
    }

    if ($_POST['action'] == "Yes") {
        //delete categories that are selected
        if (isset($_POST['delete']) && is_array($_POST['delete'])) {
            foreach ($_POST['delete'] as $k => $v) {
                $k = intval($k);
                if ($v == 'delete') {
                    //never delete categories without using this function it will mess up your database big time
                    $catscontrol->delete($k);
                } elseif ($v == 'move') {
                    if (isset($_POST['moveid'][$k]) && !empty($_POST['moveid'][$k])
                        && is_numeric($_POST['moveid'][$k]) && $catscontrol->check_category($_POST['moveid'][$k])) {
                        // first move the parent
                        $catscontrol->move($k, $_POST['moveid'][$k]);
                        // remove the parent and raise the children up a level
                        $catscontrol->delete($k, true);
                        $query = "UPDATE " . $DBPrefix . "auctions SET category = :cat_new WHERE category = :cat_old";
                        $params = array();
                        $params[] = array(':cat_new', $_POST['moveid'][$k], 'str');
                        $params[] = array(':cat_old', $k, 'int');
                        $db->query($query, $params);
                    } else {
                        $ERR = $MSG['move_category_missing_id'];
                    }
                }
            }
        }
        rebuild_cat_file();
        resync_category_counters();
        include 'util_cc1.php';
    }
    if (isset($ERR)) {
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $ERR));
    }
}

//show the page
if (!isset($_GET['parent'])) {
    $query = "SELECT left_id, right_id, level, cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -1";
    $params = array();
} else {
    $parent = intval($_GET['parent']);
    $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :parent_id";
    $params = array();
    $params[] = array(':parent_id', $parent, 'int');
}
$db->query($query, $params);
$parent_node = $db->result();

if (!isset($_GET['parent'])) {
    $parent = $parent_node['cat_id'];
}

$crumb_string = '';
if ($parent != 0) {
    $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
    for ($i = 0; $i < count($crumbs); $i++) {
        $template->assign_block_vars('crumbs', array(
            'CAT_ID' => $crumbs[$i]['cat_id'],
            'CAT_NAME' => $crumbs[$i]['cat_name']
        ));
    }
}

$children = $catscontrol->get_children($parent_node['left_id'], $parent_node['right_id'], $parent_node['level']);
for ($i = 0; $i < count($children); $i++) {
    $child = $children[$i];
    $template->assign_block_vars('cats', array(
            'CAT_ID' => $child['cat_id'],
            'CAT_NAME' => htmlspecialchars($child['cat_name']),
            'CAT_COLOUR' => $child['cat_colour'],
            'CAT_IMAGE' => $child['cat_image'],

            'B_SUBCATS' => ($child['left_id'] != ($child['right_id'] - 1)),
            'B_AUCTIONS' => ($child['counter'] > 0)
            ));
}

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'CRUMBS' => $crumb_string,
        'PARENT' => $parent
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'categories.tpl'
        ));
$template->display('body');
include 'footer.php';
