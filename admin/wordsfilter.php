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

require('../includes/config.inc.php');
include "loggedin.inc.php";

unset($ERR);

if(isset($_POST['action']) && $_POST['action'] == "update")
{
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET wordsfilter='".str_replace("\n\n","\n",$_POST['wordsfilter'])."'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	mysql_query("DELETE FROM " . $DBPrefix . "filterwords");
	
	$TMP = explode("\n",$_POST['filtervalues']);
	if(is_array($TMP)) {
		while(list($k,$v) = each($TMP)) {
			$query = "INSERT INTO " . $DBPrefix . "filterwords VALUES('".chop($v)."')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	$ERR = $MSG['5073'];
	$system->SETTINGS = $_POST;
}

$query = "SELECT wordsfilter FROM " . $DBPrefix . "settings";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if(mysql_num_rows($res) > 0) {
	$system->SETTINGS = mysql_fetch_array($res);
}
$query = "SELECT * FROM " . $DBPrefix . "filterwords";
$r_f = mysql_query($query);
$system->check_mysql($r_f, $query, __LINE__, __FILE__);
while($word = mysql_fetch_array($r_f)) {
	$WORDSLIST .= $word['word']."\n";
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
          <td width="30"><img src="images/i_too.gif" ></td>
          <td class=white><?php echo $MSG['5436']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5068']; ?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
<TABLE BORDER=0 WIDTH=95% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD>
<CENTER>
<BR>
<form name="conf" action="" method="post">
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
		<TR>
			<TD ALIGN=CENTER class=title>
				<?php print $MSG['5068']; ?>
			</TD>
		</TR>
		<TR>
			<TD>

<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
  <?php
  if(isset($ERR))
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
	<TD WIDTH=109>&nbsp;</TD>
	<TD WIDTH="375">
	  <?php print $MSG['5069']; ?>
	  </TD>
  </TR>
  <TR VALIGN="TOP">
	<TD WIDTH=109 HEIGHT="22">
	  <?php print $MSG['5070']; ?>
	  </TD>
	<TD WIDTH="375" HEIGHT="22">
	  <INPUT TYPE="radio" NAME="wordsfilter" VALUE="y" <?php if($system->SETTINGS['wordsfilter'] == "y") print " CHECKED"?>>
	  <?php print $MSG['030']; ?>
	  <INPUT TYPE="radio" NAME="wordsfilter" VALUE="n" <?php if($system->SETTINGS['wordsfilter'] == "n") print " CHECKED"?>>
	  <?php print $MSG['029']; ?>
	  </TD>
  </TR>
  <TR VALIGN="TOP">
	<TD WIDTH=109 HEIGHT="22">
	  <?php print $MSG['5071']; ?>
	  </TD>
	<TD WIDTH="375" HEIGHT="22">
	  <?php echo $MSG['5072']; ?><BR>
	  <textarea name="filtervalues" cols="45" rows="15"><?php echo $WORDSLIST; ?></textarea>
	  </TD>
  </TR>
  <TR VALIGN="TOP">
	<TD WIDTH=109 HEIGHT="22">&nbsp;</TD>
	<TD WIDTH="375" HEIGHT="22">&nbsp;</TD>
  </TR>
  <TR>
	<TD WIDTH=109>
	  <INPUT TYPE="hidden" NAME="action" VALUE="update">
	</TD>
	<TD WIDTH="375">
	  <INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['530']; ?>">
	</TD>
  </TR>
  <TR>
	<TD WIDTH=109></TD>
	<TD WIDTH="375"> </TD>
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
