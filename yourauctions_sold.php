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

// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_sold.php';
	header('location: user_login.php');
	exit;
}
// check if the user can access this page
$user->checkSuspended();

$NOW = time();
$NOWB = date('Ymd');
$user_message = '';

$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'relist_fee'";
$db->direct_query($query);
$relist_fee = $db->result('value');

// Update
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Re-list auctions
	if (isset($_POST['relist']) && is_array($_POST['relist']) && count($_POST['relist']) > 0)
	{
		foreach ($_POST['relist'] as $k)
		{
			$k = intval($k);
			$query = "SELECT duration, category FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);
			$AUCTION = $db->result();

			// auction ends
			$WILLEND = time() + ($AUCTION['duration'] * 24 * 60 * 60);
			$suspend = 0;

			if ($system->SETTINGS['fees'] == 'y' && $relist_fee > 0)
			{
				if ($system->SETTINGS['fee_type'] == 1)
				{
					// charge relist fee
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :relist_fee WHERE id = :user_id";
					$params = array();
					$params[] = array(':relist_fee', $relist_fee, 'float');
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$db->query($query, $params);
				}
				else
				{
					$suspend = 8;
				}
			}

			$query = "UPDATE " . $DBPrefix . "auctions
					SET starts = :starts,
					ends = :ends,
					closed = 0,
					num_bids = 0,
					relisted = relisted + 1,
					current_bid = 0,
					sold = 'n',
					suspended = :suspended
					WHERE id = :auc_id";
			$params = array();
			$params[] = array(':starts', $NOW, 'int');
			$params[] = array(':ends', $WILLEND, 'int');
			$params[] = array(':suspended', $suspend, 'int');
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// delete bids
			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Proxy Bids
			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Winners: only in case of reserve not reached
			$query = "DELETE FROM " . $DBPrefix . "winners WHERE auction = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Update COUNTERS table
			$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
			$db->direct_query($query);

			// get category data to update it
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
			$params = array();
			$params[] = array(':cat_id', $AUCTION['category'], 'int');
			$db->query($query, $params);

			$parent_node = $db->result();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
			// update recursive categories
			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
			if ($system->SETTINGS['fee_type'] == 2 && isset($relist_fee) && $relist_fee > 0)
			{
				header('location: pay.php?a=5');
				exit;
			}
		}
		$user_message .= sprintf($MSG['1146'], count($_POST['relist']));
		if ($relist_fee > 0)
		{
			$user_message .= sprintf($MSG['1148'], $system->print_money(count($_POST['relist']) * $relist_fee));
		}
	}
}

// Retrieve sold auction data from the database
$query = "SELECT COUNT(a.id) AS COUNT FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "winners w
		WHERE a.user = :user_id AND a.closed = 1 AND a.suspended = 0 AND a.id = w.auction GROUP BY w.auction";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
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
if (!isset($_SESSION['solda_ord']) && empty($_GET['solda_ord']))
{
	$_SESSION['solda_ord'] = 'title';
	$_SESSION['solda_type'] = 'asc';
}
elseif (!empty($_GET['solda_ord']))
{
	$_SESSION['solda_ord'] = $_GET['solda_ord'];
	$_SESSION['solda_type'] = $_GET['solda_type'];
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

$query = "SELECT a.* FROM " . $DBPrefix . "auctions a
	LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
	WHERE a.user = :user_id
	AND a.closed = 1
	AND a.suspended = 0
	GROUP BY w.auction
	ORDER BY " . $_SESSION['solda_ord'] . " " . $_SESSION['solda_type'] . " LIMIT :offset, :perpage";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
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
			'BID' => ($item['current_bid'] == 0) ? '-' : $system->print_money($item['current_bid']),
			'BIDS' => $item['num_bids'],

			'B_CLOSED' => ($item['closed']),
			'B_HASNOBIDS' => ($item['current_bid'] == 0),
			'B_BUY_NOW_ONLY' => ($item['bn_only']),
			'B_BUY_NOW' => ($item['bn_sale'] == 1),
			'B_DUTCH' => ($item['auction_type'] == 2)
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
		'USER_MESSAGE' => $user_message,

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $PREV . '&id=' . $id . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $NEXT . '&id=' . $id . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

include 'header.php';
$TMP_usmenutitle = $MSG['25_0119'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourauctions_sold.tpl'
		));
$template->display('body');
include 'footer.php';
