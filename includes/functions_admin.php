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

if (!defined('InWeBid')) exit();

if (!defined('AdminFuncCall'))
{
	function checklogin()
	{
		global $_SESSION, $system, $DBPrefix;

		if (isset($_SESSION['WEBID_ADMIN_NUMBER']) && isset($_SESSION['WEBID_ADMIN_IN']) && isset($_SESSION['WEBID_ADMIN_PASS']))
		{
			$query = "SELECT hash, password FROM " . $DBPrefix . "adminusers WHERE password = '" . $_SESSION['WEBID_ADMIN_PASS'] . "' AND id = " . $_SESSION['WEBID_ADMIN_IN'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);

			if (mysql_num_rows($res) > 0)
			{
				$user_data = mysql_fetch_array($res);

				if (strspn($user_data['password'], $user_data['hash']) == $_SESSION['WEBID_ADMIN_NUMBER'])
				{
					return false;
				}
			}
		}
		return true;
	}

	function getAdminNotes()
	{
		global $_SESSION, $system, $DBPrefix;

		if (isset($_SESSION['WEBID_ADMIN_NUMBER']) && isset($_SESSION['WEBID_ADMIN_IN']) && isset($_SESSION['WEBID_ADMIN_PASS']))
		{
			$query = "SELECT notes FROM " . $DBPrefix . "adminusers WHERE password = '" . $_SESSION['WEBID_ADMIN_PASS'] . "' AND id = " . $_SESSION['WEBID_ADMIN_IN'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);

			if (mysql_num_rows($res) > 0)
			{
				return mysql_result($res, 0);
			}
		}
		return '';
	}

	function loadblock($title = '', $description = '', $type = '', $name = '', $default = '', $tagline = array(), $header = false)
	{
		global $template;

		$template->assign_block_vars('block', array(
				'TITLE' => $title,
				'DESCRIPTION' => (!empty($description)) ? $description . '<br>' : '',
				'TYPE' => $type,
				'NAME' => $name,
				'DEFAULT' => $default,
				'TAGLINE1' => (isset($tagline[0])) ? $tagline[0] : '',
				'TAGLINE2' => (isset($tagline[1])) ? $tagline[1] : '',
				'TAGLINE3' => (isset($tagline[2])) ? $tagline[2] : '',

				'B_HEADER' => $header
				));
	}

	function generateSelect($name = '', $options = array(), $usekey = true)
	{
		global $selectsetting;
		$html = '<select name="' . $name . '">';
		foreach ($options as $option => $value)
		{
			if (!$usekey)
			{
				$option = $value;
			}
			if ($selectsetting == $option)
			{
				$html .= '<option value="' . $option . '" selected>' . $value . '</option>';
			}
			else
			{
				$html .= '<option value="' . $option . '">' . $value . '</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}

	function get_hash()
	{
		$string = '0123456789abcdefghijklmnopqrstuvyxz';
		$hash = '';
		for ($i = 0; $i < 5; $i++)
		{
			$rand = rand(0, 35);
			$hash .= $string[$rand];
			$string = str_replace($string[$rand], '', $string);
		}
		return $hash;
	}

	function load_file_from_url($url)
	{
		if(false !== ($str = file_get_contents($url)))
		{
			return $str; 
		}
		elseif(($handle = @fopen($url, 'r')) !== false)
		{
			$str = fread($handle, 5);
			if(false !== $str)
			{
				fclose($handle);
				return $str;
			}
		}
		elseif (function_exists('curl_init') && function_exists('curl_setopt')
		&& function_exists('curl_exec') && function_exists('curl_close'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_REFERER, $system->SETTINGS['siteurl']);
			$str = curl_exec($curl);
			curl_close($curl);
			return $str;
		}
		return false;
	}

	define('AdminFuncCall', 1);
}
?>