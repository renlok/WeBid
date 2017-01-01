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
$current_page = 'contents';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['delete']) && is_array($_POST['delete'])) {
    foreach ($_POST['delete'] as $val) {
        $params = array();
        $params[] = array(':faq_id', $val, 'int');
        $query = "DELETE FROM " . $DBPrefix . "faqs WHERE id = :faq_id";
        $db->query($query, $params);
        $query = "DELETE FROM " . $DBPrefix . "faqs_translated WHERE id = :faq_id";
        $db->query($query, $params);
    }
    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['faqs_deleted']));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqscategories  ORDER BY category";
$db->direct_query($query);
$faq_cats = $db->fetchall();
foreach ($faq_cats as $row) {
    $template->assign_block_vars('cats', array(
            'CAT' => $row['category']
            ));

    $query = "SELECT id, question FROM " . $DBPrefix . "faqs WHERE category = :cat_id";
    $params = array();
    $params[] = array(':cat_id', $row['id'], 'int');
    $db->query($query, $params);
    while ($cat_row = $db->fetch()) {
        $template->assign_block_vars('cats.faqs', array(
                'ID' => $cat_row['id'],
                'FAQ' => $cat_row['question']
                ));
    }
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'faqs.tpl'
        ));
$template->display('body');
include 'footer.php';
