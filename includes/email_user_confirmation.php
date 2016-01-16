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
		'SITENAME' => $system->SETTINGS['sitename'],
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ADMINMAIL' => $system->SETTINGS['adminmail'],
		'CONFIRMURL' => $system->SETTINGS['siteurl'] . 'confirm.php?id=' . $TPL_id_hidden . '&hash=' . md5($MD5_PREFIX . $TPL_nick_hidden),
		'C_NAME' => $TPL_name_hidden
		));
$emailer->email_uid = $TPL_id_hidden;
$emailer->email_sender($TPL_email_hidden, 'usermail.inc.php', $system->SETTINGS['sitename'] . ' ' . $MSG['098']);