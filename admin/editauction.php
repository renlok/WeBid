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

define('InAdmin', 1);
$current_page = 'auctions';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';
include PACKAGE_PATH . 'ckeditor/ckeditor.php';

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

function load_gallery($auc_id)
{
	$UPLOADED_PICTURES = array();
	if (is_dir(UPLOAD_PATH . $auc_id))
	{
		if ($dir = opendir(UPLOAD_PATH . $auc_id))
		{
			while ($file = @readdir($dir))
			{
				if ($file != '.' && $file != '..' && strpos($file, 'thumb-') === false)
				{
					$UPLOADED_PICTURES[] = UPLOAD_FOLDER . $auc_id . '/' . $file;

				}
			}
			closedir($dir);
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
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_701));
		}
		elseif (isset($_POST['current_bid']) && $_POST['current_bid'] < $_POST['min_bid'] && $_POST['current_bid'] != 0) // bid > min_bid
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_702));
		}
		else
		{
			// Retrieve auction data
			$query = "SELECT * from " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $_POST['id'], 'int');
			$db->query($query, $params);
			$AUCTION = $db->result();

			$a_start = $AUCTION['starts'];
			$a_ends = $a_start + ($_POST['duration'] * 24 * 60 * 60);

			if ($AUCTION['category'] != $_POST['category'])
			{
				// and increase new category counters
				$ct = intval($_POST['category']);
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $ct, 'int');
				$db->query($query, $params);
				$parent_node = $db->result();

				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					if ($crumbs[$i]['cat_id'] == $ct)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + 1, sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
					}
					$params = array();
					$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
					$db->query($query, $params);
				}

				// and decrease old category counters
				$cta = intval($AUCTION['category']);
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $cta, 'int');
				$db->query($query, $params);
				$parent_node = $db->result();
				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					if ($crumbs[$i]['cat_id'] == $cta)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
					}
					$params = array();
					$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
					$db->query($query, $params);
				}
			}

			if ($AUCTION['secondcat'] != $_POST['secondcat'])
			{
				// and increase new category counters
				$ct = intval($_POST['secondcat']);
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $ct, 'int');
				$db->query($query, $params);
				$parent_node = $db->result();

				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					if ($crumbs[$i]['cat_id'] == $ct)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + 1, sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cat_id";
					}
					$params = array();
					$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
					$db->query($query, $params);
				}

				// and decrease old category counters
				$cta = intval($AUCTION['secondcat']);
				$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $cta, 'int');
				$db->query($query, $params);
				$parent_node = $db->result();

				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					if ($crumbs[$i]['cat_id'] == $cta)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
					}
					$params = array();
					$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
					$db->query($query, $params);
				}
			}

			// clean unwanted images
			if (isset($_POST['gallery']) && is_array($_POST['gallery']))
			{
				$uploaded = load_gallery($_POST['id']);
				foreach ($uploaded as $img)
				{
					if (in_array($img, $_POST['gallery']))
					{
						unlink(MAIN_PATH . $img);
					}
				}
			}

			$query = "UPDATE " . $DBPrefix . "auctions SET
					title = :title,
					subtitle = :subtitle,
					ends = :ends,
					duration = :duration,
					category = :category,
					secondcat = :secondcat,
					description = :description,
					quantity = :quantity,
					minimum_bid = :minimum_bid,
					shipping_cost = :shipping_cost,
					buy_now = :buy_now,
					bn_only = :bn_only,
					reserve_price = :reserve_price,
					increment = :increment,
					shipping = :shipping,
					payment = :payment,
					international = :international,
					shipping_terms = :shipping_terms,
					bold = :bold,
					highlighted = :highlighted,
					featured = :featured
					WHERE id = :auc_id";
			$params = array();
			$params[] = array(':title', $system->cleanvars($_POST['title']), 'str');
			$params[] = array(':subtitle', $system->cleanvars($_POST['subtitle']), 'str');
			$params[] = array(':ends', $a_ends, 'int');
			$params[] = array(':duration', $system->cleanvars($_POST['duration']), 'str');
			$params[] = array(':category', $_POST['category'], 'int');
			$params[] = array(':secondcat', $_POST['secondcat'], 'int');
			$params[] = array(':description', $_POST['description'], 'str');
			$params[] = array(':quantity', $_POST['quantity'], 'int');
			$params[] = array(':minimum_bid', $system->input_money($_POST['min_bid']), 'float');
			$params[] = array(':shipping_cost', $system->input_money($_POST['shipping_cost']), 'float');
			$params[] = array(':buy_now', $system->input_money($_POST['buy_now']), 'float');
			$params[] = array(':bn_only', $_POST['buy_now_only'], 'bool');
			$params[] = array(':reserve_price', $system->input_money($_POST['reserve_price']), 'float');
			$params[] = array(':increment', $system->input_money($_POST['customincrement']), 'float');
			$params[] = array(':shipping', $_POST['shipping'], 'str');
			$params[] = array(':payment', implode(', ', $_POST['payment']), 'str');
			$params[] = array(':international', ((isset($_POST['international'])) ? 1 : 0), 'int');
			$params[] = array(':shipping_terms', $system->cleanvars($_POST['shipping_terms']), 'str');
			$params[] = array(':bold', (isset($_POST['is_bold'])), 'bool');
			$params[] = array(':highlighted', (isset($_POST['is_highlighted'])), 'bool');
			$params[] = array(':featured', (isset($_POST['is_featured'])), 'bool');
			$params[] = array(':auc_id', $_POST['id'], 'int');
			$db->query($query, $params);

			$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
			unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
			header('location: ' . $URL);
			exit;
		}
	}
	else
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_112));
	}
}

$auc_id = intval($_REQUEST['id']);
$query =   "SELECT u.nick, a.* FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
			WHERE a.id = :auc_id";
$params = array();
$params[] = array(':auc_id', $auc_id, 'int');
$db->query($query, $params);

if ($db->numrows() == 0)
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

$auction_data = $db->result();

// DURATIONS
$dur_list = ''; // empty string to begin HTML list
$query = "SELECT days, description FROM " . $DBPrefix . "durations";
$db->direct_query($query);

while ($row = $db->fetch())
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
if (file_exists(UPLOAD_PATH . $auc_id))
{
	// load dem pictures
	$UPLOADED_PICTURES = load_gallery($auc_id);

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
$payment = explode(', ', strtolower($auction_data['payment']));
$payment_methods = '';
$query = "SELECT * FROM " . $DBPrefix . "payment_options";
$db->direct_query($query);
while ($payment_method = $db->fetch())
{
	if ($payment_method['gateway_active'] == 1 || $payment_method['is_gateway'] == 0)
	{
		$checked = (in_array($payment_method['name'], $payment)) ? 'checked' : '';
		$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $payment_method['name'] . '" ' . $checked . '> ' . $payment_method['displayname'] . '</p>';
	}
}

$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . '/js/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = 550;
$CKEditor->config['height'] = 400;

$template->assign_vars(array(
		'ID' => intval($_REQUEST['id']),
		'USER' => $auction_data['nick'],
		'TITLE' => $auction_data['title'],
		'SUBTITLE' => $auction_data['subtitle'],
		'DURLIST' => $dur_list,
		'CATLIST1' => $categories_list1,
		'CATLIST2' => $categories_list2,
		'EDITOR' => $CKEditor->editor('description', $auction_data['description']),
		'CURRENT_BID' => $system->print_money_nosymbol($auction_data['current_bid']),
		'MIN_BID' => $system->print_money_nosymbol($auction_data['minimum_bid']),
		'QTY' => $auction_data['quantity'],
		'PAYMENTS' => $payment_methods,
		'ATYPE' => $system->SETTINGS['auction_types'][$auction_data['auction_type']],

		'SHIPPING_COST' => $system->print_money_nosymbol($auction_data['shipping_cost']),
		'RESERVE' => $system->print_money_nosymbol($auction_data['reserve_price']),
		'BN_ONLY_Y' => ($auction_data['bn_only']) ? 'checked' : '',
		'BN_ONLY_N' => ($auction_data['bn_only']) ? '' : 'checked',
		'BN_PRICE' => $system->print_money_nosymbol($auction_data['buy_now']),
		'CUSTOM_INC' => ($auction_data['increment'] > 0) ? $system->print_money_nosymbol($auction_data['increment']) : '',
		'SHIPPING1' => ($auction_data['shipping'] == 1 || empty($auction_data['shipping'])) ? 'checked' : '',
		'SHIPPING2' => ($auction_data['shipping'] == 2) ? 'checked' : '',
		'INTERNATIONAL' => (!empty($auction_data['international'])) ? 'checked' : '',
		'SHIPPING_TERMS' => $auction_data['shipping_terms'],
		'IS_BOLD' => ($auction_data['bold']) ? 'checked' : '',
		'IS_HIGHLIGHTED' => ($auction_data['highlighted']) ? 'checked' : '',
		'IS_FEATURED' => ($auction_data['featured']) ? 'checked' : '',
		'SUSPENDED' => ($auction_data['suspended'] == 0) ? $MSG['029'] : $MSG['030'],

		'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y'),
		'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y'),
		'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y')
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'editauction.tpl'
		));
$template->display('body');
include 'footer.php';
?>
