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

include "../includes/common.inc.php";
include $include_path . 'functions_admin.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>WeBid Administration back-end</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CHARSET; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="0083D7" background="images/bac_hea.gif" text="#FFFFFF" link="#FFFFFF" vlink="#CCCCCC" alink="#666666" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="54" border="0" cellpadding="2" cellspacing="2" background="images/bac_hea.gif">
  <tr> 
	<td width="285" rowspan="2" valign="top">
		<A HREF=index.php TARGET=_top><img src="images/logo.gif" hspace="5" vspace="2" BORDER=0></A>
	</td>
	<td height="20">
		<img src="images/t_adm_be.gif" width="192" height="16" hspace="5">
	</td>
  </tr>
  <tr>
	<td valign="top" align=right colspan="2">
		<font size="1" face="Verdana, Arial, Helvetica, sans-serif">
		<?php
		  if (!checklogin()) {
		?>
		  <?php echo $MSG['592']; ?>
		  <B>
		  <?php echo $_SESSION['WEBID_ADMIN_USER']; ?>
		  </B></FONT>
		  <?php
		  } else {
			print "&nbsp;";
		  }
		  if (!checklogin()) {
		?>
		 <font color="#FFFFFF" SIZE=1> | 
		 </font> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="logout.php" TARGET=content>logout</a></FONT></font>
		 <?php
		 	if (count($LANGUAGES) > 1){
				foreach ($LANGUAGES as $lang => $value)
				{
					print "<a target='_top' href='index.php?lan=$lang'><img align='middle' vspace=2 hspace=2 src='".$system->SETTINGS['siteurl']."includes/flags/".$lang.".gif' border='0'></a>";
				}
			}
		  }
		?>
	 </td>
  </tr>
</table>
</body>
</html>