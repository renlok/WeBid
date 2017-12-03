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
    if ($_POST['status'] == 'enabled' && (!is_numeric($_POST['timebefore']) || !is_numeric($_POST['extend']))) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_numeric_values']));
    } elseif ($_POST['maxpicturesize'] == 0) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_max_pic_size_zero']));
    } elseif (!empty($_POST['maxpicturesize']) && !intval($_POST['maxpicturesize'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_max_pic_size_numeric']));
    } elseif (!empty($_POST['maxpictures']) && !intval($_POST['maxpictures'])) {
        $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_max_num_pics_numeric']));
    } else {
        $system->writesetting("proxy_bidding", ynbool($_POST['proxy_bidding']), 'str');
        $system->writesetting("edit_starttime", $_POST['edit_starttime'], 'int');
        $system->writesetting("edit_endtime", $_POST['edit_endtime'], 'int');
        $system->writesetting("cust_increment", $_POST['cust_increment'], 'int');
        $system->writesetting("hours_countdown", $_POST['hours_countdown'], 'int');
        $system->writesetting("ao_hpf_enabled", ynbool($_POST['ao_hpf_enabled']), 'str');
        $system->writesetting("ao_hi_enabled", ynbool($_POST['ao_hi_enabled']), 'str');
        $system->writesetting("ao_bi_enabled", ynbool($_POST['ao_bi_enabled']), 'str');
        $system->writesetting("subtitle", ynbool($_POST['subtitle']), 'str');
        $system->writesetting("extra_cat", ynbool($_POST['extra_cat']), 'str');
        $system->writesetting("autorelist", ynbool($_POST['autorelist']), 'str');
        $system->writesetting("autorelist_max", $_POST['autorelist_max'], 'int');
        $system->writesetting("ae_status", ynbool($_POST['status']), 'str');
        $system->writesetting("ae_timebefore", $_POST['timebefore'], 'int');
        $system->writesetting("ae_extend", $_POST['extend'], 'int');
        $system->writesetting("picturesgallery", $_POST['picturesgallery'], 'int');
        $system->writesetting("maxpictures", $_POST['maxpictures'], 'int');
        $system->writesetting("maxuploadsize", ($_POST['maxpicturesize'] * 1024), 'int');
        $system->writesetting("thumb_show", $_POST['thumb_show'], 'int');
        $system->writesetting("gallery_max_width_height", $_POST['gallery_max_width_height'], 'int');

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['auction_settings_updated']));
    }
}

loadblock($MSG['enable_proxy_bidding'], $MSG['enable_proxy_bidding_explain'], 'yesno', 'proxy_bidding', $system->SETTINGS['proxy_bidding'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_custom_start_date'], $MSG['enable_custom_start_date_explain'], 'batch', 'edit_starttime', $system->SETTINGS['edit_starttime'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_custom_end_date'], $MSG['enable_custom_end_date_explain'], 'batch', 'edit_endtime', $system->SETTINGS['edit_endtime'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_custom_increments'], $MSG['enable_custom_increments_explain'], 'batch', 'cust_increment', $system->SETTINGS['cust_increment'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['hours_until_countdown'], $MSG['hours_until_countdown_explain'], 'days', 'hours_countdown', $system->SETTINGS['hours_countdown'], array($MSG['25_0037']));

loadblock($MSG['additional_auction_options'], '', '', '', '', array(), true);
loadblock($MSG['enable_featured_items'], $MSG['enable_featured_items_explain'], 'yesno', 'ao_hpf_enabled', $system->SETTINGS['ao_hpf_enabled'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_hightlighted_items'], $MSG['enable_hightlighted_items_explain'], 'yesno', 'ao_hi_enabled', $system->SETTINGS['ao_hi_enabled'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_bold_items'], $MSG['enable_bold_items_explain'], 'yesno', 'ao_bi_enabled', $system->SETTINGS['ao_bi_enabled'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_subtitles'], $MSG['enable_subtitles_explain'], 'yesno', 'subtitle', $system->SETTINGS['subtitle'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_second_cat'], $MSG['enable_second_cat_explain'], 'yesno', 'extra_cat', $system->SETTINGS['extra_cat'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['enable_auto_relist'], $MSG['enable_auto_relist_explain'], 'yesno', 'autorelist', $system->SETTINGS['autorelist'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['max_relists'], $MSG['max_relists_explain'], 'days', 'autorelist_max', $system->SETTINGS['autorelist_max']);

// auction extension options
loadblock($MSG['auction_extension_settings'], '', '', '', '', array(), true); // :O
loadblock($MSG['enable_auto_extension'], $MSG['enable_auto_extension_explain'], 'yesno', 'status', $system->SETTINGS['ae_status'], array($MSG['yes'], $MSG['no']));
$string = sprintf($MSG['auto_extend_auction_by'], '<input type="text" name="extend" value="' . $system->SETTINGS['ae_extend'] . '" size="5">', '<input type="text" name="timebefore" value="' . $system->SETTINGS['ae_timebefore'] . '" size="5">');
loadblock('', $string, '');

// picture gallery options
loadblock($MSG['663'], '', '', '', '', array(), true);
loadblock($MSG['enable_picture_gallery'], $MSG['enable_picture_gallery_explain'], 'batch', 'picturesgallery', $system->SETTINGS['picturesgallery'], array($MSG['yes'], $MSG['no']));
loadblock($MSG['gallery_images_allowance'], '', 'days', 'maxpictures', $system->SETTINGS['maxpictures']);
loadblock($MSG['gallery_image_max_kb'], $MSG['gallery_image_max_kb_explain'], 'decimals', 'maxpicturesize', ($system->SETTINGS['maxuploadsize'] / 1024), array($MSG['672']));
loadblock($MSG['thumbnail_size'], $MSG['thumbnail_size_explain'], 'decimals', 'thumb_show', $system->SETTINGS['thumb_show'], array($MSG['pixels']));
loadblock($MSG['gallery_image_max_size'], $MSG['gallery_image_max_size_explain'], 'decimals', 'gallery_max_width_height', $system->SETTINGS['gallery_max_width_height'], array($MSG['pixels']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['5142'],
        'PAGENAME' => $MSG['auction_settings']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
