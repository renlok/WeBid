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

if (isset($_POST['action']) && $_POST['action'] == "update")
{
	if (empty($_POST['sizetype']))
	{
		$ERR = $ERR_047;
		$system->SETTINGS = $_POST;
	}
	elseif ($_POST['sizetype'] == 'fix' && (empty($_POST['width'] ) || empty($_POST['height'])))
	{
		$ERR = $ERR_047;
		$system->SETTINGS = $_POST;
	}
	elseif ($_POST['sizetype'] == 'fix' && (!ereg("^[0-9]+$",$_POST['width']) || !ereg("^[0-9]+$",$_POST['height'])))
	{
		$ERR = $MSG['_0020'];
		$system->SETTINGS = $_POST;
	}
	else
	{
		#// Update database
		$query = "UPDATE " . $DBPrefix . "bannerssettings
					  SET
					  sizetype='$_POST[sizetype]',
					  width=".intval($_POST['width']).",
					  height=".intval($_POST['height']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$ERR = $MSG['600'];
		$system->SETTINGS = $_POST;
	}
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "bannerssettings";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0)
	{
		$system->SETTINGS = mysql_fetch_array($res);
	}
}

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
		  <td width="30"><img src="images/i_ban.gif" ></td>
		  <td class=white><?php echo $MSG['25_0011']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['_0013']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD align="center">
	<BR>
	<FORM NAME=conf ACTION="" METHOD=POST>
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
			<TR>
				<TD ALIGN=CENTER class=title>
					<?php print $MSG['_0013']; ?>
					</B></TD>
			</TR>
			<TR>
				<TD>

				<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
				  <?php
				  if (!empty($ERR))
				  {
						?>
				  <TR>
					<TD class=error COLSPAN="2" ALIGN=CENTER BGCOLOR=yellow>
					  <?php echo $ERR; ?>
					 </TD>
				  </TR>
				  <?php
				  }
						?>
				  <TR VALIGN="TOP">
					<TD COLSPAN="2">
					  <?php print $MSG['_0014']; ?>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP" BGCOLOR="#dddddd">
					<TD WIDTH="73" HEIGHT="22">
					  <INPUT TYPE="radio" NAME="sizetype" VALUE="any"
								<?php if ($system->SETTINGS['sizetype'] == 'any') print " CHECKED";?>
								>
					  </TD>
					<TD HEIGHT="22" WIDTH="559">
					  <?php echo $MSG['_0015']; ?>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH="73" HEIGHT="22" BGCOLOR="#eeeeee">
					  <INPUT TYPE="radio" NAME="sizetype" VALUE="fix"
								<?php if ($system->SETTINGS['sizetype'] == 'fix') print " CHECKED";?>
								>
					  </TD>
					<TD HEIGHT="22" WIDTH="559" BGCOLOR="#eeeeee">
					  <?php echo $MSG['_0016']; ?>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH="73" HEIGHT="22" BGCOLOR="#eeeeee">
					  <?php echo $MSG['_0017']; ?>
					  </TD>
					<TD WIDTH="559" HEIGHT="22" BGCOLOR="#eeeeee">
					  <INPUT TYPE=text NAME=width VALUE="<?php echo $system->SETTINGS['width']; ?>">
					  <?php echo $MSG['5224']; ?>
					  </TD>
				  </TR>
				  <TR VALIGN="TOP">
					<TD WIDTH="73" HEIGHT="22" BGCOLOR="#eeeeee">
					  <?php echo $MSG['_0018']; ?>
					  </TD>
					<TD HEIGHT="22" WIDTH="559" BGCOLOR="#eeeeee">
					  <INPUT TYPE=text NAME=height VALUE="<?php echo $system->SETTINGS['height']; ?>">
					  <?php echo $MSG['5224']; ?>
					  </TD>
				  </TR>
				  <TR>
					<TD WIDTH="73">&nbsp; </TD>
					<TD WIDTH="559">
					  <INPUT TYPE="hidden" NAME="action" VALUE="update">
					  <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $id; ?>">
					  <INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['530']; ?>">
					</TD>
				  </TR>
				  <TR>
					<TD COLSPAN="2"> </TD>
				  </TR>
				</TABLE>
				</TD>
			</TR>
		</TABLE>
		</FORM>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>