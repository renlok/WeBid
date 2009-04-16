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
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
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
<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
<tr>
<td>
<CENTER>
<BR>
<form NAME=conf ACTION="" METHOD=POST>
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
<tr>
<td align="center" class=title>
<?php print $MSG['525']; ?>
</td>
</tr>
<tr>
<td>
<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
<tr>
<td colspan="2"><A HREF="./increments.php">
</A>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr bgcolor="#EEEEEE">
		<td colspan="5" align="center"><A HREF=newadminuser.php><?php echo $MSG['367']; ?></A></td>
</tr>
<tr bgcolor="#999999">
		<td width="30%">
				<CENTER>
					<B>
					<?php print $MSG['003']; ?>
					</B>
				</CENTER>
		</td>
		<td width="16%">
				<CENTER>
					<B>
					<?php print $MSG['558']; ?>
					</B>
				</CENTER>
		</td>
		<td width="19%">
				<CENTER>
					<B>
					<?php print $MSG['559']; ?>
					</B>
				</CENTER>
		</td>
		<td width="12%">
				<CENTER>
					<B>
					<?php print $MSG['560']; ?>
					</B>
				</CENTER>
		</td>
		<td width="23%">
				<CENTER>
					<B>
					<input type="submit" name="Submit" value="<?php echo $MSG['561']; ?>">
					</B>
				</CENTER>
		</td>
</tr>
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
<tr bgcolor="#EEEEEE">
		<td width="30%">
				<A HREF=editadminuser.php?id=<?php echo $USER['id']; ?>>
				<?php echo $USER['username']; ?>
				</A></td>
		<td width="16%" align="center">
				<?php echo $CREATED; ?>
				</td>
		<td width="19%" align="center">
				<?php echo $LASTLOGIN; ?>
				</td>
		<td width="12%" align="center">
				<?php echo $STATUS[$USER['status']]; ?>
				</td>
		<td width="23%">
				<CENTER>
				<input type="checkbox" name="delete[<?php echo $USER['id']; ?>]" value="<?php echo $USER['id']; ?>">
				</CENTER>
		</td>
</tr>
<?php
}
?>
</table>
<A HREF="./increments.php" CLASS="links">
</A></td>
</tr>
<tr>
<td width=169>
<input type="hidden" name="action" value="update">
</td>
<td width="365">&nbsp; </td>
</tr>
<tr>
<td width=169></td>
<td width="365"> </td>
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