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
if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_c.php';
	header('location: user_login.php');
	exit;
}

// DELETE OPEN AUCTIONS
$NOW = time();
$NOWB = gmdate('Ymd');
$catscontrol = new MPTTcategories();

$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'relist_fee'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$relist_fee = mysql_result($res, 0);

// Update
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Delete auction
	if (is_array($_POST['delete']))
	{
		foreach ($_POST['delete'] as $k => $v)
		{
			$v = intval($v);
			// Pictures Gallery
			if ($dir = @opendir($upload_path . $v))
			{
				while ($file = readdir($dir))
				{
					if ($file != '.' && $file != '..')
					{
						unlink($upload_path . $v . '/' . $file);
					}
				}
				closedir($dir);
				@rmdir($upload_path . $v);
			}

			$query = "UPDATE " . $DBPrefix . "counters SET closedauctions = closedauctions - 1";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = " . $v;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	if (is_array($_POST['sell']))
	{
		foreach ($_POST['sell'] as $v)
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET sold = 's' WHERE id = " . intval($v);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		include 'cron.php';
	}
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
$query = "SELECT COUNT(id) AS COUNT FROM " . $DBPrefix . "auctions
		WHERE user = " . $user->user_data['id'] . "
		AND closed = 1 AND suspended = 0
		AND (num_bids = 0 OR (num_bids > 0 AND current_bid < reserve_price AND sold = 'n'))";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$TOTALAUCTIONS = mysql_result($res, 0, 'COUNT');

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1)
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
if (!isset($_SESSION['ca_ord']) && empty($_GET['ca_ord']))
{
	$_SESSION['ca_ord'] = 'title';
	$_SESSION['ca_type'] = 'asc';
}
elseif (!empty($_GET['ca_ord']))
{
	$_SESSION['ca_ord'] = mysql_escape_string($_GET['ca_ord']);
	$_SESSION['ca_type'] = mysql_escape_string($_GET['ca_type']);
}
elseif (isset($_SESSION['ca_ord']) && empty($_GET['ca_ord']))
{
	$_SESSION['ca_nexttype'] = $_SESSION['ca_type'];
}

if (!isset($_SESSION['ca_nexttype']) || $_SESSION['ca_nexttype'] == 'desc')
{
	$_SESSION['ca_nexttype'] = 'asc';
}
else
{
	$_SESSION['ca_nexttype'] = 'desc';
}

if (!isset($_SESSION['ca_type']) || $_SESSION['ca_type'] == 'desc')
{
	$_SESSION['ca_type_img'] = '<img src="images/arrow_up.gif" align="center" hspace="2" border="0">';
}
else
{
	$_SESSION['ca_type_img'] = '<img src="images/arrow_down.gif" align="center" hspace="2" border="0">';
}

$query = "SELECT *  FROM " . $DBPrefix . "auctions
	WHERE user = " . $user->user_data['id'] . "
	AND closed = 1 AND suspended = 0
	AND (num_bids = 0 OR (num_bids > 0 AND reserve_price > 0 AND current_bid < reserve_price AND sold = 'n'))
	ORDER BY " . $_SESSION['ca_ord'] . " " . $_SESSION['ca_type'] . " LIMIT $OFFSET, " . $system->SETTINGS['perpage'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$i = 0;
while ($item = mysql_fetch_array($res))
{
	$canrelist = false;
	if (($item['current_bid'] > $item['reserve_price']))
	{
		$cansell = false;
	}
	else
	{
		if ($item['reserve_price'] > 0 || $item['num_bids'] == 0)
		{
			$canrelist = true;
		}
		if ($item['reserve_price'] > 0 && $item['num_bids'] > 0)
		{
			$cansell = true;
		}
		else
		{
			$cansell = false;
		}
	}

	$template->assign_block_vars('items', array(
			'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
			'ID' => $item['id'],
			'TITLE' => $item['title'],
			'STARTS' => FormatDate($item['starts']),
			'ENDS' => FormatDate($item['ends']),
			'BID' => ($item['current_bid'] == 0) ? '-' : $system->print_money($item['current_bid']),
			'BIDS' => $item['num_bids'],

			'B_CANRELIST' => $canrelist,
			'B_CANSSELL' => $cansell,
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_c.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
		'ORDERCOL' => $_SESSION['ca_ord'],
		'ORDERNEXT' => $_SESSION['ca_nexttype'],
		'ORDERTYPEIMG' => $_SESSION['ca_type_img'],
		'RELIST_FEE' => $system->print_money($relist_fee),
		'RELIST_FEE_NO' => $system->print_money_nosymbol($relist_fee),

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_c.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_c.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,

		'B_AREITEMS' => ($i > 0),
		'B_RELIST_FEE' => ($relist_fee > 0 && $system->SETTINGS['fees'] == 'y'),
		'B_AUTORELIST' => ($system->SETTINGS['autorelist'] == 'y')
		));

include 'header.php';
$TMP_usmenutitle = $MSG['354'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourauctions_c.tpl'
		));
$template->display('body');
include 'footer.php';
?>
