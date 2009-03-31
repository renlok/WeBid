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

require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

if ($_POST['action'] == "update")
{
	#// Update database
	$query = "UPDATE " . $DBPrefix . "settings set
			  boards='$_POST[boards]',
			  boardslink='$_POST[boardslink]'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$ERR = $MSG['5051'];
	$SETTINGS = $_POST;
}

#//
$query = "SELECT boards,boardslink FROM " . $DBPrefix . "settings";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$SETTINGS = mysql_fetch_array($res);
}
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
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
<TR>
<TD>
<CENTER>
				<BR>
				<FORM NAME=conf ACTION="" METHOD=POST>
					<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
						<TR>
							<TD ALIGN=CENTER><FONT COLOR=#FFFFFF FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="4"><B>
								<?php print $MSG['5047']; ?>
								</B></FONT></TD>
						</TR>
						<TR>
							<TD>

				<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
				  <?php
					  if (!empty($ERR))
					  {
				  ?>
				  <TR BGCOLOR=yellow>
					<TD COLSPAN="2" ALIGN=CENTER><B><FONT FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="2" COLOR="#FF0000">
					  <?php print $ERR; ?>
					  </FONT></B></TD>
				  </TR>
				  <?php
					  }
				   ?>
				  <TR VALIGN="TOP">
					<TD WIDTH=195 HEIGHT="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <?php echo $MSG['5048']; ?>
					  </FONT></TD>
					<TD WIDTH="437" HEIGHT="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <INPUT TYPE="radio" NAME="boards" VALUE="y" <?if ($SETTINGS[boards] == "y") print " CHECKED"?>>
					  <?php print $MSG['030']; ?>
					  <INPUT TYPE="radio" NAME="boards" VALUE="n" <?if ($SETTINGS[boards] == "n") print " CHECKED"?>>
					  <?php print $MSG['029']; ?>
					  </FONT></TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH=195>&nbsp;</TD>
					<TD WIDTH="437"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  </FONT></TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH=195 HEIGHT="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <?php echo $MSG['5049']; ?>
					  </FONT></TD>
					<TD WIDTH="437" HEIGHT="22"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  <INPUT TYPE="radio" NAME="boardslink" VALUE="y" <?if ($SETTINGS[boardslink] == "y") print " CHECKED"?>>
					  <?php print $MSG['030']; ?>
					  <INPUT TYPE="radio" NAME="boardslink" VALUE="n" <?if ($SETTINGS[boardslink] == "n") print " CHECKED"?>>
					  <?php print $MSG['029']; ?>
					  <BR><?php echo $MSG['5050']; ?>
					  </FONT></TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH=195>&nbsp;</TD>
					<TD WIDTH="437"><FONT FACE="Verdana, Verdana, Arial, Helvetica, sans-serif" SIZE="2">
					  </FONT></TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH=195 HEIGHT="22">&nbsp;</TD>
					<TD WIDTH="437" HEIGHT="22">&nbsp;</TD>
				  </TR>
				  <TR>
					<TD WIDTH=195>
					  <INPUT TYPE="hidden" NAME="action" VALUE="update">
					</TD>
					<TD WIDTH="437">
					  <INPUT TYPE=submit NAME=act VALUE="<?php print $MSG['530']; ?>">
					</TD>
				  </TR>
				  <TR>
					<TD WIDTH=195></TD>
					<TD WIDTH="437"> </TD>
				  </TR>
				</TABLE>
							</TD>
						</TR>
					</TABLE>
					</FORM>
	</CENTER>

</TD>
</TR>
</TABLE>
</BODY>
</HTML>
