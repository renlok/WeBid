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

Function ToBeDeleted($index){
	Global $delete;
	
	$i = 0;
	while($i < count($_POST['delete'])){
		if($_POST['delete'][$i] == $index) return true;
		
		$i++;
	}
	return false;
}


if($_POST['act'] && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF'])){
	//-- Built new payments array
	
	$rebuilt_array = array();
	$i = 0;
	while($i < count($_POST['new_payments'])){
		if(!ToBeDeleted($i) && strlen($_POST['new_payments'][$i]) != 0){
			$rebuilt_array[] = $_POST['new_payments'][$i];
		}
		$i++;
	}
	
	//--
	$query = "delete from " . $DBPrefix . "payments";
	$result = mysql_query($query);
	if(!$result) {
		print $ERR_001." - ".mysql_error();
		exit;
	}
	
	//--
	$i = 0;
	$counter = 1;
	while($i < count($rebuilt_array)){
		$query = "insert into " . $DBPrefix . "payments values($counter,\"$rebuilt_array[$i]\")";
		$result = mysql_query($query);
		if(!$result) {
			print $ERR_001." - ".mysql_error();
			exit;
		}
		$counter++;
		$i++;
	}
	
	$msg = "093";
}

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
         if(isInverse)
            fldObj.checked = (fldObj.checked) ? false : true;
         else fldObj.checked = true; 
       }
   }
}
</SCRIPT>
</HEAD>
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
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD align="center">
<BR>
<FORM NAME=conf ACTION=payments.php METHOD=POST>
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
		<TR>
			<TD ALIGN=CENTER class=title>
				<?php print $MSG['075']; ?>
				</B></TD>
		</TR>
		<TR>
			<TD>
				<TABLE WIDTH=100% CELLPADDING=2 BGCOLOR="#FFFFFF">
					<?php
					if(isset($ERR))
					{
					?>
						<TR BGCOLOR=yellow>
						<TD COLSPAN="3" ALIGN=CENTER><B>
                        <?php
						  if($$ERR) {
								print $$ERR;
							}else{
								if($msg) {
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
                    <TR>
						<TD WIDTH=50></TD>
						<TD> 
							<?php
							print $MSG['092'];
							?>
							</TD>
					</TR>
					<TR>
						<TD WIDTH=3></TD>
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
					$query = "select * from " . $DBPrefix . "payments order by description";
					$result = mysql_query($query);
					if(!$result)
					{
						print $ERR_001." - ".mysql_error();
						exit;
					}
					$num = mysql_num_rows($result);
					
					$i = 0;
					while($i < $num){
						
						$description 	= mysql_result($result,$i,"description");
						
						print "<TR>
		 <TD WIDTH=50></TD>
		 <TD>
		 <INPUT TYPE=text NAME=new_payments[] VALUE=\"$description\" SIZE=25>
		 </TD>
		 <TD align=center>
		 <INPUT TYPE=checkbox NAME=delete[] VALUE=$i>
		 </TD>
		 </TR>";
						$i++;
					}
		?>
		<TR>
		 <TD WIDTH=50>
		  Add
		 </TD>
		 <TD>
		 <INPUT TYPE=text NAME=new_payments[] SIZE=25>
		 </TD>
		 <TD align=center>
		 <a href="javascript: void(0)" onClick="selectAll(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A>
		 </TD>
		 </TR>
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