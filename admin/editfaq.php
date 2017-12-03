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
include PACKAGE_PATH . 'ckeditor/ckeditor.php';

// Data check
if (!isset($_REQUEST['id'])) {
    header('location: faqs.php');
    exit;
}

// Update message
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if (empty($_POST['question'][$system->SETTINGS['defaultlanguage']])
        || empty($_POST['answer'][$system->SETTINGS['defaultlanguage']])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_067));
        $faq = $_POST;
    } else {
        $query = "UPDATE " . $DBPrefix . "faqs SET category = :category,
                  question = :question,
                  answer = :answer
                  WHERE id = :faq_id";
        $params = array();
        $params[] = array(':category', $_POST['category'], 'int');
        $params[] = array(':question', $_POST['question'][$system->SETTINGS['defaultlanguage']], 'str');
        $params[] = array(':answer', $system->cleanvars($_POST['answer'][$system->SETTINGS['defaultlanguage']], true), 'str');
        $params[] = array(':faq_id', $_POST['id'], 'int');
        $db->query($query, $params);
        foreach ($LANGUAGES as $lang_code) {
            $query = "SELECT question FROM " . $DBPrefix . "faqs_translated WHERE lang = :lang AND id = :faq_id";
            $params = array();
            $params[] = array(':lang', $lang_code, 'str');
            $params[] = array(':faq_id', $_POST['id'], 'int');
            $db->query($query, $params);
            $params = array();
            $params[] = array(':lang', $lang_code, 'str');
            $params[] = array(':question', $_POST['question'][$lang_code], 'str');
            $params[] = array(':answer', $system->cleanvars($_POST['answer'][$lang_code]), 'str');
            if ($db->numrows() > 0) {
                $query = "UPDATE " . $DBPrefix . "faqs_translated SET
                          question = :question,
                          answer = :answer
                          WHERE id = :faq_id AND lang = :lang";
            } else {
                $query = "INSERT INTO " . $DBPrefix . "faqs_translated VALUES
                          (:faq_id, :lang, :question, :answer)";
                $params[] = array(':faq_id', $_POST['id'], 'int');
            }
            $db->query($query, $params);
        }
        header('location: faqs.php');
        exit;
    }
}

// load categories
$query = "SELECT * FROM " . $DBPrefix . "faqscategories ORDER BY category";
$db->direct_query($query);
while ($row = $db->fetch()) {
    $template->assign_block_vars('cats', array(
            'ID' => $row['id'],
            'CAT' => $row['category']
            ));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqs_translated WHERE id = :faq_id";
$params = array();
$params[] = array(':faq_id', $_GET['id'], 'int');
$db->query($query, $params);
while ($row = $db->fetch()) {
    $QUESTION_tr[$row['lang']] = $row['question'];
    $ANSWER_tr[$row['lang']] = $row['answer'];
}

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

foreach ($LANGUAGES as $lang_code) {
    $template->assign_block_vars('qs', array(
            'LANG' => $lang_code,
            'QUESTION' => (isset($_POST['question'][$lang_code])) ? $_POST['question'][$lang_code] : (isset($QUESTION_tr[$lang_code])? $QUESTION_tr[$lang_code] : '')
            ));
    $answer = (isset($_POST['answer'][$lang_code])) ? $_POST['answer'][$lang_code] : (isset($ANSWER_tr[$lang_code]) ? $ANSWER_tr[$lang_code] : '');
    $template->assign_block_vars('as', array(
            'LANG' => $lang_code,
            'ANSWER' => $CKEditor->editor('answer[' . $lang_code . ']', $answer)
            ));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqs WHERE id = :faq_id";
$params = array();
$params[] = array(':faq_id', $_GET['id'], 'int');
$db->query($query, $params);
$faq = $db->result();

$template->assign_vars(array(
        'ID' => $faq['id'],
        'FAQ_NAME' => $faq['question'],
        'FAQ_CAT' => $faq['category']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'editfaq.tpl'
        ));
$template->display('body');

include 'footer.php';
