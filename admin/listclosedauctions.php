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
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
//-- Set offset and limit for pagination
$limit = 30;
if(!isset($_GET['offset'])) {
  $offset = 0;
} else {
  $offset = $_GET['offset'];
}
$PAGES = ceil($TOTALUSERS / $limit);
#// Set return script name
$_SESSION['RETURN_LIST'] = 'listclosedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = intval($_GET['offset']);


?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_auc.gif" ></td>
          <td class=white><?php echo $MSG['239']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5226']; ?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7" ALIGN="CENTER">
<TR>
  <TD ALIGN=CENTER class=title><?php print $MSG['5226']; ?></TD>
</TR>
<TR>
  <TD><TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN="CENTER" CELLPADDING="3">
      <?php
      $query = "select count(id) as auctions from " . $DBPrefix . "auctions WHERE closed<>'0' AND suspended='0'";
      $result = mysql_query($query);
      if(!$result){
      	print "$ERR_001<BR>$query<BR>".mysql_error();
      	exit;
      }
      $num_auctions = mysql_result($result,0,"auctions");
      print "<TR BGCOLOR=#FFFFFF><TD COLSPAN=7><B>
				$num_auctions ".$MSG['311']."</B> 
				</TD></TR>";
	?>
      <TR BGCOLOR="#FFCC00">
        <TD ALIGN=CENTER> <B> <?php print $MSG['312']; ?> </B>  </TD>
        <TD ALIGN=CENTER> <B> <?php print $MSG['313']; ?> </B>  </TD>
        <TD ALIGN=CENTER> <B> <?php print $MSG['314']; ?> </B>  </TD>
        <TD ALIGN=CENTER> <B> <?php print $MSG['315']; ?> </B>  </TD>
        <TD ALIGN=LEFT> <B> <?php print $MSG['316']; ?> </B>  </TD>
        <TD ALIGN=LEFT> <B> <?php print $MSG['317']; ?> </B>  </TD>
        <TD ALIGN=LEFT> <B> <?php print $MSG['297']; ?> </B>  </TD>
      </tr>
        <?php
					$query = "SELECT DISTINCT(a.id), a.closed, u.nick, a.title, a.starts, a.description, c.cat_name, d.description as duration, a.suspended
				  FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "users u, " . $DBPrefix . "categories c, " . $DBPrefix . "durations d
				  WHERE u.id = a.user and c.cat_id = a.category and d.days = a.duration AND a.closed<>'0' AND a.suspended='0'
				  ORDER BY u.nick limit $offset, $limit";
					$result = mysql_query($query);
					if(!$result){
						print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
						exit;
					}
					$num_auction = mysql_num_rows($result);
					$i = 0;
					$bgcolor = "#FFFFFF";
					while($i < $num_auction) {
						if($bgcolor == "#FFFFFF"){
							$bgcolor = "#EEEEEE";
						}else{
							$bgcolor = "#FFFFFF";
						}
						$id = mysql_result($result,$i,"id");
						
						$query = "SELECT id FROM " . $DBPrefix . "winners WHERE auction='$id'";
						$res_w = @mysql_query($query);
						if(!$res_w) {
							print "$query<BR>".mysql_error();
							exit;
						} elseif(@mysql_num_rows($res_w) > 0) {
							$HASWINNERS = TRUE;
						} else {
							$HASWINNERS = FALSE;
						}
						
						$title = stripslashes(mysql_result($result,$i,"title"));
						$nick = mysql_result($result,$i,"nick");
						$tmp_date = mysql_result($result,$i,"starts") + $system->tdiff;
						$duration = mysql_result($result,$i,"duration");
						$category = mysql_result($result,$i,"cat_name");
						$description = strip_tags(stripslashes(mysql_result($result,$i,"description")));
						$suspended = mysql_result($result,$i,"suspended");
						if($system->SETTINGS['datesformat'] == 'USA') {
							$date = gmdate('m/d/Y', $tmp_date);
						} else {
							$date = gmdate('d/m/Y', $tmp_date);
						}
						
						print "<TR BGCOLOR=$bgcolor>
					<TD>";
						if($suspended == 1) {
							print "<FONT COLOR=red><B>$title</B>";
						} else {
							print $title;
						}
						print "
						</TD>
						<TD>
						".$nick."
						
						</TD>
						<TD>
						".$date."
						
						</TD>
						<TD>
						$duration
						
						</TD>
						<TD>
						$category
						
						</TD>
						<TD>
						$description
						
						</TD>
						<TD ALIGN=LEFT>
						<A HREF=\"editauction.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['298']."</A><BR>
						<A HREF=\"deleteauction.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['008']."</A><BR>
						<A HREF=\"excludeauction.php?id=$id&offset=$offset\" class=\"nounderlined\">";
						if($suspended == 0) {
							print $MSG['300'];
						} else {
							print $MSG['310'];
						}
						if($HASWINNERS) {
							print "<BR><A HREF=\"viewwinners.php?id=$id&offset=$offset\" class=\"nounderlined\">".$MSG['_0163']."</A>";
						}
						print "</A><BR>
						</TD>
						<TR>";
						$i++;
					}
					?>
					</TABLE>
					<?php
					//-- Build navigation line
					print "<TABLE WIDTH=100% BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
			   <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
			   <TD COLSPAN=2>";
					print "<SPAN CLASS=\"navigation\">";
					$num_pages = ceil($num_auctions / $limit);
					$i = 0;
					while($i < $num_pages ){
						$of = ($i * $limit);
						if($of != $offset){
							print "<A HREF=\"listclosedauctions.php?offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
							if($i != $num_pages) print " | ";
						}else{
							print $i + 1;
							if($i != $num_pages) print " | ";
						}
						$i++;
					}
					print "</SPAN></TR></TD></table>";
					
	  ?>
    </td></tr>
	</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>