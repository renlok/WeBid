<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit();

if (!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = 'cron.php';

include $include_path . 'functions_cron.php';

// initialize cron script
printLog('=============== STARTING CRON SCRIPT: ' . date('F d, Y H:i:s'));

$categories = constructCategories();

/**
 * ------------------------------------------------------------
 * 1) "close" expired auctions
 * closing auction means:
 * a) update database:
 * + "auctions" table
 * + "categories" table - for counters
 * + "counters" table
 * b) send email to winner (if any) - passing seller's data
 * c) send email to seller (reporting if there was a winner)
 */
printLog('++++++ Closing expired auctions');
$NOW = time();
$NOWB = date('Ymd');
$buyer_emails = array();
$seller_emails = array();

// get buyer fee
$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = 'buyer_fee'";
$db->direct_query($query);
$row = $db->result();
$buyer_fee = (isset($row['value'])) ? $row['value'] : 0;
$buyer_fee_type = (isset($row['fee_type'])) ? $row['fee_type'] : 'flat';

// get closed auction fee
$query = "SELECT * FROM " . $DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
$db->direct_query($query);
$endauc_fee = array();
while($row = $db->fetch())
{
	$endauc_fee[] = $row;
}

// get a list of all ended auctions
$query = "SELECT a.*, u.email, u.endemailmode, u.nick, u.payment_details, u.name
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (a.user = u.id)
		WHERE a.ends <= :time
		AND ((a.closed = 0)
		OR (a.closed = 1
		AND a.reserve_price > 0
		AND a.num_bids > 0
		AND a.current_bid < a.reserve_price
		AND a.sold = 's'))";
$params = array();
$params[] = array(':time', $NOW, 'int');
$db->query($query, $params);

$count_auctions = $num = $db->numrows();
printLog($num . ' auctions to close');

$n = 1;
$auction_data = $db->fetchall();
foreach ($auction_data as $Auction) // loop auctions
{
	$n++;
	$report_text = '';
	printLog("\n" . 'Processing auction: ' . $Auction['id']);
	$Auction['description'] = strip_tags($Auction['description']);

	// Send notification to all users watching this auction
	sendWatchEmails($Auction['id']);

	// set seller array
	$Seller = array(
		'id' => $Auction['user'],
		'email' => $Auction['email'],
		'endemailmode' => $Auction['endemailmode'],
		'nick' => $Auction['nick'],
		'payment_details' => $Auction['payment_details'],
		'name' => $Auction['name']);

	// get an order list of bids of the item (high to low)
	$winner_present = false;
	$query = "SELECT u.* FROM " . $DBPrefix . "bids b
			LEFT JOIN " . $DBPrefix . "users u ON (b.bidder = u.id)
			WHERE auction = :auc_id ORDER BY b.bid DESC, b.quantity DESC, b.id DESC";
	$params = array();
	$params[] = array(':auc_id', $Auction['id'], 'int');
	$db->query($query, $params);
	$num_bids = $db->numrows();

	// send email to seller - to notify him
	// create a "report" to seller depending of what kind auction is
	$atype = intval($Auction['auction_type']);
	if ($atype == 1)
	{
		if ($num_bids > 0 && ($Auction['current_bid'] >= $Auction['reserve_price'] || $Auction['sold'] == 's'))
		{
			$Winner = $db->result();
			$Winner['quantity'] = $Auction['quantity'];
			$WINNING_BID = $Auction['current_bid'];
			$winner_present = true;
		}

		// Standard auction
		if ($winner_present)
		{
			$report_text = $Winner['nick'] . "\n";
			if ($system->SETTINGS['users_email'] == 'n')
			{
				$report_text .= ' (<a href="mailto:' . $Winner['email'] . '">' . $Winner['email'] . '</a>)' . "\n";
			}
			if ($Winner['address'] != '')
			{
				$report_text .= $MSG['30_0086'] . $Winner['address'] . ' ' . $Winner['city'] . ' ' . $Winner['prov'] . ' ' . $Winner['zip'] . ', ' . $Winner['country'];
			}
			$bf_paid = 1; // buyer fee payed?
			$ff_paid = 1; // auction end fee payed?
			// work out & add fee
			if ($system->SETTINGS['fees'] == 'y')
			{
				sortFees();
			}

			// Add winner's data to "winners" table
			$query = "INSERT INTO " . $DBPrefix . "winners VALUES
			(NULL, :auc_id, :seller_id, :winner_id, :current_bid, :time, 0, 0, 1, 0, :bf_paid, :ff_paid)";
			$params = array();
			$params[] = array(':auc_id', $Auction['id'], 'int');
			$params[] = array(':seller_id', $Seller['id'], 'int');
			$params[] = array(':winner_id', $Winner['id'], 'int');
			$params[] = array(':time', $NOW, 'int');
			$params[] = array(':current_bid', $Auction['current_bid'], 'float');
			$params[] = array(':bf_paid', $bf_paid, 'int');
			$params[] = array(':ff_paid', $ff_paid, 'int');
			$db->query($query, $params);
		}
		else
		{
			$report_text = $MSG['429'];
		}
	}
	else
	{
		// Dutch Auction
		// find out winners sorted by bid
		$query = "SELECT *, MAX(bid) AS maxbid
				FROM " . $DBPrefix . "bids WHERE auction = :auc_id GROUP BY bidder
				ORDER BY maxbid DESC, quantity DESC, id DESC";
		$params = array();
		$params[] = array(':auc_id', $Auction['id'], 'int');
		$db->query($query, $params);

		$num_bids = $num_bids + $db->numrows();
		$WINNERS_ID = array();
		$winner_array = array();
		$items_count = $Auction['quantity'];
		$items_sold = 0;
		$bidder_data = $db->fetchall(); // load every bid
		foreach ($bidder_data as $row)
		{
			if (!in_array($row['bidder'], $WINNERS_ID))
			{
				$items_wanted = $row['quantity'];
				$items_got = 0;
				if ($items_wanted <= $items_count)
				{
					$items_got = $items_wanted;
				}
				else
				{
					$items_got = $items_count;
				}
				$items_count -= $items_got;
				$items_sold += $items_got;

				// Retrieve winner nick from the database
				$query = "SELECT id, nick, email, name, address, city, zip, prov, country
						FROM " . $DBPrefix . "users WHERE id = :bidder LIMIT 1";
				$params = array();
				$params[] = array(':bidder', $row['bidder'], 'int');
				$db->query($query, $params);
				$Winner = $db->result();
				// set arrays
				$WINNERS_ID[] = $row['bidder'];
				$Winner['maxbid'] = $row['maxbid'];
				$Winner['quantity'] = $items_got;
				$Winner['wanted'] = $items_wanted;
				$winner_array[] = $Winner; // set array ready for emails
				$report_text .= ' ' . $MSG['159'] . ' ' . $Winner['nick'];
				if ($system->SETTINGS['users_email'] == 'n')
				{
					$report_text .= ' (' . $Winner['email'] . ')';
				}
				$report_text .= ' ' . $items_got . ' ' . $MSG['5492'] . ', ' . $MSG['5493'] . ' ' . $system->print_money($row['bid']) . ' ' . $MSG['5495'] . ' - (' . $MSG['5494'] . ' ' . $items_wanted . ' ' . $MSG['5492'] . ')' . "\n";
				$report_text .= ' ' . $MSG['30_0086'] . $ADDRESS . "\n";

				$bf_paid = 1;
				$ff_paid = 1;
				// work out & add fee
				if ($system->SETTINGS['fees'] == 'y')
				{
					sortFees();
				}

				// Add winner's data to "winners" table
				$query = "INSERT INTO " . $DBPrefix . "winners VALUES
						(NULL, :auc_id, :seller_id, :winner_id, :current_bid, :time, 0, 0, :items_got, 0, :bf_paid, :ff_paid)";
				$params = array();
				$params[] = array(':auc_id', $Auction['id'], 'int');
				$params[] = array(':seller_id', $Seller['id'], 'int');
				$params[] = array(':winner_id', $row['bidder'], 'int');
				$params[] = array(':time', $NOW, 'int');
				$params[] = array(':items_got', $items_got, 'int');
				$params[] = array(':current_bid', $row['maxbid'], 'float');
				$params[] = array(':bf_paid', $bf_paid, 'int');
				$params[] = array(':ff_paid', $ff_paid, 'int');
				$db->query($query, $params);
			}
			if ($items_count == 0)
			{
				break;
			}
		}
	} // end auction ends
	printLogL ('mail to seller: ' . $Seller['email'], 1);

	$month = date('m', $Auction['ends'] + $system->tdiff);
	$ends_string = $MSG['MON_0' . $month] . ' ' . date('d, Y H:i', $Auction['ends'] + $system->tdiff);

	$close_auction = true;
	// deal with the automatic relists find which auctions are to be relisted
	if ($Auction['relist'] > 0 && ($Auction['relist'] - $Auction['relisted']) > 0 && $Auction['suspended'] == 0)
	{
		$query = "SELECT id FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $Auction['id'], 'int');
		$db->query($query, $params);
		$_BIDSNUM = $db->numrows();

		// noone won the auction so remove bids and start it again
		if ($_BIDSNUM == 0 || ($_BIDSNUM > 0 && $Auction['reserve_price'] > 0 && !$winner_present))
		{
			// Calculate end time
			$_ENDS = $NOW + ($Auction['duration'] * 24 * 60 * 60);

			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $Auction['id'], 'int');
			$db->query($query, $params);
			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $Auction['id'], 'int');
			$db->query($query, $params);
			$query = "UPDATE " . $DBPrefix . "auctions SET starts = :time, ends = :ends,
					current_bid = 0, num_bids = 0, relisted = relisted + 1 WHERE id = :auc_id";
			$params = array();
			$params[] = array(':time', $NOW, 'int');
			$params[] = array(':ends', $_ENDS, 'int');
			$params[] = array(':auc_id', $Auction['id'], 'int');
			$db->query($query, $params);
			$close_auction = false;
			$count_auctions--;
		}
	}

	if ($Auction['suspended'] != 0)
	{
		$count_auctions--;
	}

	if ($close_auction)
	{
		// update category tables
		$cat_id = $Auction['category'];
		$root_cat = $cat_id;
		$second_cat = false;
		while ($cat_id != -1 && isset($categories[$cat_id]))
		{
			// update counter for this category
			$R_counter = intval($categories[$cat_id]['counter']) - 1;
			$R_sub_counter = intval($categories[$cat_id]['sub_counter']) - 1;
			if ($cat_id == $root_cat)
				--$R_counter;
			if ($R_counter < 0)
				$R_counter = 0;
			if ($R_sub_counter < 0)
				$R_sub_counter = 0;
			$categories[$cat_id]['counter'] = $R_counter;
			$categories[$cat_id]['sub_counter'] = $R_sub_counter;
			$categories[$cat_id]['updated'] = true;
			if ($cat_id == $categories[$cat_id]['parent_id']) // incase something messes up
				break;
			$cat_id = $categories[$cat_id]['parent_id'];

			if (!$second_cat && !($cat_id != -1 && isset($categories[$cat_id])) && $system->SETTINGS['extra_cat'] == 'y' && $Auction['secondcat'] != 0)
			{
				$second_cat = true;
				$cat_id = $Auction['secondcat'];
				$root_cat = $cat_id;
			}
		}

		// Close auction
		if ($Auction['sold'] != 's' AND $Auction['num_bids'] > 0 AND $Auction['reserve_price'] > 0 AND $Auction['current_bid'] < $Auction['reserve_price'])
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET closed = 1, sold = 'n' WHERE id = :auc_id";
        }
		else
		{
			$query = "UPDATE " . $DBPrefix . "auctions SET closed = 1, sold = 'y' WHERE id = :auc_id";
        }
		$params = array();
		$params[] = array(':auc_id', $Auction['id'], 'int');
		$db->query($query, $params);
	}

	// WINNER PRESENT
	if ($winner_present)
	{
		// Send mail to the seller
		include $include_path . 'email_endauction_winner.php';
		if (isset($winner_array) && is_array($winner_array) && count($winner_array) > 0)
		{
			for ($i = 0, $count = count($winner_array); $i < $count; $i++)
			{
				// Send mail to the buyer
				$Winner = $winner_array[$i];
				include $include_path . 'email_endauction_youwin.php';
			}
		}
		elseif (is_array($Winner))
		{
			// Send mail to the buyer
			include $include_path . 'email_endauction_youwin_nodutch.php';
		}
	}
	else
	{
		// Send mail to the seller if no winner
		if ($Seller['endemailmode'] != 'cum')
		{
			include $include_path . 'email_endauction_nowinner.php';
		}
		else
		{
			// Save in the database to send later
			$query = "INSERT INTO " . $DBPrefix . "pendingnotif VALUES
			(NULL, :auc_id, :seller_id, '', :auction_data, :seller_data, :date)";
			$params = array();
			$params[] = array(':auc_id', $Auction['id'], 'int');
			$params[] = array(':seller_id', $Auction['id'], 'int');
			$params[] = array(':auction_data', serialize($Auction), 'str');
			$params[] = array(':seller_data', serialize($Seller), 'str');
			$params[] = array(':date', date('Ymd'), 'int');
			$db->query($query, $params);
		}
	}
	// Update bid counter
	$query = "UPDATE " . $DBPrefix . "counters SET bids = (bids - :num_bids)";
	$params = array();
	$params[] = array(':num_bids', $num_bids, 'int');
	$db->query($query, $params);
}

$query = "UPDATE " . $DBPrefix . "counters SET auctions = (auctions - :num_aucsa), closedauctions = (closedauctions + :num_aucsb)";
$params = array();
$params[] = array(':num_aucsa', $count_auctions, 'int');
$params[] = array(':num_aucsb', $count_auctions, 'int');
$db->query($query, $params);

if (count($categories) > 0)
{
	foreach ($categories as $cat_id => $category)
	{
		if ($category['updated'])
		{
			$query = "UPDATE " . $DBPrefix . "categories SET
					 counter = :counter,
					 sub_counter = :sub_counter
					 WHERE cat_id = :cat_id";
			$params = array();
			$params[] = array(':counter', $category['counter'], 'int');
			$params[] = array(':sub_counter', $category['sub_counter'], 'int');
			$params[] = array(':cat_id', $cat_id, 'int');
			$db->query($query, $params);
		}
	}
}

// "remove" old auctions (archive them)
printLog("\n");
printLog("++++++ Archiving old auctions");

$expireAuction = 60 * 60 * 24 * $system->SETTINGS['archiveafter']; // time of auction expiration (in seconds)
$expiredTime = time() - $expireAuction;

$query = "SELECT id FROM " . $DBPrefix . "auctions WHERE ends <= :expiredTime";
$params = array();
$params[] = array(':expiredTime', $expiredTime, 'int');
$db->query($query, $params);

$num = $db->numrows();
printLog($num . " auctions to archive");
if ($num > 0)
{
	$auction_data = $db->fetchall();
	foreach ($auction_data as $AuctionInfo)
	{
		printLogL("Processing auction: " . $AuctionInfo['id'], 0);

		// delete auction
		$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $AuctionInfo['id'], 'int');
		$db->query($query, $params);

		// delete bids for this auction
		$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $AuctionInfo['id'], 'int');
		$db->query($query, $params);

		// Delete proxybid entries
		$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $AuctionInfo['id'], 'int');
		$db->query($query, $params);

		// Delete counter entries
		$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $AuctionInfo['id'], 'int');
		$db->query($query, $params);

		// Delete all images
		if (file_exists($upload_path . $AuctionInfo['id']))
		{
			if ($dir = @opendir($upload_path . $AuctionInfo['id']))
			{
				while ($file = readdir($dir))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink($upload_path . $AuctionInfo['id'] . '/' . $file);
					}
				}
				closedir($dir);
				@rmdir($upload_path . $AuctionInfo['id']);
			}
		}
	}
}

// send cumulative emails
$query = "SELECT id, name, email FROM " . $DBPrefix . "users WHERE endemailmode = 'cum'";
$db->direct_query($query);

$user_data = $db->fetchall();
foreach ($auction_data as $row)
{
	$query = "SELECT * FROM " . $DBPrefix . "pendingnotif WHERE thisdate < '" . date('Ymd') . "' AND seller_id = :seller_id";
	$params = array();
	$params[] = array(':seller_id', $row['id'], 'int');
	$params[] = array(':date', date('Ymd'), 'int');
	$db->query($query, $params);

	if ($db->numrows() > 0)
	{
		$pending_data = $db->fetchall();
		foreach ($pending_data as $pending)
		{
			$Auction = unserialize($pending['auction']);
			$Seller = unserialize($pending['seller']);
			$report .= "-------------------------------------------------------------------------\n" . 
						$Auction['title'] . "\n" . 
						"-------------------------------------------------------------------------\n";
			if(strlen($pending['winners']) > 0)
			{
				$report .= $MSG['453'] . ':' . "\n" . $pending['winners'] . "\n\n";
			}
			else
			{
				$report .= $MSG['1032']."\n\n";
			}
			$query = "DELETE FROM " . $DBPrefix . "pendingnotif WHERE id = :pending_id";
			$params = array();
			$params[] = array(':pending_id', $pending['id'], 'int');
			$db->query($query, $params);
		}
		include $include_path . 'email_endauction_cumulative.php';
	}
}

// send buyer fee emails
if ($buyer_fee > 0)
{
	for ($i = 0; $i < count($buyer_emails); $i++)
	{
		$emailer = new email_handler();
		$emailer->assign_vars(array(
				'ID' => $buyer_emails[$i]['id'],
				'TITLE' => $buyer_emails[$i]['title'],
				'NAME' => $buyer_emails[$i]['name'],
				'LINK' => $system->SETTINGS['siteurl'] . 'pay.php?a=6&auction_id=' . $Auction['id']
				));
		$emailer->email_uid = $buyer_emails[$i]['uid'];
		$emailer->email_sender($buyer_emails[$i]['email'], 'buyer_fee.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['522']);
	}
}
for ($i = 0; $i < count($seller_emails); $i++)
{
	$emailer = new email_handler();
	$emailer->assign_vars(array(
			'ID' => $seller_emails[$i]['id'],
			'TITLE' => $seller_emails[$i]['title'],
			'NAME' => $seller_emails[$i]['name'],
			'LINK' => $system->SETTINGS['siteurl'] . 'pay.php?a=7&auction_id=' . $Auction['id']
			));
	$emailer->email_uid = $seller_emails[$i]['uid'];
	$emailer->email_sender($seller_emails[$i]['email'], 'final_value_fee.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['523']);
}

// Purging thumbnails cache
if (!file_exists($upload_path . 'cache'))
{
	mkdir($upload_path . 'cache', 0777);
}

if (!file_exists($upload_path . 'cache/purge'))
{
	touch($upload_path . 'cache/purge');
}

$purgecachetime = filectime($upload_path . 'cache/purge');
if ((time() - $purgecachetime) > 86400)
{
	$dir = $upload_path . 'cache';
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if ($file != 'purge' && !is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > 86400)
				unlink($dir . '/' . $file);
		}
		closedir($dh);
	}
	touch($upload_path . 'cache/purge');
}

// finish cron script
printLog ("=========================== ENDING CRON: " . date('F d, Y H:i:s') . "\n");

?>