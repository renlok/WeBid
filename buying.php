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
if (!$user->logged_in)
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'buying.php';
	header('location: user_login.php');
	exit;
}

// the user has received the item
if (isset($_GET['shipped']))
{
	$query = "UPDATE " . $DBPrefix . "winners SET shipped = 2 WHERE id = :get_shipped AND winner = :user_id";
	$params[] = array(':get_shipped', $_GET['shipped'], 'int');
	$params[] = array(':user_id', $user->user_data['id'], 'int');
	$db->query($query, $params);
}


$query = "SELECT count(DISTINCT a.id) As COUNT
		FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.seller)
		WHERE (b.closed = 1 OR b.bn_only = 1) AND b.suspended = 0
		AND a.winner = :user_id";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$TOTALAUCTIONS = $db->result('COUNT');

if (!isset($_GET['PAGE']) || intval($_GET['PAGE']) <= 1 || empty($_GET['PAGE']))
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

// Get closed auctions with winners
$query = "SELECT DISTINCT a.id, a.qty, a.seller, a.paid, a.feedback_win, a.bid, a.auction, a.shipped, b.title, b.ends, b.shipping_cost, b.additional_shipping_cost, b.shipping, u.nick, u.email
		FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.seller)
		WHERE (b.closed = 1 OR b.bn_only = 1) AND b.suspended = 0
		AND a.winner = :user_id ORDER BY a.closingdate DESC
		LIMIT :offset, :perpage";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

while ($row = $db->fetch())
{
	$totalcost = ($row['qty'] > 1) ? ($row['bid'] * $row['qty']) : $row['bid'];
	$additional_shipping = $row['additional_shipping_cost'] * ($row['qty'] - 1);
	$totalcost = ($row['shipping'] == 2) ? $totalcost : ($totalcost + $row['shipping_cost'] + $additional_shipping);

	$template->assign_block_vars('items', array(
			'AUC_ID' => $row['auction'],
			'TITLE' => htmlspecialchars($row['title']),
			'ID' => $row['id'],
			'ENDS' => FormatDate($row['ends']),
			'BID' => $row['bid'],
			'FBID' => $system->print_money($row['bid']),
			'QTY' => ($row['qty'] > 0) ? $row['qty'] : 1,
			'TOTAL' => $system->print_money($totalcost),
			'B_PAID' => ($row['paid'] == 1),
			'SHIPPED' => $row['shipped'],

			'SELLNICK' => $row['nick'],
			'SELLEMAIL' => $row['email'],
			'FB_LINK' => ($row['feedback_win'] == 0) ? '<a href="' . $system->SETTINGS['siteurl'] . 'feedback.php?auction_id=' . $row['auction'] . '&wid=' . $user->user_data['id'] . '&sid=' . $row['seller'] . '&ws=w">' . $MSG['207'] . '</a>' : ''
			));
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'buying.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'buying.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'buying.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,
));

include 'header.php';
$TMP_usmenutitle = $MSG['454'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'buying.tpl'
		));
$template->display('body');
include 'footer.php';
