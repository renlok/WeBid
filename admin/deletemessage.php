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
include "loggedin.inc.php";

// Insert new currency
if(isset($_POST['action']) && $_POST['action'] == "delete") {
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
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM NAME="newcurrency" METHOD="post" ACTION="">
  <TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
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
		<TR>
			<td align="center" valign="middle">

        <TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
        <tr><td align="center" valign="middle">
        <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
          <TR>
            <TD ALIGN=CENTER class=title colspan="2">
                <?php echo $MSG['5276']; ?>
            </TD>
          </TR>
          <tr><td>
          <TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
					<TR BGCOLOR="#FFFFFF">
						<TD WIDTH="24%" BGCOLOR="#FFFFFF" VALIGN="TOP">
							<FONT FACE="Verdana,Helvetica,Arial" SIZE="2">
							<?php echo $MSG['333']; ?>
						</TD>
						<TD WIDTH="76%" VALIGN="TOP">
						<FONT FACE="Verdana,Helvetica,Arial" SIZE="2">
						<?php echo nl2br($msg['message']); ?></TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD WIDTH="24%"><FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><?php echo $MSG['5060']; ?></TD>
						<TD WIDTH="76%">
						<FONT FACE="Verdana,Helvetica,Arial" SIZE="2">
							<?
								if($msg['user'] > 0) {
									print $msg['username'];
								}
								else
								{
									print $MSG['5061'];
								}
							?>
							-
							<?php echo FormatDate($msg['msgdate']); ?>
						</TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD WIDTH="24%">
							<INPUT TYPE="hidden" NAME="action" VALUE="delete">
							<INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $id; ?>">
							<INPUT TYPE="hidden" NAME="msg" VALUE="<?php echo $msg_id; ?>">
						</TD>
						<TD WIDTH="76%">
							<INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['5276']; ?>">
						</TD>
					</TR>
				</TABLE>
        </td></tr>
        </TABLE>
        </td></tr>
			</TD>
		</TR>
	</TABLE>
    <A HREF="boards.php"><?php echo $MSG['5032']; ?></A> | <A HREF=editmessages.php?id=<?php echo $id; ?>><?php echo $MSG['5277']; ?></A>
</FORM>
</BODY>
</HTML>