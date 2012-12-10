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

// Default for error message (blank)
unset($ERR);

// Update message
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['question'][$system->SETTINGS['defaultlanguage']])
		|| empty($_POST['answer'][$system->SETTINGS['defaultlanguage']]))
	{
		$ERR = $ERR_067;
		$faq = $_POST;
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "faqs SET category=" . $_POST['category'] . ",
			question='" . mysql_escape_string($_POST['question'][$system->SETTINGS['defaultlanguage']]) . "',
			answer='" . mysql_escape_string($_POST['answer'][$system->SETTINGS['defaultlanguage']]) . "'
			WHERE id = " . $_POST['id'];
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		reset($LANGUAGES);
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "SELECT question FROM " . $DBPrefix . "faqs_translated WHERE lang = '" . $k . "' AND id = " . $_POST['id'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				$query = "UPDATE " . $DBPrefix . "faqs_translated SET 
						question = '" . mysql_escape_string($_POST['question'][$k]) . "',
						answer = '" . mysql_escape_string($_POST['answer'][$k]) . "'
						WHERE id = '" . $_POST['id'] . "' AND lang = '" . $k . "'";
			}
			else
			{
				$query = "INSERT INTO " . $DBPrefix . "faqs_translated VALUES(
						'" . $_POST['id'] . "',
						'" . $k . "',
						'" . mysql_escape_string($_POST['question'][$k]) . "',
						'" . mysql_escape_string($_POST['answer'][$k]) . "')";
			}
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}  
		header('location: faqs.php');
		exit;
	}
}

// load categories
$query = "SELECT * FROM " . $DBPrefix . "faqscategories ORDER BY category";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('cats', array(
			'ID' => $row['id'],
			'CAT' => $row['category']
			));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqs_translated WHERE id = " . $_GET['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res))
{
	$QUESTION_tr[$row['lang']] = $row['question'];
	$ANSWER_tr[$row['lang']] = $row['answer'];
}
				
reset($LANGUAGES);
foreach ($LANGUAGES as $k => $v)
{
	$template->assign_block_vars('qs', array(
			'LANG' => $k,
			'QUESTION' => (isset($_POST['question'][$k])) ? $_POST['question'][$k] : $QUESTION_tr[$k]
			));
	$template->assign_block_vars('as', array(
			'LANG' => $k,
			'ANSWER' => (isset($_POST['answer'][$k])) ? $_POST['answer'][$k] : $ANSWER_tr[$k]
			));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqs WHERE id = " . $_GET['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$faq = mysql_fetch_assoc($res);

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $faq['id'],
		'FAQ_NAME' => $faq['question'],
		'FAQ_CAT' => $faq['category']
		));

$template->set_filenames(array(
		'body' => 'editfaq.tpl'
		));
$template->display('body');

?>