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

if ($_POST['act'] == "insert" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])) {
	#// Additional security check
	$RR = mysql_query("SELECT id FROM " . $DBPrefix . "adminusers");
	if (mysql_num_rows($RR) > 0)	{
		print "Fatal error: user cannot be inserted - one or more administrators are already present in the database.<BR><A HREF=login.php>login page</A>";
		exit;
	}
	$md5_pass = md5($MD5_PREFIX.$_POST['password']);
	$query = "INSERT INTO " . $DBPrefix . "adminusers VALUES (NULL, '" . $_POST['username'] . "', '$md5_pass', '" . get_hash() . "', '" . gmdate("Ymd") . "', '" . time() . "', 1)";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	// Redirect
	header("Location: login.php");
	exit;
}
$query = "SELECT MAX(id) FROM " . $DBPrefix . "adminusers";
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_row($result)) {
	$id = $row[0] + 1;
}
?>
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="style.css" />
</HEAD>
<BODY>
<?php
if ($id==1) {
	$id=0;
?>
<TABLE BORDER=0 WIDTH=650 CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF" ALIGN="CENTER">
	<TR>
		<TD><CENTER><BR><BR>
			<FORM NAME=login ACTION=login.php METHOD=POST>
			<TABLE WIDTH="410" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#336699">
			<TR>
				<TD>
					<TABLE WIDTH=100% CELLPADDING=3 ALIGN="CENTER" CELLSPACING="0" BORDER="0" BGCOLOR="#FFFFFF">
					<TR BGCOLOR="#336699">
						<TD COLSPAN="2" ALIGN=CENTER>
							<FONT COLOR=white><B>:: Please create your username and password ::</B></FONT>
						</TD>
					</TR>
					<TR>
						<TD></TD>
						<TD> <FONT COLOR=red>
						<?php print $ERR; ?>
						</TD>
					</TR>
					<TR>
						<TD ALIGN=right> 
							<?php print $MSG['003']; ?>
						</TD>
						<TD>
							<INPUT TYPE=TEXT NAME=username SIZE=20 >
						</TD>
					</TR>
					<TR>
						<TD ALIGN=right> 
							<?php print $MSG['004']; ?>
						</TD>
						<TD>
							<INPUT TYPE=password NAME=password SIZE=20 >
						</TD>
					</TR>
					<TR>
						<TD></TD>
						<TD>
							<INPUT TYPE="submit" NAME="act"ion VALUE="insert">
						</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			</TABLE>
			</FORM>
			</CENTER>
		</TD>
	</TR>
	</TABLE>
<?php

} else {
	if (isset($_POST['action']) && $_POST['action'] == "login") {
		if (strlen($_POST['username']) == 0 || strlen($_POST['password']) == 0) {
			$ERR = $ERR_047;
		} elseif (!preg_match('([a-zA-Z0-9]*)', $_POST['username'])) {
			$ERR = $ERR_047_a;
		} else {
			$password = md5($MD5_PREFIX.$_POST['password']);
			$query = "SELECT id, hash FROM " . $DBPrefix . "adminusers WHERE username = '" . $_POST['username'] . "' and password = '" . $password . "'";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) == 0) {
				$ERR = $ERR_048;
			} else {
				$admin = mysql_fetch_array($res);
				// Set sessions vars
				$_SESSION['WEBID_ADMIN_NUMBER'] = strspn($password, $admin['hash']);
				$_SESSION['WEBID_ADMIN_PASS'] = $password;
				$_SESSION['WEBID_ADMIN_IN'] = $admin['id'];
				$_SESSION['WEBID_ADMIN_USER'] = $_POST['username'];
				// Update last login information for this user
				$query = "UPDATE " . $DBPrefix . "adminusers SET lastlogin = '" . time() . "' WHERE id = " . $admin['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				// Redirect
				print "<script type='text/javascript'>parent.location.href = 'index.php';</script>";
				exit;
			}
		}
	}
	
?>
<TABLE BORDER=0 WIDTH=650 CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF" ALIGN="CENTER">
<TR>
	<TD>
		<CENTER>
		<BR><BR>
<?php if (!$act || ($act && $ERR)) { ?>
		<FORM NAME=login ACTION=login.php METHOD=POST>
		<TABLE WIDTH="415" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#336699">
		<TR>
			<TD>
				<TABLE WIDTH=100% CELLPADDING=4 ALIGN="CENTER" CELLSPACING="0" BORDER="0" BGCOLOR="#FFFFFF">
				<TR BGCOLOR="#33CC33">
					<TD COLSPAN="2" ALIGN=CENTER>
						<B>:: PLEASE LOG IN WITH THE USERNAME & PASSWORD YOU CREATED ::</B>
					</TD>
				</TR>
				<TR>
					<TD></TD>
					<TD>
						<FONT COLOR=red><?php print $ERR; ?>
					</TD>
				</TR>
				<TR>
					<TD ALIGN=right> 
						<?php print $MSG['003']; ?>
					</TD>
					<TD>
						<INPUT TYPE=TEXT NAME=username SIZE=20 >
					</TD>
				</TR>
				<TR>
					<TD ALIGN=right>
						<?php print $MSG['004']; ?>
					</TD>
					<TD>
						<INPUT TYPE=password NAME=password SIZE=20 >
					</TD>
				</TR>
				<TR>
					<TD></TD>
					<TD>
						<INPUT TYPE="submit" NAME="action" VALUE="login">
					</TD>
				</TR>
				</TABLE>
			</TD>
		</TR>
		</TABLE>
		</FORM>
<?php  }  ?>
		
		</CENTER>
	</TD>
</TR>
</TABLE>
<?php  } 
require("./footer.php");  
?>