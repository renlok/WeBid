<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
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
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	
	foreach ($_POST['category'] as $k => $v)
	{
		$query = "SELECT category FROM " . $DBPrefix . "faqscat_translated WHERE lang = '" . $k . "' AND id = " . $_POST['id'];
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) > 0)
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
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
	header('location: faqscategories.php');
	exit;
}

$query = "SELECT * FROM " . $DBPrefix . "faqscat_translated WHERE id = " . $_GET['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

// get all translations
$tr = array();
while ($row = mysql_fetch_assoc($res))
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