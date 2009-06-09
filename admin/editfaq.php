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

#//Default for error message (blank)
$ERR = "&nbsp;";

#// Update message
if ($_POST[action] == "update" && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))){
  if (strlen($_POST[question]) == 0 && strlen($_POST[answer]) == 0){
	$ERR = $ERR_067;
	$faq = $_POST;
  }else{
	$query = "UPDATE " . $DBPrefix . "faqs SET category=$_POST[category],
		   question='".addslashes($_POST['question'][$system->SETTINGS['defaultlanguage']])."',
		   answer='".addslashes($_POST['answer'][$system->SETTINGS['defaultlanguage']])."'
		   WHERE id='".$_POST['id']."'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	  reset($LANGUAGES);
	  foreach ($LANGUAGES as $k => $v)
	  {
		$tr=@mysql_result(@mysql_query("SELECT question FROM " . $DBPrefix . "faqs_translated WHERE lang='".$k."' AND id=".$_POST['id']),0,"question"); 
		if ($tr){
		  $query = "UPDATE " . $DBPrefix . "faqs_translated SET 
			  question='".addslashes($_POST['question'][$k])."',
			  answer='".addslashes($_POST['answer'][$k])."'
			  WHERE id='".$_POST['id']."' AND
			  lang='$k'";
		}else{
		  $query = "INSERT INTO " . $DBPrefix . "faqs_translated VALUES(
			  '".$_POST['id']."',
			  '$k',
			  '".addslashes($_POST['question'][$k])."',
			  '".addslashes($_POST['answer'][$k])."')";
		}
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		unset($tr);
	  }  
	  header("Location: faqs.php");
	  exit;
  }
}

if ($_POST[action] != "update")
{
  #// Get data from the database
  $query = "SELECT * FROM " . $DBPrefix . "faqs WHERE id='".$_GET['id']."'";
  $res = mysql_query($query);
  $system->check_mysql($res, $query, __LINE__, __FILE__);
  $faq = mysql_fetch_array($res);
  
  #//
  $query = "SELECT * FROM " . $DBPrefix . "faqscategories ORDER BY category";
  $res_c = mysql_query($query);
  $system->check_mysql($res_c, $query, __LINE__, __FILE__);
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="faq" METHOD="post" action="">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5232']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
  <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#0083D7">
	<tr align=center>
	  <td bgcolor="#ffffff">&nbsp;
	  
	  </td>
	</tr>
	<tr>
	  <td>
		<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
		  <tr>
			<td colspan="2" bgcolor="#0083D7" align=center class=title>
				<?php echo $MSG['5241']; ?>
			</td>
		  </tr>
		  <tr bgcolor="#FFFFFF">
			<td width="23%" CLASS=link height="27" VALIGN="top">
			  <?php echo $MSG['5238']; ?>
			  </td>
			<td width="77%" CLASS=link height="27">
			  <SELECT name="category">
				<?php
				while ($row = mysql_fetch_array($res_c))
				{
				  $row[category]=stripslashes($row[category]);
				  print "<OPTION VALUE=\"$row[id]\"";
				  if ($faq[category] == $row[id]) print " SELECTED";
				  print ">$row[category]</OPTION>\n";
				}
				$res_tr = @mysql_query("SELECT * FROM " . $DBPrefix . "faqs_translated WHERE id='".$_GET['id']."'");
				while ($tr=mysql_fetch_array($res_tr)){
				  $QUESTION_tr[$tr['lang']] = $tr['question'];
				  $ANSWER_tr[$tr['lang']] = $tr['answer'];
				}
			  ?>
			  </SELECT>
			  </td>
		  </tr>
		  <tr bgcolor="#FFFFFF" valign=top>
			<td width="23%" CLASS=link height="27" VALIGN="top"><?php echo $MSG['5239']; ?></td>
			<td width="77%" CLASS=link height="27">
			  <IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif">&nbsp;<input type="text" name="question[<?php echo $system->SETTINGS['defaultlanguage']; ?>]" SIZE="35" MAXLENGTH="200" value="<?php echo stripslashes($QUESTION_tr[$system->SETTINGS['defaultlanguage']]); ?>">
			  <?php
				reset($LANGUAGES);
				foreach ($LANGUAGES as $k => $v){
				  if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<input type=text NAME=question[$k] SIZE=35 MAXLENGTH=200 VALUE=\"".stripslashes($QUESTION_tr[$k])."\">";
				}
			  ?>
			</td>
		  </tr>
		  <tr bgcolor="#FFFFFF">
			<td width="23%" CLASS=link height="27" VALIGN="top"><?php echo $MSG['5240']; ?></td>
			<td width="77%" CLASS=link height="27">
			  <IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif"><br><TEXTAREA name="answer[<?php echo $system->SETTINGS['defaultlanguage']; ?>]" COLS="40" ROWS="15"><?php echo stripslashes($ANSWER_tr[$system->SETTINGS['defaultlanguage']]); ?></TEXTAREA>
			  <?php
				reset($LANGUAGES);
				foreach ($LANGUAGES as $k => $v){
				  if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif><br><TEXTAREA NAME=answer[$k] COLS=40 ROWS=15>".stripslashes($ANSWER_tr[$k])."</TEXTAREA>";
				}
			  ?>
			</td>
		  </tr>
		  <tr>
			<td width="23%" bgcolor="#FFFFFF">
			  <input type="hidden" name="action" value="update">
			  <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
			</td>
			<td width="77%" bgcolor="#FFFFFF">
			  <input type="submit" name="Submit" value="SAVE CHANGES">
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</td>
</tr>
</table>
</form>
</body>
</html>