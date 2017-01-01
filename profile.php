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

if (!isset($_GET['user_id'])) {
    if (!$user->checkAuth()) {
        $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
        $_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions.php';
        header('location: user_login.php');
        exit;
    } else {
        $user_id = $user->user_data['id'];
    }
} else {
    $user_id = $_GET['user_id'];
}

if (!is_numeric($user_id)) {
    $query = "SELECT * FROM " . $DBPrefix . "users WHERE nick = :user";
    $params = array();
    $params[] = array(':user', $user_id, 'str');
    $db->query($query, $params);
} else {
    $query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
    $params = array();
    $params[] = array(':user_id', $user_id, 'int');
    $db->query($query, $params);
}

if (@$db->numrows() == 1) {
    $user_data = $db->result();
    $TPL_user_id = $user_data['id'];
    $query = "SELECT icon FROM " . $DBPrefix . "membertypes WHERE feedbacks <= :feedback ORDER BY feedbacks DESC LIMIT 1;";
    $params = array();
    $params[] = array(':feedback', $user_data['rate_sum'], 'int');
    $db->query($query, $params);
    $feedback_icon = $db->result('icon');

    $query = "SELECT f.*, a.user FROM " . $DBPrefix . "feedbacks f
		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = f.auction_id)
		WHERE f.rated_user_id = :user_id";
    $params = array();
    $params[] = array(':user_id', $TPL_user_id, 'int');
    $db->query($query, $params);

    // TODO: clean this up should be able to do this with just mysql
    $total_fb = 0;
    $fb = array(-1 => 0, 0 => 0, 1 => 0);
    $fb_as_seller = array(-1 => 0, 0 => 0, 1 => 0);
    $fb_as_buyer = array(-1 => 0, 0 => 0, 1 => 0);
    $fb_last_year = array(-1 => 0, 0 => 0, 1 => 0);
    $fb_last_3month = array(-1 => 0, 0 => 0, 1 => 0);
    $fb_last_month = array(-1 => 0, 0 => 0, 1 => 0);
    if ($db->numrows() > 0) {
        while ($ratesum = $db->fetch()) {
            $fb[$ratesum['rate']]++;
            $total_fb++;
            if ($ratesum['user'] == $TPL_user_id) {
                $fb_as_seller[$ratesum['rate']]++;
            } else {
                $fb_as_buyer[$ratesum['rate']]++;
            }
            $feedbackdate = new DateTime($ratesum['feedbackdate'], $dt->UTCtimezone);
            if ($feedbackdate > new DateTime('- 1 year', $dt->UTCtimezone)) {
                $fb_last_year[$ratesum['rate']]++;
            }
            if ($feedbackdate > new DateTime('- 3 month', $dt->UTCtimezone)) {
                $fb_last_3month[$ratesum['rate']]++;
            }
            if ($feedbackdate > new DateTime('- 1 month', $dt->UTCtimezone)) {
                $fb_last_month[$ratesum['rate']]++;
            }
        }
    }

    $DATE = strtotime($user_data['reg_date']);
    $mth = 'MON_0'.date('m', $DATE);

    $feedback_rate = ($user_data['rate_sum'] == 0) ? 1 : $user_data['rate_sum'];
    $feedback_rate = ($feedback_rate < 0) ? $feedback_rate * - 1 : $feedback_rate;
    $total_fb = ($total_fb < 1) ? 1 : $total_fb;
    $variables = array(
        'FB_ICON' => $feedback_icon,
        'NUM_FB' => $user_data['rate_num'],
        'SUM_FB' => $user_data['rate_sum'],
        'FB_POS' => (isset($fb[1])) ? '<span style="color:green">' .$MSG['500'] . $fb[1] . ' (' . ceil($fb[1] * 100 / $total_fb) . '%)</span><br>' : '',
        'FB_NEUT' => (isset($fb[0])) ? $MSG['499'] . $fb[0] . ' (' . ceil($fb[0] * 100 / $total_fb) . '%)<br>' : '',
        'FB_NEG' => (isset($fb[ - 1])) ? '<span style="color:red">' . $MSG['501'] . $fb[ - 1] . ' (' . ceil($fb[ - 1] * 100 / $total_fb) . '%)</span>' : '',
        'FB_SELLER_POS' => $fb_as_seller[1],
        'FB_BUYER_POS' => $fb_as_buyer[1],
        'FB_LASTYEAR_POS' => $fb_last_year[1],
        'FB_LAST3MONTH_POS' => $fb_last_3month[1],
        'FB_LASTMONTH_POS' => $fb_last_month[1],
        'FB_SELLER_NEUT' => $fb_as_seller[0],
        'FB_BUYER_NEUT' => $fb_as_buyer[0],
        'FB_LASTYEAR_NEUT' => $fb_last_year[0],
        'FB_LAST3MONTH_NEUT' => $fb_last_3month[0],
        'FB_LASTMONTH_NEUT' => $fb_last_month[0],
        'FB_SELLER_NEG' => $fb_as_seller[-1],
        'FB_BUYER_NEG' => $fb_as_buyer[-1],
        'FB_LASTYEAR_NEG' => $fb_last_year[-1],
        'FB_LAST3MONTH_NEG' => $fb_last_3month[-1],
        'FB_LASTMONTH_NEG' => $fb_last_month[-1],
        'REGSINCE' => $MSG[$mth] . ' ' . date('d, Y', $DATE),
        'COUNTRY' => $user_data['country'],
        'AUCTION_ID' => (isset($_GET['auction_id'])) ? $_GET['auction_id'] : '',
        'USER' => $user_data['nick'],
        'USER_ID' => $TPL_user_id,
        'B_VIEW' => true,
        'B_AUCID' => (isset($_GET['auction_id'])),
        'B_CONTACT' => (($system->SETTINGS['contactseller'] == 'always' || ($system->SETTINGS['contactseller'] == 'logged' && $user->logged_in)) && (!$user->logged_in || $user->user_data['id'] != $TPL_user_id))
        );
} else {
    $variables = array(
        'B_VIEW' => false,
        'MSG' => $ERR_025
        );
}

$template->assign_vars($variables);

include 'header.php';
$template->set_filenames(array(
        'body' => 'profile.tpl'
        ));
$template->display('body');
include 'footer.php';
