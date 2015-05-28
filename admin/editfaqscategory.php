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

if ($_POST['action'] == 'update')
{
	if (strlen($_POST['category']) == 0)
	{
		$ERR = $ERR_049;
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "faqscategories
				SET category = '" . $system->cleanvars($_POST['category'][$system->SETTINGS['defaultlanguage']]) . "'
				WHERE id = " . $_POST['id'];
		$db->direct_query($query);
	}
	
	foreach ($_POST['category'] as $k => $v)
	{
		$query = "SELECT category FROM " . $DBPrefix . "faqscat_translated WHERE lang = '" . $k . "' AND id = " . $_POST['id'];
		$db->direct_query($query);
		if ($db->numrows() > 0)
		{
			$query = "UPDATE " . $DBPrefix . "faqscat_translated SET 
					category = '" . $system->cleanvars($_POST['category'][$k]) . "'
					WHERE lang = '" . $k . "' AND id = " . $_POST['id'];
		}
		else
		{
			$query = "INSERT INTO " . $DBPrefix . "faqscat_translated
					VALUES (" . $_POST['id'] . ", '" . $k . "', '" .$system->cleanvars($_POST['category'][$k]) . "')";
		}
		$db->direct_query($query);
	}
	header('location: faqscategories.php');
	exit;
}

$query = "SELECT * FROM " . $DBPrefix . "faqscat_translated WHERE id = " . $_GET['id'];
$db->direct_query($query);

// get all translations
$tr = array();
while ($row = $db->fetch())
{
	$tr[$row['lang']] = $row['category'];
}

foreach ($LANGUAGES as $k => $v)
{
	$k = trim($k);
	$template->assign_block_vars('flangs', array(
			'LANGUAGE' => $k,
			'TRANSLATION' => $tr[$k]
			));
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'FAQ_NAME' => $tr[$system->SETTINGS['defaultlanguage']],
		'ID' => $_GET['id']
		));

$template->set_filenames(array(
		'body' => 'editfaqscategory.tpl'
		));
$template->display('body');
?>