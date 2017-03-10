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

if (!$user->checkAuth()) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourfeedback.php';
    header('location: user_login.php');
    exit;
}

$query = "SELECT icon FROM " . $DBPrefix . "membertypes WHERE feedbacks <= :feedback ORDER BY feedbacks DESC LIMIT 1;";
$params = array();
$params[] = array(':feedback', $user->user_data['rate_sum'], 'int');
$db->query($query, $params);
$feedback_icon = $db->result('icon');

$page = (isset($_GET['pg']) && intval($_GET['pg']) > 0) ? $_GET['pg'] : 1;
$left_limit = ($page - 1) * $system->SETTINGS['perpage'];

$query = "SELECT count(*) As COUNT FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :user_id";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$total = $db->result('COUNT');
// get number of pages
$pages = ceil($total / $system->SETTINGS['perpage']);

$left_limit = ($left_limit < 0) ? 0 : $left_limit;

$query = "SELECT feedbacks, icon FROM " . $DBPrefix . "membertypes ORDER BY feedbacks DESC;";
$db->direct_query($query);
$membertypes = $db->fetchAll();

$query = "SELECT f.*, a.title, u.rate_sum, w.winner FROM " . $DBPrefix . "feedbacks f
	LEFT OUTER JOIN " . $DBPrefix . "auctions a ON (a.id = f.auction_id)
	LEFT JOIN " . $DBPrefix . "users u ON (u.id = f.rated_user_id)
	LEFT JOIN " . $DBPrefix . "winners w ON (w.auction = a.id)
	WHERE rated_user_id = :user_id
	ORDER by feedbackdate DESC
	LIMIT :left_limit, :perpage";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':left_limit', $left_limit, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

$i = 0;
$feed_disp = array();
while ($arrfeed = $db->fetch()) {
    foreach ($membertypes as $membertype) {
        if ($membertype['feedbacks'] >= $arrfeed['rate_sum']) {
            $user_feedback_icon = $membertype['icon'];
            break;
        }
    }
    switch ($arrfeed['rate']) {
        case 1: $uimg = $system->SETTINGS['siteurl'] . 'images/positive.png';
            break;
        case - 1: $uimg = $system->SETTINGS['siteurl'] . 'images/negative.png';
            break;
        case 0: $uimg = $system->SETTINGS['siteurl'] . 'images/neutral.png';
            break;
    }
    $template->assign_block_vars('fbs', array(
            'BGCOLOUR' => (!(($i + 1) % 2)) ? '' : 'class="alt-row"',
            'IMG' => $uimg,
            'USFLINK' => 'profile.php?user_id=' . $arrfeed['winner'] . '&auction_id=' . $arrfeed['auction_id'],
            'USERNAME' => $arrfeed['rater_user_nick'],
            'USFEED' => $arrfeed['rate_sum'],
            'FB_ICON' => $user_feedback_icon,
            'FBDATE' => $dt->formatDate($arrfeed['feedbackdate']),
            'AUCTION_TITLE' => htmlspecialchars($arrfeed['title']),
            'AUCTION_ID' => $arrfeed['auction_id'],
            'FEEDBACK' => nl2br($arrfeed['feedback'])
            ));

    $i++;
}

// get pagenation
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
                'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourfeedback.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
                ));
        $COUNTER++;
    }
}

$template->assign_vars(array(
        'USERNICK' => $user->user_data['nick'],
        'USERFB' => $user->user_data['rate_sum'],
        'USER_FB_ICON' => $feedback_icon,

        'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourfeedback.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
        'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourfeedback.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
        'PAGE' => $PAGE,
        'PAGES' => $PAGES,

        'BGCOLOUR' => (!(($i + 1) % 2)) ? '' : 'class="alt-row"'
        ));

include 'header.php';
$TMP_usmenutitle = $MSG['25_0223'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
        'body' => 'yourfeedback.tpl'
        ));
$template->display('body');
include 'footer.php';
