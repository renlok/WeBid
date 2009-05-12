<?php

/***************************************************************************
 *   copyright				: (C) 2008 WeBid
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
		WHERE a.id = b.auction AND a.closed = 0 AND b.bidder = " . $user->user_data['id'] . " ORDER BY a.ends ASC, b.bidwhen DESC";
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);

$idcheck = '';
$auctions_count = 0;
$bgColor = '#EBEBEB';
while ($row = mysql_fetch_array($result))
{
	$rowid = $row['id'];
	if ($idcheck != $rowid)
	{
		$bid = $row['bid'];
		// prepare some data
		if ($bgColor == '#EBEBEB')
		{
			$bgColor = '#FFFFFF';
		}
		else
		{
			$bgColor = '#EBEBEB';
		}
		// Outbidded or winning bid
		if ($row['current_bid'] != $row['bid']) $bgColor = '#FFFF00';
		// current bid of this auction
		if ($bid == 0)
		{
			$bid = $starting_price;
		}
		$bid = $system->print_money($bid);
		// time left till the end of this auction
		$difference = $row['ends'] - time();

		$auctions_count++;

		$idcheck = $rowid;

		$template->assign_block_vars('bids', array(
				'BGCOLOUR' => $bgColor,
				'ID' => $rowid,
				'TITLE' => $row['title'],
				'BID' => $bid,
				'TIMELEFT' => FormatTimeLeft($difference)
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
