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
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<TABLE WIDTH=100% CELLPADDING=2 CELLSPACING="0" BORDER="0">
	<TR BGCOLOR=#eeeeee>
		<td background="images/bac_barint.gif" colspan="2">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr> 
            <td width="30"><img src="images/i_con.gif" ></td>
            <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5030']; ?></td>
            </tr>
            </table>
        </td>
	</TR>
	<TR>
		<TD WIDTH="3%">&nbsp;</TD>
		<TD WIDTH="97%"> <FONT FACE="Tahoma, Verdana" SIZE="2"><IMG SRC="./images/ball.gif" WIDTH="12" HEIGHT="12"><A
		HREF="./boardsettings.php" CLASS="links">
			<?php print $MSG['5047'];?>
			</A> </FONT></TD>
	</TR>
	<TR>
		<TD WIDTH="3%">&nbsp;</TD>
		<TD WIDTH="97%"> <FONT FACE="Tahoma, Verdana" SIZE="2"><IMG SRC="./images/ball.gif" WIDTH="12" HEIGHT="12"><A HREF="./newboard.php" CLASS="links">
			<?php print $MSG['5031'];?>
			</A> </FONT></TD>
	</TR>
	<TR>
		<TD WIDTH="3%">&nbsp;</TD>
		<TD WIDTH="97%"> <FONT FACE="Tahoma, Verdana" SIZE="2"><IMG SRC="./images/ball.gif" WIDTH="12" HEIGHT="12"><A HREF="./boards.php" CLASS="links">
			<?php print $MSG['5032'];?>
			</A> </FONT></TD>
	</TR>
	<TR>
		<TD WIDTH="3%">&nbsp;</TD>
		<TD WIDTH="97%">&nbsp;</TD>
	</TR>

</TABLE>
</BODY>
</HTML>