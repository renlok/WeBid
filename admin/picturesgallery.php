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
require('../includes/common.inc.php');
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
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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

<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD align="center">
<BR>
<form name="conf" action="" method="post">
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
		<TR>
			<TD ALIGN=CENTER class=title>
				<?php print $MSG['663']; ?>
			</TD>
		</TR>
		<TR>
			<TD>
			<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
				<?php
				if (isset($ERR))
				{
				?>
					<TR BGCOLOR=yellow>
					<TD COLSPAN="2" ALIGN=CENTER><B>
					  <?php print $ERR; ?>
					  </B></TD>
				  </TR>
				 <?php
				}
				 ?>
				<TR VALIGN="TOP">
					<TD WIDTH=134>&nbsp;</TD>
					<TD WIDTH="350">
						<?php print $MSG['664']; ?>
						</TD>
				</TR>
				<TR VALIGN="TOP">
					<TD WIDTH=134 HEIGHT="22">
						<?php print $MSG['665']; ?>
						</TD>
					<TD WIDTH="350" HEIGHT="22">
						<INPUT TYPE="radio" NAME="picturesgallery" VALUE="1" <?if ($system->SETTINGS[picturesgallery] == "1") print " CHECKED"?>>
						<?php print $MSG['030']; ?>
						<INPUT TYPE="radio" NAME="picturesgallery" VALUE="2" <?if ($system->SETTINGS[picturesgallery] == "2") print " CHECKED"?>>
						<?php print $MSG['029']; ?>
						</TD>
				</TR>
				<TR VALIGN="TOP">
					<TD WIDTH=134 HEIGHT="22">
						<?php print $MSG['666']; ?>
						</TD>
					<TD WIDTH="350" HEIGHT="22">
						<INPUT TYPE="text" NAME="maxpictures" SIZE="5" VALUE="<?php echo $system->SETTINGS[maxpictures];?>">
						</TD>
				</TR>
				<TR VALIGN="TOP">
					<TD WIDTH=134 HEIGHT="22">
						<?php print $MSG['671']; ?>
						</TD>
					<TD WIDTH="350" HEIGHT="22">
						<INPUT TYPE="text" NAME="maxpicturesize" SIZE="5" VALUE="<?php echo $system->SETTINGS[maxpicturesize];?>">
						&nbsp;<?php print $MSG['672']; ?></TD>
				</TR>
				<TR VALIGN="TOP">
					<TD WIDTH=134 HEIGHT="22">&nbsp;</TD>
					<TD WIDTH="350" HEIGHT="22">&nbsp;</TD>
				</TR>
				<TR>
					<TD WIDTH=134>
						<INPUT TYPE="hidden" NAME="action" VALUE="update">
					</TD>
					<TD WIDTH="350">
						<INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['530']; ?>">
					</TD>
				</TR>
				<TR>
					<TD WIDTH=134></TD>
					<TD WIDTH="350"> </TD>
				</TR>
			</TABLE>
			</TD>
		</TR>
	</TABLE>
	</FORM>
<br>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>