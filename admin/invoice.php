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
$current_page = 'fees';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

// get form variables
$group = isset($_GET['group']) ? $_GET['group'] : 'i';
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : 0;
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : 0;
$username = isset($_GET['username']) ? $_GET['username'] : '';
$searchuser = (isset($_GET['username']) && !empty($_GET['username'])) ? true : false;

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1)
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = (($PAGE - 1) * $system->SETTINGS['perpage']);
}

$where_sql = '';
$join_sql = '';
$pull_sql = '';
$group_sql = '';
$pagenation_link = '';
$params = array();
// if we are searching for a user get their id
if ($searchuser)
{
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = :nick";
	$params = array();
	$params[] = array(':nick', $system->cleanvars($username), 'str');
	$db->query($query, $params);
	$user_id = $db->result('id');
	$where_sql .= 'user_id = :user_id';
	$params[] = array(':user_id', $user_id, 'int');
	$pagenation_link .= '&username=' . $username;
}
// within a timeframe?
if ($from_date != 0)
{
	if (!empty($where_sql))
	{
		$where_sql .= ' AND ';
	}
	$where_sql = 'date > :from_date';
	$params[] = array(':from_date', strtotime($from_date), 'int');
	$pagenation_link .= '&from_date=' . $from_date;
}
if ($to_date != 0)
{
	if (!empty($where_sql))
	{
		$where_sql .= ' AND ';
	}
	$where_sql .= 'date < :to_date';
	$params[] = array(':to_date', strtotime($to_date), 'int');
	$pagenation_link .= '&to_date=' . $to_date;
}
if ($group == 'g')
{
	$group_sql = " GROUP BY user_id ";
	$pagenation_link .= '&group=' . $group;
}

$join_sql .= " LEFT JOIN " . $DBPrefix . "users u ON (u.id = " . $DBPrefix . "useraccounts.user_id) ";
$pull_sql .= ', u.nick';

$query = "SELECT COUNT(" . $DBPrefix . "useraccounts.useracc_id) As COUNT, SUM(total) As TOTAL_VAL FROM " . $DBPrefix . "useraccounts" . ((!empty($join_sql)) ? $join_sql : '') . " " . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . " " . ((!empty($group_sql)) ? $group_sql : '');

$db->query($query, $params);
$TOTALAUCTIONS = $db->result('COUNT');
$TOTAL_VALUE = $db->result('TOTAL_VAL');
$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);

$query = "SELECT * " . $pull_sql . " FROM " . $DBPrefix . "useraccounts
		" . ((!empty($join_sql)) ? $join_sql : '') . "
		" . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . "
		" . ((!empty($group_sql)) ? $group_sql : '') . " ORDER BY date LIMIT :OFFSET , :perpage";
$params[] = array(':OFFSET', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$total_all = 0;

while ($row = $db->fetch())
{
	$DATE = $row['date'] + $system->tdiff;

	// build invoice info
	$info = '';
	$auc_id = false;
	if ($row['setup'] != 0)
	{
		$info .= $MSG['432'] . ' ' . $system->print_money($row['setup']) . '<br>';
		$auc_id = true;
	}
	if ($row['featured'] != 0)
	{
		$info .= $MSG['433'] . ' ' . $system->print_money($row['featured']) . '<br>';
		$auc_id = true;
	}
	if ($row['bold'] != 0)
	{
		$info .= $MSG['439'] . ' ' . $system->print_money($row['bold']) . '<br>';
		$auc_id = true;
	}
	if ($row['highlighted'] != 0)
	{
		$info .= $MSG['434'] . ' ' . $system->print_money($row['highlighted']) . '<br>';
		$auc_id = true;
	}
	if ($row['subtitle'] != 0)
	{
		$info .= $MSG['803'] . ' ' . $system->print_money($row['subtitle']) . '<br>';
		$auc_id = true;
	}
	if ($row['relist'] != 0)
	{
		$info .= $MSG['437'] . ' ' . $system->print_money($row['relist']) . '<br>';
		$auc_id = true;
	}
	if ($row['reserve'] != 0)
	{
		$info .= $MSG['440'] . ' ' . $system->print_money($row['reserve']) . '<br>';
		$auc_id = true;
	}
	if ($row['buynow'] != 0)
	{
		$info .= $MSG['436'] . ' ' . $system->print_money($row['buynow']) . '<br>';
		$auc_id = true;
	}
	if ($row['picture'] != 0)
	{
		$info .= $MSG['435'] . ' ' . $system->print_money($row['picture']) . '<br>';
		$auc_id = true;
	}
	if ($row['extracat'] != 0)
	{
		$info .= $MSG['804'] . ' ' . $system->print_money($row['extracat']) . '<br>';
		$auc_id = true;
	}
	if ($row['signup'] != 0)
	{
		$info .= $MSG['768'] . ' ' . $system->print_money($row['signup']) . '<br>';
	}
	if ($row['buyer'] != 0)
	{
		$info .= $MSG['775'] . ' ' . $system->print_money($row['buyer']) . '<br>';
		$auc_id = true;
	}
	if ($row['finalval'] != 0)
	{
		$info .= $MSG['791'] . ' ' . $system->print_money($row['finalval']) . '<br>';
		$auc_id = true;
	}
	if ($row['balance'] != 0)
	{
		$info .= $MSG['935'] . ' ' . $system->print_money($row['balance']) . '<br>';
	}

	if ($auc_id)
	{
		$info = '<strong>' . $MSG['1034'] . ' ' . $row['auc_id'] . '</strong><br>' . $info;
	}

	$template->assign_block_vars('invoices', array(
			'INVOICE' => $row['useracc_id'],
			'AUC_ID' => $row['auc_id'],
			'USER' => (!$searchuser) ? $row['nick'] : '',
			'DATE' => ArrangeDateNoCorrection($DATE),
			'INFO' => $info,
			'TOTAL' => $system->print_money($row['total']),
			'PAID' => ($row['paid'] == 1), // true if paid
			'PDF' => $system->SETTINGS['siteurl'] . 'item_invoice.php?id=' . $row['auc_id'],
			));
	$total_all = $row['total'] + $total_all;
	$in_date[] = $DATE;
}

// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $COUNTER . $pagenation_link . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$_SESSION['INVOICE_RETURN'] = 'admin/invoice.php';
$template->assign_vars(array(
		'GROUP' => isset($_GET['group']) ? $_GET['group'] : 'i',
		'FROM_DATE' => ($from_date == 0) ? '' : $from_date,
		'TO_DATE' => ($to_date == 0) ? '' : $to_date,
		'USER_SEARCH' => (!$searchuser) ? '' : $username,
		'NO_USER_SEARCH' => (!$searchuser),
		'HASH' => $_SESSION['WEBID_ADMIN_NUMBER'],

		'PAGNATION' => ($PAGES > 1),
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $PREV . $pagenation_link . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $NEXT . $pagenation_link . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'invoice.tpl'
		));
$template->display('body');
include 'footer.php';
?>
