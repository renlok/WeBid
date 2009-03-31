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
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

include $include_path.'status.inc.php';

$ERR = "&nbsp;";

if (is_array($_POST['delete']))
{
	$delete = '';
	$i = 0;
	while (list($k,$v) = each($_POST['delete']))
	{
		if ($i != 0) $delete = ', ';
		$delete = $k;
		$i++;
	}
	$query = "DELETE FROM " . $DBPrefix . "adminusers WHERE id IN ($delete)";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
}

$query = "SELECT * FROM " . $DBPrefix . "adminusers ORDER BY username";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$STATUS = array(
"1" => "<FONT COLOR=GREEN><b>Active</b></FONT>",
"2" => "<FONT COLOR=red><b>Not active</B></FONT>"
);

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
		  <td width="30"><img src="images/i_use.gif" ></td>
		  <td class=white><?php echo $MSG['25_0010']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['525']; ?></td>
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
<TD>
<CENTER>
<BR>
<FORM NAME=conf ACTION="" METHOD=POST>
<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
<TR>
<TD ALIGN=CENTER class=title>
<?php print $MSG['525']; ?>
</TD>
</TR>
<TR>
<TD>
<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
<TR>
<TD COLSPAN="2"><A HREF="./increments.php">
</A>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="2">
<TR BGCOLOR="#EEEEEE">
		<TD COLSPAN="5" ALIGN=CENTER><A HREF=newadminuser.php><?php echo $MSG['367']; ?></A></TD>
</TR>
<TR BGCOLOR="#999999">
		<TD WIDTH="30%">
				<CENTER>
					<B>
					<?php print $MSG['003']; ?>
					</B>
				</CENTER>
		</TD>
		<TD WIDTH="16%">
				<CENTER>
					<B>
					<?php print $MSG['558']; ?>
					</B>
				</CENTER>
		</TD>
		<TD WIDTH="19%">
				<CENTER>
					<B>
					<?php print $MSG['559']; ?>
					</B>
				</CENTER>
		</TD>
		<TD WIDTH="12%">
				<CENTER>
					<B>
					<?php print $MSG['560']; ?>
					</B>
				</CENTER>
		</TD>
		<TD WIDTH="23%">
				<CENTER>
					<B>
					<INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['561']; ?>">
					</B>
				</CENTER>
		</TD>
</TR>
<?php
while ($USER = mysql_fetch_array($res))
{
	$CREATED = substr($USER['created'],4,2)."/".
	substr($USER['created'],6,2)."/".
	substr($USER['created'],0,4);
	if ($USER['lastlogin'] == 0)
	{
		$LASTLOGIN = $MSG['570'];
	}
	else
	{
		$LASTLOGIN = date('d/m/Y H:i:s', $USER['lastlogin']);
	}
	
?>
<TR BGCOLOR="#EEEEEE">
		<TD WIDTH="30%">
				<A HREF=editadminuser.php?id=<?php echo $USER['id']; ?>>
				<?php echo $USER['username']; ?>
				</A></TD>
		<TD WIDTH="16%" ALIGN=CENTER>
				<?php echo $CREATED; ?>
				</TD>
		<TD WIDTH="19%" ALIGN=CENTER>
				<?php echo $LASTLOGIN; ?>
				</TD>
		<TD WIDTH="12%" ALIGN=CENTER>
				<?php echo $STATUS[$USER['status']]; ?>
				</TD>
		<TD WIDTH="23%">
				<CENTER>
				<INPUT TYPE="checkbox" NAME="delete[<?php echo $USER['id']; ?>]" VALUE="<?php echo $USER['id']; ?>">
				</CENTER>
		</TD>
</TR>
<?php
}
?>
</TABLE>
<A HREF="./increments.php" CLASS="links">
</A></TD>
</TR>
<TR>
<TD WIDTH=169>
<INPUT TYPE="hidden" NAME="action" VALUE="update">
</TD>
<TD WIDTH="365">&nbsp; </TD>
</TR>
<TR>
<TD WIDTH=169></TD>
<TD WIDTH="365"> </TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</FORM>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>