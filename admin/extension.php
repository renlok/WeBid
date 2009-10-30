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

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Data check
	if ($_POST['status'] == 'enabled' && (!is_numeric($_POST['timebefore']) || !is_numeric($_POST['extend'])))
	{
		$ERR = $MSG['2_0038'];
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "settings SET
				  ae_status = '" . $_POST['status']."',
				  ae_timebefore = ".intval($_POST['timebefore']).",
				  ae_extend = ".intval($_POST['extend']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$ERR = $MSG['2_0039'];
	}
	$system->SETTINGS['ae_status'] = $_POST['status'];
	$system->SETTINGS['ae_timebefore'] = $_POST['timebefore'];
	$system->SETTINGS['ae_extend'] = $_POST['extend'];
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_auc.gif" ></td>
		  <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['2_0032']; ?></td>
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
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
			<tr>
				<td align="center" class=title>
					<?php print $MSG['2_0032']; ?>
				</td>
			</tr>
			<tr>
				<td>

	<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
	  <?php
		if ($ERR != "")
		{
		 ?>
	  <tr bgcolor=yellow>
		<td colspan="2" align="center"><B>
		  <?php print $ERR; ?>
		  </B></td>
	  </tr>
	  <?php
			}
		?>
	  <tr valign="top">
		<td height="7">&nbsp;</td>
		<td height="7">
		  <?php echo $_CUSTOM_0032; ?>
		  </td>
	  </tr>

	  <tr valign="top">
		<td colspan="2" height="7"><IMG SRC="../images/transparent.gif" width="1" height="5"></td>
	  </tr>
	  <tr valign="top">
		<td width=214 height="31">
		  <?php echo $MSG['2_0034']; ?>
		  </td>
		<td height="31" width="418">
		  <input type="radio" name="status" value="enabled" <?php if ($system->SETTINGS['ae_status'] == 'enabled') print " CHECKED";?>>
		  
		  <?php echo $MSG['030']; ?>
		  
		  <input type="radio" name="status" value="disabled" <?php if ($system->SETTINGS['ae_status'] == 'disabled') print " CHECKED";?>>
		  
		  <?php echo $MSG['029']; ?>
		   </td>
	  </tr>
	  <tr valign="top">
		<td colspan="2" height="4"><IMG SRC="../images/transparent.gif" width="1" height="5"></td>
	  </tr>
	  <tr valign="top">
		<td width=214 height="31">&nbsp;
		  </td>
		<td height="31" width="418">
		  <?php echo $MSG['2_0035']; ?>
		   &nbsp;
		  <input type=text name=extend value="<?php echo $system->SETTINGS['ae_extend']; ?>" size=5>
		  &nbsp; &nbsp;
		   
		  <?php echo $MSG['2_0036']; ?>
		   &nbsp;
		  <input type=text name=timebefore value="<?php echo $system->SETTINGS['ae_timebefore']; ?>" size=5>
		  &nbsp; &nbsp;
		   
		  <?php echo $MSG['2_0037']; ?>
		   </td>
	  </tr>
	  <tr valign="top">
		<td colspan="2" height="6"><IMG SRC="../images/transparent.gif" width="1" height="5"></td>
	  </tr>
	  <tr>
		<td width=214>
		  <input type="hidden" name="action" value="update">
		  <input type="hidden" name="id" value="<?php echo $id; ?>">
		</td>
		<td width="418">
		  <input type="submit" name="act" value="<?php print $MSG['530']; ?>">
		</td>
	  </tr>
	  <tr>
		<td width=214></td>
		<td width="418"> </td>
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