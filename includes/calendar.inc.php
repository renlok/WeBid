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
 *************************************/

if (!defined('InWeBid')) exit();

$cal_months = json_encode(array(
		$MSG['MON_001E'],
		$MSG['MON_002E'],
		$MSG['MON_003E'],
		$MSG['MON_004E'],
		$MSG['MON_005E'],
		$MSG['MON_006E'],
		$MSG['MON_007E'],
		$MSG['MON_008E'],
		$MSG['MON_009E'],
		$MSG['MON_010E'],
		$MSG['MON_011E'],
		$MSG['MON_012E'],
	));
$cal_imgpath = $system->SETTINGS['siteurl'] . "includes/img/";

$cal_invalid_date = "'Invalid date: \"' + s_date[0] + '\".\\nAccepted format is dd-mm-yyyy.'";

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$cal_invalid_date = "'Invalid date: \"' + s_date[0] + '\".\\nAccepted format is mm-dd-yyyy.'";
}

$cal_gener_date = "(d_date.getDate() < 10 ? '0' : '') + d_date.getDate() + \"-\"
		+ (d_date.getMonth() < 9 ? '0' : '') + (d_date.getMonth() + 1) + \"-\"
		+ d_date.getFullYear()";

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$cal_gener_date = "(d_date.getMonth() < 9 ? '0' : '') + (d_date.getMonth() + 1) + \"-\"
		+ (d_date.getDate() < 10 ? '0' : '') + d_date.getDate() + \"-\"
		+ d_date.getFullYear()";
}

$cal_date_parts = json_encode(array('month' => '$2', 'day' => '$1', 'year' => '$3'));

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$cal_date_parts = json_encode(array('month' => '$1', 'day' => '$2', 'year' => '$3'));
}

$cal_conf = "var A_TCALDEF = {
	'months'   : $cal_months,
	'weekdays' : ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	'yearscroll': true, // show year scroller
	'weekstart': 1, // first day of week: 0-Su or 1-Mo
	'centyear'  : 70, // 2 digit years less than 'centyear' are in 20xx, othewise in 19xx.
	'imgpath' : '$cal_imgpath',
	'invaliddate': function (s_date) { return $cal_invalid_date },
	'generdate': function (d_date) { return $cal_gener_date },
	'dateparts' : $cal_date_parts
};";

$template->assign_vars(array(
		'CAL_CONF' => $cal_conf,
		));