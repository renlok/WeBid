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
<h1>WeBid Updater, v0.7.2 to v0.7.3</h1>
<?php
$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
switch($step){
	case 2:
		$siteURL = $_GET['URL'];
		$siteEmail = $_GET['EMail'];
		include('../includes/config.inc.php');
		if(!mysql_connect($DbHost, $DbUser, $DbPassword)){
			die('<p>Cannot connect to '.$DbHost.'</p>');
		}
		if(!mysql_select_db($DbDatabase)){
			die('<p>Cannot select database</p>');
		}
		include('sql/updatedump.inc.php');
		for($i = $from; $i < $to; $i++){
			mysql_query($query[$i]) or print(mysql_error() . '<br>' . $query[$i] . '<br>');
		}
		echo 'Update complete now remove the install folder from your server';
		break;
	case 1:
		$cats = (isset($_POST['importcats'])) ? 1 : 0;
		echo '<b>step 1:</b> writting config file...<br>';
		$path = (!get_magic_quotes_gpc()) ? str_replace('\\', '\\\\', $_POST['mainpath']) : $_POST['mainpath'];
		$content = '<?php
$DbHost     = "'.$_POST['DBHost'].'";
$DbDatabase = "'.$_POST['DBName'].'";
$DbUser     = "'.$_POST['DBUser'].'";
$DbPassword = "'.$_POST['DBPass'].'";
$DBPrefix	= "'.$_POST['DBPrefix'].'";
$main_path	= "'.$path.'";
?>';
		$output = makeconfigfile($content);
		if($output)
			echo 'Complete, now to <b><a href="?step=2&URL='.$_POST['URL'].'&cats='.$cats.'&n=1">step 2</a></b>';
		else {
			echo 'WeBid could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the inclues directory)';
			echo '<p><textarea style="width:500px; height:500px;">
'.$content.'
			</textarea></p>';
			echo 'Once you\'ve done this, you can continue to <b><a href="?step=2&URL='.$_POST['URL'].'&cats='.$cats.'&n=1">step 2</a></b>';
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
</table>
<br>
<input type="submit" value="install">
</form>
<?php
	break;
}
?>