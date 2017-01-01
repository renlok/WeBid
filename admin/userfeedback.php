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

$secid = intval($_GET['id']);
$query = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $secid, 'int');
$db->query($query, $params);

if ($db->numrows() > 0) {
    $arr = $db->result();
    $num_fbs = $arr['rate_num'];
    // get page limits
    if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '') {
        $OFFSET = 0;
        $PAGE = 1;
    } else {
        $PAGE = intval($_GET['PAGE']);
        $OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
    }
    $PAGES = ($num_fbs == 0) ? 1 : ceil($num_fbs / $system->SETTINGS['perpage']);

    $query = "SELECT icon FROM " . $DBPrefix . "membertypes WHERE feedbacks <= :feedback ORDER BY feedbacks DESC LIMIT 1;";
    $params = array();
    $params[] = array(':feedback', $arr['rate_sum'], 'int');
    $db->query($query, $params);
    $feedback_icon = $db->result('icon');

    $query = "SELECT * FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = " . $secid . " ORDER by feedbackdate DESC";
    $params = array();
    $params[] = array(':user_id', $secid, 'int');
    $db->query($query, $params);
    while ($arrfeed = $db->fetch()) {
        switch ($arrfeed['rate']) {
            case 1:
                $fb_type = 'positive';
                break;
            case -1:
                $fb_type = 'negative';
                break;
            case 0:
                $fb_type = 'neutral';
                break;
        }

        $template->assign_block_vars('feedback', array(
                'FB_TYPE' => $fb_type,
                'FB_FROM' => $arrfeed['rater_user_nick'],
                'FB_TIME' => $dt->formatDate($arrfeed['feedbackdate']),
                'FB_MSG' => nl2br($arrfeed['feedback']),
                'FB_ID' => $arrfeed['id']
                ));
    }
} else {
    $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_105));
}

$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1) {
    $LOW = $PAGE - 5;
    if ($LOW <= 0) {
        $LOW = 1;
    }
    $COUNTER = $LOW;
    while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6)) {
        $template->assign_block_vars('pages', array(
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/userfeedback.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$_SESSION['RETURN_LIST'] = 'userfeedback.php?id=' . $secid;
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$template->assign_vars(array(
        'ID' => $secid,
        'NICK' => $arr['nick'],
        'FB_NUM' => $arr['rate_num'],
        'FB_ICON' => $feedback_icon,

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/userfeedback.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/userfeedback.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'userfeedback.tpl'
        ));
$template->display('body');
include 'footer.php';
