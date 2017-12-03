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
    $system->writesetting("use_moderation", $_POST['use_moderation'], 'bool');
    $system->writesetting("auction_moderation", $_POST['auction_moderation'], 'int');
    $system->writesetting("new_auction_moderation", $_POST['new_auction_moderation'], 'int');

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['moderation_settings_updated']));
}

loadblock($MSG['moderation'], '', 'bool', 'use_moderation', $system->SETTINGS['use_moderation'], array($MSG['759'], $MSG['760']));

loadblock($MSG['auction_moderation'], '', '', '', '', array(), true);
loadblock($MSG['auction_moderation'], '', 'bool', 'auction_moderation', $system->SETTINGS['auction_moderation'], array($MSG['759'], $MSG['760']));
loadblock($MSG['new_auction_moderation'], '', 'select3num', 'new_auction_moderation', $system->SETTINGS['new_auction_moderation'], array($MSG['moderation_disabled'], $MSG['moderation_pre_moderation'], $MSG['moderation_post_moderation']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['5142'],
        'PAGENAME' => $MSG['moderation_settings'],
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
