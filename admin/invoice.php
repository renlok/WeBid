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
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$error_TPL = '';
// get form variables
$list_type = isset($_GET['type']) ? $_GET['type'] : 'a';
$group = isset($_GET['group']) ? $_GET['group'] : 'i';
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : 0;
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : 0;
$end_date = 0;	
$start_date	= 0;	
$date = date("Y-m");
$query_1 = '';



$query = "SELECT a.*, u.paid
	FROM " . $DBPrefix . "useraccounts a
	LEFT JOIN " . $DBPrefix . "userfees u ON (u.auc_id = a.auc_id)";

if ($group == 'g') {$query .= " GROUP BY a.user_id ";}

$where_sql = '';
if ($from_date != 0)
{
	$where_sql = 'a.date > ' . strtotime($from_date) . '';
}
if ($to_date != 0)
{
	if (!empty($where_sql))
	{
		$where_sql .= ' AND ';
	}
	$where_sql .= 'a.date < ' . strtotime($to_date) . '';
}


if ($list_type == 'year' || $list_type == 'm' || $list_type == 'w' || $list_type == 'd')
{
	$OFFSET = 0;
	$PAGE = 1;
	$PAGES = 1;
	$show_pagnation = false;
	if ($list_type == 'year')
	{
		$end_date = strtotime("1 year ago +1 year -1 day", strtotime(date('Y-m-01 01:00:00'))); 	
        $start_date	= strtotime("1 year ago", strtotime(date('Y-m-01 01:00:00')));
		
		$query .= $query_1 = ((!empty($where_sql)) ? ' WHERE ' . $where_sql : ' WHERE a.date > ('.$start_date.') AND a.date < ('.$end_date.')') . " ";
		
	}
	elseif ($list_type == 'm')
	{
		
		$end_date = strtotime("-1 month +1 month -1 day",strtotime(date('Y-m-01 01:00:00'))); 
        $start_date	= strtotime("-1 month",strtotime(date('Y-m-01 01:00:00')));	
		
		$query .= $query_1 = ((!empty($where_sql)) ? ' WHERE ' . $where_sql : ' WHERE a.date > ('.$start_date.') AND a.date < ('.$end_date.')') . " ";
		
	}
	elseif ($list_type == 'w')
	{
		$end_date = strtotime("-1 week +1 week",strtotime(date('Y-m-d 01:00:00')));	
        $start_date	= strtotime("-1 week",strtotime(date('Y-m-d 01:00:00')));		
		
		$query .= $query_1 = ((!empty($where_sql)) ? ' WHERE ' . $where_sql : ' WHERE a.date > ('.$start_date.') AND a.date < ('.$end_date.')') . " ";
		
	}
	else
	{
		$end_date = strtotime("-1 day +1 day");	
        $start_date	= strtotime("-1 day");
		
		$query .= $query_1 = ((!empty($where_sql)) ? ' WHERE ' . $where_sql : ' WHERE a.date > ('.$start_date.') AND a.date < ('.$end_date.')') . " ";
				
	}
}
else {

	
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

$show_pagnation = true;
   $query .= ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . " LIMIT " . $system->SETTINGS['perpage'] . " OFFSET " . intval($OFFSET);
   $query_1 .= ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '');
   $end_date = 0;	
    $start_date	= 0;

}

$query1 = "SELECT COUNT(a.id) As COUNT, SUM(a.total) As TOTAL_VAL FROM " . $DBPrefix . "useraccounts a
    LEFT JOIN " . $DBPrefix . "userfees u ON (u.auc_id = a.auc_id)";
  $query1 .= $query_1;

$result = mysql_query($query1);
$system->check_mysql($result, $query1, __LINE__, __FILE__);
$TOTALAUCTIONS = mysql_result($result, 0, 'COUNT');
$TOTAL_VALUE = mysql_result($result, 0, 'TOTAL_VAL');

$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);


//-------------------invoice mod start
   //if ($show_pagnation == true){
	//$query .= "LIMIT " . intval($OFFSET) . "," . $system->SETTINGS['perpage'];
 // }
    $res_ = mysql_query($query);
    $system->check_mysql($res_, $query, __LINE__, __FILE__);
    $total_all = 0;

   
    while ($row = mysql_fetch_assoc($res_))
    {
	
	
	
    $DATE = $row['date'] + $system->tdiff;
    if ($row['paid'] == 0)
    { $paid = "NOT PAID";
    $tick = "<img src='../images/error1.png'>";
    }
    if ($row['paid'] == 1)
    { $paid = "PAID";
    $tick = "<img src='../images/green-tick111.png'>";
    }
    // if ($row['buynow'] == 0) {$row['buynow'] = ' - ';}
    //else {$row['buynow'] = $system->print_money($row['buynow']);}

    $template->assign_block_vars('topay', array(
    'INVOICE' => $row['id'],
    'ID' => $row['auc_id'],
    'DATE' => ArrangeDateNoCorrection($DATE),
	'FEE_USER' => $row['user_id'],
    'FEE_FEATURED' => ($row['featured'] == 0) ? ' - ' : $system->print_money($row['featured']),
    'FEE_SETUP' => ($row['setup'] == 0) ? ' - ' : $system->print_money($row['setup']),
    'FEE_BOLD_ITEM' => ($row['bold'] == 0) ? ' - ' : $system->print_money($row['bold']),
    'FEE_HIGHLITED' => ($row['highlighted'] == 0) ? ' - ' : $system->print_money($row['highlighted']),
    'FEE_SUBTITLE' => ($row['subtitle'] == 0) ? ' - ' : $system->print_money($row['subtitle']),
    'RELIST_TOTAL' => ($row['relist'] == 0) ? ' - ' : $system->print_money($row['relist']),
    'FEE_RP' => ($row['reserve'] == 0) ? ' - ' : $system->print_money($row['reserve']),
    'FEE_BN' => ($row['buynow'] == 0) ? ' - ' : $system->print_money($row['buynow']),
    'PIC_TOTAL' => ($row['image'] == 0) ? ' - ' : $system->print_money($row['image']),
    'EXTRA_CAT_FEE' => ($row['extcat'] == 0) ? ' - ' : $system->print_money($row['extcat']),
    'FEE_VALUE_F' => $system->print_money($row['total']),
    'PAID' => $paid,
    'TICK' => $tick,
	'PDF' => $system->SETTINGS['siteurl'] . 'item_invoice.php?id=' . $row['auction'],
    ));
	$total_all = $row['total'] + $total_all;
	$in_date[] = $DATE;
    }
    //-------------------invoice mod end 


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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}
/*
$query = "SELECT balance, SUM(balance) as totl FROM " . $DBPrefix . "users";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_balance = mysql_result($res, 0);
$total_owned = mysql_result($res, 0, 'totl');
*/
if ($TOTALAUCTIONS == 0) {$error_TPL = "Please check selected period input.  Date or date format may not be correct or there are no fees for that period. 'Start' date must be earlier than the 'End' date";}

$template->assign_vars(array(
		'TYPE' => isset($_GET['type']) ? $_GET['type'] : 'a',
		'GROUP' => isset($_GET['group']) ? $_GET['group'] : 'i',
		'FROM_DATE' => ($from_date == 0) ? '' : $from_date,
		'TO_DATE' => ($to_date == 0) ? '' : $to_date,
		'TO_DATE_REPL' => ArrangeDateNoCorrection(strtotime(date('Y-m-d h:i:s'))),
		'PAGNATION' => $show_pagnation,
		'TOTAL_AUCT_SALES' => ($list_type == 'a') ? $system->print_money($TOTAL_VALUE) : $system->print_money($total_all),
		 'START_END_DATE' => ($start_date == 0 && $end_date == 0) ? 1 : 0,
		'CURRENCY' => $system->SETTINGS['currency'],
		'START_DATE' => ArrangeDateNoCorrection($start_date), //ArrangeDateNoCorrection(min($in_date)) ,  
		'END_DATE' =>   ArrangeDateNoCorrection($end_date), //ArrangeDateNoCorrection(max($in_date)) ,
        'ERROR' => isset($error_TPL) ? $error_TPL : '',
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $PREV . '&from_date=' .$from_date . '&to_date=' . $to_date . '&group=' . $group . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/invoice.php?PAGE=' . $NEXT . '&from_date=' .$from_date . '&to_date=' . $to_date . '&group=' . $group . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,
		'TOTALAUCTIONS' => $TOTALAUCTIONS,
		));

$template->set_filenames(array(
		'body' => 'invoice.tpl'
		));
$template->display('body');

?>
