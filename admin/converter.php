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

include "../includes/config.inc.php";
include $include_path."converter.inc.php";

$CURRENCIES=CurrenciesList();

if(isset($_POST['action']) && $_POST['action'] == "convert") {
	#// Convert
	$CONVERTED = ConvertCurrency($_POST['from'], $_POST['to'],$_POST['amount'] );
}

?>
<HTML>
<HEAD>
<TITLE>::: PHPAUCTION :::</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
</HEAD>
<BODY BGCOLOR="#FFFFFF" TEXT="#000000" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="4">
  <TR>
    <TD BGCOLOR="<?php echo $system->SETTINGS['bordercolor']; ?>"><FONT FACE="Tahoma, Verdana" SIZE="2" COLOR="#FFFFFF">
      <?php echo $nav_font; ?>
      <B>::: CURRENCY CONVERTER :::</B></FONT></TD>
  </TR>
  <TR>
    <TD><FORM NAME="form1" METHOD="post" ACTION="">
        <BR>
        <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" BGCOLOR="#666666">
          <TR>
            <TD><TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="5" BGCOLOR="#FFFFFF">
                <?php
                if(isset($_POST['action']) && $_POST['action'] == "convert") {
				?>
                <TR VALIGN="TOP" BGCOLOR="#eeeeee">
                  <TD COLSPAN="3" ALIGN=CENTER><FONT FACE=Verdana,Arial SIZE=2>
                    <?php echo number_format($_POST['amount'],4,'.',','); ?>
                    <?php echo $_POST['from']; ?>
                    =
                    <?php echo number_format($CONVERTED,4,'.',','); ?>
                    <?php echo $_POST['to']; ?>
                    </font> </TD>
                </TR>
                <?php
                } else {
				?>
                <TR VALIGN="TOP" BGCOLOR="#FFFFFF">
                  <TD COLSPAN="3" ALIGN=CENTER>&nbsp;</TD>
                </TR>
                <?php
                }
				?>
                <TR VALIGN="TOP">
                  <TD WIDTH="15%"><FONT FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="2">Convert</FONT><BR>
                    <INPUT TYPE="text" NAME="amount" SIZE="5" VALUE=<?php echo $AMOUNT; ?>>
                  </TD>
                  <TD WIDTH="39%"><FONT FACE="Geneva, Arial, Helvetica, san-serif" SIZE="2">of this currency<BR>
                    <SELECT NAME="from">
                      <?php
                      foreach($CURRENCIES as $k=>$v) {
                      	print "<OPTION VALUE=\"$k\"";
                      	if($k == $system->SETTINGS['currency']) {
                      		print " SELECTED";
                      	} elseif($_POST['from'] == $k) {
                      		print " SELECTED";
                      	}
                      	print ">$k $v</OPTION>\n";
                      }
					?>
                    </SELECT>
                    </SELECT>
                    </FONT></TD>
                  <TD WIDTH="32%"><FONT FACE="Geneva, Arial, Helvetica, san-serif" SIZE="2">into this currency<BR>
                    <SELECT NAME="to">
                      <?php
                      foreach($CURRENCIES as $k=>$v) {
                      	print "<OPTION VALUE=\"$k\"";
                      	if($_POST['to'] == $k) print " SELECTED";
                      	print ">$k $v</OPTION>\n";
                      }
					?>
                    </SELECT>
                    </FONT></TD>
                </TR>
                <TR VALIGN="TOP">
                  <TD COLSPAN="3"><CENTER>
                      <INPUT TYPE="hidden" NAME="action" VALUE="convert">
                      <INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['25_0176']; ?>">
                    </CENTER></TD>
                </TR>
              </TABLE></TD>
          </TR>
        </TABLE>
      </FORM></TD>
  </TR>
  <TR>
    <TD><CENTER>
        <FONT FACE="Tahoma, Verdana" SIZE="2"><A HREF="javascript:window.close()">Close</A></FONT>
      </CENTER></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
