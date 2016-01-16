<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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
include $include_path . 'htmLawed.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Data check
	if (!isset($_POST['title']) || !isset($_POST['content']))
	{
		$ERR = $ERR_112;
	}
	else
	{
		// clean up everything
		$conf = array();
		$conf['safe'] = 1;
		foreach ($_POST['title'] as $k => $v)
		{
			$_POST['title'][$k] = htmLawed($v, $conf);
			$_POST['content'][$k] = htmLawed($_POST['content'][$k], $conf);
		}

		$query = "INSERT INTO " . $DBPrefix . "news VALUES (NULL, :title, :content, :time, :suspended)";
		$params = array();
		$params[] = array(':title', $system->cleanvars($_POST['title'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':content', $system->cleanvars($_POST['content'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':time', time(), 'int');
		$params[] = array(':suspended', $_POST['suspended'], 'int');
		$db->query($query, $params);
		$news_id = $db->lastInsertId();

		// Insert into translation table
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (:news_id, :lang, :title, :content)";
			$params = array();
			$params[] = array(':title', $system->cleanvars($_POST['title'][$k]), 'str');
			$params[] = array(':content', $system->cleanvars($_POST['content'][$k]), 'str');
			$params[] = array(':lang', $k, 'str');
			$params[] = array(':news_id', $news_id, 'int');
			$db->query($query, $params);
		}
		header('location: news.php');
		exit;
	}
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
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'TITLE' => $MSG['518'],
		'BUTTON' => $MSG['518'],
		'ID' => '', // inserting new user so needs to be blank

		'B_ACTIVE' => ((isset($_POST['suspended']) && $_POST['suspended'] == 0) || !isset($_POST['suspended'])),
		'B_INACTIVE' => (isset($_POST['suspended']) && $_POST['suspended'] == 1)
		));

$template->set_filenames(array(
		'body' => 'addnew.tpl'
		));
$template->display('body');
?>