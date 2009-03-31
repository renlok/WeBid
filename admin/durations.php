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
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
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
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD COLSPAN=3>
<FORM NAME=conf ACTION=durations.php METHOD=POST>
<BR>
<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
		<TR>
				<TD ALIGN=CENTER class=title>
						<?php print $MSG['069']; ?>
				</TD>
		</TR>
		<TR>
			<TD>
				<TABLE WIDTH=100% CELLPADDING=2 BGCOLOR="#FFFFFF">
					<?php
					if (isset($ERR))
					{
					?>
						<TR BGCOLOR=yellow>
						<TD COLSPAN="4" ALIGN=CENTER><B>
						<?php
						  if ($$ERR) {
								print $$ERR;
							}else{
								if ($msg) {
									print $MSG[$msg];
								}
							}
							?>
						  </B></TD>
					  </TR>
					 <?php
					}
					 ?>
					<TR>
						<TD WIDTH=50></TD>
						<TD COLSPAN=2> 
							<?php
								print $MSG['122'];
							?>
						</TD>
					</TR>
					<TR>
						<TD WIDTH=50></TD>
						<TD BGCOLOR="#EEEEEE">
							<B>
							<?php print $MSG['097']; ?>
							</B> </TD>
						<TD BGCOLOR="#EEEEEE">
							<B>
							<?php print $MSG['087']; ?>
							</B> </TD>
						<TD BGCOLOR="#EEEEEE">
							<B>
							<?php print $MSG['008']; ?>
							</B> </TD>
					</TR>
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
						print "<TR>
							 <TD WIDTH=50></TD>
							 <TD>
							 <INPUT TYPE=text NAME=new_days[] VALUE=\"$days\" SIZE=5>
							 </TD>
							 <TD>
							 <INPUT TYPE=text NAME=new_durations[] VALUE=\"$description\" SIZE=25>
							 </TD>
							 <TD align=center>
							 <INPUT TYPE=checkbox NAME=delete[] VALUE=\"$days\">
							 </TD>
							 </TR>";
								$i++;
							}
							print '<TR>
									 <TD WIDTH=50>
									  Add
									 </TD>
									 <TD>
									  Days <INPUT TYPE="text" NAME="new_days[]" SIZE="5" maxlength="5" value="0">
									 </TD>
									 <TD>
									 <INPUT TYPE=text NAME="new_durations[]" SIZE=25>
									 </TD>
									 <TD align=center>
									 <a href="javascript: void(0)" onclick="selectAll(document.forms[0],1)">'.$MSG['30_0102'].'</A>
									 </TD>
									 </TR>';
							?>
					<TR>
						<TD WIDTH=50></TD>
						<TD>
							<INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['089']; ?>">
						</TD>
					</TR>
					<TR>
						<TD WIDTH=50></TD>
						<TD> </TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
</TABLE>
</FORM>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>