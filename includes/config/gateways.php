<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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

$gateway_links = array(
	'paypal' => 'http://paypal.com/',
	'authnet' => 'http://authorize.net/',
	'worldpay' => 'http://rbsworldpay.com/',
	'moneybookers' => 'http://moneybookers.com/',
	'toocheckout' => 'http://2checkout.com/'
	);
$address_string = array(
	'paypal' => $MSG['720'],
	'authnet' => $MSG['773'],
	'worldpay' => $MSG['824'],
	'moneybookers' => $MSG['825'],
	'toocheckout' => $MSG['826']
	);
$password_string = array(
	'authnet' => $MSG['774']
	);
$error_string = array(
	'paypal' => $MSG['810'],
	'authnet' => $MSG['811'],
	'worldpay' => $MSG['823'],
	'moneybookers' => $MSG['822'],
	'toocheckout' => $MSG['821']
);
