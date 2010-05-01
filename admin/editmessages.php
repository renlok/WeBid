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

if (isset($_POST['action']) && $_POST['action'] == "purge") {
	if (is_numeric($_POST['days'])) {
		// Build date
		$DATE = time() - $_POST['days'] * 3600 * 24;
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE msgdate <= $DATE AND boardid = " . $id;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		// Update counter
		$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "comm_messages WHERE boardid = " . $id;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$query = "UPDATE " . $DBPrefix . "community SET messages = " . mysql_result($res, 0, "COUNTER") . " WHERE id = " . $id;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
}
$id = intval($_GET['id']);
#// Retrieve board's messages from the database
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE boardid = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<form name="purge" METHOD="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
			<td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5063']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
		<tr>
			<td align="center" valign="middle">

		<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
		<tr><td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		  <tr>
			<td align="center" class=title colspan="2">
				<?php echo $MSG['5063']; ?>
			</td>
		  </tr>
		  <tr><td>
		  <table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">

		  <tr bgcolor="#FFFFFF">
			<td colspan="2" bgcolor="#33CC66"> <FONT FACE=Verdana,Arial SIZE=2 COLOR=red><B>
			  <font color="#FFFFFF"><?php echo $MSG['5065']; ?>
			  <input type="text" name="days" size="5">
			   <?php echo $MSG['5115']; ?>
			  <input type="hidden" name="action" VALUE=purge>
			  <input type="hidden" name="id" VALUE=<?php echo $id; ?>>
			  <input type="submit" name="Submit" value="<?php echo $MSG['5029']; ?>">
			  </font></B></FONT></td>
		  </tr>
		  <tr bgcolor="#FFFFFF">
			<td colspan="2" align=center> <FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><A HREF=editboards.php?id=<?php echo $id; ?>><?php echo $MSG['5064']; ?></A> </td>
		  </tr>
		  <?
			  while ($msg = mysql_fetch_array($res))
			  {
		  ?>
		  <tr bgcolor="#FFFFFF">
			<td colspan="2">
			  <FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><?php echo nl2br($msg[message]); ?>
			  <BR>
			  <FONT SIZE=-2><?php echo $MSG['5060']; ?> <B>
			  <?php echo $msg['username']; ?>
			  </B> -
			  <?php echo FormatDate($msg['msgdate']); ?>
			  </FONT> <BR>
			  <CENTER>
				<A HREF="editmessage.php?id=<?php echo $id; ?>&msg=<?php echo $msg['id']; ?>"><?php echo $MSG['298']; ?></A>&nbsp;|&nbsp;<A
				HREF="deletemessage.php?id=<?php echo $id; ?>&msg=<?php echo $msg['id']; ?>"><?php echo $MSG['008']; ?></A>
			  </CENTER>
			</td>
		  </tr>
		  <?
						}
					?>
		</table>
		</td></tr>
		</table>
		</td></tr>
			</td>
		</tr>
	</table>
	<A HREF="boards.php"><?php echo strtoupper($MSG['5032']); ?></A>
</form>
</body>
</html>