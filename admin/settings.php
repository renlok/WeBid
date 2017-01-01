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
    // Data check
    if (empty($_POST['sitename']) || empty($_POST['siteurl']) || empty($_POST['adminmail'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
    } elseif (!is_numeric($_POST['archiveafter'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_043));
    } else {
        // Update data
        $system->writesetting(array(
            array("sitename", $_POST['sitename'], 'str'),
            array("adminmail", $_POST['adminmail'], 'str'),
            array("siteurl", $_POST['siteurl'], 'str'),
            array("copyright", $_POST['copyright'], 'str'),
            array("cron", $_POST['cron'], 'int'),
            array("archiveafter", $_POST['archiveafter'], 'int'),
            array("cache_theme", $_POST['cache_theme'], 'str'),
            array("https", $_POST['https'], 'str'),
            array("https_url", $_POST['https_url'], 'str'),
        ));

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['general_settings_updated']));
    }
}

// general settings
loadblock($MSG['site_name'], $MSG['site_name_explain'], 'text', 'sitename', $system->SETTINGS['sitename']);
loadblock($MSG['site_url'], $MSG['site_url_explain'], 'text', 'siteurl', $system->SETTINGS['siteurl']);
loadblock($MSG['admin_email'], $MSG['admin_email_explain'], 'text', 'adminmail', $system->SETTINGS['adminmail']);
loadblock($MSG['copyright_msg'], $MSG['copyright_msg_explain'], 'text', 'copyright', $system->SETTINGS['copyright']);

// batch settings
loadblock($MSG['batch_settings'], '', '', '', '', array(), true);
loadblock($MSG['run_cron'], $MSG['run_cron_explain'], 'batch', 'cron', $system->SETTINGS['cron'], array($MSG['batch'], $MSG['non_batch']));
loadblock($MSG['clear_closed_auctions'], $MSG['clear_closed_auctions_explain'], 'days', 'archiveafter', $system->SETTINGS['archiveafter'], array($MSG['5115']));

// optimisation settings
loadblock($MSG['optimisation'], '', '', '', '', array(), true);
loadblock($MSG['enable_template_cache'], $MSG['enable_template_cache_explain'], 'yesno', 'cache_theme', $system->SETTINGS['cache_theme'], array($MSG['yes'], $MSG['no']));

// SSL settings
loadblock($MSG['ssl_support'], '', '', '', '', array(), true);
loadblock($MSG['enable_ssl'], $MSG['enable_ssl_explain'], 'yesno', 'https', $system->SETTINGS['https'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['ssl_url'], $MSG['ssl_url_explain'], 'text', 'https_url', $system->SETTINGS['https_url']);

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['5142'],
        'PAGENAME' => $MSG['general_settings'],
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
