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
$TIME = $system->ctime;

if (isset($_POST['action']))
{
	// Data check
	if (!isset($_POST['title']) || !isset($_POST['content']))
	{
		$ERR = 'ERR_112';
	}
	else
	{
		$query = "INSERT INTO " . $DBPrefix . "news VALUES (NULL, '".$system->cleanvars($_POST['title'][$system->SETTINGS['defaultlanguage']])."','".$system->cleanvars($_POST['content'][$system->SETTINGS['defaultlanguage']])."',".time().",".intval($_POST['suspended']).")";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$_POST['id'] = mysql_insert_id();
		// Insert into translation table.
		reset($LANGUAGES);
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (
					".$_POST['id'].", '$k', '".$system->cleanvars($_POST['title'][$k])."', '".$system->cleanvars($_POST['content'][$k])."')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		header("Location: news.php");
		exit;
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
		<form NAME=addnew action="" METHOD="POST">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
		<td>
			<table width=100% cellpadding=4 cellspacing=0 border=0>
			<tr>
	 		<td align="center" COLSPAN=2 class=title>
				<B><?php print $MSG['518']; ?></B>
				<BR>
	 		</td>
			</tr>
			<?php
			if ($ERR || $updated){
			print "<tr><td>&nbsp;</td><td width=486>";
			if ($$ERR) print $$ERR;
			if ($updated) print "Auction data updated";
			print "</td></tr>";
			}
			?>
			<tr bgcolor=#FFFFFF valign=top>
	  		<td width="204" VALIGN="top" ALIGN="right">
			<?php print $MSG['519'].' *'; ?>
	  		</td>
	  		<td width="486">
			<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif">&nbsp;<input type=text NAME=title[<?php echo $system->SETTINGS['defaultlanguage']; ?>] SIZE=40 MAXLENGTH=255 value="<?php print $_POST['title']; ?>">
			<?php
				reset($LANGUAGES);
				foreach ($LANGUAGES as $k => $v)
				{
					if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<input type=text NAME=title[$k] SIZE=40 MAXLENGTH=255 VALUE=>";
				}
			?>
	  		</td>
			</tr>

			<tr bgcolor=#FFFFFF>
	  		<td width="204" VALIGN="top" ALIGN="right">
			<?php print $MSG['520'].' *'; ?>
	  		</td>
	  		<td width="486">
			<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif"><br>
			<TEXTAREA NAME=content[<?php echo $system->SETTINGS['defaultlanguage']; ?>] COLS=45 ROWS=20></TEXTAREA>
			<?php
				reset($LANGUAGES);
				foreach ($LANGUAGES as $k => $v)
				{
					if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif><br><TEXTAREA NAME=content[$k] COLS=45 ROWS=20></TEXTAREA>";
				}
			?>
	  		</td>
			</tr>

			<tr bgcolor=#FFFFFF>
	  		<td width="204" VALIGN="top" ALIGN="right">
			<?php print $MSG['521'].' *'; ?>
	  		</td>
	  		<td width="486">
			<input type=radio NAME=suspended value=0
			<?php
			if ($_POST['suspended'] == 0) print " CHECKED";
			?>
			>
			<?php print $MSG['030']; ?>
			<input type=radio NAME=suspended value=1
			<?php
			if ($_POST['suspended'] == 1) print " CHECKED";
			?>
			> <?php print $MSG['029']; ?>
	  		</td>
			</tr>

			<tr bgcolor=#FFFFFF>
	  		<td width="204" VALIGN="top" ALIGN="right">&nbsp;
		
			  </td>
	  		<td width="486">
			<input type="submit" value="<?php echo $MSG['518']; ?>">
	  		</td>
			</tr>
		</table>
		<INPUT type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
		<INPUT type="hidden" name="offset" value="<?php echo $_GET['offset']; ?>">
		<INPUT type="hidden" name="action" value="addnew">

		</td>
		</tr>
		</table>	
		</form>
</td>
</tr>
</table>
</body>
</html>