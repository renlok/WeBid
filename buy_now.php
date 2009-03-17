<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'includes/config.inc.php';
include $include_path . "membertypes.inc.php";
foreach($membertypes as $idm => $memtypearr) {
    $memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}

if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("location: user_login.php");
    exit;
}

if ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on') {
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
    header('Location: ' . $sslurl . 'buy_now.php');
    exit;
}

ksort($memtypesarr, SORT_NUMERIC);
$NOW = time();
$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id=" . intval($_REQUEST['id']);
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);

if (mysql_result ($result, 0, "closed") == 1) {
    header("Location: item.php?id=" . $_REQUEST['id']);
    exit;
}
$user = mysql_result($result, 0, "user");
$title = mysql_result($result, 0, "title");
$buy_now_only = mysql_result($result, 0, "bn_only");
$buy_now_price = mysql_result($result, 0, "buy_now");
$reserve_price = mysql_result($result, 0, "reserve_price");
$category = mysql_result($result, 0, "category");
$quantity = mysql_result($result, 0, "quantity");
$num_bids = mysql_result($result, 0, "num_bids");
$current_bid = mysql_result($result, 0, "current_bid");
// If there are bids for this auction -> error
if ($buy_now_only == 'n') {
    if (!($buy_now_price > 0 && ($num_bids == 0 || ($reserve_price > 0 && $current_bid < $reserve_price) || ($current_bid < $buy_now_price)))) {
        $ERR = '712';
    } else {
        $query = "SELECT MAX(bid) AS maxbid FROM " . $DBPrefix . "proxybid WHERE itemid=" . intval($_REQUEST['id']);
        $res = mysql_query($query);
        $system->check_mysql($res, $query, __LINE__, __FILE__);
        $maxbid = mysql_result ($res, 0, "maxbid");
        if (($maxbid > 0 && $maxbid >= $reserve_price)) {
            $ERR = '712';
        }
    }
}

$TPL_seller = $user;
$TPL_title_value = $MSG['2__0025'];
$TPL_title = $title;
$TPL_buy_now_price = $system->print_money($buy_now_price);

// get user's nick
$query = "select id, nick FROM " . $DBPrefix . "users WHERE id=" . intval($user);
$result_usr = mysql_query ($query);
$system->check_mysql($result_usr, $query, __LINE__, __FILE__);

$user_nick = mysql_result ($result_usr, 0, "nick");
$user_id = mysql_result ($result_usr, 0, "id");
$TPL_user_nick_value = $user_nick;

// Get current number of feedbacks
$query = "SELECT rated_user_id FROM " . $DBPrefix . "feedbacks WHERE rated_user_id=" . intval($user_id);
$result = mysql_query ($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$num_feedbacks = mysql_num_rows ($result);

// Get current total rate value for user
$query = "SELECT rate_sum FROM " . $DBPrefix . "users WHERE nick='" . $system->cleanvars($user_nick) . "'";
$result = mysql_query ($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
if ($result && mysql_num_rows($result) > 0)
    $total_rate = mysql_result ($result, 0, "rate_sum");

$TPL_vendetor_value = " <a href=\"profile.php?user_id=" . $user_id . "\"><b>" . $TPL_user_nick_value . "</b></a>";

$i = 0;
foreach ($memtypesarr as $k => $l) {
    if ($k >= $total_rate || $i++ == (count($memtypesarr) - 1)) {
        $TPL_rate_radio = '<img src="' . $system->SETTINGS['siteurl'] . "images/icons/" . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
        break;
    }
}
$TPL_num_feedbacks = "<b>($total_rate)</b>";

if ($_GET['action'] == 'buy') {
    $bidder_id = $_SESSION['WEBID_LOGGED_IN'];
    if ($system->SETTINGS['usersauth'] == 'y') {
        // check if nickname and password entered
        if (strlen($_POST['password']) == 0) {
            $ERR = "610";
        }
        // check if nick is valid
        $query = "select * FROM " . $DBPrefix . "users WHERE id = " . $_SESSION['WEBID_LOGGED_IN'] . " LIMIT 1";
        $result = mysql_query($query);
        $system->check_mysql($result, $query, __LINE__, __FILE__);

        $n = 0;
        if ($result) $n = mysql_num_rows($result);
        else $ERR = "001";

        if ($n == 0) $ERR = "609";
        if ($n > 0) {
            // check if password is correct
            $pwd = mysql_result($result, 0, "password");
            if ($pwd != md5($MD5_PREFIX . $_POST['password'])) {
                $ERR = "611";
            } else {
                if (mysql_result($result, 0, "suspended") > 0) {
                    $ERR = "618";
                }
            }
        }
    }
    // check if buyer is not the seller
    if ($_POST['nick'] == $user_nick) {
        $ERR = "711";
    }
    // perform final actions
    if (isset($ERR)) {
        $TPL_errmsg = ${"ERR_" . $ERR} ;
    }

    if (empty($ERR)) {
        $query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL,
					" . intval($_REQUEST['id']) . ", " . intval($bidder_id) . ", " . floatval($buy_now_price) . ", '$NOW', 1)";
        $result = mysql_query($query);
        $system->check_mysql($result, $query, __LINE__, __FILE__);
        if ($quantity == 1) {
            $query = "UPDATE " . $DBPrefix . "auctions SET ends = '$NOW', num_bids = num_bids + 1, current_bid = " . floatval($buy_now_price) . " WHERE id = " . intval($_REQUEST['id']);
            $system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
            $query = "UPDATE " . $DBPrefix . "counters SET bids = (bids + 1)";
            $system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
            include ('cron.php');
        } else {
            $query = "UPDATE " . $DBPrefix . "auctions SET quantity = quantity - 1 WHERE id=" . intval($_REQUEST['id']);
            $system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
            // do stuff that is important
            $query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $_SESSION['WEBID_LOGGED_IN'];
            $result = mysql_query($query);
            $system->check_mysql($result, $query, __LINE__, __FILE__);
            $Winner = mysql_fetch_array($result);

            $query = "INSERT INTO " . $DBPrefix . "winners VALUES (NULL," . intval($_REQUEST['id']) . ", " . $user_id . ", " . $Winner['id'] . ", " . $buy_now_price . ", '$NOW', 0, 0, 0, 1)";
            $system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
            include $include_path . 'endauction_youwin.inc.php';
        }

        $buy_done = 1;
    }
}

$template->assign_vars(array(
        'ERROR' => (isset($TPL_errmsg)) ? $TPL_errmsg : '',
        'ID' => $_REQUEST['id'],
        'TITLE' => $TPL_title,
        'BN_PRICE' => $TPL_buy_now_price,
        'SELLER' => $TPL_vendetor_value,
        'SELLERNUMFBS' => $TPL_num_feedbacks,
        'FBICON' => $TPL_rate_radio,

        'B_NOTBOUGHT' => ($buy_done != 1),
        'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')
        ));

require("header.php");
$template->set_filenames(array(
        'body' => 'buy_now.html'
        ));
$template->display('body');
require("footer.php");
?>