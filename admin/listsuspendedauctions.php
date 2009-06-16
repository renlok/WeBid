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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
//-- Set offset and limit for pagination
$limit = 20;
if (!$offset) $offset = 0;
$_SESSION['RETURN_LIST'] = 'listsuspendedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = intval($_GET['offset']);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php	require('../includes/styles.inc.php'); ?>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_auc.gif" ></td>
		  <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5227']; ?></td>
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
  <td align="center" class=title><?php print $MSG['5227']; ?></td>
</tr>
<tr>
  <td><table width=100% CELPADDING=0 cellspacing=1 border=0 align="center" cellpadding="3">
	  <?php
	  $query = "select count(id) as auctions from " . $DBPrefix . "auctions WHERE suspended<>0 ";
	  $result = mysql_query($query);
	  if (!$result){
	  	print "$ERR_001<BR>$query<BR>".mysql_error();
	  	exit;
	  }
	  $num_auctions = mysql_result($result,0,"auctions");
	  print "<tr bgcolor=#FFFFFF><td COLSPAN=7><B>
				$num_auctions ".$MSG['311']."</B></td></tr>";
	?>
	  <tr bgcolor="#FFCC00">
		<td align="center"> <B> <?php print $MSG['312']; ?> </B>  </td>
		<td align="center"> <B> <?php print $MSG['313']; ?> </B>  </td>
		<td align="center"> <B> <?php print $MSG['314']; ?> </B>  </td>
		<td align="center"> <B> <?php print $MSG['315']; ?> </B>  </td>
		<td ALIGN=LEFT> <B> <?php print $MSG['316']; ?> </B>  </td>
		<td ALIGN=LEFT> <B> <?php print $MSG['317']; ?> </B>  </td>
		<td ALIGN=LEFT> <B> <?php print $MSG['297']; ?> </B>  </td>
	</tr>	
		<?php
		$query = "SELECT a.*,u.*,c.*,d.description as duration
					FROM
					" . $DBPrefix . "auctions a,
					" . $DBPrefix . "users u,
					" . $DBPrefix . "categories c,
					" . $DBPrefix . "durations d
					WHERE
					u.id = a.user AND
					c.cat_id = a.category AND
					a.suspended<>'0'
					group by a.id ORDER BY u.nick limit $offset, $limit";
		$result = mysql_query($query);
		if (!$result){
			print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
			exit;
		}
		$num_auction = mysql_num_rows($result);
		$i = 0;
		$bgcolor = "#FFFFFF";
		while ($i < $num_auction){
			if ($bgcolor == "#FFFFFF") {
				$bgcolor = "#EEEEEE";
			}else{
				$bgcolor = "#FFFFFF";
			}
			$id = mysql_result($result,$i,"id");
			$title = stripslashes(mysql_result($result,$i,"title"));
			$nick = mysql_result($result,$i,"nick");
			$tmp_date = mysql_result($result,$i,"starts") + $system->tdiff;
			$duration = mysql_result($result,$i,"duration");
			$category = mysql_result($result,$i,"cat_name");
			$description = strip_tags(stripslashes(mysql_result($result,$i,"description")));
			$suspended = mysql_result($result,$i,"suspended");
			if ($system->SETTINGS['datesformat'] == 'USA') {
				$date = gmdate('m/d/Y', $tmp_date);
			} else {
				$date = gmdate('d/m/Y', $tmp_date);
			}
			
			print "<tr bgcolor=$bgcolor>
					<td>";
			if ($suspended == 1) {
				print "<FONT COLOR=red><B>$title</B>";
			} else {
				print $title;
			}
			print "
						</td>
						<td>
						".$nick."
						
						</td>
						<td>
						".$date."
						
						</td>
						<td>
						$duration
						
						</td>
						<td>
						$category
						
						</td>
						<td>
						$description
						
						</td>
						<td ALIGN=LEFT>
						<A HREF=\"editauction.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['298']."</A><BR>
						<A HREF=\"deleteauction.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['008']."</A><BR>
						<A HREF=\"excludeauction.php?id=$id&offset=$offset\" class=\"nounderlined\">";
			if ($suspended == 0) {
				print $MSG['300'];
			} else {
				print $MSG['310'];
			}
			print "</A><BR>
						</td>
						<tr>";
			
			$i++;
		}
		?>
		</table>
		<?php
		//-- Build navigation line
		print '<table width=100% border=0 cellpadding=4 cellspacing=0 align="center">
			   <tr align="center" bgcolor=#FFFFFF>
			   <td COLSPAN=2>';
		print "<SPAN CLASS=\"navigation\">";
		$num_pages = ceil($num_auctions / $limit);
		$i = 0;
		while ($i < $num_pages ){
			$of = ($i * $limit);
			if ($of != $offset){
				print "<A HREF=\"listsuspendedauctions.php?offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
				if ($i != $num_pages) print " | ";
			}else{
				print $i + 1;
				if ($i != $num_pages) print " | ";
			}
			$i++;
		}
		print "</SPAN></tr></td></table>";
	  ?>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>