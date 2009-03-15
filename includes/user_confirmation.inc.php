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

if(isset($_COOKIE['USERLANGUAGE'])) {
	$USERLANG = $_COOKIE['USERLANGUAGE'];
} else {
	$USERLANG = $language;
}

include $include_path."messages.inc.php";
$buffer = file($main_path."language/".$USERLANG."/mail_usermail.inc.php");

$i = 0;
$j = 0;
while($i < count($buffer)) {
	if(!ereg("^#(.)*$",$buffer[$i])){
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}
//--Reteve message

$CONFIRMATIONPAGE = $system->SETTINGS['siteurl'] . 'confirm.php?id=' . $TPL_id_hidden . '&hash=' . md5($TPL_nick_hidden);

$message = implode($skipped_buffer, '');

//--Change TAGS with variables content

$message = ereg_replace("<#c_id#>",AddSlashes($TPL_id_hidden),$message);
$message = ereg_replace("<#c_name#>",AddSlashes($TPL_name_hidden),$message);
$message = ereg_replace("<#c_nick#>",AddSlashes($TPL_nick_hidden),$message);
$message = ereg_replace("<#c_address#>",AddSlashes($_POST['TPL_address']),$message);
$message = ereg_replace("<#c_city#>",AddSlashes($_POST['TPL_city']),$message);
$message = ereg_replace("<#c_prov#>",AddSlashes($_POST['TPL_prov']),$message);
$message = ereg_replace("<#c_zip#>",AddSlashes($_POST['TPL_zip']),$message);
$message = ereg_replace("<#c_country#>",AddSlashes($_POST['TPL_country']),$message);
$message = ereg_replace("<#c_phone#>",AddSlashes($_POST['TPL_phone']),$message);
$message = ereg_replace("<#c_email#>",AddSlashes($_POST['TPL_email']),$message);
$message = ereg_replace("<#c_password#>",AddSlashes($_POST['TPL_password']),$message);
$message = ereg_replace("<#c_sitename#>",$system->SETTINGS['sitename'],$message);
$message = ereg_replace("<#c_siteurl#>",$system->SETTINGS['siteurl'],$message);
$message = ereg_replace("<#c_adminemail#>",$system->SETTINGS['adminmail'],$message);
$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);
$message = ereg_replace("<#c_logo#>",$system->SETTINGS['siteurl'].'themes/'.$system->SETTINGS['theme'].'/'.$system->SETTINGS['logo'], $message);

$addheaders = "From:".$system->SETTINGS['sitename']." <".$system->SETTINGS['adminmail'].">\n"."Content-Type: text/html; charset=$CHARSET";
mail($TPL_email_hidden, $system->SETTINGS['sitename'] . ' ' . $MSG['098'], $message, $addheaders);

?>