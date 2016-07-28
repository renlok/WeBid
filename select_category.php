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

include 'common.php';
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';

// Is the seller logged in?
if (!$user->checkAuth())
{
	$_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'select_category.php';
	header('location: user_login.php');
	exit;
}
$user->checkSuspended();

if (!$user->can_sell)
{
	header('location: user_menu.php?cptab=selling');
	exit;
}

// Process category selection
$box = (isset($_POST['box'])) ? $_POST['box'] + 1 : 0;
$catscontrol = new MPTTcategories();
$cat_no = (isset($_REQUEST['cat_no'])) ? $_REQUEST['cat_no'] : 1;
$i = 0;
while (true)
{
	if (!isset($_POST['cat' . $i]))
	{
		break;
	}
	$POST['cat' . $i] = $_POST['cat' . $i];
	$i++;
}

if (isset($_POST['action']) && $_POST['action'] == 'process' && $_POST['box'] == '')
{
	$_SESSION['action'] = 1;
	$VARNAME = 'cat' . (count($POST) - 1);
	$_SESSION['SELL_sellcat' . $cat_no] = $POST[$VARNAME];
	$query = "SELECT left_id, right_id FROM " . $DBPrefix . "categories WHERE cat_id = :sellcat";
	$params = array();
	$params[] = array(':sellcat', $_POST[$VARNAME], 'int');
	$db->query($query, $params);
	$lft_rgt = $db->result();
	if ($lft_rgt['left_id'] + 1 == $lft_rgt['right_id'])
	{
		if ($system->SETTINGS['extra_cat'] == 'n' || ($cat_no == 2 && $system->SETTINGS['extra_cat'] == 'y'))
		{
			header('location: sell.php');
			exit;
		}
		else
		{
			header('location: select_category.php?cat_no=2');
			exit;
		}
	}
	else
	{
		$ERR = $ERR_25_0001;
	}
}

// Process change mode
if (isset($_GET['change']) && $_GET['change'] == 'yes')
{
	$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :sellcat_id";
	$params = array();
	$params[] = array(':sellcat_id', $_SESSION['SELL_sellcat' . $cat_no], 'int');
	$db->query($query, $params);
	$cat = $db->result();
	$crumbs = $catscontrol->get_bread_crumbs($cat['left_id'], $cat['right_id']);
	$count = count($crumbs);
	$box = $count - 1;
	for ($i = 1; $i < $count; $i++)
	{
		$POST['cat' . ($i - 1)] = $crumbs[$i]['cat_id'];
	}
	$_SESSION['SELL_editing_category'] = true;
}
elseif (count($_POST) == 0 && !isset($_GET['cat_no']))
{
	unset($_SESSION['UPLOADED_PICTURES_SIZE']);
	$_SESSION['SELL_editing_category'] = false;
	$_SESSION['SELL_sellcat1'] = 0;
	$_SESSION['SELL_sellcat2'] = 0;
	$_SESSION['SELL_starts'] = '';
	$_SESSION['UPLOADED_PICTURES'] = array();
	$_SESSION['SELL_with_reserve'] = '';
	$_SESSION['SELL_reserve_price'] = '';
	$_SESSION['SELL_minimum_bid'] = '';
	$_SESSION['SELL_file_uploaded'] = false;
	$_SESSION['SELL_title'] = '';
	$_SESSION['SELL_subtitle'] = '';
	$_SESSION['SELL_description'] = '';
	$_SESSION['SELL_pict_url'] = '';
	$_SESSION['SELL_pict_url_temp'] = '';
	$_SESSION['SELL_atype'] = '';
	$_SESSION['SELL_iquantity'] = '';
	$_SESSION['SELL_with_buy_now'] = '';
	$_SESSION['SELL_buy_now_price'] = '';
	$_SESSION['SELL_duration'] = '';
	$_SESSION['SELL_relist'] = '';
	$_SESSION['SELL_increments'] = '';
	$_SESSION['SELL_customincrement'] = 0;
	$_SESSION['SELL_shipping'] = 1;
	$_SESSION['SELL_shipping_terms'] = '';
	$_SESSION['SELL_additional_shipping_cost'] = 0;
	$_SESSION['SELL_payment'] = '';
	$_SESSION['SELL_international'] = false;
	$_SESSION['SELL_buy_now_only'] = 0;
	$_SESSION['SELL_action'] = '';
	$_SESSION['SELL_shipping_cost'] = 0;
	$_SESSION['SELL_is_bold'] = 0;
	$_SESSION['SELL_is_highlighted'] = 0;
	$_SESSION['SELL_is_featured'] = 0;
	$_SESSION['SELL_is_taxed'] = 0;
	$_SESSION['SELL_tax_included'] = 0;
	$_SESSION['SELL_start_now'] = '1';
	$_SESSION['SELL_ends'] = '';
	$_SESSION['SELL_custom_end'] = 0;
	$_SESSION['SELL_caneditstartdate'] = true;
}

// Build the categories arrays
$boxarray = array();
$SHOWBUTTON = false;
$pc = 0;
for ($i = 0; $i <= $box; $i++)
{
	$parent = (isset($POST['cat' . ($i - 1)])) ? $POST['cat' . ($i - 1)] : 0;
	$safe_box = true;
	$cat_params = array();
	if ($parent == 0)
	{
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE parent_id = -1";
		if ($pc != 0)
		{
			$safe_box = false;
		}
		$pc++;
	}
	else
	{
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :parent";
		$cat_params[] = array(':parent', $parent, 'int');
	}
	if ($safe_box)
	{
		$db->query($query, $cat_params);
		$cat = $db->result();
		$temparray = $catscontrol->get_children($cat['left_id'], $cat['right_id'], $cat['level']);
		if (count($temparray) > 0)
		{
			for ($j = 0; $j < count($temparray); $j++)
			{
				$boxarray[$i][$temparray[$j]['cat_id']] = $temparray[$j]['cat_name'];
				$boxarray[$i][$temparray[$j]['cat_id']] .= ($temparray[$j]['left_id'] + 1 != $temparray[$j]['right_id']) ? ' ->' : '';
			}
		}
		else
		{
			$SHOWBUTTON = true;
		}
	}
}

$boxes = count($boxarray);
for ($i = 0; $i < $boxes; $i++)
{
	$template->assign_block_vars('boxes', array(
			'B_NOWLINE' => (($i % 2 == 0) && ($i > 0)),
			'I' => $i,
			'PERCENT' => ($boxes == 1) ? 100 : ($boxes == 2) ? 50 : 33
			));
	foreach ($boxarray[$i] as $k => $v)
	{
		$template->assign_block_vars('boxes.cats', array(
				'K' => $k,
				'CATNAME' => $category_names[$k],
				'SELECTED' => (isset($POST['cat' . $i]) && $POST['cat' . $i] == $k) ? ' selected' : ''
				));
	}
}

$extra_cat = 0;
if ($cat_no == 2)
{
	$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'excat_fee'";
	$db->direct_query($query);
	$extra_cat = $db->result('value');
}

$template->assign_vars(array(
		'B_SHOWBUTTON' => $SHOWBUTTON,
		'B_EDITING' => $_SESSION['SELL_editing_category'],
		'CAT_NO' => $cat_no,
		'COST' => ($extra_cat > 0) ? $system->print_money($extra_cat) : '',
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'select_category.tpl'
		));
$template->display('body');
include 'footer.php';
