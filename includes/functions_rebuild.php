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

if (!defined('InWeBid')) exit();

function rebuild_table_file($table)
{
	global $DBPrefix, $db;
	switch($table)
	{
		case 'membertypes':
			$output_filename = INCLUDE_PATH . 'membertypes.inc.php';
			$field_name = array('id', 'feedbacks', 'icon');
			$sort_field = 1;
			$array_name = 'membertypes';
			$array_key = 'feedbacks';
		break;
	}

	$query = "SELECT " . join(',', $field_name) . " FROM " . $DBPrefix . "" . $table . " ORDER BY " . $field_name[$sort_field] . ";";
	$db->direct_query($query);
	$num_rows = $db->numrows();

	$i = 0;
	$output = '<?php' . "\n";
	$output.= '$' . $array_name . ' = array(' . "\n";
	while ($row = $db->fetch())
	{
		$output .= '\'' . $row[$array_key] . '\' => array(' . "\n\t";
		$field_count = count($field_name);
		$j = 0;
		foreach ($field_name as $field)
		{
			$output .= '\'' . $field . '\' => \'' . $row[$field] . '\'';
			$j++;
			if ($j < $field_count)
				$output .= ', ';
			else
				$output .= "\n" . ')';
		}
		$i++;
		if ($i < $num_rows)
			$output .= ',' . "\n";
		else
			$output .= "\n";
	}

	$output .= ');' . "\n" . '?>';

	$handle = fopen($output_filename, 'w');
	fputs($handle, $output);
	fclose($handle);
}