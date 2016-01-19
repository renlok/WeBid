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
include 'functions.php';
include '../includes/class_db_handle.php';
define('InInstaller', 1);

$db = new db_handle();

$main_path = getmainpath();
$thisversion = package_version();
echo print_header(false);

$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
switch($step)
{
	case 2:
		$siteURL = urldecode($_GET['URL']);
		$siteEmail = $_GET['EMail'];
		include '../includes/config.inc.php';
		include 'sql/dump.inc.php';
		$queries = count($query);
		$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix);
		echo ($_GET['n'] * 25) . '% Complete<br>';
		$from = (isset($_GET['from'])) ? $_GET['from'] : 0;
		$fourth = floor($queries/4);
		$to = ($_GET['n'] == 4) ? $queries : ($fourth * $_GET['n']);
		for ($i = $from; $i < $to; $i++)
		{
			$db->direct_query($query[$i]);
		}
		flush();
		if ($i < $queries)
		{
			echo '<script type="text/javascript">window.location = "install.php?step=2&URL=' . urlencode($_GET['URL']) . '&EMail=' . $_GET['EMail'] . '&cats=' . $_GET['cats'] . '&n=' . ($_GET['n'] + 1) . '&from=' . $i . '";</script>';
		}
		else
		{
			echo '<p>Installation complete.</p>
				<p>What do I do now?</p>
				<ul>
					<li>Your WeBid password salt: <span style="color: #FF0000; font-weight:bold;">' . $_SESSION['hash'] . '</span> You should make note of this random code, it is used to secure your users passwords. It is stored in your config file if you accidently delete this file and don\'t have this code all your users will have to reset their passwords</li>
					<li>Remove the install folder from your server. You will not be able to use WeBid until you do this.</li>
					<li>Finally set-up your admin account <a href="' . $_GET['URL'] . 'admin/" style="font-weight:bold;">here</a></li>
					<li>And don\'t forget to check out our <a href="http://www.webidsupport.com/forums/">support forum</a></li>
				</ul>';
		}
		break;
	case 1:
		$db->connect($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass'], $_POST['DBName'], $_POST['DBPrefix']);
		$cats = (isset($_POST['importcats'])) ? 1 : 0;
		echo '<p><b>Step 1:</b> Writing config file...</p>';
		$path = (!get_magic_quotes_gpc()) ? str_replace('\\', '\\\\', $_POST['mainpath']) : $_POST['mainpath'];
		$hash = md5(microtime() . rand(0,50));
		$_SESSION['hash'] = $hash;
		// generate config file
		$content = '<?php' . "\n";
		$content .= '$DbHost	 = "' . $_POST['DBHost'] . '";' . "\n";
		$content .= '$DbDatabase = "' . $_POST['DBName'] . '";' . "\n";
		$content .= '$DbUser	 = "' . $_POST['DBUser'] . '";' . "\n";
		$content .= '$DbPassword = "' . $_POST['DBPass'] . '";' . "\n";
		$content .= '$DBPrefix	= "' . $_POST['DBPrefix'] . '";' . "\n";
		$content .= '$main_path	= "' . $path . '";' . "\n";
		$content .= '$MD5_PREFIX = "' . $hash . '";' . "\n";
		$content .= '?>';
		$output = makeconfigfile($content, $path);
		if ($output)
		{
			$check = check_installation();
			if ($check)
			{
				echo '<p>You appear to already have an installation on WeBid running would you like to do a <a href="update.php">upgrade instead?</a></p>';
			}
			echo '<p>Complete, now to <b><a href="?step=2&URL=' . urlencode($_POST['URL']) . '&EMail=' . $_POST['EMail'] . '&cats=' . $cats . '&n=1">step 2</a></b></p>';
		}
		else
		{
			echo '<p>WeBid could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the includes directory)</p>';
			echo '<p><textarea style="width:500px; height:500px;">
'.$content.'
			</textarea></p>';
			echo '<p>Once you\'ve done this, you can continue to <b><a href="?step=2&URL=' . urlencode($_POST['URL']) . '&EMail=' . $_POST['EMail'] . '&cats=' . $cats . '&n=1">step 2</a></b></p>';
		}
		break;
	default:
		$check = check_installation();
		if ($check)
		{
			echo '<p>You appear to already have an installation on WeBid running would you like to do a <a href="update.php">upgrade instead?</a></p>';
		}
		echo show_config_table(true);
	break;
}

?>
