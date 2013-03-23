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

if (!defined('InWeBid')) exit();

function rebuild_table_file($table)
{
	global $DBPrefix, $system, $include_path;
	switch($table)
	{
		case 'membertypes':
			$output_filename = $include_path . 'membertypes.inc.php';
			$field_name = array('id', 'feedbacks', 'icon');
			$sort_field = 1;
			$array_name = 'membertypes';
			$output = '<?php' . "\n";
			$output.= '$' . $array_name . ' = array(' . "\n";
		break;
	}

	$query = "SELECT " . join(',', $field_name) . " FROM " . $DBPrefix . "" . $table . " ORDER BY " .$field_name[$sort_field] . ";";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$num_rows = mysql_num_rows($res);

	$i = 0;
	while ($row = mysql_fetch_assoc($res))
	{
		$output .= '\'' . $row[$field_name[0]] . '\' => array(' . "\n";
		$field_count = count($field_name);
		$j = 0;
		foreach ($field_name as $field)
		{
			$output .= '\'' . $field . '\' => \'' . $row[$field] . '\'';
			$j++;
			if ($j < $field_count)
				$output .= ', ';
			else
				$output .= ')';
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

function rebuild_html_file($table)
{
	global $DBPrefix, $system, $include_path;
	switch($table)
	{
		case 'countries':
			$output_filename = $include_path . 'countries.inc.php';
			$field_name = 'country';
			$array_name = 'countries';
		break;
	}

	$query = "SELECT " . $field_name . " FROM " . $DBPrefix . $table . " ORDER BY " . $field_name . ";";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$num_rows = mysql_num_rows($res);

	$output = '<?php' . "\n";
	$output.= '$' . $array_name . ' = array(\'\', ' . "\n";

	$i = 0;
	while ($row = mysql_fetch_assoc($res))
	{
		$output .= '\'' . $row[$field_name] . '\'';
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
?>