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

#//
if ($_POST[action] == "insert" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	if (empty($_POST[name]) || empty($_POST[company]) || empty($_POST[email]))
	{
		$ERR = $ERR_047;
	}
	elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$",$_POST[email]))
	{
		$ERR = $ERR_008;
	}
	else
	{
		#// Update database
		$query = "INSERT INTO " . $DBPrefix . "bannersusers
					  VALUES (
					  NULL,
					  '".addslashes($_POST['name'])."',
					  '".addslashes($_POST['company'])."',
					  '$_POST[email]')";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$ID = mysql_insert_id();
		header("Location: userbanners.php?id=$ID");
		exit;
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
	<td align="center" valign="middle">
	<BR>
	<form name="conf" action="" method="post">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
			<tr>
				<td align="center"><B>
					<?php print $MSG['_0026']; ?>
					</B></td>
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
					  <input type=text NAME=name SIZE=40 VALUE=<?php echo $_POST[name]; ?>>
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="101" height="22">
					  <?php echo $MSG['_0022']; ?>
					  </td>
					<td height="22" width="531">
					  <input type=text NAME=company SIZE=40 VALUE=<?php echo $_POST[company]; ?>>
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="101" height="22">
					  <?php echo $MSG['107']; ?>
					  </td>
					<td height="22" width="531">
					  <input type=text NAME=email SIZE=40 VALUE=<?php echo $_POST[email]; ?>>
					  </td>
				  </tr>
				  <tr>
					<td width="101">&nbsp; </td>
					<td width="531">
					  <input type="hidden" name="action" value="insert">
					  <input type="submit" name="submit" value="<?php echo $MSG['569']; ?>">
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
	<BR>
</td>
</tr>
</table>
</body>
</html>