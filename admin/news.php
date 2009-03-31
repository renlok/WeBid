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


//-- Set offset and limit for pagination
$limit = 20;
if (!isset($offset)) $offset = 0;
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['516']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
	<TR>
		<TD ALIGN=CENTER class=title>
			<?php print $MSG['516']; ?>
		</TD>
	</TR>
	<TR>
		<TD>
			<TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN="CENTER" CELLPADDING="3">
				<TR>
					<TD ALIGN=center COLSPAN=5 BGCOLOR=#EEEEEE>
						<B><A HREF="addnew.php">
						<?php print $MSG['518']; ?>
						</A></B>
					</TD>
				</TR>
				<?php
				$query = "select count(id) as news from " . $DBPrefix . "news";
				$result = mysql_query($query);
				if (!$result){
					print "$ERR_001<BR>$query<BR>".mysql_error();
					exit;
				}
				$num_news = mysql_result($result,0,"news");
				print '<TR BGCOLOR=#FFFFFF><TD COLSPAN=5><B>
				'.$num_news.' '.$MSG['517'].'</B></TD></TR>';
	?>
				<TR BGCOLOR="#dddddd">
					<TD ALIGN=CENTER WIDTH=20%> 
						<B>
						<?php print $MSG['314']; ?>
						</B>  </TD>
					<TD ALIGN=center WIDTH=60%> 
						<B>
						<?php print $MSG['312']; ?>
						</B>  </TD>
					<TD ALIGN=center> 
						<B>
						<?php print $MSG['297']; ?>
						</B>  </TD>
				<TR>
					<?php
					$query = "select * from " . $DBPrefix . "news order by new_date limit $offset, $limit";
					$result = mysql_query($query);
					if (!$result){
						print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
						exit;
					}
					$num_news2 = mysql_num_rows($result);
					$i = 0;
					$bgcolor = "#FFFFFF";
					while ($i < $num_news2){
						
						if ($bgcolor == "#FFFFFF"){
							$bgcolor = "#EEEEEE";
						}else{
							$bgcolor = "#FFFFFF";
						}
						
						$id = mysql_result($result,$i,"id");
						$title = 	stripslashes(mysql_result($result,$i,"title"));
						$tmp_date = mysql_result($result,$i,"new_date") + $system->tdiff;
						$suspended = mysql_result($result,$i,"suspended");
						
						print "<TR BGCOLOR=$bgcolor>
					<TD>
						";
						if ($system->SETTINGS['datesformat'] != 'USA')
						{
							print gmdate('d/m/Y', $tmp_date);
						}
						else
						{
							print gmdate('m/d/Y', $tmp_date);
						}
						
						print " 
						</TD>
						<TD>
						";
						if ($suspended == 1)
						{
							print "<FONT COLOR=red><B>$title</B>";
						}
						else
						{
							print $title;
						}
						print "
						</TD>

						<TD ALIGN=LEFT>
						<A HREF=\"editnew.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['298']."</A><BR>
						<A HREF=\"deletenew.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['008']."</A>
						<BR>
						</TD>
						<TR>";
						
						$i++;
					}
					
					print "</TABLE>
			   </TD></TR></TABLE>";
					
					
					
					//-- Build navigation line
					print "<TABLE WIDTH=600 BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
			   <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
			   <TD COLSPAN=2>";
					
					print "<SPAN CLASS=\"navigation\">";
					$num_pages = ceil($num_news / $limit);
					$i = 0;
					while ($i < $num_pages ){
						
						$of = ($i * $limit);
						
						if ($of != $offset){
							print "<A HREF=\"news.php?offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
							if ($i != $num_pages) print " | ";
						}else{
							print $i + 1;
							if ($i != $num_pages) print " | ";
						}
						
						$i++;
					}
					print "</SPAN></TD></TR>";
	  ?>
		</TABLE>
		</TD>
		</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>