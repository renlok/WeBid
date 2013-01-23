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
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'selling.php';
	header('location: user_login.php');
	exit;
}

if (isset($_GET['paid']))
{
	$query = "UPDATE " . $DBPrefix . "winners SET paid = 1 WHERE id = " . intval($_GET['paid']) . " AND seller = " . $user->user_data['id'];
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
}

$searchid = (isset($_GET['id'])) ? ' AND b.id = ' . intval($_GET['id']) : '';

// Get closed auctions with winners
$query = "SELECT a.auction, b.title, b.ends
		 FROM " . $DBPrefix . "winners a, " . $DBPrefix . "auctions b
		 WHERE a.auction = b.id AND (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0 AND b.user = " . $user->user_data['id'] . $searchid . "
		 GROUP BY b.id ORDER BY a.closingdate DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$sslurl = ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y') ? str_replace('http://', 'https://', $system->SETTINGS['siteurl']) : $system->SETTINGS['siteurl'];
$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;

$i = 0;
while ($row = mysql_fetch_array($res))
{
	$template->assign_block_vars('a', array(
			'TITLE' => $row['title'],
			'ENDS' => FormatDate($row['ends']),
			'AUCTIONID' => $row['auction']
			));

	// Build winners array
	$query = "SELECT w.*, u.nick, u.email FROM " . $DBPrefix . "winners w
			LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.winner)
			WHERE w.auction = " . $row['auction'];
	$rr = mysql_query($query);
	$system->check_mysql($rr, $query, __LINE__, __FILE__);
	while ($winner = mysql_fetch_array($rr))
	{
		$fblink = ($winner['feedback_sel'] == 0) ? '(<a href="' . $sslurl . 'feedback.php?auction_id=' . $row['auction'] . '&wid=' . $winner['winner'] . '&sid=' . $winner['seller'] . '&ws=s">' . $MSG['207'] . '</a>)' : '';
		$template->assign_block_vars('a.w', array(
				'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
				'ID' => $winner['id'],
				'BID' => $winner['bid'],
				'BIDF' => $system->print_money($winner['bid']),
				'QTY' => $winner['qty'],
				'NICK' => $winner['nick'],
				'WINNERID' => $winner['winner'],
				'FB' => $fblink,

				'B_PAID' => ($winner['paid'] == 1)
				));
		$i++;
	}
}

$template->assign_vars(array(
		'NUM_WINNERS' => $i,
		'AUCID' => (!empty($searchid)) ? '&id=' . $searchid : '',
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
?>
