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

if (!defined('InWeBid')) exit('Access denied');

if (!function_exists('GetLeftSeconds'))
{
	function GetLeftSeconds()
	{
		$today = getdate();
		$month = $today['mon'];
		$mday = $today['mday'];
		$year = $today['year'];
		$lday = 31;
		// Calculate last day
		while (!checkdate($month, $lday, $year))
		{
			$lday--;
		}
		// Days left t the end of the month
		$daysleft = intval($lday - date('d'));
		$hoursleft = 24 - $today['hours'];
		$minsleft = 60 - $today['minutes'];
		$secsleft = 60 - $today['seconds'];
		$left = $secsleft + ($minsleft * 60) + ($hoursleft * 3600) + ($daysleft * 86400);
		
		return $left;
	}
}

if (!function_exists('FormatDate'))
{
	function FormatDate($DATE)
	{
		global $system;
		
		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$F_date = gmdate('m/d/Y', $DATE);
		}
		else
		{
			$F_date = gmdate('d/m/Y', $DATE);
		}
		return $F_date;
	}
}

if (!function_exists('FormatTimeStamp'))
{
	function FormatTimeStamp($DATE)
	{
		global $system;

		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$F_date = substr($DATE,5,2) . '/' . substr($DATE,8,2) . '/' . substr($DATE,0,4);
		}
		else
		{
			$F_date = substr($DATE,8,2) . '/' . substr($DATE,5,2) . '/' . substr($DATE,0,4);
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
		global $MSG;
		$mth = 'MON_0' . gmdate('m', $DATE);
		$return = $MSG[$mth] . ' ' . gmdate('d, Y - H:i', $DATE);
		return $return;
	}
}

if (!function_exists('ArrangeDateNoCorrMesCompleto'))
{
	function ArrangeDateNoCorrMesCompleto($day, $month, $year, $hours, $minutes)
	{
		global $MSG;
		$DATE = gmmktime($hours, $minutes, 0, $month, $day, $year);
		$mth = 'MON_0' . gmdate('m', $DATE) . 'E';
		$return = $MSG[$mth] . ' ' . gmdate('d, Y - H:i', $DATE);
		return $return;
	}
}
?>