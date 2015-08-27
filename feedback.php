<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
include $include_path . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}

ksort($memtypesarr, SORT_NUMERIC);
$NOW = time();

if (isset($_REQUEST['auction_id']))
{
	$_SESSION['CURRENT_ITEM'] = intval($_REQUEST['auction_id']);
}

$auction_id = (isset($_SESSION['CURRENT_ITEM']) && intval($_SESSION['CURRENT_ITEM']) > 0) ? $_SESSION['CURRENT_ITEM'] : 0;
$ws = (isset($_GET['ws'])) ? $_GET['ws'] : 'w';

if (isset($_POST['addfeedback'])) // submit the feedback
{
	if (!$user->is_logged_in())
	{
		header('location: user_login.php');
		exit;
	}

	if (((isset($_POST['TPL_password']) && $system->SETTINGS['usersauth'] == 'y') || $system->SETTINGS['usersauth'] == 'n') && isset($_POST['TPL_rate']) && isset($_POST['TPL_feedback']) && !empty($_POST['TPL_feedback']))
	{
		$query = "SELECT winner, seller, feedback_win, feedback_sel, paid FROM " . $DBPrefix . "winners
				WHERE auction = :auc_id
				AND winner = :winner_id AND seller = :seller_id
				AND ((seller = :user_ids AND feedback_sel = 0)
				OR (winner = :user_idw AND feedback_win = 0))";
		$params = array();
		$params[] = array(':auc_id', $auction_id, 'int');
		$params[] = array(':winner_id', $_REQUEST['wid'], 'int');
		$params[] = array(':seller_id', $_REQUEST['sid'], 'int');
		$params[] = array(':user_ids', $user->user_data['id'], 'int');
		$params[] = array(':user_idw', $user->user_data['id'], 'int');
		$db->query($query, $params);
		if ($db->numrows() > 0)
		{
			if ($user->user_data['nick'] != $_POST['TPL_nick_hidden'])
			{
				$wsell = $db->result();
				// winner/seller check
				$ws = ($user->user_data['id'] == $wsell['winner']) ? 'w' : 's';
				if ((intval($_REQUEST['sid']) == $user->user_data['id'] && $wsell['feedback_sel'] == 1) || (intval($_REQUEST['wid']) == $user->user_data['id'] && $wsell['feedback_win'] == 1))
				{
					$TPL_err = 1;
					$TPL_errmsg = $ERR_074;
				}
				//elseif ((intval($_REQUEST['wid']) == $user->user_data['id'] && $wsell['paid'] == 1) || (intval($_REQUEST['sid']) == $user->user_data['id']))
				else
				{
					// load hashing class to check password
					include $include_path . 'PasswordHash.php';
					$phpass = new PasswordHash(8, false);
					if ($system->SETTINGS['usersauth'] == 'n' || $phpass->CheckPassword($_POST['TPL_password'], $user->user_data['password']))
					{
						$secTPL_feedback = $system->cleanvars($_POST['TPL_feedback']);
						$uid = ($ws == 'w') ? $_REQUEST['sid'] : $_REQUEST['wid'];
						$sql = "UPDATE " . $DBPrefix . "users SET rate_sum = rate_sum + :rate_sum, rate_num = rate_num + 1 WHERE id = :user_id";
						$params = array();
						$params[] = array(':rate_sum', $_POST['TPL_rate'], 'int');
						$params[] = array(':user_id', $uid, 'int');
						$db->query($query, $params);

						if ($system->SETTINGS['wordsfilter'] == 'y')
						{
							$secTPL_feedback = $system->filter($secTPL_feedback);
						}
						$sql = "INSERT INTO " . $DBPrefix . "feedbacks (rated_user_id, rater_user_nick, feedback, rate, feedbackdate, auction_id) VALUES
							(:user_id, :user_nick, :feedback, :rate, :time, :auc_id)";
						$params = array();
						$params[] = array(':user_id', $uid, 'int');
						$params[] = array(':user_nick', $user->user_data['nick'], 'str');
						$params[] = array(':feedback', $secTPL_feedback, 'str');
						$params[] = array(':rate', $_POST['TPL_rate'], 'int');
						$params[] = array(':time', $system->ctime, 'int');
						$params[] = array(':auc_id', $auction_id, 'int');
						$db->query($query, $params);
						if ($ws == 's')
						{
							$sqlset = "feedback_sel = 1";
						}
						if ($ws == 'w')
						{
							$sqlset = "feedback_win = 1";
						}
						$sql = "UPDATE " . $DBPrefix . "winners SET $sqlset
								WHERE auction = :auc_id AND winner = :winner AND seller = :seller";
						$params = array();
						$params[] = array(':auc_id', $auction_id, 'int');
						$params[] = array(':winner', $_REQUEST['wid'], 'int');
						$params[] = array(':seller', $_REQUEST['sid'], 'int');						
						$db->query($query, $params);
						header ('location: feedback.php?faction=show&id=' . intval($uid));
						exit;
					}
					else
					{
						$TPL_err = 1;
						$TPL_errmsg = $ERR_101;
					}
				}
				/*
				else
				{
					$TPL_err = 1;
					$TPL_errmsg = $ERR_705;
				}*/
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
	$secid = ($ws == 'w') ? $_REQUEST['sid'] : $_REQUEST['wid'];
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
		$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;
		header('Location: ' . $sslurl . 'feedback.php?auction_id=' . $auction_id . '&sid=' . $_REQUEST['sid'] . '&wid=' . $_REQUEST['wid'] . '&ws=' . $_REQUEST['ws']);
		exit;
	}

	$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auc_id LIMIT 1";
	$params = array();
	$params[] = array(':auc_id', $auction_id, 'int');				
	$db->query($query, $params);
	$item_title = $db->result('title');

	$sql = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $secid, 'int');						
	$db->query($query, $params);

	if ($db->numrows() > 0)
	{
		$arr = $db->result();
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
	if (!isset($_GET['id']))
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_106;
	}
	else
	{
		$secid = intval($_GET['id']);
		$thispage = (isset($_GET['pg'])) ? $_GET['pg'] : 1;
		if ($thispage == 0) $thispage = 1;
		$left_limit = ($thispage - 1) * $system->SETTINGS['perpage'];

		$query = "SELECT rate_sum, nick FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array();
		$params[] = array(':user_id', $secid, 'int');					
		$db->query($query, $params);
		if ($db->numrows() > 0)
		{
			$user_data = $db->result();
			$total = $user_data['rate_sum'];
			$TPL_nick = $user_data['nick'];
			$TPL_feedbacks_num = $total;
			// get number of pages
			$pages = ceil($total / $system->SETTINGS['perpage']);

			$sql = "SELECT f.*, a.title, u.id As uId, u.rate_num, u.rate_sum
				FROM " . $DBPrefix . "feedbacks f
				LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = f.auction_id)
				LEFT JOIN " . $DBPrefix . "users u ON (u.nick = f.rater_user_nick)
				WHERE rated_user_id = :user_id
				ORDER by feedbackdate DESC LIMIT :left_limit, :perpage";
			$params = array();
			$params[] = array(':user_id', $secid, 'int');
			$params[] = array(':left_limit', $left_limit, 'int');
			$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');					
			$db->query($query, $params);
			$i = 0;
			$feed_disp = array();
			while ($arrfeed = $db->fetch())
			{
				$j = 0;
				foreach ($memtypesarr as $k => $l)
				{
					if ($k >= $arrfeed['rate_sum'] || $j++ == (count($memtypesarr) - 1))
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
					case 0 : $uimg = $system->SETTINGS['siteurl'] . 'images/neutral.png';
						break;
				}
				$template->assign_block_vars('fbs', array(
						'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
						'IMG' => $uimg,
						'USFLINK' => 'profile.php?user_id=' . $arrfeed['uId'] . '&auction_id=' . $arrfeed['auction_id'],
						'USERID' => $arrfeed['uId'],
						'USERNAME' => $arrfeed['rater_user_nick'],
						'USFEED' => $arrfeed['rate_sum'],
						'USICON' => (isset($usicon)) ? $usicon : '',
						'FBDATE' => FormatDate($arrfeed['feedbackdate']),
						'AUCTIONURL' => ($arrfeed['title']) ? '<a href="item.php?id=' . $arrfeed['auction_id'] . '">' . $system->uncleanvars($arrfeed['title']) . '</a>' : $MSG['113'] . $arrfeed['auction_id'],
						'FEEDBACK' => nl2br($arrfeed['feedback'])
						));
				$i++;
			}
			else
			{
				$TPL_err = 1;
				$TPL_errmsg = $ERR_105;
			}
		}
	}
	$firstpage = (($thispage - 5) <= 0) ? 1 : ($thispage - 5);
	$lastpage = (($thispage + 5) > $pages) ? $pages : ($thispage + 5);
	$backpage = (($thispage - 1) <= 0) ? 1 : ($thispage - 1);
	$nextpage = (($thispage + 1) > $pages) ? $pages : ($thispage + 1);
	$echofeed = ($thispage == 1) ? '' : '<a href="feedback.php?id=' . $_GET['id'] . '&faction=show">&laquo;</a> <a href="feedback.php?id=' . $_GET['id'] . '&pg=' . $backpage . '&faction=show"><</a> ';
	for ($ind2 = $firstpage; $ind2 <= $lastpage; $ind2++)
	{
		if ($thispage != $ind2)
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
			'AUCT_ID' => $auction_id,
			'AUCT_TITLE' => $item_title,
			'WID' => $_GET['wid'],
			'SID' => $_GET['sid'],
			'WS' => $ws,
			'FEEDBACK' => (isset($secTPL_feedback)) ? $secTPL_feedback : '',
			'RATE1' => (!isset($_POST['TPL_rate']) || $_POST['TPL_rate'] == 1) ? ' checked="true"' : '',
			'RATE2' => (isset($_POST['TPL_rate']) && $_POST['TPL_rate'] == 0) ? ' checked="true"' : '',
			'RATE3' => (isset($_POST['TPL_rate']) && $_POST['TPL_rate'] == -1) ? ' checked="true"' : '',
			'SBMSG' => $sbmsg,
			'THEM' => $them,

			'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')
			));
	include 'header.php';
	$template->set_filenames(array(
			'body' => 'feedback.tpl'
			));
	$template->display('body');
	include 'footer.php';
}

if (isset($_GET['faction']) && $_GET['faction'] == 'show')
{
	$sql = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array();
	$params[] = array(':user_id', $_REQUEST['id'], 'int');				
	$db->query($query, $params);
	if ($arr = $db->fetch())
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
			'AUCT_ID' => $auction_id,
			'ID' => $_REQUEST['id']
			));
	include 'header.php';
	$template->set_filenames(array(
			'body' => 'show_feedback.tpl'
			));
	$template->display('body');
	include 'footer.php';
}
?>
