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

if(!defined('InWeBid')) exit();
include $include_path . "platforms.inc.php";

?>
<HTML>
<HEAD>
<TITLE>Untitled Document</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<STYLE type="text/css">
<!--
.bluelink {  font: 10pt Verdana, Arial, Helvetica, sans-serif; color: 000066; text-decoration: none}
-->
</STYLE></HEAD>

<BODY bgcolor="#FFFFFF">
<CENTER>
  <P><B>
  <FONT face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#000066">
  <?php echo $MSG['5156']; ?></FONT></B> </P>
   <P align="center"><A href="javascript:window.close()" class="bluelink">Close</A></P>
	<TABLE width="352" border="0" cellspacing="0" cellpadding="0">
    <TR>
      <TD>
	  <FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
      <?php
	  	while(list($k,$v) = each($OS))
		{
			print "$v<BR>";
		}
	   ?>
      </TD>
    </TR>
  </TABLE>
  </CENTER>
 <P align="center"><A href="javascript:window.close()" class="bluelink">Close</A></P>

</BODY>
</HTML>
