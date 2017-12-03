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
$current_page = 'interface';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
        // Handle logo upload
        $inf = GetImageSize($_FILES['logo']['tmp_name']);
        if ($inf[2] < 1 || $inf[2] > 3) {
            $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_602));
        } elseif (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name'] != "none") {
            if (move_uploaded_file($_FILES['logo']['tmp_name'], UPLOAD_PATH . 'logo/' . $_FILES['logo']['name'])) {
                $system->writesetting("logo", $_FILES['logo']['name'], "str");
            } else {
                $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['upload_failed']));
            }
        }
    }
    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['logo_upload_success']));
}

$logoURL = $system->SETTINGS['siteurl'] . 'uploaded/logo/' . $system->SETTINGS['logo'];
loadblock($MSG['your_logo'], $MSG['current_logo'], 'image', 'logo', $system->SETTINGS['logo']);
loadblock('', $MSG['upload_new_logo'], 'upload', 'logo', $system->SETTINGS['logo']);

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'IMAGEURL' => $logoURL,
        ));
include 'header.php';
$template->set_filenames(array(
        'body' => 'logo_upload.tpl'
        ));
$template->display('body');
include 'footer.php';
