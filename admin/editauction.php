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

define('InAdmin', 1);
$current_page = 'auctions';
include '../common.php';
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

function load_gallery($uploaded_path, $auc_id)
{
	$UPLOADED_PICTURES = array();
	if (file_exists('../' . $uploaded_path . $auc_id))
	{
		$dir = @opendir('../' . $uploaded_path . $auc_id);
		if ($dir)
		{
			while ($file = @readdir($dir))
			{
				if ($file != '.' && $file != '..' && strpos($file, 'thumb-') === false)
				{
					$UPLOADED_PICTURES[$K] = $uploaded_path . $auc_id . '/' . $file;
					$K++;
				}
			}
			@closedir($dir);
		}
	}
	return $UPLOADED_PICTURES;
}

if (isset($_POST['action']))
{
	// Check that all the fields are not NULL
	if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['duration']) && !empty($_POST['category']) && !empty($_POST['description']) && !empty($_POST['min_bid']))
	{
		// fix values
		$_POST['quantity'] = (empty($_POST['quantity'])) ? 1 : $_POST['quantity'];
		$_POST['customincrement'] = (empty($_POST['customincrement'])) ? 0 : $_POST['customincrement'];
		// Check the input values for validity.
		if ($_POST['quantity'] < 1) // 1 or more items being sold
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

			$start = gmdate('H i s n j Y', $AUCTION['starts']);
			$start = explode(' ', $start);
			$a_start = gmmktime($start[0], $start[1], $start[2], $start[3], $start[4], $start[5]);
			$a_ends = $a_start + ($_POST['duration'] * 24 * 60 * 60);

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

			if ($AUCTION['secondcat'] != $_POST['secondcat'])
			{
				// and increase new category counters
				$ct = intval($_POST['secondcat']);
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
				$cta = intval($AUCTION['secondcat']);
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

			// clean unwanted images
			if (isset($_POST['gallery']) && is_array($_POST['gallery']))
			{
				$uploaded = load_gallery($uploaded_path, $_POST['id']);
				foreach ($uploaded as $img)
				{
					if (in_array($img, $_POST['gallery']))
					{
						unlink($main_path . $img);
					}
				}
			}

			$query = "UPDATE " . $DBPrefix . "auctions SET
					title = '" . $system->cleanvars($_POST['title']) . "',
					subtitle = '" . $system->cleanvars($_POST['subtitle']) . "',
					ends = '" . $a_ends . "',
					duration = '" . $system->cleanvars($_POST['duration']) . "',
					category = '" . intval($_POST['category']) . "',
					secondcat = '" . intval($_POST['secondcat']) . "',
					description = '" . mysql_escape_string($_POST['description']) . "',
					quantity = '" . intval($_POST['quantity']) . "',
					minimum_bid = '" . $system->input_money($_POST['min_bid']) . "',
					shipping_cost = '" . $system->input_money($_POST['shipping_cost']) . "',
					buy_now = '" . $system->input_money($_POST['buy_now']) . "',
					bn_only = '" . $system->cleanvars($_POST['buy_now_only']) . "',
					reserve_price = '" . $system->input_money($_POST['reserve_price']) . "',
					increment = " . $system->input_money($_POST['customincrement']) . ",
					shipping = '" . $_POST['shipping'] . "',
					payment = '" . $system->cleanvars(implode(', ', $_POST['payment'])) . "',
					international = " . ((isset($_POST['international'])) ? 1 : 0) . ",
					shipping_terms = '" . $system->cleanvars($_POST['shipping_terms']) . "',
					bold = '" . ((isset($_POST['is_bold'])) ? 'y' : 'n') . "',
					highlighted = '" . ((isset($_POST['is_highlighted'])) ? 'y' : 'n') . "',
					featured = '" . ((isset($_POST['is_featured'])) ? 'y' : 'n') . "'
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

$auc_id = intval($_REQUEST['id']);
$query =   "SELECT u.nick, a.* FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
			WHERE a.id = " . $auc_id;
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

$auction_data = mysql_fetch_assoc($res);

// DURATIONS
$dur_list = ''; // empty string to begin HTML list
$query = "SELECT days, description FROM " . $DBPrefix . "durations";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while ($row = mysql_fetch_assoc($res))
{
	$dur_list .= '<option value="' . $row['days'] . '"';
	if ($row['days'] == $auction_data['duration'])
	{
		$dur_list .= ' selected';
	}
	$dur_list .= '>' . $row['description'] . '</option>' . "\n";
}

// CATEGORIES
$categories_list1 = '<select name="category">' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		$categories_list1 .= '	<option value="' . $k . '"' . (($k == $auction_data['category']) ? ' selected="true"' : '') . '>' . $v . '</option>' . "\n";
	}
}
$categories_list1 .= '</select>' . "\n";

$categories_list2 = '<select name="secondcat">' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		$categories_list2 .= '	<option value="' . $k . '"' . (($k == $auction_data['secondcat']) ? ' selected="true"' : '') . '>' . $v . '</option>' . "\n";
	}
}
$categories_list2 .= '</select>' . "\n";

// Pictures Gellery
$K = 0;
$UPLOADED_PICTURES = array();
if (file_exists('../' . $uploaded_path . $auc_id))
{
	// load dem pictures
	$UPLOADED_PICTURES = load_gallery($uploaded_path, $auc_id);

	if (is_array($UPLOADED_PICTURES))
	{
		foreach ($UPLOADED_PICTURES as $k => $v)
		{
			$TMP = @getimagesize('../' . $v);
			if ($TMP[2] >= 1 && $TMP[2] <= 3)
			{
				$template->assign_block_vars('gallery', array(
						'V' => $v
						));
			}
		}
	}
}

// payments
$payment = explode(', ', $auction_data['payment']);
$payment_methods = '';
$query = "SELECT * FROM " . $DBPrefix . "gateways";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$gateways_data = mysql_fetch_assoc($res);
$gateway_list = explode(',', $gateways_data['gateways']);
foreach ($gateway_list as $v)
{
	$v = strtolower($v);
	if ($gateways_data[$v . '_active'] == 1 && _in_array($v, $payment))
	{
		$checked = (in_array($v, $payment)) ? 'checked' : '';
		$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $v . '" ' . $checked . '> ' . $system->SETTINGS['gatways'][$v] . '</p>';
	}
}

$payment_options = unserialize($system->SETTINGS['payment_options']);
foreach ($payment_options as $k => $v)
{
	$checked = (_in_array($k, $payment)) ? 'checked' : '';
	$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $k . '" ' . $checked . '> ' . $v . '</p>';
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => intval($_REQUEST['id']),
		'USER' => $auction_data['nick'],
		'TITLE' => $auction_data['title'],
		'SUBTITLE' => $auction_data['subtitle'],
		'DURLIST' => $dur_list,
		'CATLIST1' => $categories_list1,
		'CATLIST2' => $categories_list2,
		'DESC' => $auction_data['description'],
		'CURRENT_BID' => $system->print_money_nosymbol($auction_data['current_bid']),
		'MIN_BID' => $system->print_money_nosymbol($auction_data['minimum_bid']),
		'QTY' => $auction_data['quantity'],
		'PAYMENTS' => $payment_methods,
		'ATYPE' => $system->SETTINGS['auction_types'][$auction_data['auction_type']],

		'SHIPPING_COST' => $system->print_money_nosymbol($auction_data['shipping_cost']),
		'RESERVE' => $system->print_money_nosymbol($auction_data['reserve_price']),
		'BN_ONLY_Y' => ($auction_data['bn_only'] == 'y') ? 'checked' : '',
		'BN_ONLY_N' => ($auction_data['bn_only'] == 'y') ? '' : 'checked',
		'BN_PRICE' => $system->print_money_nosymbol($auction_data['buy_now']),
		'CUSTOM_INC' => ($auction_data['increment'] > 0) ? $system->print_money_nosymbol($auction_data['increment']) : '',
		'SHIPPING1' => ($auction_data['shipping'] == 1 || empty($auction_data['shipping'])) ? 'checked' : '',
		'SHIPPING2' => ($auction_data['shipping'] == 2) ? 'checked' : '',
		'INTERNATIONAL' => (!empty($auction_data['international'])) ? 'checked' : '',
		'SHIPPING_TERMS' => $auction_data['shipping_terms'],
		'IS_BOLD' => ($auction_data['bold'] == 'y') ? 'checked' : '',
		'IS_HIGHLIGHTED' => ($auction_data['highlighted'] == 'y') ? 'checked' : '',
		'IS_FEATURED' => ($auction_data['featured'] == 'y') ? 'checked' : '',
		'SUSPENDED' => ($auction_data['suspended'] == 0) ? $MSG['029'] : $MSG['030'],

		'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y'),
		'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y'),
		'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y')
		));

$template->set_filenames(array(
		'body' => 'editauction.tpl'
		));
$template->display('body');
?>
