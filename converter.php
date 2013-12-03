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
 
include 'common.php';
include $include_path . 'converter.inc.php';

$CURRENCIES = CurrenciesList();
$conversion = '&nbsp;';

if (isset($_POST['action']) && $_POST['action'] == 'convert')
{
	// Convert
	$from = is_numeric($_POST['from']) ? $_POST['from'] : 0;
	$to = is_numeric($_POST['to']) ? $_POST['to'] : 0;
	$amount = is_numeric($_POST['amount']) ? $_POST['amount'] : 0;
	$conversion = ConvertCurrency($from, $to, $amount);
	// construct string
	$conversion = $system->print_money_nosymbol($amount) . ' ' . $CURRENCIES[$from] . ' = ' . $system->print_money_nosymbol($conversion, true) . ' |' . $CURRENCIES[$to];
}

foreach ($CURRENCIES as $k => $v)
{
	$fromselected = false;
	$toselected = false;
	if ($k == $system->SETTINGS['currency'])
	{
		$fromselected = true;
	}
	elseif (isset($_POST['from']) && $_POST['from'] == $k)
	{
		$fromselected = true;
	}
	if (isset($_POST['to']) && $_POST['to'] == $k)
	{
		$toselected = true;
	}
	$template->assign_block_vars('from', array(
			'VALUE' => $k,
			'NAME' => $v,
			'B_SELECTED' => $fromselected
			));
	$template->assign_block_vars('to', array(
			'VALUE' => $k,
			'NAME' => $v,
			'B_SELECTED' => $toselected
			));
}

$template->assign_vars(array(
		'SITENAME' => $system->SETTINGS['sitename'],
		'THEME' => $system->SETTINGS['theme'],
		'ERROR' => (!isset($errormsg)) ? '' : $errormsg,
		'CONVERSION' => $conversion,
		'AMOUNT' => (isset($_POST['amount'])) ? $_POST['amount'] : ((isset($_GET['AMOUNT'])) ? $_GET['AMOUNT'] : 1.00),

		'B_CONVERSION' => (isset($_POST['action']) && $_POST['action'] == 'convert')
		));

$template->set_filenames(array(
		'body' => 'converter.tpl'
		));
$template->display('body');
?>