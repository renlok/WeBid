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

include "includes/common.inc.php";
include $include_path . "membertypes.inc.php";
foreach($membertypes as $idm => $memtypearr) {
    $memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}
ksort($memtypesarr, SORT_NUMERIC);

if (!$user->logged_in) {
    header("Location: user_login.php");
    exit;
}

$secid = $user->user_data['id'];
$TPL_rater_nick = $user->user_data['nick'];
$sql = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id=" . intval($secid);
$res = mysql_query ($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0) {
    $arr = mysql_fetch_array ($res);
    $TPL_nick = $arr['nick'];
    $i = 0;
    foreach ($memtypesarr as $k => $l) {
        if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr) - 1)) {
            $TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
            break;
        }
    }
    $TPL_feedbacks_num = $arr['rate_num'];
    $TPL_feedbacks_sum = $arr['rate_sum'];
} else {
    $TPL_err = 1;
    $TPL_errmsg = $ERR_105;
}

if ($_GET['pg'] == 0) $_GET['pg'] = 1;
$lines = (int)$lines;
if ($lines == 0) $lines = 5;
$left_limit = ($_GET['pg'] - 1) * $lines;
$rsl = mysql_query ("SELECT count(*) FROM " . $DBPrefix . "feedbacks WHERE rated_user_id=" . intval($secid));
if ($rsl) {
    $hash = mysql_fetch_array($rsl);
    $total = (int)$hash[0];
} else $total = 0;
$TPL_feedbacks_num = $total;
// get number of pages
$pages = ceil($total / $lines);

$left_limit = ($left_limit < 0) ? 0 : $left_limit;

$sql = "SELECT f.*, a.title FROM " . $DBPrefix . "feedbacks f
	LEFT OUTER JOIN " . $DBPrefix . "auctions a
	ON a.id = f.auction_id
	WHERE rated_user_id='$secid'
	ORDER by feedbackdate DESC
	LIMIT $left_limit,$lines";
$res = mysql_query ($sql);
$system->check_mysql($res, $sql, __LINE__, __FILE__);
$i = 0;
$feed_disp = array();
while ($arrfeed = mysql_fetch_array($res)) {
    $sql = "SELECT id, rate_num, rate_sum FROM " . $DBPrefix . "users WHERE nick='" . $arrfeed['rater_user_nick'] . "'";
    $usarr = mysql_fetch_array(mysql_query($sql));
    $j = 0;
    foreach ($memtypesarr as $k => $l) {
        if ($k >= $usarr['rate_sum'] || $j++ == (count($memtypesarr) - 1)) {
            $usicon = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
            break;
        }
    }
    switch ($arrfeed['rate']) {
        case 1: $uimg = $system->SETTINGS['siteurl'] . "images/positive.gif";
            break;
        case - 1: $uimg = $system->SETTINGS['siteurl'] . "images/negative.gif";
            break;
        case 0: $uimg = $system->SETTINGS['siteurl'] . "images/neutral.gif";
            break;
    }
    $template->assign_block_vars('fbs', array(
            'BGCOLOUR' => (!(($i + 1) % 2)) ? '' : 'class="alt-row"',
            'IMG' => $uimg,
            'USFLINK' => 'profile.php?user_id=' . $usarr['id'] . '&auction_id=' . $arrfeed['auction_id'],
            'USERNAME' => $arrfeed['rater_user_nick'],
            'USFEED' => $usarr['rate_sum'],
            'USICON' => (isset($usicon)) ? $usicon : '',
            'FBDATE' => FormatDate($arrfeed['feedbackdate']),
            'AUCTIONURL' => ($arrfeed['title']) ? '<a href="item.php?id=' . $arrfeed['auction_id'] . '">' . $arrfeed['title'] . '</a>' : $MSG['113'] . $arrfeed['auction_id'],
            'FEEDBACK' => nl2br(stripslashes($arrfeed['feedback']))
            ));

    $i++;
}

$thispage = (isset($_GET['pg'])) ? $_GET['pg'] : 1;
$firstpage = (($thispage - 5) <= 0) ? 1 : ($thispage - 5);
$lastpage = (($thispage + 5) > $pages) ? $pages : ($thispage + 5);
$backpage = (($thispage - 1) <= 0) ? 1 : ($thispage - 1);
$nextpage = (($thispage + 1) > $pages) ? $pages : ($thispage + 1);
$echofeed = ($thispage == 1) ? "" : "<a href=\"yourfeedback.php\">&laquo;</a> <a href=\"yourfeedback.php?pg=$backpage\"><</a> ";
for ($ind2 = $firstpage; $ind2 <= $lastpage; $ind2++) {
    if ($pg != $ind2) {
        $echofeed .= "<a href=\"yourfeedback.php?pg=$ind2\">$ind2</a>";
    } else {
        $echofeed .= $ind2;
    }
    if ($ind2 != $lastpage) {
        $echofeed .= " | ";
    }
}
$echofeed .= ($thispage == $pages || $pages == 0) ? "" : " <a href=\"yourfeedback.php?pg=$nextpage\">></a> <a href=\"feedback.php?pg=$pages\">&raquo;</a>";

$template->assign_vars(array(
        'USERNICK' => $TPL_nick,
        'USERFB' => $TPL_feedbacks_sum,
        'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',
        'PAGENATION' => $echofeed,
        'BGCOLOUR' => (!(($i + 1) % 2)) ? '' : 'class="alt-row"'
        ));

include "header.php";
$TMP_usmenutitle = $MSG['25_0223'];
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'yourfeedback.html'
        ));
$template->display('body');
include "footer.php";

?>