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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . 'language/' . $language . '/categories.inc.php';

unset($ERR);
$catscontrol = new MPTTcategories();

// Data check
if (!isset($_REQUEST['id']))
{
	if (!isset($_SESSION['RETURN_LIST']))
	{
		$URL = 'listauctions.php';
	}
	else
	{
		$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	}
	unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
	header('location: ' . $URL);
	exit;
}

if (isset($_POST['action']))
{
	// Check that all the fields are not NULL
	if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['date']) && !empty($_POST['duration']) && !empty($_POST['category'])
	&& !empty($_POST['description']) && !empty($_POST['quantity']) && !empty($_POST['min_bid']) && !empty($_POST['reserve_price'])
	&& !empty($_POST['buy_now']))
	{
		$DATE = explode('/', $_POST['date']);
		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$tmp_day = $DATE[1];
			$tmp_month = $DATE[0];
			$tmp_year = $DATE[2];
		}
		else
		{
			$tmp_day = $DATE[0];
			$tmp_month = $DATE[1];
			$tmp_year = $DATE[2];
		}

		// Check the input values for validity.
		if (strlen($tmp_year) == 2)
		{
			$tmp_year = '20' . $tmp_year;
		}

		if (!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{2,4}$", $_POST['date'])) //date check
		{
			$ERR = $ERR_700;
		}
		elseif ($_POST['quantity'] < 1) // 1 or more items being sold
		{
			$ERR = $ERR_701;
		}
		elseif ($_POST['current_bid'] < $_POST['min_bid'] && $_POST['current_bid'] != 0) // bid > min_bid
		{
			$ERR = $ERR_702;
		}
		else
		{
			// Retrieve auction data
			$query = "SELECT * from " . $DBPrefix . "auctions WHERE id = " . intval($_POST['id']);
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$AUCTION = mysql_fetch_array($res);

			$start = gmdate('H i s', $AUCTION['starts']);
			$start = explode(' ', $start);
			$a_start = gmmktime($start[0], $start[1], $start[2], $tmp_month, $tmp_day, $tmp_year);
			$a_ends = $T + ($_POST['duration'] * 24 * 60 * 60);

			if ($AUCTION['category'] != $_POST['category'])
			{
				// and increase new category counters
				$ct = intval($_POST['category']);
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $ct;
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$parent_node = mysql_fetch_assoc($res);
				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					if ($crumbs[$i]['cat_id'] == $ct)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + 1, sub_counter = sub_counter + 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
					}
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}

				// and decrease old category counters
				$cta = intval($AUCTION['category']);
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . $cta;
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$parent_node = mysql_fetch_assoc($res);
				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					if ($crumbs[$i]['cat_id'] == $cta)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = " . $crumbs[$i]['cat_id'];
					}
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
			}

			$query = "UPDATE " . $DBPrefix . "auctions SET
					title = '" . $system->cleanvars($_POST['title']) . "',
					starts = '" . $a_start . "',
					ends = '" . $a_ends . "',
					duration = '" . $system->cleanvars($_POST['duration']) . "',
					category = '" . $system->cleanvars($_POST['category']) . "',
					description = '" . mysql_escape_string($_POST['description']) . "',
					quantity = '" . $system->cleanvars($_POST['quantity']) . "',
					minimum_bid = '" . $system->cleanvars($_POST['min_bid']) . "',
					buy_now = '" . $system->cleanvars($_POST['buy_now']) . "',
					reserve_price = '" . $system->cleanvars($_POST['reserve_price']) . "'
					WHERE id = " . $_POST['id'];
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

			$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
			unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
			header('location: ' . $URL);
			exit;
		}
	}
	else
	{
		$ERR = $ERR_112;
	}
}

if (!isset($_POST['action']) || isset($ERR))
{
	$query = "SELECT a.id, u.nick, a.title, a.starts, a.description,
				a.category, a.suspended, a.current_bid, a.duration,
				a.quantity, a.reserve_price, a.buy_now, a.minimum_bid
				FROM " . $DBPrefix . "auctions a,
					" . $DBPrefix . "users u,
					" . $DBPrefix . "durations d
				WHERE u.id = a.user
				AND a.id = " . intval($_REQUEST['id']);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	
	if (mysql_num_rows($res) == 0)
	{
		if (!isset($_SESSION['RETURN_LIST']))
		{
			$URL = 'listauctions.php';
		}
		else
		{
			$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
		}
		unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
		header('location: ' . $URL);
		exit;
	}
		
	$id = mysql_result($res, 0, 'id');
	$title = stripslashes(mysql_result($res, 0, 'title'));
	$user = stripslashes(mysql_result($res, 0, 'nick'));
	$starts = mysql_result($res, 0, 'starts');
	$duration = mysql_result($res, 0, 'duration');
	$category = mysql_result($res, 0, 'category');
	$description = stripslashes(mysql_result($res, 0, 'description'));
	$suspended = mysql_result($res, 0, 'suspended');
	$current_bid = mysql_result($res, 0, 'current_bid');
	$min_bid = mysql_result($res, 0, 'minimum_bid');
	$quantity = mysql_result($res, 0, 'quantity');
	$reserve_price = mysql_result($res, 0, 'reserve_price');
	$buy_now = mysql_result($res, 0, 'buy_now');

	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$starts = gmdate('m/d/Y', $starts);
	}
	else
	{
		$starts = gmdate('d/m/Y', $starts);
	}

	// DURATIONS
	$dur_list = ''; // empty string to begin HTML list
	$query = "SELECT days, description FROM " . $DBPrefix . "durations";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);

	while ($row = mysql_fetch_assoc($res))
	{
		// Append to the list
		$dur_list .= '<option value="' . $row['days'] . '"';
		// If this Durations # of days coresponds to the duration of this
		// auction, select it
		if ($row['days'] == $duration)
		{
			$dur_list .= ' selected';
		}
		$dur_list .= '>' . $row['description'] . '</option>' . "\n";
	}

	// CATEGORIES
	$categories_list = '<select name="category">' . "\n";
	if (isset($category_plain) && count($category_plain) > 0) {
		foreach ($category_plain as $k => $v) {
			$categories_list .= '	<option value="' . $k . '"' . (($k == $category) ? ' selected="true"' : '') . '>' . $v . '</option>' . "\n";
		}
	}
	$categories_list .= '</select>' . "\n";
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $id,
		'USER' => $user,
		'TITLE' => $title,
		'STARTS' => $starts,
		'DURLIST' => $dur_list,
		'CATLIST' => $categories_list,
		'DESC' => $description,
		'CURRENT_BID' => $current_bid,
		'MIN_BID' => $min_bid,
		'QTY' => $quantity,
		'RESERVE' => $reserve_price,
		'BUYNOW' => $buy_now,
		'SUSPENDED' => ($suspended == 0) ? $MSG['029'] : $MSG['030']
		));

$template->set_filenames(array(
		'body' => 'editauction.tpl'
		));
$template->display('body');
?>
