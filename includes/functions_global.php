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

if (!defined('InWeBid')) exit('Access denied');

class global_class
{
	var $SETTINGS, $ctime, $tdiff;
	
	function global_class()
	{
		global $DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $main_path;
		// Database connection
		if (!mysql_connect($DbHost,$DbUser,$DbPassword)) die();
		if (!mysql_select_db($DbDatabase)) die();
		// Load settings
		$this->loadsettings();
		$this->ctime = time() + (($this->SETTINGS['timecorrection'] + gmdate('I')) * 3600);
		$this->tdiff = ($this->SETTINGS['timecorrection'] + gmdate('I')) * 3600;
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
		if (!defined('IPBan') && !defined('InAdmin'))
		{
			$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND action = 'deny'";
			$result = mysql_query($query);
			$this->check_mysql($result, $query, __LINE__, __FILE__);
			if (mysql_num_rows($result) > 0)
			{
				header('location: iperror.php');
				exit;
			}
		}
	}
	
	function loadsettings()
	{
		global $DBPrefix;
		$query = "SELECT * FROM " . $DBPrefix . "settings";
		$result = mysql_query($query);
		$this->check_mysql($result, $query, __LINE__, __FILE__);
		$this->SETTINGS = mysql_fetch_assoc($result);
		$this->SETTINGS['gatways'] = array(
			'paypal' => 'PayPal',
			'authnet' => 'Authorize.net'
			);
	}

	function check_mysql($result, $query, $line, $page)
	{
		if (!$result)
		{
			MySQLError($query, $line, $page);
			header('location: ' . $this->SETTINGS['siteurl'] . 'error.php');
			exit;
		}
	}

	function check_maintainance_mode()
	{
		global $DBPrefix, $user;

		$query = "SELECT * FROM " . $DBPrefix . "maintainance";
		$res = mysql_query($query);
		$this->check_mysql($res, $query, __LINE__, __FILE__);
		
		if (mysql_num_rows($res) > 0)
		{
			$MAINTAINANCE = mysql_fetch_array($res);
			if ($MAINTAINANCE['active'] == 'y')
			{
				if ($user->logged_in && ($user->user_data['nick'] == $MAINTAINANCE['superuser'] || $user->user_data['id'] == $MAINTAINANCE['superuser']))
				{
					return false;
				}
				return true;
			}
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
		global $DBPrefix;
		$query = "SELECT * FROM " . $DBPrefix . "filterwords";
		$res = mysql_query($query);
		$this->check_mysql($res, $query, __LINE__, __FILE__);
		while ($word = mysql_fetch_array($res))
		{
			$txt = preg_replace('(' . $word['word'] . ')', '', $txt); //best to use str_ireplace but not avalible for PHP4
		}
		return $txt;
	}

	function move_file($from, $to)
	{
		$upload_mode = (@ini_get('open_basedir') || @ini_get('safe_mode') || strtolower(@ini_get('safe_mode')) == 'on') ? 'move' : 'copy';
		switch ($upload_mode)
		{
			case 'copy':
				if (!@copy($from, $to))
				{
					if (!@move_uploaded_file($from, $to))
					{
						return false;
					}
				}
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
				@unlink($from);
				break;
		}
		@chmod($to, 0666);
		return true;
	}

	//CURRENCY FUNCTIONS
	function input_money($str)
	{
		if ($this->SETTINGS['moneyformat'] == 1)
		{
			// Drop thousands separator
			$str = ereg_replace(',', '', $str);
		}
		elseif ($this->SETTINGS['moneyformat'] == 2)
		{
			// Drop thousands separator
			$str = str_replace('.', '', $str);

			// Change decimals separator
			$str = str_replace(',', '.', $str);
		}
		
		return $str;
	}

	function CheckMoney($amount)
	{
		if ($this->SETTINGS['moneyformat'] == 1)
		{
			if (!ereg('^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{0,3})?$', $amount))
				return false;
		}
		elseif ($this->SETTINGS['moneyformat'] == 2)
		{
			if (!ereg('^([0-9]+|[0-9]{1,3}(\.[0-9]{3})*)(,[0-9]{0,3})?$', $amount))
				return false;
		}
		return true;
	}

	function print_money($str, $link = true)
	{
		$a = ($this->SETTINGS['moneyformat'] == 1) ? '.' : ',';
		$b = ($this->SETTINGS['moneyformat'] == 1) ? ',' : '.';
		$str = $this->print_money_nosymbol($str);

		if ($link)
		{
			$currency = '<a href="' . $this->SETTINGS['siteurl'] . 'converter.php?AMOUNT=' . $str . '" alt="converter" class="new-window">' . $this->SETTINGS['currency'] . '</a>';
		}
		else
		{
			$currency = $this->SETTINGS['currency'];
		}

		if ($this->SETTINGS['moneysymbol'] == 2) // Symbol on the right
		{
			return '<b>' . $str . '</b> ' . $currency;
		}
		elseif ($this->SETTINGS['moneysymbol'] == 1) // Symbol on the left
		{
			return $currency . ' <b>' . $str . '</b>';
		}
	}

	function print_money_nosymbol($str)
	{
		$a = ($this->SETTINGS['moneyformat'] == 1) ? '.' : ',';
		$b = ($this->SETTINGS['moneyformat'] == 1) ? ',' : '.';

		return number_format($str, $this->SETTINGS['moneydecimals'], $a, $b);
	}
}
?>