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

include 'common.php';

$cat = (isset($_GET['cat'])) ? intval($_GET['cat']) : intval($_POST['cat']);
if ($cat > 0)
{
	// Retrieve category's name
	$query = "SELECT category FROM " . $DBPrefix . "faqscategories WHERE id = " . $cat;
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	$FAQ_ctitle = stripslashes(mysql_result($res, 0));
	$template->assign_vars(array(
			'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl
			'PAGE_TITLE' => $system->SETTINGS['sitename'] . ' ' . $MSG['5236'] . ' - ' . $FAQ_ctitle,
			'CHARSET' => $CHARSET,
			'LOGO' => ($system->SETTINGS['logo']) ? '<a href="' . $system->SETTINGS['siteurl'] . 'index.php?"><img src="' . $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '"></a>' : "&nbsp;",
			'SITEURL' => $system->SETTINGS['siteurl'],

			'FNAME' => $FAQ_ctitle
			));
	// Retrieve FAQs categories from the database
	$query = "SELECT * FROM " . $DBPrefix . "faqscategories ORDER BY category ASC";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	while ($cats = mysql_fetch_array($res))
	{
		$template->assign_block_vars('cats', array(
				'CAT' => stripslashes($cats['category']),
				'ID' => $cats['id']
				));
	}
	// Retrieve FAQs from the database
	$query = "SELECT f.question As q, f.answer As a, t.* FROM " . $DBPrefix . "faqs f
			LEFT JOIN " . $DBPrefix . "faqs_translated t ON (t.id = f.id)
			WHERE f.category = " . $cat . " AND t.lang = '" . $language . "'";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	while ($row = mysql_fetch_assoc($res))
	{
		if (!empty($row['question']) && !empty($row['answer']))
		{
			$question = stripslashes($row['question']);
			$answer = stripslashes($row['answer']);
		}
		else
		{
			$question = stripslashes($row['q']);
			$answer = stripslashes($row['a']);
		}

		$template->assign_block_vars('faqs', array(
				'Q' => $question,
				'A' => $answer,
				'ID' => $row['id']
				));
	}

	$template->set_filenames(array(
			'body' => 'viewhelp.tpl'
			));
	$template->display('body');
}
else
{
	header('location: help.php');
}
?>
