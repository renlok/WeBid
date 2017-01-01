<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
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
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

// Create currencies array
$query = "SELECT id, valuta, symbol, ime FROM " . $DBPrefix . "rates ORDER BY ime";
$db->direct_query($query);
if ($db->numrows() > 0) {
    while ($row = $db->fetch()) {
        $CURRENCIES[$row['id']] = $row['symbol'] . '&nbsp;' . $row['ime'] . '&nbsp;(' . $row['valuta'] . ')';
        $CURRENCIES_SYMBOLS[$row['id']] = $row['symbol'];
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Data check
    if (empty($_POST['currency'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
    } elseif (!empty($_POST['moneydecimals']) && !is_numeric($_POST['moneydecimals'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_051));
    } else {
        if (!empty($_POST['country']) && !empty($_POST['currency_type']) && !empty($_POST['currency_abbreviation'])) {
            $query = "INSERT INTO " . $DBPrefix . "rates VALUES (NULL, :country, :currency_type, :currency_abbreviation);";
            $params = array();
            $params[] = array(':country', $system->cleanvars($_POST['country']), 'str');
            $params[] = array(':currency_type', $system->cleanvars($_POST['currency_type']), 'str');
            $params[] = array(':currency_abbreviation', $system->cleanvars($_POST['currency_abbreviation']), 'str');
            $db->query($query, $params);
            $new_id = $db->lastInsertId();
            $CURRENCIES[$new_id] = $_POST['currency_abbreviation'] . '&nbsp;' . $_POST['country'] . '&nbsp;(' . $_POST['currency_type'] . ')';
            $system->writesetting("currency", $system->cleanvars($_POST['currency_abbreviation']), 'str');
        } else {
            $system->writesetting("currency", $system->cleanvars($CURRENCIES_SYMBOLS[$_POST['currency']]), 'str');
        }

        // Update database
        $system->writesetting("moneyformat", $_POST['moneyformat'], 'int');
        $system->writesetting("moneydecimals", $_POST['moneydecimals'], 'int');
        $system->writesetting("moneysymbol", $_POST['moneysymbol'], 'int');

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['currency_settings_updated']));
    }
}

foreach ($CURRENCIES_SYMBOLS as $k => $v) {
    if ($v == $system->SETTINGS['currency']) {
        $selectsetting = $k;
    }
}

loadblock($MSG['default_currency'], $MSG['default_currency_explain'], generateSelect('currency', $CURRENCIES));
loadblock($MSG['money_format'], '', 'batchstacked', 'moneyformat', $system->SETTINGS['moneyformat'], array($MSG['money_format_us'], $MSG['money_format_euro']));
loadblock($MSG['money_decimals'], $MSG['money_decimals_explain'], 'decimals', 'moneydecimals', $system->SETTINGS['moneydecimals']);
loadblock($MSG['money_symbol_position'], '', 'batchstacked', 'moneysymbol', $system->SETTINGS['moneysymbol'], array($MSG['money_symbol_position_before'], $MSG['money_symbol_position_after']));
loadblock($MSG['new_currency'], '', '', '', '', array(), true);
loadblock($MSG['014'], $MSG['curreny_country_explain'], 'text', 'country', (isset($_POST['country'])) ? $_POST['country'] : '');
loadblock($MSG['currency_name'], $MSG['curreny_name_explain'], 'text', 'currency_type', (isset($_POST['currency_type'])) ? $_POST['currency_type'] : '');
loadblock($MSG['curreny_symbol'], $MSG['curreny_symbol_explain'], 'text', 'currency_abbreviation', (isset($_POST['currency_abbreviation'])) ? $_POST['currency_abbreviation'] : '');

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'OPTIONHTML' => '',
        'TYPENAME' => $MSG['25_0008'],
        'PAGENAME' => $MSG['currency_settings']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
