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

define('InAdmin', 1);
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$fees = array( //0 = single value, 1 = staged fees
	'signup_fee' => 0,
	'setup' => 1,
	'endauction' => 1,
	'hpfeat_fee' => 0,
	'bolditem_fee' => 0,
	'hlitem_fee' => 0,
	'rp_fee' => 0,
	'picture_fee' => 0,
	'relist_fee' => 0,
	'buyout_fee' => 0
	);
	
$feenames = array(
	'signup_fee' => $MSG['430'],
	'setup' => $MSG['432'],
	'endauction' => $MSG['438'],
	'hpfeat_fee' => $MSG['433'],
	'bolditem_fee' => $MSG['439'],
	'hlitem_fee' => $MSG['434'],
	'rp_fee' => $MSG['440'],
	'picture_fee' => $MSG['435'],
	'relist_fee' => $MSG['437'],
	'buyout_fee' => $MSG['436']
	);
	
if(isset($_GET['type']) && isset($fees[$_GET['type']]))
{
	if($fees[$_GET['type']] == 0)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'update')
		{
			if(!$system->CheckMoney($_POST['value']))
			{
				$errmsg = $ERR_058;
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "fees SET value = '" . $_POST['value'] . "' WHERE type = '" . $_GET['type'] . "'";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$errmsg = $feenames[$_GET['type']] . $MSG['359'];
			}
		}
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = '" . $_GET['type'] . "'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$value = mysql_result($res, 0);
		
		$template->assign_vars(array(
				'VALUE' => $system->print_money_nosymbol($value),
				'CURRENCY' => $system->SETTINGS['currency']
				));
	}
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'B_SINGLE' => (isset($_GET['type']) && isset($fees[$_GET['type']]) && $fees[$_GET['type']] == 0) ? true : false,
		'FEETYPE' => (isset($_GET['type']) && isset($feenames[$_GET['type']])) ? $feenames[$_GET['type']] : '',
		'ERROR' => (isset($errmsg)) ? $errmsg : ''
		));

$template->set_filenames(array(
		'body' => 'adminfees.html'
		));
$template->display('body');
?>
