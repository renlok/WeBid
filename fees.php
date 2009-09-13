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

include 'includes/common.inc.php';

if ($system->SETTINGS['fees'] == 'y')
{
	header('location: index.php');
	exit;
}

// get fees
$query = "SELECT * FROM " . $DBPrefix . "fees";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$bgColor = '#EBEBEB';
while ($row = mysql_fetch_array($res))
{
	if ($row['type'] == 'setup')
	{
		if ($row['fee_from'] != $row['fee_to'])
		{
			$template->assign_block_vars('setup_fees', array(
					'BGCOLOUR' => ($bgColor == '#EBEBEB') ? '#FFFFFF' : '#EBEBEB',
					'FROM' => $system->print_money($row['fee_from']),
					'TO' => $system->print_money($row['fee_to']),
					'VALUE' => ($row['fee_type'] == 'flat') ? $system->print_money($row['value']) : $row['value'] . '%'
					));
		}
	}
	elseif ($row['type'] == 'signup_fee')
	{
		$template->assign_vars(array(
				'B_SIGNUP_FEE' => ($row['value'] > 0),
				'SIGNUP_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'hpfeat_fee')
	{
		$template->assign_vars(array(
				'B_HPFEAT_FEE' => ($row['value'] > 0),
				'HPFEAT_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'bolditem_fee')
	{
		$template->assign_vars(array(
				'B_BOLD_FEE' => ($row['value'] > 0),
				'BOLD_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'hlitem_fee')
	{
		$template->assign_vars(array(
				'B_HL_FEE' => ($row['value'] > 0),
				'HL_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'rp_fee')
	{
		$template->assign_vars(array(
				'B_RP_FEE' => ($row['value'] > 0),
				'RP_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'picture_fee')
	{
		$template->assign_vars(array(
				'B_PICTURE_FEE' => ($row['value'] > 0),
				'PICTURE_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'relist_fee')
	{
		$template->assign_vars(array(
				'B_RELIST_FEE' => ($row['value'] > 0),
				'RELIST_FEE' => $system->print_money($row['value'])
				));
	}
	elseif ($row['type'] == 'buyout_fee')
	{
		$template->assign_vars(array(
				'B_BUYNOW_FEE' => ($row['value'] > 0),
				'BUYNOW_FEE' => $system->print_money($row['value'])
				));
	}
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'fees.tpl'
		));
$template->display('body');
include 'footer.php';
?>
