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
    $system->writesetting("taxuser", $_POST['taxuser'], "str");
    $system->writesetting("tax", $_POST['tax'], "str");
    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['tax_settings_updated']));
}

loadblock($MSG['enable_tax'], $MSG['enable_tax_explain'], 'yesno', 'tax', $system->SETTINGS['tax'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_user_tax'], $MSG['enable_user_tax_explain'], 'yesno', 'taxuser', $system->SETTINGS['taxuser'], array($MSG['yes'], $MSG['no']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0012'],
        'PAGENAME' => $MSG['tax_settings']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
