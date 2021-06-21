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

session_start();
define('InWeBid', 1);
define('InInstaller', 1);
include '../includes/database/Database.php';
include '../includes/database/DatabasePDO.php';

$db = new DatabasePDO();

include 'functions.php';
define('MAIN_PATH',  getmainpath());
$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
$new_version = 'Unknown';
/*
how new updater will work
in package config.inc.php will be named config.inc.php.new so it cannot be overwritten
1. check for config.inc.php
2. if config file missing ask for details
3. with database details check theres actually an installation of webid if not show link to make fresh install
	- if there is but no config write config file
4. collect query needed to run for version in use
5. update language files
*/

if ($step == 0)
{
	if (!file_exists(MAIN_PATH . 'includes/config.inc.php'))
	{
		$package_version = package_version();
		$installed_version = check_version();
		echo print_header(true);
		echo show_config_table(false);
	}
	else
	{
		$check = check_installation();
		$package_version = package_version();
		$installed_version = check_version();
		echo print_header(true);
		if (!$check)
		{
			echo '<p>It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b></p>';
		}
		else
		{
			echo '<p>Now to <b><a href="?step=1">step 1</a></b></p>';
		}
	}
}
if ($step == 1)
{
	$check = check_installation();
	$package_version = package_version();
	$installed_version = check_version();
	echo print_header(true);
	if (!$check)
	{
		echo '<p>It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b></p>';
		exit;
	}
	include 'sql/updatedump.inc.php';
	echo '<p>Upgrading to v' . $new_version . ' from ' . $installed_version . '</p>';
	$queries = count($query);
	$from = (isset($_GET['from'])) ? $_GET['from'] : 0;
	if ($queries > 0 && $from < $queries)
	{
		$next = $from + 25;
		$to = ($next > $queries) ? $queries : $next;
		echo 'Writing to database: ' . floor($to / $queries * 100) . '% Complete<br>';
		for ($i = $from; $i < $to; $i++)
		{
			$db->direct_query($query[$i]);
		}
		if ($next < $queries) 
		{
			echo '<script type="text/javascript">window.location = "update.php?step=1&from=' . $next . '";</script>';
			exit;
		}
	}
	if (file_exists('scripts/' . $new_version . '.php'))
	{
		echo '<b>Running database update script</b><br>';
		include 'scripts/' . $new_version . '.php';
		echo '<b>Update script complete</b><br>';
	}
	// update database version
	$db->direct_query("UPDATE `" . $DBPrefix . "settings` SET `value` = '" . $new_version . "' WHERE fieldname = 'version';");
	if ($new_version == $package_version)
	{
		echo '<p>Update almost complete, remove the install folder from your server to complete the upgrade</p>';
	}
	else
	{
		echo '<script type="text/javascript">window.location = "?step=1";</script>';
		echo '<noscript>Javascript is disabled please <a href="?step=1">refresh the page</a></noscript>';
	}
}
