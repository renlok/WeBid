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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$id = $_REQUEST[id];

#//
if ($_POST[action] == "update")
{
	if (empty($_POST[name]) || empty($_POST[company]) || empty($_POST[email]))
	{
		$ERR = $ERR_047;
		$USER = $_POST;
	}
	elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$",$_POST[email]))
	{
		$ERR = $ERR_008;
		$USER = $_POST;
	}
	else
	{
		#// Update database
		$query = "UPDATE " . $DBPrefix . "bannersusers
					  SET
					  name='".addslashes($_POST[name])."',
					  company='".addslashes($_POST[company])."',
					  email='$_POST[email]'
					  WHERE id=$id";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$ID = mysql_insert_id();
		header("Location: managebanners.php");
		exit;
	}
}
else
{
	#//
	$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id=$id";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0) {
		$USER = mysql_fetch_array($res);
	}
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_ban.gif" ></td>
		  <td class=white><?php echo $MSG['25_0011']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['_0008']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">

<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
<tr>
<td align="center">
	<BR>
	<form NAME=conf action="" method="post">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
			<tr>
				<td align="center" class=title>
					<?php print $MSG['511']; ?>
				</td>
			</tr>
			<tr>
				<td>

				<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
				  <?php
				  if (!empty($ERR))
				  {
						?>
				  <tr>
					<td colspan="2" align="center" bgcolor=yellow> <B>
					  <?php echo $ERR; ?>
					   </B></td>
				  </tr>
				  <?php
				  }
						?>
				  <tr valign="top">
					<td colspan="2" align="center">
					  <A HREF=managebanners.php><?php echo $MSG['270']; ?></A>
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="101" height="22">
					  <?php echo $MSG['302']; ?>
					  </td>
					<td height="22" width="531">
					  <input type=text NAME=name SIZE=40 value="<?php echo $USER['name']; ?>">
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="101" height="22">
					  <?php echo $MSG['_0022']; ?>
					  </td>
					<td height="22" width="531">
					  <input type=text NAME=company SIZE=40 value="<?php echo $USER[company]; ?>">
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="101" height="22">
					  <?php echo $MSG['107']; ?>
					  </td>
					<td height="22" width="531">
					  <input type=text NAME=email SIZE=40 value="<?php echo $USER[email]; ?>">
					  </td>
				  </tr>
				  <tr>
					<td width="101">&nbsp; </td>
					<td width="531">
					  <input type="hidden" name="action" value="update">
					  <input type="hidden" name="id" value="<?php echo $id; ?>">
					  <input type="submit" name="submit" value="<?php echo $MSG['530']; ?>">
					</td>
				  </tr>
				  <tr>
					<td colspan="2"> </td>
				  </tr>
				</table>
				</td>
			</tr>
		</table>
		</form>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>