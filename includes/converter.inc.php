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

if (!defined('InWeBid')) exit();

include $include_path . 'currencies.php';

function CurrenciesList()
{
	global $system, $DBPrefix;

	$query = "SELECT * FROM " . $DBPrefix . "rates";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$CURRENCIES = array();
	while ($row = mysql_fetch_assoc($res))
	{
		$CURRENCIES[$row['symbol']] = $row['valuta'];
	}
	return $CURRENCIES;
}

function ConvertCurrency($FROM, $INTO, $AMOUNT)
{
	global $conversionarray;

	$data = array(
		'amount'	=> $AMOUNT,
		'from' 		=> $FROM,
		'to' 		=> $INTO
		);
	if ($FROM == $INTO) return $AMOUNT;

	$CURRENCIES = CurrenciesList();

	$rate = findconversionrate($FROM, $INTO);
	if ($rate == 0)
	{
		$conversion = googleconvert($AMOUNT, $FROM, $INTO);
		$conversionarray[1][] = array('from' => $FROM, 'to' => $INTO, 'rate' => $conversion);
		buildcache($conversionarray[1]);
		return $AMOUNT * $conversion;
	}
	else
	{
		return $AMOUNT * $rate;
	}
}

function buildcache($newaarray)
{
	global $include_path;

	$output_filename = $include_path . 'currencies.php';
	$output = "<?php\n";
	$output.= "\$conversionarray[] = '" . time() . "';\n";
	$output.= "\$conversionarray[] = array(\n";

	for ($i = 0; $i < count($newaarray); $i++)
	{
		$output .= "\t" . "array('from' => '" . $newaarray[$i]['from'] . "', 'to' => '" . $newaarray[$i]['to'] . "', 'rate' => '" . floatval($newaarray[$i]['rate']) . "')";
		if ($i < (count($newaarray) - 1))
		{
			$output .= ",\n";
		}
		else
		{
			$output .= "\n";
		}
	}

	$output .= ");\n?>\n";

	$handle = fopen($output_filename, 'w');
	fputs($handle, $output);
	fclose($handle);
}

function findconversionrate($FROM, $INTO)
{
	global $conversionarray;

	if (time() - (3600 * 24) < $conversionarray[0])
	{
		for ($i = 0; $i < count($conversionarray[1]); $i++)
		{
			if ($conversionarray[1][$i]['from'] == $FROM && $conversionarray[1][$i]['to'] == $INTO)
				return $conversionarray[1][$i]['rate'];
		}
	}
	else
	{
		$conversionarray = array(0, array());
	}
	return 0;
}

function googleconvert($amount, $fromCurrency , $toCurrency)
{
	//Call Google API
	$google_url = "http://www.google.com/ig/calculator?hl=en&q=1" . $fromCurrency . "=?" . $toCurrency;
	//Get and Store API results into a variable
	$result = file_get_contents($google_url);
	//Explode result to convert into an array
	$result = explode('"', $result);
	// get value
	$converted_amount = explode(' ', $result[3]);
	return $converted_amount[0];
}
?>