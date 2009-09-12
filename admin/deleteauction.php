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
include "../includes/common.inc.php";
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $include_path."countries.inc.php";

$username = $name;

//-- Data check
if (!$_REQUEST['id']) {
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header("Location: $URL");
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == "Delete") {
  if (!$ERR) {
	//-- Get category
	$query = "select category,photo_uploaded,pict_url from " . $DBPrefix . "auctions WHERE id='".$_POST['id']."'";
	$res__ = mysql_query($query);
	$system->check_mysql($res__, $query, __LINE__, __FILE__);
	$cat_id = mysql_result($res__,0,"category");
	$photo_uploaded = mysql_result($res__,0,"photo_uploaded");
	$pict_url = mysql_result($res__,0,"pict_url");

	//-- delete auction
	$sql="delete from " . $DBPrefix . "auctions WHERE id='".$_POST['id']."'";
	$res=mysql_query($sql);
	$system->check_mysql($res, $sql, __LINE__, __FILE__);

	//-- Update counters
	mysql_query("UPDATE " . $DBPrefix . "counters set auctions=(auctions-1)");

	//-- delete bids
	$query = "SELECT count(auction) as BIDS from " . $DBPrefix . "bids WHERE auction='".$_POST['id']."'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	
	if (mysql_num_rows($res) > 0) {
	  $BIDS = mysql_result($res,0,"BIDS");
	  $sql="delete from " . $DBPrefix . "bids WHERE auction='".$_POST['id']."'";
	  $res=mysql_query($sql);
	  $system->check_mysql($res, $sql, __LINE__, __FILE__);

	  #// Delete entries from the proxybid table
	  $sql="delete from " . $DBPrefix . "proxybid WHERE itemid='".$_POST['id']."'";
	  $res=mysql_query($sql);
	  $system->check_mysql($res, $sql, __LINE__, __FILE__);
	} else {
	  $BIDS = 0;
	}

	#// Delete file in counters
	mysql_query("DELETE " . $DBPrefix . "auccounter WHERE auction_id=".$_POST['id']);

	//-- Update counters
	mysql_query("UPDATE " . $DBPrefix . "bids set bids=(bids-$BIDS)");

	// update "categories" table - for counters
	$root_cat = $cat_id;
	do {
		// update counter for this category
		$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=\"$cat_id\"";
		$result = mysql_query($query);
		$system->check_mysql($result, $query, __LINE__, __FILE__);

		if (mysql_num_rows($result)>0) {
			$R_parent_id = mysql_result($result,0,"parent_id");
			$R_cat_id = mysql_result($result,0,"cat_id");
			$R_counter = intval(mysql_result($result,0,"counter"));
			$R_sub_counter = intval(mysql_result($result,0,"sub_counter"));
			
			$R_sub_counter--;
			if ( $cat_id == $root_cat )
				--$R_counter;
			
			if ($R_counter < 0) $R_counter = 0;
			if ($R_sub_counter < 0) $R_sub_counter = 0;
		
			$query = "UPDATE " . $DBPrefix . "categories SET counter='$R_counter', sub_counter='$R_sub_counter' WHERE cat_id=\"$cat_id\"";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			
			$cat_id = $R_parent_id;
		}
	} while ($cat_id!=0);

	#// ##############################################################################################
	#// Delete any image for this auction (uploaded picture and pictures gallery)

	#// Pictures gallery
	if (file_exists($upload_path.$_POST['id'])) {
	  if ($dir = @opendir($upload_path.$_POST['id'])) {
		while ($file = readdir($dir)) {
		  if ($file != "." && $file != "..") {
			@unlink($upload_path.$_POST['id']."/".$file);
		  }
		}
		closedir($dir);
		@rmdir($upload_path.$_POST['id']);
	  }
	}

	#// Uploaded picture
	if ($photo_uploaded)  {
	  @unlink($upload_path.$pict_url);
	}

	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	Header("location:  $URL?offset=".$_REQUEST['offset']);
  }
}


if (!$_POST['action']) {
  $query = "select a.id, u.nick, a.title, a.starts, a.description,
	c.cat_name, d.description as duration, a.suspended, a.current_bid,
	a.quantity, a.reserve_price from " . $DBPrefix . "auctions
	a, " . $DBPrefix . "users u, " . $DBPrefix . "categories c, " . $DBPrefix . "durations d WHERE u.id = a.user and
	c.cat_id = a.category and d.days = a.duration and a.id=\"".$_GET['id']."\"";
  $result = mysql_query($query);
  $system->check_mysql($result, $query, __LINE__, __FILE__);

  $id = mysql_result($result,0,"id");
  $title = mysql_result($result,0,"title");
  $nick = mysql_result($result,0,"nick");
  $tmp_date = mysql_result($result,0,"starts");
  $duration = mysql_result($result,0,"duration");
  $category = mysql_result($result,0,"cat_name");
  $description = mysql_result($result,0,"description");
  $suspended = mysql_result($result,0,"suspended");
  $current_bid = mysql_result($result,0,"current_bid");
  $quantity = mysql_result($result,0,"quantity");
  $reserve_price = mysql_result($result,0,"reserve_price");
	if ($system->SETTINGS['datesformat'] == "USA") {
		$date = gmdate('m/d/Y', $tmp_date);
	} else {
		$date = gmdate('d/m/Y', $tmp_date);
	}
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
		  <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['325']; ?></td>
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
			  <?php print $MSG['325']; ?>
			</td>
		  </tr>
		<tr>
			<td align="center">
			<table width=100% cellpadding=4 cellspacing=0 border=0 bgcolor="#FFFFFF">
			  <tr>
								<td align="center" COLSPAN=2> <BR><BR>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['312']; ?>
				</td>
				<td width="486">
				  <?php print $title; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['313']; ?>
				</td>
				<td width="486">
				  <?php print $nick; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['314']; ?>
				</td>
				<td width="486">
				  <?php print $date; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204"  VALIGN="top" ALIGN="right">
				  <?php print $MSG['315']; ?>
				</td>
				<td width="486">
				  <?php print $duration; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204"  VALIGN="top" ALIGN="right">
				  <?php print $MSG['316']; ?>
				</td>
				<td width="486">
				  <?php print $category; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['317']; ?>
				</td>
				<td width="486">
				  <?php print stripslashes($description); ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['318']; ?>
				</td>
				<td width="486">
				  <?php print $current_bid; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['319']; ?>
				</td>
				<td width="486">
				  <?php print $quantity; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['320']; ?>
				</td>
				<td width="486">
				  <?php print $reserve_price; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204" VALIGN="top" ALIGN="right">
				  <?php print $MSG['300']; ?>
				</td>
				<td width="486">
				  <?php
				  if ($suspended == 0)
				  print $MSG['029'];
				  else
				  print $MSG['030'];
				  ?>
				</td>
			  </tr>
			  <tr>
				<td width="204">&nbsp;</td>
				<td width="486">
				  <?php print $MSG['326']; ?>
				</td>
			  </tr>
			  <tr>
				<td width="204">&nbsp;</td>
				<td width="486">
				  <form NAME=details ACTION="deleteauction.php" METHOD="POST">
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
					<input type="hidden" name="offset" value="<?php echo $_REQUEST['offset']; ?>">
					<input type="hidden" name="action" value="Delete">
					<input type="submit" name="act" value="<?php print $MSG['008']; ?>">
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