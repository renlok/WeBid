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
$current_page = 'tools';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$query = "UPDATE " . $DBPrefix . "settings SET wordsfilter = '" . $_POST['wordsfilter'] . "'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

	//purge the old wordlist
	$query = "DELETE FROM " . $DBPrefix . "filterwords";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	
	//rebuild the wordlist
	$TMP = explode("\n", $_POST['filtervalues']);
	if (is_array($TMP))
	{
		foreach ($TMP as $k => $v)
		{
			$v = trim($v);
			if (!empty($v))
			{
				$query = "INSERT INTO " . $DBPrefix . "filterwords VALUES ('" . $v . "')";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
			}
		}
	}
	$ERR = $MSG['5073'];
	$system->SETTINGS['wordsfilter'] = $_POST['wordsfilter'];
}

$query = "SELECT * FROM " . $DBPrefix . "filterwords";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$WORDSLIST = '';
while ($word = mysql_fetch_assoc($res))
{
	$WORDSLIST .= $word['word'] . "\n";
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'SITEURL' => $system->SETTINGS['siteurl'],
		'WORDLIST' => $WORDSLIST,
		'WFYES' => ($system->SETTINGS['wordsfilter'] == 'y') ? ' checked="checked"' : '',
		'WFNO' => ($system->SETTINGS['wordsfilter'] == 'n') ? ' checked="checked"' : ''
		));

$template->set_filenames(array(
		'body' => 'wordfilter.tpl'
		));
$template->display('body');
?>
