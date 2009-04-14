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
include $include_path.'status.inc.php';
include $include_path.'dates.inc.php';

#//
unset($ERR);

#// Delete boards
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	while (list($k,$v) = each($_POST['delete']))
	{
		$query = "DELETE FROM " . $DBPrefix . "community WHERE id='$v'";
		$r = mysql_query($query);
		$system->check_mysql($r, $query, __LINE__, __FILE__);
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE boardid='$v'";
		$r = mysql_query($query);
		$system->check_mysql($r, $query, __LINE__, __FILE__);
	}
}

#// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "community ORDER BY name";
$res__ = mysql_query($query);
$system->check_mysql($res__, $query, __LINE__, __FILE__);

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT type="text/javascript">
function selectDelete(formObj, isInverse) 
{
   for (var i=0;i < formObj.length;i++) 
   {
	  fldObj = formObj.elements[i];
	  if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete')
	  { 
		 if (isInverse)
			fldObj.checked = (fldObj.checked) ? false : true;
		 else fldObj.checked = true; 
	   }
   }
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM NAME="boards" METHOD="post" ACTION="">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif">
	
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5032']; ?></td>
		</tr>
	  	</table>
	</td>
	</tr>
	<tr>
	<td align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr> 
	<td align="center" valign="middle">
  		<TABLE WIDTH="600" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" BGCOLOR="#0083D7">
		<TR>
			<TD>
				<TABLE WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="4" ALIGN="CENTER">
				  <TR BGCOLOR="#0083D7">
					<TD COLSPAN="6" clign=center class=title>
				<?php echo $MSG['5032']; ?>
			</TD>
					</TR>
					<?php
					if (isset($ERR))
					{
					?>
					<TR BGCOLOR="yellow">
					  <TD COLSPAN="6" class=error>
						<?php echo $ERR; ?>
						</TD>
					</TR>
					<?php
					}
					?>
					<TR bgcolor=#ffffff>
						<TD COLSPAN="6">
						<B><?php echo $MSG['5040']; ?></B></TD>
					</TR>
					<TR BGCOLOR="#eeeeee">
						<TD WIDTH="6%"><?php echo $MSG['129']; ?></TD>
						<TD WIDTH="40%"><?php echo $MSG['294']; ?></TD>
						<TD WIDTH="10%" ALIGN=CENTER><?php echo $MSG['5046']; ?></TD>
						<TD WIDTH="12%" ALIGN=CENTER><?php echo $MSG['5043']; ?></TD>
						<TD WIDTH="16%" ALIGN=CENTER><?php echo $MSG['5044']; ?></TD>
						<TD WIDTH="16%" ALIGN=CENTER>
							<INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['008']; ?>">
						</TD>
					</TR>
					<?php
					while ($row = mysql_fetch_array($res__))
					{
						if ($row['active'] == 1) {
							$BG = "#FFFFFF";
						} else {
							$BG = "#CCCCFF";
						}
					?>
					<TR BGCOLOR="<?php echo $BG; ?>">
						<TD WIDTH="6%">
							<?php echo $row['id']; ?>
						</TD>
						<TD WIDTH="40%"> <A HREF=editboards.php?id=<?php echo $row['id']; ?>>
							<?php echo $row['name']; ?>
							</A>
							<?php
							if ($row['active'] == 2)
							{
								print "&nbsp;&nbsp;&nbsp;<B>[INACTIVE]</B>";
							}
							?></TD>
						<TD WIDTH="10%" ALIGN=CENTER><?php echo $row['msgstoshow']; ?></TD>
						<TD WIDTH="12%" ALIGN=CENTER>
							<?php echo $row['messages']; ?>
						</TD>
						<TD WIDTH="16%" ALIGN=CENTER>
							<?php
							if ($row['lastmessage'] == 0) {
								print "--";
							} else {
								print FormatDate($row['lastmessage']);
							}
							?>
						</TD>
						<TD WIDTH="16%" ALIGN=CENTER>
							<INPUT TYPE="checkbox" NAME="delete[<?php echo $row['id']; ?>]" VALUE="<?php echo $row['id']; ?>">
						</TD>
					</TR>
					<?php
					}
					?>
					<TR bgcolor=#FFFFFF>
						<TD colspan=5>&nbsp;</TD>
						<TD align=center><a href="javascript: void(0)" onClick="selectDelete(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A></TD>
					</TR>
					<TR BGCOLOR="#eeeeee">
						<TD WIDTH="6%" BGCOLOR="#FFFFFF">&nbsp;</TD>
						<TD BGCOLOR="#FFFFFF" WIDTH="40%">&nbsp;</TD>
						<TD WIDTH="10%" BGCOLOR="#FFFFFF" ALIGN=CENTER>&nbsp;</TD>
						<TD WIDTH="12%" BGCOLOR="#FFFFFF" ALIGN=CENTER>&nbsp;</TD>
						<TD WIDTH="16%" BGCOLOR="#FFFFFF" ALIGN=CENTER>&nbsp;</TD>
						<TD WIDTH="16%" BGCOLOR="#FFFFFF" ALIGN=CENTER>
							<INPUT TYPE="submit" NAME="Submit2" VALUE="Delete">
						</TD>
						</TR>
						</TABLE>
		</TD>
		</TR>
		</TABLE>
</TD>
</TR>
</TABLE>
</FORM>
</body>
</HTML>