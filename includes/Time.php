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

// work in progress
class Time
{
	private $system;
	private $tz_UTC;
	private $tz_user;

	public function __construct($timezone = '')
	{
		global $system;
		$this->system = $system;
		$this->tz_UTC = new DateTimeZone('UTC');
		if (!empty($timezone))
		{
			$this->tz_user = new DateTimeZone($timezone);
		}
		else
		{
			$this->tz_user = false;
		}
	}

	// used to be: dates.inc.php FormatDate($DATE, $spacer = '/', $GMT = true)
	public function formatTimestamp($timestamp, $format = '', $timezone_ajust = true)
	{
		if ($format == '')
		{
			$format = ($this->system->SETTINGS['datesformat'] == 'USA') ? 'm/d/Y' : 'd/m/Y';
		}

		$dt = DateTime::createFromFormat('U', $timestamp, $this->tz_UTC);
		if ($timezone_ajust && !$this->tz_user)
		{
			$dt->setTimezone($this->tz_user);
		}
		return $date->format($format);
	}

	// used to be: dates.inc.php FormatTimeStamp($DATE, $spacer = '-')
	public function dateToTimestamp($date, $format = '')
	{
		if ($format == '')
		{
			$format = ($this->system->SETTINGS['datesformat'] == 'USA') ? 'm/d/Y' : 'd/m/Y';
		}
		$dt = DateTime::createFromFormat($format, $date, $this->tz_UTC);
		return $dt->format('U');
	}

	public function formatTimeLeft($diff)
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

	private function getConvertedDateTimeObject($timestamp, $userTimezone)
	{
		# create server and user timezone objects
		$toZone = new DateTimeZone($userTimezone); // Europe/London, or whatever it happens to be

		$dt = DateTime::createFromFormat('U', $timestamp, $this->tz_UTC);
		$dt->setTimezone($toZone);
		return $dt;
	}

	public function getUserTimestamp($timestamp, $userTimezone)
	{
		$dt = $this->getConvertedDateTimeObject($timestamp, $userTimezone);
		return $dt->getTimestamp();
	}

	public function getUserOffset($timestamp, $userTimezone)
	{
		$dt = $this->getConvertedDateTimeObject($timestamp, $userTimezone);
		return $dt->getOffset();
	}
}
