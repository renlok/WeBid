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

if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourbids.php';
	header('location: user_login.php');
	exit;
}

// get active bids for this user
$query = "SELECT a.current_bid, a.current_bid_id, a.id, a.title, a.ends, b.bid, b.quantity, p.bid As proxybid, b.id As bid_id FROM " . $DBPrefix . "bids b
	LEFT JOIN " . $DBPrefix . "proxybid p ON (p.itemid = b.auction AND p.userid = b.bidder)
	LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = b.auction)
	WHERE a.closed = 0 AND b.bidder = :user_id
	AND a.bn_only = 0 ORDER BY a.ends ASC, b.bid DESC";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);

$idcheck = array();
$auctions_count = 0;
while ($row = $db->fetch())
{
	if (!in_array($row['id'], $idcheck))
	{
		// prepare some data
		$bgColor = (!($auctions_count % 2)) ? '' : 'class="alt-row"';

		// Outbidded or winning bid
		if ($row['bid_id'] != $row['current_bid_id']) $bgColor = 'style="background-color:#FFFF00;"';

		$auctions_count++;
		$idcheck[] = $row['id'];

		$template->assign_block_vars('bids', array(
				'BGCOLOUR' => $bgColor,
				'ID' => $row['id'],
				'TITLE' => htmlspecialchars($row['title']),
				'BID' => $system->print_money($row['bid']),
				'PROXYBID' => (intval($row['proxybid']) > 0) ? $system->print_money($row['proxybid']) : '',
				'QTY' => $row['quantity'],
				'TIMELEFT' => FormatTimeLeft($row['ends'] - time()),
				'CBID' => $system->print_money($row['current_bid'])
				));
	}
}

$template->assign_vars(array(
		'NUM_BIDS' => $auctions_count
		));

include 'header.php';
$TMP_usmenutitle = $MSG['620'];
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'yourbids.tpl'
		));
$template->display('body');
include 'footer.php';
