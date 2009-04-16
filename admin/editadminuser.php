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
include $include_path.'status.inc.php';

#//
$ERR = "&nbsp;";

$id = $_REQUEST[id];
if ($_POST[action] == "update" && strstr(basename($_SERVER['HTTP_REFERER']), basename($_SERVER['PHP_SELF'])))
{
  if ((!empty($_POST[password]) && empty($_POST[repeatpassword])) ||
  (empty($_POST[password]) && !empty($_POST[repeatpassword])))
  {
	$ERR = $ERR_054;
	$USER = $_POST;
  }
  elseif ($_POST[password] != $_POST[repeatpassword])
  {
	$ERR = $ERR_006;
	$USER = $_POST;
  }
  else
  { 
	#// Update
	$query = "UPDATE " . $DBPrefix . "adminusers set";
	if (!empty($_POST[password]))
	{
	  $PASS = md5($MD5_PREFIX.$_POST[password]);
	  $query .= " password='$PASS', ";
	}
	$query .= " status=".intval($_POST[status])."
				WHERE id=$_POST[id]";

	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	header("Location: adminusers.php");
	exit;
  }
}

#//
$query = "SELECT * FROM " . $DBPrefix . "adminusers WHERE id=$id";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$USER = mysql_fetch_array($res);
$CREATED = substr($USER[created],4,2)."/".
substr($USER[created],6,2)."/".
substr($USER[created],0,4);
if ($USER[lastlogin] == 0)
{
  $LASTLOGIN = $MSG['570'];
}
else
{
  $LASTLOGIN = substr($USER[lastlogin],4,2)."/".
  substr($USER[lastlogin],6,2)."/".
  substr($USER[lastlogin],0,4)." ".
  substr($USER[lastlogin],8,2).":".
  substr($USER[lastlogin],10,2).":".
  substr($USER[lastlogin],12,2);
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
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
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_use.gif" ></td>
		  <td class=white><?php echo $MSG['25_0010']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['525']; ?></td>
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
<form name="conf" action="" method="post">
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
  <tr>
	<td align="center" class=title>
	  <?php print $MSG['562']; ?>
	</td>
  </tr>
  <tr>
	<td>
	  <table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
		<tr>
		  <td colspan="2"><A HREF="./increments.php" CLASS="links">
			</A>
			<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
			  <tr>
				<td colspan="2" align="center"><B>
				  <?php print $ERR; ?>
				  </B></td>
			  </tr>
			  <tr>
				<td width="123"> 
				  <?php print $MSG['003']; ?>
				  </td>
				<td width="411">
				  <B>
				  <?php print $USER[username]; ?>
				  </B> </td>
			  </tr>
			  <tr>
				<td width="123"> 
				  <?php print $MSG['558']; ?>
				  </td>
				<td width="411">
				  <?php print $CREATED;?>
				  </td>
			  </tr>
			  <tr>
				<td width="123"> 
				  <?php print $MSG['559']; ?>
				  </td>
				<td width="411">
				  <?php print $LASTLOGIN; ?>
				  </td>
			  </tr>
			  <tr>
				<td colspan="2" bgcolor="#EEEEEE">
				  <?php print $MSG['563']; ?>
				  </td>
			  </tr>
			  <tr>
				<td width="123" bgcolor="#EEEEEE">
				  <?php print $MSG['004']; ?>
				  </td>
				<td width="411" bgcolor="#EEEEEE">
				  <input type="PASSWORD" name="password" SIZE="25">
				</td>
			  </tr>
			  <tr>
				<td width="123" bgcolor="#EEEEEE">
				  <?php print $MSG['564']; ?>
				  </td>
				<td width="411" bgcolor="#EEEEEE">
				  <input type="PASSWORD" name="repeatpassword" SIZE="25">
				</td>
			  </tr>
			  <tr>
				<td width="123">
				  <?php print $MSG['565']; ?>
				  </td>
				<td width="411">
				  <input type="radio" name="status" value="1"
	  <?php if ($USER[status] == 1) print " CHECKED";?>
	  >
				  
				  <?php print $MSG['566']; ?>
				  
				  <input type="radio" name="status" value="2"
	  <?php if ($USER[status] == 2) print " CHECKED";?>
	  >
				  
				  <?php print $MSG['567']; ?>
				   </td>
			  </tr>
			  <tr>
				<td width=123>&nbsp;</td>
				<td width="411">&nbsp;</td>
			  </tr>
			  <tr>
				<td width=123>
				  <input type="hidden" name="action" value="update">
				  <input type="hidden" name="id" value="<?php echo $id; ?>">
				</td>
				<td width="411">
				  <input type="submit" name="act" value="<?php print $MSG['530']; ?>">
				</td>
			  </tr>
			  <tr>
				<td width=123></td>
				<td width="411"> </td>
			  </tr>
			</table>
			</td>
		</tr>
		<tr>
		  <td width=169>
			<input type="hidden" name="action" value="update">
		  </td>
		  <td width="365">&nbsp; </td>
		</tr>
		<tr>
		  <td width=169></td>
		  <td width="365"> </td>
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
</td>
</tr>
</table>
</body>
</html>