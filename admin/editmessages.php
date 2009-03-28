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

if(isset($_POST['action']) && $_POST['action'] == "purge") {
	if(ereg("^[0-9]+$", $_POST['days'])) {
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
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM NAME="purge" METHOD="post" ACTION="">
  <TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
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
		<TR>
			<td align="center" valign="middle">

        <TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
        <tr><td align="center" valign="middle">
        <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
          <TR>
            <TD ALIGN=CENTER class=title colspan="2">
                <?php echo $MSG['5063']; ?>
            </TD>
          </TR>
          <tr><td>
          <TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">

          <TR BGCOLOR="#FFFFFF">
            <TD COLSPAN="2" bgcolor="#33CC66"> <FONT FACE=Verdana,Arial SIZE=2 COLOR=red><B>
              <font color="#FFFFFF"><?php echo $MSG['5065']; ?>
              <input type="text" name="days" size="5">
			   <?php echo $MSG['5115']; ?>
			  <input type="hidden" name="action" VALUE=purge>
			  <input type="hidden" name="id" VALUE=<?php echo $id; ?>>
              <input type="submit" name="Submit" value="<?php echo $MSG['5029']; ?>">
              </font></B></FONT></TD>
          </TR>
          <TR BGCOLOR="#FFFFFF">
            <TD COLSPAN="2" align=center> <FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><A HREF=editboards.php?id=<?php echo $id; ?>><?php echo $MSG['5064']; ?></A> </TD>
          </TR>
          <?
			  while($msg = mysql_fetch_array($res))
			  {
		  ?>
          <TR BGCOLOR="#FFFFFF">
            <TD COLSPAN="2">
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
            </TD>
          </TR>
          <?
						}
					?>
        </TABLE>
        </td></tr>
        </TABLE>
        </td></tr>
			</TD>
		</TR>
	</TABLE>
    <A HREF="boards.php"><?php echo strtoupper($MSG['5032']); ?></A>
</FORM>
</BODY>
</HTML>