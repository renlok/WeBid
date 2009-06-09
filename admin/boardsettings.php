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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

if ($_POST['action'] == 'update')
{
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings set
			boards = '" . $_POST['boards'] . "',
			boardslink = '" . $_POST['boardslink'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	$ERR = $MSG['5051'];
	$system->SETTINGS['boards'] = $_POST['boards'];
	$system->SETTINGS['boardslink'] = $_POST['boardslink'];
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
<tr>
	<td background="images/bac_barint.gif" colspan="2">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		<td width="30"><img src="images/i_con.gif" ></td>
		<td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5047']; ?></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
<tr>
<td>
<CENTER>
				<BR>
				<form NAME=conf action="" method="post">
					<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
						<tr>
							<td align="center"><FONT COLOR=#FFFFFF FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="4"><B>
								<?php print $MSG['5047']; ?>
								</B></FONT></td>
						</tr>
						<tr>
							<td>

				<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
				  <?php
					  if (!empty($ERR))
					  {
				  ?>
				  <tr bgcolor=yellow>
					<td colspan="2" align="center"><B><FONT FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="2" COLOR="#FF0000">
					  <?php print $ERR; ?>
					  </FONT></B></td>
				  </tr>
				  <?php
					  }
				   ?>
				  <tr valign="top">
					<td width=195 height="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <?php echo $MSG['5048']; ?>
					  </FONT></td>
					<td width="437" height="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <input type="radio" name="boards" value="y" <?if ($system->SETTINGS[boards] == "y") print " CHECKED"?>>
					  <?php print $MSG['030']; ?>
					  <input type="radio" name="boards" value="n" <?if ($system->SETTINGS[boards] == "n") print " CHECKED"?>>
					  <?php print $MSG['029']; ?>
					  </FONT></td>
				  </tr>
				  <tr valign="top">
					<td width=195>&nbsp;</td>
					<td width="437"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  </FONT></td>
				  </tr>
				  <tr valign="top">
					<td width=195 height="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <?php echo $MSG['5049']; ?>
					  </FONT></td>
					<td width="437" height="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <input type="radio" name="boardslink" value="y" <?if ($system->SETTINGS[boardslink] == "y") print " CHECKED"?>>
					  <?php print $MSG['030']; ?>
					  <input type="radio" name="boardslink" value="n" <?if ($system->SETTINGS[boardslink] == "n") print " CHECKED"?>>
					  <?php print $MSG['029']; ?>
					  <BR><?php echo $MSG['5050']; ?>
					  </FONT></td>
				  </tr>
				  <tr valign="top">
					<td width=195>&nbsp;</td>
					<td width="437"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  </FONT></td>
				  </tr>
				  <tr valign="top">
					<td width=195 height="22">&nbsp;</td>
					<td width="437" height="22">&nbsp;</td>
				  </tr>
				  <tr>
					<td width=195>
					  <input type="hidden" name="action" value="update">
					</td>
					<td width="437">
					  <input type=submit NAME=act value="<?php print $MSG['530']; ?>">
					</td>
				  </tr>
				  <tr>
					<td width=195></td>
					<td width="437"> </td>
				  </tr>
				</table>
							</td>
						</tr>
					</table>
					</form>
	</CENTER>

</td>
</tr>
</table>
</body>
</html>
