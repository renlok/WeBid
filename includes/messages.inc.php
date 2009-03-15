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

// Language management

$lan = (isset($_GET['lan'])) ? $_GET['lan'] : '';
if(!empty($_GET['lan'])) {
	$language = $lan;
	$_SESSION['language'] = $language;
	
	#// Set language cookie
	setcookie("USERLANGUAGE","",time()-3600);
	setcookie("USERLANGUAGE",$_GET['lan'],time()+31536000,"/");
} elseif(isset($_SESSION['language'])) {
    $language = $_SESSION['language'];
} elseif(empty($_SESSION['language']) && !isset($_COOKIE['USERLANGUAGE'])) {
	$language = $system->SETTINGS['defaultlanguage'];
	$_SESSION['language'] = $language;
	
	#// Set language cookie
	setcookie("USERLANGUAGE","",time()-3600);
	setcookie("USERLANGUAGE",$language,time()+31536000);
} elseif(empty($lan)) {
  if(isset($_COOKIE['USERLANGUAGE'])) {
    $language = $_COOKIE['USERLANGUAGE'];
  } else {
    $language = $system->SETTINGS['defaultlanguage'];
  }
} elseif(isset($_COOKIE['USERLANGUAGE'])) {
	$language = $_COOKIE['USERLANGUAGE'];
} elseif(strlen($lan) > 2 ) {
	$language = $system->SETTINGS['defaultlanguage'];
} else {
	$language = $system->SETTINGS['defaultlanguage'];
} 
$language = str_replace('..','',addslashes(htmlspecialchars($language)));
#// If the user is logged in, update the user's record
#// This is used to send the e-mails in the user's language
if(isset($_SESSION['WEBID_LOGGED_IN'])) {
	mysql_query("DELETE FROM " . $DBPrefix . "userslanguage WHERE user='".$_SESSION['WEBID_LOGGED_IN']."'");
	mysql_query("INSERT INTO " . $DBPrefix . "userslanguage VALUES(
						 '".$_SESSION['WEBID_LOGGED_IN']."',
						 '$language')");
}
if (!$language) $language = $system->SETTINGS['defaultlanguage'];

require($main_path.'language/'.$language.'/messages.inc.php');
/* **************************************************************/

//find installed languages
$LANGUAGES = array();
if ($handle = opendir($main_path.'language')) {
    while (false !== ($file = readdir($handle))) { 
        if (ereg("^([A-Z]{2})$",$file,$regs)) {
            $LANGUAGES[$regs[1]] = $regs[1];
        }
    }
}
closedir($handle);
?>