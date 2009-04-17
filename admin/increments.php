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

function ToBeDeleted($index){
	global $delete;
	$i = 0;
	while ($i < count($delete)){
		if ($delete[$i] == $index) return true;
		$i++;
	}
	return false;
}

unset($ERR);
$increments = $_POST['increments'];
$lows = $_POST['lows'];
$highs = $_POST['highs'];
$delete = $_POST['delete'];

if (isset($_POST['act'])) {
	//-- Al fields must be numeric with
	
	$i = 0;
	while ($i < count($increments) - 1){
		/*$lows[$i] = $system->input_money($lows[$i]);
		$highs[$i] = $system->input_money($highs[$i]);
		$increments[$i] = $system->input_money($increments[$i]);
		*/
		//print "$lows[$i] - $highs[$i] - $increments[$i]<BR>";
		if (!$system->CheckMoney($lows[$i])){
			$ERR = "ERR_030";
		}
		if (!$system->CheckMoney($highs[$i])){
			$ERR = "ERR_030";
		}
		if (!$system->CheckMoney($increments[$i])){
			$ERR = "ERR_030";
		}
		
		/*
		if (!ereg("^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{1,2})$",$lows[$i])){
		$ERR = "ERR_030";
		}
		if (!ereg("^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{1,2})$",$highs[$i])){
		$ERR = "ERR_030";
		}
		if (!ereg("^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{1,2})$",$increments[$i])){
		$ERR = "ERR_030";
		}
		*/
		$i++;
	}
}

if (isset($_POST['act']) && !isset($ERR)){
	
	//-- Build new increments array
	$rebuilt_increments = array();
	$rebuilt_lows = array();
	$rebuilt_highs = array();

	$i = 0;
	while ($i < count($increments)){
		if (!ToBeDeleted($i) && strlen($increments[$i]) != 0){
			$rebuilt_increments[] 	= $increments[$i];
			$rebuilt_lows[] 		= $lows[$i];
			$rebuilt_highs[] 		= $highs[$i];
		}
		$i++;
	}
	
	$query = "DELETE FROM " . $DBPrefix . "increments";
	$result = mysql_query($query);
	if (!$result){
		print "Database access error - abnormal termination".mysql_error();
		exit;
	}
	
	$i = 0;
	$counter = 1;
	while ($i < count($rebuilt_increments)){
		$query = "INSERT INTO " . $DBPrefix . "increments VALUES ('$counter', ".
		$system->input_money($rebuilt_lows[$i]).", ".
		$system->input_money($rebuilt_highs[$i]).", ".
		$system->input_money($rebuilt_increments[$i]).")";
		$result = mysql_query($query);
		$i++;
		$counter++;
	}
	
	$msg = "160";
}

?>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
}
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
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['128']; ?></td>
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
<form name="conf" action="increments.php" method="post">
	<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
			<td align="center" class=title>
				<?php print $MSG['128']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<table width=100% cellpadding=2 bgcolor="#FFFFFF">
					<?php
					if (isset($ERR) || isset($msg))
					{
					?>
						<tr bgcolor=yellow>
						<td colspan="5" align="center"><B>
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
						<td COLSPAN=4> 
							<?php
							print $MSG['135'];
							?>
							<BR><BR>
							[&nbsp;<A HREF=javascript:window_open('<?php echo $system->SETTINGS['siteurl']; ?>converter.php','incre',650,250,30,30)><?php echo $MSG['5010']; ?></A>&nbsp;]
							 </td>
					</tr>
					<tr>
						<td width=50></td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['240']; ?>
							</B> </td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['241']; ?>
							</B> </td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['137']; ?>
							</B> </td>
						<td bgcolor="#EEEEEE">
							<B>
							<?php print $MSG['008']; ?>
							</B> </td>
					</tr>
					<?php
					$query = "select * from " . $DBPrefix . "increments order by low";
					$result = mysql_query($query);
					if (!$result){
						print "Database access error: contact the site adminitrator".mysql_error();
						exit;
					}
					$num_increments = mysql_num_rows($result);
					$i = 0;
					while ($i < $num_increments)
					{
						$low = $system->print_money_nosymbol(mysql_result($result,$i,"low"));
						$high = $system->print_money_nosymbol(mysql_result($result,$i,"high"));
						$increment = $system->print_money_nosymbol(mysql_result($result,$i,"increment"));
						
						/*
						$low = number_format(mysql_result($result,$i,"low"),2,'.',',');
						$high = number_format(mysql_result($result,$i,"high"),2,'.',',');
						$increment = number_format(mysql_result($result,$i,"increment"),2,'.',',');
						*/
						print "<tr>
										 <td width=50></td>
										 <td><input type=text NAME=lows[] VALUE=\"".chop($low)."\" SIZE=10></td>
										 <td><input type=text NAME=highs[] VALUE=\"".chop($high)."\" SIZE=10></td>
										 <td><input type=text NAME=increments[] VALUE=\"".chop($increment)."\" SIZE=10></td>
										 <td align=center><input type=checkbox NAME=delete[] VALUE=\"$i\"></td>
										 </tr>";
						$i++;
					}
					print "<tr>
	 <td width=50>
	  Add
	 </td>
	 <td>
	 <input type=text NAME=lows[] SIZE=10>
	 </td>
	 <td>
	 <input type=text NAME=highs[] SIZE=10>
	 </td>
	 <td>
	 <input type=text NAME=increments[] SIZE=10>
	 </td>
	 <td align=center>
	 <a href=\"javascript: void(0)\" onclick=\"selectAll(document.forms[0],1)\">".$MSG['30_0102']."</A>
	 </td>
	 </tr>";
					
?>
					<tr>
						<td width=50></td>
						<td>
						<input type="hidden" name="action" value="go">
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