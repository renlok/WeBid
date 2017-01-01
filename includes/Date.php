<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) {
    exit('Access denied');
}

class Date
{
    public $timezone;
    public $UTCtimezone;
    private $defaultformat;

    public function __construct($system, $user)
    {
        $timezone = $system->SETTINGS['timezone'];
        if ($user->logged_in) {
            $timezone = $user->user_data['timezone'];
        }
        $this->timezone = new DateTimeZone($timezone);
        $this->UTCtimezone = new DateTimeZone('UTC');

        if ($system->SETTINGS['datesformat'] == 'USA') {
            $this->defaultformat = 'm/d/Y';
        } else {
            $this->defaultformat = 'd/m/Y';
        }
    }

    // convert datetime from UTC to users timezone
    public function printDateTz($datetime, $UTC_input = true)
    {
        if ($UTC_input) {
            $UTC_time = new DateTime($datetime, $this->UTCtimezone);
            $UTC_time->setTimezone($this->timezone);
            return $UTC_time->format('Y-m-d H:i');
        } else {
            $tmp = new DateTime($datetime, $this->timezone);
            return $tmp->format('Y-m-d H:i');
        }
    }

    public function currentDatetime($UTC = false)
    {
        if ($UTC) {
            $datetime = new DateTime('now', $this->UTCtimezone);
        } else {
            $datetime = new DateTime('now', $this->timezone);
        }
        return $datetime->format('Y-m-d H:i:s');
    }

    // convert raw date string into datetime UTC timezone
    public function convertToDatetime($raw_date, $format = false)
    {
        if (!$format) {
            $datetime = DateTime::createFromFormat($this->defaultformat, $raw_date, $this->timezone);
        } else {
            $datetime = new DateTime(strtotime($raw_date), $this->timezone);
        }
        $datetime->setTimezone($this->UTCtimezone);
        return $datetime->format('Y-m-d H:i:s');
    }

    public function convertToUTC($raw_date)
    {
        $UTC_time = new DateTime($raw_date, $this->timezone);
        $UTC_time->setTimezone($this->UTCtimezone);
        return $UTC_time->format('Y-m-d H:i:s');
    }

    public function formatDate($raw_date, $format = false, $UTC_input = true)
    {
        if ($UTC_input) {
            $datetime = new DateTime($raw_date, $this->UTCtimezone);
            $datetime->setTimezone($this->timezone);
        } else {
            $datetime = new DateTime($raw_date, $this->timezone);
        }
        if (!$format) {
            return $datetime->format($this->defaultformat);
        } else {
            return $datetime->format($format);
        }
    }

    public function formatTimeLeft($diff)
    {
        global $MSG;

        $timeleft = '';
        if ($diff->y > 0) {
            $timeleft = $diff->y . $MSG['year_s'];
        } elseif ($diff->m > 0) {
            $timeleft = $diff->m . $MSG['month_s'];
        } elseif ($diff->d > 0) {
            $timeleft = $diff->d . $MSG['day_short'] . ' ';
            if ($diff->h > 0) {
                $timeleft .= $diff->h . $MSG['hour_short'] . ' ';
            }
        } else {
            if ($diff->h > 0) {
                $timeleft .= $diff->h . $MSG['hour_short'] . ' ';
            }
            if ($diff->m > 0) {
                $timeleft .= $diff->m . $MSG['minute_short'] . ' ';
            } elseif ($diff->h == 0 && $diff->m == 0 && $diff->s > 0) {
                $timeleft = '<1' . $MSG['minute_short'];
            }
            if ($diff->invert) {
                $timeleft = $MSG['911'];
            }
        }
        if ($diff->y == 0 && $diff->m == 0 && $diff->d == 0 && $diff->h == 0 && $diff->m < 15) {
            $timeleft = '<span style="color:#FF0000;">' . $timeleft . '</span>';
        }

        return $timeleft;
    }
}
