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
include 'loggedin.inc.php';

// 1 = cat list
// 2 = search list

function clearfile()
{
	global $main_path, $system;
	$handle = fopen($main_path . 'language/' . $system->SETTINGS['defaultlanguage'] . '/categories2.inc.php', 'w');
	fclose($handle);
}

function writetofile($input)
{
	global $main_path, $system;
	$handle = fopen($main_path . 'language/' . $system->SETTINGS['defaultlanguage'] . '/categories2.inc.php', 'a');
	fwrite($handle, $input);
	fclose($handle);
}

function search_cats($parent_id, $level)
{
	global $DBPrefix, $limiter, $done, $catlist;
	$diff = $limiter - $done;
	$catlist[$level] = (!isset($catlist[$level])) ? 0 : $catlist[$level];
	$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories
			WHERE parent_id = " . $parent_id . " ORDER BY cat_name
			LIMIT " . $catlist[$level] . ", 2";
	$result = mysql_query($query);
	$cats = array();
	$catstr = '';
	$stringstart = '';
	if ($level > 0)
	{
		for ($i = 0; $i < $level; $i++)
		{
			$stringstart .= '|___';
		}
	}
	while ($cats = mysql_fetch_assoc($result))
	{
		$done++;
		$catstr .= ",\n{$cats['cat_id']} => '$stringstart{$cats['cat_name']}'";
		print('Adding Category ID ' . $cats['cat_id'] . '...<br>');
		$catlist[$level]++;
		if ($done == $limiter)
		{
			$catstr = implode(',', $catlist);
			print('Writting to file<br>');
			writetofile($catstr);
			print('<script type="text/javascript">window.location = "newcats.php?part=2&num=' . $_GET['num'] . '&catlist=' . $catstr . '";</script>');
			exit;
		}
		$catstr .= search_cats($cats['cat_id'], $level+1);
	}
	unset($cats);
	return $catstr;
}

$limiter = 500;
$done = 0;
$write = '';
$part = (!isset($_GET['part'])) ? 1 : $_GET['part'];

echo '<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE"><h2>Working... do not close this page</h2>';

if($part == 1 || $part == 2)
{
	if (!isset($_GET['num']))
	{
		echo 'Counting Categories...<br>';
		$query = "SELECT COUNT(cat_id) FROM " . $DBPrefix . "categories";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$num_cats = mysql_result($res, 0);
		$done =+ 10;
	}
	else
	{
		$num_cats = $_GET['num'];
	}
}

$from = (!isset($_GET['from'])) ? 0 : $_GET['from'];

switch ($part)
{
	case 1:
		$diff = $limiter - $done;
		$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories ORDER BY cat_name LIMIT " . $from . ", " . $diff;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		
		if ($from == 0)
		{
			echo 'Clearing File Contents...<br>';
			clearfile();
			$write .= '<?php' . "\n";
			$write .= '$category_names = array(' . "\n";
		}
		while ($row = mysql_fetch_assoc($res))
		{
			$write .= $row['cat_id'] . " => '" . $row['cat_name'] . "'";
			if (($from - 1) == $num_cats)
			{
				$write .= "\n";
				$write .= ');' . "\n\n";
				$part++;
			}
			else
			{
				$from++;
				$write .= ',' . "\n";
			}
			$done++;
			echo 'Adding Category ID ' . $row['cat_id'] . '...<br>';
		}
		if ($limiter == $done)
		{
			echo 'Writting to file<br>';
			writetofile($write);
			echo '<script type="text/javascript">window.location = "newcats.php?part=' . $part . '&num=' . $num_cats . '&from=' . $from . '";</script>';
		}
		echo 'Writting to file<br>';
		writetofile($write);
		echo '<script type="text/javascript">window.location = "newcats.php?part=2&from=0&num=' . $num_cats . '";</script>';
	case 2:
		if ($from == 0)
		{
			$write .= '$category_plain = array(' . "\n";
			$write .= '0 => \'\'' . "\n";
		}

		$catlist = (!isset($_GET['catlist'])) ? array() : explode(',', $_GET['catlist']);
		
		$write .= search_cats(0, 0);
		
		if ($from == $num_cats)
		{
			$write .= ');' . "\n\n";
		}
	break;
}
//echo '<script type="text/javascript">window.location = "categories.php";</script>';
exit;
?>