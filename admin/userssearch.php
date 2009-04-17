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

#// Return if empty search
if ($_POST['keyword'] == '') {
	header('location: listusers.php');
	exit;
}
?>
<link rel="stylesheet" type="text/css" href="style.css" />
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_use.gif" ></td>
		  <td class=white><?php echo $MSG['25_0010']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['045']; ?></td>
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
  <td align="center" class=title><?php print $MSG['045']; ?></td>
</tr>
<tr>
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
	<form NAME=search ACTION=userssearch.php method="post">
	<tr>
	  <td bgcolor="#eeeeee"> 
		<BR>
		<?php echo $MSG['5022']; ?> <input type=text NAME=keyword SIZE=25>
		<input type=SUBMIT name=SUBMIT value="<?php echo $MSG['5023']; ?>">
		<?php echo $MSG['5024']; ?>
		<BR><BR>
	  </td>
	</tr>
	</form>
  </table>
  </td>
</tr>
<tr>
  <td><table width=100% CELPADDING=0 cellspacing=1 border=0 align="center" cellpadding="3">
	  <?php
		$query = "select count(id) as users from " . $DBPrefix . "users
						WHERE name like '%$_POST[keyword]%' OR nick like '%$_POST[keyword]%' OR email like '%$_POST[keyword]%'";
		$result = mysql_query($query);
		if (!$result) {
			print "$ERR_001<BR>$query<BR>".mysql_error();
			exit;
		}
		$num_usrs = mysql_result($result,0,"users");
		print "<tr bgcolor=#FFFFFF><td COLSPAN=7><B>
				$num_usrs ".$MSG['301']."</B></td></tr>";
		?>
	  <tr bgcolor="#FFCC00">
		<td align="center"> <B> <?php print $MSG['293']; ?> </B>  </td>
		<td align="center"> <B> <?php print $MSG['294']; ?> </B>  </td>
		<td align="center"> <B> <?php print $MSG['295']; ?> </B>  </td>
		<td align="center"> <B> <?php print $MSG['296']; ?> </B>  </td>
		<td ALIGN=LEFT width="10%"> <B> <?php print strtoupper($MSG['25_0079']); ?> </B>  </td>
		<td ALIGN=LEFT width="10%"> <B> <?php print strtoupper($MSG['560']); ?> </B>  </td>
		<td ALIGN=LEFT> <B> <?php print $MSG['297']; ?> </B>  </td>
	  </tr>
		<?php
		$query = "SELECT * FROM " . $DBPrefix . "users
				WHERE name LIKE '%".$_POST['keyword']."%' || nick LIKE '%".$_POST['keyword']."%' || email LIKE '%".$_POST['keyword']."%'
				order by nick";
		$result = mysql_query($query);
		//print $query;
		if (!$result){
			print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
			exit;
		}
		$num_users = mysql_num_rows($result);
		$i = 0;
		$bgcolor = "#FFFFFF";
		while ($i < $num_users) {			
			if ($bgcolor == "#FFFFFF") {
				$bgcolor = "#EEEEEE";
			} else {
				$bgcolor = "#FFFFFF";
			}			
			$id = mysql_result($result,$i,"id");
			$nick = mysql_result($result,$i,"nick");
			$name = mysql_result($result,$i,"name");
			$country = mysql_result($result,$i,"country");
			$email = mysql_result($result,$i,"email");
			$suspended = mysql_result($result,$i,"suspended");
			$newsletter = mysql_result($result,$i,"nletter");
			print "		<tr bgcolor=$bgcolor>
			<td>$nick</td>
			<td>";
			if ($suspended > 0) {
				print "<FONT COLOR=red><B>$name</B>";
			} else {
				print $name;
			}
			print "</td>
			<td>$country</td>
			<td><A HREF=\"mailto:$email\">$email</A></td>
			<td align=center>";
			if ($newsletter == 1) {
				print $MSG['030'];
			}
			if ($newsletter == 2) {
				print $MSG['029'];
			}
			print "</td><td>";
			if ($suspended == 0) {
				print "<B><FONT COLOR=green>".$MSG['5291']."</B>";
			}
			if ($suspended == 9) {
				print "<B><FONT COLOR=red>".$MSG['5293']."</B>";
			}
			if ($suspended == 8) {
				print "<B><FONT COLOR=orange>".$MSG['5292']."</B>
						<BR>
						<FONT SIZE=1 COLOR=#000000><A HREF=resendemail.php?id=$id>".$MSG['25_0074']."</A>";
			}
			if ($suspended == 1) {
				print "<B><FONT COLOR=violet>".$MSG['5294']."</B>";
			}
			if ($suspended == 10) {
				print "<B><FONT COLOR=violet>".$MSG['25_0136']."</B>";
			}
			print "		</td>";
			print "<td ALIGN=LEFT>
				<A HREF=\"edituser.php?userid=$id&offset=$offset\" class=\"nounderlined\">".$MSG['298']."</A><BR>
				<A HREF=\"deleteuser.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['008']."</A><BR>
				<A HREF=\"excludeuser.php?id=$id&offset=$offset\" class=\"nounderlined\">";
				if ($suspended == 0) {
					print $MSG['300'];
				} else {
					print $MSG['310'];
				}
				print "</a><br>
				<A HREF=\"viewuserauctions.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['5094']."</A><BR>
				<A HREF=\"userfeedback.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['503']."</A><BR>
				<A HREF=\"viewuserips.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['2_0004']."</A>
			</td>
		</tr>";
			$i++;
		}		
		print "</table>";
		print "</td></tr></table>";
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
