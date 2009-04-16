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

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == "update") {
	if (empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active'])) {
		$ERR = $ERR_047;
	} elseif (!ereg("^[0-9]+$", $_POST['msgstoshow'])) {
		$ERR = $ERR_5000;
	} elseif (intval($_POST['msgstoshow'] == 0)) {
		$ERR = $ERR_5001;
	} else {
		$query = "UPDATE " . $DBPrefix . "community
				  SET name = '" . addslashes($_POST['name']) . "',
				  msgstoshow = " . intval($_POST['msgstoshow']) . ",
				  active = " . intval($_POST['active']) . "
				  WHERE id = " . intval($_POST['id']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		header("Location: boards.php");
		exit;
	}
}
$id = intval($_GET['id']);
// Retrieve board's data from the database
$query = "SELECT * FROM " . $DBPrefix . "community WHERE id = " . $id;
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);
$BOARD = mysql_fetch_array($res_);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="newcurrency" METHOD="post" ACTION="">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
			<td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5052']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
		<tr>
			<td align="center" valign="middle">

		<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
		<tr><td align="center" valign="middle">
		<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
		  <tr>
			<td align="center" class=title colspan="2">
				<?php echo $MSG['5052']; ?>
			</td>
		  </tr>
		  <tr><td>
		  <table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
		  <?
			  if (!empty($ERR))
			  {
		  ?>
		  <tr bgcolor=yellow>
			<td colspan="2" align="center"><B><FONT COLOR="#FF0000">
			  <? print $ERR; ?>
			  </FONT></B></td>
		  </tr>
		  <?
			}
		  ?>
		  <tr>
			<td width="17%">
			  <?php echo $MSG['5034']; ?>
			</td>
			<td>
			  <input type="text" name="name" SIZE="25" MAXLENGTH="255" value="<?php echo $BOARD[name]; ?>">
			</td>
		  </tr>
		  <tr>
			<td width="17%">
			  <?php echo $MSG['5043']; ?>
			</td>
			<td>
				<B>
			  <?php echo $BOARD['messages']; ?>
			  </B> &nbsp;&nbsp;
			  <?
				  if ($BOARD['messages'] > 0)
				  {
			  ?>
			  &nbsp;&nbsp;&nbsp;<img src="images/ball.gif" width="12" height="12"><img src="images/ball.gif" width="12" height="12">&nbsp;<a href="editmessages.php?id=<?php echo $id; ?>">
			  <?php echo $MSG['5063']; ?>
			  </a>
			  <?
				  }
			  ?>
			</td>
		  </tr>
		  <tr>
			<td width="17%">
			  <?php echo $MSG['5053']; ?>
			</td>
			<td>
			  <?
				  if ($BOARD['lastmessage'])
				  {
					  print FormatDate($BOARD['lastmessage']);
				  }
				  else
				  {
					  print "--";
				  }
			  ?>
			</td>
		  </tr>
		  <tr>
			<td width="17%" valign="top"><?php echo $MSG['5035']; ?></td>
			<td>
			  <?php echo $MSG['5036']; ?>
			  <BR>
			  <input type="text" name="msgstoshow" SIZE="4" MAXLENGTH="4" value="<?php echo $BOARD['msgstoshow']; ?>">
			</td>
		  </tr>
		  <tr>
			<td width="17%">
			  <?php echo $MSG['5054']; ?>
			</td>
			<td>
			  <input type="radio" name="active" value="1"
			  <?
				  if ($BOARD['active'] == 1)
				  {
					  print " CHECKED";
				  }
			  ?>
			  >
			  <?php echo $MSG['5038']; ?>
			  <input type="radio" name="active" value="2"
			  <?
				  if ($BOARD['active'] == 2)
				  {
					  print " CHECKED";
				  }
			  ?>
			  >
			  <?php echo $MSG['5039']; ?>
			</td>
		  </tr>
		  <tr>
			<td width="17%">
			  <input type="hidden" name="action" value="update">
			  <input type="hidden" name="id" value="<?php echo $id; ?>">
			</td>
			<td>
			  <input type="submit" name="Submit" value="<?php echo $MSG['5029']; ?>">
			</td>
		  </tr>
		</table>
		</td></tr>
		</table>
		</td></tr>
			</td>
		</tr>
	</table>
	<A HREF="boards.php"><?php echo strtoupper($MSG['5032']); ?></A>
</form>
</body>
</html>