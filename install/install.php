<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/
include('functions.php');
?>
<h1>WeBid Installer v0.7.3</h1>
<?php
$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
switch($step){
	case 2:
		$siteURL = $_GET['URL'];
		$siteEmail = $_GET['EMail'];
		include('../includes/config.inc.php');
		include('sql/dump.inc.php');
		if (!mysql_connect($DbHost, $DbUser, $DbPassword)){
			die('<p>Cannot connect to '.$DbHost.'</p>');
		}
		if (!mysql_select_db($DbDatabase)){
			die('<p>Cannot select database</p>');
		}
		echo ($_GET['n']*25) . '% Complete<br>';
		$from = (isset($_GET['from'])) ? $_GET['from'] : 0;
		$fourth = floor(count($query)/4);
		$to = ($_GET['n'] == 4) ? count($query) : $fourth*$_GET['n'];
		for ($i = $from; $i < $to; $i++){
			mysql_query($query[$i]) or die(mysql_error()."\n".$query[$i]);
		}
		flush();
		if ($i < count($query))
			echo '<script type="text/javascript">window.location = "install.php?step=2&URL='.$_GET['URL'].'&EMail='.$_GET['EMail'].'&cats='.$_GET['cats'].'&n='.($_GET['n']+1).'&from='.($i+1).'";</script>';
		else {
			echo 'Installation complete now set-up your admin account <a href="'.$_GET['URL'].'admin">here</a> and remove the install folder from your server';
		}
		break;
	case 1:
		$cats = (isset($_POST['importcats'])) ? 1 : 0;
		echo '<b>Step 1:</b> Writting config file...<br>';
		$path = (!get_magic_quotes_gpc()) ? str_replace('\\', '\\\\', $_POST['mainpath']) : $_POST['mainpath'];
		$content = '<?php
$DbHost	 = "'.$_POST['DBHost'].'";
$DbDatabase = "'.$_POST['DBName'].'";
$DbUser	 = "'.$_POST['DBUser'].'";
$DbPassword = "'.$_POST['DBPass'].'";
$DBPrefix	= "'.$_POST['DBPrefix'].'";
$main_path	= "'.$path.'";
?>';
		$output = makeconfigfile($content);
		if ($output)
			echo 'Complete, now to <b><a href="?step=2&URL='.$_POST['URL'].'&EMail='.$_POST['EMail'].'&cats='.$cats.'&n=1">step 2</a></b>';
		else {
			echo 'WeBid could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the inclues directory)';
			echo '<p><textarea style="width:500px; height:500px;">
'.$content.'
			</textarea></p>';
			echo 'Once you\'ve done this, you can continue to <b><a href="?step=2&URL='.$_POST['URL'].'&EMail='.$_POST['EMail'].'&cats='.$cats.'&n=1">step 2</a></b>';
		}
		break;
	default:
?>
<form name="form1" method="post" action="?step=1">
<table cellspacing="1" border="1" style="border-collapse:collapse;" cellpadding="6">
  <tr>
	<td width="140">URL</td>
	<td width="108">
	  <input type="text" name="URL" id="textfield" value="<?php echo getdomainpath(); ?>">
	</td>
	<td rowspan="2">
	  The url &amp; location of the webid installation on your server. It's usually best to leave these as they are.<br>
	  Also if your running on windows at the end of the <b>Doument Root</b> there should be a \\ (double backslash)
	</td>
  </tr>
  <tr>
	<td>Doument Root</td>
	<td>
	  <input type="text" name="mainpath" id="textfield" value="<?php echo getmainpath(); ?>">
	</td>
  </tr>
  <tr>
	<td>Email Address</td>
	<td>
	  <input type="text" name="EMail" id="textfield">
	</td>
	<td>The admin email address</td>
  </tr>
  <tr>
	<td>Database Host</td>
	<td>
	  <input type="text" name="DBHost" id="textfield" value="localhost">
	</td>
	<td>The location of your MySQL database in most cases its just localhost</td>
  </tr>
  <tr>
	<td>Database Username</td>
	<td>
	  <input type="text" name="DBUser" id="textfield">
	</td>
	<td rowspan="3">The username, password and database name of the database your installing webid on</td>
  </tr>
  <tr>
	<td>Database Password</td>
	<td>
	  <input type="text" name="DBPass" id="textfield">
	</td>
  </tr>
  <tr>
	<td>Database Name</td>
	<td>
	  <input type="text" name="DBName" id="textfield">
	</td>
  </tr>
  <tr>
	<td>Database Prefix</td>
	<td>
	  <input type="text" name="DBPrefix" id="textfield" value="webid_">
	</td>
	<td>the prefix of the webid tables in the database, used so you can install multiple scripts in the same database without issues.</td>
  </tr>
  <tr>
	<td>Import Default Categories</td>
	<td>
	  <input type="checkbox" name="importcats" id="checkbox" checked="checked">
	</td>
	<td>Leaving this checked is recommened. But you make want to uncheck it if your auction site is a specalist niche and will need custom catergories.</td>
  </tr>
</table>
<br>
<table cellspacing="1" border="1" style="border-collapse:collapse;" cellpadding="6" width="400px">
<tr>
	<td colspan="2"><b>File Checks:</b></td>
</tr>
<?php
$directories = array(
	'cache/',
	'uploaded/',
	'uploaded/banners/',
	'uploaded/cache/'
	);

umask(0);

$passed = true;
$main_path = getmainpath();
foreach ($directories as $dir) {
	$exists = $write = false;

	// Try to create the directory if it does not exist
	if (!file_exists($main_path . $dir)) {
		@mkdir($main_path . $dir, 0777);
		@chmod($main_path . $dir, 0777);
	}

	// Now really check
	if (file_exists($main_path . $dir) && is_dir($main_path . $dir)) {
		$exists = true;
	}

	// Now check if it is writable by storing a simple file
	$fp = @fopen($main_path . $dir . 'test_lock', 'wb');
	if ($fp !== false) {
		$write = true;
	}
	@fclose($fp);

	@unlink($main_path . $dir . 'test_lock');
	
	if (!$exists || !$write) {
		$passed = false;
	}
	
	echo '<tr><td>' . $dir . ':</td><td>';
	echo ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
	echo ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
	echo '</tr>';
}

$directories = array(
	'includes/config.inc.php',
	'includes/countries.inc.php',
	'includes/currencies.php',
	'includes/membertypes.inc.php',
	'language/EN/categories.inc.php',
	'language/EN/categories_select_box.inc.php'
	);

foreach ($directories as $dir) {
	$write = $exists = true;
	if (file_exists($main_path . $dir)) {
		if (!@is_writable($main_path . $dir)) {
			$write = false;
		}
	} else {
		$write = $exists = false;
	}
	
	if (!$exists || !$write) {
		$passed = false;
	}

	echo '<tr><td>' . $dir . ':</td><td>';
	echo ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
	echo ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
	echo '</tr>';
}

echo '</table>';

if ($passed) {
	echo '<br><input type="submit" value="install">';
}
?>
</form>
<?php
	break;
}
?>