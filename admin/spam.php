<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (($_POST['spam_sendtofriend'] == 2 || $_POST['spam_register'] == 2 || $_POST['spam_reportitem'] == 2) && empty($_POST['recaptcha_public']) && empty($_POST['recaptcha_private']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['751']));
	}
	else
	{
		$system->writesetting("recaptcha_public", $_POST['recaptcha_public'], 'str');
		$system->writesetting("recaptcha_private", $_POST['recaptcha_private'], 'str');
		$system->writesetting("spam_sendtofriend", $_POST['spam_sendtofriend'], 'int');
		$system->writesetting("spam_reportitem", $_POST['spam_reportitem'], 'int');
		$system->writesetting("spam_register", $_POST['spam_register'], 'int');
		$system->writesetting("spam_blocked_email_enabled", $_POST['spam_blocked_email_enabled'], 'bool');
		$system->writesetting("spam_blocked_email_domains", $_POST['spam_blocked_email_domains'], 'str');
		
		$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['750']));
	}
}

loadblock($MSG['746'], $MSG['748'], 'text', 'recaptcha_public', $system->SETTINGS['recaptcha_public']);
loadblock($MSG['747'], '', 'text', 'recaptcha_private', $system->SETTINGS['recaptcha_private']);
loadblock($MSG['743'], $MSG['745'], 'select3num', 'spam_register', $system->SETTINGS['spam_register'], array($MSG['740'], $MSG['741'], $MSG['742']));
loadblock($MSG['744'], '', 'select3num', 'spam_sendtofriend', $system->SETTINGS['spam_sendtofriend'], array($MSG['740'], $MSG['741'], $MSG['742']));
loadblock($MSG['item_report_captcha_type'], '', 'select3num', 'spam_reportitem', $system->SETTINGS['spam_reportitem'], array($MSG['740'], $MSG['741'], $MSG['742']));
loadblock($MSG['spam_blocked_email_enabled'], '', 'bool', 'spam_blocked_email_enabled', $system->SETTINGS['spam_blocked_email_enabled'], array($MSG['759'], $MSG['760']));
loadblock($MSG['spam_blocked_email_domains'], $MSG['spam_blocked_email_domains_explain'], 'textarea', 'spam_blocked_email_domains', $system->SETTINGS['spam_blocked_email_domains']);

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPENAME' => $MSG['5142'],
		'PAGENAME' => $MSG['749']
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'footer.php';
?>
