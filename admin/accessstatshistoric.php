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

$ABSOLUTEWIDTH = 650;
$MAX = 0;
$TOTAL_PAGEVIEWS = 0;
$TOTAL_UNIQUEVISITORS = 0;
$TOTAL_USERSESSIONS = 0;

// Retrieve data
$query = "SELECT year FROM " . $DBPrefix . "accesseshistoric GROUP BY year ORDER BY year desc ";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($year = mysql_fetch_array($res))
{
	$YEARS[] = $year['year'];
	
	$query = "SELECT * FROM " . $DBPrefix . "accesseshistoric WHERE year='$year[year]' ORDER BY month DESC";
	$r = mysql_query($query);
	$system->check_mysql($r, $query, __LINE__, __FILE__);
	while ($month = mysql_fetch_array($r))
	{
		$PAGEVIEWS[$year['year']][$month['month']] = $month['pageviews'];
		if ($month['pageviews'] > $MAX) $MAX = $month['pageviews'];
		$TOTAL_PAGEVIEWS += $month['pageviews'];
		
		$UNIQUEVISITORS[$year['year']][$month['month']] = $month['uniquevisitiors'];
		if ($month['uniquevisitiors'] > $MAX) $MAX = $month['uniquevisitiors'];
		$TOTAL_UNIQUEVISITORS += $month['uniquevisitiors'];
		
		$USERSESSIONS[$year['year']][$month['month']] = $month['usersessions'];
		if ($month['usersessions'] > $MAX) $MAX = $month['usersessions'];
		$TOTAL_USERSESSIONS += $month['usersessions'];
	}
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_sta.gif" ></td>
		  <td class=white><?php echo $MSG['25_0023']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5143']; ?></td>
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
		  <?php echo $MSG['5158'] . '<I>' . $system->SETTINGS['sitename'] . '</I>'; ?>
		  </b> <BR>
		  <?php echo $MSG['5281']; ?></p>
		<p>
			<A HREF=viewbrowserstats.php?><?php echo $MSG['5165']; ?></A> |
			<A HREF=viewdomainstats.php?><?php echo $MSG['5166']; ?></A> |
			<A HREF=viewplatformstats.php?><?php echo $MSG['5318']; ?></A>
			</p>
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
		<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF">
		  <tr>
			<td><b>
			  <?php echo strtoupper($MSG['5164']); ?>
			  </b></td>
		  </tr>
		  <tr>
			<td>
			  <table border=0 callpadding=0 cellspacing=0 width=250 bgcolor=red>
				<tr>
				  <td width="22" bgcolor="#006699">&nbsp;</td>
				  <td bgcolor="#FFFFFF" width="144"><b>&nbsp;
					<?php echo $MSG['5161']; ?>
					: </b></td>
				  <td bgcolor="#FFFFFF" width="78"><b>
					<?php echo $TOTAL_PAGEVIEWS; ?>
					</b></td>
				</tr>
			  </table>
			  <table border=0 callpadding=0 cellspacing=0 width=250 bgcolor=orange>
				<tr>
				  <td width="22" bgcolor="#66CC00">&nbsp;</td>
				  <td bgcolor="#FFFFFF" width="144"><b>&nbsp;
					<?php echo $MSG['5162']; ?>
					: </b></td>
				  <td bgcolor="#FFFFFF" width="78"><b>
					<?php echo $TOTAL_UNIQUEVISITORS; ?>
					</b></td>
				</tr>
			  </table>
			  <table border=0 callpadding=0 cellspacing=0 width=250 bgcolor=yellow>
				<tr>
				  <td width="22">&nbsp;</td>
				  <td bgcolor="#FFFFFF" width="144"><b><font color="#000000">&nbsp;
					<?php echo $MSG['5163']; ?>
					:<b><font color="#000000">
					</b></td>
				  <td bgcolor="#FFFFFF" width="78">
		  	<b><font color="#000000">
					<?php echo $TOTAL_USERSESSIONS; ?>
					</b>
			</font>
				  </td>
				</tr>
			  </table>
			  &nbsp;&nbsp;&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr bgcolor=#FFFFFF>
	  <td width="80">&nbsp;</td>
	  <td width="692">&nbsp;</td>
	</tr>
	<tr bgcolor="#CCCCCC">
	  <td align=CENTER width="80" height="21">
		<b>
		<?php echo $MSG['5280']; ?>
		</b>  </td>
	  <td align=right height="21" width="692">
		<a href="viewaccessstats.php">
		<?php echo $MSG['5282']; ?>
		</a>  </td>
	  <?php
	  if (is_array($PAGEVIEWS))
	  {
	  	while (list($k,$v) = each($PAGEVIEWS))
	  	{
		?>
			<tr bgcolor=yellow >
				<td COLSPAN=2><B><?php echo $k; ?></B></td>
			</tr>
			<?php
			while (list($t,$y) = each($v))
			{
			?>
			<tr bgcolor=#eeeeee>
			  <td width="80" align="center"><b>
				<?php echo $t; ?>
				</b> </td>
			  <td width="692">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="89%">
					  <?php $WIDTH = ( $PAGEVIEWS[$k][$t] * $ABSOLUTEWIDTH ) / $MAX; ?>
					  
					  <table border=0 CALLPADDING=0 cellspacing=0 width=<?php echo intval($WIDTH); ?> bgcolor=#006699>
						<tr>
						  <td><B><FONT COLOR=white>
							<?php echo $PAGEVIEWS[$k][$t]; ?>
							</B></td>
						</tr>
					  </table>
					</td>
				  </tr>
				  <tr>
					<td width="89%">
					  <?php $WIDTH = ( $UNIQUEVISITORS[$k][$t] * $ABSOLUTEWIDTH ) / $MAX; ?>
					  
					  <table border=0 CALLPADDING=0 cellspacing=0 width=<?php echo intval($WIDTH); ?> bgcolor=#66CC00>
						<tr>
						  <td><B><FONT COLOR=white>
							<?php echo $UNIQUEVISITORS[$k][$t]; ?>
							</B></td>
						</tr>
					  </table>
					</td>
				  </tr>
				  <tr>
					<td width="89%">
					  <?php $WIDTH = ( $USERSESSIONS[$k][$t] * $ABSOLUTEWIDTH ) / $MAX;?>
					  
					  <table border=0 CALLPADDING=0 cellspacing=0 width=<?php echo intval($WIDTH); ?> bgcolor=#FFFF33>
						<tr>
						  <td><B>
							<?php echo $USERSESSIONS[$k][$t]; ?>
							</B></td>
						</tr>
					  </table>
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