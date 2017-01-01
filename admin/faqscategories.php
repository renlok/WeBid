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

if (isset($_POST['action'])) {
    // add category
    if ($_POST['action'] == "Insert") {
        if (empty($_POST['cat_name'][$system->SETTINGS['defaultlanguage']])) {
            $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
        } else {
            $query = "INSERT INTO " . $DBPrefix . "faqscategories (category) VALUES (:cat_name)";
            $params = array();
            $params[] = array(':cat_name', $_POST['cat_name'][$system->SETTINGS['defaultlanguage']], 'str');
            $db->query($query, $params);
            $id = $db->lastInsertId();
            foreach ($LANGUAGES as $lang_code) {
                $query = "INSERT INTO " . $DBPrefix . "faqscat_translated VALUES (:cat_id, :lang, :cat_name)";
                $params = array();
                $params[] = array(':cat_id', $id, 'int');
                $params[] = array(':lang', $lang_code, 'str');
                $params[] = array(':cat_name', $_POST['cat_name'][$lang_code], 'str');
                $db->query($query, $params);
            }
        }
    }

    // Delete categories
    if ($_POST['action'] == "Yes" && isset($_POST['delete']) && is_array($_POST['delete'])) {
        foreach ($_POST['delete'] as $k => $v) {
            if ($v == 'delete') {
                // get a list of all faqs within the category
                $query = "SELECT id FROM " . $DBPrefix . "faqs WHERE category = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $k, 'int');
                $db->query($query, $params);
                $ids = '0';
                while ($row = $db->fetch()) {
                    $ids .= ',' . $row['id'];
                }
                // delete faqs in this category
                $query = "DELETE FROM " . $DBPrefix . "faqs WHERE category = :cat_id";
                $params = array();
                $params[] = array(':cat_id', $k, 'int');
                $db->query($query, $params);
                // delete translated faqs in this category
                $query = "DELETE FROM " . $DBPrefix . "faqs_translated WHERE id IN (:id_list)";
                $params = array();
                $params[] = array(':id_list', $ids, 'str');
                $db->query($query, $params);
            } else {
                $move = explode(':', $v);
                $query = "UPDATE " . $DBPrefix . "faqs SET category = :new_cat WHERE category = :old_cat";
                $params = array();
                $params[] = array(':new_cat', $move[1], 'int');
                $params[] = array(':old_cat', $k, 'int');
                $db->query($query, $params);
            }
            // delete the category
            $query = "DELETE FROM " . $DBPrefix . "faqscategories WHERE id = :faq_id";
            $params = array();
            $params[] = array(':faq_id', $k, 'int');
            $db->query($query, $params);
            // delete the translated category
            $query = "DELETE FROM " . $DBPrefix . "faqscat_translated WHERE id = :faq_id";
            $params = array();
            $params[] = array(':faq_id', $k, 'int');
            $db->query($query, $params);
        }
    }

    // delete check
    if ($_POST['action'] == "Delete" && isset($_POST['delete']) && is_array($_POST['delete'])) {
        // get cats FAQs can be moved to
        $delete = implode(',', $_POST['delete']);
        $query = "SELECT category, id FROM " . $DBPrefix . "faqscategories WHERE id NOT IN (:delete_list)";
        $params = array();
        $params[] = array(':delete_list', $delete, 'str');
        $db->query($query, $params);
        $move = '';
        while ($row = $db->fetch()) {
            $move .= '<option value="move:' . $row['id'] . '">' . $MSG['840'] . $row['category'] . '</option>';
        }
        // Get data from the database
        $query = "SELECT COUNT(f.id) as COUNT, c.category, c.id FROM " . $DBPrefix . "faqscategories c
                  LEFT JOIN " . $DBPrefix . "faqs f ON ( f.category = c.id )
                  WHERE c.id IN (:delete_list) GROUP BY c.id ORDER BY category";
        $params = array();
        $params[] = array(':delete_list', $delete, 'int');
        $db->query($query, $params);

        $names = array();
        while ($row = $db->fetch()) {
            $template->assign_block_vars('faqcats', array(
                    'ID' => $row['id'],
                    'CATEGORY' => $row['category'],
                    'COUNT' => $row['COUNT'],
                    'DROPDOWN' => $move
                    ));
            $names[] = $row['category'] . '<input type="hidden" name="delete[' . $row['id'] . ']" value="delete">';
        }
        // build message
        $template->assign_vars(array(
                'ERROR' => (isset($ERR)) ? $ERR : '',
                'CAT_LIST' => implode(', ', $names)
                ));

        $template->set_filenames(array(
                'body' => 'faqcatconfirm.tpl'
                ));
        $template->display('body');
        exit;
    }
}

// Get data from the database
$query = "SELECT COUNT(f.id) as COUNT, c.category, c.id FROM " . $DBPrefix . "faqscategories c
			LEFT JOIN " . $DBPrefix . "faqs f ON ( f.category = c.id )
			GROUP BY c.id ORDER BY category";
$db->direct_query($query);

while ($row = $db->fetch()) {
    $template->assign_block_vars('cats', array(
            'ID' => $row['id'],
            'CATEGORY' => $row['category'],
            'FAQSTXT' => sprintf($MSG['contains_x_faqs'], $row['COUNT']),
            'FAQS' => $row['COUNT']
            ));
}

foreach ($LANGUAGES as $k => $v) {
    $template->assign_block_vars('lang', array(
            'LANG' => $k,
            'B_NODEFAULT' => ($k != $system->SETTINGS['defaultlanguage'])
            ));
}

$template->assign_vars(array(
        'B_ADDCAT' => (isset($_GET['do']) && $_GET['do'] == 'add')
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'faqscategories.tpl'
        ));
$template->display('body');
include 'footer.php';
