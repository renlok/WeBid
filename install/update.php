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

$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
if ($step != 3)
{
	session_start();
}
define('InWeBid', 1);
include 'functions.php';
include '../includes/class_db_handle.php';
define('InInstaller', 1);

$db = new db_handle();

$main_path = getmainpath();
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
	if (!file_exists($main_path . 'includes/config.inc.php'))
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
			echo '<p>Now to <b><a href="?step=2">step 1</a></b></p>';
		}
	}
}
if ($step == 1)
{
	$db->connect($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass'], $_POST['DBName'], $_POST['DBPrefix']);
	$toecho = '<p><b>Step 1:</b> Writing the config file...</p>';
	$toecho .= '<p>As you are missing your old random security code all your users will have to reset their passwords after this update</p>';
	$path = (!get_magic_quotes_gpc()) ? str_replace('\\', '\\\\', $_POST['mainpath']) : $_POST['mainpath'];
	// generate config file
	$content = '<?php' . "\n";
	$content .= '$DbHost	 = "' . $_POST['DBHost'] . '";' . "\n";
	$content .= '$DbDatabase = "' . $_POST['DBName'] . '";' . "\n";
	$content .= '$DbUser	 = "' . $_POST['DBUser'] . '";' . "\n";
	$content .= '$DbPassword = "' . $_POST['DBPass'] . '";' . "\n";
	$content .= '$DBPrefix	= "' . $_POST['DBPrefix'] . '";' . "\n";
	$content .= '$main_path	= "' . $path . '";' . "\n";
	$content .= '$MD5_PREFIX = "' . md5(microtime() . rand(0,50)) . '";' . "\n";
	$content .= '?>';
	$output = makeconfigfile($content, $path);
	if ($output)
	{
		$check = check_installation();
		$package_version = package_version();
		$installed_version = check_version();
		echo print_header(true);
		echo $toecho;
		if (!$check)
		{
			echo '<p>It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b></p>';
		}
		else
		{
			echo '<p>Complete, now to <b><a href="?step=2">step 2</a></b></p>';
		}
	}
	else
	{
		$package_version = package_version();
		$installed_version = check_version();
		echo print_header(true);
		echo $toecho;
		echo '<p>WeBid could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the inclues directory)</p>';
		echo '<p><textarea style="width:500px; height:500px;">' . $content . '</textarea></p>';
		echo '<p>Once you\'ve done this, you can continue to <b><a href="?step=2">step 2</a></b></p>';
	}
}
if ($step == 2)
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
	for ($i = 0; $i < @count($query); $i++)
	{
		$db->direct_query($query[$i]);
		echo '<b>' . $query[$i] . '</b><br>';
	}
	if (file_exists('scripts/' . $new_version . '.php'))
	{
		include 'scripts/' . $new_version . '.php';
	}
	if ($installed_version == $package_version)
	{
		echo 'Complete, now to <b><a href="?step=3">step 3</a></b>';
	}
	else
	{
		echo '<script type="text/javascript">window.location = "?step=2";</script>';
		echo '<noscript>Javascript is disabled please <a href="?step=2">refresh the page</a></noscript>';
	}
}
if ($step == 3)
{
	$check = check_installation();
	$package_version = package_version();
	$installed_version = check_version();
	if (!$check)
	{
		echo print_header(true);
		echo '<p>It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b></p>';
		exit;
	}
	include $main_path . 'common.php';
	echo print_header(true);

	include $include_path . 'functions_rebuild.inc.php';
	echo '<p>Rebuilding membertypes...</p>';
	rebuild_table_file('membertypes');

	echo '<p>Rebuilding countries...</p>';
	rebuild_html_file('countries');

	echo '<p>Rebuilding categories...</p>';
	$catscontrol = new MPTTcategories();
	rebuild_cat_file();

	include $main_path . 'admin/util_cc1.php';

	echo '<p>Update almost complete, remove the install folder from your server to complete the upgrade</p>';
}

?>
