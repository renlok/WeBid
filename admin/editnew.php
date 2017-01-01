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

if (!isset($_POST['id']) && (!isset($_GET['id']) || empty($_GET['id']))) {
    header('location: news.php');
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Data check
    if (empty($_POST['title']) || empty($_POST['content'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_112));
    } else {
        // clean up everything
        $news_id = intval($_POST['id']);
        $query = "UPDATE " . $DBPrefix . "news SET
                  title = :title,
                  content = :content,
                  suspended = :suspended
                  WHERE id = :id";
        $params = array();
        $params[] = array(':title', $system->cleanvars($_POST['title'][$system->SETTINGS['defaultlanguage']]), 'str');
        $params[] = array(':content', $system->cleanvars($_POST['content'][$system->SETTINGS['defaultlanguage']], true), 'str');
        $params[] = array(':suspended', $_POST['suspended'], 'int');
        $params[] = array(':id', $news_id, 'int');
        $db->query($query, $params);

        foreach ($LANGUAGES as $k => $v) {
            $query = "SELECT id FROM " . $DBPrefix . "news_translated WHERE lang = :lang AND id = :news_id";
            $params = array();
            $params[] = array(':lang', $k, 'str');
            $params[] = array(':news_id', $news_id, 'int');
            $db->query($query, $params);

            if ($db->numrows() > 0) {
                $query = "UPDATE " . $DBPrefix . "news_translated SET
                          title = :title,
                          content = :content
                          WHERE  lang = :lang AND id = :news_id";
            } else {
                $query = "INSERT INTO " . $DBPrefix . "news_translated VALUES
                          (:news_id, :lang, :title, :content)";
            }
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

// get news story
$query = "SELECT t.*, n.suspended FROM " . $DBPrefix . "news_translated t
          LEFT JOIN " . $DBPrefix . "news n ON (n.id = t.id) WHERE t.id = :id";
$params = array();
$params[] = array(':id', $_GET['id'], 'int');
$db->query($query, $params);

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

while ($arr = $db->fetch()) {
    $suspended = $arr['suspended'];
    $template->assign_block_vars('lang', array(
            'LANG' => $arr['lang'],
            'TITLE' => $arr['title'],
            'CONTENT' => $CKEditor->editor('content[' . $arr['lang'] . ']', $arr['content'])
            ));
}

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TITLE' => $MSG['edit_news'],
        'BUTTON' => $MSG['530'],
        'ID' => intval($_GET['id']),

        'B_ACTIVE' => ((isset($suspended) && $suspended == 0) || !isset($suspended)),
        'B_INACTIVE' => (isset($suspended) && $suspended == 1),
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'addnew.tpl'
        ));
$template->display('body');

include 'footer.php';
