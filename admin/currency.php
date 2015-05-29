<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);
$html = '';

// Create currencies array
$query = "SELECT id, valuta, symbol, ime FROM " . $DBPrefix . "rates ORDER BY ime";
$db->direct_query($query);
if ($db->numrows() > 0)
{
	while ($row = $db->result())
	{
		$CURRENCIES[$row['id']] = $row['symbol'] . '&nbsp;' . $row['ime'] . '&nbsp;(' . $row['valuta'] . ')';
		$CURRENCIES_SYMBOLS[$row['id']] = $row['symbol'];
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Data check
	if (empty($_POST['currency']))
	{
		$ERR = $ERR_047;
	}
	elseif (!empty($_POST['moneydecimals']) && !is_numeric($_POST['moneydecimals']))
	{
		$ERR = $ERR_051;
	}
	else
	{
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				currency = '" . $system->cleanvars($CURRENCIES_SYMBOLS[$_POST['currency']]) . "',
				moneyformat = " . intval($_POST['moneyformat']) . ",
				moneydecimals = " . intval($_POST['moneydecimals']) . ",
				moneysymbol = " . intval($_POST['moneysymbol']);
		$db->direct_query($query);
		$system->SETTINGS['moneyformat'] = $_POST['moneyformat'];
		$system->SETTINGS['moneydecimals'] = $_POST['moneydecimals'];
		$system->SETTINGS['moneysymbol'] = $_POST['moneysymbol'];
		$ERR = $MSG['553'];
	}
}

$link = "javascript:window_open('" . $system->SETTINGS['siteurl'] . "converter.php','incre',650,250,30,30)";

foreach ($CURRENCIES_SYMBOLS as $k => $v)
{
	if ($v == $system->SETTINGS['currency'])
		$selectsetting = $k;
}

loadblock($MSG['5008'], '', generateSelect('currency', $CURRENCIES));
loadblock('', $MSG['5138'], 'link', 'currenciesconverter', '', array($MSG['5010']));
loadblock($MSG['544'], '', 'batchstacked', 'moneyformat', $system->SETTINGS['moneyformat'], array($MSG['545'], $MSG['546']));
loadblock($MSG['548'], $MSG['547'], 'decimals', 'moneydecimals', $system->SETTINGS['moneydecimals']);
loadblock($MSG['549'], '', 'batchstacked', 'moneysymbol', $system->SETTINGS['moneysymbol'], array($MSG['550'], $MSG['551']));

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'LINKURL' => $link,
		'OPTIONHTML' => $html,
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['5004']
		));

$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
?>
