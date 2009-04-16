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
count($old_membertypes) . " <br><br>\n";

include "./rebuild_tables.php";

/*
* When the submit button is pressed (below on the page) on
* the first call to countires.php it calls countires.php
* again but with a form variable named "act" being sent as true
* (see the submit input in the HTML below).  This causes the execution
* of the below code.
*/

if (isset($_POST['act'])) {
  $old_membertypes = $_POST['old_membertypes'];
  $new_membertypes = $_POST['new_membertypes'];
  $new_membertype = $_POST['new_membertype'];
  $delete = $_POST['delete'];
	/*
	*	For a description of how the arrays (delete[], new_countries[],
	*	old_countries[]) are set up see the body of the HTML below.
	*/
	// we use a single SQL query to quickly do ALL our deletes
	$sqlstr = "DELETE FROM " . $DBPrefix . "membertypes WHERE id IN (";
	/*
	* Delete anything marked for deletion in the delete[]
	* array.
	*/
	// if this is the first country being deleted it don't
	// precede it with an " or " in the SQL string
	if (is_array($delete)) {
		$idslist=join(",",$delete);
		$sqlstr.=$idslist.")";
		$DBGStr=$sqlstr;
		// If the delete array is > 0 in size
		if (count($delete)) {
			$result = mysql_query($sqlstr);
			if ( !$result ) {
				echo "$DBGStr";
				$TPL_info_err = $ERR_001;
			} else {
				$TPL_info_err = "";
			}
		}
	}
	/*
	* Now we update all the countries where old_countries
	* isn't the same as new_countries (saving ourselves a
	* lot of queries.
	*/
	if (is_array($old_membertypes)) {
		foreach ($old_membertypes as $id => $val) {
			if ( $val != $new_membertypes[$id]) {
				$sqlstr = "UPDATE " . $DBPrefix . "membertypes SET
							feedbacks = '" . $new_membertypes[$id]['feedbacks'] . "', 
							membertype = '',
							icon = '" . $system->cleanvars($new_membertypes[$id]['icon']) . "' 
							WHERE id = " . $id;
				$result = mysql_query($sqlstr);
				if (!$result) {
					$TPL_info_err = $ERR_001;
					echo $sqlstr;
				}
			}
		}
	}
	
	/* If a new membertype was added, insert it into database */
	if ( !empty($new_membertype['feedbacks']) )
	{
		$sqlstr = "INSERT INTO " . $DBPrefix . "membertypes VALUES (\"\",'";
		$sqlstr .= $new_membertype['feedbacks'] . "','";
		$sqlstr .= $new_membertype['membertype'] . "','";
		$sqlstr .= "','";
		$sqlstr .= $system->cleanvars($new_membertype['icon']) . "');";
		$result = mysql_query($sqlstr);
		if (!$result) {
			$TPL_info_err = $ERR_001;
			echo "$DBGStr";
		}
	}
	
	rebuild_table_file("membertypes");
	
}
if (file_exists( "../includes/membertypes.inc.php"))
	include "../includes/membertypes.inc.php";
else {
	rebuild_table_file("membertypes");
	include "../includes/membertypes.inc.php";
}
rebuild_table_file("membertypes");

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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr>
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['25_0169']; ?>
			</td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
	<td align="center" valign="middle"><?php print $TPL_info_err . ""?>
	  <table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
		<tr>
		  <td>
			  <BR>
			<form NAME=conf ACTION=membertypes.php METHOD=POST>
			  <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="0083D7" align="center">
				<tr>
				  <td align="center" class=title><?php print $MSG['25_0169']; ?></td>
				</tr>
				<tr>
				  <td><table width=100% cellpadding=2 bgcolor="#FFFFFF">
					  <tr>
						<td width=20></td>
						<td colspan="4">
						  <?php 
						  print $MSG['25_0170'];
						  if ($$ERR) {
						  	print "<FONT COLOR=red><BR><BR>".$$ERR;
						  }
						  ?>
						   </td>
					  </tr>
					  <tr>
						<td width=20></td>
						<td bgcolor="#EEEEEE"> <B> <?php print $MSG['25_0171']; ?> </B> </td>
						<td bgcolor="#EEEEEE"> <B> <?php print $MSG['25_0167']; ?> </B> </td>
						<td bgcolor="#EEEEEE" width=20></td>
						<td bgcolor="#EEEEEE"> <B> <?php print $MSG['25_0168']; ?> </B> </td>
					  </tr>
					  <?php
					  foreach ($membertypes as $id => $quest) {
					  ?>
					  <tr>
						<td width=20></td>
						<td><input type=hidden NAME=old_membertypes[<?php echo $id; ?>][feedbacks] VALUE='<?php echo $quest['feedbacks']; ?>'>
						  <input type=text NAME=new_membertypes[<?php echo $id; ?>][feedbacks] VALUE='<?php echo $quest['feedbacks']; ?>' SIZE=5>
						</td>
						<td><input type=hidden NAME=old_membertypes[<?php echo $id; ?>][icon] VALUE='<?php echo $quest['icon']; ?>'>
						  <input type=text NAME=new_membertypes[<?php echo $id; ?>][icon] VALUE='<?php echo $quest['icon']; ?>' SIZE=30></td>
						<td><IMG SRC='../images/icons/<?php echo $quest['icon']; ?>' align='middle'> </td>
						<td><input type=checkbox NAME=delete[] VALUE='<?php echo $id; ?>'>
						</td>
					  </tr>
					  <?php
					  }
					  ?>
					  <tr>
						<td width=20>
						  Add</td>
						<td><input type='text' NAME='new_membertype[feedbacks]' SIZE='5'></td>
						<td><input type='text' NAME='new_membertype[icon]' SIZE='30'></td>
						<td colspan=2 align=right>
						<a href="javascript: void(0)" onClick="selectAll(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A></td>
					  </tr>
					  <tr>
						<td width=20></td>
						<td colspan="6" align="center"><input type="submit" name="act" value="<?php print $MSG['089']; ?>">
						</td>
					  </tr>
					</table>
					<input type=hidden name=new_membertypes[<?php echo $id; ?>][membertype] value='<?php echo $quest['membertype']; ?>' size=30></td>
				</tr>
			  </table>
			</form></td>
		</tr>
	  </table></td>
  </tr>
</table>
</body>
</html>

