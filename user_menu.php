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

// Connect to sql server & inizialize configuration variables
include 'includes/common.inc.php';

// If user is not logged in redirect to login page
if (!$user->logged_in)
{
	header('location: user_login.php');
	exit;
}

$secid = intval($_SESSION['WEBID_LOGGED_IN']);

// Send buyer's request to the administrator
if (isset($_POST['requesttoadmin']))
{
	$emailer = new email_class();
	$emailer->assign_vars(array(
			'NAME' => $user->user_data['name'],
			'NICK' => $user->user_data['nick'],
			'EMAIL' => $user->user_data['email'],
			'ID' => $user->user_data['id']
			));
	$emailer->email_sender($system->SETTINGS['adminmail'], 'mail_buyer_request.inc.php', 'Account change request');
	$request_sent = $MSG['25_0142'];
	// Update user's status
	$query = "UPDATE " . $DBPrefix . "users SET accounttype = 'buyertoseller' WHERE id = " . $secid;
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$user->user_data['accounttype'] = 'buyertoseller';
}

$cptab = (isset($_GET['cptab'])) ? $_GET['cptab'] : '';

switch ($cptab)
{
	default:
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
	case 'account':
		$query = "SELECT COUNT(*) AS total FROM " . $DBPrefix . "messages WHERE `read` = 0 AND sentto = " . $secid;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$new_messages = mysql_result($res, 0, 'total');
		$query = "SELECT COUNT(*) AS total FROM " . $DBPrefix . "winners a
				LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
				WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0
				AND ((a.seller = " . $secid . " AND a.feedback_win = 0)
				OR (a.winner = " . $secid . " AND a.feedback_sel = 0))";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$fb_to_leave = mysql_result($res, 0, 'total');
		break;
	case 'selling':
		break;
	case 'buying':
		break;
}

$template->assign_vars(array(
		'B_REQUEST' => isset($request_sent),
		'B_TMPMSG' => isset($_SESSION['TMP_MSG']),
		'B_CANSELL' => (($system->SETTINGS['accounttype'] == 'sellerbuyer' && $user->user_data['accounttype'] == 'seller') || ($system->SETTINGS['accounttype'] == 'unique')),
		'B_ONLYBUYER' => ($system->SETTINGS['accounttype'] == 'sellerbuyer' && $user->user_data['accounttype'] == 'buyer'),
		'B_BUYTOSELL' => ($system->SETTINGS['accounttype'] == 'sellerbuyer' && $user->user_data['accounttype'] == 'buyertoseller'),

		'TMPMSG' => (isset($_SESSION['TMP_MSG'])) ? $_SESSION['TMP_MSG'] : '',
		'NEWMESSAGES' => (isset($new_messages) && $new_messages > 0) ? '( ' . $new_messages . $MSG['047'] . ' )' : '',
		'FBTOLEAVE' => (isset($fb_to_leave) && $fb_to_leave > 0) ? '( ' . $fb_to_leave . $MSG['072'] . ' )' : '',
		'REQUEST' => (isset($request_sent)) ? $request_sent : '',
		'THISPAGE' => $_SESSION['cptab']
		));

include 'header.php';
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'user_menu.html'
		));
$template->display('body');
include 'footer.php';
unset($_SESSION['TMP_MSG']);
?>
