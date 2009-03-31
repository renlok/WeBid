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
if (!defined('InWeBid')) exit('Access denied');
// UNDER CONSTRUCTION XD
class fees
{
	var $ASCII_RANGE;
	
	function fees() {
		$this->ASCII_RANGE = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
	
	function paypal_validate() {
		global $system, $_POST;

		$confirmed = false;	// used to check if the payment is confirmed
		$errstr = $error_output = '';
		$errno = 0;

		// we ensure that the txn_id (transaction ID) contains only ASCII chars...
		$pos = strspn($_POST['txn_id'], $this->ASCII_RANGE);
		$len = strlen($_POST['txn_id']);

		if ($pos != $len) {
			return;
		}
		
		//validate payment
		$req = 'cmd=_notify-validate';

		foreach ($this->data as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= '&' . $key . '=' . $value;
		}

		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
		
		$payment_status = $_POST['payment_status'];
		$payment_gross = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		
		list($custom, $fee_table) = explode('TBL',$_POST['custom']);
		
		if (!$fp) {
			$error_output = $errstr . ' (' . $errno . ')';
		} else {
			fputs ($fp, $header . $req);
		
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
		
				if (strcmp ($res, "VERIFIED") == 0) {
					/* PROCESSED
					$process_fee = new fees();
					$process_fee->setts = &$setts;
		
					$process_fee->callback_process($custom, $fee_table, $active_pg, $payment_gross, $txn_id, $payment_currency);
					*/
				}
			}
			fclose ($fp);
		}
	}
}
?>