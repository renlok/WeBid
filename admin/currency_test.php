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

require('../includes/config.inc.php');
include "loggedin.inc.php";

unset($ERR);

// Create currencies array
$query = "SELECT id, valuta, symbol, ime FROM " . $DBPrefix . "rates ORDER BY ime";
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
if(mysql_num_rows(mysql_query($query)) > 0) {
	while($row = mysql_fetch_array(mysql_query($query))) {
		$CURRENCIES[$row['id']] = $row[symbol] . '&nbsp;' . $row['ime'] . '&nbsp;(' . $row['valuta'] . ')';
		$CURRENCIES_SYMBOLS[$row['id']] = $row['symbol'];
	}
}

//
if(isset($_POST['action']) && $_POST['action'] == "update")
{
	// Data check
	if(empty($_POST['defaultcurrency']) || empty($_POST['moneyformat']) || empty($_POST['moneysymbol'])) {
		$ERR = $ERR_047;
		$system->SETTINGS = $_POST;
	} elseif(!empty($_POST['moneydecimals']) && !ereg("^[0-9]+$",$_POST['moneydecimals'])) {
		$ERR = $ERR_051;
		$system->SETTINGS = $_POST;
	} else {
		// Update database
		$query = "UPDATE " . $DBPrefix . "settings set currency='".addslashes($CURRENCIES_SYMBOLS[$_POST['defaultcurrency']])."',
				  moneyformat=$_POST[moneyformat],
				  moneydecimals=".intval($_POST['moneydecimals']).",
				  moneysymbol=$_POST[moneysymbol]";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$system->SETTINGS['moneyformat'] = $_POST['moneyformat'];
		$system->SETTINGS['moneydecimals'] = $_POST['moneydecimals'];
		$system->SETTINGS['moneysymbol'] = $_POST['moneysymbol'];
		$ERR = $MSG['553'];
		$system->SETTINGS = $_POST;
	}
	
	if(is_array($_POST['othercurrencies'])) {
		@mysql_query("DELETE FROM " . $DBPrefix . "currencies");
		while(list($k,$v) = each($_POST[othercurrencies])) {
			$query = "INSERT INTO " . $DBPrefix . "currencies VALUES (NULL,'$v')";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);;
		}
	}
}

$query = "SELECT * FROM ".$DBPrefix."settings";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if(mysql_num_rows($res) > 0)
{
	$system->SETTINGS = mysql_fetch_array($res);
}


$OTHERCURRENCIES = array();
$query = "SELECT * FROM ".$DBPrefix."currencies";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if(mysql_num_rows($res) > 0) {
	while($row = mysql_fetch_array($res)) {
		$OTHERCURRENCIES[$row['id']] = $row['currency'];
	}
}

loadblock('', $MSG['25_0152'], 'dropdown', 'currency', $OTHERCURRENCIES['currency'], $MSG['5138'], '');
loadblock('', $MSG['544'], 'yesnostacked', 'moneyformat', $system->SETTINGS['moneyformat'], $MSG['545'], $MSG['546']);
loadblock($MSG['548'], $MSG['547'], 'decimals', 'moneydecimals', $system->SETTINGS['moneydecimals'],'', '');
loadblock('', $MSG['549'], 'yesnostacked', 'moneysymbol', $system->SETTINGS['moneysymbol'], $MSG['550'], $MSG['551']);

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'pre',
		'TYPENAME' => $MSG['25_0008'],
		'PAGENAME' => $MSG['5004']
        ));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
