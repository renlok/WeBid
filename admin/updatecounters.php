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
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';


#// Retrieve current counters
$query = "SELECT * FROM " . $DBPrefix . "counters";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$COUNTERS = mysql_fetch_array($res);
}

require("./header.php");
?>
<link rel='stylesheet' type='text/css' href='style.css' />
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD>
<CENTER>
<BR>
<FORM NAME=conf ACTION=checkupdates.php METHOD=POST>
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#296FAB">
		<TR>
			<TD ALIGN=CENTER class=title>
				<?php print $MSG['1030']; ?>
			</TD>
		</TR>
		<TR>
			<TD>
				<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
					<TR VALIGN="TOP">
						<TD COLSPAN=3>
							<?php echo $MSG['1031'];?>
							</TD>
					</TR>
					<TR VALIGN="TOP">
						<TD COLSPAN=3>
							
							<BR><BR>
							USERS<BR>
							-----<BR>
							<?php
							$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "users WHERE suspended=0";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							$USERS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE " . $DBPrefix . "counters set users=$USERS";
							$res_ = mysql_query($query);
							$system->check_mysql($res_, $query, __LINE__, __FILE__);
							print "<I>active users</I> counter updated. New value is: $USERS<BR>";
							?>

							<?php
							$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "users WHERE suspended<>0";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							$USERS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE " . $DBPrefix . "counters set inactiveusers=$USERS";
							$res_ = mysql_query($query);
							$system->check_mysql($res_, $query, __LINE__, __FILE__);
							print "<I>inactive users</I> counter updated. New value is: $USERS<BR>";
							?>
							<BR>
							AUCTIONS<BR>
							--------<BR>
							<?php
							$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "auctions WHERE closed=0 and suspended=0 AND private='n'";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							$AUCTIONS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE " . $DBPrefix . "counters set auctions=$AUCTIONS";
							$res_ = mysql_query($query);
							$system->check_mysql($res_, $query, __LINE__, __FILE__);
							print "<I>active auctions</I> counter updated. New value is: $AUCTIONS<BR>";
							$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "auctions WHERE closed<>0 AND private='n'";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							$AUCTIONS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE " . $DBPrefix . "counters set closedauctions=$AUCTIONS";
							$res_ = mysql_query($query);
							$system->check_mysql($res_, $query, __LINE__, __FILE__);
							print "<I>closed auctions</I> counter updated. New value is: $AUCTIONS<BR>";
							$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "auctions WHERE closed=0 and suspended<>0 AND private='n'";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							$AUCTIONS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE " . $DBPrefix . "counters set suspendedauctions=$AUCTIONS";
							$res_ = mysql_query($query);
							$system->check_mysql($res_, $query, __LINE__, __FILE__);
							print "<I>suspended auctions</I> counter updated. New value is: $AUCTIONS<BR>";
							?>

							<BR>
							BIDS<BR>
							----<BR>
							<?php
							$query = "SELECT
										  a.id,
										  a.auction,
										  b.id
										  FROM
										  " . $DBPrefix . "bids a, " . $DBPrefix . "auctions b
										  WHERE
										  a.auction=b.id AND
										  b.closed=0 AND b.suspended=0 AND private='n'";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							$BIDS = mysql_num_rows($res);
							
							#// Update counters table
							$query = "UPDATE " . $DBPrefix . "counters set bids=$BIDS";
							$res_ = mysql_query($query);
							$system->check_mysql($res_, $query, __LINE__, __FILE__);
							print "<I>bids</I> counter updated. New value is: $BIDS<BR>";
							?>
							<BR>
							CATEGORIES<BR>
							----------<BR>
							<?php
							@mysql_query("UPDATE " . $DBPrefix . "categories set counter=0, sub_counter=0");
							print "Reset all categories counters<BR>";
							$query = "SELECT
										  a.cat_id, a.cat_name, a.parent_id, a.counter,a.sub_counter,
										  b.id, b.category
										  FROM
										  " . $DBPrefix . "categories a, " . $DBPrefix . "auctions b
										  WHERE
										  a.cat_id=b.category
										  AND
										  b.closed=0 AND b.suspended=0 AND private='n'";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
							while ($row = mysql_fetch_array($res))
							{
								
								
								$cat_id = $row[cat_id];
								
								do
								{
									// update counter for this category
									$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=\"$cat_id\"";
									$result = mysql_query($query);
									$system->check_mysql($result, $query, __LINE__, __FILE__);
									$CAT = mysql_fetch_array($result);
									if ($result)
									{
										if (mysql_num_rows($result) > 0)
										{
											$R_parent_id = $CAT[parent_id];
											$R_cat_id = $CAT[cat_id];
											$R_sub_name = $CAT[cat_name];
											$R_counter = intval(mysql_result($result,0,"counter"));
											$R_sub_counter = intval(mysql_result($result,0,"sub_counter"));
											
											$R_sub_counter++;
											if ( $cat_id == $root_cat )
											++$R_counter;
											
											if ($R_counter < 0) $R_counter = 0;
											if ($R_sub_counter < 0) $R_sub_counter = 0;
											
											$query = "UPDATE " . $DBPrefix . "categories SET counter='$R_counter', sub_counter='$R_sub_counter' WHERE cat_id=\"$cat_id\"";
											$res = mysql_query($query);
											$system->check_mysql($res, $query, __LINE__, __FILE__);
											
											$cat_id = $R_parent_id;
											print "Counter updated for category <I>$R_sub_name</I>. New value is: $R_sub_counter<BR>\n";
										}
									}
								}
								while ($cat_id!=0);
							}
							
	?>
							</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
	</FORM>
	<BR><BR>

	
	<A HREF="admin.php" CLASS="links">Admin Home</A>
	
	</CENTER>
	<BR><BR>

</TD>
</TR>
</TABLE>

<!-- Closing external table (header.php) -->
</TD>
</TR>
</TABLE>

<?php require("./footer.php"); ?>
</BODY>
</HTML>
