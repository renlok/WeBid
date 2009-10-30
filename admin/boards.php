<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include $include_path.'status.inc.php';
include $include_path.'dates.inc.php';

#//
unset($ERR);

#// Delete boards
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		$query = "DELETE FROM " . $DBPrefix . "community WHERE id='$v'";
		$r = mysql_query($query);
		$system->check_mysql($r, $query, __LINE__, __FILE__);
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE boardid='$v'";
		$r = mysql_query($query);
		$system->check_mysql($r, $query, __LINE__, __FILE__);
	}
}

#// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "community ORDER BY name";
$res__ = mysql_query($query);
$system->check_mysql($res__, $query, __LINE__, __FILE__);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">
function selectDelete(formObj, isInverse) 
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
<body style="margin:0;">
<form name="boards" METHOD="post" action="">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif">
	
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5032']; ?></td>
		</tr>
	  	</table>
	</td>
	</tr>
	<tr>
	<td align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr> 
	<td align="center" valign="middle">
  		<table width="600" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#0083D7">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
				  <tr bgcolor="#0083D7">
					<td colspan="6" clign=center class=title>
				<?php echo $MSG['5032']; ?>
			</td>
					</tr>
					<?php
					if (isset($ERR))
					{
					?>
					<tr bgcolor="yellow">
					  <td colspan="6" class=error>
						<?php echo $ERR; ?>
						</td>
					</tr>
					<?php
					}
					?>
					<tr bgcolor=#ffffff>
						<td colspan="6">
						<B><?php echo $MSG['5040']; ?></B></td>
					</tr>
					<tr bgcolor="#eeeeee">
						<td width="6%"><?php echo $MSG['129']; ?></td>
						<td width="40%"><?php echo $MSG['294']; ?></td>
						<td width="10%" align="center"><?php echo $MSG['5046']; ?></td>
						<td width="12%" align="center"><?php echo $MSG['5043']; ?></td>
						<td width="16%" align="center"><?php echo $MSG['5044']; ?></td>
						<td width="16%" align="center">
							<input type="submit" name="Submit" value="<?php echo $MSG['008']; ?>">
						</td>
					</tr>
					<?php
					while ($row = mysql_fetch_array($res__))
					{
						if ($row['active'] == 1) {
							$BG = "#FFFFFF";
						} else {
							$BG = "#CCCCFF";
						}
					?>
					<tr bgcolor="<?php echo $BG; ?>">
						<td width="6%">
							<?php echo $row['id']; ?>
						</td>
						<td width="40%"> <A HREF=editboards.php?id=<?php echo $row['id']; ?>>
							<?php echo $row['name']; ?>
							</A>
							<?php
							if ($row['active'] == 2)
							{
								print "&nbsp;&nbsp;&nbsp;<B>[INACTIVE]</B>";
							}
							?></td>
						<td width="10%" align="center"><?php echo $row['msgstoshow']; ?></td>
						<td width="12%" align="center">
							<?php echo $row['messages']; ?>
						</td>
						<td width="16%" align="center">
							<?php
							if ($row['lastmessage'] == 0) {
								print "--";
							} else {
								print FormatDate($row['lastmessage']);
							}
							?>
						</td>
						<td width="16%" align="center">
							<input type="checkbox" name="delete[<?php echo $row['id']; ?>]" value="<?php echo $row['id']; ?>">
						</td>
					</tr>
					<?php
					}
					?>
					<tr bgcolor=#FFFFFF>
						<td colspan=5>&nbsp;</td>
						<td align=center><a href="javascript: void(0)" onClick="selectDelete(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A></td>
					</tr>
					<tr bgcolor="#eeeeee">
						<td width="6%" bgcolor="#FFFFFF">&nbsp;</td>
						<td bgcolor="#FFFFFF" width="40%">&nbsp;</td>
						<td width="10%" bgcolor="#FFFFFF" align="center">&nbsp;</td>
						<td width="12%" bgcolor="#FFFFFF" align="center">&nbsp;</td>
						<td width="16%" bgcolor="#FFFFFF" align="center">&nbsp;</td>
						<td width="16%" bgcolor="#FFFFFF" align="center">
							<input type="submit" name="Submit2" value="Delete">
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