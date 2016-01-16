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

if (!defined('InWeBid')) exit('Access denied');

function GetLeftSeconds()
{
	$today = explode('|', date('j|n|Y|G|i|s'));
	$month = $today[1];
	$mday = $today[0];
	$year = $today[2];
	$lday = 31;
	// Calculate last day
	while (!checkdate($month, $lday, $year))
	{
		$lday--;
	}
	// Days left t the end of the month
	$daysleft = intval($lday - date('d'));
	$hoursleft = 24 - $today[3];
	$minsleft = 60 - $today[4];
	$secsleft = 60 - $today[5];
	$left = $secsleft + ($minsleft * 60) + ($hoursleft * 3600) + ($daysleft * 86400);

	return $left;
}

function FormatDate($DATE, $spacer = '/', $GMT = true)
{
	global $system;

	if (!$GMT)
	{
		$DATE += $system->tdiff;
	}

	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$F_date = date('m' . $spacer . 'd' . $spacer . 'Y', $DATE);
	}
	else
	{
		$F_date = date('d' . $spacer . 'm' . $spacer . 'Y', $DATE);
	}
	return $F_date;
}

function FormatTimeStamp($DATE, $spacer = '-')
{
	global $system;

	$DATE = explode($spacer, $DATE);
	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$F_date = mktime(0, 0, 0, $DATE[0], $DATE[1], $DATE[2]);
	}
	else
	{
		$F_date = mktime(0, 0, 0, $DATE[1], $DATE[0], $DATE[2]);
	}
	//echo ArrangeDateNoCorrection($F_date) .'<br>'; // enable to view finalized date
	return $F_date;
}

function FormatTimeLeft($diff)
{
	global $MSG;

	$days_difference = floor($diff / 86400);
	$difference = $diff % 86400;
	$hours_difference = floor($difference / 3600);
	$difference = $difference % 3600;
	$minutes_difference = floor($difference / 60);
	$seconds_difference = $difference % 60;
	$secshow = false;
	$timeleft = '';

	if ($days_difference > 0)
	{
		$timeleft = $days_difference . 'd ';
	}
	if ($hours_difference > 0)
	{
		$timeleft .= $hours_difference . 'h ';
	}
	else
	{
		$secshow = true;
	}
	if ($diff > 60)
	{
		$timeleft .= $minutes_difference . 'm ';
	}
	elseif ($diff > 60 && !$seconds)
	{
		$timeleft = '<1m';
	}
	if ($secshow)
	{
		$timeleft .= $seconds_difference . 's ';
	}
	if ($diff < 0)
	{
		$timeleft = $MSG['911'];
	}
	if (($diff * 60) < 15)
	{
		$timeleft = '<span style="color:#FF0000;">' . $timeleft . '</span>';
	}

	return $timeleft;
}

//-- Date and time hanling functions
function ActualDate()
{
	global $system;
	return date('M d, Y H:i:s', $system->ctime);
}

function ArrangeDateNoCorrection($DATE)
{
	global $MSG, $system;
	$mth = 'MON_0' . date('m', $DATE);
	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$return = $MSG[$mth] . ' ' . date('d, Y - H:i', $DATE);
	}
	else
	{
		$return = date('d', $DATE) . ' ' . $MSG[$mth] . ', ' . date('Y - H:i', $DATE);
	}
	return $return;
}
