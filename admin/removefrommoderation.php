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

define('InAdmin', 1);
$current_page = 'auctions';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include INCLUDE_PATH . 'functions_sell.php';
include 'loggedin.inc.php';
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';

if (!isset($_REQUEST['id']))
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == "Yes")
{
	$id = intval($_POST['id']);

	$query = "DELETE FROM `" . $DBPrefix . "auction_moderation` WHERE auction_id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $id, 'int');
			$db->query($query, $params);

	$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == "No")
{
	$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$query = "SELECT u.nick, a.title, a.starts, a.description, a.category, d.description as duration,
		a.suspended, a.current_bid, a.quantity, a.reserve_price
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "durations d ON (d.days = a.duration)
		WHERE a.id = :auc_id";
$params = array();
$params[] = array(':auc_id', $_GET['id'], 'int');
$db->query($query, $params);
$auc_data = $db->result();

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$date = date('m/d/Y', $auc_data['starts'] + $system->tdiff);
}
else
{
	$date = date('d/m/Y', $auc_data['starts'] + $system->tdiff);
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'PAGE_TITLE' => $MSG['remove_auction_from_moderation'],
		'ID' => $_GET['id'],
		'TITLE' => htmlspecialchars($auc_data['title']),
		'NICK' => $auc_data['nick'],
		'STARTS' => $date,
		'DURATION' => $auc_data['duration'],
		'CATEGORY' => $category_names[$auc_data['category']],
		'DESCRIPTION' => $auc_data['description'],
		'CURRENT_BID' => $system->print_money($auc_data['current_bid']),
		'QTY' => $auc_data['quantity'],
		'RESERVE_PRICE' => $system->print_money($auc_data['reserve_price']),
		'SUSPENDED' => $auc_data['suspended'],
		'OFFSET' => $_REQUEST['offset']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'removefrommoderation.tpl'
		));
$template->display('body');
include 'footer.php';
?>
