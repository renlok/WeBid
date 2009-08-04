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

include 'includes/common.inc.php';

// If user is not logged in redirect to login page
if (!$user->logged_in)
{
	header('location: user_login.php');
	exit;
}

switch($_GET['a'])
{
	case 1: // add to account balance
		$query = "SELECT paypal_address FROM " . $DBPrefix . "gateways LIMIT 1";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$paytoemail = mysql_result($res, 0);
		$payvalue = $system->input_money($_POST['pfval']);
		break;
	case 2:
}

$template->assign_vars(array(
		'PAYTOEMAIL' => $paytoemail,
		'PAY_VAL' => $payvalue,
		'CURRENCY' -> $system->SETTINGS['currency'],
		'TITLE' => $title,
		'PAY_VAL' => $payvalue,
		'PAY_VAL' => $payvalue,
		'PAY_VAL' => $payvalue,
		'PAY_VAL' => $payvalue
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'pay.tpl'
		));
$template->display('body');
include 'footer.php';
?>
