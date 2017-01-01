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

// If user is not logged in redirect to login page
if (!$user->checkAuth()) {
    header("location: user_login.php");
    exit;
}

// check recaptcha is enabled
if ($system->SETTINGS['spam_reportitem'] == 2) {
    include PACKAGE_PATH . 'recaptcha/recaptcha.php';
} elseif ($system->SETTINGS['spam_reportitem'] == 1) {
    include PACKAGE_PATH . 'captcha/securimage.php';
}

if (isset($_REQUEST['id'])) {
    $_SESSION['CURRENT_ITEM'] = intval($_REQUEST['id']);
}

$id = $_SESSION['CURRENT_ITEM'];

$TPL_error_text = '';
$itemreported = 1;
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
if ($system->SETTINGS['spam_reportitem'] == 1) {
    $resp = new Securimage();
    $spam_html = $resp->getCaptchaHtml();
}

if (isset($_POST['action']) && $_POST['action'] == 'reportitem') {
    // check errors
    if (empty($_POST['reason']) || (isset($_POST['reason']) && $_POST['reason'] == '0')) {
        $TPL_error_text = $ERR_INVALID_REPORT_REASON;
    }

    $auction_id = intval($_POST['id']);

    if ($system->SETTINGS['spam_reportitem'] == 2) {
        $resp = recaptcha_check_answer($system->SETTINGS['recaptcha_private'], $_POST['g-recaptcha-response']);
        if (!$resp) {
            $TPL_error_text = $MSG['752'];
        }
    } elseif ($system->SETTINGS['spam_reportitem'] == 1) {
        if (!$resp->check($_POST['captcha_code'])) {
            $TPL_error_text = $MSG['752'];
        }
    }

    $query = "INSERT INTO " . $DBPrefix . "reportedauctions
			(auction_id, reason, user_id)
			VALUES
			(:auction_id, :reason, :user_id);";
    $params = array();
    $params[] = array(':auction_id', $auction_id, 'int');
    $params[] = array(':reason', $_POST['reason'], 'str');
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);
    if (!empty($TPL_error_text)) {
        $itemreported = 1;
    } else {
        $itemreported = 0;
    }
}

if ($system->SETTINGS['spam_reportitem'] == 2) {
    $capcha_text = recaptcha_get_html($system->SETTINGS['recaptcha_public']);
} elseif ($system->SETTINGS['spam_reportitem'] == 1) {
    $capcha_text = $spam_html;
}

$template->assign_vars(array(
        'ERROR' => $TPL_error_text,
        'ID' => intval($_REQUEST['id']),
        'CAPTCHATYPE' => $system->SETTINGS['spam_reportitem'],
        'CAPCHA' => (isset($capcha_text)) ? $capcha_text : '',
        'TITLE' => $TPL_item_title,
        'ITEMREPORTED' => $itemreported
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'item_report.tpl'
        ));
$template->display('body');
include 'footer.php';
