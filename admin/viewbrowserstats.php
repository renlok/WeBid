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

$ABSOLUTEWIDTH = 650;

// Retrieve data
$query = "SELECT * FROM " . $DBPrefix . "currentbrowsers WHERE month = " . date('n') . " AND year = " . date('Y') . " ORDER BY counter DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$MAX = 0;
$TOTAL = 0;
while($row = mysql_fetch_array($res))
{
	$BROWSERS[$row['browser']] = $row['counter'];
	$TOTAL = $TOTAL + $row['counter'];
	
	if($row['counter'] > $MAX)
	{
		$MAX = $row['counter'];
	}
}

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
  <TABLE WIDTH=95% CELLPADDING=2 CELLSPACING=1 BORDER=0 ALIGN="CENTER">
    <TR BGCOLOR="#FFCC00">
      <TD ALIGN=CENTER colspan="2" bgcolor="#eeeeee">
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
      </TD>
    </TR>
    <TR BGCOLOR=#FFFFFF>
      <TD width="80">&nbsp;</TD>
      <TD width="692">&nbsp;</TD>
    </TR>
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
      if(is_array($BROWSERS))
      {
      	while(list($k,$vv) = each($BROWSERS))
      	{
		?>
    		<TR BGCOLOR=#eeeeee>
    		  <TD width="80"> <b>
        		<?php echo $k; ?>
        		</b> </TD>
    		  <TD width="692">

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
    		  </TD>
    		</TR>
    		<?php
      	}
      }
		?>
  </TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>