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

session_start();
error_reporting(E_ALL);
$step = (!isset($_GET['step'])) ? 1 : $_GET['step'];

include('../includes/config.inc.php');
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

switch($step)
{
	case 1:
		unset($_SESSION['ordered_cats']);
		unset($_SESSION['import_cats']);
		$query = "SELECT cat_id, parent_id, cat_name FROM `" . $DBPrefix . "categories` ORDER BY parent_id ASC, cat_name ASC";
		$res = mysql_query($query) or die(mysql_error());
		$_SESSION['import_cats'] = array();
		while ($row = mysql_fetch_assoc($res))
		{
			$_SESSION['import_cats'][] = $row;
		}
		echo '<script type="text/javascript">window.location = "MPTT_converter.php?step=2";</script>';
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
					$group = array();
				}
				$group[$v['cat_id']] = array();
			}
			$parent_id = $v['parent_id'];
		}
		$a = search($parent_id, array(), 0, $_SESSION['ordered_cats']);
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
	break;
}
?>