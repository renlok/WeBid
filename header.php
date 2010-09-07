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
 
if (!defined('InWeBid')) exit();

include $include_path . 'maintainance.php';
include $include_path . 'banners.inc.php';
if (basename($_SERVER['PHP_SELF']) != 'error.php')
	include $include_path . 'stats.inc.php';

$jsfiles = (basename($_SERVER['PHP_SELF']) == 'sell.php') ? '<script type="text/javascript" src="includes/calendar.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>' : '';

// Get users and auctions counters
$query = "SELECT * FROM " . $DBPrefix . "counters";
$result_counters = mysql_query($query);
$counters = '';
if ($result_counters)
{
	if ($system->SETTINGS['counter_auctions'] == 'y')
		$counters .= '<b>' . mysql_result($result_counters, 0, 'auctions') . '</b> ' . strtoupper($MSG['232']) . '| ';
	if ($system->SETTINGS['counter_users'] == 'y')
		$counters .= '<b>' . mysql_result($result_counters, 0, 'users') . '</b> ' . strtoupper($MSG['231']) . ' | ';
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
				$s = $_COOKIE['WEBID_ONLINE'];
				setcookie('WEBID_ONLINE', $s, time() + 900);
			}
		}
		else
		{
			$s = 'uId-' . $user->user_data['id'];
		}
		$uxtime = time();
		$query = "SELECT * FROM " . $DBPrefix . "online WHERE SESSION = '$s'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		if (mysql_num_rows($res) == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "online (SESSION, time) VALUES ('$s', " . $uxtime . ")";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		else
		{
			$oID = mysql_result($res, 0, 'ID');
			$query = "UPDATE " . $DBPrefix . "online SET time = " . $uxtime . " WHERE ID = '$oID'";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		$deltime = $uxtime - 900;
		$query = "DELETE from " . $DBPrefix . "online WHERE time < " . $deltime;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "SELECT * FROM " . $DBPrefix . "online";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		$count15min = mysql_num_rows($res);

		$counters .= '<b>' . $count15min . '</b> ' . $MGS_2__0064 . ' | ';
	}
}

// Display current Date/Time
$mth = "MON_0" . gmdate('m', $system->ctime);
$date = $MSG[$mth] . gmdate(' j, Y', $system->ctime);
$counters .= $date . ' <span id="servertime">' . gmdate('H:i:s', $system->ctime) . '</span>';

$page_title = (isset($page_title)) ? ' ' . $page_title : '';

$sslurl = $system->SETTINGS['siteurl'];
if ($system->SETTINGS['https'] == 'y')
{
	$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
}
// for images/ccs/javascript etc on secure pages
$incurl = (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') ? $system->SETTINGS['siteurl'] : $sslurl;

$template->assign_vars(array(
		'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl
		'THEME' => $system->SETTINGS['theme'],
		'PAGE_TITLE' => $system->SETTINGS['sitename'] . $page_title,
		'CHARSET' => $CHARSET,
		'DESCRIPTION' => stripslashes($system->SETTINGS['descriptiontag']),
		'KEYWORDS' => stripslashes($system->SETTINGS['keywordstag']),
		'EXTRAINC' => $jsfiles,
		'ACTUALDATE' => ActualDate(),
		'LOGO' => ($system->SETTINGS['logo']) ? '<a href="' . $system->SETTINGS['siteurl'] . 'index.php?"><img src="' . $incssl . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '"></a>' : '&nbsp;',
		'BANNER' => ($system->SETTINGS['banners'] == 1) ? view() : '',
		'HEADERCOUNTER' => $counters,
		'SITEURL' => $system->SETTINGS['siteurl'],
		'SSLURL' => $sslurl,
		'ASSLURL' => ($system->SETTINGS['https'] == 'y' && $system->SETTINGS['usersauth'] == 'y') ? $sslurl : $system->SETTINGS['siteurl'],
		'INCURL' => $incurl,
		'Q' => (isset($q)) ? $q : '',
		'SELECTION_BOX' => file_get_contents($main_path . "language/" . $language . "/categories_select_box.inc.php"),
		'YOURUSERNAME' => ($user->logged_in) ? $user->user_data['nick'] : '',

		'B_CAN_SELL' => $user->can_sell,
		'B_LOGGED_IN' => $user->logged_in,
		'B_BOARDS' => ($system->SETTINGS['boards'] == 'y')
		));

$template->set_filenames(array(
		'header' => 'global_header.tpl'
		));
$template->display('header');
?>
