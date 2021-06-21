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
$current_page = 'tools';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$system->writesetting("wordsfilter", ynbool($_POST['wordsfilter']), 'str');

	//purge the old wordlist
	$query = "DELETE FROM " . $DBPrefix . "filterwords";
	$db->direct_query($query);

	//rebuild the wordlist
	$TMP = explode("\n", $_POST['filtervalues']);
	if (is_array($TMP))
	{
		foreach ($TMP as $k => $v)
		{
			$v = trim($v);
			if (!empty($v))
			{
				$query = "INSERT INTO " . $DBPrefix . "filterwords VALUES (:word)";
				$params = array();
				$params[] = array(':word', $v, 'str');
				$db->query($query, $params);
			}
		}
	}
	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['5073']));
}

$query = "SELECT * FROM " . $DBPrefix . "filterwords";
$db->direct_query($query);

$WORDSLIST = '';
while ($word = $db->fetch())
{
	$WORDSLIST .= $word['word'] . "\n";
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'WORDLIST' => $WORDSLIST,
		'WFYES' => ($system->SETTINGS['wordsfilter'] == 'y') ? ' checked="checked"' : '',
		'WFNO' => ($system->SETTINGS['wordsfilter'] == 'n') ? ' checked="checked"' : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'wordfilter.tpl'
		));
$template->display('body');
include 'footer.php';
?>
