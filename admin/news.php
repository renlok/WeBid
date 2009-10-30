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


//-- Set offset and limit for pagination
$limit = 20;
if (!isset($offset)) $offset = 0;
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
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
	<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
	<tr>
		<td align="center" class=title>
			<?php print $MSG['516']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<table width=100% CELPADDING=0 cellspacing=1 border=0 align="center" cellpadding="3">
				<tr>
					<td ALIGN=center COLSPAN=5 bgcolor=#EEEEEE>
						<B><A HREF="addnew.php">
						<?php print $MSG['518']; ?>
						</A></B>
					</td>
				</tr>
				<?php
				$query = "select count(id) as news from " . $DBPrefix . "news";
				$result = mysql_query($query);
				if (!$result){
					print "$ERR_001<BR>$query<BR>".mysql_error();
					exit;
				}
				$num_news = mysql_result($result,0,"news");
				print '<tr bgcolor=#FFFFFF><td COLSPAN=5><B>
				'.$num_news.' '.$MSG['517'].'</B></td></tr>';
	?>
				<tr bgcolor="#dddddd">
					<td align="center" width=20%> 
						<B>
						<?php print $MSG['314']; ?>
						</B>  </td>
					<td ALIGN=center width=60%> 
						<B>
						<?php print $MSG['312']; ?>
						</B>  </td>
					<td ALIGN=center> 
						<B>
						<?php print $MSG['297']; ?>
						</B>  </td>
				<tr>
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
						
						print "<tr bgcolor=$bgcolor>
					<td>
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
						</td>
						<td>
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
						</td>

						<td ALIGN=LEFT>
						<A HREF=\"editnew.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['298']."</A><BR>
						<A HREF=\"deletenew.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['008']."</A>
						<BR>
						</td>
						<tr>";
						
						$i++;
					}
					
					print "</table>
			   </td></tr></table>";
					
					
					
					//-- Build navigation line
					print "<table width=600 border=0 cellpadding=4 cellspacing=0 align=\"center\">
			   <tr align=\"center\" bgcolor=#FFFFFF>
			   <td COLSPAN=2>";
					
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
					print "</SPAN></td></tr>";
	  ?>
		</table>
		</td>
		</tr>
</table>
</td>
</tr>
</table>
</body>
</html>