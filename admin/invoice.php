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

define('InAdmin', 1);
$current_page = 'fees';
$extraJs = ';js/calendar.php';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

// get form variables
$group = isset($_GET['group']) ? $_GET['group'] : 'i';
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : 0;
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : 0;
$username = isset($_GET['username']) ? $_GET['username'] : 0;
$date = date('Y-m');

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
$pagenation_link = '';
if ($from_date != 0)
{
	$where_sql = 'date > ' . strtotime($from_date);
	$pagenation_link .= '&from_date=' . $from_date;
}
if ($to_date != 0)
{
	if (!empty($where_sql))
	{
		$where_sql .= ' AND ';
	}
	$where_sql .= 'date < ' . strtotime($to_date);
	$pagenation_link .= '&to_date=' . $to_date;
}
if ($username != '')
{
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = '" . mysql_escape_real_string($username) . "'";
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$user_id = mysql_result($result, 0);
	$where_sql .= 'user_id = ' . $user_id;
	$pagenation_link .= '&username=' . $username;
}
if ($group == 'g')
{
	$query .= " GROUP BY user_id ";
	$pagenation_link .= '&group=' . $group;
}
else
{
	$join_sql .= " LEFT JOIN " . $DBPrefix . "users u ON (u.id = " . $DBPrefix . "useraccounts.user_id) ";
	$pull_sql .= ', u.nick';
}

$query = "SELECT COUNT(id) As COUNT, SUM(total) As TOTAL_VAL FROM " . $DBPrefix . "useraccounts" . ((!empty($join_sql)) ? $join_sql : '') . " " . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '');

$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$TOTALAUCTIONS = mysql_result($result, 0, 'COUNT');
$TOTAL_VALUE = mysql_result($result, 0, 'TOTAL_VAL');
$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);

$query = "SELECT * " . $pull_sql . " FROM " . $DBPrefix . "useraccounts
		" . ((!empty($join_sql)) ? ' WHERE ' . $join_sql : '') . "
		" . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . " ORDER BY date LIMIT " . $OFFSET . ", " . $system->SETTINGS['perpage'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$total_all = 0;

while ($row = mysql_fetch_assoc($res))
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
	if ($row['image'] != 0)
	{
		$info .= $MSG['435'] . ' ' . $system->print_money($row['image']) . '<br>';
		$auc_id = true;
	}
	if ($row['extcat'] != 0)
	{
		$info .= $MSG['804'] . ' ' . $system->print_money($row['extcat']) . '<br>';
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
			'INVOICE' => $row['id'],
			'AUC_ID' => $row['auc_id'],
			'USER' => ($username != '') ? $row['nick'] : '',
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
        'ERROR' => isset($ERR) ? $ERR : '',

		'GROUP' => isset($_GET['group']) ? $_GET['group'] : 'i',
		'FROM_DATE' => ($from_date == 0) ? '' : $from_date,
		'TO_DATE' => ($to_date == 0) ? '' : $to_date,
		'USER_SEARCH' => ($username == '') ? '' : $username,
		'NO_USER_SEARCH' => ($username != ''),

		'PAGNATION' => ($PAGES > 1),
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $PREV . $pagenation_link . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $NEXT . $pagenation_link . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

$template->set_filenames(array(
		'body' => 'invoice.tpl'
		));
$template->display('body');
?>
