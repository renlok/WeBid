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
$current_page = 'banners';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (!isset($_GET['banner'])) {
    header('location: managebanners.php');
    exit;
}

$banner = intval($_GET['banner']);

// Retrieve filters
$query = "SELECT c.cat_name FROM " . $DBPrefix . "bannerscategories b
          LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = b.category)
          WHERE banner = :banner";
$params = array();
$params[] = array(':banner', $banner, 'int');
$db->query($query, $params);

while ($row = $db->fetch()) {
    $template->assign_block_vars('cats', array(
            'CATEGORY' => $row['cat_name']
            ));
}

$query = "SELECT keyword FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner";
$params = array();
$params[] = array(':banner', $banner, 'int');
$db->query($query, $params);

while ($row = $db->fetch()) {
    $template->assign_block_vars('keywords', array(
            'KEYWORD' => $row['keyword']
            ));
}

$template->set_filenames(array(
        'body' => 'viewfilters.tpl'
        ));
$template->display('body');
