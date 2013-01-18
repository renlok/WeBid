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
 
$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
if ($step != 3)
{
	session_start();
}
include 'functions.php';
define('InInstaller', 1);

$main_path = getmainpath();
/*
how new updater will work
in package config.inc.php will be named config.inc.php.new so it cannot be overwritten
1. check for config.inc.php
2. if config file missing ask for details
3. with database details check theres actually an installation of webid if not show link to make fresh install
	- if there is but no config write config file
4. collect query needed to run for version in use
5. update langauge files
*/

if ($step == 0)
{
	if (!file_exists($main_path . 'includes/config.inc.php'))
	{
		$thisversion = this_version();
		$myversion = check_version();
		echo print_header(true);
		echo show_config_table(false);
	}
	else
	{
		$check = check_installation();
		$thisversion = this_version();
		$myversion = check_version();
		echo print_header(true);
		if (!$check)
		{
			echo 'It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		}
		else
		{
			echo 'Now to <b><a href="?step=2">step 1</a></b>';
		}
	}
}
if ($step == 1)
{
	if (!mysql_connect($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass']))
	{
		die('<p>Cannot connect to ' . $DbHost . ' with the supplied username and password. <a href="#" onClick="history.go(-1)">Go Back</a></p>');
	}
	if (!mysql_select_db($_POST['DBName']))
	{
		die('<p>Cannot select database ' . $_POST['DBName'] . '. <a href="#" onClick="history.go(-1)">Go Back</a></p>');
	}
	$toecho = '<p><b>Step 1:</b> Writting config file...</p>';
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
		$thisversion = this_version();
		$myversion = check_version();
		echo print_header(true);
		echo $toecho;
		if (!$check)
		{
			echo 'It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		}
		else
		{
			echo 'Complete, now to <b><a href="?step=2">step 2</a></b>';
		}
	}
	else
	{
		$thisversion = this_version();
		$myversion = check_version();
		echo print_header(true);
		echo $toecho;
		echo 'WeBid could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the inclues directory)';
		echo '<p><textarea style="width:500px; height:500px;">' . $content . '</textarea></p>';
		echo 'Once you\'ve done this, you can continue to <b><a href="?step=2">step 2</a></b>';
	}
}
if ($step == 2)
{
	$check = check_installation();
	$thisversion = this_version();
	$myversion = check_version();
	echo print_header(true);
	if (!$check)
	{
		echo 'It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		exit;
	}
	include 'sql/updatedump.inc.php';
	for ($i = 0; $i < @count($query); $i++)
	{
		mysql_query($query[$i]) or print(mysql_error() . '<br>' . $query[$i] . '<br>');
		echo '<b>' . $query[$i] . '</b><br>';
	}
	if ($myversion == $thisversion)
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
	$thisversion = this_version();
	$myversion = check_version();
	if (!$check)
	{
		echo print_header(true);
		echo 'It seems you don\'t currently have a version of WeBid installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		exit;
	}
	include $main_path . 'common.php';
	echo print_header(true);
	include $include_path . 'functions_rebuild.inc.php';
	echo 'Rebuilding membertypes...<br>';
	rebuild_table_file('membertypes');
	echo 'Rebuilding countries...<br>';
	rebuild_html_file('countries');

	echo 'Rebuilding categories...<br>';
	$catscontrol = new MPTTcategories();
	rebuild_cat_file();

	include $main_path . 'admin/util_cc1.php';

	echo 'Update complete now remove the install folder from your server';
}

?>