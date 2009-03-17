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

require('../includes/config.inc.php');
include "loggedin.inc.php";

// Insert new currency
if(isset($_POST['action']) && $_POST['action'] == "update") {
	if(empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active'])) {
		$ERR = $ERR_047;
	} elseif(!ereg("^[0-9]+$", $_POST['msgstoshow'])) {
		$ERR = $ERR_5000;
	} elseif(intval($_POST['msgstoshow'] == 0)) {
		$ERR = $ERR_5001;
	} else {
		$query = "UPDATE " . $DBPrefix . "community
				  SET name = '" . addslashes($_POST['name']) . "',
				  msgstoshow = " . intval($_POST['msgstoshow']) . ",
				  active = " . intval($_POST['active']) . "
				  WHERE id = " . intval($_POST['id']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		header("Location: boards.php");
		exit;
	}
}
$id = intval($_GET['id']);
// Retrieve board's data from the database
$query = "SELECT * FROM " . $DBPrefix . "community WHERE id = " . $id;
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);
$BOARD = mysql_fetch_array($res_);
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
            <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5052']; ?></td>
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
                <?php echo $MSG['5052']; ?>
            </TD>
          </TR>
          <tr><td>
          <TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
          <?
			  if(!empty($ERR))
			  {
		  ?>
          <TR BGCOLOR=yellow>
            <TD COLSPAN="2" ALIGN=CENTER><B><FONT COLOR="#FF0000">
              <? print $ERR; ?>
              </FONT></B></TD>
          </TR>
          <?
			}
		  ?>
          <TR>
            <TD WIDTH="17%">
			  <?php echo $MSG['5034']; ?>
            </TD>
            <TD>
              <INPUT TYPE="text" NAME="name" SIZE="25" MAXLENGTH="255" VALUE="<?php echo $BOARD[name]; ?>">
            </TD>
          </TR>
          <TR>
            <TD WIDTH="17%">
			  <?php echo $MSG['5043']; ?>
            </TD>
            <TD>
				<B>
              <?php echo $BOARD['messages']; ?>
              </B> &nbsp;&nbsp;
              <?
				  if($BOARD['messages'] > 0)
				  {
			  ?>
              &nbsp;&nbsp;&nbsp;<img src="images/ball.gif" width="12" height="12"><img src="images/ball.gif" width="12" height="12">&nbsp;<a href="editmessages.php?id=<?php echo $id; ?>">
              <?php echo $MSG['5063']; ?>
              </a>
              <?
				  }
			  ?>
            </TD>
          </TR>
          <TR>
            <TD WIDTH="17%">
			  <?php echo $MSG['5053']; ?>
            </TD>
            <TD>
              <?
				  if($BOARD['lastmessage'])
				  {
					  print FormatDate($BOARD['lastmessage']);
				  }
				  else
				  {
					  print "--";
				  }
			  ?>
            </TD>
          </TR>
          <TR>
            <TD WIDTH="17%" VALIGN="TOP"><?php echo $MSG['5035']; ?></TD>
            <TD>
			  <?php echo $MSG['5036']; ?>
              <BR>
              <INPUT TYPE="text" NAME="msgstoshow" SIZE="4" MAXLENGTH="4" VALUE="<?php echo $BOARD['msgstoshow']; ?>">
            </TD>
          </TR>
          <TR>
            <TD WIDTH="17%">
			  <?php echo $MSG['5054']; ?>
            </TD>
            <TD>
              <INPUT TYPE="radio" NAME="active" VALUE="1"
			  <?
				  if($BOARD['active'] == 1)
				  {
					  print " CHECKED";
				  }
			  ?>
			  >
			  <?php echo $MSG['5038']; ?>
              <INPUT TYPE="radio" NAME="active" VALUE="2"
			  <?
				  if($BOARD['active'] == 2)
				  {
					  print " CHECKED";
				  }
			  ?>
			  >
			  <?php echo $MSG['5039']; ?>
            </TD>
          </TR>
          <TR>
            <TD WIDTH="17%">
              <INPUT TYPE="hidden" NAME="action" VALUE="update">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $id; ?>">
            </TD>
            <TD>
              <INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['5029']; ?>">
            </TD>
          </TR>
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