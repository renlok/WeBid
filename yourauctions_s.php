<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
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
$NOWB = gmdate('Ymd');

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_s.php';
	header('location: user_login.php');
	exit;
}

// DELETE OR CLOSE OPEN AUCTIONS
if (isset($_POST['action']) && $_POST['action'] == 'delopenauctions')
{
	if (is_array($_POST['O_delete']) && count($_POST['O_delete']) > 0)
	{
		foreach ($_POST['O_delete'] as $k => $v)
		{
			$removed = 0;
			$v = intval($v);
			// Pictures Gallery
			if ($dir = @opendir($upload_path . '/' . $v))
			{
				while ($file = readdir($dir))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink($upload_path . '/' . $v . $file);
					}
				}
				closedir($dir);
				@rmdir($upload_path . '/' . $v);
			}

			// remove auction
			$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			$removed++;
		}

		$query = "UPDATE " . $DBPrefix . "counters SET suspendedauctions = (suspendedauctions - " . $removed . ")";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
}

// Retrieve active auctions from the database
$query = "SELECT count(id) as COUNT FROM " . $DBPrefix . "auctions WHERE user = " . $user->user_data['id'] . " AND suspended != 0";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$TOTALAUCTIONS = mysql_result($res, 0, 'COUNT');

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
if (!isset($_SESSION['sa_ord']) && empty($_GET['sa_ord']))
{
	$_SESSION['sa_ord'] = 'title';
	$_SESSION['sa_type'] = 'asc';
}
elseif (!empty($_GET['sa_ord']))
{
	$_SESSION['sa_ord'] = mysql_escape_string($_GET['sa_ord']);
	$_SESSION['sa_type'] = mysql_escape_string($_GET['sa_type']);
}
elseif (isset($_SESSION['sa_ord']) && empty($_GET['sa_ord']))
{
	$_SESSION['sa_nexttype'] = $_SESSION['sa_type'];
}

if (!isset($_SESSION['sa_nexttype']) || $_SESSION['sa_nexttype'] == 'desc')
{
	$_SESSION['sa_nexttype'] = 'asc';
}
else
{
	$_SESSION['sa_nexttype'] = 'desc';
}

if (!isset($_SESSION['sa_type']) || $_SESSION['sa_type'] == 'desc')
{
	$_SESSION['sa_type_img'] = '<img src="images/arrow_up.gif" align="center" hspace="2" border="0" />';
}
else
{
	$_SESSION['sa_type_img'] = '<img src="images/arrow_down.gif" align="center" hspace="2" border="0" />';
}
$query = "SELECT id, title, current_bid, num_bids, relist, relisted, current_bid, suspended
		FROM " . $DBPrefix . "auctions WHERE user = " . $user->user_data['id'] . "
		AND suspended != 0 ORDER BY " . $_SESSION['sa_ord'] . " " . $_SESSION['sa_type'] . " LIMIT " . $OFFSET . ", " . $system->SETTINGS['perpage'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
while ($item = mysql_fetch_array($res))
{
	$template->assign_block_vars('items', array(
			'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
			'ID' => $item['id'],
			'TITLE' => $item['title'],
			'BID' => $system->print_money($item['current_bid']),
			'BIDS' => $item['num_bids'],
			'RELIST' => $item['relist'],
			'RELISTED' => $item['relisted'],
			'SUSPENDED' => $item['suspended'],

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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_s.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
		'ORDERCOL' => $_SESSION['sa_ord'],
		'ORDERNEXT' => $_SESSION['sa_nexttype'],
		'ORDERTYPEIMG' => $_SESSION['sa_type_img'],

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_s.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_s.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,

		'B_AREITEMS' => ($i > 0)
		));

include 'header.php';
$TMP_usmenutitle = $MSG['2__0056'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourauctions_s.tpl'
		));
$template->display('body');
include 'footer.php';
?>
