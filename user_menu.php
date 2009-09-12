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

// Connect to sql server & inizialize configuration variables
include 'includes/common.inc.php';

// If user is not logged in redirect to login page
if (!$user->logged_in)
{
	header('location: user_login.php');
	exit;
}

function get_reminders($secid)
{
	global $DBPrefix, $system;
	$data = array();
	// get number of new messages
	$query = "SELECT COUNT(*) AS total FROM " . $DBPrefix . "messages WHERE isread = 0 AND sentto = " . $secid;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$data[] = mysql_result($res, 0, 'total');
	// get number of pending feedback
	$query = "SELECT COUNT(*) AS total FROM " . $DBPrefix . "winners a
			LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
			WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0
			AND ((a.seller = " . $secid . " AND a.feedback_win = 0)
			OR (a.winner = " . $secid . " AND a.feedback_sel = 0))";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$data[] = mysql_result($res, 0, 'total');

	return $data;
}

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
	$emailer->email_sender($system->SETTINGS['adminmail'], 'buyer_request.inc.php', 'Account change request');
	$request_sent = $MSG['25_0142'];
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
				'NEWMESSAGES' => ($reminders[0] > 0) ? $reminders[0] . ' ' . $MSG['508'] . '<br>' : '',
				'FBTOLEAVE' => ($reminders[1] > 0) ? $reminders[1] . $MSG['072'] . '<br>' : '',
				'NO_REMINDERS' => (($reminders[0] + $reminders[1]) == 0) ? $MSG['510'] : '',
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
		'B_REQUEST' => isset($request_sent),
		'B_TMPMSG' => isset($_SESSION['TMP_MSG']),
		'B_CANSELL' => ($user->can_sell),
		'B_ONLYBUYER' => (!$user->can_buy),

		'TMPMSG' => (isset($_SESSION['TMP_MSG'])) ? $_SESSION['TMP_MSG'] : '',
		'REQUEST' => (isset($request_sent)) ? $request_sent : '',
		'THISPAGE' => $_SESSION['cptab']
		));

include 'header.php';
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'user_menu.tpl'
		));
$template->display('body');
include 'footer.php';
unset($_SESSION['TMP_MSG']);
?>
