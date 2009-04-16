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

$DBGStr = "DBGStr: ". count($delete). "-" .
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
	$DBGStr .= 'Deleting[' . $i .'] ' . $delete[$i] . '<br>' . "\n";
	if (!$first) {
		$sqlstr .= " or ";
	} else {
		$first = 0;
	}
	$sqlstr .= "country = '" . $system->cleanvars($old_countries[$delete[$i]]) . "'";
  }
  $DBGStr .= $sqlstr;
  
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
	$DBGStr .= "hey != hey";
	if ( $old_countries[$i] != $new_countries[$i]) {
	  $sqlstr = "UPDATE " . $DBPrefix . "countries SET
	  country = '" .  $system->cleanvars($new_countries[$i]) . "'
	  WHERE country = '" . $system->cleanvars($old_countries[$i]) . "'";
	  $DBGStr .= "<br>" . $sqlstr;
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
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
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
</head>
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
	<td align="center" valign="middle"><table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
		<tr>
		  <td><CENTER>
			  <BR>
			</CENTER>
			<form NAME=conf action="<?php echo basename($_SERVER['PHP_SELF']); ?>" METHOD=POST>
			  <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
				<tr>
				  <td align="center" class=title><?php print $MSG['081']; ?></td>
				</tr>
				<tr>
				  <td><table width=100% cellpadding=2 bgcolor="#FFFFFF">
					  <tr>
						<td width=50></td>
						<td><p>
							<?php 
							print $MSG['094'];
							?>
							</p>
						  <p><img src="../images/nodelete.gif" width="20" height="21"> 
							<?php echo $MGS_2__0030; ?>
							 </p></td>
					  </tr>
					  <tr>
						<td width=50></td>
						<td bgcolor="#EEEEEE"><B> <?php print $MSG['087']; ?> </B> </td>
						<td bgcolor="#EEEEEE" align=center><B> <?php print $MSG['008']; ?> </B> </td>
					  </tr>
					  <?php
					  
					  $i = 1;
					  while ($i < count($countries)) {
					  	$j = $i - 1;
					  	
					  	// Check if this country has been selected for an auction or
					  	// if some user has registered selecting it
					  	// If one of the above conditions is true the country cannot be deleted
					  	$USEDINUSERS = mysql_num_rows(mysql_query("SELECT id FROM " . $DBPrefix . "users WHERE country='".mysql_real_escape_string($countries[$i])."'"));
					  	
					  	print "
					  <tr>
						 <td width=50></td>
						 <td>
						 <input type=hidden NAME=old_countries[] VALUE=\"".$countries[$i]."\" SIZE=25>
						 <input type=text NAME=new_countries[] VALUE=\"".$countries[$i]."\" SIZE=45>
						 </td>
						 <td align=center>";
					  	if (!isset($USEDINUSERS) || $USEDINUSERS == 0) {
					  		print "<input type=checkbox NAME=delete[] VALUE=\"$j\">";
					  	} else {
					  		print "<IMG SRC=\"../images/nodelete.gif\" ALT=\"You cannot delete this category\">";
					  	}
					  	print "
					  	</td>
					</tr>";
					  	$i++;
					  }
					  ?>
					<tr>
						<td width=50> Add</td>
						<td>
						<input type=text NAME=new_countries[] SIZE=25>
						</td>
						 <td align=center>
						 <a href="javascript: void(0)" onClick="selectAll(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A>
						 </td>
					</tr>				  
					  <tr>
						<td width=50></td>
						<td><input type="submit" name="act" value="<?php print $MSG['089']; ?>">
						</td>
					  </tr>
					  <tr>
						<td width=50></td>
						<td></td>
					  </tr>
					</table></td>
				</tr>
			  </table>
			</form></td>
		</tr>
	  </table></td>
  </tr>
</table>
</body>
</html>