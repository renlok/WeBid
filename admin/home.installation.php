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

?>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=2 CELLSPACING=0 BGCOLOR="#FFFFFF" ALIGN="CENTER">
  <TR>
    <TD>
		<A HREF=<?php echo basename($_SERVER['PHP_SELF']); ?>?show=stats><?php echo $MSG['25_0031']; ?></A>
	</TD>
  </TR>
</TABLE>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=1 CELLSPACING=0 BGCOLOR="#0083D7" ALIGN="CENTER">
  <TR>
    <TD>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="4" CELLSPACING="1" BGCOLOR="#0083D7">
      <TR BGCOLOR="#0083D7">
        <TD COLSPAN="2" ALIGN=CENTER class=title><?php echo $MSG['25_0025']; ?></TD>
        </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['528']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $system->SETTINGS['siteurl']; ?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['527']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo stripslashes($system->SETTINGS['sitename']); ?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['540']; ?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?php echo $system->SETTINGS['adminmail']; ?></B>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0026']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				if($system->SETTINGS['cron'] == '1') {
					print "<B>".$MSG['373']."</B><BR>".$MSG['25_0027'];
				} else {
					print "<B>".$MSG['374']."</B>";
				}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['663']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				if($system->SETTINGS['picturesgallery'] == '1') {
					print "<B>".$MGS_2__0066."</B><BR>".$MSG['666'].": ".$system->SETTINGS['maxpictures']."<BR>".$MSG['671'].": ".$system->SETTINGS['maxpicturesize'];
				} else {
					print "<B>".$MGS_2__0067."</B>";
				}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['2__0025']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				if($system->SETTINGS['buy_now'] != '1') {
					print "<B>".$MGS_2__0066."</B>";
				} else {
					print "<B>".$MGS_2__0067."</B>";
				}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['5008']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?	
				print "<B>".$system->SETTINGS['currency']."</B>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0035']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?	
				if($system->SETTINGS['timecorrection'] == 0) {
					print "<B>".$MSG['25_0036']."</B>";
				} else {
					print "<B>".$system->SETTINGS['timecorrection'].$MSG['25_0037']."</B>";
				}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['363']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?	
				print "<B>".$system->SETTINGS['datesformat']."</B>";
				if($system->SETTINGS['datesformat'] == 'USA') {
					print " (".$MSG['382'].")";
				} else {
					print " (".$MSG['383'].")";
				}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['5322']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?	
				print "<B>".$system->SETTINGS['defaultcountry']."</B>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['2__0057']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				print $MSG['25_0038'];
				$counters = @mysql_fetch_Array(@mysql_query("SELECT * FROM " . $DBPrefix . "counterstoshow"));
				print "<B>";
				if($counters['auctions'] == 'y') {
					print $MGS_2__0060."<BR>";
				}
				if($counters['users'] == 'y') {
					print $MGS_2__0061."<BR>";
				}
				if($counters['online'] == 'y') {
					print $MGS_2__0059;
				}
				print "</B>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['2__0002']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				while(list($k,$v) = each($LANGUAGES)) {
					print "<B>".$v."</B>";
					if($k == $system->SETTINGS['defaultlanguage']) {
						print " (".$MGS_2__0005.")";
					}
					print "<BR>";
				}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0040']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				print "<B>".$system->SETTINGS['alignment']."</B>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MGS_2__0051; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				print "<B>".$system->SETTINGS['pagewidth'];
				if($system->SETTINGS ['pagewidthtype'] == 'perc') {
					print "%";
				} else {
					print " ".$MSG['5224'];
				}
				print "</B>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0041']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				print $MSG['5013'].":<B> ".$system->SETTINGS ['lastitemsnumber']."</B><BR>";
				print $MSG['5015'].":<B> ".$system->SETTINGS ['higherbidsnumber']."</B><BR>";
				print $MSG['5017'].":<B> ".$system->SETTINGS ['endingsoonnumber']."</B><BR>";
				print $MSG['25_0042'].":<B> ";
				if($system->SETTINGS ['loginbox'] == '1') {
					print $MSG['030'];
				} else {
					print $MSG['029'];
				}
				print "</B><BR>";
				print $MSG['25_0043'].":<B> ";
				if($system->SETTINGS ['newsbox'] == '1') {
					print $MSG['030']."</B>";
					print " - ".$MSG['25_0044'].":<B> ".$system->SETTINGS['newstoshow']."</B>";
				} else {
					print $MSG['029'];
				}
				print "</B><BR>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0045']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
				print $MSG['25_0048'].":<B> ".$system->SETTINGS ['thumb_show']." ".$MSG['5224']."</B>";
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['_0025']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
			if($system->SETTINGS ['banners'] == 1) {
				print "<B>".$MGS_2__0066."</B>";
			} else {
				print "<B>".$MGS_2__0067."</B>";
			}
			?>
		</TD>
      </TR>
      <TR>
        <TD VALIGN=TOP WIDTH="29%" BGCOLOR=#FFFFFF>
			<?php echo $MSG['25_0049']; ?>
		</TD>
        <TD VALIGN=TOP WIDTH="71%" BGCOLOR=#FFFFFF>
			<?php
			if($system->SETTINGS ['newsletter'] == 1) {
				print "<B>".$MGS_2__0066."</B>";
			} else {
				print "<B>".$MGS_2__0067."</B>";
			}
			?>
		</TD>
      </TR>
    </TABLE>
	</TD>
  </TR>
</TABLE>
