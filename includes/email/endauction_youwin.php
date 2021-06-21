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

if(strlen(strip_tags($Auction['description'])) > 60)
{
	$description = substr(strip_tags($Auction['description']), 0, 50) . '...';
}
else
{
	$description = $Auction['description'];
}

$emailer = new email_handler();
$emailer->assign_vars(array(
		'W_NAME' => $Winner['name'],
		'W_WANTED' => $Winner['wanted'],
		'W_GOT' => $Winner['quantity'],

		'A_URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $Auction['id'],
		'A_TITLE' => htmlspecialchars($Auction['title']),
		'A_DESCRIPTION' => $description,
		'A_CURRENTBID' => $system->print_money($WINNERS_BID[$Winner['current_bid']]),
		'A_ENDS' => $ends_string,

		'S_NICK' => $Seller['nick'],
		'S_EMAIL' => $Seller['email'],
		'S_PAYMENT' => $Seller['payment_details'],

		'SITE_URL' => $system->SETTINGS['siteurl'],
		'SITENAME' => $system->SETTINGS['sitename'],
		'ADMINEMAIL' => $system->SETTINGS['adminmail']
		));
$emailer->email_uid = $Winner['id'];
$emailer->email_sender($Winner['email'], 'endauction_youwin.inc.php', $MSG['909']);
