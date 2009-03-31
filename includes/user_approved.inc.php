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

if (isset($_COOKIE['USERLANGUAGE'])) {
	$USERLANG = $_COOKIE['USERLANGUAGE'];
} else {
	$USERLANG = $language;
}

include $include_path."messages.inc.php";
$buffer = file($main_path."language/".$USERLANG."/mail_user_approved.inc.php");

$i = 0;
$j = 0;
while ($i < count($buffer)) {
  if (!ereg("^#(.)*$",$buffer[$i])){
	$skipped_buffer[$j] = $buffer[$i];
	$j++;
  }
  $i++;
}
//--Reteve message
$message = implode($skipped_buffer,"");

//--Change TAGS with variables content

$message = ereg_replace("<#c_name#>",$USER['name'],$message);
$message = ereg_replace("<#c_sitename#>",$system->SETTINGS['sitename'],$message);
$message = ereg_replace("<#c_siteurl#>", $system->SETTINGS['siteurl'],$message);
$message = ereg_replace("<#c_adminemail#>",$system->SETTINGS['adminmail'],$message);

$addheaders = "From:".$system->SETTINGS['sitename']." <".$system->SETTINGS['adminmail'].">\n"."Content-Type: text/html; charset=$CHARSET";

mail($USER['email'], $system->SETTINGS['sitename']. ' '.$MSG['095'], $message, $addheaders);
mail($system->SETTINGS['adminmail'], $system->SETTINGS['sitename']. ' '.$MSG['095'], $message, $addheaders);
?>