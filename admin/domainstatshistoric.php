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
include $include_path.'domains.inc.php';

$ABSOLUTEWIDTH = 550;

#// Retrieve data
$query = "SELECT year FROM " . $DBPrefix . "currentdomains WHERE (year<>".date("Y")."
			  OR (year=".date("Y")." AND month<>".date("m").")) GROUP BY year ORDER BY year desc";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($year = mysql_fetch_array($res))
{
	$query = "SELECT * FROM " . $DBPrefix . "currentdomains WHERE year=".$year[year]." AND month<>'".date("m")."' GROUP BY month ORDER BY month desc";
	$r_ = mysql_query($query);
	$system->check_mysql($r_, $query, __LINE__, __FILE__);
	//print $year[year]."<BR>";
	while ($month = mysql_fetch_array($r_))
	{
		$YEARS[$year['year']][$month['month']] = $month['month'];
	}
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<STYLE type="text/css">
<!--
.unnamed1 {  font: 10pt Tahoma, Arial; color: #000066; text-decoration: none}
-->
</STYLE>


<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_sta.gif" ></td>
		  <td class=white><?php echo $MSG['25_0023']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5166']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
  <table width=95% cellpadding=2 cellspacing=1 border=0 align="center">
	<tr bgcolor="#FFCC00">
	  <td align="center" colspan="2" bgcolor="#eeeeee">
		<p class="title" style="color:#000000">
		  <?php echo $MSG['5168'].'<I>'.$system->SETTINGS['sitename'].'</I>'; ?>
		  </b> <BR>
		  <B>
		  <?php echo $MSG['5281']; ?>
		  </B></p>
		<p>
			<A HREF=viewaccessstats.php?><?php echo $MSG['5143']; ?></A> |
			<A HREF=viewbrowserstats.php?><?php echo $MSG['5165']; ?></A> |
			<A HREF=viewplatformstats.php?><?php echo $MSG['5318']; ?></A>
			</p>
	  </td>
	</tr>
	<tr bgcolor=#FFFFFF>
	  <td width="146">&nbsp;</td>
	  <td width="626">&nbsp;</td>
	</tr>
	<tr bgcolor="#CCCCCC">
	  <td width="146" height="21">
		<b>
		<?php echo $MSG['5280']; ?>
		</b>  </td>
	  <td align=right height="21" width="626"> 
		<a href="viewdomainstats.php">
		<?php echo $MSG['5282']; ?>
		</a>  </td>
	  <?php
	  if (is_array($YEARS))
	  {
	  	while (list($k,$v) = each($YEARS))
	  	{
		?>
			<tr bgcolor=yellow>
				<td COLSPAN=2 >
					<B><?php echo $k; ?></B>
				</td>
			</tr>
			<?php
			while (list($t,$z) = each($v))
			{
			?>
			<tr bgcolor=#eeeeee>

	  <td>
	  	<b>
		<?php echo $t; ?>
		</b> </td>

	  <td width="626">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="600"> 
			  <?php
			  $query = "SELECT domain,counter
				   			 FROM " . $DBPrefix . "currentdomains
				   		 	 WHERE year='$k' AND month='$t'";
			  $RR = mysql_query($query);
			  $system->check_mysql($RR, $query, __LINE__, __FILE__);
			  
			  	while ($row = mysql_fetch_array($RR))
			  	{
			  		$query = "SELECT max(counter) as MAX, sum(counter) as TOTAL
				   					  FROM " . $DBPrefix . "currentdomains
				   		 			  WHERE year='$k' AND month='$t'";
			  		$R___ = @mysql_query($query);
			  		$MAX = mysql_result($R___,0,"MAX");
			  		$TOTAL = mysql_result($R___,0,"TOTAL");
			  		
			  		$WIDTH = ( $row[counter] * $ABSOLUTEWIDTH ) / $MAX;
			  		$PERCENAGE = ceil(intval($row[counter] * 100 / $TOTAL));
			  		
					   ?>
							
							
							<B><?php echo $row[domain]; ?></B> <?php echo "(".$DOMAINS[$row[domain]].")"; ?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="2%">
								  <table border=0 callpadding=0 cellspacing=0 width=<?php echo intval($WIDTH); ?> bgcolor=#66CC00>
									<tr>
									  <td>&nbsp; </td>
									</tr>
								  </table>
								</td>
								<td width="98%">
								  &nbsp;<?php echo $PERCENAGE; ?>
								  % </td>
							  </tr>
							</table>
			<?php
			  	}
			?>
			</td>
		  </tr>
		</table>
			  </td>
			</tr>
			<?php
			}
	  	}
	  }
		?>
  </table>
  </td>
  </tr>
  </table>
  </body>
  </html>