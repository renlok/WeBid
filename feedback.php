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

include 'includes/common.inc.php';
include $include_path . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}

ksort($memtypesarr, SORT_NUMERIC);
$NOW = time();

if (!isset($_POST['auction_id']) && !isset($_GET['auction_id']))
{
	$_REQUEST['auction_id'] = $_SESSION['CURRENT_ITEM'];
}
elseif (isset($_REQUEST['auction_id']))
{
	$_SESSION['CURRENT_ITEM'] = intval($_REQUEST['auction_id']);
}

$pg = (empty($_REQUEST['pg'])) ? 1 : $_REQUEST['pg'];
$ws = (isset($_GET['ws'])) ? $_GET['ws'] : 'w';

if (isset($_POST['addfeedback'])) // submit the feedback
{
	if (!$user->logged_in)
	{
		header('location: user_login.php');
		exit;
	}

	if (((isset($_POST['TPL_password']) && $system->SETTINGS['usersauth'] == 'y') || $system->SETTINGS['usersauth'] == 'n') && isset($_POST['TPL_rate']) && isset($_POST['TPL_feedback']) && !empty($_POST['TPL_feedback']))
	{
		$sql = "SELECT winner, seller, feedback_win, feedback_sel FROM " . $DBPrefix . "winners
				WHERE auction = " . $_REQUEST['auction_id'] . "
				AND winner = " . intval($_REQUEST['wid']) . " AND seller = " . intval($_REQUEST['sid']) . "
				AND ((seller = " . $user->user_data['id'] . " AND feedback_win = 0)
				OR (winner = " . $user->user_data['id'] . " AND feedback_sel = 0))";
		$resids = mysql_query($sql);
		$system->check_mysql($resids, $sql, __LINE__, __FILE__);
		if (mysql_num_rows($resids) > 0)
		{
			if ($user->user_data['nick'] != $_POST['TPL_nick_hidden'])
			{
				$wsell = mysql_fetch_assoc($resids);
				$sql = "SELECT id, nick, password FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
				$resrater = mysql_query($sql);
				$system->check_mysql($resrater, $sql, __LINE__, __FILE__);
				if (mysql_num_rows($resrater) > 0)
				{
					$arr = mysql_fetch_array ($resrater);
					if ((intval($_REQUEST['sid']) == $arr['id'] && $wsell['feedback_sel'] == 0) || (intval($_REQUEST['wid']) == $arr['id'] && $wsell['feedback_win'] == 0))
					{
						if ($system->SETTINGS['usersauth'] == 'n' || $arr['password'] == md5($MD5_PREFIX . $_POST['TPL_password']))
						{
							$secTPL_rater_nick = $user->user_data['nick'];
							$secTPL_feedback = ereg_replace("\n", "<br>", $_POST['TPL_feedback']);
							$uid = ($ws == 's') ? $_REQUEST['sid'] : $_REQUEST['wid'];
							$sql = "UPDATE " . $DBPrefix . "users SET rate_sum = rate_sum + " . $_POST['TPL_rate'] . ", rate_num = rate_num + 1 WHERE id = " . intval($uid);
							$system->check_mysql(mysql_query($sql), $sql, __LINE__, __FILE__);
							if ($system->SETTINGS['wordsfilter'] == 'y')
							{
								$secTPL_feedback = $system->filter($secTPL_feedback);
							}
							$sql = "INSERT INTO " . $DBPrefix . "feedbacks (rated_user_id, rater_user_nick, feedback, rate, feedbackdate, auction_id) VALUES (
								" . intval($uid) . ",
								'" . $system->cleanvars($secTPL_rater_nick) . "',
								'" . $system->cleanvars($secTPL_feedback) . "',
								" . intval($_POST['TPL_rate']) . ", '" . time() . "'," . $_REQUEST['auction_id'] . ")";
							$system->check_mysql(mysql_query($sql), $sql, __LINE__, __FILE__);
							if ($ws == 's')
							{
								$sqlset = "feedback_sel = 1";
							}
							if ($ws == 'w')
							{
								$sqlset = "feedback_win = 1";
							}
							$sql = "UPDATE " . $DBPrefix . "winners SET $sqlset
									WHERE auction = " . $_REQUEST['auction_id'] . " AND winner = " . intval($_REQUEST['wid']) . " AND seller = " . intval($_REQUEST['sid']);
							$system->check_mysql(mysql_query($sql), $sql, __LINE__, __FILE__);
							header ('location: feedback.php?faction=show&id=' . intval($uid));
							exit;
						}
						else
						{
							$TPL_err = 1;
							$TPL_errmsg = $ERR_101;
						}
					}
					else
					{
						$TPL_err = 1;
						$TPL_errmsg = $ERR_705;
					}
				}
				else
				{
					$TPL_err = 1;
					$TPL_errmsg = $ERR_102;
				}
			}
			else
			{
				$TPL_err = 1;
				$TPL_errmsg = $ERR_103;
			}
		}
		else
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_704;
		}
	}
	else
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_104;
	}
}

if ((isset($_GET['wid']) && isset($_GET['sid'])) || isset($TPL_err)) // gets user details
{
	$secid = ($ws == 's') ? $_REQUEST['sid'] : $_REQUEST['wid'];
	if ($_REQUEST['sid'] == $user->user_data['id'])
	{
		$them = $_REQUEST['wid'];
		$sbmsg = $MSG['131'];
	}
	else
	{
		$them = $_REQUEST['sid'];
		$sbmsg = $MSG['125'];
	}
	if ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
	{
		$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
		header('Location: ' . $sslurl . 'feedback.php?auction_id=' . $_REQUEST['auction_id'] . '&sid=' . $_REQUEST['sid'] . '&wid=' . $_REQUEST['wid'] . '&ws=' . $_REQUEST['ws']);
		exit;
	}

	$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = " . $_REQUEST['auction_id'] . " LIMIT 1";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$item_title = mysql_result($res, 0, 'title');
	$sql = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = " . intval($secid);
	$res = mysql_query($sql);
	$system->check_mysql($res, $sql, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$arr = mysql_fetch_array ($res);
		$TPL_nick = $arr['nick'];
		$i = 0;
		foreach ($memtypesarr as $k => $l)
		{
			if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr) - 1))
			{
				$TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
				break;
			}
		}
		$TPL_feedbacks_num = $arr['rate_num'];
		$TPL_feedbacks_sum = $arr['rate_sum'];
	}
	else
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_105;
	}
}

if (isset($_GET['faction']) && $_GET['faction'] == 'show')
{
	// determine limits for SQL query
	$secid = $_GET['id'];
	if ($pg == 0) $pg = 1;
	$lines = (isset($lines)) ? intval($lines) : 5;
	$left_limit = ($pg - 1) * $lines;

	$query = "SELECT rate_sum, nick FROM " . $DBPrefix . "users WHERE id = " . intval($secid);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	$hash = mysql_fetch_assoc($res);
	$total = (int)$hash['rate_sum'];
	$TPL_nick = $hash['nick'];
	$TPL_feedbacks_num = $total;
	// get number of pages
	$pages = ceil($total / $lines);

	$sql = "SELECT f.*, a.title, u.id As uId, u.rate_num, u.rate_sum
		FROM " . $DBPrefix . "feedbacks f
		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = f.auction_id)
		LEFT JOIN " . $DBPrefix . "users u ON (u.nick = f.rater_user_nick)
		WHERE rated_user_id = " . intval($secid) . "
		ORDER by feedbackdate DESC
		LIMIT " . intval($left_limit) . "," . intval($lines);
	$res = mysql_query($sql);
	$system->check_mysql($res, $sql, __LINE__, __FILE__);
	$i = 0;
	$feed_disp = array();
	while ($arrfeed = mysql_fetch_array($res))
	{
		$i = 0;
		foreach ($memtypesarr as $k => $l)
		{
			if ($k >= $arrfeed['rate_sum'] || $i++ == (count($memtypesarr) - 1))
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
			case 0 : $uimg = $system->SETTINGS['siteurl'] . 'images/neutral.gif';
				break;
		}
		$template->assign_block_vars('fbs', array(
				'BGCOLOUR' => (!(($i + 1) % 2)) ? '#EEEEEE' : '#FFFFFF',
				'IMG' => $uimg,
				'USFLINK' => 'profile.php?user_id=' . $arrfeed['uId'] . '&auction_id=' . $arrfeed['auction_id'],
				'USERID' => $arrfeed['uId'],
				'USERNAME' => $arrfeed['rater_user_nick'],
				'USFEED' => $arrfeed['rate_sum'],
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
	$echofeed = ($thispage == 1) ? '' : '<a href="feedback.php?id=' . $_GET['id'] . '&faction=show">&laquo;</a> <a href="feedback.php?id=' . $_GET['id'] . '&pg=' . $backpage . '&faction=show"><</a> ';
	for ($ind2 = $firstpage; $ind2 <= $lastpage; $ind2++)
	{
		if ($pg != $ind2)
		{
			$echofeed .= '<a href="feedback.php?id=' . $_GET['id'] . '&pg=' . $ind2 . '&faction=show">' . $ind2 . '</a>';
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
	$echofeed .= ($thispage == $pages || $pages == 0) ? '' : ' <a href="feedback.php?id=' . $_GET['id'] . '&pg=' . $nextpage . '&faction=show">></a> <a href="feedback.php?id=' . $_GET['id'] . '&pg=' . $pages . '&faction=show">&raquo;</a>';
}
// Calls the appropriate templates/templates
if ((isset($TPL_err) && !empty($TPL_err)) || !isset($_GET['faction']))
{
	$template->assign_vars(array(
			'ERROR' => (isset($TPL_errmsg)) ? $TPL_errmsg : '',
			'USERNICK' => $TPL_nick,
			'USERFB' => $TPL_feedbacks_sum,
			'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',
			'AUCT_ID' => $_REQUEST['auction_id'],
			'AUCT_TITLE' => $item_title,
			'WID' => $_GET['wid'],
			'SID' => $_GET['sid'],
			'WS' => $ws,
			'FEEDBACK' => $TPL_feedback,
			'RATE1' => (!isset($_POST['TPL_rate']) || $_POST['TPL_rate'] == 1) ? ' checked="true"' : '',
			'RATE2' => (isset($_POST['TPL_rate'] && $_POST['TPL_rate'] == 0) ? ' checked="true"' : '',
			'RATE3' => (isset($_POST['TPL_rate'] && $_POST['TPL_rate'] == -1) ? ' checked="true"' : '',
			'SBMSG' => $sbmsg,
			'THEM' => $them,

			'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')
			));
	include 'header.php';
	$template->set_filenames(array(
			'body' => 'feedback.html'
			));
	$template->display('body');
	include 'footer.php';
}

if (isset($_GET['faction']) && $_GET['faction'] == 'show')
{
	$sql = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . intval($_REQUEST['id']);
	$res = mysql_query($sql);
	$system->check_mysql($res, $sql, __LINE__, __FILE__);
	if ($arr = mysql_fetch_array($res))
	{
		$TPL_rate_ratio_value = '';
		foreach ($memtypesarr as $k => $l)
		{
			if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr) - 1))
			{
				$TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';
				break;
			}
		}
	}
	$template->assign_vars(array(
			'USERNICK' => $TPL_nick,
			'USERFB' => $TPL_feedbacks_num,
			'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',
			'PAGENATION' => $echofeed,
			'AUCT_ID' => $_REQUEST['auction_id'],
			'ID' => $_REQUEST['id']
			));
	include 'header.php';
	$template->set_filenames(array(
			'body' => 'show_feedback.html'
			));
	$template->display('body');
	include 'footer.php';
}
?>
