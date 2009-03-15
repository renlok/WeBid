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

if(!defined('InWeBid')) exit();

include($include_path."nusoap.php");

function CurrenciesList() {
	if(!isset($_SESSION['curlist'])) {
		$s = new soapclientt("http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getListOfCurrencies");
		$result= $s->call('getListOfCurrencies',array(),'','http://webservices.lb.lt/ExchangeRates/getListOfCurrencies');
		$parser = xml_parser_create();
		xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
		xml_parse_into_struct($parser,$s->responseData,$values,$tags);
		xml_parser_free($parser);
		$CURRENCIES = array();
		foreach($values as $k => $v) {
			if($v['tag'] == "currency") $cur = $v['value'];
			if($v['tag'] == "description" && $v['attributes']['lang'] == 'en') {
				$CURRENCIES[$cur] = $v['value'];
			}
		}
		$_SESSION['curlist'] = $CURRENCIES;
	} else {
		$CURRENCIES = $_SESSION['curlist'];
	}
	return $CURRENCIES;
}

function ConvertCurrency($FROM,$INTO,$AMOUNT) {
	global $include_path;
	$params1 = array(
	'FromCurrency' 		=> $FROM,
	'ToCurrency' 		=> $INTO
	);
	if($FROM==$INTO) return $AMOUNT;
	$sclient 		= new soapclientt($include_path . "CurrencyConverter.wdsl", "wsdl");
	$p				= $sclient->getProxy();
	$ratio			= $p->ConversionRate($params1);
	
	$VAL 	= floatval($AMOUNT);
	return $VAL*$ratio;
}
?>