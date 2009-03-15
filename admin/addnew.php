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

include "../includes/config.inc.php";
include "loggedin.inc.php";
include $include_path."messages.inc.php";
include $include_path."countries.inc.php";
$TIME = $system->ctime;

if(isset($_POST['action']))
{
	//-- Data check
	if(!isset($_POST['title']) || !isset($_POST['content'])) {
		$ERR = "ERR_112";
	} else {		
		$query = "INSERT INTO " . $DBPrefix . "news VALUES (NULL, '".$system->cleanvars($_POST['title'][$system->SETTINGS['defaultlanguage']])."','".$system->cleanvars($_POST['content'][$system->SETTINGS['defaultlanguage']])."',".time().",".intval($_POST['suspended']).")";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$_POST['id'] = mysql_insert_id();
		#// Insert into translation table.
		reset($LANGUAGES);
		while(list($k,$v) = each($LANGUAGES)){
			$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (
					".$_POST['id'].", '$k', '".$system->cleanvars($_POST['title'][$k])."', '".$system->cleanvars($_POST['content'][$k])."')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		header("Location: news.php");
		exit;
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
    <td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_con.gif" ></td>
          <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['516']; ?></td>
        </tr>
      	</table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
		<FORM NAME=addnew ACTION="" METHOD="POST">
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
		<TR>
		<TD>
			<TABLE WIDTH=100% CELLPADDING=4 CELLSPACING=0 BORDER=0>
			<TR>
	 		<TD ALIGN=CENTER COLSPAN=2 class=title>
				<B><?php print $MSG['518']; ?></B>
				<BR>
	 		</TD>
			</TR>
			<?php
			if($ERR || $updated){
			print "<TR><TD>&nbsp;</TD><TD WIDTH=486>";
			if($$ERR) print $$ERR;
			if($updated) print "Auction data updated";
			print "</TD></TR>";
			}
			?>
			<TR BGCOLOR=#FFFFFF valign=top>
	  		<TD WIDTH="204" VALIGN="top" ALIGN="right">
			<?php print $MSG['519'].' *'; ?>
	  		</TD>
	  		<TD WIDTH="486">
			<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif">&nbsp;<INPUT TYPE=text NAME=title[<?php echo $system->SETTINGS['defaultlanguage']; ?>] SIZE=40 MAXLENGTH=255 VALUE="<?php print $_POST['title']; ?>">
			<?php
				reset($LANGUAGES);
				while(list($k,$v) = each($LANGUAGES)){
					if($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<INPUT TYPE=text NAME=title[$k] SIZE=40 MAXLENGTH=255 VALUE=>";
				}
			?>
	  		</TD>
			</TR>

			<TR BGCOLOR=#FFFFFF>
	  		<TD WIDTH="204" VALIGN="top" ALIGN="right">
			<?php print $MSG['520'].' *'; ?>
	  		</TD>
	  		<TD WIDTH="486">
			<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif"><br>
			<TEXTAREA NAME=content[<?php echo $system->SETTINGS['defaultlanguage']; ?>] COLS=45 ROWS=20></TEXTAREA>
			<?php
				reset($LANGUAGES);
				while(list($k,$v) = each($LANGUAGES)){
					if($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif><br><TEXTAREA NAME=content[$k] COLS=45 ROWS=20></TEXTAREA>";
				}
			?>
	  		</TD>
			</TR>

			<TR BGCOLOR=#FFFFFF>
	  		<TD WIDTH="204" VALIGN="top" ALIGN="right">
			<?php print $MSG['521'].' *'; ?>
	  		</TD>
	  		<TD WIDTH="486">
			<INPUT TYPE=radio NAME=suspended value=0
			<?php
			if($_POST['suspended'] == 0) print " CHECKED";
			?>
			>
			<?php print $MSG['030']; ?>
			<INPUT TYPE=radio NAME=suspended value=1
			<?php
			if($_POST['suspended'] == 1) print " CHECKED";
			?>
			> <?php print $MSG['029']; ?>
	  		</TD>
			</TR>

			<TR BGCOLOR=#FFFFFF>
	  		<TD WIDTH="204" VALIGN="top" ALIGN="right">&nbsp;
		
			  </TD>
	  		<TD WIDTH="486">
			<INPUT TYPE="submit" VALUE="<?php echo $MSG['518']; ?>">
	  		</TD>
			</TR>
		</TABLE>
		<INPUT type="hidden" NAME="id" VALUE="<?php echo $_GET['id']; ?>">
		<INPUT type="hidden" NAME="offset" VALUE="<?php echo $_GET['offset']; ?>">
		<INPUT type="hidden" NAME="action" VALUE="addnew">

		</TD>
		</TR>
		</TABLE>	
		</FORM>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>