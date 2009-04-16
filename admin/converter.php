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

include "../includes/common.inc.php";
include $include_path."converter.inc.php";

$CURRENCIES=CurrenciesList();

if (isset($_POST['action']) && $_POST['action'] == "convert") {
	#// Convert
	$CONVERTED = ConvertCurrency($_POST['from'], $_POST['to'],$_POST['amount'] );
}

?>
<html>
<head>
<TITLE>::: PHPAUCTION :::</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF" TEXT="#000000" LEFTMARGIN="0" TOPMARGIN="0" MARGINwidth="0" MARGINheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
	<td bgcolor="<?php echo $system->SETTINGS['bordercolor']; ?>"><FONT FACE="Tahoma, Verdana" SIZE="2" COLOR="#FFFFFF">
	  <?php echo $nav_font; ?>
	  <B>::: CURRENCY CONVERTER :::</B></FONT></td>
  </tr>
  <tr>
	<td><form name="form1" METHOD="post" ACTION="">
		<BR>
		<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#666666">
		  <tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFFFFF">
				<?php
				if (isset($_POST['action']) && $_POST['action'] == "convert") {
				?>
				<tr valign="top" bgcolor="#eeeeee">
				  <td colspan="3" align="center"><FONT FACE=Verdana,Arial SIZE=2>
					<?php echo number_format($_POST['amount'],4,'.',','); ?>
					<?php echo $_POST['from']; ?>
					=
					<?php echo number_format($CONVERTED,4,'.',','); ?>
					<?php echo $_POST['to']; ?>
					</font> </td>
				</tr>
				<?php
				} else {
				?>
				<tr valign="top" bgcolor="#FFFFFF">
				  <td colspan="3" align="center">&nbsp;</td>
				</tr>
				<?php
				}
				?>
				<tr valign="top">
				  <td width="15%"><FONT FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="2">Convert</FONT><BR>
					<input type="text" name="amount" SIZE="5" VALUE=<?php echo $AMOUNT; ?>>
				  </td>
				  <td width="39%"><FONT FACE="Geneva, Arial, Helvetica, san-serif" SIZE="2">of this currency<BR>
					<SELECT name="from">
					  <?php
					  foreach ($CURRENCIES as $k=>$v) {
					  	print "<OPTION VALUE=\"$k\"";
					  	if ($k == $system->SETTINGS['currency']) {
					  		print " SELECTED";
					  	} elseif ($_POST['from'] == $k) {
					  		print " SELECTED";
					  	}
					  	print ">$k $v</OPTION>\n";
					  }
					?>
					</SELECT>
					</SELECT>
					</FONT></td>
				  <td width="32%"><FONT FACE="Geneva, Arial, Helvetica, san-serif" SIZE="2">into this currency<BR>
					<SELECT name="to">
					  <?php
					  foreach ($CURRENCIES as $k=>$v) {
					  	print "<OPTION VALUE=\"$k\"";
					  	if ($_POST['to'] == $k) print " SELECTED";
					  	print ">$k $v</OPTION>\n";
					  }
					?>
					</SELECT>
					</FONT></td>
				</tr>
				<tr valign="top">
				  <td colspan="3"><CENTER>
					  <input type="hidden" name="action" value="convert">
					  <input type="submit" name="Submit" value="<?php echo $MSG['25_0176']; ?>">
					</CENTER></td>
				</tr>
			  </table></td>
		  </tr>
		</table>
	  </form></td>
  </tr>
  <tr>
	<td><CENTER>
		<FONT FACE="Tahoma, Verdana" SIZE="2"><A HREF="javascript:window.close()">Close</A></FONT>
	  </CENTER></td>
  </tr>
</table>
</body>
</html>
