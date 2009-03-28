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

#//Default for error message (blank)
$ERR = "&nbsp;";

if(is_array($_POST['delete']) && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])) {
	while(list($k,$v) = each($_POST['delete'])) {
		#//
		$query = "delete from " . $DBPrefix . "faqs WHERE id=$k";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		@mysql_query("DELETE FROM " . $DBPrefix . "faqs_translated WHERE id=$k");
	}
}

#// Insert new message
if(isset($_POST['action']) && $_POST['action'] == "update") {
	if(strlen($_POST['name']) == 0) {
		$ERR = "Site's name cannot be an empty string";
		$system->SETTINGS = $_POST;
	} else {
		$query = "UPDATE " . $DBPrefix . "settings set title='".addslashes($_POST['title'])."',
											       name = '".addslashes($_POST['name'])."'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$MSG = "Database updated";
		$_SESSION['MSG']=$MSG;
		header("Location: index.php");
		exit;
	}
}

#// Get data from the database
$query = "select * from " . $DBPrefix . "faqscategories";
$res_c = mysql_query($query);
$system->check_mysql($res_c, $query, __LINE__, __FILE__);

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT type="text/javascript">
function selectDelete(formObj, isInverse)  {
   for (var i=0;i < formObj.length;i++)  {
      fldObj = formObj.elements[i];
      if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete') { 
         if(isInverse)
            fldObj.checked = (fldObj.checked) ? false : true;
         else fldObj.checked = true; 
       }
   }
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM NAME="faq" METHOD="post" ACTION="">
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
  <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" BGCOLOR="#0083D7">
    <TR align=center>
      <TD BGCOLOR="#ffffff">&nbsp;</TD>
    </TR>
    <TR>
      <TD><TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="4" ALIGN="CENTER">
          <TR>
            <TD COLSPAN="2" BGCOLOR="#0083D7" align=center class=title>
                <?php echo $MSG['5229']; ?>
             </TD>
          </TR>
          <TR BGCOLOR="#FFFFFF">
            <TD WIDTH="86%">&nbsp;</TD>
            <TD align=center WIDTH="14%"><INPUT TYPE="submit" NAME="Submit2" VALUE="Delete">
            </TD>
          </TR>
          <?php
          while($cat = mysql_fetch_array($res_c)) {
          	$cat['category']	=	stripslashes($cat['category']);
					?>
          <TR BGCOLOR="#eeeeee">
            <TD COLSPAN="2"><B> 
              <?php echo $cat['category']; ?>
              </B> </B> </TD>
          </TR>
          <?php
          $query = "select * from " . $DBPrefix . "faqs WHERE category=".$cat['id'];
          $res = mysql_query($query);
          $system->check_mysql($res, $query, __LINE__, __FILE__);

          while($faq = mysql_fetch_array($res)) {
          	$faq['question']=	stripslashes($faq['question']);
							?>
          <TR BGCOLOR="#eeeeee">
            <TD WIDTH="86%" BGCOLOR="#FFFFFF"><A HREF=editfaq.php?id=<?php echo $faq['id']; ?>> 
              <?php echo $faq['question']; ?>
               </A> </TD>
            <TD WIDTH="14%" BGCOLOR="#FFFFFF" ALIGN=CENTER><INPUT TYPE="checkbox" NAME="delete[<?php echo $faq['id']; ?>]" VALUE="<?php echo $faq['id']; ?>">
            </TD>
          </TR>
          <?php
          }
          }
		?>
		<TR bgcolor=#FFFFFF>
			<TD colspan=1>&nbsp;</TD>
			<TD align=center><a href="javascript: void(0)" onClick="selectDelete(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A></TD>
		</TR>
          <TR BGCOLOR="#eeeeee">
            <TD BGCOLOR="#FFFFFF" WIDTH="86%">&nbsp;</TD>
            <TD WIDTH="14%" BGCOLOR="#FFFFFF" ALIGN=CENTER><INPUT TYPE="submit" NAME="Submit" VALUE="Delete">
            </TD>
          </TR>
        </TABLE></TD>
    </TR>
  </TABLE>
</TD>
</TR>
</TABLE>
</FORM>
</body>