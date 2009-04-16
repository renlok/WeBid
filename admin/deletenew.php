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

include '../includes/common.inc.php';
$TIME = $system->ctime;

if (isset($_POST['action']) && $_POST['action'] == $MSG['030']) {
	$query = "DELETE FROM " . $DBPrefix . "news WHERE id='".$_POST['id']."'";
	$res = mysql_query($query);
	if (!$res) {
		$ERR = 'ERR_001';
	} else {
		header('location: news.php');
		exit;
	}
} elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029']) {
	header('location: news.php');
	exit;
}

if (!isset($_POST['action'])) {
	$query = "SELECT * FROM " . $DBPrefix . "news WHERE id='".$_GET['id']."'";
	$res = mysql_query($query);
	if (!$res) {
		print $ERR_001;
		exit;
	} else {
		$title = stripslashes(mysql_result($res,0,'title'));
		$content = stripslashes(mysql_result($res,0,'content'));
		$suspended = mysql_result($res,0,'suspended');
		$tmp_date = mysql_result($res,$i,'new_date');
		$day = substr($tmp_date,6,2);
		$month = substr($tmp_date,4,2);
		$year = substr($tmp_date,0,4);
		$new_date = $day.'/'.$month.'/'.$year;
	}
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif">
	  <table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['338']; ?></td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
	<td align="center" valign="middle"><form NAME=addnew ACTION="<?php print basename($_SERVER['PHP_SELF']); ?>" METHOD="POST">
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
<tr>
<td>
	<table width=100% CELPADDING=4 cellspacing=0 border=0 >
	<tr>
	 <td align="center" COLSPAN=2 class=title><?php print $MSG['338']; ?></td>
	</tr>

	<?php
	if ($ERR || $updated) {
		print "<tr><td></td><td width=486>";
		if ($$ERR) print $$ERR;
		if ($updated) print "Data updated";
		print "</td>
		</tr>";
	}
	?>
	<tr bgcolor=#FFFFFF>
	  <td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['432'].' *'; ?>
	  </td>
	  <td width="486">
		<?php
		if ($system->SETTINGS['datesformat'] == "USA") {
			print Date("m/d/Y",$TIME). " (mm/dd/yyyy)";
		} else {
			print Date("d/m/Y",$TIME). " (dd/mm/yyyy)";
		}
		?>
	  </td>
	</tr>
	<tr bgcolor=#FFFFFF>
	  <td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['519'].' *'; ?>
	  </td>
	  <td width="486">
		<?php print $title; ?>
	  </td>
	</tr>

	<tr bgcolor=#FFFFFF>
	  <td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['520'].' *'; ?>
	  </td>
	  <td width="486">
	  <?php print nl2br($content); ?>
	  </td>
	</tr>

	<tr bgcolor=#FFFFFF>
	  <td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['521'].' *'; ?>
	  </td>
	  <td width="486">
	  <?php
	  if ($suspended == 0) print $MSG['030'];
	  if ($suspended == 1) print $MSG['029'];
	  ?>
	  </td>
	</tr>

	<tr bgcolor=#FFFFFF>
	  <td width="204" VALIGN="top" ALIGN="right">&nbsp;
		
	  </td>
	  <td width="486">
	  <BR><BR>
	  <?php print $MSG['339']; ?>
	  <BR><BR>
		<input type="submit" name="action" VALUE=<?php print $MSG['030']; ?>>&nbsp;&nbsp;&nbsp;
		<input type="submit" name="action" VALUE=<?php print $MSG['029']; ?>>
		<INPUT type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
		<INPUT type="hidden" name="offset" value="<?php echo $_GET['offset']; ?>">
	  </td>
	</tr>
	</table>
	</td>
	</tr>
	</table></form>
</td>
</tr>
</table>
</body>
</html>