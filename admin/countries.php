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
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$DBGSTR = "DBGSTR: ". count($delete). "-" .
count($old_countries) . " <br><br>\n";
include "./rebuild_html.php";

/*
* When the submit button is pressed (below on the page) on
* the first call to countires.php it calls countires.php
* again but with a form variable named "act" being sent as true
* (see the submit input in the HTML below).  This causes the execution
* of the below code.
*/
if (isset($_POST['act'])) {
  $delete = $_POST['delete'];
  $new_countries = $_POST['new_countries'];
  $old_countries = $_POST['old_countries'];
  /*
  *  For a description of how the arrays (delete[], new_countries[],
  *  old_countries[]) are set up see the body of the HTML below.
  */
  
  // we use a single SQL query to quickly do ALL our deletes
  $sqlstr = "DELETE FROM " . $DBPrefix . "countries WHERE ";
  /*
  * Delete anything marked for deletion in the delete[]
  * array.
  */
  // if this is the first country being deleted it don't
  // precede it with an " or " in the SQL string
  $first = 1;
  for ($i = 0; $i < count($delete); $i++) {
	$DBGSTR .= 'Deleting[' . $i .'] ' . $delete[$i] . '<br>' . "\n";
	if (!$first) {
		$sqlstr .= " or ";
	} else {
		$first = 0;
	}
	$sqlstr .= "country = '" . $system->cleanvars($old_countries[$delete[$i]]) . "'";
  }
  $DBGSTR .= $sqlstr;
  
  // If the delete array is > 0 in size
  if ( count($delete) ) {
	$result = mysql_query($sqlstr);
	if ( !$result ) {
	  $TPL_info_err = $ERR_001;
	} else {
	  $TPL_info_err = "";
	}
  }
  /*
  * Now we update all the countries where old_countries
  * isn't the same as new_countries (saving ourselves a
  * lot of queries.
  */
  for ( $i = 0; $i < count($_POST['old_countries']); $i++) {
	if ( "hey" != "hey")
	$DBGSTR .= "hey != hey";
	if ( $old_countries[$i] != $new_countries[$i]) {
	  $sqlstr = "UPDATE " . $DBPrefix . "countries SET
	  country = '" .  $system->cleanvars($new_countries[$i]) . "'
	  WHERE country = '" . $system->cleanvars($old_countries[$i]) . "'";
	  $DBGSTR .= "<br>" . $sqlstr;
	  $result = mysql_query($sqlstr);
	}
  }
  
  /* If a new country was added, insert it into database */
  if ( $new_countries[(count($new_countries) - 1)] ) {
	$sqlstr = "INSERT INTO " . $DBPrefix . "countries (country) VALUES ('";
	$sqlstr .= $system->cleanvars($new_countries[(count($new_countries) - 1)]) . "');";
	$result = mysql_query($sqlstr);
	if (!$result) {
	  $TPL_info_err = $ERR_001;
	}
  }
  rebuild_html_file("countries");
}

include $include_path . "countries.inc.php";

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT type="text/javascript">
function selectAll(formObj, isInverse) 
{
   for (var i=0;i < formObj.length;i++) 
   {
	  fldObj = formObj.elements[i];
	  if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete')
	  { 
		 if (isInverse)
			fldObj.checked = (fldObj.checked) ? false : true;
		 else fldObj.checked = true; 
	   }
   }
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php print $TPL_info_err . ""?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr>
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['081']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
	<td align="center" valign="middle"><TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
		<TR>
		  <TD><CENTER>
			  <BR>
			</CENTER>
			<FORM NAME=conf action="<?php echo basename($_SERVER['PHP_SELF']); ?>" METHOD=POST>
			  <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
				<TR>
				  <TD ALIGN=CENTER class=title><?php print $MSG['081']; ?></TD>
				</TR>
				<TR>
				  <TD><TABLE WIDTH=100% CELLPADDING=2 BGCOLOR="#FFFFFF">
					  <TR>
						<TD WIDTH=50></TD>
						<TD><p>
							<?php 
							print $MSG['094'];
							?>
							</p>
						  <p><img src="../images/nodelete.gif" width="20" height="21"> 
							<?php echo $MGS_2__0030; ?>
							 </p></TD>
					  </TR>
					  <TR>
						<TD WIDTH=50></TD>
						<TD BGCOLOR="#EEEEEE"><B> <?php print $MSG['087']; ?> </B> </TD>
						<TD BGCOLOR="#EEEEEE" align=center><B> <?php print $MSG['008']; ?> </B> </TD>
					  </TR>
					  <?php
					  
					  $i = 1;
					  while ($i < count($countries)) {
					  	$j = $i - 1;
					  	
					  	// Check if this country has been selected for an auction or
					  	// if some user has registered selecting it
					  	// If one of the above conditions is true the country cannot be deleted
					  	$USEDINUSERS = mysql_num_rows(mysql_query("SELECT id FROM " . $DBPrefix . "users WHERE country='".mysql_real_escape_string($countries[$i])."'"));
					  	
					  	print "
					  <TR>
						 <TD WIDTH=50></TD>
						 <TD>
						 <INPUT TYPE=hidden NAME=old_countries[] VALUE=\"".$countries[$i]."\" SIZE=25>
						 <INPUT TYPE=text NAME=new_countries[] VALUE=\"".$countries[$i]."\" SIZE=45>
						 </TD>
						 <TD align=center>";
					  	if (!isset($USEDINUSERS) || $USEDINUSERS == 0) {
					  		print "<INPUT TYPE=checkbox NAME=delete[] VALUE=\"$j\">";
					  	} else {
					  		print "<IMG SRC=\"../images/nodelete.gif\" ALT=\"You cannot delete this category\">";
					  	}
					  	print "
					  	</TD>
					</TR>";
					  	$i++;
					  }
					  ?>
					<TR>
						<TD WIDTH=50> Add</TD>
						<TD>
						<INPUT TYPE=text NAME=new_countries[] SIZE=25>
						</TD>
						 <TD align=center>
						 <a href="javascript: void(0)" onClick="selectAll(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A>
						 </TD>
					</TR>				  
					  <TR>
						<TD WIDTH=50></TD>
						<TD><INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['089']; ?>">
						</TD>
					  </TR>
					  <TR>
						<TD WIDTH=50></TD>
						<TD></TD>
					  </TR>
					</TABLE></TD>
				</TR>
			  </TABLE>
			</FORM></TD>
		</TR>
	  </TABLE></TD>
  </TR>
</TABLE>
</BODY>
</HTML>