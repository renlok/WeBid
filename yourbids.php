<?php

/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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

// get active bids for this user
$query = "SELECT a.current_bid, a.id, a.title, a.ends, b.bid FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "bids b
		WHERE a.id = b.auction AND a.closed = 0 AND b.bidder = " . $user->user_data['id'] . "
		AND a.bn_only = 'n' ORDER BY a.ends ASC, b.bidwhen DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$idcheck = array();
$auctions_count = 0;
$bgColor = '#EBEBEB';
while ($row = mysql_fetch_assoc($res))
{
	if (!in_array($row['id'], $idcheck))
	{
		// prepare some data
		$bgColor = ($bgColor == '#EBEBEB') ? '#FFFFFF' : '#EBEBEB';

		// Outbidded or winning bid
		if ($row['current_bid'] != $row['bid']) $bgColor = '#FFFF00';

		$auctions_count++;
		$idcheck[] = $row['id'];

		$template->assign_block_vars('bids', array(
				'BGCOLOUR' => $bgColor,
				'ID' => $row['id'],
				'TITLE' => $row['title'],
				'BID' => $system->print_money($row['bid']),
				'TIMELEFT' => FormatTimeLeft($row['ends'] - time())
				));
	}
}

$template->assign_vars(array(
		'NUM_BIDS' => $auctions_count
		));

include 'header.php';
$TMP_usmenutitle = $MSG['620'];
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'yourbids.tpl'
		));
$template->display('body');
include 'footer.php';
?>
