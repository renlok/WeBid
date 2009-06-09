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

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (!empty($_POST['ip']))
	{
		$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
				(NULL, 'NOUSER',  '" . $_POST['ip'] . "', 'next',  'deny')";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	if (is_array($_POST['delete']))
	{
		foreach ($_POST['delete'] as $k => $v)
		{
			$query = "DELETE FROM " . $DBPrefix . "usersips WHERE id = " . intval($k);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	if (is_array($_POST['accept']))
	{
		foreach ($_POST['accept'] as $k => $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'accept' WHERE id = " . intval($k);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
	if (is_array($_POST['deny']))
	{
		foreach ($_POST['deny'] as $k => $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'deny' WHER id = " . intval($k);
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
}

$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE user = 'NOUSER'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$NEXT = array();
while ($row = mysql_fetch_array($res))
{
	$NEXT[$row['id']] = $row;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_use.gif" ></td>
		  <td class=white><?php echo $MSG['25_0010']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['2_0017']; ?></td>
		</tr>
	  	</table>
	</td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr> 
  <td align="center" valign="middle">
	<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
	<tr>
		<td align="center" class=title>
			<?php print $MSG['2_0020']; ?>
		</td>
	</tr>
	<tr>
	<td>
	<form NAME=banform action="" method="post">
	  <table width=100% CELPADDING=0 cellspacing=1 border=0 align="center" cellpadding="3">
		<tr bgcolor=#FFFFFF align="center">
		  <td>
		  
			  <table width="100%" border="0" cellspacing="0" cellpadding="4" bgcolor="#CCCCCC">
				<tr>
				  <td bgcolor="#FFFF66">
					<?php echo $MSG['2_0021']; ?>
					<input type="text" name="ip">
					<input type="submit" name="Submit2" value="&gt;&gt;">
					<?php echo $MSG['2_0024']; ?>
					 </td>
				</tr>
			  </table>
			  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
				<tr>
				  <td width="29%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['087']; ?>
					  </b></div>
				  </td>
				  <td width="25%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['2_0009']; ?>
					  </b></div>
				  </td>
				  <td width="19%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['560']; ?>
					  </b></div>
				  </td>
				  <td width="18%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['5028']; ?>
					  </b></div>
				  </td>
				  <td width="9%" bgcolor="#eeeeee">
					<div align="center"><b>
					  <?php print $MSG['008']; ?>
					  </b></div>
				  </td>
				</tr>
				<?php
				if (is_array($NEXT))
				{
					foreach ($NEXT as $k => $v)
					{
				?>
				<tr bgcolor="#FFFFFF">
				  <td width="29%"> 
					<?php echo $MSG['2_0025']; ?>
					 </td>
				  <td width="25%" align=center> 
					<?php echo $v['ip']; ?>
					 </td>
				  <td width="19%" align=center> 
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
				  <td width="18%"> 
					<?php
					if ($v['action'] == 'accept')
					{
					?>
					<input type="checkbox" name="deny[<?php echo $v['id']; ?>]22" value="<?php echo $v['id']; ?>">
					<?php
					print "&nbsp;".$MSG['2_0006'];
					}
					else
					{
					?>
					<input type="checkbox" name="accept[<?php echo $v['id']; ?>]22" value="<?php echo $v['id']; ?>">
					<?php
					print "&nbsp;".$MSG['2_0007'];
					}
				  ?>
					 </td>
				  <td width="9%">
					<div align="center">
					  <input type="checkbox" name="delete[<?php echo $v['id']; ?>]" value="<?php echo $v['id']; ?>">
					</div>
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
			  </td>
			</tr>
			</table>
			</form>
		  </td>
		</tr></table>
</td></tr></table>
</body>
</html>