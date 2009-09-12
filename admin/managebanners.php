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

#// Delete users and banners if necessary
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		@mysql_query("DELETE FROM " . $DBPrefix . "banners WHERE user=$v");
		@mysql_query("DELETE FROM " . $DBPrefix . "bannersusers WHERE id=$v");
	}
}

#// Retrieve users from the database
$query = "SELECT * FROM " . $DBPrefix . "bannersusers ORDER BY name";
$res_ = @mysql_query($query);
if (!$res_)
{
	print "$query<BR>".mysql_error();
	exit;
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
	<form NAME=this ACTION="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
	<table width="80%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
	  <tr>
		<td align="center" class=title>
		  <?php print $MSG['_0008']; ?>
		  </td>
	  </tr>
	  <tr>
		<td>
		  <table width=100% cellpadding=2 align="center" bgcolor="#dddddd">
			<tr valign="top" bgcolor=white>
			  <td colspan="6" align="center"> 
				<A HREF="newbannersuser.php">
				<?php echo $MSG['_0026']; ?>
				</A></td>
			</tr>
			<tr valign="top" bgcolor="#eeeeee">
			  <td width="15%">
				<?php echo $MSG['5180']; ?>
				</td>
			  <td width="25%">
				<?php echo $MSG['_0022']; ?>
				</td>
			  <td width="28%">
				<?php echo $MSG['303']; ?>
				</td>
			  <td width="11%" align="center">
				<?php echo $MSG['_0025']; ?>
				 </td>
			  <td width="10%" align="center">
				<?php echo $MSG['_0024']; ?>
				</td>
			  <td width="11%" align="center"><?php echo $MSG['008']; ?>
				</td>
			</tr>
			<?php
			while ($row = mysql_fetch_array($res_))
			{
				#// Retriee the number of banners for this user
				$query = "SELECT id FROM " . $DBPrefix . "banners WHERE user=$row[id]";
				$r = @mysql_query($query);
				if (!$r)
				{
					print "$query<BR>".mysql_error();
					exit;
				}
				$COUNTER = mysql_num_rows($r);
			?>
			<tr valign="top" bgcolor="#ffffff">
			  <td width="15%"> 
				<A HREF="editbannersuser.php?id=<?php echo $row[id]; ?>"><?php echo $row[name]; ?></A>
				 </td>
			  <td width="25%"> 
				<?php echo $row[company]; ?>
				 </td>
			  <td width="28%"> 
				<A HREF="mailto:<?php echo $row[email]; ?>">
				<?php echo $row[email]; ?>
				</A>  </td>
			  <td width="11%" align="center">
				<?php echo $COUNTER; ?>
				</td>
			  <td width="10%" align="center"><A HREF="userbanners.php?id=<?php echo $row[id]; ?>"><IMG border=0 SRC="./images/tool.gif"></A></td>
			  <td width="11%" align="center"> &nbsp;
				<input type="checkbox" name="delete[]" value="<?php echo $row[id]; ?>">
			  </td>
			</tr>
			<?php
			}
			?>
			<tr valign="top" align="center" bgcolor="#ffffff">
			  <td colspan="6">
				<input type="submit" name="Submit" value="<?php echo $MSG['_0028']; ?>">
			  </td>
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
