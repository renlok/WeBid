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

if (!defined('InWeBid')) exit();

$emailer = new email_handler();
$emailer->assign_vars(array(
		'C_ID' => addslashes($TPL_id_hidden),
		'C_NAME' => addslashes($TPL_name_hidden),
		'C_NICK' => addslashes($TPL_nick_hidden),
		'C_ADDRESS' => addslashes($_POST['TPL_address']),
		'C_CITY' => addslashes($_POST['TPL_city']),
		'C_PROV' => addslashes($_POST['TPL_prov']),
		'C_ZIP' => addslashes($_POST['TPL_zip']),
		'C_COUNTRY' => addslashes($_POST['TPL_country']),
		'C_PHONE' => addslashes($_POST['TPL_phone']),
		'C_EMAIL' => addslashes($_POST['TPL_email']),
		'C_PASSWORD' => addslashes($TPL_password_hidden),
		'SITENAME' => $system->SETTINGS['sitename'],
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ADMINEMAIL' => $system->SETTINGS['adminmail'],
		'CONFIRMATION_PAGE' => $system->SETTINGS['siteurl'] . 'confirm.php?id=' . $TPL_id_hidden . '&hash=' . md5($MD5_PREFIX . $hash),
		'LOGO' => $system->SETTINGS['siteurl'] . 'uploaded/logo/' . $system->SETTINGS['logo']
		));
$emailer->email_uid = $TPL_id_hidden;
if (!$system->SETTINGS['email_admin_on_signup'])
{
	$email_to = $TPL_email_hidden;
}
else
{
	$email_to = array($TPL_email_hidden, $system->SETTINGS['adminmail']);
}
$emailer->email_sender($email_to, 'user_needapproval.inc.php', $system->SETTINGS['sitename']. ' '.$MSG['098']);
