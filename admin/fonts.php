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

require('../includes/config.inc.php');
include "loggedin.inc.php";
?>
<html>
<head>
<link rel='stylesheet' type='text/css' href='style.css' />
<script type="text/javascript">
function ChooseColor(val,what,T)
{
	what.value = val;
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td background="images/bac_barint.gif">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td width="30"><img src="images/i_gra.gif"></td>
                    <td class=white><?php echo $MSG['25_0009']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5001']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="middle">
            <table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
                <tr>
                    <td align="center"> <br>
                        <form name=conf action="" method="post">
                            <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
                                <tr>
                                    <td align=CENTER class=title><?php print $MSG['5001']; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width=100% cellspacing=1 cellpadding=2 align="CENTER" bgcolor="#ffffff">
											<TR>
											<TD COLSPAN=2>
												<?php echo $MSG['30_0009']; ?><BR>
												<B><?php echo $MSG['30_0010']; ?></B>(<CODE><?php echo "themes/".$system->SETTINGS['theme']."/style.css"; ?></CODE>)
											</TD>
											</TR>
                                            <tr valign="TOP">
                                                <td bgcolor="#eeeeee">
													<H3><?php echo $MSG['571'] ?></H3>
													<?php echo $MSG['577'] ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=table&from=fonts.php&font=standard><?php echo $MSG['30_0004']; ?></A>
												</td>
                                                <td bgcolor="#eeeeee">
													<H3><?php echo $MSG['572'] ?></H3>
													<?php echo $MSG['576'] ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.errfont&from=fonts.php&font=error><?php echo $MSG['30_0005']; ?></A>
												</td>
                                            </tr>
                                            <tr valign="TOP">
                                                <td bgcolor="#eeeeee">
													<H3><?php echo $MSG['575'] ?></H3>
													<?php echo $MSG['585'] ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.titTable2&from=fonts.php&font=title><?php echo $MSG['30_0006']; ?></A>
												</td>
                                                <td bgcolor="#eeeeee">
													<H3><?php echo $MSG['588'] ?></H3>
													<?php echo $MSG['589'] ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.table-bar&from=fonts.php&font=navigation><?php echo $MSG['30_0007']; ?></A>
												</td>
                                            </tr>
                                            <tr valign="TOP">
                                                <td bgcolor="#eeeeee">
													<H3><?php echo $MSG['574'] ?></H3>
													<?php echo $MSG['584'] ?>
													<p align=right><A HREF=../csseditor_.php?thestyle=themes/<?php echo $system->SETTINGS['theme']; ?>/style.css&sel=.footer&from=fonts.php&font=footer><?php echo $MSG['30_0008']; ?></A>
												</td>
                                            </tr>
                                                <td> </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
