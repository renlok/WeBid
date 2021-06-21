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

// Connect to sql server & inizialize configuration variables
include 'common.php';

// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	header('location: user_login.php');
	exit;
}

function get_reminders($secid)
{
	global $DBPrefix, $db;
	$data = array();

	// get number of new messages
	$query = "SELECT COUNT(*) AS total FROM " . $DBPrefix . "messages
			WHERE isread = 0 AND sentto = :sec_id";
	$params = array();
	$params[] = array(':sec_id', $secid, 'int');
	$db->query($query, $params);
	$data[] = $db->result('total');

	// get number of pending feedback
	$query = "SELECT COUNT(DISTINCT a.auction) AS total FROM " . $DBPrefix . "winners a
			LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
			WHERE (b.closed = 1 OR b.bn_only = 1) AND b.suspended = 0
			AND ((a.seller = :seller AND a.feedback_sel = 0)
			OR (a.winner = :winner AND a.feedback_win = 0))";
	$params = array();
	$params[] = array(':seller', $secid, 'int');
	$params[] = array(':winner', $secid, 'int');
	$db->query($query, $params);
	$data[] = $db->result('total');

	// get auctions still requiring payment
	$query = "SELECT COUNT(DISTINCT id) AS total FROM " . $DBPrefix . "winners
			WHERE paid = 0 AND winner = :winner_id";
	$params = array();
	$params[] = array(':winner_id', $secid, 'int');
	$db->query($query, $params);
	$data[] = $db->result('total');

	// get auctions ending soon
	$query = "SELECT COUNT(DISTINCT b.auction) AS total FROM " . $DBPrefix . "bids b
			LEFT JOIN " . $DBPrefix . "auctions a ON (b.auction = a.id)
			WHERE b.bidder = :bidder AND a.ends <= :timer
			AND a.closed = 0 AND a.bn_only = 0 GROUP BY b.auction";
	$params = array();
	$params[] = array(':bidder', $secid, 'int');
	$params[] = array(':timer', (time() + (3600 * 24)), 'int');
	$db->query($query, $params);
	$data[] = ($db->numrows() > 0) ? $db->result('total') : 0;

	// get outbid auctions
	$query = "SELECT a.current_bid, a.id, a.title, a.ends, b.bid
			FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "bids b
			WHERE a.id = b.auction AND a.closed = 0 AND b.bidder = :bidder
			AND a.bn_only = 'n' ORDER BY a.ends ASC, b.bidwhen DESC";
	$params = array();
	$params[] = array(':bidder', $secid, 'int');
	$db->query($query, $params);
	$idcheck = array();
	$auctions_count = 0;
	while ($row = $db->fetch())
	{
		if (!in_array($row['id'], $idcheck))
		{
			// Outbidded or winning bid
			if ($row['current_bid'] != $row['bid']) $auctions_count++;;
			$idcheck[] = $row['id'];
		}
	}
	$data[] = $auctions_count;

	// get auctions sold item
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE b.closed = 1 AND a.seller = :sellers AND a.is_read = 0";
	$params = array();
	$params[] = array(':sellers', $secid, 'int');
	$db->query($query, $params);
	$data[] =  $db->result('total');

	return $data;
}

// Send buyer's request to the administrator
if (isset($_POST['requesttoadmin']) && $system->SETTINGS['user_request_seller_permission'])
{
	$emailer = new email_handler();
	$emailer->assign_vars(array(
			'NAME' => $user->user_data['name'],
			'NICK' => $user->user_data['nick'],
			'EMAIL' => $user->user_data['email'],
			'ID' => $user->user_data['id']
			));
	$emailer->email_sender($system->SETTINGS['adminmail'], 'buyer_request.inc.php', $MSG['820']);
	$_SESSION['TMP_MSG'] = $MSG['25_0142'];
}

$cptab = (isset($_GET['cptab'])) ? $_GET['cptab'] : '';

switch ($cptab)
{
	default:
	case 'summary':
		$_SESSION['cptab'] = 'summary';
		break;
	case 'account':
		$_SESSION['cptab'] = 'account';
		break;
	case 'selling':
		$_SESSION['cptab'] = 'selling';
		break;
	case 'buying':
		$_SESSION['cptab'] = 'buying';
		break;
}

switch ($_SESSION['cptab'])
{
	default:
	case 'summary':
		$reminders = get_reminders($user->user_data['id']);
		$template->assign_vars(array(
				'NEWMESSAGES' => ($reminders[0] > 0) ? $reminders[0] . ' ' . $MSG['508'] . ' (<a href="' . $system->SETTINGS['siteurl'] . 'mail.php">' . $MSG['5295'] . '</a>)<br>' : '',
				'FBTOLEAVE' => ($reminders[1] > 0) ? $reminders[1] . $MSG['072'] . ' (<a href="' . $system->SETTINGS['siteurl'] . 'buysellnofeedback.php">' . $MSG['5295'] . '</a>)<br>' : '',
				'TO_PAY' => ($reminders[2] > 0) ? sprintf($MSG['792'], $reminders[2]) . ' (<a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php">' . $MSG['5295'] . '</a>)<br>' : '',
				'BENDING_SOON' => ($reminders[3] > 0) ? $reminders[3] . $MSG['793'] . ' (<a href="' . $system->SETTINGS['siteurl'] . 'yourbids.php">' . $MSG['5295'] . '</a>)<br>' : '',
				'BOUTBID' => ($reminders[4] > 0) ? sprintf($MSG['794'], $reminders[4]) . ' (<a href="' . $system->SETTINGS['siteurl'] . 'yourbids.php">' . $MSG['5295'] . '</a>)<br>' : '',
				'SOLD_ITEMS' => ($reminders[5] > 0) ? sprintf($MSG['870'], $reminders[5]) . ' (<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php">' . $MSG['5295'] . '</a>)<br>' : '',
				'NO_REMINDERS' => (($reminders[0] + $reminders[1] + $reminders[2] + $reminders[3] + $reminders[4] + $reminders[5]) == 0) ? $MSG['510'] : '',

				));
		break;
	case 'account':
		$reminders = get_reminders($user->user_data['id']);
		$template->assign_vars(array(
				'NEWMESSAGES' => ($reminders[0] > 0) ? '( ' . $reminders[0] . ' ' . $MSG['508'] . ' )' : '',
				'FBTOLEAVE' => ($reminders[1] > 0) ? '( ' . $reminders[1] . $MSG['072'] . ' )' : ''
				));
		break;
	case 'selling':
		break;
	case 'buying':
		break;
}

$template->assign_vars(array(
		'B_CANSELL' => ($user->can_sell),
		'B_CANREQUESTSELL' => ($system->SETTINGS['user_request_seller_permission']),

		'TMPMSG' => (isset($_SESSION['TMP_MSG'])) ? $_SESSION['TMP_MSG'] : '',
		'THISPAGE' => $_SESSION['cptab']
		));

include 'header.php';
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'user_menu.tpl'
		));
$template->display('body');
include 'footer.php';
unset($_SESSION['TMP_MSG']);
