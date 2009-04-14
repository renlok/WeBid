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
include "../includes/common.inc.php";
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $include_path."countries.inc.php";

$username = $name;
//-- Data check

if (!isset($_REQUEST['id'])) {
	header("Location: listusers.php");
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'Delete') {
	if ($_POST['mode'] == "activate") {
		$sql = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = '".$_POST['idhidden']."'";
		$counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET inactiveusers=(inactiveusers-1), users=(users+1)");
		$query = "SELECT name, email FROM " . $DBPrefix . "users WHERE id = '".$_POST['idhidden']."'";
		$result = mysql_query($query);
		$USER = mysql_fetch_assoc($result);
		include $include_path . "user_approved.inc.php";
	} else {
		$sql = "UPDATE " . $DBPrefix . "users SET suspended = 1 WHERE id = '".$_POST['idhidden']."'";
		$counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers + 1, users = users - 1");
	}
	$res = mysql_query($sql);
	
	header("Location: listusers.php");
	exit;
}

if (!isset($_POST['action']) && isset($_GET['id'])) {
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . intval($_GET['id']);
	$result = mysql_query($query);
	if (!$result){
		print "Database access error: abnormal termination".mysql_error();
		exit;
	}

	$username = mysql_result($result,0,"name");
	$nick = mysql_result($result,0,"nick");
	$password = mysql_result($result,0,"password");
	$email = mysql_result($result,0,"email");
	$address = mysql_result($result,0,"address");
	$country = mysql_result($result,0,"country");
	$country_list = '';
	while (list ($code, $descr) = each ($countries)) {
		$country_list .= '<option value="' . $descr . '"';
		if ($descr == $country) {
			$country_list .= ' selected';
		}
		$country_list .= '>' . $descr . '</option>'."\n";
	}
	
	$prov = mysql_result($result,0,"prov");
	$zip = mysql_result($result,0,"zip");
	$birthdate = mysql_result($result,0,"birthdate");
	$birth_day = substr($birthdate,6,2);
	$birth_month = substr($birthdate,4,2);
	$birth_year = substr($birthdate,0,4);
	$birthdate = "$birth_day/$birth_month/$birth_year";
	$phone = mysql_result($result,0,"phone");
	$suspended = mysql_result($result,0,"suspended");
	$rate_num = mysql_result($result,0,"rate_num");
	$rate_sum = mysql_result($result,0,"rate_sum");
	if ($rate_num) {
		$rate = round($rate_sum / $rate_num);
	} else {
		$rate = 0;
	}
}
?>
<HTML> 
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<STYLE TYPE="text/css">
body {
scrollbar-face-color: #aaaaaa;
scrollbar-shadow-color: #666666;
scrollbar-highlight-color: #aaaaaa;
scrollbar-3dlight-color: #dddddd;
scrollbar-darkshadow-color: #444444;
scrollbar-track-color: #cccccc;
scrollbar-arrow-color: #ffffff;
}</STYLE>
</HEAD>
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
<BR>
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="CENTER">
		<tr>
		  <td align=CENTER class=title>
			<?php
			if ($suspended > 0) {
				print $MSG['306'];
			} else {
				print $MSG['305'];
			}
		?>
			</b></td>
		</tr>
		<tr>
		  <td bgcolor="#FFFFFF">
				<table width=100% celpadding=4 cellspacing=0 border=0 bgcolor="#FFFFFF">
					
					  <?php
					  if ($updated){
						  print "<TR><TD></TD><TD WIDTH=486>";
						  if ($updated) print "Users data updated";
						  print "</TD>
					</TR>";
					  }
?>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['302']; ?> </td>
						<td width="486"><?print $username; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['003']; ?> </td>
						<td width="486"><?php print $nick; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['004']; ?> </td>
						<td width="486"><?php print $password; ?> </td>
					  </tr>
					  <tr>
						<td width="204"  valign="top" align="right"><?php print $MSG['303']; ?> </td>
						<td width="486"><?php print $email; ?> </td>
					  </tr>
					  <tr>
						<td width="204"  valign="top" align="right"><?php print $MSG['252']; ?> </td>
						<td width="486"><?php print $birthdate; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['009']; ?> </td>
						<td width="486"><?php print $address; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['014']; ?> </td>
						<td width="486"><?php print $country; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['012']; ?> </td>
						<td width="486"><?php print $zip; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['013']; ?> </td>
						<td width="486"><?php print $phone; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['222']; ?> </td>
						<td width="486"><?php if (!$rate) $rate=0; ?>
						  <img src="../images/estrella_<?php echo $rate; ?>.gif"> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right">
						  <?php
						  if ($suspended > 0) {
							  print $MSG['310'];
						  } else {
							  print $MSG['300'];
						  }
						  ?>
						</td>
						<td width="486">
						<?php
						  if ($suspended == 0)
						  print $MSG['029'];
						  else
						  print $MSG['030'];
						?>
						</td>
					  </tr>
					  <tr>
						<td width="204">&nbsp;</td>
						<td width="486">
						  <?php
						  if ($suspended > 0) {
							  print $MSG['309'];
							  $mode = "activate";
						  } else {
							  print $MSG['308'];
							  $mode = "suspend";
						  }
						  ?>
						</td>
					  </tr>
					  <tr>
						<td width="204">&nbsp;</td>
						<td width="486"><form name=details action="excludeuser.php" method="POST">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
							<input type="hidden" name="offset" value="<?php echo $_GET['offset']; ?>">
							<input type="hidden" name="action" value="Delete">
							<input type="hidden" name="idhidden" value="<?php echo $_GET['id']; ?>">
							<input type="hidden" name="mode" value="<?php print $mode; ?>">
							<input TYPE="submit" NAME="act" value="<?php print $MSG['030']; ?>">
						  </form></td>
					  </tr>
					</table>
				 
				  
		</td>
		</tr>
	  </table>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>