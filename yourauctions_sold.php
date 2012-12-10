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

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_sold.php';
	header('location: user_login.php');
	exit;
}

$NOW = time();
$NOWB = gmdate('Ymd');

// Update
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Re-list auctions
	if (is_array($_POST['relist']))
	{
		foreach ($_POST['relist'] as $k)
		{
			$k = intval($k);
			$query = "SELECT duration, category FROM " . $DBPrefix . "auctions WHERE id = " . $k;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$AUCTION = mysql_fetch_assoc($res);

			// auction ends
			$WILLEND = time() + ($AUCTION['duration'] * 24 * 60 * 60);
			$suspend = 0;

			if ($system->SETTINGS['fees'] == 'y')
			{
				if ($system->SETTINGS['fee_type'] == 1)
				{
					// charge relist fee
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - " . $relist_fee . " WHERE id = " . $user->user_data['id'];
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				else
				{
					$suspend = 8;
				}
			}

			$query = "UPDATE " . $DBPrefix . "auctions
				  SET starts = '" . $NOW . "',
				  ends = '" . $WILLEND . "',
				  closed = 0,
				  num_bids = 0,
				  relisted = relisted + 1,
				  current_bid = 0,
				  sold = 'n',
				  suspended = " . $suspend . "
				  WHERE id = " . $k;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			// Insert into relisted table
			$query = "INSERT INTO " . $DBPrefix . "closedrelisted VALUES (" . $k . ", '" . $NOWB . "', '" . $k . "')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// delete bids
			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = " . $k;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Proxy Bids
			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = " . $k;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Winners: only in case of reserve not reached
			$query = "DELETE FROM " . $DBPrefix . "winners WHERE auction = " . $k;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			// Update COUNTERS table
			$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $AUCTION['category'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$parent_node = mysql_fetch_assoc($res);
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
			// update recursive categories
			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}
			if ($system->SETTINGS['fee_type'] == 2 && isset($relist_fee) && $relist_fee > 0)
			{
				header('location: pay.php?a=5');
				exit;
			}
		}
	}
}

// Retrieve closed auction data from the database
$query = "SELECT a.*  FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "winners w
		WHERE a.user = " . $user->user_data['id'] . " AND a.closed = 1 AND a.suspended = 0 AND a.id = w.auction GROUP BY w.auction";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$TOTALAUCTIONS = mysql_num_rows($res);

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
if (!isset($_SESSION['solda_ord']) && empty($_GET['solda_ord']))
{
	$_SESSION['solda_ord'] = 'title';
	$_SESSION['solda_type'] = 'asc';
}
elseif (!empty($_GET['solda_ord']))
{
	$_SESSION['solda_ord'] = mysql_escape_string($_GET['solda_ord']);
	$_SESSION['solda_type'] = mysql_escape_string($_GET['solda_type']);
}
elseif (isset($_SESSION['solda_ord']) && empty($_GET['solda_ord']))
{
	$_SESSION['solda_nexttype'] = $_SESSION['solda_type'];
}

if (!isset($_SESSION['solda_nexttype']) || $_SESSION['solda_nexttype'] == 'desc')
{
	$_SESSION['solda_nexttype'] = 'asc';
}
else
{
	$_SESSION['solda_nexttype'] = 'desc';
}

if (!isset($_SESSION['solda_type']) || $_SESSION['solda_type'] == 'desc')
{
	$_SESSION['solda_type_img'] = '<img src="images/arrow_up.gif" align="center" hspace="2" border="0" alt="up"/>';
}
else
{
	$_SESSION['solda_type_img'] = '<img src="images/arrow_down.gif" align="center" hspace="2" border="0" alt="down"/>';
}

$query = "SELECT a.* FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "winners w
		WHERE a.user = " . $user->user_data['id'] . "
		AND a.closed = 1
		AND a.suspended = 0
		AND a.id = w.auction
		GROUP BY w.auction
		ORDER BY " . $_SESSION['solda_ord'] . " " . $_SESSION['solda_type'] . " LIMIT " . $OFFSET . "," . $system->SETTINGS['perpage'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
while ($item = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('items', array(
			'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
			'ID' => $item['id'],
			'TITLE' => $item['title'],
			'STARTS' => FormatDate($item['starts']),
			'ENDS' => FormatDate($item['ends']),
			'BID' => ($item['current_bid'] == 0) ? '-' : $system->print_money($item['current_bid']),
			'BIDS' => $item['num_bids'],

			'B_CLOSED' => ($item['closed'] == 1),
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $COUNTER . '&id=' . $id . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'ORDERCOL' => $_SESSION['solda_ord'],
		'ORDERNEXT' => $_SESSION['solda_nexttype'],
		'ORDERTYPEIMG' => $_SESSION['solda_type_img'],

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $PREV . '&id=' . $id . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $NEXT . '&id=' . $id . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

include 'header.php';
$TMP_usmenutitle = $MSG['25_0119'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourauctions_sold.tpl'
		));
$template->display('body');
include 'footer.php';
?>
