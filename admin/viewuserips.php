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

$id = $_REQUEST[id];
$offset = $_REQUEST[offset];
if ($_POST[action] == "update")
{
	if (is_array($_POST['accept']))
	{
		while (list($k,$v) = each($_POST['accept']))
		{
			@mysql_query("UPDATE " . $DBPrefix . "usersips SET action='accept' WHERE id=$k");
		}
	}
	if (is_array($_POST['deny']))
	{
		while (list($k,$v) = each($_POST['deny']))
		{
			@mysql_query("UPDATE " . $DBPrefix . "usersips SET action='deny' WHERE id=$k");
		}
	}
}

#//
$query = "SELECT nick,email,lastlogin FROM " . $DBPrefix . "users WHERE id='".$id."'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$USER = mysql_fetch_array($res);
}

#//
$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE user='$id' AND type='first'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$FIRST = mysql_fetch_array($res);
}

$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE user='$id' AND type<>'first'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	while ($row = mysql_fetch_array($res))
	{
		$NEXT[$row['id']] = $row;
	}
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_use.gif" ></td>
		  <td class=white><?php echo $MSG['25_0010']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['045']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
	<tr>
		<td align="center" class=title>
			<?php print $MSG['2_0004']; ?>
		</td>
	</tr>
	<tr>
		<td>

	  <table width=100% CELPADDING=0 cellspacing=1 border=0 align="center" cellpadding="3">
		<tr bgcolor=#FFFFFF align="center">
		  <td colspan=7>
		  <form NAME=banform ACTION="" METHOD=POST>
			  <table width="90%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
				<tr>
				  <td bgcolor="#ffffff">
					<b>
					  <?php print $MSG['200']; ?></b>
					  <?php echo $USER['nick']; ?>
					  (<A HREF=<?php echo $USER['email']; ?>><?php echo $USER['email']; ?></A>)
					</td>
					<td ALIGN="right">
					<?php
						$lastlogin = strtotime($USER['lastlogin']);
					?>
					<?php echo $MSG['559'].":".date('Y-m-d H:i:s', $lastlogin + $system->tdiff); ?>
				</tr>
			  </table>
			  <table width="90%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
				<tr>
				  <td width="35%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['087']; ?>
					  </b></div>
				  </td>
				  <td width="27%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['2_0009']; ?>
					  </b></div>
				  </td>
				  <td width="21%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['560']; ?>
					  </b></div>
				  </td>
				  <td width="17%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['5028']; ?>
					  </b></div>
				  </td>
				</tr>
				<tr bgcolor="#FFFFFF">
				  <td width="35%"> <b>
					<?php print $MSG['2_0005']; ?>
					</b></td>
				  <td width="27%">
					<div align="center"><b>
					  <?php print $FIRST['ip']; ?>
					  </b></div>
				  </td>
				  <td width="21%" align=center> 
					<?php
					if ($FIRST['action'] == 'accept')
					{
						print $MSG['2_0012'];
					}
					else
					{
						print $MSG['2_0013'];
					}
				  ?>
					 </td>
				  <td width="17%"> 
					<?php
					if ($FIRST['action'] == 'accept')
					{
					?>
					<input type="checkbox" name="deny[<?php echo $FIRST['id']; ?>]2" value="<?php echo $FIRST['id']; ?>">
					<?php
					print "&nbsp;".$MSG['2_0006'];
					}
					else
					{
					?>
					<input type="checkbox" name="accept[<?php echo $FIRST['id']; ?>]2" value="<?php echo $FIRST['id']; ?>">
					<?php
					print "&nbsp;".$MSG['2_0007'];
					}
				  ?>
					 </td>
				</tr>
				<?php
				if (is_array($NEXT))
				{
					while (list($k,$v) = each($NEXT))
					{
				?>
				<tr bgcolor="#FFFFFF">
				  <td width="35%"> 
					<?php echo $MSG['221']; ?>
					 </td>
				  <td width="27%" align=center> 
					<?php echo $v['ip']; ?>
					 </td>
				  <td width="21%" align=center> 
					<?php
					if ($v['action'] == 'accept')
					{
						print $MSG['2_0012'];
					}
					else
					{
						print $MSG['2_0013'];
					}
				  ?>
					 </td>
				  <td width="17%"> 
					<?php
					if ($v['action'] == 'accept')
					{
					?>
					<input type="checkbox" name="deny[<?php echo $v['id']; ?>]2" value="<?php echo $v['id']; ?>">
					<?php
					print "&nbsp;".$MSG['2_0006'];
					}
					else
					{
					?>
					<input type="checkbox" name="accept[<?php echo $v['id']; ?>]2" value="<?php echo $v['id']; ?>">
					<?php
					print "&nbsp;".$MSG['2_0007'];
					}
				  ?>
					 </td>
				  <?php
					}
				}
				?>
				</tr>
			  </table>
			  <p>&nbsp;</p>
			  <p>
				<input type="submit" name="Submit" value="<?php echo $MSG['2_0015']; ?>">
				<input type=hidden NAME=action VALUE=update>
				<input type=hidden NAME=id VALUE=<?php echo $id; ?>>
			  </p>
			</form>
		  </td>
		</tr>

	  </table>
</td></tr></table>

</td>
</tr>
</table>
</body>
</html>
