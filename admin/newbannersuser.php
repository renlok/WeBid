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
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
			<TR>
				<TD ALIGN=CENTER><B>
					<?php print $MSG['_0026']; ?>
					</B></TD>
			</TR>
			<TR>
				<TD>

				<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
				  <?php
				  if (!empty($ERR))
				  {
						?>
				  <TR>
					<TD COLSPAN="2" ALIGN=CENTER BGCOLOR=yellow> <B>
					  <?php echo $ERR; ?>
					   </B></TD>
				  </TR>
				  <?php
				  }
						?>
				  <TR VALIGN="TOP">
					<TD COLSPAN="2" ALIGN=CENTER>
					  <A HREF=managebanners.php><?php echo $MSG['270']; ?></A>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH="101" HEIGHT="22">
					  <?php echo $MSG['302']; ?>
					  </TD>
					<TD HEIGHT="22" WIDTH="531">
					  <INPUT TYPE=text NAME=name SIZE=40 VALUE=<?php echo $_POST[name]; ?>>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH="101" HEIGHT="22">
					  <?php echo $MSG['_0022']; ?>
					  </TD>
					<TD HEIGHT="22" WIDTH="531">
					  <INPUT TYPE=text NAME=company SIZE=40 VALUE=<?php echo $_POST[company]; ?>>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH="101" HEIGHT="22">
					  <?php echo $MSG['107']; ?>
					  </TD>
					<TD HEIGHT="22" WIDTH="531">
					  <INPUT TYPE=text NAME=email SIZE=40 VALUE=<?php echo $_POST[email]; ?>>
					  </TD>
				  </TR>
				  <TR>
					<TD WIDTH="101">&nbsp; </TD>
					<TD WIDTH="531">
					  <INPUT TYPE="hidden" NAME="action" VALUE="insert">
					  <INPUT TYPE="submit" NAME="submit" VALUE="<?php echo $MSG['569']; ?>">
					</TD>
				  </TR>
				  <TR>
					<TD COLSPAN="2"> </TD>
				  </TR>
				</TABLE>
				</TD>
			</TR>
		</TABLE>
		</FORM>
	<BR>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>