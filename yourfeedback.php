<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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
include INCLUDE_PATH . 'membertypes.inc.php';

if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourfeedback.php';
	header('location: user_login.php');
	exit;
}

$i = 0;
foreach ($membertypes as $k => $l)
{
	if ($k >= $user->user_data['rate_sum'] || $i++ == (count($membertypes) - 1))
	{
		$TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
		break;
	}
}

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
while ($arrfeed = $db->fetch())
{
	$j = 0;
	foreach ($membertypes as $k => $l)
	{
		if ($k >= $arrfeed['rate_sum'] || $j++ == (count($membertypes) - 1))
		{
			$usicon = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
			break;
		}
	}
	switch ($arrfeed['rate'])
	{
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
			'USICON' => (isset($usicon)) ? $usicon : '',
			'FBDATE' => FormatDate($arrfeed['feedbackdate']),
			'AUCTION_TITLE' => htmlspecialchars($arrfeed['title']),
			'AUCTION_ID' => $arrfeed['auction_id'],
			'FEEDBACK' => nl2br($arrfeed['feedback'])
			));

	$i++;
}

$firstpage = (($page - 5) <= 0) ? 1 : ($page - 5);
$lastpage = (($page + 5) > $pages) ? $pages : ($page + 5);
$backpage = (($page - 1) <= 0) ? 1 : ($page - 1);
$nextpage = (($page + 1) > $pages) ? $pages : ($page + 1);
$echofeed = ($page == 1) ? '' : '<a href="yourfeedback.php">&laquo;</a> <a href="yourfeedback.php?pg=' . $backpage . '"><</a> ';
for ($ind2 = $firstpage; $ind2 <= $lastpage; $ind2++)
{
	if ($page != $ind2)
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
$echofeed .= ($page == $pages || $pages == 0) ? '' : ' <a href="yourfeedback.php?pg=' . $nextpage . '">></a> <a href="yourfeedback.php?pg=' . $pages . '">&raquo;</a>';

$template->assign_vars(array(
		'USERNICK' => $user->user_data['nick'],
		'USERFB' => $user->user_data['rate_sum'],
		'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',
		'PAGENATION' => $echofeed,
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
