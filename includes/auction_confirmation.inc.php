<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
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

include $include_path . "messages.inc.php";

if ($user->user_data['startemailmode'] == 'yes')
{	
	$emailer = new email_class();
	$emailer->assign_vars(array(
			'SITE_URL' => $system->SETTINGS['siteurl'],
			'SITENAME' => $system->SETTINGS['sitename'],
			
			'A_ID' => $auction_id,
			'A_TITLE' => $_SESSION['SELL_title'],
			'A_TYPE' => ($_SESSION['SELL_atype'] == 1) ? $MSG['642'] : $MSG['641'],
			'A_PICURL' => ($_SESSION['SELL_pict_url'] != '') ? $uploaded_path . $auction_id . '/' . $pict_url : 'images/email_alerts/default_item_img.jpg',
			'A_MINBID' => $system->print_money($_SESSION['SELL_minimum_bid']),
			'A_RESERVE' => $system->print_money($_SESSION['SELL_reserve_price']),
			'A_BNPRICE' => $system->print_money($_SESSION['SELL_buy_now_price']),
			'A_ENDS' => ArrangeDateNoCorrection($a_ends + $system->tdiff),
			
			'C_NAME' => $user->user_data['name']
			));
	$emailer->email_uid = $user->user_data['id'];
	$subject = $system->SETTINGS['sitename'] . ' ' . $MSG['099'] . ': ' . $_SESSION['SELL_title'] . ' (' . $auction_id . ')';
	$emailer->email_sender($user->user_data['email'], 'mail_auctionmail.inc.php', $subject);
}
?>
