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

#// Insert new currency
if(isset($_POST['action']) && $_POST['action'] == "insert") {
	if(empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active'])) {
		$ERR = $ERR_047;
	} elseif(!ereg("^[0-9]+$",$_POST['msgstoshow'])) {
		$ERR = $ERR_5000;
	} elseif(intval($_POST['msgstoshow'] == 0)) {
		$ERR = $ERR_5001;
	} else {
		$query = "INSERT INTO " . $DBPrefix . "community VALUES (NULL, '".addslashes($_POST['name'])."', 0, 0, ".intval($_POST['msgstoshow']).", ".intval($_POST['active'])." )";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		header("Location: boards.php");
		exit;
	}
}
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM NAME="newcurrency" METHOD="post" ACTION="">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER">
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
<TR>
    <TD>
        <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
        <TR>
            <TD ALIGN=CENTER class=title>
                <?php echo $MSG['5031']; ?>
            </TD>
        </TR>
        <tr>
        <td>
            <TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
            <?
            if(!empty($ERR))
            {
            ?>
            <TR BGCOLOR="yellow">
                <TD COLSPAN="2"> <FONT SIZE=2 COLOR=red><B>
                <?php echo $ERR; ?>
                </B></FONT></TD>
            </TR>
            <?
            }
            ?>
            <TR BGCOLOR="#FFFFFF">
                <TD WIDTH="24%"><?php echo $MSG['5034']; ?></TD>
                <TD WIDTH="76%">
                <INPUT TYPE="text" NAME="name" SIZE="25" MAXLENGTH="255" VALUE="<?php echo $_POST['name']; ?>">
            </TD>
            </TR>
            <TR BGCOLOR="#FFFFFF">
                <TD WIDTH="24%" VALIGN="TOP"><?php echo $MSG['5035']; ?></TD>
                <TD WIDTH="76%"><FONT FACE="Verdana,Helvetica,Arial" SIZE="2"><?php echo $MSG['5036']; ?><BR>
                <INPUT TYPE="text" NAME="msgstoshow" SIZE="4" MAXLENGTH="4" VALUE="<?php echo $_POST['msgstoshow']; ?>">
                </TD>
            </TR>
            <TR BGCOLOR="#FFFFFF">
                <TD WIDTH="24%"><?php echo $MSG['5037']; ?></TD>
                <TD WIDTH="76%">
                <INPUT TYPE="radio" NAME="active" VALUE="1"
                <?
                if($_POST['active'] == 1 || !isset($_POST['active']))
                {
                  print " CHECKED";
                }
                ?>
                >
                <?php echo $MSG['5038']; ?>
                <INPUT TYPE="radio" NAME="active" VALUE="2"
                <?
                if($_POST['active'] == 2)
                {
                  print " CHECKED";
                }
                ?>
                >
                <?php echo $MSG['5039']; ?></TD>
            </TR>
            <TR BGCOLOR="#FFFFFF">
                <TD WIDTH="24%">
                <INPUT TYPE="hidden" NAME="action" VALUE="insert">
                </TD>
                <TD WIDTH="76%">
                <INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['5029']; ?>">
                </TD>
            </TR>
            </TABLE>
        </td>
        </tr>
        </table>
    </TD>
</TR>
<TR align=center>
    <TD BGCOLOR="#EEEEEE"><A HREF="boards.php"><?php echo $MSG['5033']; ?></A></TD>
</TR>
</TABLE>
</FORM>
</BODY>
</HTML>
