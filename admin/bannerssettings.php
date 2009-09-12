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

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['sizetype']))
	{
		$ERR = $ERR_047;
	}
	elseif ($_POST['sizetype'] == 'fix' && (empty($_POST['width']) || empty($_POST['height'])))
	{
		$ERR = $ERR_047;
	}
	elseif ($_POST['sizetype'] == 'fix' && (!ereg("^[0-9]+$",$_POST['width']) || !ereg("^[0-9]+$",$_POST['height'])))
	{
		$ERR = $MSG['_0020'];
	}
	else
	{
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				banner_sizetype = '" . $_POST['sizetype'] . "',
				banner_width = " . intval($_POST['width']) . ",
				banner_height = " . intval($_POST['height']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$ERR = $MSG['600'];
	}
	$system->SETTINGS['banner_sizetype'] = $_POST['sizetype'];
	$system->SETTINGS['banner_width'] = $_POST['width'];
	$system->SETTINGS['banner_height'] = $_POST['height'];
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
		  <td class=white><?php echo $MSG['25_0011']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['_0013']; ?></td>
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
					<?php print $MSG['_0013']; ?>
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
					<td class=error colspan="2" align="center" bgcolor=yellow>
					  <?php echo $ERR; ?>
					 </td>
				  </tr>
				  <?php
				  }
						?>
				  <tr valign="top">
					<td colspan="2">
					  <?php print $MSG['_0014']; ?>
					  </td>
				  </tr>
				  <tr valign="top" bgcolor="#dddddd">
					<td width="73" height="22">
					  <input type="radio" name="sizetype" value="any"
								<?php if ($system->SETTINGS['banner_sizetype'] == 'any') print " CHECKED";?>
								>
					  </td>
					<td height="22" width="559">
					  <?php echo $MSG['_0015']; ?>
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="73" height="22" bgcolor="#eeeeee">
					  <input type="radio" name="sizetype" value="fix"
								<?php if ($system->SETTINGS['banner_sizetype'] == 'fix') print " CHECKED";?>
								>
					  </td>
					<td height="22" width="559" bgcolor="#eeeeee">
					  <?php echo $MSG['_0016']; ?>
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="73" height="22" bgcolor="#eeeeee">
					  <?php echo $MSG['_0017']; ?>
					  </td>
					<td width="559" height="22" bgcolor="#eeeeee">
					  <input type=text NAME=width value="<?php echo $system->SETTINGS['banner_width']; ?>">
					  <?php echo $MSG['5224']; ?>
					  </td>
				  </tr>
				  <tr valign="top">
					<td width="73" height="22" bgcolor="#eeeeee">
					  <?php echo $MSG['_0018']; ?>
					  </td>
					<td height="22" width="559" bgcolor="#eeeeee">
					  <input type=text NAME=height value="<?php echo $system->SETTINGS['banner_height']; ?>">
					  <?php echo $MSG['5224']; ?>
					  </td>
				  </tr>
				  <tr>
					<td width="73">&nbsp; </td>
					<td width="559">
					  <input type="hidden" name="action" value="update">
					  <input type="hidden" name="id" value="<?php echo $id; ?>">
					  <input type="submit" name="act" value="<?php print $MSG['530']; ?>">
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