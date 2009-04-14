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

define('InAdmin', 1);
require('../includes/common.inc.php');
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

// Create currencies array
$query = "SELECT id, valuta, symbol, ime FROM " . $DBPrefix . "rates ORDER BY ime";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);
if (mysql_num_rows($res_) > 0) {
	while ($row = mysql_fetch_array($res_)) {
		$CURRENCIES[$row['id']] = $row['symbol'] . '&nbsp;' . $row['ime'] . '&nbsp;(' . $row['valuta'] . ')';
		$CURRENCIES_SYMBOLS[$row['id']] = $row['symbol'];
	}
}

if (isset($_POST['action']) && $_POST['action'] == "update") {
	// Data check
	if (empty($_POST['currency']) || empty($_POST['moneydecimals'])) {
		$ERR = $ERR_047;
		$system->SETTINGS = $_POST;
		$system->SETTINGS['currency'] = $CURRENCIES_SYMBOLS[$_POST['currency']];
	} elseif (!empty($_POST['moneydecimals']) && !ereg("^[0-9]+$", $_POST['moneydecimals'])) {
		$ERR = $ERR_051;
		$system->SETTINGS = $_POST;
		$system->SETTINGS['currency'] = $CURRENCIES_SYMBOLS[$_POST['currency']];
	} else {
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings SET
				currency = '" . addslashes($CURRENCIES_SYMBOLS[$_POST['currency']]) . "',
				moneyformat = " . intval($_POST['moneyformat']) . ",
				moneydecimals = " . intval($_POST['moneydecimals']) . ",
				moneysymbol = " . intval($_POST['moneysymbol']);
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$system->SETTINGS = $_POST;
		$system->SETTINGS['currency'] = $CURRENCIES_SYMBOLS[$_POST['currency']];
		$ERR = $MSG['553'];
	}
}

$OTHERCURRENCIES = array();
$query = "SELECT * FROM " . $DBPrefix . "currencies";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0) {
	while ($row = mysql_fetch_array($res)) {
		$OTHERCURRENCIES[$row['id']] = $row['currency'];
	}
}

$link = "javascript:window_open('converter.php','incre',650,200,30,30)";

foreach ($CURRENCIES_SYMBOLS as $k => $v) {
	if ($v == $system->SETTINGS['currency'])
		$selectsetting = $k;
}

loadblock($MSG['5008'], '', generateSelect('currency', $CURRENCIES));
loadblock('', $MSG['5138'], 'link', 'currenciesconverter', '', $MSG['5010']);
loadblock($MSG['544'], '', 'batchstacked', 'moneyformat', $system->SETTINGS['moneyformat'], $MSG['545'], $MSG['546']);
loadblock($MSG['548'], $MSG['547'], 'decimals', 'moneydecimals', $system->SETTINGS['moneydecimals']);
loadblock($MSG['549'], '', 'batchstacked', 'moneysymbol', $system->SETTINGS['moneysymbol'], $MSG['550'], $MSG['551']);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'LINKURL' => $link,
		'OPTIONHTML' => $html,
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['5004']
		));

$template->set_filenames(array(
		'body' => 'adminpages.html'
		));
$template->display('body');
?>
