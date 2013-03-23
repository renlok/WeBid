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

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

function ToBeDeleted($index)
{
	global $delete;

	if (in_array($index, $delete))
	{
		return true;
	}
	return false;
}

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] = 'update')
{
	$ids = $_POST['id'];
	$increments = $_POST['increments'];
	$lows = $_POST['lows'];
	$highs = $_POST['highs'];
	$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();

	for ($i = 0; $i < count($increments); $i++)
	{
		if (!empty($lows[$i]) && !empty($highs[$i]) && !empty($increments[$i]) && !ToBeDeleted($ids[$i]))
		{
			if (!$system->CheckMoney($lows[$i]) || !$system->CheckMoney($highs[$i]) || !$system->CheckMoney($increments[$i]))
			{
				$ERR = $ERR_030;
			}
			if ($lows[$i] > $highs[$i])
			{
				$ERR = $ERR_713;
			}
		}
	}

	if (!isset($ERR))
	{
		for ($i = 0; $i < count($increments); $i++)
		{
			if (!ToBeDeleted($ids[$i]))
			{
				if (!(intval($lows[$i]) == 0 && intval($highs[$i]) == 0 && intval($increments[$i]) == 0))
				{
					if (!isset($ids[$i]) || empty($ids[$i]))
					{
						$query = "INSERT INTO " . $DBPrefix . "increments VALUES
								('NULL', " . $system->input_money($lows[$i]) . ", " . $system->input_money($highs[$i]) . ", " . $system->input_money($increments[$i]) . ")";
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "increments SET
								low = " . $system->input_money($lows[$i]) . ",
								high = " . $system->input_money($highs[$i]) . ",
								increment = " . $system->input_money($increments[$i]) . "
								WHERE id = " . $ids[$i];
					}
				}
			}
			else
			{
				$query = "DELETE FROM " . $DBPrefix . "increments WHERE id = " . $ids[$i];
			}
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		$ERR = $MSG['160'];
	}
}

$query = "SELECT * FROM " . $DBPrefix . "increments ORDER BY low";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res))
{
	$template->assign_block_vars('increments', array(
			'ID' => $row['id'],
			'HIGH' => $system->print_money_nosymbol($row['high']),
			'LOW' => $system->print_money_nosymbol($row['low']),
			'INCREMENT' => $system->print_money_nosymbol($row['increment'])
			));
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'increments.tpl'
		));
$template->display('body');
?>