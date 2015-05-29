<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
include $include_path . 'functions_admin.php';
$extraJs = ';js/jquery-ui.js;js/jquery-migrate.js';
include 'loggedin.inc.php';

unset($ERR);

$mail_protocol = array('0' => 'WEBID MAIL', '1' => 'MAIL', '2' => 'SMTP', '4' => 'SENDMAIL', '5'=> 'QMAIL', '3' => 'NEVER SEND EMAILS (may be useful for testing purposes)');
$smtp_secure_options =array('none' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL');

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// checks 
	if (intval($_POST['mail_protocol']) == 2)
	{
		if (empty($_POST['smtp_host']) || empty($_POST['smtp_username']) || empty($_POST['smtp_password']) || empty($_POST['smtp_port']) || intval($_POST['smtp_port']) <= 0 )
		{ 
			$ERR = $MSG['1132'];
		}
	}
	
	if (array_key_exists(intval($_POST['mail_protocol']), $mail_protocol))
	{
	
	  if  (intval($_POST['mail_protocol']) !== 2)
	  {
	   // Update database
			$query = "UPDATE ". $DBPrefix . "settings SET
					mail_protocol = " . intval($_POST['mail_protocol']) . ",
					mail_parameter = '" . $_POST['mail_parameter'] . "',
					alert_emails = '" . $_POST['alert_emails'] . "'";
			$db->direct_query($query);
	    }
		else
		{
			$query = "UPDATE ". $DBPrefix . "settings SET
					mail_protocol = 2,
					smtp_authentication = '" . $_POST['smtp_authentication'] . "',
					smtp_security = '" . $_POST['smtp_security'] . "',
					smtp_port = " . intval($_POST['smtp_port']) . ",
					smtp_username = '" . (!empty($_POST['smtp_username'])? $_POST['smtp_username'] : '') . "',
					smtp_password = '" . (!empty($_POST['smtp_password'])? $_POST['smtp_password'] : '') . "',
					smtp_host = '" . (!empty($_POST['smtp_host'])? $_POST['smtp_host'] : '') . "',
					alert_emails = '" . $_POST['alert_emails'] . "'";
			$db->direct_query($query);
	    }
	  $ERR = $MSG['895'];
	} 
	
    $system->SETTINGS['mail_protocol'] = intval($_POST['mail_protocol']);
	$system->SETTINGS['mail_parameter'] = $_POST['mail_parameter'];
	$system->SETTINGS['smtp_authentication'] = $_POST['smtp_authentication'];
	$system->SETTINGS['smtp_security'] = $_POST['smtp_security'];
	$system->SETTINGS['smtp_port'] = (!empty($_POST['smtp_port']) && is_numeric($_POST['smtp_port']))? (int)($_POST['smtp_port']) : '';
	$system->SETTINGS['smtp_username'] = $_POST['smtp_username'];
	$system->SETTINGS['smtp_password'] = $_POST['smtp_password'];
	$system->SETTINGS['smtp_host'] = $_POST['smtp_host'];
	$system->SETTINGS['alert_emails'] = $_POST['alert_emails'];
}

$selectsetting = isset($system->SETTINGS['mail_protocol'])? $system->SETTINGS['mail_protocol'] : '0';
loadblock($MSG['1119'], '', generateSelect('mail_protocol', $mail_protocol));
loadblock($MSG['1120'] , '<span class="non_smtp para">' . $MSG['1121'], 'text', 'mail_parameter', $system->SETTINGS['mail_parameter']);
loadblock($MSG['1133'] .'<span class="smtp"></span>' . $MSG['1141'], '', '', '', '', array(), true);
loadblock($MSG['1128'], '<span class="smtp"></span>', 'yesno', 'smtp_authentication', $system->SETTINGS['smtp_authentication'], array($MSG['030'], $MSG['029']));

$selectsetting = isset($system->SETTINGS['smtp_security'])? $system->SETTINGS['smtp_security'] : 'none';
loadblock($MSG['1127'] , '<span class="smtp"></span>', generateSelect('smtp_security', $smtp_secure_options));
loadblock($MSG['1126'] , '<span class="smtp"></span>', 'text', 'smtp_port', $system->SETTINGS['smtp_port']);
loadblock($MSG['1124'], '<span class="smtp"></span>', 'text', 'smtp_username', $system->SETTINGS['smtp_username']);
loadblock($MSG['1125'] , '<span class="smtp"></span>', 'text', 'smtp_password', $system->SETTINGS['smtp_password']);
loadblock($MSG['1122'] , '<span class="smtp"></span>', 'text', 'smtp_host', $system->SETTINGS['smtp_host']);
loadblock($MSG['1129'] , sprintf($MSG['1130'], $system->SETTINGS['adminmail']), 'text', 'alert_emails', $system->SETTINGS['alert_emails']);

$mail_info2 = '';

// send test email
if (isset($_GET['test_email']))
{
	$user_name      = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
	$to_email       = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
	$subject        = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
	$message        = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
    
	$emailer = new email_handler();
	$send_mail = $emailer->email_basic($subject, $to_email, $message);
	if($send_mail)
    {
		$output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.Response:<br>' . $send_mail));
		die($output);
    }
	else
	{
		$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_name .' Your email(s) has been processed and sent. No error(s) to report.'));
		die($output);
    }
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['524'],
		'PAGENAME' => $MSG['1131'],

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

$template->set_filenames(array(
		'body' => 'emailsettings.tpl'
		));
$template->display('body');
?>