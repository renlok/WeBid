<?php
/***************************************************************************
 *   copyright              : (C) 2008 - 2016 WeBid
 *   site                   : http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

define('InAdmin', 1);
$current_page = 'stats';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $trackingcode = $_POST['trackingcode'];

    $system->writesetting("googleanalytics", $trackingcode, 'str');

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['google_analytics_updated']));
}

loadblock($MSG['google_analytics_tracking_code'], $MSG['google_analytics_tracking_code_hint'], 'textarea', 'trackingcode', $system->SETTINGS['googleanalytics']);

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0023'],
        'PAGENAME' => $MSG['google_analytics'],
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
?>
