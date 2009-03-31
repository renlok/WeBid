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

?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<STYLE type="text/css">
<!--
.bluelink {  font: 10pt Verdana, Arial, Helvetica, sans-serif; color: 000066; text-decoration: none}
-->
</STYLE></HEAD>

<BODY bgcolor="#FFFFFF">
<CENTER>
  <P><B><FONT face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#000066">Bid
	increments table</FONT></B> </P>
  <TABLE width="352" border="0" cellspacing="0" cellpadding="0">
	<TR>
	  <TD>
		<P><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">The bid
		  increments table determines the increment between two bids.<BR>
		  The increment depends on the current price (higher bid) the auction
		  reached.<BR>
		  <BR>
		  You must enter price intervals specifying the low limit (FROM column),
		  the uppre limit (TO column) and the increment (in the currency you are
		  using) for that interval.<BR>
		  </FONT><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2"><BR>
		  The last increment you specify will be valid also for all the upper
		  values of price.</FONT></P>
		<P><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2"> Be sure
		  to check the intervals and increments congruence yourself, no check
		  is made upon that.</FONT></P>
		<P><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">An example
		  follows.</FONT></P>
		<CENTER>
	  <TABLE cellpadding=5 cellspacing=1 border=1 width="280">
			<TR bgcolor="#54B4B6">
			  <TD align=center width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><STRONG>From</STRONG></FONT></TD>
			  <TD align=center width="79"> <FONT face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><STRONG>To</STRONG>
				</FONT></TD>
			  <TD align=center width="90"> <FONT face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><STRONG>
				Increment</STRONG> </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$0.01</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$0.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$0.05 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$1.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$9.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$0.25 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$10.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$24.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$0.50 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$25.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$99.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$1.00 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$100.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$249.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$2.50 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$250.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$499.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$5.00 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$500.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$999.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$10.00 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$1,000.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$2,499.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$25.00 </FONT></TD>
			</TR>
			<TR>
			  <TD width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$2,500.00</FONT></TD>
			  <TD width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$4,999.99 </FONT></TD>
			  <TD width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$50.00 </FONT></TD>
			</TR>
			<TR>
			  <TD height="31" width="66"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">$5,000.00</FONT></TD>
			  <TD height="31" width="79"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$10,000.00 </FONT></TD>
			  <TD height="31" width="90"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">
				$100.00 </FONT></TD>
			</TR>
		  </TABLE>
	  <P align="left"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">This
			is a suggested increments table only, feel free to built the one you
			wish.<BR>
			Please note that the $100.00 increment will be taken also for a current
			prices over $10,000.00.</FONT></P>
		  <P align="center"><A href="javascript:window.close()"><FONT face="Verdana, Arial, Helvetica, sans-serif" size="2">Close</FONT></A></P>
		</CENTER>
		</TD>
	</TR>
  </TABLE>
  </CENTER>
</BODY>
</HTML>
