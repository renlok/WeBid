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
$current_page = 'stats';
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

// Retrieve data
$query = "SELECT * FROM " . $DBPrefix . "currentbrowsers WHERE month = " . date('n') . " AND year = " . date('Y') . " ORDER BY counter DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$MAX = 0;
$TOTAL = 0;
while ($row = mysql_fetch_array($res))
{
	$BROWSERS[$row['browser']] = $row['counter'];
	$TOTAL = $TOTAL + $row['counter'];
	
	if ($row['counter'] > $MAX)
	{
		$MAX = $row['counter'];
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
		  <td width="30"><img src="images/i_sta.gif" ></td>
		  <td class=white><?php echo $MSG['25_0023']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5165']; ?></td>
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
		  <?php echo $MSG['5167']."<I>".$system->SETTINGS['sitename']."</I>"?>
		  <BR>
		  <?php echo date("F Y");?>
		  </p>
		<p>
			<A HREF=viewaccessstats.php?><?php echo $MSG['5143']; ?></A> |
			<A HREF=viewdomainstats.php?><?php echo $MSG['5166']; ?></A> |
			<A HREF=viewplatformstats.php?><?php echo $MSG['5318']; ?></A>
		</p>
	  </td>
	</tr>
	<tr bgcolor=#FFFFFF>
	  <td width="80">&nbsp;</td>
	  <td width="692">&nbsp;</td>
	</tr>
	<tr bgcolor="#CCCCCC">
	  <td width="80" height="21"> 
		<b>
		<?php echo $MSG['5169']; ?>
		</b>  </td>
	  <td align=right height="21" width="692"> 
		<a href="browserstatshistoric.php">
		<?php echo $MSG['5160']; ?>
		</a>  </td>
	  <?php
	  if (is_array($BROWSERS))
	  {
		foreach ($BROWSERS as $k => $v)
	  	{
		?>
			<tr bgcolor=#eeeeee>
			  <td width="80"> <b>
				<?php echo $k; ?>
				</b> </td>
			  <td width="692">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="91%"> 
			  <?php
			  $WIDTH = ( $BROWSERS[$k] * $ABSOLUTEWIDTH ) / $MAX;
			  $PERCENAGE = ceil(intval($BROWSERS[$k] * 100 / $TOTAL));
					   ?>
			  
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="2%">
					<table border=0 callpadding=0 cellspacing=0 width=<?php echo intval($WIDTH); ?> bgcolor=#006699>
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
			</td>
		  </tr>
		</table>
			  </td>
			</tr>
			<?php
	  	}
	  }
		?>
  </table>
</td>
</tr>
</table>
</body>
</html>