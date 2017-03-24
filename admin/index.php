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
$current_page = 'home';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include INCLUDE_PATH . 'config/timezones.php';
include 'loggedin.inc.php';

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'clearcache':
            if (is_dir(MAIN_PATH . 'cache')) {
                $dir = opendir(MAIN_PATH . 'cache');
                while (($myfile = readdir($dir)) !== false) {
                    if ($myfile != '.' && $myfile != '..' && $myfile != 'index.php') {
                        unlink(CACHE_PATH . $myfile);
                    }
                }
                closedir($dir);
            }
            $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['cache_cleared']));
        break;

        case 'clear_image_cache':
        if (is_dir(UPLOAD_PATH . '/cache')) {
            $dir = opendir(UPLOAD_PATH . '/cache');
            while (($myfile = readdir($dir)) !== false) {
                if ($myfile != '.' && $myfile != '..' && $myfile != 'index.php') {
                    unlink(IMAGE_CACHE_PATH . $myfile);
                }
            }
            closedir($dir);
        }
            $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['image_cache_cleared']));
        break;

        case 'updatecounters':
            //update users counter
            $query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "users WHERE suspended = 0";
            $db->direct_query($query);
            $USERS = $db->result('COUNT');
            $query = "UPDATE " . $DBPrefix . "counters SET users = :USERS";
            $params = array();
            $params[] = array(':USERS', $USERS, 'int');
            $db->query($query, $params);

            //update suspended users counter
            $query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "users WHERE suspended != 0";
            $db->direct_query($query);
            $USERS = $db->result('COUNT');
            $query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = :USERS";
            $params = array();
            $params[] = array(':USERS', $USERS, 'int');
            $db->query($query, $params);

            //update auction counter
            $query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE closed = 0 AND suspended = 0";
            $db->direct_query($query);
            $AUCTIONS = $db->result('COUNT');
            $query = "UPDATE " . $DBPrefix . "counters SET auctions = :AUCTIONS";
            $params = array();
            $params[] = array(':AUCTIONS', $AUCTIONS, 'int');
            $db->query($query, $params);

            //update closed auction counter
            $query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE closed = 1";
            $db->direct_query($query);
            $AUCTIONS = $db->result('COUNT');
            $query = "UPDATE " . $DBPrefix . "counters SET closedauctions = :AUCTIONS";
            $params = array();
            $params[] = array(':AUCTIONS', $AUCTIONS, 'int');
            $db->query($query, $params);

            //update suspended auctions counter
            $query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE closed = 0 and suspended != 0";
            $db->direct_query($query);
            $AUCTIONS = $db->result('COUNT');
            $query = "UPDATE " . $DBPrefix . "counters SET suspendedauctions = :AUCTIONS";
            $params = array();
            $params[] = array(':AUCTIONS', $AUCTIONS, 'int');
            $db->query($query, $params);

            //update bids
            $query = "SELECT COUNT(b.id) As COUNT FROM " . $DBPrefix . "bids b
                      LEFT JOIN " . $DBPrefix . "auctions a ON (b.auction = a.id)
                      WHERE a.closed = 0 AND a.suspended = 0";
            $db->direct_query($query);
            $BIDS = $db->result('COUNT');
            $query = "UPDATE " . $DBPrefix . "counters SET bids = :BIDS";
            $params = array();
            $params[] = array(':BIDS', $BIDS, 'int');
            $db->query($query, $params);

            resync_category_counters();

            $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['counters_updated']));
        break;
    }
}

$query = "SELECT * FROM " . $DBPrefix . "counters";
$db->direct_query($query);
$COUNTERS = $db->result();

$query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE year = :year AND month = :month AND day = :day";
$params = array();
$params[] = array(':year', date('Y'), 'str');
$params[] = array(':month', date('m'), 'str');
$params[] = array(':day', date('d'), 'str');
$db->query($query, $params);
$ACCESS = $db->result();
$ACCESS['pageviews'] = (!isset($ACCESS['pageviews']) || empty($ACCESS['pageviews'])) ? 0 : $ACCESS['pageviews'];
$ACCESS['uniquevisitors'] = (!isset($ACCESS['uniquevisitors']) || empty($ACCESS['uniquevisitors'])) ? 0 : $ACCESS['uniquevisitors'];
$ACCESS['usersessions'] = (!isset($ACCESS['usersessions']) || empty($ACCESS['usersessions'])) ? 0 : $ACCESS['usersessions'];

if ($system->SETTINGS['activationtype'] == 0) {
    $query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users WHERE suspended = 10";
    $db->direct_query($query);
    $uuser_count = $db->result('COUNT');
}

// version check
$realversion = '0.0';
$update_available = false;
if ($system->SETTINGS['version_check'] !== "") {
    switch ($system->SETTINGS['version_check']) {
        case 'unstable':
            $url = 'http://raw.githubusercontent.com/renlok/WeBid/dev/install/thisversion.txt';
            break;
        default:
          $url = 'http://raw.githubusercontent.com/renlok/WeBid/master/install/thisversion.txt';
            break;
    }
    if (!($realversion = load_file_from_url($url))) {
        $ERR = $MSG['error_file_access_disabled'];
        $realversion = $MSG['unknown'];
    }
}

$update_available = false;
if (version_compare($system->SETTINGS['version'], $realversion, "<")) {
    $update_available = true;
    $text = $MSG['outdated_version'];
}

//getting the correct email settings
$mail_protocol = array('0' => 'WEBID MAIL', '1' => 'MAIL', '2' => 'SMTP', '4' => 'SENDMAIL', '5'=> 'QMAIL', '3' => 'NEVER SEND EMAILS (may be useful for testing purposes)');

$template->assign_vars(array(
        'SITENAME' => $system->SETTINGS['sitename'],
        'ADMINMAIL' => $system->SETTINGS['adminmail'],
        'CRON' => ($system->SETTINGS['cron'] == 1) ? '<b>' . $MSG['batch'] . '</b><br>' . $MSG['25_0027'] : '<b>' . $MSG['non_batch'] . '</b>',
        'GALLERY' => ($system->SETTINGS['picturesgallery'] == 1) ? '<b>' . $MSG['2__0066'] . '</b><br>' . $MSG['gallery_images_allowance'] . ': ' . $system->SETTINGS['maxpictures'] . '<br>' . $MSG['gallery_image_max_kb'] . ': ' . $system->SETTINGS['maxuploadsize']/1024 . ' KB' : '<b>' . $MSG['2__0067'] . '</b>',
        'BUY_NOW' => ($system->SETTINGS['buy_now'] == 1) ? '<b>' . $MSG['2__0067'] . '</b>' : '<b>' . $MSG['2__0066'] . '</b>',
        'CURRENCY' => $system->SETTINGS['currency'],
        'TIMEZONE' => $timezones[$system->SETTINGS['timezone']],
        'DATEFORMAT' => $system->SETTINGS['datesformat'],
        'DATEEXAMPLE' => ($system->SETTINGS['datesformat'] == 'USA') ? $MSG['american_dates'] : $MSG['european_dates'],
        'DEFULTCONTRY' => $system->SETTINGS['defaultcountry'],
        'USERCONF' => $system->SETTINGS['activationtype'],
        'EMAIL_HANDLER' => $mail_protocol[$system->SETTINGS['mail_protocol']],

        'C_USERS' => $COUNTERS['users'],
        'C_IUSERS' => $COUNTERS['inactiveusers'],
        'C_UUSERS' => (isset($uuser_count)) ? $uuser_count : '',
        'C_AUCTIONS' => $COUNTERS['auctions'],
        'C_CLOSED' => $COUNTERS['closedauctions'],
        'C_BIDS' => $COUNTERS['bids'],

        'A_PAGEVIEWS' => $ACCESS['pageviews'],
        'A_UVISITS' => $ACCESS['uniquevisitors'],
        'A_USESSIONS' => $ACCESS['usersessions'],

        'THIS_VERSION' => $system->SETTINGS['version'],
        'CUR_VERSION' => $realversion,
        'UPDATE_AVAILABLE' => $update_available
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'home.tpl'
        ));
$template->display('body');
include 'footer.php';
