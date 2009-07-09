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
 
include '../includes/common.inc.php';
include $include_path.'domains.inc.php';

$ABSOLUTEWIDTH = 550;

#// Retrieve data
$query = "SELECT * FROM " . $DBPrefix . "currentdomains WHERE month = " . date('n') . " AND year = " . date('Y') . " ORDER BY domain";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$MAX = 0;
$TOTAL = 0;
while ($row = mysql_fetch_array($res))
{
	$DOM[$row['domain']] = $row['counter'];
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
  <table width=95% cellpadding=2 cellspacing=1 border=0 align="center" bgcolor=white>
	<tr bgcolor="#FFCC00">
	  <td align="center" colspan="2" bgcolor="#eeeeee">
		<p class="title" style="color:#000000">
		  <?php echo $MSG['5168']." <I>".$system->SETTINGS['sitename']."</I>"?>
		  <BR>
	  <?php echo date("F Y");?>
		  </p>
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
		<?php echo $MSG['5170']; ?>
		</b>  </td>
	  <td align=right height="21" width="626"> 
		<a href="domainstatshistoric.php">
		<?php echo $MSG['5160']; ?>
		</a>  </td>
	  <?php
			foreach ($DOM as $k => $v)
			{
		?>
			<tr bgcolor=#eeeeee>

	  <td> <b>
		<?php echo $k;  ?></B> <?php echo ($DOMAINS[$k]); ?>
		</b> </td>

	  <td width="626">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="600"> 
			  <?php
					  	$WIDTH = ( $DOM[$k] * $ABSOLUTEWIDTH ) / $MAX;
						$PERCENAGE = ceil(intval($DOM[$k] * 100 / $TOTAL));
					   ?>
			  
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
			</td>
		  </tr>
		</table>
			  </td>
			</tr>
			<?php
		 	}
		?>
  </table>
</td>
</tr>
</table>
</body>
</html>