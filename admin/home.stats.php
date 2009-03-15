<?php
	$query = "SELECT * FROM " . $DBPrefix . "counters";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$COUNTERS = mysql_fetch_array($res);
?>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=2 CELLSPACING=0 BGCOLOR="#FFFFFF" ALIGN="CENTER">
  <TR>
    	<TD>
	<A HREF=<?php echo basename($_SERVER['PHP_SELF']); ?>><?php echo $MSG['25_0025']; ?></A>
	</TD>
  </TR>
</TABLE>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=1 CELLSPACING=0 BGCOLOR="#0083D7" ALIGN="CENTER">
  <TR>
    <TD>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="4" CELLSPACING="1" BGCOLOR="#0083D7">
      <TR BGCOLOR="#0083D7">
        <TD COLSPAN="2" ALIGN=CENTER class=title><?php echo $MSG['25_0031']; ?></TD>
        </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0055']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $COUNTERS['users']; ?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0056']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $COUNTERS['inactiveusers']; ?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0057']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $COUNTERS['auctions']; ?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['354']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $COUNTERS['closedauctions']; ?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0059']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $COUNTERS['bids']; ?></B>
		</TD>
      </TR>
      <TR VALIGN=TOP>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0063']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
		<?php
			$query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE year = '".date("Y")."' AND month='".date("m")."' AND day='".date("d")."'";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
        	$ACCESS = mysql_fetch_array($res);
			$ACCESS['pageviews'] = (!isset($ACCESS['pageviews']) || empty($ACCESS['pageviews'])) ? 0 : $ACCESS['pageviews'];
			$ACCESS['uniquevisitors'] = (!isset($ACCESS['uniquevisitors']) || empty($ACCESS['uniquevisitors'])) ? 0 : $ACCESS['uniquevisitors'];
			$ACCESS['usersessions'] = (!isset($ACCESS['usersessions']) || empty($ACCESS['usersessions'])) ? 0 : $ACCESS['usersessions'];
		?>
			<?php echo $MSG['5161']; ?>: <B><?php echo $ACCESS['pageviews']; ?></B><BR>
			<?php echo $MSG['5162']; ?>: <B><?php echo $ACCESS['uniquevisitors']; ?></B><BR>
			<?php echo $MSG['5163']; ?>: <B><?php echo $ACCESS['usersessions']; ?></B><BR>
		</TD>
      </TR>
    </TABLE>
	</TD>
  </TR>
</TABLE>
