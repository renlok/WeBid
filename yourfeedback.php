<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'includes/common.inc.php';
include $include_path . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}
ksort($memtypesarr, SORT_NUMERIC);

if (!$user->logged_in)
{
	header('location: user_login.php');
	exit;
}

$i = 0;
foreach ($memtypesarr as $k => $l)
{
	if ($k >= $user->user_data['rate_sum'] || $i++ == (count($memtypesarr) - 1))
	{
		$TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
		break;
	}
}

if (!isset($_GET['pg']) || $_GET['pg'] == 0) $_GET['pg'] = 1;
$lines = (isset($lines)) ? $lines : 5;
$left_limit = ($_GET['pg'] - 1) * $lines;

$query = "SELECT count(*) FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = " . $user->user_data['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$total = mysql_result($res, 0);
// get number of pages
$pages = ceil($total / $lines);

$left_limit = ($left_limit < 0) ? 0 : $left_limit;

$query = "SELECT f.*, a.title FROM " . $DBPrefix . "feedbacks f
		LEFT OUTER JOIN " . $DBPrefix . "auctions a
		ON a.id = f.auction_id
		WHERE rated_user_id = " . $user->user_data['id'] . "
		ORDER by feedbackdate DESC
		LIMIT $left_limit, $lines";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
$feed_disp = array();
while ($arrfeed = mysql_fetch_assoc($res))
{
	$query = "SELECT id, rate_num, rate_sum FROM " . $DBPrefix . "users WHERE nick = '" . $arrfeed['rater_user_nick'] . "'";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$usarr = mysql_fetch_array($result);
	$j = 0;
	foreach ($memtypesarr as $k => $l)
	{
		if ($k >= $usarr['rate_sum'] || $j++ == (count($memtypesarr) - 1))
		{
			$usicon = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
			break;
		}
	}
	switch ($arrfeed['rate'])
	{
		case 1: $uimg = $system->SETTINGS['siteurl'] . 'images/positive.gif';
			break;
		case - 1: $uimg = $system->SETTINGS['siteurl'] . 'images/negative.gif';
			break;
		case 0: $uimg = $system->SETTINGS['siteurl'] . 'images/neutral.gif';
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
$echofeed = ($thispage == 1) ? '' : '<a href="yourfeedback.php">&laquo;</a> <a href="yourfeedback.php?pg=' . $backpage . '"><</a> ';
for ($ind2 = $firstpage; $ind2 <= $lastpage; $ind2++)
{
	if ($pg != $ind2)
	{
		$echofeed .= '<a href="yourfeedback.php?pg=' . $ind2 . '">' . $ind2 . '</a>';
	}
	else
	{
		$echofeed .= $ind2;
	}
	if ($ind2 != $lastpage)
	{
		$echofeed .= ' | ';
	}
}
$echofeed .= ($thispage == $pages || $pages == 0) ? '' : ' <a href="yourfeedback.php?pg=' . $nextpage . '">></a> <a href="feedback.php?pg=' . $pages . '">&raquo;</a>';

$template->assign_vars(array(
		'USERNICK' => $user->user_data['nick'],
		'USERFB' => $user->user_data['rate_sum'],
		'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',
		'PAGENATION' => $echofeed,
		'BGCOLOUR' => (!(($i + 1) % 2)) ? '' : 'class="alt-row"'
		));

include 'header.php';
$TMP_usmenutitle = $MSG['25_0223'];
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'yourfeedback.tpl'
		));
$template->display('body');
include 'footer.php';
?>
