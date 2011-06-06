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

if (!defined('InWeBid')) exit('Access denied');

// author: John	http://www.webidsupport.com/forums/member.php?5491-John
function converter_call($post_data = true, $data = array())
{
	include $include_path . 'converter.inc.php';

	// get convertion data
	if ($post_data)
	{
		global $_POST;
		$amount = $_POST['amount'];
		$from = $_POST['from'];
		$to = $_POST['to'];
	}
	else
	{
		$amount = $data['amount'];
		$from = $data['from'];
		$to = $data['to'];
	}

	$CURRENCIES = CurrenciesList();

	$conversion = ConvertCurrency($from, $to, $amount);
	// construct string
	echo $amount . ' ' . $CURRENCIES[$from] . ' = ' . number_format(($amount * $conversion), 2, '.', ',') . ' ' . $CURRENCIES[$to];
}
?>