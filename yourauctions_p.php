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

$NOW = time();
$NOWB = date('Ymd');

// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_p.php';
	header('location: user_login.php');
	exit;
}
// check if the user can access this page
$user->checkSuspended();

$user_message = '';

// DELETE OR CLOSE OPEN AUCTIONS
if (isset($_POST['action']) && $_POST['action'] == 'delopenauctions')
{
	if (isset($_POST['O_delete']) && is_array($_POST['O_delete']) && count($_POST['O_delete']) > 0)
	{
		$removed = 0;
		foreach ($_POST['O_delete'] as $k => $v)
		{
			$v = intval($v);
			// Pictures Gallery
			if (is_dir(UPLOAD_PATH . $v))
			{
				if ($dir = opendir(UPLOAD_PATH . $v))
				{
					while ($file = readdir($dir))
					{
						if ($file != '.' && $file != '..')
						{
							@unlink(UPLOAD_PATH . $v . '/' . $file);
						}
					}
					closedir($dir);
					rmdir(UPLOAD_PATH . $v);
				}
			}

			$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $v, 'int');
			$db->query($query, $params);

			$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $v, 'int');
			$db->query($query, $params);
			$removed++;
		}

		$query = "UPDATE " . $DBPrefix . "counters SET auctions = (auctions - :removed)";
		$params = array();
		$params[] = array(':removed', $removed, 'int');
		$db->query($query, $params);
		$user_message .= sprintf($MSG['1145'], count($_POST['O_delete']));
	}

	if (isset($_POST['startnow']) && is_array($_POST['startnow']) && count($_POST['startnow']) > 0)
	{
		foreach ($_POST['startnow'] as $k => $v)
		{
			$query = "SELECT duration FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $v, 'int');
			$db->query($query, $params);

			$aucdata = $db->result();

			$ends = $NOW + ($aucdata['duration'] * 24 * 60 * 60);

			// Update end time to "now"
			$query = "UPDATE " . $DBPrefix . "auctions SET starts = :time, ends = :ends WHERE id = :auc_id";
			$params = array();
			$params[] = array(':time', $NOW, 'int');
			$params[] = array(':ends', $ends, 'int');
			$params[] = array(':auc_id', $v, 'int');
			$db->query($query, $params);
		}
		$user_message .= sprintf($MSG['1150'], count($_POST['closenow']));
	}
}
// Retrieve active auctions from the database
$query = "SELECT count(id) AS COUNT FROM " . $DBPrefix . "auctions WHERE user = :user_id and starts > :time AND suspended = 0";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':time', $NOW, 'int');
$db->query($query, $params);
$TOTALAUCTIONS = $db->result('COUNT');

if (!isset($_GET['PAGE']) || $_GET['PAGE'] < 0 || empty($_GET['PAGE']))
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);
// Handle columns sorting variables
if (!isset($_SESSION['pa_ord']) && empty($_GET['pa_ord']))
{
	$_SESSION['pa_ord'] = 'title';
	$_SESSION['pa_type'] = 'asc';
}
elseif (!empty($_GET['pa_ord']))
{
	$_SESSION['pa_ord'] = $_GET['pa_ord'];
	$_SESSION['pa_type'] = $_GET['pa_type'];
}
elseif (isset($_SESSION['pa_ord']) && empty($_GET['pa_ord']))
{
	$_SESSION['pa_nexttype'] = $_SESSION['pa_type'];
}

if (!isset($_SESSION['pa_nexttype']) || $_SESSION['pa_nexttype'] == 'desc')
{
	$_SESSION['pa_nexttype'] = 'asc';
}
else
{
	$_SESSION['pa_nexttype'] = 'desc';
}

if (!isset($_SESSION['pa_type']) || $_SESSION['pa_type'] == 'desc')
{
	$_SESSION['pa_type_img'] = '<img src="images/arrow_up.gif" align="center" hspace="2" border="0" />';
}
else
{
	$_SESSION['pa_type_img'] = '<img src="images/arrow_down.gif" align="center" hspace="2" border="0" />';
}
$query = "SELECT * FROM " . $DBPrefix . "auctions au
	WHERE user = :user_id AND starts > :time AND suspended = 0
	ORDER BY " . $_SESSION['pa_ord'] . " " . $_SESSION['pa_type'] . " LIMIT :offset, :perpage";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':time', $NOW, 'int');
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

$i = 0;
while ($item = $db->fetch())
{
	$template->assign_block_vars('items', array(
			'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
			'ID' => $item['id'],
			'TITLE' => htmlspecialchars($item['title']),
			'STARTS' => FormatDate($item['starts'], '/', false),
			'ENDS' => FormatDate($item['ends'], '/', false),

			'B_HASNOBIDS' => ($item['current_bid'] == 0)
			));
	$i++;
}
// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_p.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
		'ORDERCOL' => $_SESSION['pa_ord'],
		'ORDERNEXT' => $_SESSION['pa_nexttype'],
		'ORDERTYPEIMG' => $_SESSION['pa_type_img'],
		'USER_MESSAGE' => $user_message,

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_p.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_p.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,

		'B_AREITEMS' => ($i > 0)
		));

include 'header.php';
$TMP_usmenutitle = $MSG['25_0115'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourauctions_p.tpl'
		));
$template->display('body');
include 'footer.php';
