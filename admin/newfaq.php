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

unset($ERR);

// Insert new message
if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (strlen($_POST[question]) == 0 && strlen($_POST[answer]) == 0){
		$ERR = "Required fields missing (all fields are required).";
		$system->SETTINGS = $_POST;
	}else{
		$query = "INSERT into ".$DBPrefix."faqs values(NULL,
			   '".addslashes($_POST['question'][$system->SETTINGS['defaultlanguage']])."',
			   '".addslashes($_POST['answer'][$system->SETTINGS['defaultlanguage']])."',
			   $_POST[category])";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$id=mysql_insert_id();
		#// Insert into translation table.
		reset($LANGUAGES);
		foreach ($LANGUAGES as $k => $v){
			$query = "INSERT INTO ".$DBPrefix."faqs_translated VALUES(
					$id,
					'$k',
					'".addslashes($_POST['question'][$k])."',
					'".addslashes($_POST['answer'][$k])."')";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
		}
		header("Location: faqs.php");
		exit;
	}
} else {
	#// Get data from the database
	$query = "select * from ".$DBPrefix."faqscategories";
	$res_c = mysql_query($query);
	$system->check_mysql($res_c, $query, __LINE__, __FILE__);
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?=$MSG['25_0018']?>&nbsp;&gt;&gt;&nbsp;<?=$MSG['5231']?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle"><form name="faq" METHOD="post" ACTION="<?=basename($_SERVER['PHP_SELF'])?>">
	<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#0083D7">
		<tr align=center>
			<td bgcolor=#ffffff>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
					<tr>
						<td colspan="2" bgcolor="#0083D7" align=center class=title>
							<?=$MSG['5231']?>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td width="23%" CLASS=link height="27" VALIGN="top">
							<?=$MSG['5238']?> </td>
						<td width="77%" CLASS=link height="27">
						<SELECT name="category">
							<?php
							while ($row = mysql_fetch_array($res_c))
							{
								$row[category]=stripslashes($row[category]);
								print '<OPTION value="'.$row['id'].'"';
								if ($_POST[category] == $row[category]) print " SELECTED";
								print '>'.$row['category'].'</OPTION>'."\n";
							}
						?>
						</SELECT>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td width="23%" CLASS=link height="27" VALIGN="top">
						<?=$MSG['5239']?></td>
						<td width="77%" CLASS=link height="27">
							<IMG SRC="../includes/flags/<?=$system->SETTINGS['defaultlanguage']?>.gif">&nbsp;<input type="text" name="question[<?=$system->SETTINGS['defaultlanguage']?>]" SIZE="35" MAXLENGTH="200">
							<?php
								reset($LANGUAGES);
								foreach ($LANGUAGES as $k => $v){
									if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<input type=text NAME=question[$k] SIZE=35 MAXLENGTH=200>";
								}
							?>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td width="23%" CLASS=link height="27" VALIGN="top">
						<?=$MSG['5240']?></td>
						<td width="77%" CLASS=link height="27">
							<IMG SRC="../includes/flags/<?=$system->SETTINGS['defaultlanguage']?>.gif"><br><TEXTAREA name="answer[<?=$system->SETTINGS['defaultlanguage']?>]" COLS="40" ROWS="15"></TEXTAREA>
							<?php
								reset($LANGUAGES);
								foreach ($LANGUAGES as $k => $v){
									if ($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif><br><TEXTAREA NAME=answer[$k] COLS=40 ROWS=15></TEXTAREA>";
								}
							?>
						</td>
					</tr>
					<tr>
						<td width="23%" bgcolor="#FFFFFF">
							<input type="hidden" name="action" value="update">
						</td>
						<td width="77%" bgcolor="#FFFFFF">
							<input type="submit" name="Submit" value="INSERT FAQ">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</td>
</tr>
</table>
</body>
</html>