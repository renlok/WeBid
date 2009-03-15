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

// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM " . $DBPrefix . "userslanguage WHERE user='".$OldWinner_id."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $language;
$buffer = file($main_path."language/".$USERLANG."/mail_no_longer_winner.inc.php");
$i = 0;
$j = 0;
while($i < count($buffer)){
	if(!ereg("^#(.)*$",$buffer[$i])){
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}

#// Handle time correction

$ENDS = explode(" ",$ends_string);
//$DATE = explode("-",$ENDS[0]);
$HOUR = explode(":",$ENDS[4]);

$ENDS_DATE = ArrangeDateNoCorrMesCompleto($ENDS[1],$ENDS[0],$ENDS[2],$HOUR[0],$HOUR[1]);

//--Retrieve message
$message = implode($skipped_buffer,"");
//--Change TAGS with variables content
$message = ereg_replace("<#o_name#>", $OldWinner_name, $message);
$message = ereg_replace("<#o_nick#>", $OldWinner_nick, $message);
$message = ereg_replace("<#o_email#>", $OldWinner_email, $message);
$message = ereg_replace("<#o_bid#>", $OldWinner_bid, $message);
$message = ereg_replace("<#n_bid#>", $new_bid, $message);
$message = ereg_replace("<#i_title#>", $item_title, $message);
$message = ereg_replace("<#i_id#>", $item_id, $message);
$message = ereg_replace("<#s_name#>", $seller_name,  $message);
$message = ereg_replace("<#s_email#>", $seller_email,$message);
$message = ereg_replace("<#i_description#>", substr(strip_tags($item_description), 0, 50) . "...", $message);
$auction_url = $system->SETTINGS['siteurl'] . 'item.php?id=' . $id;
if ($pict_url_plain != '') {
	$apict_url_plain = $system->SETTINGS['siteurl'] . $uploaded_path . $item_id . '/' . $pict_url_plain;
} else {
	$apict_url_plain = $system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg';
}
$message = ereg_replace("<#a_picturl#>", $apict_url_plain, $message);
$message = ereg_replace("<#i_url#>", $auction_url, $message);
$message = ereg_replace("<#i_ends#>", $ends_string, $message);
$message = ereg_replace("<#c_sitename#>", $system->SETTINGS['sitename'], $message);
$message = ereg_replace("<#c_siteurl#>", $system->SETTINGS['siteurl'], $message);
$message = ereg_replace("<#c_adminemail#>", $system->SETTINGS['adminmail'], $message);

$item_title = $system->uncleanvars($item_title);
mail($OldWinner_email, $system->SETTINGS['sitename'] . ' '.$MSG['906'] .': '. $item_title, stripslashes($message), "From:" . $system->SETTINGS['sitename'] . " <" . $system->SETTINGS['adminmail'] . ">\n" . "Content-Type: text/html; charset=$CHARSET");
?>