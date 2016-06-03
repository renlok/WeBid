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

$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -1";
$db->direct_query($query);
$parent_cat_id = $db->result('cat_id');

$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = :parent_cat_id ORDER BY cat_name";
$params = array();
$params[] = array(':parent_cat_id', $parent_cat_id, 'int');
$db->query($query, $params);

$categories = $db->fetchAll();

// move current language to end of array
unset($LANGUAGES[$language]);
$LANGUAGES[$language] = $language;

foreach ($LANGUAGES as $k => $v)
{
	include MAIN_PATH . 'language/' . $k . '/messages.inc.php';
	include MAIN_PATH . 'language/' . $k . '/categories.inc.php';
	$cat_strings = [];
	//build array of category names
	foreach ($categories as $category)
	{
		$cat_strings[$category['cat_id']] = $category_names[$category['cat_id']];
	}
	// sort the array
	asort($cat_strings);

	// build select dropdown
	$output = "\t" . '<option value="0">' . $MSG['277'] . '</option>' . "\n";
	$output.= "\t" . '<option value="0">----------------------</option>' . "\n";
	foreach ($cat_strings as $cat_id => $category_name)
	{
		$output .= "\t" . '<option value="' . $cat_id . '">' . $category_name . '</option>' . "\n";
	}
	$handle = fopen (MAIN_PATH . 'language/' . $k . '/categories_select_box.inc.php', 'w');
	fputs($handle, $output);
	fclose($handle);
}

$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['086']));
?>
