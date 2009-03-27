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
 
include "includes/common.inc.php";
include $include_path . "converter.inc.php";

$CURRENCIES = CurrenciesList();

if (isset($_POST['action']) && $_POST['action'] == 'convert') {
    // Convert
    $CONVERTED = ConvertCurrency($_POST['from'], $_POST['to'], $_POST['amount']);
	if($CONVERTED == false) {
		$errormsg = $ERR_069;
	}
}

$AMOUNT = (isset($_POST['amount'])) ? $_POST['amount'] : ((isset($_GET['AMOUNT'])) ? $_GET['AMOUNT'] : 0);

?>
<html>
<head>
<title>
<?php
echo $system->SETTINGS['sitename'];
?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
include $include_path . "styles.inc.php";
echo '<link rel="stylesheet" type="text/css" href="themes/' . $system->SETTINGS['theme'] . '/style.css">';
?>
</head>
<body>
<div id="content">
    <div class="container">
        <div class="titTable2">
            ::: CURRENCY CONVERTER :::
        </div>
        <div class="table3">
            <form name="form1" method="post" action="">
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php
if (isset($_POST['action']) && $_POST['action'] == "convert") {
?>
                    <tr valign="TOP">
                        <th colspan="3">
<?php
if(!isset($errormsg)) {
	echo number_format($_POST['amount'], 4, '.', ',') . ' ' . $_POST['from'] . ' = ' . number_format($CONVERTED, 4, '.', ',') . ' ' . $_POST['to'];
} else {
	echo $errormsg;
}
?>
                        </th>
                    </tr>
<?php
} else {
?>
                    <tr valign="TOP">
                        <td colspan="3" align=CENTER>&nbsp;</td>
                    </tr>
<?php
}
?>
                    <tr valign="TOP">
                        <td width="22%">Convert<br>
                            <input type="text" name="amount" size="5" value=<?php echo $AMOUNT; ?> />
                        </td>
                        <td width="39%">of this currency<br>
                            <select name="from">
<?php
foreach($CURRENCIES as $k => $v) {
    print '<option value="' . $k . '"';
    if ($k == $system->SETTINGS['currency']) {
        print ' selected="true"';
    } elseif ($_POST['from'] == $k) {
        print " selected=true";
    }
    print ">$k $v</option>\n";
}
?>
                            </select>
                        </td>
                        <td width="39%">into this currency<br>
                            <select name="to">
<?php
foreach($CURRENCIES as $k => $v) {
    print "<option value=\"$k\"";
    if ($_POST['to'] == $k)
        print " selected=true";
    print ">$k $v</option>\n";
}
?>
                            </select>
                        </td>
                    </tr>
                </table>
                <div style="text-align:center">
                    <input type="hidden" name="action" value="convert" />
                    <input type="submit" name="Submit" value="<?php echo $MSG['25_0176']; ?>" />
                </div>
            </form>
        </div>
        <div style="text-align:center">
            <input type="button" value="Close" onClick="javascript:window.close()" />
        </div>
		<br>
    </div>
</div>
</body>
</html>