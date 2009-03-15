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

if(isset($_POST['action']) && $_POST['action'] == "update") {
	if(is_dir($main_path.'cache')){
		$dir = opendir($main_path.'cache');
		while(($myfile = readdir($dir)) !== false){
			if($myfile != '.' && $myfile != '..' && $myfile != 'index.php'){
				unlink($main_path.'cache/'.$myfile);
			}
		}
		closedir($dir);
	}
	$ERR = $MSG['30_0033'];
}

?>
<html>
<head>
<link rel='stylesheet' type='text/css' href='style.css' />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td background="images/bac_barint.gif">
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td width="30"><img src="images/i_gra.gif"></td>
                    <td class=white><?php echo $MSG['25_0009']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['30_0031']; ?></td>
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
                        <form name="conf" action="" method="post">
                            <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7" align="center">
                                <tr>
                                    <td align=CENTER class=title><?php print $MSG['30_0031']; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width=100% cellpadding=2 align="CENTER" bgcolor="#FFFFFF">
                                            <?php
                                            if(!empty($ERR))
                                            {
											?>
                                            <tr bgcolor=yellow>
                                                <td colspan="2" align=CENTER><b><?php print $ERR; ?> </b></td>
                                            </tr>
                                            <?php
                                            }
				 							?>
                                            <tr valign="TOP">
                                                <td width="393" align="center"> 
                                                    <?php echo $MSG['30_0032']; ?>
                                                </td>
                                            </tr>
                                            <tr valign="TOP">
                                                <td align="center">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="submit" name="submit" value="<?php echo $MSG['30_0031']; ?>">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
