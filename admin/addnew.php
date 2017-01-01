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

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Data check
    if (!isset($_POST['title']) || !isset($_POST['content'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_112));
    } else {
        $query = "INSERT INTO " . $DBPrefix . "news (title, content, suspended)
                  VALUES (:title, :content, :suspended)";
        $params = array();
        $params[] = array(':title', $system->cleanvars($_POST['title'][$system->SETTINGS['defaultlanguage']]), 'str');
        $params[] = array(':content', $system->cleanvars($_POST['content'][$system->SETTINGS['defaultlanguage']], true), 'str');
        $params[] = array(':suspended', $_POST['suspended'], 'int');
        $db->query($query, $params);
        $news_id = $db->lastInsertId();

        // Insert into translation table
        foreach ($LANGUAGES as $k => $v) {
            $query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (:news_id, :lang, :title, :content)";
            $params = array();
            $params[] = array(':title', $system->cleanvars($_POST['title'][$k]), 'str');
            $params[] = array(':content', $system->cleanvars($_POST['content'][$k], true), 'str');
            $params[] = array(':lang', $k, 'str');
            $params[] = array(':news_id', $news_id, 'int');
            $db->query($query, $params);
        }
        header('location: news.php');
        exit;
    }
}

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

foreach ($LANGUAGES as $k => $language) {
    $template->assign_block_vars('lang', array(
            'LANG' => $language,
            'TITLE' => (isset($_POST['title'][$k])) ? $_POST['title'][$k] : '',
            'CONTENT' => $CKEditor->editor('content[' . $k . ']', (isset($_POST['content'][$k]) ? $_POST['content'][$k] : ''))
            ));
}

$template->assign_vars(array(
        'TITLE' => $MSG['518'],
        'BUTTON' => $MSG['518'],
        'ID' => '', // inserting new user so needs to be blank

        'B_ACTIVE' => ((isset($_POST['suspended']) && $_POST['suspended'] == 0) || !isset($_POST['suspended'])),
        'B_INACTIVE' => (isset($_POST['suspended']) && $_POST['suspended'] == 1)
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'addnew.tpl'
        ));
$template->display('body');
include 'footer.php';
