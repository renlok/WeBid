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

if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $val)
	{
		$query = "DELETE FROM " . $DBPrefix . "faqs WHERE id = " . $val;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		$query = "DELETE FROM " . $DBPrefix . "faqs_translated WHERE id = " . $val;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	}
}

// Get data from the database
$query = "SELECT id, category FROM " . $DBPrefix . "faqscategories";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('cats', array(
			'CAT' => $row['category']
			));

	$query = "SELECT id, question FROM " . $DBPrefix . "faqs WHERE category = " . $row['id'];
	$cat_res = mysql_query($query);
	$system->check_mysql($cat_res, $query, __LINE__, __FILE__);
	while ($cat_row = mysql_fetch_assoc($cat_res))
	{
		$template->assign_block_vars('cats.faqs', array(
				'ID' => $cat_row['id'],
				'FAQ' => $cat_row['question']
				));
	}
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'faqs.tpl'
		));
$template->display('body');

?>