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
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';
include PACKAGE_PATH . 'ckeditor/ckeditor.php';

$subject = (isset($_POST['subject'])) ? $_POST['subject'] : '';
$content = (isset($_POST['content'])) ? $_POST['content'] : '';
$is_preview = false;

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    if (empty($subject) || empty($content)) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_subject_or_body_missing']));
    } else {
        $COUNTER = 0;
        $query = "SELECT email FROM " . $DBPrefix . "users WHERE nletter = 1";
        switch ($_POST['usersfilter']) {
            case 'active':
                $query .= ' AND suspended = 0';
                break;
            case 'admin':
                $query .= ' AND suspended = 1';
                break;
            case 'fee':
                $query .= ' AND suspended = 9';
                break;
            case 'confirmed':
                $query .= ' AND suspended = 8';
                break;
        }
        $headers = 'From:' . $system->SETTINGS['sitename'] . ' <' . $system->SETTINGS['adminmail'] . '>' . "\n" . 'Content-Type: text/html; charset=' . $CHARSET;
        $db->direct_query($query);
        while ($row = $db->fetch()) {
            if (mail($row['email'], $subject, $content, $headers)) {
                $COUNTER++;
            }
        }
        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => sprintf($MSG['5300'], $COUNTER)));
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'preview') {
    $is_preview = true;
}

$USERSFILTER = array('all' => $MSG['all_users'],
    'active' => $MSG['active_users'],
    'admin' => $MSG['suspended_by_admin'],
    'fee' => $MSG['signup_fee_unpaid'],
    'confirmed' => $MSG['account_never_confirmed']);

$selectsetting = (isset($_POST['usersfilter'])) ? $_POST['usersfilter'] : '';

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

$template->assign_vars(array(
        'SELECTBOX' => generateSelect('usersfilter', $USERSFILTER),
        'SUBJECT' => $subject,
        'EDITOR' => $CKEditor->editor('content', $content),
        'PREVIEW' => $content,

        'B_PREVIEW' => $is_preview
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'newsletter.tpl'
        ));
$template->display('body');
include 'footer.php';
