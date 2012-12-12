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

		$query = "INSERT INTO " . $DBPrefix . "news VALUES (NULL, '" . mysql_real_escape_string($_POST['title'][$system->SETTINGS['defaultlanguage']]) . "','" . mysql_real_escape_string($_POST['content'][$system->SETTINGS['defaultlanguage']]) . "'," . time() . "," . intval($_POST['suspended']) . ")";
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$news_id = mysql_insert_id();

		// Insert into translation table
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES
			(" . $news_id . ", '" . $k . "', '" . mysql_real_escape_string($_POST['title'][$k]) . "', '" . mysql_real_escape_string($_POST['content'][$k]) . "')";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
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

		'B_ACTIVE' => ((isset($_POST['suspended']) && $_POST['suspended'] == 0) || !isset($_POST['suspended'])),
		'B_INACTIVE' => (isset($_POST['suspended']) && $_POST['suspended'] == 1)
		));

$template->set_filenames(array(
		'body' => 'addnew.tpl'
		));
$template->display('body');
?>