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

if (!isset($_GET['id']) && !isset($_POST['id'])) {
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header("Location: $URL");
	exit;
}

foreach ($_GET as $k=>$v){
  $var = $k;
  $$var = $v; 
}

foreach ($_POST as $k=>$v){
  $var = $k;
  $$var = $v; 
}

if ($action && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))){
	if ($mode == "activate") {
		$sql="UPDATE " . $DBPrefix . "auctions set suspended=0 WHERE id='$id'";
		if ($closed==1) {
			$counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET suspendedauction=(suspendedauction-1),closedauctions=(closedauctions+1)");
		} else if ($closed==0) {
			$counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET suspendedauction=(suspendedauction-1),auctions=(auctions+1)");
			$query = "select category from " . $DBPrefix . "auctions WHERE id='$id'";
			$res__ = mysql_query($query);
			if (!$res__) {
				print $ERR_001." $query<BR>".mysql_error();
				exit;
			} else {
				$cat_id = mysql_result($res__,0,"category");
			}
			// update "categories" table - for counters
			$root_cat = $cat_id;
			do {
				// update counter for this category
				$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=\"$cat_id\"";
				$result = mysql_query($query);
				
				if ($result) {
					if (mysql_num_rows($result)>0) {
						$R_parent_id = mysql_result($result,0,"parent_id");
						$R_cat_id = mysql_result($result,0,"cat_id");
						$R_counter = intval(mysql_result($result,0,"counter"));
						$R_sub_counter = intval(mysql_result($result,0,"sub_counter"));
						
						$R_sub_counter++;
						if ( $cat_id == $root_cat )
						++$R_counter;
						
						if ($R_counter < 0) $R_counter = 0;
						if ($R_sub_counter < 0) $R_sub_counter = 0;
						
						$query = "UPDATE " . $DBPrefix . "categories SET counter='$R_counter', sub_counter='$R_sub_counter' WHERE cat_id=\"$cat_id\"";
						$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
						
						$cat_id = $R_parent_id;
					}
				}
			} while ($cat_id!=0);
		}
	} else {
		$sql="UPDATE " . $DBPrefix . "auctions set suspended=1 WHERE id='$id'";
		/* Update column suspendedauction,auctions,closedauctions   in table " . $DBPrefix . "counters */
		if ($closed==1) {
			$counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET suspendedauction=(suspendedauction+1),closedauctions=(closedauctions-1)");
		} else if ($closed==0){
			$counteruser = mysql_query("UPDATE " . $DBPrefix . "counters SET suspendedauction=(suspendedauction+1),auctions=(auctions-1)");
			$query = "select category from " . $DBPrefix . "auctions WHERE id='$id'";
			$res__ = mysql_query($query);
			if (!$res__) {
				print $ERR_001." $query<BR>".mysql_error();
				exit;
			} else {
				$cat_id = mysql_result($res__,0,"category");
			}
			// update "categories" table - for counters
			$root_cat = $cat_id;
			do {
				// update counter for this category
				$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=\"$cat_id\"";
				$result = mysql_query($query);
				if ($result) {
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
				}
			} while ($cat_id!=0);
		}
	}
	$res=mysql_query($sql);
	$URL = $_SESSION['RETURN_LIST']."?offset=".$_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header("Location: $URL");
	exit;
}


if (!$action || ($action && $updated)){
	
	$query = "select a.id, u.nick, a.title, a.starts, a.description,
		c.cat_name, d.description as duration, a.suspended, a.current_bid,
		a.quantity, a.reserve_price, a.minimum_bid from " . $DBPrefix . "auctions
		a, " . $DBPrefix . "users u, " . $DBPrefix . "categories c, " . $DBPrefix . "durations d WHERE u.id = a.user and
		c.cat_id = a.category and d.days = a.duration and a.id=\"$id\"";
	$result = mysql_query($query);
	if (!$result) {
		print "Database access error: abnormal termination".mysql_error();
		exit;
	}
	
	
	$id = mysql_result($result,0,"id");
	$title = stripslashes(mysql_result($result,0,"title"));
	$nick = mysql_result($result,0,"nick");
	$tmp_date = mysql_result($result,0,"starts");
	$duration = mysql_result($result,0,"duration");
	$category = mysql_result($result,0,"cat_name");
	$description = stripslashes(mysql_result($result,0,"description"));
	$suspended = mysql_result($result,0,"suspended");
	$current_bid = mysql_result($result,0,"current_bid");
	$min_bid = mysql_result($result,0,"minimum_bid");
	$quantity = mysql_result($result,0,"quantity");
	$reserve_price = mysql_result($result,0,"reserve_price");
	
	$day = substr($tmp_date,6,2);
	$month = substr($tmp_date,4,2);
	$year = substr($tmp_date,0,4);
	$date = "$day/$month/$year";
	
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
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr>
		  <td width="30"><img src="images/i_auc.gif" ></td>
		  <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php if ($suspended > 0) {
				print $MSG['322'];
			} else {
				print $MSG['321'];
			} ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
	<td align="center" valign="middle"><table width="95%" border="0" cellspacing="1" cellpadding="1" bgcolor="#0083D7" align="center">
		<tr>
		  <td align="center" class=title>
			<?php
			if ($suspended > 0) {
				print $MSG['322'];
			} else {
				print $MSG['321'];
			}
			?>
			</B></td>
		</tr>
		<tr>
		  <td bgcolor="#FFFFFF">
		  <table width=100% CELPADDING=4 cellspacing=0 border=0 bgcolor="#FFFFFF">
					  <?php
					  if ($updated) {
					  ?>
					  <tr>
						<td></td>
						<td width=486>Auctions data updated</td>
					  </tr>
					  <?php
					  }
					  ?>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['312']; ?> </td>
						<td width="486"><?php print $title; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['313']; ?> </td>
						<td width="486"><?php print $nick; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['314']; ?> </td>
						<td width="486"><?php print $date; ?></td>
					  </tr>
					  <tr>
						<td width="204"  VALIGN="top" ALIGN="right"><?php print $MSG['315']; ?> </td>
						<td width="486"><?php print $duration; ?></td>
					  </tr>
					  <tr>
						<td width="204"  VALIGN="top" ALIGN="right"><?php print $MSG['316']; ?> </td>
						<td width="486"><?php print $category; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right">
						  <?php print $MSG['317']; ?> </td>
						<td width="486">
						  <?php print $description; ?> </td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['318']; ?> </td>
						<td width="486"><?php print $current_bid; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['327']; ?> </td>
						<td width="486"><?php print $min_bid; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['319']; ?> </td>
						<td width="486"><?php print $quantity; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['320']; ?> </td>
						<td width="486"><?php print $reserve_price; ?></td>
					  </tr>
					  <tr>
						<td width="204" VALIGN="top" ALIGN="right"><?php print $MSG['300']; ?> </td>
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
						  <?php
						  if ($suspended > 0) {
						  	print $MSG['324'];
						  	$mode = "activate";
						  } else {
						  	print $MSG['323'];
						  	$mode = "suspend";
						  }
										?>
						</td>
					  </tr>
					  <tr>
						<td width="204">&nbsp;</td>
						<td width="486"><form NAME=details ACTION="excludeauction.php" METHOD="POST">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="offset" value="<?php echo $offset; ?>">
							<input type="hidden" name="action" value="Delete">
							<input type="hidden" name="mode" value="<?php print $mode; ?>">
							<input type="submit" name="act" value="<?php print $MSG['030']; ?>">
						  </form></td>
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
