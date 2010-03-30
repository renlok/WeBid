<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';
include $include_path . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}
ksort($memtypesarr, SORT_NUMERIC);

$secid = intval($_GET['id']);
$query = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = " . $secid;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

if (mysql_num_rows($res) > 0)
{
	$arr = mysql_fetch_array($res);

	// Handle pagination
	$num_fbs = $arr['rate_num'];
	if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1 || $_GET['PAGE'] == '')
	{
		$OFFSET = 0;
		$PAGE = 1;
	}
	else
	{
		$PAGE = $_GET['PAGE'];
		$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
	}
	$PAGES = ceil($num_fbs / $system->SETTINGS['perpage']);
	if (!isset($PAGES) || $PAGES < 1) $PAGES = 1;

	$i = 0;
	foreach ($memtypesarr as $k => $l) {
		if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr)-1))
		{
			$feedback_image = '<img src="' . $system->SETTINGS['siteurl'] . '/images/icons/' . $l['icon'] . '" class="fbstar">';
			break;
		}
	}

	$query = "SELECT * FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = " . $secid . " ORDER by feedbackdate DESC";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$i=0;
	$bgcolour = '#FFFFFF';
	while ($arrfeed = mysql_fetch_array($res))
	{
		switch($arrfeed['rate'])
		{
			case 1:
				$fb_type = 'positive';
				break;
			case -1:
				$fb_type = 'negative.gif';
				break;
			case 0:
				$fb_type = 'neutral.gif';
				break;
		}
		
		$bgcolour = ($bgcolour == '#FFFFFF') ? '#EEEEEE' : '#FFFFFF';
		$template->assign_block_vars('feedback', array(
				'BGCOLOUR' => $bgcolour,
				'FB_TYPE' => $fb_type,
				'FB_FROM' => $arrfeed['rater_user_nick'],
				'FB_TIME' => FormatDate($arrfeed['feedbackdate'] + $system->tdiff),
				'FB_MSG' => nl2br($arrfeed['feedback']),
				'FB_ID' => $arrfeed['id']
				));
	}
}
else
{
	$TPL_err = 1;
	$TPL_errmsg = $ERR_105;
}

$LOW = $PAGE - 5;
if ($LOW <= 0) $LOW = 1;
$COUNTER = $LOW;
$pagenation = '';
while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
{
	if ($PAGE == $COUNTER)
	{
		$pagenation .= '<b>' . $COUNTER . '</b>&nbsp;&nbsp;';
	}
	else
	{
		$pagenation .= '<a href="userfeedback.php?PAGE=' . $COUNTER . '&id=' . $secid . '&offset=' . $uloffset . '"><u>' . $COUNTER . '</u></a>&nbsp;&nbsp;';
	}
	$COUNTER++;
}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ID' => $secid,
		'NICK' => $arr['nick'],
		'FB_NUM' => $arr['rate_num'],
		'FB_IMG' => $feedback_image,

		'B_MULPAG' => ($PAGES > 1),
		'NEXT' => intval($PAGE + 1),
		'PREV' => intval($PAGE - 1),
		'PAGE' => $PAGE,
		'PAGES' => $PAGES,
		'PAGENA' => $pagenation
		));

$template->set_filenames(array(
		'body' => 'userfeedback.tpl'
		));
$template->display('body');
?>
