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
unset($ERR);

#//
if(isset($_POST['action']) && $_POST['action'] == "update")
{
	#// Data check
	if($_POST['status'] == 'enabled' && (!is_numeric($_POST['timebefore']) || !is_numeric($_POST['extend'])))
	{
		$ERR = $MSG['2_0038'];
		$system->SETTINGS = $_POST;
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "auctionextension SET
				  status='".$_POST['status']."',
				  timebefore=".intval($_POST['timebefore']).",
				  extend=".intval($_POST['extend']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$ERR = $MSG['2_0039'];
		$system->SETTINGS = $_POST;
	}
}

$query = "SELECT * FROM " . $DBPrefix . "auctionextension";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if(mysql_num_rows($res) > 0)
{
	$system->SETTINGS = mysql_fetch_array($res);
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
          <td width="30"><img src="images/i_auc.gif" ></td>
          <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['2_0032']; ?></td>
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
	<form name="conf" action="" method="post">
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
			<TR>
				<TD ALIGN=CENTER class=title>
					<?php print $MSG['2_0032']; ?>
				</TD>
			</TR>
			<TR>
				<TD>

	<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
	  <?php
		if($ERR != "")
		{
		 ?>
	  <TR BGCOLOR=yellow>
		<TD COLSPAN="2" ALIGN=CENTER><B>
		  <?php print $ERR; ?>
		  </B></TD>
	  </TR>
	  <?php
			}
		?>
	  <TR VALIGN="TOP">
		<TD HEIGHT="7">&nbsp;</TD>
		<TD HEIGHT="7">
		  <?php echo $_CUSTOM_0032; ?>
		  </TD>
	  </TR>

	  <TR VALIGN="TOP">
		<TD COLSPAN="2" HEIGHT="7"><IMG SRC="../images/transparent.gif" WIDTH="1" HEIGHT="5"></TD>
	  </TR>
	  <TR VALIGN="TOP">
		<TD WIDTH=214 HEIGHT="31">
		  <?php echo $MSG['2_0034']; ?>
		  </TD>
		<TD HEIGHT="31" WIDTH="418">
		  <input type="radio" name="status" value="enabled" <?php if($system->SETTINGS['status'] == 'enabled') print " CHECKED";?>>
		  
		  <?php echo $MSG['030']; ?>
		  
		  <input type="radio" name="status" value="disabled" <?php if($system->SETTINGS['status'] == 'disabled') print " CHECKED";?>>
		  
		  <?php echo $MSG['029']; ?>
		   </TD>
	  </TR>
	  <TR VALIGN="TOP">
		<TD COLSPAN="2" HEIGHT="4"><IMG SRC="../images/transparent.gif" WIDTH="1" HEIGHT="5"></TD>
	  </TR>
	  <TR VALIGN="TOP">
		<TD WIDTH=214 HEIGHT="31">&nbsp;
		  </TD>
		<TD HEIGHT="31" WIDTH="418">
		  <?php echo $MSG['2_0035']; ?>
		   &nbsp;
		  <input type=text name=extend value="<?php echo $system->SETTINGS['extend']; ?>" size=5>
		  &nbsp; &nbsp;
		   
		  <?php echo $MSG['2_0036']; ?>
		   &nbsp;
		  <input type=text name=timebefore value="<?php echo $system->SETTINGS['timebefore']; ?>" size=5>
		  &nbsp; &nbsp;
		   
		  <?php echo $MSG['2_0037']; ?>
		   </TD>
	  </TR>
	  <TR VALIGN="TOP">
		<TD COLSPAN="2" HEIGHT="6"><IMG SRC="../images/transparent.gif" WIDTH="1" HEIGHT="5"></TD>
	  </TR>
	  <TR>
		<TD WIDTH=214>
		  <INPUT TYPE="hidden" NAME="action" VALUE="update">
		  <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $id; ?>">
		</TD>
		<TD WIDTH="418">
		  <INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['530']; ?>">
		</TD>
	  </TR>
	  <TR>
		<TD WIDTH=214></TD>
		<TD WIDTH="418"> </TD>
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
</TD>
</TR>
</TABLE>
</BODY>
</HTML>