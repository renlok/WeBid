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

// timezone fix
$int_timezones = array(
		-11.5 => 'Pacific/Midway',
		-11 => 'Pacific/Midway',
		-10.5 => 'Pacific/Honolulu',
		-10 => 'Pacific/Honolulu',
		-9.5 => 'Pacific/Marquesas',
		-9 => 'Pacific/Gambier',
		-8.5 => 'America/Ensenada',
		-8 => 'America/Ensenada',
		-7.5 => 'America/Denver',
		-7 => 'America/Denver',
		-6.5 => 'America/Belize',
		-6 => 'America/Belize',
		-5.5 => 'America/New_York',
		-5 => 'America/New_York',
		-4.5 => 'America/Caracas',
		-4 => 'America/Santiago',
		-3.5 => 'America/St_Johns',
		-3 => 'America/Araguaina',
		-2.5 => 'America/Noronha',
		-2 => 'America/Noronha',
		-1.5 => 'Atlantic/Cape_Verde',
		-1 => 'Atlantic/Cape_Verde',
		-0.5 => 'Europe/London',
		0 => 'Europe/London',
		0.5 => 'Europe/London',
		1 => 'Europe/Amsterdam',
		1.5 => 'Europe/Amsterdam',
		2 => 'Asia/Beirut',
		2.5 => 'Asia/Beirut',
		3 => 'Europe/Moscow',
		3.5 => 'Asia/Tehran',
		4 => 'Asia/Dubai',
		4.5 => 'Asia/Kabul',
		5 => 'Asia/Yekaterinburg',
		5.5 => 'Asia/Kolkata',
		6 => 'Asia/Dhaka',
		6.5 => 'Asia/Rangoon',
		7 => 'Asia/Bangkok',
		7.5 => 'Asia/Bangkok',
		8 => 'Asia/Hong_Kong',
		8.5 => 'Australia/Eucla',
		9 => 'Asia/Tokyo',
		9.5 => 'Australia/Adelaide',
		10 => 'Australia/Sydney',
		10.5 => 'Australia/Lord_Howe',
		11 => 'Asia/Magadan',
		11.5 => 'Pacific/Norfolk',
		12 => 'Asia/Anadyr'
	);
$timezone_list = timezone_identifiers_list();
$query = "SELECT value FROM " . $DBPrefix . "settings WHERE fieldname = 'timezone';";
$db->direct_query($query);
$old_timezone = $db->result('value');
if (!in_array($old_timezone, $timezone_list))
{
	if (isset($int_timezones[$old_timezone]))
	{
		$query = "SELECT value FROM " . $DBPrefix . "settings WHERE fieldname = '" . $int_timezones[$old_timezone] . "';";
	}
	else
	{
		$query = "SELECT value FROM " . $DBPrefix . "settings WHERE fieldname = 'Europe/London';";
	}
	$db->direct_query($query);
}

// update user table
foreach ($int_timezones as $time_ajustment => $timezone)
{
	$query = "UPDATE " . $DBPrefix . "users SET timezone = '" . $timezone . "' WHERE timezone = '" . $time_ajustment . "';";
	$db->direct_query($query);
}

$query = "SELECT value FROM " . $DBPrefix . "settings WHERE fieldname = 'theme'";
$db->direct_query($query);
$old_theme = $db->result('value');
if ($old_theme == 'default')
{
	$query = "UPDATE " . $DBPrefix . "settings set value = 'classic' WHERE fieldname = 'theme'";
	$db->direct_query($query);
}

// remove unused files and folders from previous versions
rmf('../admin/bar.php');
rmf('../inc/calendar.css');
rmf('../inc/img/cal.gif');
rmf('../inc/img/next_mon.gif');
rmf('../inc/img/next_year.gif');
rmf('../inc/img/no_cal.gif');
rmf('../inc/img/pixel.gif');
rmf('../inc/img/prev_mon.gif');
rmf('../inc/img/prev_year.gif');
rmf('../inc/img/shade_bl.png');
rmf('../inc/img/shade_bm.png');
rmf('../inc/img/shade_br.png');
rmf('../inc/img/shade_mr.png');
rmf('../inc/img/shade_tr.png');
rmf('../includes/class_db_handle.php');
rmf('../includes/class_template_compile.php');
rmf('../includes/class_user.php');
rmf('../includes/converter.inc.php');
rmf('../includes/countries.inc.php');
rmf('../includes/currencies.php');
rmf('../includes/email_auction_confirmation.php');
rmf('../includes/email_endauction_cumulative.php');
rmf('../includes/email_endauction_nowinner.php');
rmf('../includes/email_endauction_winner.php');
rmf('../includes/email_endauction_youwin.php');
rmf('../includes/email_endauction_youwin_nodutch.php');
rmf('../includes/email_outbid.php');
rmf('../includes/email_user_approved.php');
rmf('../includes/email_user_confirmation.php');
rmf('../includes/email_user_needapproval.php');
rmf('../includes/htmLawed.php');
rmf('../includes/template.php');
rmf('../includes/useragent.inc.php');
rmf('../js/calendar.php');
rmf('../js/google_converter.js');
rmf('../js/jquery.dimensions.js');
rmf('../captcha.php');
rmf('../captcha_play.php');
rmf('../converter.php');
rmf('../loader.php');

rrmdir('../fck');
rrmdir('../ckeditor');
rrmdir('../inc/captcha');
rrmdir('../includes/captcha');
rrmdir('../inc/checks');
rrmdir('../inc/flags');
rrmdir('../includes/flags');
rrmdir('../inc/plupload');
rrmdir('../themes/admin');
rrmdir('../themes/default');
