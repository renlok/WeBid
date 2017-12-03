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

// Data check
if (!isset($_REQUEST['id'])) {
    header('location: faqscategories.php');
    exit;
}

$id = intval($_GET['id']);

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $user = intval($_POST['user']);
    $query = "UPDATE " . $DBPrefix . "feedbacks SET
              rate = :rate,
              feedback = :feedback
              WHERE id = :feedback_id";
    $params = array();
    $params[] = array(':rate', $_POST['aTPL_rate'], 'int');
    $params[] = array(':feedback', $_POST['TPL_feedback'], 'str');
    $params[] = array(':feedback_id', $id, 'int');
    $db->query($query, $params);

    // Update user's record
    $query = "SELECT SUM(rate) as FSUM, count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks
              WHERE rated_user_id = :user_id";
    $params = array();
    $params[] = array(':user_id', $user, 'int');
    $db->query($query, $params);
    $SUM = $db->result('FSUM');
    $NUM = $db->result('FNUM');

    $query = "UPDATE " . $DBPrefix . "users SET rate_sum = :SUM, rate_num = :NUM WHERE id = :user_id";
    $params = array();
    $params[] = array(':SUM', $SUM, 'int');
    $params[] = array(':NUM', $NUM, 'int');
    $params[] = array(':user_id', $user, 'int');
    $db->query($query, $params);

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['183']));
}

$query = "SELECT u.nick, u.id, f.rater_user_nick, f.feedback, f.rate FROM " . $DBPrefix . "feedbacks f
          LEFT JOIN " . $DBPrefix . "users u ON (u.id = f.rated_user_id) WHERE f.id = :feedback_id";
$params = array();
$params[] = array(':feedback_id', $id, 'int');
$db->query($query, $params);

$feedback = $db->result();

$template->assign_vars(array(
        'RATED_USER' => $feedback['nick'],
        'RATED_USER_ID' => $feedback['id'],
        'RATER_USER' => $feedback['rater_user_nick'],
        'FEEDBACK' => $feedback['feedback'],
        'SEL1' => ($feedback['rate'] == 1),
        'SEL2' => ($feedback['rate'] == 0),
        'SEL3' => ($feedback['rate'] == -1)
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'edituserfeed.tpl'
        ));
$template->display('body');
include 'footer.php';
