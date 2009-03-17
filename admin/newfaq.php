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

require('../includes/config.inc.php');
include "loggedin.inc.php";
include $main_path . "fck/fckeditor.php";

unset($ERR);

// Insert new message
if(isset($_POST['action']) && $_POST['action'] == "update") {
	if(strlen($_POST['question']) == 0 && strlen($_POST['answer']) == 0){
		$ERR = $ERR_067;
	} else {
		$query = "INSERT INTO " . $DBPrefix . "faqs VALUES (NULL,
			   '" .  mysql_escape_string($_POST['question'][$system->SETTINGS['defaultlanguage']]) . "',
			   '" . mysql_escape_string($_POST['answer'][$system->SETTINGS['defaultlanguage']]) . "',
			   " . $_POST['category'] . ")";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$id = mysql_insert_id();
		// Insert into translation table.
		reset($LANGUAGES);
		while(list($k,$v) = each($LANGUAGES)){
			$query = "INSERT INTO " . $DBPrefix . "faqs_translated VALUES
			($id, '$k', '" .  mysql_escape_string($_POST['question'][$k]) . "', '" .  mysql_escape_string($_POST['answer'][$k]) . "')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		header("Location: faqs.php");
		exit;
	}
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqscategories";
$res_c = mysql_query($query);
$system->check_mysql($res_c, $query, __LINE__, __FILE__);

$faqcats = array();
while($row = mysql_fetch_array($res_c)) {
	$faqcats[$row['id']] = $row['category'];
}

$question = (isset($_POST['question'][$system->SETTINGS['defaultlanguage']])) ? $_POST['question'][$system->SETTINGS['defaultlanguage']] : '';
$answer = (isset($_POST['answer'][$system->SETTINGS['defaultlanguage']])) ? $_POST['answer'][$system->SETTINGS['defaultlanguage']] : '';

$flagurl = '<img src="../includes/flags/' . $system->SETTINGS['defaultlanguage'] . '.gif">';

$selectsetting = (isset($_POST['category'])) ? $_POST['category'] : '';

loadblock($MSG['5238'], '', generateSelect('question', $faqcats));
loadblock($MSG['5239'], $flagurl);
loadblock('', '', 'text', 'question', $question, $MSG['030'], $MSG['029']);

$oFCKeditor = new FCKeditor('answer');
$oFCKeditor->BasePath = '../fck/';
$oFCKeditor->Value = $answer;
$oFCKeditor->Width  = '550';
$oFCKeditor->Height = '400';

loadblock($MSG['5240'], '', $oFCKeditor->CreateHtml());

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'TYPE' => 'con',
		'TYPENAME' => $MSG['25_0018'],
		'PAGENAME' => $MSG['5231']
		));

$template->set_filenames(array(
        'body' => 'adminpages.html'
        ));
$template->display('body');
?>
