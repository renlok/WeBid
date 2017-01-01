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

$mail_protocol = array('0' => 'WEBID MAIL', '1' => 'MAIL', '2' => 'SMTP', '4' => 'SENDMAIL', '5'=> 'QMAIL', '3' => 'NEVER SEND EMAILS (may be useful for testing purposes)');
$smtp_secure_options =array('none' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL');

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // checks
    if (intval($_POST['mail_protocol']) == 2) {
        if (empty($_POST['smtp_host']) || empty($_POST['smtp_username']) || empty($_POST['smtp_password']) || empty($_POST['smtp_port']) || intval($_POST['smtp_port']) <= 0) {
            $template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['error_missing_SMTP_settings']));
        }
    }

    if (array_key_exists(intval($_POST['mail_protocol']), $mail_protocol)) {
        if (intval($_POST['mail_protocol']) !== 2) {
            $system->writesetting("mail_protocol", $_POST['mail_protocol'], 'int');
            $system->writesetting("mail_parameter", $_POST['mail_parameter'], 'str');
            $system->writesetting("alert_emails", $_POST['alert_emails'], 'str');
        } else {
            $system->writesetting("mail_protocol", 2, 'int');
            $system->writesetting("smtp_authentication", $_POST['smtp_authentication'], 'str');
            $system->writesetting("smtp_security", $_POST['smtp_security'], 'str');
            $system->writesetting("smtp_port", (!empty($_POST['smtp_port']) && is_numeric($_POST['smtp_port']))? (int)($_POST['smtp_port']) : '', 'int');
            $system->writesetting("smtp_username", (!empty($_POST['smtp_username'])? $_POST['smtp_username'] : ''), 'str');
            $system->writesetting("smtp_password", (!empty($_POST['smtp_password'])? $_POST['smtp_password'] : ''), 'str');
            $system->writesetting("smtp_host", (!empty($_POST['smtp_host'])? $_POST['smtp_host'] : ''), 'str');
            $system->writesetting("smtp_emails", $_POST['alert_emails'], 'str');
        }
        $INFO = $MSG['email_settings_updated'];
    }
}

$selectsetting = isset($system->SETTINGS['mail_protocol'])? $system->SETTINGS['mail_protocol'] : '0';
loadblock($MSG['mail_protocol'], '', generateSelect('mail_protocol', $mail_protocol));
loadblock($MSG['mail_parameters'], '<span class="non_smtp para">' . $MSG['mail_parameters_explain'], 'text', 'mail_parameter', $system->SETTINGS['mail_parameter']);
loadblock($MSG['SMTP_settings'] .'<span class="smtp"></span>' . $MSG['SMTP_settings_explain'], '', '', '', '', array(), true);
loadblock($MSG['SMTP_authentication'], '<span class="smtp"></span>', 'yesno', 'smtp_authentication', $system->SETTINGS['smtp_authentication'], array($MSG['yes'], $MSG['no']));

$selectsetting = isset($system->SETTINGS['smtp_security'])? $system->SETTINGS['smtp_security'] : 'none';
loadblock($MSG['SMTP_security'], '<span class="smtp"></span>', generateSelect('smtp_security', $smtp_secure_options));
loadblock($MSG['SMTP_port'], '<span class="smtp"></span>', 'text', 'smtp_port', $system->SETTINGS['smtp_port']);
loadblock($MSG['SMTP_username'], '<span class="smtp"></span>', 'text', 'smtp_username', $system->SETTINGS['smtp_username']);
loadblock($MSG['SMTP_password'], '<span class="smtp"></span>', 'text', 'smtp_password', $system->SETTINGS['smtp_password']);
loadblock($MSG['SMTP_host'], '<span class="smtp"></span>' . $MSG['SMTP_host_explain'], 'text', 'smtp_host', $system->SETTINGS['smtp_host']);
loadblock($MSG['other_admin_emails'], sprintf($MSG['other_admin_emails_explain'], $system->SETTINGS['adminmail']), 'text', 'alert_emails', $system->SETTINGS['alert_emails']);

// send test email
if (isset($_GET['test_email'])) {
    $user_name      = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $to_email       = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
    $subject        = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $message        = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    $emailer = new email_handler();
    $emailer->email_basic($subject, $to_email, $message);
    die();
}

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['524'],
        'PAGENAME' => $MSG['email_settings'],

        'MAIL_PROTOCOL' => $mail_protocol[$system->SETTINGS['mail_protocol']],
        'SMTP_AUTH' => $system->SETTINGS['smtp_authentication'],
        'SMTP_SEC' => $system->SETTINGS['smtp_security'],
        'SMTP_PORT' => (!empty($system->SETTINGS['smtp_port']) && is_numeric($system->SETTINGS['smtp_port'])) ? $system->SETTINGS['smtp_port'] : 25,
        'SMTP_USER' => $system->SETTINGS['smtp_username'],
        'SMTP_PASS' => $system->SETTINGS['smtp_password'],
        'SMTP_HOST' => $system->SETTINGS['smtp_host'],
        'ALERT_EMAILS' => $system->SETTINGS['alert_emails'],
        'ADMIN_EMAIL' => $system->SETTINGS['adminmail'],
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'emailsettings.tpl'
        ));
$template->display('body');
include 'footer.php';
