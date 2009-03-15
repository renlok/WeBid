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

#// Insert new message
if($_POST[action] == "update" && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))) {
  if(strlen($_POST[category]) == 0){
    $ERR = "The category's name cannot be empty";
  } else {
    $query = "UPDATE " . $DBPrefix . "faqscategories SET category='".addslashes($_POST['category'][$system->SETTINGS['defaultlanguage']])."'
        WHERE id=".$_POST['id'];
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);
  }

  reset($LANGUAGES);
  while(list($k,$v) = each($LANGUAGES)) {
    $TR=@mysql_result(@mysql_query("SELECT category FROM " . $DBPrefix . "faqscat_translated WHERE lang='".$k."' AND id=".$id),0,"category"); 
    if($TR) {
      $query = "UPDATE " . $DBPrefix . "faqscat_translated SET 
          category='".addslashes($_POST[category][$k])."'
          WHERE id=".$_POST['id']." AND
          lang='$k'";
    } else {
      $query = "INSERT INTO " . $DBPrefix . "faqscat_translated VALUES(
          ".$_POST['id'].",
          '$k',
          '".addslashes($_POST[category][$k])."')";
    }
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
    unset($TR);
  }
  Header("Location: faqscategories.php");
  exit;
}

if($_POST[action] != "update") {
  #// Get data from the database
  $query = "select * from " . $DBPrefix . "faqscategories WHERE id='".$_REQUEST['id']."'";
  $res = mysql_query($query);
  $system->check_mysql($res, $query, __LINE__, __FILE__);
  $category = mysql_fetch_array($res);
  $category[category]=stripslashes($category[category]);
}

?>

<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<STYLE TYPE="text/css">
body {
scrollbar-face-color: #aaaaaa;
scrollbar-shadow-color: #666666;
scrollbar-highlight-color: #aaaaaa;
scrollbar-3dlight-color: #dddddd;
scrollbar-darkshadow-color: #444444;
scrollbar-track-color: #cccccc;
scrollbar-arrow-color: #ffffff;
}</STYLE></HEAD>
<FORM NAME="editcat" METHOD="post" ACTION="">
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_con.gif" width="22" height="19" ></td>
          <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5230']; ?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
  <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" BGCOLOR="#0083D7">
    <TR BGCOLOR=#ffffff>
    <TD>&nbsp;</TD>
    </TR>
    <TR>
      <TD>
        <TABLE WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="4" ALIGN="CENTER">
          <TR BGCOLOR="#0083D7">
            <TD COLSPAN="2" align=center class=title><?php echo $MSG['5283']; ?></TD>
          </TR>
          <TR BGCOLOR="#FFFFFF">
            <TD COLSPAN="2">
              <?php echo $ERR; ?>
              </B></TD>
          </TR>
          <TR BGCOLOR="#FFFFFF">
            <TD WIDTH="24%">
            <?php echo $MSG['5284']; ?>
            </TD>
            <TD WIDTH="76%" valign=top>
            <?php
                $res_tr = @mysql_query("SELECT * FROM " . $DBPrefix . "faqscat_translated WHERE id='".$_GET['id']."'");
                while($tr=mysql_fetch_array($res_tr)){
                  $TR[$tr['lang']] = $tr['category'];
                }
            ?>
              <IMG SRC=../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif>&nbsp;<INPUT TYPE="text" NAME="category[<?php echo $system->SETTINGS['defaultlanguage']; ?>]" SIZE="50" MAXLENGTH="150" VALUE="<?php echo $TR[$system->SETTINGS['defaultlanguage']]; ?>">
              <?php
                reset($LANGUAGES);
                while(list($k,$v) = each($LANGUAGES)){
                  if($k!=$system->SETTINGS['defaultlanguage']) print "<BR><IMG SRC=../includes/flags/".$k.".gif>&nbsp;<INPUT TYPE=text NAME=category[$k] SIZE=50 MAXLENGTH=150 VALUE=\"$TR[$k]\">";
                }
              ?>
            </TD>
          </TR>
          <TR BGCOLOR="#FFFFFF">
            <TD WIDTH="24%">
              <INPUT TYPE="hidden" NAME="action" VALUE="update">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $_REQUEST['id']; ?>">
            </TD>
            <TD WIDTH="76%">
              <INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo $MSG['530']; ?>">
            </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
  </TABLE>
</TD>
</TR>
</TABLE>
</FORM>
</BODY>
</HTML>