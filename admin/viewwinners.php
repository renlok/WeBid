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

include '../includes/common.inc.php';
include $include_path.'dates.inc.php';
include $include_path.'auction_types.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';


#// If $id is not defined -> error
if (!isset($_GET['id']))
{
	print $MSG['_0164'];
	exit;
}

#// Retrieve auction's data
$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id=".intval($_GET['id']);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) == 0)
{
	print $MSG['_0165'];
} else {
	$AUCTION = mysql_fetch_array($res);
}

#// Retrieve winners
$query = "SELECT * FROM " . $DBPrefix . "winners WHERE auction=".intval($_GET['id']);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	while ($row = mysql_fetch_array($res))
	{
		$WINNERS[$row['id']] = $row;
	}
}
#// Retrieve bids
$query = "SELECT * FROM " . $DBPrefix . "bids WHERE auction=".intval($_GET['id']);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	while ($row = mysql_fetch_array($res))
	{
		$BIDS[$row['id']] = $row;
	}
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_auc.gif"></td>
		  <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['30_0176']; ?></td>
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
			<?php print $MSG['30_0176']; ?>
		</td>
	</tr>
	<tr>
		<td>

	<table width=100% CELPADDING=4 cellspacing=0 border=0 align="center" cellpadding="3">
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left><B><?php echo $MSG['113']; ?>: </B> <?php echo intval($_GET['id']); ?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left><B><?php echo $MSG['197']; ?>: </B> <?php echo stripslashes($AUCTION['title']); ?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left>
			<? $SELLER = @mysql_fetch_array(@mysql_query("SELECT name,nick FROM " . $DBPrefix . "users WHERE id=".$AUCTION['user']));?>
			<B><?php echo $MSG['125']; ?>: </B> <?php echo stripslashes($SELLER['nick'])." (".$SELLER['name'].")";?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left><B><?php echo $MSG['127']; ?>: </B> <?php echo $system->print_money($AUCTION['minimum_bid']); ?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left><B><?php echo $MSG['111']; ?>: </B> <?php echo FormatDate($AUCTION['starts']); ?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left><B><?php echo $MSG['30_0177']; ?>: </B> <?php echo FormatDate($AUCTION['ends']); ?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left><B><?php echo $MSG['257']; ?>: </B> <?php echo $auction_types[$AUCTION['auction_type']]; ?></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left>&nbsp;</td>
	  </tr>
	  <tr bgcolor="#FFCC00">
		<td ALIGN=left><B><?php echo $MSG['453']; ?></B></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left>
		<?php
		if (is_array($WINNERS)){
		?>
				<table width=65% align="center" cellpadding=4 cellspacing=1 border=0 bgcolor=#FFFFFF>
				<tr bgcolor=#DDDDDD align=center>
					<td><B><?php echo $MSG['176']; ?></B></td>
					<td><B><?php echo $MSG['30_0179']; ?></B></td>
					<td><B><?php echo $MSG['284']; ?></B></td>
				</tr>
			<?php
				foreach ($WINNERS as $k => $v)
				{
					$qty = @mysql_result(@mysql_query("SELECT quantity FROM " . $DBPrefix . "bids WHERE bidder=".$v['winner']." AND auction=".intval($_GET['id'])),0,"quantity");
					$BIDDER = @mysql_fetch_array(@mysql_query("SELECT name,nick FROM " . $DBPrefix . "users WHERE id=".$v['winner']));
			?>
				<tr>
					<td><?php echo stripslashes($BIDDER['nick'])." (".stripslashes($BIDDER['name']).")"; ?></td>
					<td align=right><?php echo $system->print_money($v['bid']); ?>&nbsp;</td>
					<td align=center><?php if ($qty==0) print "--"; else print $qty; ?></td>
				</tr>
			<?php
				}
			?>
				</table>
			<?php
		}else{
			print $MSG['30_0178'];
		}
		?>
		</td>
	  </tr>
	  <tr bgcolor="#FFCC00">
		<td ALIGN=left><B><?php echo $MSG['30_0180']; ?></B></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td ALIGN=left>
		<?php
		if (is_array($BIDS)){
		?>
				<table width=65% align="center" cellpadding=4 cellspacing=1 border=0 bgcolor=#FFFFFF>
				<tr bgcolor=#DDDDDD align=center>
					<td><B><?php echo $MSG['176']; ?></B></td>
					<td><B><?php echo $MSG['30_0179']; ?></B></td>
					<td><B><?php echo $MSG['284']; ?></B></td>
				</tr>
			<?php
				foreach ($BIDS as $k => $v)
				{
					$qty = @mysql_result(@mysql_query("SELECT quantity FROM " . $DBPrefix . "bids WHERE bidder=".$v['bidder']." AND auction=".intval($_GET['id'])),0,"quantity");
					$BIDDER = @mysql_fetch_array(@mysql_query("SELECT name,nick FROM " . $DBPrefix . "users WHERE id=".$v['bidder']));
			?>
				<tr>
					<td><?php echo stripslashes($BIDDER['nick'])." (".stripslashes($BIDDER['name']).")"; ?></td>
					<td align=right><?php echo $system->print_money($v['bid']); ?>&nbsp;</td>
					<td align=center><?php if ($qty==0) print "--"; else print $qty;?></td>
				</tr>
			<?php
				}
			?>
				</table>
			<?php
		}else{
			print $MSG['30_0178'];
		}
		?>
		</td>
	  </tr>
	  
	</table>
</tr>
</table>
</body>
<html>