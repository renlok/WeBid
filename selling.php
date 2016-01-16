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
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'selling.php';
	header('location: user_login.php');
	exit;
}

if (isset($_GET['paid']))
{
	$query = "UPDATE " . $DBPrefix . "winners SET paid = 1 WHERE id = :winner_id AND seller = :seller_id";
	$params = array();
	$params[] = array(':winner_id', $_GET['paid'], 'int');
	$params[] = array(':seller_id', $user->user_data['id'], 'int');
	$db->query($query, $params);
}
if (isset($_GET['shipped']))
{
	$query = "UPDATE " . $DBPrefix . "winners SET shipped = 1 WHERE id = :get_shipped AND seller = :user_id";
	$params[] = array(':get_shipped', $_GET['shipped'], 'int');
	$params[] = array(':user_id', $user->user_data['id'], 'int');
	$db->query($query, $params);
}

// Get closed auctions with winners
$params = array();
// a specific auction?
$auc_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
if ($auc_id > 0)
{
	$searchid = ' AND a.id = :auc_id';
	$params[] = array(':auc_id', $auc_id, 'int');
}
else
{
	$searchid = '';
}

$query = "SELECT a.title, a.ends, w.id, w.auction, w.bid, w.qty, w.winner, w.seller, w.paid, w.shipped, w.feedback_sel, u.nick
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "winners w ON (w.auction = a.id)
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.winner)
		WHERE (a.closed = 1 OR a.bn_only = 'y') AND a.suspended = 0 AND a.user = :seller_id
		" . $searchid . "
		ORDER BY w.closingdate DESC";
$params[] = array(':seller_id', $user->user_data['id'], 'int');
$db->query($query, $params);

$sslurl = ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y') ? str_replace('http://', 'https://', $system->SETTINGS['siteurl']) : $system->SETTINGS['siteurl'];
$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;

$i = 0;
$winner_data = $db->fetchall();
foreach ($winner_data as $row)
{
	$fblink = ($row['feedback_sel'] == 0) ? '(<a href="' . $sslurl . 'feedback.php?auction_id=' . $row['auction'] . '&wid=' . $row['winner'] . '&sid=' . $row['seller'] . '&ws=s">' . $MSG['207'] . '</a>)' : '';
	$template->assign_block_vars('a', array(
		'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
		'TITLE' => $system->uncleanvars($row['title']),
		'ENDS' => FormatDate($row['ends']),
		'AUCTIONID' => $row['auction'],

		'ID' => $row['id'],
		'BID' => $row['bid'],
		'BIDF' => $system->print_money($row['bid']),
		'QTY' => $row['qty'],
		'NICK' => $row['nick'],
		'WINNERID' => $row['winner'],
		'FB' => $fblink,

		'B_PAID' => ($row['paid'] == 1),
		'SHIPPED' => $row['shipped']
		));
	$i++;
}

$template->assign_vars(array(
		'NUM_WINNERS' => $i,
		'AUCID' => ($auc_id > 0) ? '&id=' . $auc_id : '',
		'SELLER_ID' => $user->user_data['id']
		));

include 'header.php';
$TMP_usmenutitle = $MSG['453'];
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'selling.tpl'
		));
$template->display('body');
include 'footer.php';