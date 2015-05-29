<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

define('InAdmin', 1);
$current_page = 'contents';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

// Insert new message
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['question'][$system->SETTINGS['defaultlanguage']]) || empty($_POST['answer'][$system->SETTINGS['defaultlanguage']]))
	{
		$system->SETTINGS = $_POST;
		$ERR = $ERR_067;
	}
	else
	{
		$query = "INSERT INTO " . $DBPrefix . "faqs values (NULL,
			   '" . $system->cleanvars($_POST['question'][$system->SETTINGS['defaultlanguage']]) . "',
			   '" . $system->cleanvars($_POST['answer'][$system->SETTINGS['defaultlanguage']]) . "',
			   " . $_POST['category'] . ")";
		$db->direct_query($query);
		$id = $db->lastInsertId();
		// Insert into translation table.
		reset($LANGUAGES);
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "INSERT INTO ".$DBPrefix."faqs_translated VALUES (
					" . $id . ",
					'" . $k . "',
					'" . $system->cleanvars($_POST['question'][$k]) . "',
					'" . $system->cleanvars($_POST['answer'][$k]) . "')";
			$db->direct_query($query);
		}
		header('location: faqs.php');
		exit;
	}
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqscategories";
$db->direct_query($query);

while ($row = $db->fetch())
{
	$template->assign_block_vars('cats', array(
			'ID' => $row['id'],
			'CATEGORY' => $row['category']
			));
}

foreach ($LANGUAGES as $k => $language)
{
	$template->assign_block_vars('lang', array(
			'LANG' => $language,
			'TITLE' => (isset($_POST['title'][$k])) ? $_POST['title'][$k] : '',
			'CONTENT' => (isset($_POST['content'][$k])) ? $_POST['content'][$k] : ''
			));
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'newfaq.tpl'
		));
$template->display('body');

?>
