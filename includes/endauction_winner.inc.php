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

// Check if the e-mail has to be sent or not
$emailmode = @mysql_result(@mysql_query("SELECT endemailmode FROM " . $DBPrefix . "users WHERE id='".$Seller['id']."'"),0,"endemailmode");
if ($emailmode != 'one') return;

// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM " . $DBPrefix . "userslanguage WHERE user='".$Seller['id']."'"),0,"language");
if (!isset($USERLANG)) $USERLANG = $language;

$buffer = file($main_path."language/".$USERLANG."/mail_endauction_winner.inc.php");
$i = 0;
$j = 0;
while ($i < count($buffer)) {
	if (!ereg("^#(.)*$",$buffer[$i])) {
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}

//--Retrieve message
$message = implode($skipped_buffer,"");

//--Change TAGS with variables content

$message = ereg_replace("<#s_name#>",$Seller['name'],$message);
$message = ereg_replace("<#s_nick#>",$Seller['nick'],$message);
$message = ereg_replace("<#s_email#>",$Seller['email'],$message);
$message = ereg_replace("<#s_address#>",$Seller['address'],$message);
$message = ereg_replace("<#s_city#>",$Seller['city'],$message);
$message = ereg_replace("<#s_prov#>",$Seller['prov'],$message);
$message = ereg_replace("<#s_country#>",$Seller['country'],$message);
$message = ereg_replace("<#s_zip#>",$Seller['zip'],$message);
$message = ereg_replace("<#s_phone#>",$Seller['phone'],$message);
$message = ereg_replace("<#w_report#>",$report_text,$message);
if ($Auction['pict_url'] != '') {
	$Auction['pict_url'] = $system->SETTINGS['siteurl'] . $uploaded_path . $Auction['id'] . '/' . $Auction['pict_url'];
} else {
	$Auction['pict_url'] = $system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg';
}
$message = ereg_replace("<#a_picturl#>", $Auction['pict_url'], $message);
$message = ereg_replace("<#i_title#>",$Auction['title'],$message);
$message = ereg_replace("<#i_currentbid#>",$system->print_money($Auction['current_bid']),$message);
$message = ereg_replace("<#i_description#>",substr(strip_tags($Auction['description']),0,50)."...",$message);
$message = ereg_replace("<#i_qty#>",$Auction['quantity'],$message);
$auction_url = $SITE_URL."item.php?id=".$Auction['id'];
$message = ereg_replace("<#i_url#>",$auction_url,$message);
$message = ereg_replace("<#i_ends#>",$ends_string,$message);

$message = ereg_replace("<#c_sitename#>",$system->SETTINGS['sitename'],$message);
$message = ereg_replace("<#c_siteurl#>",$system->SETTINGS['siteurl'],$message);
$message = ereg_replace("<#c_adminemail#>",$system->SETTINGS['adminmail'],$message);

mail($Seller['email'],$system->SETTINGS['sitename'] . ' '.$MSG['079'].' '.$MSG['907'].' ' . $Auction['title'],stripslashes($message),"From:".$system->SETTINGS['sitename']." <".$system->SETTINGS['adminmail'].">\n"."Content-Type: text/html; charset=$CHARSET");

?>