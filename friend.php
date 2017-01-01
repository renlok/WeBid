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

// check recaptcha is enabled
if ($system->SETTINGS['spam_sendtofriend'] == 2) {
    include PACKAGE_PATH . 'recaptcha/recaptcha.php';
} elseif ($system->SETTINGS['spam_sendtofriend'] == 1) {
    include PACKAGE_PATH . 'captcha/securimage.php';
}

if (isset($_REQUEST['id'])) {
    $_SESSION['CURRENT_ITEM'] = intval($_REQUEST['id']);
}

$id = $_SESSION['CURRENT_ITEM'];

$TPL_error_text = '';
$emailsent = 1;
// Get item data
$query = "SELECT title, category FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
$params = array();
$params[] = array(':auc_id', $id, 'int');
$db->query($query, $params);
if ($db->numrows() > 0) {
    $TPL_item_title = $db->result('title');
} else {
    $_SESSION['msg_title'] = $ERR_622;
    $_SESSION['msg_body'] = $ERR_623;
    header('location: message.php');
    exit;
}

$spam_html = '';
if ($system->SETTINGS['spam_sendtofriend'] == 1) {
    $resp = new Securimage();
    $spam_html = $resp->getCaptchaHtml();
}

if (isset($_POST['action']) && $_POST['action'] == 'sendmail') {
    // check errors
    if (empty($_POST['sender_name']) || empty($_POST['sender_email']) || empty($_POST['friend_name']) || empty($_POST['friend_email'])) {
        $TPL_error_text = $ERR_031;
    }

    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['sender_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['friend_email'])) {
        $TPL_error_text = $ERR_008;
    }

    if ($system->SETTINGS['spam_sendtofriend'] == 2) {
        $resp = recaptcha_check_answer($system->SETTINGS['recaptcha_private'], $_POST['g-recaptcha-response']);
        if (!$resp) {
            $TPL_error_text = $MSG['752'];
        }
    } elseif ($system->SETTINGS['spam_sendtofriend'] == 1) {
        if (!$resp->check($_POST['captcha_code'])) {
            $TPL_error_text = $MSG['752'];
        }
    }


    if (!empty($TPL_error_text)) {
        $emailsent = 1;
    } else {
        $emailsent = 0;
        $emailer = new email_handler();
        $emailer->assign_vars(array(
                'S_NAME' => $_POST['sender_name'],
                'S_EMAIL' => $_POST['sender_email'],
                'S_COMMENT' => $_POST['sender_comment'],
                'F_NAME' => $_POST['friend_name'],
                'TITLE' => $TPL_item_title,
                'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $id,
                'SITENAME' => $system->SETTINGS['sitename'],
                'SITEURL' => $system->SETTINGS['siteurl'],
                'ADMINEMAIL' => $system->SETTINGS['adminmail']
                ));
        $emailer->email_sender($_POST['friend_email'], 'friendmail.inc.php', $MSG['905']);
    }
}

if ($system->SETTINGS['spam_sendtofriend'] == 2) {
    $capcha_text = recaptcha_get_html($system->SETTINGS['recaptcha_public']);
} elseif ($system->SETTINGS['spam_sendtofriend'] == 1) {
    $capcha_text = $spam_html;
}

$template->assign_vars(array(
        'ERROR' => $TPL_error_text,
        'ID' => intval($_REQUEST['id']),
        'CAPTCHATYPE' => $system->SETTINGS['spam_sendtofriend'],
        'CAPCHA' => (isset($capcha_text)) ? $capcha_text : '',
        'TITLE' => $TPL_item_title,
        'FRIEND_NAME' => (isset($_POST['friend_name'])) ? $system->cleanvars($_POST['friend_name']) : '',
        'FRIEND_EMAIL' => (isset($_POST['friend_email'])) ?  $system->cleanvars($_POST['friend_email']) : '',
        'YOUR_NAME' => ($user->logged_in) ? $system->cleanvars($user->user_data['name']) : '',
        'YOUR_EMAIL' => ($user->logged_in) ? $system->cleanvars($user->user_data['email']) : '',
        'COMMENT' => (isset($_POST['sender_comment'])) ? $system->cleanvars($_POST['sender_comment']) : '',
        'EMAILSENT' => $emailsent
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'friend.tpl'
        ));
$template->display('body');
include 'footer.php';
