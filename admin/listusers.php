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

unset($ERR);

if (isset($_GET['resend']) && isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $_REQUEST['id'];
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) > 0) {
		$USER = mysql_fetch_array($res);
		
		$emailer = new email_class();
		$emailer->assign_vars(array(
				'SITENAME' => $system->SETTINGS['sitename'],
				'SITEURL' => $system->SETTINGS['siteurl'],
				'ADMINMAIL' => $system->SETTINGS['adminmail'],
				'CONFIRMURL' => $system->SETTINGS['siteurl'] . 'confirm.php?id=' . $USER['id'] . '&hash=' . md5($USER['nick']),
				'C_NAME' => $USER['name']
				));
		$emailer->email_uid = $USER['id'];
		$emailer->email_sender($useremail, 'usermail.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['098']);
		$ERR = $MSG['059'];
	}
}

if ($_GET['usersfilter'] == 'all') {
	unset($_SESSION['usersfilter']);
	unset($Q);
} elseif (isset($_GET['usersfilter'])) {
	switch($_GET['usersfilter']) {
		case 'active':
		$Q = 0;
		break;
		case 'admin':
		$Q = 1;
		break;
		case 'confirmed':
		$Q = 8;
		break;
		case 'fee':
		$Q = 9;
		break;
		case 'sellers':
		$account = 'seller';
		break;
		case 'buyers':
		$account = 'buyer';
		break;
	}
	$usersfilter = $_GET['usersfilter'];
	$_SESSION['usersfilter']=$usersfilter;
} elseif (!isset($_GET['usersfilter']) && isset($_SESSION['usersfilter'])) {
	switch($_SESSION['usersfilter']) {
		case 'active':
		$Q = 0;
		break;
		case 'admin':
		$Q = 1;
		break;
		case 'confirmed':
		$Q = 8;
		break;
		case 'fee':
		$Q = 9;
		break;
		case 'sellers':
		$account = 'seller';
		break;
		case 'buyers':
		$account = 'buyer';
		break;
	}
} else {
	unset($_SESSION['usersfilter']);
	unset($Q);
}


#// Retrieve active auctions from the database
if (isset($Q)) {
	$TOTALUSERS = mysql_result(mysql_query("select count(id) as COUNT from " . $DBPrefix . "users WHERE suspended=$Q"),0,"COUNT");
} elseif (isset($account)) {
	$TOTALUSERS = mysql_result(mysql_query("select count(id) as COUNT from " . $DBPrefix . "users WHERE accounttype='$account'"),0,"COUNT");
} else {
	$TOTALUSERS = mysql_result(mysql_query("select count(id) as COUNT from " . $DBPrefix . "users"),0,"COUNT");
}

//-- Set offset and limit for pagination
$LIMIT = 30;
if (!$offset) $offset = 0;

if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1 || !$_GET['PAGE']) {
	$OFFSET = 0;
	$PAGE = 1;
} else {
	$PAGE = $_GET['PAGE'];
	$OFFSET = ($_GET['PAGE'] - 1) * $LIMIT;
}
$PAGES = ceil($TOTALUSERS / $LIMIT);
$_SESSION['RETURN_LIST'] = 'listusers.php';
$_SESSION['RETURN_LIST_PAGE'] = intval($PAGE);

?>
<html>
<head>
<SCRIPT type="text/javascript">
function SubmitFilter()
{
	document.filter.submit();
}
</SCRIPT>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
	
}
</SCRIPT>
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
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
			<td align="center" class=title><?php print $MSG['045']; ?></td>
			</tr>
			<tr>
			<td>
				<table width=100% CELPADDING=0 cellspacing=1 border=0 align="center" cellpadding="3" bgcolor=#ffffff>
				<?php
				if (isset($ERR))
				{
				?>
				<tr bgcolor="yellow">
				  <td COLSPAN=8 align="center">
					<b><?php echo $ERR; ?></b>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
				<td COLSPAN=8>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
					<form NAME=search ACTION=userssearch.php method="post">
					<tr>
					<td bgcolor="#eeeeee"> 
					<BR>
					<?php echo $MSG['5022']; ?> <input type=text NAME=keyword SIZE=25>
					<input type=SUBMIT name=SUBMIT value="<?php echo $MSG['5023']; ?>">
					<?php echo $MSG['5024']; ?>
					</td>
					</tr>
					</form>
					</table>
				</td>
				</tr>
				<tr bgcolor=#FFFFFF>
				<td COLSPAN=8>
				<table width=100% cellpadding=1 cellspacing=0 border=0>
					<form name="filter" ACTION="<?php echo basename($_SERVER['PHP_SELF']); ?>">
				  <tr>
					<td width=30%> <B>
					<?php echo $TOTALUSERS." ".$MSG['301']; ?>
					</B> </td>
					<td width=20% valign="center">
					<td width=50% align=right>
					<?php echo $MSG['5295']; ?>
					<SELECT NAME=usersfilter onChange="SubmitFilter()">
					<OPTION VALUE=all>
					<?php echo $MSG['5296']; ?>
					</OPTION>
					<OPTION VALUE=active <?php if ($_SESSION['usersfilter'] == 'active') print " selected"?>>
					<?php echo $MSG['5291']; ?>
					</OPTION>
					<OPTION VALUE=admin <?php if ($_SESSION['usersfilter'] == 'admin') print " selected"?>>
					<?php echo $MSG['5294']; ?>
					</OPTION>
					<OPTION VALUE=fee <?php if ($_SESSION['usersfilter'] == 'fee') print " selected"?>>
					<?php echo $MSG['5293']; ?>
					</OPTION>
					<OPTION VALUE=confirmed <?php if ($_SESSION['usersfilter'] == 'confirmed') print " selected"?>>
					<?php echo $MSG['5292']; ?>
					</OPTION>
					<?php
					if ($system->SETTINGS['accounttype'] == 'sellerbuyer') {
					?>
					<OPTION VALUE=sellers <?php if ($_SESSION['usersfilter'] == 'sellers') print " selected"?>>
					<?php echo $MSG['25_0138']; ?>
					</OPTION>
					<OPTION VALUE=buyers <?php if ($_SESSION['usersfilter'] == 'buyers') print " selected"?>>
					<?php echo $MSG['25_0139']; ?>
					</OPTION>
					<?php
					}
					?>
					</SELECT>
					</td>
				  </tr>
				  </form>
				  </table>
				</td>
				</tr>
				<tr bgcolor="#FFCC00">
					<td ALIGN=LEFT width="20%"> <B> <?php print $MSG['293']; ?> </B>  </td>
					<td ALIGN=LEFT width="30%"> <B> <?php print $MSG['294']; ?> </B>  </td>
					<td ALIGN=LEFT width="10%"> <B> <?php print $MSG['295']; ?> </B>  </td>
					<td ALIGN=LEFT width="10%"> <B> <?php print $MSG['296']; ?> </B>  </td>
					<td ALIGN=LEFT width="10%"> <B> <?php print strtoupper($MSG['25_0079']); ?> </B>  </td>
					<td ALIGN=LEFT width="10%"> <B> <?php print strtoupper($MSG['560']); ?> </B>  </td>
					<td ALIGN=LEFT width="10%"> <B> <?php print $MSG['297']; ?> </B>  </td>
				</tr>
				<?php
				if (isset($Q)) {
					$query = "select * from " . $DBPrefix . "users WHERE suspended=$Q order by nick limit $OFFSET, $LIMIT";
				} elseif (isset($account)) {
					$query = "select * from " . $DBPrefix . "users WHERE accounttype='$account' order by nick limit $OFFSET, $LIMIT";
				} else {
					$query = "select * from " . $DBPrefix . "users order by nick limit $OFFSET, $LIMIT";
				}
				$result = mysql_query($query);
				if (!$result) {
					print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
					exit;
				}
				$num_users = mysql_num_rows($result);
				$i = 0;
				$bgcolor = "#FFFFFF";
				while ($i < $num_users){
					if ($bgcolor == "#FFFFFF"){
						$bgcolor = "#EEEEEE";
					}else{
						$bgcolor = "#FFFFFF";
					}
					$id = mysql_result($result,$i,"id");
					$nick = mysql_result($result,$i,"nick");
					$name = mysql_result($result,$i,"name");
					$country = mysql_result($result,$i,"country");
					$email = mysql_result($result,$i,"email");
					$suspended = mysql_result($result,$i,"suspended");
					$newsletter = mysql_result($result,$i,"nletter");

					print "<tr bgcolor=$bgcolor>
					<td>$nick</td>
					<td>$name</td>
					<td>$country</td>
					<td><A HREF=\"mailto:$email\">$email</A></td>
					<td align=center>";
					if ($newsletter == 1) {
						print $MSG['030'];
					}
					if ($newsletter == 2) {
						print $MSG['029'];
					}
					print "</td><td>";
					if ($suspended == 0) {
						print "<B><FONT COLOR=green>".$MSG['5291']."</B>";
					}
					if ($suspended == 1) {
						print "<B><FONT COLOR=violet>".$MSG['5294']."</B>";
					}
					if ($suspended == 7) {
						print "<B><FONT COLOR=red>".$MSG['5297']."</B>";
					}
					if ($suspended == 8) {
						print '<B><FONT COLOR=orange>'.$MSG['5292'].'</B>
							   <BR><a href="listusers.php?resend=1&id=' . $id . '">' . $MSG['25_0074'] . '</a>';
					}
					if ($suspended == 9) {
						print "<B><FONT COLOR=red>".$MSG['5293']."</B>";
					}
					if ($suspended == 10) {
						print "<B><FONT COLOR=orange><A HREF=\"excludeuser.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['25_0136']."</A>";
					}
					print "</td>";
					print "<td ALIGN=LEFT>
					<A HREF=\"edituser.php?userid=$id&offset=$offset\" class=\"nounderlined\">".$MSG['298']."</A><BR>
					<A HREF=\"deleteuser.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['008']."</A><BR>
					<A HREF=\"excludeuser.php?id=$id&offset=$offset\" class=\"nounderlined\">";
					if ($suspended == 0) {
						print $MSG['300'];
					} else {
						print $MSG['310'];
					}
					print "</A><BR>
					<A HREF=\"viewuserauctions.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['5094']."</A><BR>
					<A HREF=\"userfeedback.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['503']."</A><BR>
					<A HREF=\"viewuserips.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['2_0004']."</A>
					</td>
					</tr>";
					$i++;
				}
				?>
				</table>
				<center class=white><?php echo $MSG['5117']; ?>&nbsp;<?php echo $PAGE; ?>&nbsp;<?php echo $MSG['5118']; ?>&nbsp;<?php echo $PAGES; ?>
				<BR>
				<?php
				$PREV = intval($PAGE - 1);
				$NEXT = intval($PAGE  + 1);
				?>
				<?php
				if ($PAGES > 1) {
					if ($PAGE > 1) {
				?>
			  	<A HREF="?PAGE=<?php echo $PREV; ?>"><U><SPAN CLASS=white>
				<?php echo $MSG['5119']; ?>
				</SPAN></U></a> &nbsp;&nbsp;
				<?php
				}
				?>
				<?php
				$LOW = $PAGE - 5;
				if ($LOW <= 0) $LOW = 1;
				$COUNTER = $LOW;
				while ($COUNTER <= $PAGES && $COUNTER < ($PAGE+6)) {
				if ($PAGE == $COUNTER) {
					print "<B>$COUNTER</B>&nbsp;&nbsp;";
				} else {
					print "<A HREF=\"?PAGE=$COUNTER\"><U><SPAN CLASS=white>$COUNTER</SPAN></U></A>&nbsp;&nbsp;";
				}
				$COUNTER++;
				}
				?>
				&nbsp;&nbsp;
				<?php
				if ($PAGE < $PAGES) {
				?>
	  			<A HREF="?PAGE=<?php echo $NEXT; ?>"><U><SPAN CLASS=white>
				  <?php echo $MSG['5120']; ?>
				  </SPAN></U></A> 
				<?php
					}
				}
				?>
				</center>
				</td>
			  </tr>
			</table>
			<BR>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
</body>
</html>
