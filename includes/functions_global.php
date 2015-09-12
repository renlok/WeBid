<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2015 WeBid
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

class global_class
{
	var $SETTINGS, $ctime, $tdiff;

	function global_class()
	{
		global $DBPrefix, $main_path, $db;

		// Load settings
		$this->loadsettings();
		$this->tdiff = ($this->SETTINGS['timecorrection'] + date('I')) * 3600;
		$this->ctime = time() + $this->tdiff;
		// check install directory
		if (is_dir($main_path . 'install'))
		{
			if (!$this->check_maintainance_mode()) // check maint mode
			{
				echo 'please delete the install directory';
				exit;
			}
		}

		// Check ip
		if (!defined('ErrorPage') && !defined('InAdmin'))
		{
			$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE ip = :user_ip AND action = 'deny'";
			$params = array();
			$params[] = array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str');
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$_SESSION['msg_title'] = $MSG['2_0027'];
				$_SESSION['msg_body'] = $MSG['2_0026'];
				header('location: message.php');
				exit;
			}
		}
	}

	function loadsettings()
	{
		global $DBPrefix, $db;
		$query = "SELECT * FROM " . $DBPrefix . "settings";
		$db->direct_query($query);
		
		$this->SETTINGS = $db->result();
		$this->SETTINGS['gatways'] = array(
			'paypal' => 'PayPal',
			'authnet' => 'Authorize.net',
			'worldpay' => 'WorldPay',
			'moneybookers' => 'Moneybookers',
			'toocheckout' => '2Checkout'
			);
	}

	/* possible types cron, error, admin, user, mod */
	function log($type, $message, $user = 0, $action_id = 0)
	{
		global $DBPrefix, $db;
		$query = "INSERT INTO " . $DBPrefix . "logs (type, message, ip, action_id, user_id, timestamp) VALUES
				(:type, :message, :user_ip, :action_id, :user_id, :time)";
		$params = array();
		$params[] = array(':type', $type, 'str');
		$params[] = array(':message', $message, 'str');
		$params[] = array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str');
		$params[] = array(':action_id', $action_id, 'int');
		$params[] = array(':user_id', $user, 'int');
		$params[] = array(':time', time(), 'int');
		$db->query($query, $params);
	}

	function check_maintainance_mode()
	{
		global $DBPrefix, $user, $db;

		if (!isset($this->SETTINGS['MAINTAINANCE']))
		{
			$query = "SELECT * FROM " . $DBPrefix . "maintainance";
			$db->direct_query($query);

			if ($db->numrows() > 0)
			{
				$this->SETTINGS['MAINTAINANCE'] = $db->result();
			}
			else
			{
				return false;
			}
		}

		if ($this->SETTINGS['MAINTAINANCE']['active'] == 'y')
		{
			if ($user->logged_in && ($user->user_data['nick'] == $this->SETTINGS['MAINTAINANCE']['superuser'] || $user->user_data['id'] == $this->SETTINGS['MAINTAINANCE']['superuser']))
			{
				return false;
			}
			return true;
		}

		return false;
	}

	function cleanvars($i, $trim = false)
	{ 
		if ($trim)
			$i = trim($i);
		if (!get_magic_quotes_gpc())
			$i = addslashes($i);
		$i = rtrim($i);
		$look = array('&', '#', '<', '>', '"', '\'', '(', ')', '%');
		$safe = array('&amp;', '&#35;', '&lt;', '&gt;', '&quot;', '&#39;', '&#40;', '&#41;', '&#37;');
		$i = str_replace($look, $safe, $i);
		return $i;
	}

	function uncleanvars($i)
	{
		$look = array('&', '#', '<', '>', '"', '\'', '(', ')', '%');
		$safe = array('&amp;', '&#35;', '&lt;', '&gt;', '&quot;', '&#39;', '&#40;', '&#41;', '&#37;');
		$i = str_replace($safe, $look, $i);
		return $i;
	}

	function filter($txt)
	{
		global $DBPrefix, $db;
		$query = "SELECT * FROM " . $DBPrefix . "filterwords";
		$db->direct_query($query);
		while ($word = $db->fetch())
		{
			$txt = preg_replace('(' . $word['word'] . ')', '', $txt); //best to use str_ireplace but not avalible for PHP4
		}
		return $txt;
	}

	function move_file($from, $to, $removeorg = true)
	{
		$upload_mode = (@ini_get('open_basedir') || @ini_get('safe_mode') || strtolower(@ini_get('safe_mode')) == 'on') ? 'move' : 'copy';
		switch ($upload_mode)
		{
			case 'copy':
				if (@copy($from, $to))
				{
					if (!@move_uploaded_file($from, $to))
					{
						return false;
					}
				}
				if ($removeorg)
					@unlink($from);
				break;
			
			case 'move':
				if (!@move_uploaded_file($from, $to))
				{
					if (!@copy($from, $to))
					{
						return false;
					}
				}
				if ($removeorg)
					@unlink($from);
				break;
		}
		@chmod($to, 0666);
		return true;
	}

	//CURRENCY FUNCTIONS
	function input_money($str)
	{
		if (empty($str))
			return 0;

		$str = preg_replace("/[^0-9\.\,\-]/", '', $str);
		if ($this->SETTINGS['moneyformat'] == 1)
		{
			// Drop thousands separator
			$str = str_replace(',', '', $str);
		}
		elseif ($this->SETTINGS['moneyformat'] == 2)
		{
			// Drop thousands separator
			$str = str_replace('.', '', $str);

			// Change decimals separator
			$str = str_replace(',', '.', $str);
		}

		return floatval($str);
	}

	function CheckMoney($amount)
	{
		if ($this->SETTINGS['moneyformat'] == 1)
		{
			if (!preg_match('#^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{0,3})?$#', $amount))
				return false;
		}
		elseif ($this->SETTINGS['moneyformat'] == 2)
		{
			if (!preg_match('#^([0-9]+|[0-9]{1,3}(\.[0-9]{3})*)(,[0-9]{0,3})?$#', $amount))
				return false;
		}
		return true;
	}

	function print_money($str, $from_database = true, $link = true, $bold = true)
	{
		$str = $this->print_money_nosymbol($str, $from_database);

		if ($link)
		{
			$currency = '<a href="' . $this->SETTINGS['siteurl'] . 'converter.php?AMOUNT=' . $str . '" alt="converter" class="new-window">' . $this->SETTINGS['currency'] . '</a>';
		}
		else
		{
			$currency = $this->SETTINGS['currency'];
		}

		if ($bold)
		{
			$str = '<b>' . $str . '</b>';
		}

		if ($this->SETTINGS['moneysymbol'] == 2) // Symbol on the right
		{
			return $str . ' ' . $currency;
		}
		elseif ($this->SETTINGS['moneysymbol'] == 1) // Symbol on the left
		{
			return $currency . ' ' . $str;
		}
	}

	function print_money_nosymbol($str, $from_database = true)
	{
		$a = ($this->SETTINGS['moneyformat'] == 1) ? '.' : ',';
		$b = ($this->SETTINGS['moneyformat'] == 1) ? ',' : '.';
		if (!$from_database)
		{
			$str = $this->input_money($str, $from_database);
		}

		return number_format(floatval($str), $this->SETTINGS['moneydecimals'], $a, $b);
	}
}

// global functions
function _mktime($hr, $min, $sec, $mon, $day, $year)
{
	global $system;
	if ($system->SETTINGS['datesformat'] != 'USA')
	{
		$mon_ = $mon;
		$mon = $day;
		$day = $mon_;
	}

	return mktime($hr, $min, $sec, $mon, $day, $year);
}

function load_counters()
{
	global $system, $DBPrefix, $MSG, $_COOKIE, $user, $db;
	$query = "SELECT * FROM " . $DBPrefix . "counters";
	$db->direct_query($query);
	$counter_data = $db->result();
	$counters = '';

	if ($system->SETTINGS['counter_auctions'] == 'y')
		$counters .= '<b>' . $counter_data['auctions'] . '</b> ' . strtoupper($MSG['232']) . '| ';
	if ($system->SETTINGS['counter_users'] == 'y')
		$counters .= '<b>' . $counter_data['users'] . '</b> ' . strtoupper($MSG['231']) . ' | ';
	if ($system->SETTINGS['counter_online'] == 'y')
	{
		if (!$user->logged_in)
		{
			if (!isset($_COOKIE['WEBID_ONLINE']))
			{
				$s = md5(rand(0, 99) . session_id());
				setcookie('WEBID_ONLINE', $s, time() + 900);
			}
			else
			{
				$s = alphanumeric($_COOKIE['WEBID_ONLINE']);
				setcookie('WEBID_ONLINE', $s, time() + 900);
			}
		}
		else
		{
			$s = 'uId-' . $user->user_data['id'];
		}
		$uxtime = time();
		$query = "SELECT ID FROM " . $DBPrefix . "online WHERE SESSION = :user";
		$params = array();
		$params[] = array(':user', $s, 'str');
		$db->query($query, $params);

		if ($db->numrows() == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "online (SESSION, time) VALUES (:user, :timer)";
			$params = array();
			$params[] = array(':user', $s, 'str');
			$params[] = array(':timer', $uxtime, 'int');
			$db->query($query, $params);
		}
		else
		{
			$oID = $db->result('ID');
			$query = "UPDATE " . $DBPrefix . "online SET time = :timer WHERE ID = :online_id";
			$params = array();
			$params[] = array(':timer', $uxtime, 'int');
			$params[] = array(':online_id', $oID, 'int');
			$db->query($query, $params);
		}
		$deltime = $uxtime - 900;
		$query = "DELETE from " . $DBPrefix . "online WHERE time <= :timer";
		$params = array();
		$params[] = array(':timer', $deltime, 'int');
		$db->query($query, $params);
		
		$query = "SELECT id FROM " . $DBPrefix . "online";
		$db->direct_query($query);

		$count15min = $db->numrows('id');

		$counters .= '<b>' . $count15min . '</b> ' . $MSG['2__0064'] . ' | ';
	}

	// Display current Date/Time
	$mth = 'MON_0' . date('m', $system->ctime);
	$date = $MSG[$mth] . date(' j, Y', $system->ctime);
	$counters .= $date . ' <span id="servertime">' . date('H:i:s', $system->ctime) . '</span>';
	return $counters;
}

function _in_array($needle, $haystack)
{
	$needle = "$needle"; //important turns integers into strings
	foreach ($haystack as $val)
	{
		if ($val == $needle)
			return true;
	}
	return false;
}

// strip none alpha-numeric characters
function alphanumeric($str)
{
	$str = preg_replace("/[^a-zA-Z0-9\s]/", '', $str);
	return $str;
}

// this is a stupid way of doing things these need to be changed to bools
function ynbool($str)
{
	$str = preg_replace("/[^yn]/", '', $str);
	return $str;
}
?>
