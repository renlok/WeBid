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
$TIME = $system->ctime;

if (!isset($_POST['id']) && (!isset($_GET['id']) || empty($_GET['id']))) {
	header('location: news.php');
	exit;
}

if (isset($_POST['action'])) {
	//-- Data check
	if (!$_POST['title'] || !$_POST['content']) {
		$ERR = "ERR_112";
	} else {		
		$query = "UPDATE " . $DBPrefix . "news SET title='".addslashes($_POST['title'][$system->SETTINGS['defaultlanguage']])."',content='".addslashes($_POST['content'][$system->SETTINGS['defaultlanguage']])."',suspended=".intval($_POST['suspended'])." WHERE id='".$_POST['id']."'";
		$res = mysql_query($query);
		if (!$res) {
			$ERR = "ERR_001";
		}
		reset($LANGUAGES);
		while (list($k,$v) = each($LANGUAGES)){
			$tr = @mysql_result(@mysql_query("SELECT title FROM " . $DBPrefix . "news_translated WHERE lang='".$k."' AND id = ".$_POST['id']), 0, "title"); 
			if (!empty($tr)) {
				$query = "UPDATE " . $DBPrefix . "news_translated SET 
						title = '".addslashes($_POST['title'][$k])."',
						content = '".addslashes($_POST['content'][$k])."'
						WHERE id = '".$_POST['id']."' AND lang = '$k'";
			} else {
				$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (
						".$_POST['id'].", '$k', '".addslashes($_POST['title'][$k])."', '".addslashes($_POST['content'][$k])."')";
			}
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			unset($tr);
		}	
		header("Location: news.php");
		exit;
	}
} else {
	//--
	$query = "SELECT t.*, n.suspended FROM " . $DBPrefix . "news_translated t
			LEFT JOIN " . $DBPrefix . "news n ON (n.id = t.id) WHERE t.id = '".$_GET['id']."'";
	$res = mysql_query($query);
	if (!$res)
	{
		print $ERR_001;
		exit;
	}
	else
	{
		$CONT_tr = array();
		$TIT_tr = array();
		while ($arr = mysql_fetch_assoc($res)) {
			$CONT_tr[$arr['lang']] = $arr['content'];
			$TIT_tr[$arr['lang']] = $arr['title'];
			$suspended = $arr['suspended'];
		}
	}
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
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
<TITLE></TITLE>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
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
	
	<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
	<tr>
	 <td align="center" class=title><?php print $MSG['343']; ?>
	 </td>
	</tr>
	<tr>
	<td><form NAME=addnew ACTION="<?php print basename($_SERVER['PHP_SELF']); ?>" METHOD="POST">
		<table width="100%" border="0" cellpadding="5" cellspacing=1 bgcolor="#FFFFFF">

		<?php
		if ($ERR || $updated){
		print "<tr><td></td><td width=486>";
		if ($$ERR) print $$ERR;
		if ($updated) print "Auction data updated";
		print "</td>
						</tr>";
		}
		?>
		<tr>
	  	<td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['519'].' *'; ?>
	  	</td>
	  	<td width="486">
		<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif">&nbsp;<input type=text NAME=title[<?php echo $system->SETTINGS['defaultlanguage']; ?>] SIZE=40 MAXLENGTH=255 value="<?php echo stripslashes($TIT_tr[$system->SETTINGS['defaultlanguage']]); ?>">
		<?php
			reset($LANGUAGES);
			while (list($k,$v) = each($LANGUAGES)){
				if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<input type=text NAME=title[$k] SIZE=40 MAXLENGTH=255 VALUE=\"".stripslashes($TIT_tr[$k])."\">";
			}
		?>
	  	</td>
		</tr>

		<tr>
	  	<td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['520'].' *'; ?>
		  </td>
	  	<td width="486">
		<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif"><br>
		<TEXTAREA NAME=content[<?php echo $system->SETTINGS['defaultlanguage']; ?>] COLS=45 ROWS=20><?php echo stripslashes($CONT_tr[$system->SETTINGS['defaultlanguage']]); ?></TEXTAREA>
		<?php
			reset($LANGUAGES);
			while (list($k,$v) = each($LANGUAGES)){
				if ($k!=$system->SETTINGS['defaultlanguage']) print "<br><IMG SRC=../includes/flags/".$k.".gif><br><TEXTAREA NAME=content[$k] COLS=45 ROWS=20>".stripslashes($CONT_tr[$k])."</TEXTAREA>";
			}
		?>
	  	</td>
		</tr>

		<tr>
	  	<td width="204" VALIGN="top" ALIGN="right">
		<?php print $MSG['521'].' *'; ?>
	  	</td>
	  	<td width="486">
		<input type=radio NAME=suspended value=0
		<?php
		if ($suspended == 0) print " CHECKED";
		?>
		>
		<?php print $MSG['030']; ?>
		<input type=radio NAME=suspended value=1
		<?php
		if ($suspended == 1) print " CHECKED";
		?>
		> <?php print $MSG['029']; ?>
	  	</td>
		</tr>

		<tr>
	  	<td width="204" VALIGt">&nbsp;
		</td>
	  	<td width="486">
		<input type=submit value="<?php echo $MSG['530']; ?>">
	  	</td>
		<tr>
		<td colspan="2">
		<INPUT type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
		<INPUT type="hidden" name="offset" value="<?php echo $_GET['offset']; ?>">
		<INPUT type="hidden" name="action" value="addnew"></td></tr>
		</table>
		</form>
		</td>
		</tr>
		</table>
		
</td>
</tr>
</table>
</body>
</html>