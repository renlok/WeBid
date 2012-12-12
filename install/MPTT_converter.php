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

session_start();
define('InWeBid', 1);
$step = (!isset($_GET['step'])) ? 1 : $_GET['step'];

include '../includes/config.inc.php';
if (!mysql_connect($DbHost, $DbUser, $DbPassword))
{
	die('<p>Cannot connect to '.$DbHost.'</p>');
}
if (!mysql_select_db($DbDatabase))
{
	die('<p>Cannot select database</p>');
}

function search($id, $tmp, $tid, $searching)
{
	foreach ($searching as $k => $v)
	{
		$tmp[$tid] = $k;
		if ($k == $id)
		{
			return $tmp;
		}
		if (is_array($searching[$k]))
		{
			$re = search($id, $tmp, ($tid + 1), $searching[$k]);
			if(is_array($re))
			{
				return $re;
			}
		}
	}
	return '';
}

function getids($count, $searching, $level)
{
	$tmp = array();
	foreach ($searching as $k => $v)
	{
		$t = array();
		$count++;
		$t['left'] = $count;
		if (is_array($searching[$k]) && count($searching[$k]) > 0)
		{
			$ra = getids($count, $searching[$k], ($level + 1));
			$tmp = array_merge($tmp, $ra[0]);
			$count = $ra[1];
		}	
		$count++;
		$t['right'] = $count;
		$t['id'] = $k;
		$t['level'] = $level;
		$tmp[] = $t;
	}
	return array($tmp, $count);
}

switch($step)
{
	case 1:
		unset($_SESSION['ordered_cats']);
		unset($_SESSION['import_cats']);
		unset($_SESSION['cats_lftrgt']);
		$query = "SELECT cat_id, parent_id, cat_name FROM `" . $DBPrefix . "categories` WHERE parent_id != -1 ORDER BY parent_id ASC, cat_name ASC";
		$res = mysql_query($query) or die(mysql_error());
		$_SESSION['import_cats'] = array();
		$count = mysql_num_rows($res);
		while ($row = mysql_fetch_assoc($res))
		{
			$_SESSION['import_cats'][] = $row;
		}
		echo '<script type="text/javascript">window.location = "MPTT_converter.php?step=2&count=' . $count . '";</script>';
	break;
	case 2: //order everything
		if (!isset($_SESSION['ordered_cats']))
		{
			$_SESSION['ordered_cats'] = array();
		}

		$parent_id = -1;
		$group = array();
		foreach ($_SESSION['import_cats'] as $k => $v)
		{
			if ($v['parent_id'] == 0)
			{
				$_SESSION['ordered_cats'][$v['cat_id']] = array();
			}
			else
			{
				if ($parent_id != $v['parent_id'] && count($group) > 0)
				{
					$a = search($parent_id, array(), 0, $_SESSION['ordered_cats']);
					if(is_array($a))
					{
						switch (count($a))
						{
							case 1:
								$_SESSION['ordered_cats'][$a[0]] = $group;
							break;
							case 2:
								$_SESSION['ordered_cats'][$a[0]][$a[1]] = $group;
							break;
							case 3:
								$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]] = $group;
							break;
							case 4:
								$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]][$a[3]] = $group;
							break;
							case 5:
								$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]][$a[3]][$a[4]] = $group;
							break;
							case 6:
								$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]][$a[3]][$a[4]][$a[5]] = $group;
							break;
						}
					}
					$group = array();
				}
				$group[$v['cat_id']] = array();
			}
			$parent_id = $v['parent_id'];
		}
		$a = search($parent_id, array(), 0, $_SESSION['ordered_cats']);
		if(is_array($a))
		{
			switch (count($a))
			{
				case 1:
					$_SESSION['ordered_cats'][$a[0]] = $group;
				break;
				case 2:
					$_SESSION['ordered_cats'][$a[0]][$a[1]] = $group;
				break;
				case 3:
					$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]] = $group;
				break;
				case 4:
					$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]][$a[3]] = $group;
				break;
				case 5:
					$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]][$a[3]][$a[4]] = $group;
				break;
				case 6:
					$_SESSION['ordered_cats'][$a[0]][$a[1]][$a[2]][$a[3]][$a[4]][$a[5]] = $group;
				break;
			}
		}
		echo '<script type="text/javascript">window.location = "MPTT_converter.php?step=3&count=' . $_GET['count'] . '";</script>';
	break;
	case 3: //get left/right values
		unset($_SESSION['import_cats']);
		if (!isset($_SESSION['cats_lftrgt']))
		{
			$_SESSION['cats_lftrgt'] = array();
		}

		$cats = array();
		$count = 1;
		$cats[0] = array('left' => $count);
		foreach ($_SESSION['ordered_cats'] as $k => $v)
		{
			$t = array();
			$count++;
			$t['left'] = $count;
			if (is_array($_SESSION['ordered_cats'][$k]) && count($_SESSION['ordered_cats'][$k]) > 0)
			{
				$ra = getids($count, $_SESSION['ordered_cats'][$k], 1);
				$cats = array_merge($cats, $ra[0]);
				$count = $ra[1];
			}
			$count++;
			$t['right'] = $count;
			$t['id'] = $k;
			$t['level'] = 0;
			$cats[] = $t;
		}
		$count++;
		$cats[0]['right'] = $count;
		$_SESSION['cats_lftrgt'] = $cats;
		echo '<script type="text/javascript">window.location = "MPTT_converter.php?step=4&count=' . count($cats) . '";</script>';
	break;
	case 4:
		unset($_SESSION['ordered_cats']);
		if (!isset($_GET['from']))
		{
			$query = "INSERT INTO `" . $DBPrefix . "categories` (left_id, right_id, level, cat_name, parent_id) VALUES
			(" . $_SESSION['cats_lftrgt'][0]['left'] . ", " . $_SESSION['cats_lftrgt'][0]['right'] . ", -1, 'All', -1)";
			$res = mysql_query($query) or die(mysql_error());
			$top_id = mysql_insert_id();
			$query = "UPDATE `" . $DBPrefix . "categories` SET parent_id = " . $top_id . " WHERE parent_id = 0";
			$res = mysql_query($query) or die(mysql_error());
			$newfrom = $from = 1;
		}
		else
		{
			$newfrom = $from = $_GET['from'];
		}

		for ($i = $from; $i < ($from + 750); $i++)
		{
			$newfrom++;
			if ($i == $_GET['count'])
			{
				break;
			}
			$query = "UPDATE `" . $DBPrefix . "categories` SET
					left_id = " . $_SESSION['cats_lftrgt'][$i]['left'] . ", right_id = " . $_SESSION['cats_lftrgt'][$i]['right'] . ",
					level = " . $_SESSION['cats_lftrgt'][$i]['level'] . "
					WHERE cat_id = " . $_SESSION['cats_lftrgt'][$i]['id'];
			$res = mysql_query($query) or die(mysql_error());
		}
		if ($newfrom >= $_GET['count'])
		{
			echo 'Update complete now remove the install folder from your server';
		}
		else
		{
			echo '<script type="text/javascript">window.location = "MPTT_converter.php?step=4&count=' . $_GET['count'] . '&from=' . $newfrom . '";</script>';
		}
	break;
}
?>