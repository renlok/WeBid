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

if (!defined('InWeBid')) exit('Access denied');

if (!function_exists('GetLeftSeconds'))
{
	function GetLeftSeconds()
	{
		$today = explode('|', gmdate('j|n|Y|G|i|s'));
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
		$daysleft = intval($lday - gmdate('d'));
		$hoursleft = 24 - $today[3];
		$minsleft = 60 - $today[4];
		$secsleft = 60 - $today[5];
		$left = $secsleft + ($minsleft * 60) + ($hoursleft * 3600) + ($daysleft * 86400);
		
		return $left;
	}
}

if (!function_exists('FormatDate'))
{
	function FormatDate($DATE, $spacer = '/', $GMT = true)
	{
		global $system;

		if (!$GMT)
		{
			$DATE += $system->tdiff;
		}

		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$F_date = gmdate('m' . $spacer . 'd' . $spacer . 'Y', $DATE);
		}
		else
		{
			$F_date = gmdate('d' . $spacer . 'm' . $spacer . 'Y', $DATE);
		}
		return $F_date;
	}
}

if (!function_exists('FormatTimeStamp'))
{
	function FormatTimeStamp($DATE, $spacer = '/')
	{
		global $system;

		$DATE = explode($spacer, $DATE);
		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$F_date = _gmmktime(0, 0, 0, $DATE[0], $DATE[1], $DATE[2]);
		}
		else
		{
			$F_date = _gmmktime(0, 0, 0, $DATE[1], $DATE[0], $DATE[2]);
		}
		return $F_date;
	}
}

if (!function_exists('FormatTimeLeft'))
{
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
}

//-- Date and time hanling functions
if (!function_exists('ActualDate'))
{
	function ActualDate()
	{
		global $system;
		return gmdate('M d, Y H:i:s', $system->ctime);
	}
}

if (!function_exists('ArrangeDateNoCorrection'))
{
	function ArrangeDateNoCorrection($DATE)
	{
		global $MSG, $system;
		$mth = 'MON_0' . gmdate('m', $DATE);
		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$return = $MSG[$mth] . ' ' . gmdate('d, Y - H:i', $DATE);
		}
		else
		{
			$return = gmdate('d', $DATE) . ' ' . $MSG[$mth] . ', ' . gmdate('Y - H:i', $DATE);
		}
		return $return;
	}
}
?>