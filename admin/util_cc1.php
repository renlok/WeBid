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

reset($LANGUAGES);
foreach ($LANGUAGES as $k => $v)
{
	include $main_path . 'language/' . $k . '/messages.inc.php';
	include $main_path . 'language/' . $k . '/categories.inc.php';

	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -1";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = " . mysql_result($res, 0) . " ORDER BY cat_name";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$output = '<select name="id">' . "\n";
	$output.= "\t" . '<option value="0">' . $MSG['277'] . '</option>' . "\n";
	$output.= "\t" . '<option value="0">----------------------</option>' . "\n";

	$num_rows = mysql_num_rows($res);

	$i = 0;
	while ($row = mysql_fetch_assoc($res))
	{
		$category_id = $row['cat_id'];
		$cat_name = $category_names[$category_id];
		$output .= "\t" . '<option value="' . $category_id . '">' . $cat_name . '</option>' . "\n";
		$i++;
	}

	$output.= '</select>'."\n";

	$handle = fopen ($main_path . 'language/' . $k . '/categories_select_box.inc.php', 'w');
	fputs($handle, $output);
	fclose($handle);
}
?>