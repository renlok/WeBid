<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit('Access denied');

// work in progress
class Auction_Dutch extends Auction
{
	public function addBid();

	public function getBidHistory()
	{
		$query = "SELECT b.*, u.nick, u.rate_sum FROM " . $db->DBPrefix . "bids b
				LEFT JOIN " . $db->DBPrefix . "users u ON (u.id = b.bidder)
				WHERE b.auction = :auc_id ORDER BY b.bidwhen DESC";
		$params = array();
		$params[] = array(':auc_id', $auction_data['id'], 'int');
		$db->query($query, $params);
		$history = $db->fetchall();
		return $history;
	}
}
