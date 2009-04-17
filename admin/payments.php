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

function ToBeDeleted($index){
	global $delete;
	
	$i = 0;
	while ($i < count($_POST['delete'])){
		if ($_POST['delete'][$i] == $index) return true;
		
		$i++;
	}
	return false;
}


if ($_POST['act'] && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])){
	//-- Built new payments array
	
	$rebuilt_array = array();
	$i = 0;
	while ($i < count($_POST['new_payments'])){
		if (!ToBeDeleted($i) && strlen($_POST['new_payments'][$i]) != 0){
			$rebuilt_array[] = $_POST['new_payments'][$i];
		}
		$i++;
	}
	
	//--
	$query = "delete from " . $DBPrefix . "payments";
	$result = mysql_query($query);
	if (!$result) {
		print $ERR_001." - ".mysql_error();
		exit;
	}
	
	//--
	$i = 0;
	$counter = 1;
	while ($i < count($rebuilt_array)){
		$query = "insert into " . $DBPrefix . "payments values($counter,\"$rebuilt_array[$i]\")";
		$result = mysql_query($query);
		if (!$result) {
			print $ERR_001." - ".mysql_error();
			exit;
		}
		$counter++;
		$i++;
	}
	
	$msg = "093";
}

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
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['075']; ?></td>
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
<td align="center">
<BR>
<form NAME=conf ACTION=payments.php method="post">
	<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
			<td align="center" class=title>
				<?php print $MSG['075']; ?>
				</B></td>
		</tr>
		<tr>
			<td>
				<table width=100% cellpadding=2 bgcolor="#FFFFFF">
					<?php
					if (isset($ERR))
					{
					?>
						<tr bgcolor=yellow>
						<td colspan="3" align="center"><B>
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
					<tr>
						<td width=50></td>
						<td> 
							<?php
							print $MSG['092'];
							?>
							</td>
					</tr>
					<tr>
						<td width=3></td>
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
					$query = "select * from " . $DBPrefix . "payments order by description";
					$result = mysql_query($query);
					if (!$result)
					{
						print $ERR_001." - ".mysql_error();
						exit;
					}
					$num = mysql_num_rows($result);
					
					$i = 0;
					while ($i < $num){
						
						$description 	= mysql_result($result,$i,"description");
						
						print "<tr>
		 <td width=50></td>
		 <td>
		 <input type=text NAME=new_payments[] VALUE=\"$description\" SIZE=25>
		 </td>
		 <td align=center>
		 <input type=checkbox NAME=delete[] VALUE=$i>
		 </td>
		 </tr>";
						$i++;
					}
		?>
		<tr>
		 <td width=50>
		  Add
		 </td>
		 <td>
		 <input type=text NAME=new_payments[] SIZE=25>
		 </td>
		 <td align=center>
		 <a href="javascript: void(0)" onClick="selectAll(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A>
		 </td>
		 </tr>
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