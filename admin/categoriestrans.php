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

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : $system->SETTINGS['defaultlanguage'];
$catscontrol = new MPTTcategories();

function search_cats()
{
    global $catscontrol;
    $catstr = '';
    $root = $catscontrol->get_virtual_root();
    $tree = $catscontrol->display_tree($root['left_id'], $root['right_id'], '|___');
    foreach ($tree as $k => $v) {
        $v = str_replace("'", "\'", $v);
        $catstr .= ",\n" . $k . " => '" . addslashes($v) . "'";
    }
    return $catstr;
}

function rebuild_cat_file($cats)
{
    global $lang;
    $output = "<?php\n";
    $output.= "$" . "category_names = array(\n";

    $num_rows = count($cats);

    $i = 0;
    foreach ($cats as $k => $v) {
        $v = str_replace("'", "\'", $v);
        $output .= "$k => '$v'";
        $i++;
        if ($i < $num_rows) {
            $output .= ",\n";
        } else {
            $output .= "\n";
        }
    }

    $output .= ");\n\n";

    $output .= "$" . "category_plain = array(\n0 => ''";

    $output .= search_cats();

    $output .= ");";

    $handle = fopen(MAIN_PATH . 'language/' . $lang . '/categories.inc.php', 'w');
    fputs($handle, $output);
    fclose($handle);
}

if (isset($_POST['categories'])) {
    rebuild_cat_file($_POST['categories']);
    include 'util_cc1.php';
}

include MAIN_PATH . 'language/' . $lang . '/categories.inc.php';

$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories ORDER BY cat_name";
$db->direct_query($query);
while ($row = $db->fetch()) {
    // set category data
    $template->assign_block_vars('cats', array(
            'CAT_ID' => $row['cat_id'],
            'CAT_NAME' => htmlspecialchars($row['cat_name']),
            'TRAN_CAT' => isset($category_names[$row['cat_id']])? $category_names[$row['cat_id']] : ''
            ));
}

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'categoriestrans.tpl'
        ));
$template->display('body');
include 'footer.php';
