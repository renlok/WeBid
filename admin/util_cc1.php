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

reset($LANGUAGES);
foreach ($LANGUAGES as $k => $v)
{
	include $main_path . 'language/' . $k . '/messages.inc.php';
	include $main_path . 'language/' . $k . '/categories.inc.php';

	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -1";
	$db->direct_query($query);
	$parent_cat_id = $db->result('cat_id');

	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = :parent_cat_id ORDER BY cat_name";
	$params = array();
	$params[] = array(':parent_cat_id', $parent_cat_id, 'int');
	$db->query($query, $params);

	$output = "\t" . '<option value="0">' . $MSG['277'] . '</option>' . "\n";
	$output.= "\t" . '<option value="0">----------------------</option>' . "\n";

	$num_rows = $db->numrows();

	while ($row = $db->fetch())
	{
		$category_id = $row['cat_id'];
		$cat_name = $category_names[$category_id];
		$output .= "\t" . '<option value="' . $category_id . '">' . $cat_name . '</option>' . "\n";
	}

	$handle = fopen ($main_path . 'language/' . $k . '/categories_select_box.inc.php', 'w');
	fputs($handle, $output);
	fclose($handle);
}
?>