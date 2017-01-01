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

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $bn_only_percent = intval($_POST['bn_only_percent']);
    $bn_only_percent = ($bn_only_percent > 100) ? 100 : $bn_only_percent;
    $bn_only_percent = ($bn_only_percent < 0) ? 0 : $bn_only_percent;
    // reset the bn_only blockers
    if ($bn_only_percent > $system->SETTINGS['bn_only_percent']) {
        $query = "UPDATE " . $DBPrefix . "users SET bn_only = 1 WHERE bn_only = 0";
        $db->direct_query($query);
    }

    $system->writesetting("buy_now", $_POST['buy_now'], "int");
    $system->writesetting("bn_only", $_POST['bn_only'], "str");
    $system->writesetting("bn_only_disable", $_POST['bn_only_disable'], "str");
    $system->writesetting("bn_only_percent", $bn_only_percent, "int");

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['buy_it_now_settings_updated']));
}

loadblock($MSG['enable_buy_it_now'], $MSG['enable_buy_it_now_explain'], 'batch', 'buy_now', $system->SETTINGS['buy_now'], array($MSG['no'], $MSG['yes']));
loadblock($MSG['enable_buy_it_now_only'], $MSG['enable_buy_it_now_only_explain'], 'yesno', 'bn_only', $system->SETTINGS['bn_only'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_bin_only_auto_disable'], $MSG['enable_bin_only_auto_disable_explain'], 'yesno', 'bn_only_disable', $system->SETTINGS['bn_only_disable'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['buy_it_now_only_limit'], '', 'percent', 'bn_only_percent', $system->SETTINGS['bn_only_percent'], array($MSG['357']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0008'],
        'PAGENAME' => $MSG['2__0025']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
