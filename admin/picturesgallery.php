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

unset($ERR);

#//
if ($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	if (!empty($_POST[maxpictures]) && !ereg("^[0-9]+$",$_POST[maxpictures]))
	{
		$ERR = $ERR_706;
		$system->SETTINGS = $_POST;
	}
	elseif ($_POST[maxpicturesize] == 0)
	{
		$ERR = $ERR_707;
		$system->SETTINGS = $_POST;
	}
	elseif (!empty($_POST[maxpicturesize]) && !ereg("^[0-9]+$",$_POST[maxpicturesize]))
	{
		$ERR = $ERR_708;
		$system->SETTINGS = $_POST;
	}
	else
	{
		#// Update database
		$query = "UPDATE " . $DBPrefix . "settings set
					picturesgallery=$_POST[picturesgallery],
					maxpictures=$_POST[maxpictures],
					maxpicturesize=$_POST[maxpicturesize]
					";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$ERR = $MSG['5006'];
		$system->SETTINGS = $_POST;
	}
}
else
{
	#//
	$query = "SELECT * FROM " . $DBPrefix . "settings";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$system->SETTINGS = mysql_fetch_array($res);
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
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['663']; ?></td>
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
<form name="conf" action="" method="post">
	<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
			<td align="center" class=title>
				<?php print $MSG['663']; ?>
			</td>
		</tr>
		<tr>
			<td>
			<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
				<?php
				if (isset($ERR))
				{
				?>
					<tr bgcolor=yellow>
					<td colspan="2" align="center"><B>
					  <?php print $ERR; ?>
					  </B></td>
				  </tr>
				 <?php
				}
				 ?>
				<tr valign="top">
					<td width=134>&nbsp;</td>
					<td width="350">
						<?php print $MSG['664']; ?>
						</td>
				</tr>
				<tr valign="top">
					<td width=134 height="22">
						<?php print $MSG['665']; ?>
						</td>
					<td width="350" height="22">
						<input type="radio" name="picturesgallery" value="1" <?if ($system->SETTINGS[picturesgallery] == "1") print " CHECKED"?>>
						<?php print $MSG['030']; ?>
						<input type="radio" name="picturesgallery" value="2" <?if ($system->SETTINGS[picturesgallery] == "2") print " CHECKED"?>>
						<?php print $MSG['029']; ?>
						</td>
				</tr>
				<tr valign="top">
					<td width=134 height="22">
						<?php print $MSG['666']; ?>
						</td>
					<td width="350" height="22">
						<input type="text" name="maxpictures" SIZE="5" value="<?php echo $system->SETTINGS[maxpictures];?>">
						</td>
				</tr>
				<tr valign="top">
					<td width=134 height="22">
						<?php print $MSG['671']; ?>
						</td>
					<td width="350" height="22">
						<input type="text" name="maxpicturesize" SIZE="5" value="<?php echo $system->SETTINGS[maxpicturesize];?>">
						&nbsp;<?php print $MSG['672']; ?></td>
				</tr>
				<tr valign="top">
					<td width=134 height="22">&nbsp;</td>
					<td width="350" height="22">&nbsp;</td>
				</tr>
				<tr>
					<td width=134>
						<input type="hidden" name="action" value="update">
					</td>
					<td width="350">
						<input type="submit" name="act" value="<?php print $MSG['530']; ?>">
					</td>
				</tr>
				<tr>
					<td width=134></td>
					<td width="350"> </td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</form>
<br>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>