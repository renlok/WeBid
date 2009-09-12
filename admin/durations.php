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

unset($ERR);

function ToBeDeleted($index){
	global $delete;
	
	$i = 0;
	while ($i < count($_POST['delete'])){
		if ($_POST['delete'][$i] == $index) return true;
		
		$i++;
	}
	return false;
}

if ($_POST['act'] && !$$ERR && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])){
	
	//-- Update DURATIONS table
	
	$rebuilt_durations = array();
	$rebuilt_days	  = array();
	$i = 0;
	while ($i < count($_POST['new_durations']) && strlen($_POST['new_durations'][$i]) != 0){
		if (!ToBeDeleted($_POST['new_days'][$i]) && strlen($_POST['new_durations']) != 0){
			
			$rebuilt_durations[]		 = $_POST['new_durations'][$i];
			$rebuilt_days[]			  = $_POST['new_days'][$i];
		}
		$i++;
	}
	
	$query = "delete from " . $DBPrefix . "durations";
	$result = mysql_query($query);
	if (!$result) {
		print $ERR_001." - ".mysql_error();
	}
	
	$i = 0;
	while ($i < count($rebuilt_durations)){
		$query = "insert into
								  " . $DBPrefix . "durations
								  values($rebuilt_days[$i],
								  \"$rebuilt_durations[$i]\")";
		$result = mysql_query($query);
		// print $query;
		if (!$result) {
			print $ERR_001." - ".mysql_error();
		}
		$i++;
	}
	
	$msg = "123";
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">
function selectAll(formObj, isInverse)  {
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
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['069']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
<tr>
<td COLSPAN=3>
<form NAME=conf ACTION=durations.php method="post">
<BR>
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
				<td align="center" class=title>
						<?php print $MSG['069']; ?>
				</td>
		</tr>
		<tr>
			<td>
				<table width=100% cellpadding=2 bgcolor="#FFFFFF">
					<?php
					if (isset($ERR))
					{
					?>
						<tr bgcolor=yellow>
						<td colspan="4" align="center"><B>
						<?php
						  if ($$ERR) {
								print $$ERR;
							}else{
								if ($msg) {
									print $MSG[$msg];
								}
							}
							?>
						  </B></td>
					  </tr>
					 <?php
					}
					 ?>
					<tr>
						<td width=50></td>
						<td COLSPAN=2> 
							<?php
								print $MSG['122'];
							?>
						</td>
					</tr>
					<tr>
						<td width=50></td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['097']; ?>
							</B> </td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['087']; ?>
							</B> </td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['008']; ?>
							</B> </td>
					</tr>
					<?php
					//--
					$query = "select * from " . $DBPrefix . "durations order by days";
					$result = mysql_query($query);
					if (!$result) {
						print $ERR_001." - ".mysql_error();
						exit;
					}
					$num = mysql_num_rows($result);
					$i = 0;

					while ($i < $num){
						$days				  = mysql_result($result,$i,"days");
						$description = mysql_result($result,$i,"description");
						print "<tr>
							 <td width=50></td>
							 <td>
							 <input type=text NAME=new_days[] VALUE=\"$days\" SIZE=5>
							 </td>
							 <td>
							 <input type=text NAME=new_durations[] VALUE=\"$description\" SIZE=25>
							 </td>
							 <td align=center>
							 <input type=checkbox NAME=delete[] VALUE=\"$days\">
							 </td>
							 </tr>";
								$i++;
							}
							print '<tr>
									 <td width=50>
									  Add
									 </td>
									 <td>
									  Days <input type="text" name="new_days[]" SIZE="5" maxlength="5" value="0">
									 </td>
									 <td>
									 <input type=text name="new_durations[]" SIZE=25>
									 </td>
									 <td align=center>
									 <a href="javascript: void(0)" onclick="selectAll(document.forms[0],1)">'.$MSG['30_0102'].'</A>
									 </td>
									 </tr>';
							?>
					<tr>
						<td width=50></td>
						<td>
							<input type="submit" name="act" value="<?php print $MSG['089']; ?>">
						</td>
					</tr>
					<tr>
						<td width=50></td>
						<td> </td>
					</tr>
				</table>
			</td>
		</tr>
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