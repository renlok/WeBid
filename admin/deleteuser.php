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
include "../includes/common.inc.php";
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $include_path."countries.inc.php";

$username = $name;
$id = intval($_REQUEST['id']);

//-- Data check
if (!$_REQUEST[id]) {
	header("Location: listusers.php");
	exit;
}

if (isset($_POST['action']) && $_POST['action'] && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))) {
	$ERR_CODE = 1;
	
	//-- Check if the users has some auction
	$query = "select * from " . $DBPrefix . "auctions WHERE user='$id'";
	
	$result = mysql_query($query);
	if (!$result) {
		print "Database access error: abnormal termination".mysql_error();
		exit;
	}
	
	$num_auctions = mysql_num_rows($result);
	if ($num_auctions > 0) {
		
		$ERR = "The user is the SELLER in the following auctions:<BR>";
		$i =  0;
		while ($i < $num_auctions) {
			$ERR_CODE=2;
			$ERR .= mysql_result($result,$i,"id")."<BR>";
			$i++;
		}
	}
	
	//-- Check if the user is BIDDER in some auction
	$query = "select * from " . $DBPrefix . "bids WHERE bidder='$id'";
	$result = mysql_query($query);
	if (!$result) {
		print "Database access error: abnormal termination".mysql_error();
		exit;
	}
	
	$num_auctions = mysql_num_rows($result);
	if ($num_auctions > 0) {
		$ERR_CODE=1;
		$ERR = "The user placed a bid in the following auctions:<BR>";
		$i =  0;
		while ($i < $num_auctions){
			$ERR .= mysql_result($result,$i,"bidder")."<BR>";
			$i++;
		}
	}
	
	//-- check if user is suspended or not
	$suspend = mysql_query("select suspended from " . $DBPrefix . "users WHERE id=\"$id\"");
	if (!$suspend){
		print "Database access error: abnormal termination".mysql_error();
		exit;
	}
	$myrow=mysql_fetch_array($suspend);
	$suspended = $myrow['suspended'];
	
	if ($ERR_CODE==1) {
		//-- delete user
		$sql="delete from " . $DBPrefix . "users WHERE id='$id'";
		$res=mysql_query($sql);
		//-- delete user bids
		$decremsql = mysql_query("select * FROM " . $DBPrefix . "bids WHERE bidder='$id'");
		$bid_decrem = mysql_num_rows($decremsql);
		$sql="delete from " . $DBPrefix . "bids WHERE bidder='$id'";
		$res=mysql_query($sql);
		//-- delete user's auctions
		$decremsql = mysql_query("select * FROM " . $DBPrefix . "auctions WHERE user='$id'");
		$row=mysql_fetch_array($decremsql);
		// update "categories" table - for counters
		$cat_id = $row['category'];
		$root_cat = $cat_id;
		do {
			$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=\"$cat_id\"";
			$result = mysql_query($query);
			if ( $result ) {
				if ( mysql_num_rows($result)>0 ) {
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
					if ( !mysql_query($query) )	errorLogSQL();
					
					$cat_id = $R_parent_id;
				}
			}
		} while ($cat_id!=0);
		
		$auction_decrem = mysql_num_rows($decremsql);
		$sql = "delete from " . $DBPrefix . "auctions WHERE user='$id'";
		$res=mysql_query($sql);
		
		//-- Update counters
		if ($suspended == 0) {
			$query = mysql_query("UPDATE " . $DBPrefix . "counters set users=(users-1), bids=(bids-$bid_decrem), auctions=(auctions-$auction_decrem)");
		} elseif ($suspended == 1) {
			$query = mysql_query("UPDATE " . $DBPrefix . "counters set users=(users-1), inactiveusers=(inactiveusers-1), bids=(bids-$bid_decrem), auctions=(auctions-$auction_decrem)");
		}
		$URL = $_SESSION['RETURN_LIST']."?PAGE=".$_SESSION['RETURN_LIST_PAGE'];
		unset($_SESSION['RETURN_LIST']);
		header("Location: $URL");
		exit;
	}
	if ($ERR_CODE == 2) {
		//-- delete user
		$sql="delete from " . $DBPrefix . "users WHERE id='$id'";
		$res=mysql_query($sql);
		$suspended = mysql_result( $res, 0, "suspended" );
		//-- delete user auctions
		$sql="delete from " . $DBPrefix . "auctions WHERE user='$id'";
		$res=mysql_query($sql);
		//-- Update counters
		if ($suspended == 0){
			$query = mysql_query("UPDATE " . $DBPrefix . "counters set users=(users-1)");
		} elseif ($suspended==1) {
			$query = mysql_query("UPDATE " . $DBPrefix . "counters set inactiveusers=(inactiveusers-1)");
		}
		$URL = $_SESSION['RETURN_LIST']."?PAGE=".$_SESSION['RETURN_LIST_PAGE'];
		unset($_SESSION['RETURN_LIST']);
		header("Location: $URL");
		exit;	}
}


if (!$_POST['action'] || ($_POST['action'] && $ERR)) {
	$query = "select * from " . $DBPrefix . "users WHERE id=".intval($id);
	$result = mysql_query($query);
	if (!$result) {
		print "Database access error: abnormal termination".mysql_error();
		exit;
	}
	
	$username = mysql_result($result,0,"name");
	
	$nick = mysql_result($result,0,"nick");
	$password = mysql_result($result,0,"password");
	$email = mysql_result($result,0,"email");
	$address = mysql_result($result,0,"address");
	
	$country = mysql_result($result,0,"country");
	$country_list="";
	foreach ($countries as $code => $descr)
	{
		$country_list .= "<option value=\"$descr\"";
		if ($descr == $country) {
			$country_list .= " selected";
		}
		$country_list .= ">$descr</option>\n";
	};
	
	$prov = mysql_result($result,0,"prov");
	$zip = mysql_result($result,0,"zip");
	
	$birthdate = mysql_result($result,0,"birthdate");
	$birth_day = substr($birthdate,6,2);
	$birth_month = substr($birthdate,4,2);
	$birth_year = substr($birthdate,0,4);
	$birthdate = "$birth_day/$birth_month/$birth_year";
	
	$phone = mysql_result($result,0,"phone");
	$suspended = mysql_result($result,0,"suspended");
	
	$rate_num = mysql_result($result,0,"rate_num");
	$rate_sum = mysql_result($result,0,"rate_sum");
	if ($rate_num) {
		$rate = round($rate_sum / $rate_num);
	} else {
		$rate=0;
	}
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
		  <td class=white><?php echo $MSG['25_0010']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['045']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">

<table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="CENTER">
		<tr>
		  <td align=CENTER class=title><?php print $MSG['304']; ?></td>
		</tr>
		<tr>
		  <td><table width=100% border=0 cellpadding="4" cellspacing=0 bgcolor="#FFFFFF" celpadding=4>
					<tr>
					  <td align=CENTER colspan=5><br>
						<br>
					  </td>
					</tr>
					<table width="100%" border="0" cellpadding="5" bgcolor=#FFFFFF>
					  <?php
					  if ($ERR) {
?>
					  <tr>
						<td width="204" valign="top" align="right"></td>
						<td width="486"><?php print $ERR; ?> </td>
					  </tr>
					  <?php
					  }
?>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['302']; ?> </td>
						<td width="486"><?print $username; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['003']; ?> </td>
						<td width="486"><?php print $nick; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['004']; ?> </td>
						<td width="486"><?php print $password; ?> </td>
					  </tr>
					  <tr>
						<td width="204"  valign="top" align="right"><?php print $MSG['303']; ?> </td>
						<td width="486"><?php print $email; ?> </td>
					  </tr>
					  <tr>
						<td width="204"  valign="top" align="right"><?php print $MSG['252']; ?> </td>
						<td width="486"><?php print $birthdate; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['009']; ?> </td>
						<td width="486"><?php print $address; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['014']; ?> </td>
						<td width="486"><?php print $country; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['012']; ?> </td>
						<td width="486"><?php print $zip; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['013']; ?> </td>
						<td width="486"><?php print $phone; ?> </td>
					  </tr>
					  <tr>
						<td width="204" valign="top" align="right"><?php print $MSG['300']; ?> </td>
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
						<td width="204" valign="top" align="right">&nbsp;</td>
						<td width="486">
						<A HREF=userfeedback.php?id=<?php echo $id; ?>><?php echo $MSG['208']; ?></A>
						</td>
					  </tr>
					  <tr>
						<td width="204">&nbsp;</td>
						<td width="486"><?php print $MSG['307']; ?> </td>
					  </tr>
					  <tr>
						<td width="204">&nbsp;</td>
						<td width="486"><form name=details action="deleteuser.php" method="POST">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="offset" value="<?php echo $_GET['offset']; ?>">
							<input type="hidden" name="action" value="Delete">
							<input TYPE="submit" name="act" value="<?php print $MSG['008']; ?>">
						  </form></td>
					</table>
				  </table></td>
		</tr>
	  </table>
</td>
</tr>
</table>
</body>
</html>