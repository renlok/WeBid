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

#// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == "insert") {
	if (empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active'])) {
		$ERR = $ERR_047;
	} elseif (!ereg("^[0-9]+$",$_POST['msgstoshow'])) {
		$ERR = $ERR_5000;
	} elseif (intval($_POST['msgstoshow'] == 0)) {
		$ERR = $ERR_5001;
	} else {
		$query = "INSERT INTO " . $DBPrefix . "community VALUES (NULL, '".addslashes($_POST['name'])."', 0, 0, ".intval($_POST['msgstoshow']).", ".intval($_POST['active'])." )";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		header("Location: boards.php");
		exit;
	}
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="newcurrency" METHOD="post" action="">

<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
<tr> 
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
			<td width="30"><img src="images/i_con.gif" ></td>
			<td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5031']; ?></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" valign="middle">&nbsp;</td>
</tr>
<tr>
	<td>
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		<tr>
			<td align="center" class=title>
				<?php echo $MSG['5031']; ?>
			</td>
		</tr>
		<tr>
		<td>
			<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
			<?
			if (!empty($ERR))
			{
			?>
			<tr bgcolor="yellow">
				<td colspan="2"> <FONT SIZE=2 COLOR=red><B>
				<?php echo $ERR; ?>
				</B></FONT></td>
			</tr>
			<?
			}
			?>
			<tr bgcolor="#FFFFFF">
				<td width="24%"><?php echo $MSG['5034']; ?></td>
				<td width="76%">
				<input type="text" name="name" SIZE="25" MAXLENGTH="255" value="<?php echo $_POST['name']; ?>">
			</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td width="24%" valign="top"><?php echo $MSG['5035']; ?></td>
				<td width="76%"><FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><?php echo $MSG['5036']; ?><BR>
				<input type="text" name="msgstoshow" SIZE="4" MAXLENGTH="4" value="<?php echo $_POST['msgstoshow']; ?>">
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td width="24%"><?php echo $MSG['5037']; ?></td>
				<td width="76%">
				<input type="radio" name="active" value="1"
				<?
				if ($_POST['active'] == 1 || !isset($_POST['active']))
				{
				  print " CHECKED";
				}
				?>
				>
				<?php echo $MSG['5038']; ?>
				<input type="radio" name="active" value="2"
				<?
				if ($_POST['active'] == 2)
				{
				  print " CHECKED";
				}
				?>
				>
				<?php echo $MSG['5039']; ?></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td width="24%">
				<input type="hidden" name="action" value="insert">
				</td>
				<td width="76%">
				<input type="submit" name="Submit" value="<?php echo $MSG['5029']; ?>">
				</td>
			</tr>
			</table>
		</td>
		</tr>
		</table>
	</td>
</tr>
<tr align=center>
	<td bgcolor="#EEEEEE"><A HREF="boards.php"><?php echo $MSG['5033']; ?></A></td>
</tr>
</table>
</form>
</body>
</html>
