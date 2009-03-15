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

if(!($handle = @fopen("http://www.webidsupport.com/version.txt", "r"))){
	$error = $ERR_25_0002;
	$realversion = 'Unknown';
} else {
	$realversion = fread($handle, 5);
	fclose($handle);
}
$handle = fopen("../includes/version.txt", "r") or die("error");
$myversion = fread($handle, 5);
fclose($handle);
if($realversion != $myversion){
	$myversion = "<span style='color:#ff0000;'>".$myversion."</span>";
	$text = $MSG['30_0211'];
} else {
	$myversion = "<span style='color:#00ae00;'>".$myversion."</span>";
	$text = $MSG['30_0212'];
}
$output =<<<EOD
$error
Your Version: <b>$myversion</b><br>
Current Version: $realversion<br>
$text
EOD;
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
                    <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
                    <td class="white"><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['25_0169a']; ?></td>
                </tr>
            </table>
		</td>
    </tr>
    <tr>
        <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="middle">
        <?php echo $output; ?>
        </td>
    </tr>
</table>
</body>
</html>