<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

function rebuild_table_file($table)
{
	global $DBPrefix;
	switch($table) {
		case "membertypes" :
			$output_filename = "../includes/membertypes.inc.php";
			$field_name = array("id","feedbacks","membertype","icon");
			$sort_field = 1;
			$array_name = "membertypes";
			$output = "<?\n";
			$output.= "$" . $array_name . " = array(\n";
			break;
		default :
			break;
	}
	
	$sqlqry = "SELECT " . join(",",$field_name) . " FROM " . $DBPrefix . "" . $table . " ORDER BY " .$field_name[$sort_field] . ";";
	$result = mysql_query($sqlqry);
	
	if ($result)
	$num_rows = mysql_num_rows($result);
	else {
		echo mysql_error();
		$num_rows = 0;
	}
	
	$i = 0;
	while ($i < $num_rows) {
		reset($field_name);
		if (count($field_name) > 1) {
			$fldn=each($field_name);
			$output.="\"" . mysql_result($result,$i, $fldn['value']) . "\" => array(\n";
			$j=1;
			do {
				$output .= "\"" . $fldn['value'] . "\"=>\"" . mysql_result($result,$i, $fldn['value']) . "\",";
				$fldn=each($field_name);
				$j++;
			}while ($j<count($field_name));
			$output .= "\"" . $fldn['value'] . "\"=>\"" . mysql_result($result,$i, $fldn['value']) . "\")";
		} else {
			$fldn=each($field_name);
			$output .= "\"" . mysql_result($result,$i, $fldn['value']) . "\"";
		}
		$i++;
		if ($i < $num_rows)
		$output .= ",\n";
		else
		$output .= "\n";
	}
	
	$output .= ");\n?>\n";
	
	$handle = fopen ( $output_filename , "w" );
	fputs ( $handle, $output );
	fclose ($handle);
}
?>