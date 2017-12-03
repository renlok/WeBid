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
$current_page = 'fees';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // update users
    if ($system->SETTINGS['fee_max_debt'] < $_POST['fee_max_debt']) {
        $query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE suspended = 7 AND balance > :fee_max_debt";
        $params = array();
        $params[] = array(':fee_max_debt', $_POST['fee_max_debt'], 'int');
        $db->query($query, $params);
    }
    // Update database
    $system->writesetting("fees", $_POST['fees'], "str");
    $system->writesetting("fee_type", $_POST['fee_type'], "int");
    $system->writesetting("fee_max_debt", $system->input_money($_POST['fee_max_debt']), "float");
    $system->writesetting("fee_signup_bonus", $system->input_money($_POST['fee_signup_bonus']), "float");
    $system->writesetting("fee_disable_acc", $_POST['fee_disable_acc'], "str");
    $system->writesetting("payment_gateway_sandbox", $_POST['payment_gateway_sandbox'], "str");

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['fee_settings_updated']));
}

loadblock($MSG['enable_fees'], $MSG['enable_fees_explain'], 'yesno', 'fees', $system->SETTINGS['fees'], array($MSG['759'], $MSG['760']));
loadblock($MSG['set_payment_type'], $MSG['set_payment_type_explain'], 'batchstacked', 'fee_type', $system->SETTINGS['fee_type'], array($MSG['balance_mode'], $MSG['live_payments']));

loadblock($MSG['payment_sandbox'], $MSG['payment_sandbox_explain'], 'bool', 'payment_gateway_sandbox', $system->SETTINGS['payment_gateway_sandbox'], array($MSG['yes'], $MSG['no']));

loadblock($MSG['balance_mode_settings'], '', '', '', '', array(), true);
loadblock($MSG['max_debt'], $MSG['max_debt_explain'], 'days', 'fee_max_debt', $system->SETTINGS['fee_max_debt']);
loadblock($MSG['signup_credit'], $MSG['signup_credit_explain'], 'days', 'fee_signup_bonus', $system->SETTINGS['fee_signup_bonus']);
loadblock($MSG['suspend_debt_accounts'], $MSG['suspend_debt_accounts_explain'], 'yesno', 'fee_disable_acc', $system->SETTINGS['fee_disable_acc'], array($MSG['yes'], $MSG['no']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0012'],
        'PAGENAME' => $MSG['enable_fees'],
        'B_TITLES' => true
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
