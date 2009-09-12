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

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == "delete") {
	$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE id = " . $_POST['msg'];
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	// Update messages counter
	$query = "UPDATE " . $DBPrefix . "community SET messages = messages - 1 WHERE id = " . $_POST['id'];
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	header("Location: editmessages.php?id=".$_POST['id']);
	exit;
} else {
	$id = intval($_GET['id']);
	$msg_id = intval($_GET['msg']);
	// Retrieve message from the database
	$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE id = " . $msg_id;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$msg = mysql_fetch_array($res);
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<form name="newcurrency" METHOD="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
			<td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5276']; ?></td>
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
				<?php echo $MSG['5276']; ?>
			</td>
		  </tr>
		  <tr><td>
		  <table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
					<tr bgcolor="#FFFFFF">
						<td width="24%" bgcolor="#FFFFFF" valign="top">
							<FONT FACE="Verdana,Helvetica,Arial" SIZE="2">
							<?php echo $MSG['333']; ?>
						</td>
						<td width="76%" valign="top">
						<FONT FACE="Verdana,Helvetica,Arial" SIZE="2">
						<?php echo nl2br($msg['message']); ?></td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td width="24%"><FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><?php echo $MSG['5060']; ?></td>
						<td width="76%">
						<FONT FACE="Verdana,Helvetica,Arial" SIZE="2">
							<?
								if ($msg['user'] > 0) {
									print $msg['username'];
								}
								else
								{
									print $MSG['5061'];
								}
							?>
							-
							<?php echo FormatDate($msg['msgdate']); ?>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td width="24%">
							<input type="hidden" name="action" value="delete">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="msg" value="<?php echo $msg_id; ?>">
						</td>
						<td width="76%">
							<input type="submit" name="Submit" value="<?php echo $MSG['5276']; ?>">
						</td>
					</tr>
				</table>
		</td></tr>
		</table>
		</td></tr>
			</td>
		</tr>
	</table>
	<A HREF="boards.php"><?php echo $MSG['5032']; ?></A> | <A HREF=editmessages.php?id=<?php echo $id; ?>><?php echo $MSG['5277']; ?></A>
</form>
</body>
</html>