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

if(!defined('InWeBid')) exit();

include $include_path . "messages.inc.php";

// Check if the e-mail has to be sent or not
$emailmode = @mysql_result(@mysql_query("SELECT startemailmode FROM " . $DBPrefix . "users WHERE id = '" . $_SESSION['WEBID_LOGGED_IN'] . "'"),0,"startemailmode");
if($emailmode != 'yes') return;

// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM " . $DBPrefix . "userslanguage WHERE user = '" . $_SESSION['WEBID_LOGGED_IN'] . "'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $language;

$buffer = file($main_path . "language/" . $USERLANG . "/mail_auctionmail.inc.php");
$i = 0;
$j = 0;
while($i < count($buffer)) {
	if(!ereg("^#(.)*$", $buffer[$i])){
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}


// Handle time correction
$ENDS = explode(' ', $a_ends);
$ENDS_DATE = ArrangeDateNoCorrection($a_ends + $system->tdiff);

$message = implode($skipped_buffer, '');

//--Change TAGS with variables content
$message = ereg_replace("<#c_name#>", $userrec['name'], $message);
$message = ereg_replace("<#c_nick#>", $userrec['nick'], $message);
$message = ereg_replace("<#c_address#>", $userrec['address'], $message);
$message = ereg_replace("<#c_city#>", $userrec['city'], $message);
$message = ereg_replace("<#c_country#>", $userrec['country'], $message);
$message = ereg_replace("<#c_zip#>", $userrec['zip'], $message);
$message = ereg_replace("<#c_email#>", $userrec['email'], $message);
if($_SESSION['SELL_atype'] == 1) {
	$message = ereg_replace("<#a_type#>", $MSG['642'], $message);
} else {
	$message = ereg_replace("<#a_type#>", $MSG['641'], $message);
}
$message = ereg_replace("<#a_buyitnow#>", $system->print_money($buy_now_price), $message);
$message = ereg_replace("<#a_qty#>", $_SESSION['SELL_iquantity'], $message);
$message = ereg_replace("<#a_title#>", $_SESSION['SELL_title'], $message);
$message = ereg_replace("<#a_id#>", "'" . $auction_id . "'", $message);
$message = ereg_replace("<#a_description#>", substr(strip_tags($_SESSION['SELL_description']),0,50) . "...", $message);
if ($_SESSION['SELL_pict_url'] != '') {
	$apict_url = $system->SETTINGS['siteurl'] . $uploaded_path . $auction_id . '/' . $pict_url;
} else {
	$apict_url = $system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg';
}
$message = ereg_replace("<#a_picturl#>", $apict_url, $message);
$message = ereg_replace("<#a_minbid#>", $system->print_money($_SESSION['SELL_minimum_bid']), $message);
$message = ereg_replace("<#a_resprice#>", $system->print_money($_SESSION['SELL_reserve_price']), $message);
$message = ereg_replace("<#a_buynowprice#>", $system->print_money($_SESSION['SELL_buy_now_price']), $message);
$message = ereg_replace("<#a_duration#>", $_SESSION['SELL_duration'], $message);
$message = ereg_replace("<#a_location#>", $location, $message);
$message = ereg_replace("<#a_zip#>", $_SESSION['SELL_location_zip'], $message);
$auction_url = $system->SETTINGS['siteurl'] . 'item.php?id=' . $auction_id;
$message = ereg_replace("<#a_url#>", $auction_url, $message);
$message = ereg_replace("<#c_sitename#>", $system->SETTINGS['sitename'], $message);
$message = ereg_replace("<#c_siteurl#>", $system->SETTINGS['siteurl'],$message);
$message = ereg_replace("<#c_adminemail#>", $system->SETTINGS['adminmail'],  $message);


if($customincrement > 0) {
	$message = ereg_replace("<#a_customincrement#>", $system->print_money($_SESSION['SELL_customincrement']), $message);
} else {
	$message = ereg_replace("<#a_customincrement#>", $MSG['614'], $message);
}

if($shipping == '1'){
	$shipping_string = $MSG['031'];
} else {
	$shipping_string = $MSG['032'];
}
$message = ereg_replace("<#a_shipping#>", $shipping_string, $message);

if($international) {
	$int_string = $MSG['033'];
} else {
	$int_string = $MSG['043'];
}
$message = ereg_replace("<#a_intern#>", $int_string, $message);
$message = ereg_replace("<#a_payment#>", $payment_text, $message);
$message = ereg_replace("<#a_category#>", $_SESSION['categoriesList'], $message);
$message = ereg_replace("<#a_ends#>", $ENDS_DATE, $message);
$message = ereg_replace("&nbsp;", " ", $message);

mail($userrec['email'], $system->SETTINGS['sitename'] . ' '. $MSG['099'] .': ' . $_SESSION['SELL_title'] . ' (' . $auction_id .')', $message, "From:" . $system->SETTINGS['sitename'] . " <" . $system->SETTINGS['adminmail'] . ">\n" . "Content-Type: text/html; charset=$CHARSET");
?>
