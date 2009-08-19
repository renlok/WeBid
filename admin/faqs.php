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

if (is_array($_POST['delete']) && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])) {
	foreach ($_POST['delete'] as $k => $v) {
		#//
		$query = "delete from " . $DBPrefix . "faqs WHERE id=$k";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		@mysql_query("DELETE FROM " . $DBPrefix . "faqs_translated WHERE id=$k");
	}
}

#// Insert new message
if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (strlen($_POST['name']) == 0) {
		$ERR = "Site's name cannot be an empty string";
		$system->SETTINGS = $_POST;
	} else {
		$query = "UPDATE " . $DBPrefix . "settings set title='".addslashes($_POST['title'])."',
												   name = '".addslashes($_POST['name'])."'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$MSG = "Database updated";
		$_SESSION['MSG']=$MSG;
		header('location: index.php');
		exit;
	}
}

#// Get data from the database
$query = "select * from " . $DBPrefix . "faqscategories";
$res_c = mysql_query($query);
$system->check_mysql($res_c, $query, __LINE__, __FILE__);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">
function selectDelete(formObj, isInverse)  {
   for (var i=0;i < formObj.length;i++)  {
	  fldObj = formObj.elements[i];
	  if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete') { 
		 if (isInverse)
			fldObj.checked = (fldObj.checked) ? false : true;
		 else fldObj.checked = true; 
	   }
   }
}
</SCRIPT>
</head>
<body style="margin:0;">
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
	  <td bgcolor="#ffffff">&nbsp;</td>
	</tr>
	<tr>
	  <td><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
		  <tr>
			<td colspan="2" bgcolor="#0083D7" align=center class=title>
				<?php echo $MSG['5229']; ?>
			 </td>
		  </tr>
		  <tr bgcolor="#FFFFFF">
			<td width="86%">&nbsp;</td>
			<td align=center width="14%"><input type="submit" name="Submit2" value="Delete">
			</td>
		  </tr>
		  <?php
		  while ($cat = mysql_fetch_array($res_c)) {
		  	$cat['category']	=	stripslashes($cat['category']);
					?>
		  <tr bgcolor="#eeeeee">
			<td colspan="2"><B> 
			  <?php echo $cat['category']; ?>
			  </B> </B> </td>
		  </tr>
		  <?php
		  $query = "select * from " . $DBPrefix . "faqs WHERE category=".$cat['id'];
		  $res = mysql_query($query);
		  $system->check_mysql($res, $query, __LINE__, __FILE__);

		  while ($faq = mysql_fetch_array($res)) {
		  	$faq['question']=	stripslashes($faq['question']);
							?>
		  <tr bgcolor="#eeeeee">
			<td width="86%" bgcolor="#FFFFFF"><A HREF=editfaq.php?id=<?php echo $faq['id']; ?>> 
			  <?php echo $faq['question']; ?>
			   </A> </td>
			<td width="14%" bgcolor="#FFFFFF" align="center"><input type="checkbox" name="delete[<?php echo $faq['id']; ?>]" value="<?php echo $faq['id']; ?>">
			</td>
		  </tr>
		  <?php
		  }
		  }
		?>
		<tr bgcolor=#FFFFFF>
			<td colspan=1>&nbsp;</td>
			<td align=center><a href="javascript: void(0)" onClick="selectDelete(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A></td>
		</tr>
		  <tr bgcolor="#eeeeee">
			<td bgcolor="#FFFFFF" width="86%">&nbsp;</td>
			<td width="14%" bgcolor="#FFFFFF" align="center"><input type="submit" name="Submit" value="Delete">
			</td>
		  </tr>
		</table></td>
	</tr>
  </table>
</td>
</tr>
</table>
</form>
</body>