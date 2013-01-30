<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit('Access denied');

// author: John	http://www.webidsupport.com/forums/member.php?5491-John
function converter_call($post_data = true, $data = array())
{
	global $system;
	include $include_path . 'converter.inc.php';

	// get convertion data
	if ($post_data)
	{
		global $_REQUEST;
		$amount = $_REQUEST['amount'];
		$from = $_REQUEST['from'];
		$to = $_REQUEST['to'];
	}
	else
	{
		$amount = $data['amount'];
		$from = $data['from'];
		$to = $data['to'];
	}
	$amount = $system->input_money($amount);

	$CURRENCIES = CurrenciesList();

	$conversion = ConvertCurrency($from, $to, $amount);
	// construct string
	echo $amount . ' ' . $CURRENCIES[$from] . ' = ' . $system->print_money_nosymbol($conversion, true) . ' ' . $CURRENCIES[$to];
}

// reload the gallery table on upldgallery.php page
function getupldtable()
{
	global $_SESSION, $uploaded_path;
	foreach ($_SESSION['UPLOADED_PICTURES'] as $k => $v)
	{
		echo '<tr>
			<td>
				<img src="' . $uploaded_path . session_id() . '/' . $v . '" width="60" border="0">
			</td>
			<td width="46%">
				' . $v . '
			</td>
			<td align="center">
				<a href="?action=delete&img=' . $k . '"><IMG SRC="images/trash.gif" border="0"></a>
			</td>
			<td align="center">
				<a href="?action=makedefault&img=' . $v . '"><img src="images/' . (($v == $_SESSION['SELL_pict_url_temp']) ? 'selected.gif' : 'unselected.gif') . '" border="0"></a>
			</td>
		</tr>';
	}
}
?>