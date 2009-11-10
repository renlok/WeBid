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

include 'includes/common.inc.php';
include $main_path . 'language/' . $language . '/categories.inc.php';

// Is the seller logged in?
if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'select_category.php';
	header('location: user_login.php');
	exit;
}

if ($system->SETTINGS['uniqueseller'] > 0 && $user->user_data['id'] != $system->SETTINGS['uniqueseller'])
{
	header('location: index.php');
	exit;
}

// Process category selection
$ERR = '';
$box = (isset($_POST['box'])) ? $_POST['box'] + 1 : 0;
$catscontrol = new MPTTcategories();
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
	$_SESSION['SELL_sellcat'] = $POST[$VARNAME];
	$query = "SELECT left_id, right_id FROM " . $DBPrefix . "categories WHERE cat_id = " . intval($_POST[$VARNAME]);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$lft_rgt = mysql_fetch_assoc($res);
	if ($lft_rgt['left_id'] + 1 == $lft_rgt['right_id'])
	{
		header('location: sell.php');
		exit;
	}
	else
	{
		$_POST['box'] = $IDX + 1;
		$ERR = $ERR_25_0001;
	}
}

// Process change mode
if (isset($_GET['change']) && $_GET['change'] == 'yes')
{
	$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . intval($_SESSION['SELL_sellcat']);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$cat = mysql_fetch_assoc($res);
    $crumbs = $catscontrol->get_bread_crumbs($cat['left_id'], $cat['right_id']);
	$count = count($crumbs);
	$box = $count - 1;
	for ($i = 1; $i < $count; $i++)
	{
		$POST['cat' . ($i - 1)] = $crumbs[$i]['cat_id'];
	}
}
elseif (count($_POST) == 0)
{
    unset($_SESSION['RELISTEDAUCTION']);
    unset($_SESSION['UPLOADED_PICTURES_SIZE']);
    unset($_SESSION['GALLERY_UPDATED']);
	unset($_SESSION['SELL_starts']);
	$_SESSION['UPLOADED_PICTURES'] = 0;
    $_SESSION['SELL_with_reserve'] = '';
    $_SESSION['SELL_reserve_price'] = '';
    $_SESSION['SELL_minimum_bid'] = '';
    $_SESSION['SELL_file_uploaded'] = '';
    $_SESSION['SELL_title'] = '';
    $_SESSION['SELL_description'] = '';
    $_SESSION['SELL_pict_url'] = '';
    $_SESSION['SELL_atype'] = '';
    $_SESSION['SELL_iquantity'] = '';
    $_SESSION['SELL_with_buy_now'] = '';
    $_SESSION['SELL_buy_now_price'] = '';
    $_SESSION['SELL_duration'] = '';
    $_SESSION['SELL_relist'] = '';
    $_SESSION['SELL_increments'] = '';
    $_SESSION['SELL_customincrement'] = '';
    $_SESSION['SELL_shipping'] = '';
    $_SESSION['SELL_shipping_terms'] = '';
    $_SESSION['SELL_payment'] = '';
    $_SESSION['SELL_international'] = '';
    $_SESSION['SELL_sendemail'] = '';
    $_SESSION['SELL_buy_now_only'] = '';
    $_SESSION['SELL_action'] = '';
    $_SESSION['SELL_shipping_cost'] = 0;
	$_SESSION['SELL_is_bold'] = 'n';
	$_SESSION['SELL_is_highlighted'] = 'n';
	$_SESSION['SELL_is_featured'] = 'n';
	$_SESSION['SELL_start_now'] = '1';
}

// Build the categories arrays
$boxarray = array();
$SHOWBUTTON = false;
$pc = 0;
for ($i = 0; $i <= $box; $i++)
{
	$parent = (isset($POST['cat' . ($i - 1)])) ? $POST['cat' . ($i - 1)] : 0;
	$safe_box = true;
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
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = " . intval($parent);
	}
	if ($safe_box)
	{
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		$cat = mysql_fetch_assoc($res);
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
				'CATNAME' => $v,
				'SELECTED' => (isset($POST['cat' . $i]) && $POST['cat' . $i] == $k) ? ' selected' : ''
				));
	}
}

$template->assign_vars(array(
        'B_SHOWBUTTON' => $SHOWBUTTON,
        'ERROR' => $ERR
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'select_category.tpl'
        ));
$template->display('body');
include 'footer.php';
?>
