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
function converter_call()
{
	global $_POST;

	$amount = $_POST['amount'];
	$from = $_POST['from'];
	$to = $_POST['to'];
	//make string to be put in API
	$string = "1" . $from . "=?" . $to;
	//Call Google API
	$google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $string;
	//Get and Store API results into a variable
	$result = file_get_contents($google_url);
	//Explode result to convert into an array
	$result = explode('"', $result);
	################################ # Right Hand Side ################################
	$converted_amount = explode(' ', $result[3]);
	$conversion = $converted_amount[0];
	$conversion = $conversion * $amount;
	$conversion = round($conversion, 2);
	//Get text for converted currency
	$rhs_text = ucwords(str_replace($converted_amount[0], "", $result[3]));
	//Make right hand side string
	$rhs = $conversion . $rhs_text;
	################################ # Left Hand Side ################################
	$google_lhs = explode(' ', $result[1]);
	$from_amount = $google_lhs[0];
	//Get text for converted from currency
	$from_text = ucwords(str_replace($from_amount, "", $result[1]));
	//Make left hand side string
	$lhs = $amount . " " . $from_text;
	################################ # Make the result ################################
	echo $lhs . " = " . $rhs;
}
?>