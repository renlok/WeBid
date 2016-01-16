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

if (!defined('InWeBid')) exit();

function generate_id()
{
	global $_SESSION;
	if (!isset($_SESSION['SELL_auction_id']))
	{
		$auction_id = md5(uniqid(rand()));
		$_SESSION['SELL_auction_id'] = $auction_id;
	}
	else
	{
		$auction_id = $_SESSION['SELL_auction_id'];
	}
	return $auction_id;
}

function setvars()
{
	global $with_reserve, $reserve_price, $minimum_bid, $pict_url, $imgtype, $title, $subtitle, $sdescription, $atype, $iquantity, $buy_now, $buy_now_price, $is_taxed, $tax_included, $additional_shipping_cost;
	global $duration, $relist, $increments, $customincrement, $shipping, $shipping_terms, $payment, $international, $sellcat1, $sellcat2, $buy_now_only, $a_starts, $shipping_cost, $is_bold, $is_highlighted, $is_featured, $start_now;
	global $_POST, $_SESSION, $system;

	$with_reserve = (isset($_POST['with_reserve'])) ? $_POST['with_reserve'] : $_SESSION['SELL_with_reserve'];
	$reserve_price = (isset($_POST['reserve_price'])) ? $_POST['reserve_price'] : $_SESSION['SELL_reserve_price'];
	$minimum_bid = (isset($_POST['minimum_bid'])) ? $_POST['minimum_bid'] : $_SESSION['SELL_minimum_bid'];
	$default_minbid = ($system->SETTINGS['moneyformat'] == 1) ? 0.99 : '0,99';
	$minimum_bid = (empty($minimum_bid)) ? $default_minbid : $minimum_bid;
	$shipping_cost = (isset($_POST['shipping_cost'])) ? $_POST['shipping_cost'] : $_SESSION['SELL_shipping_cost'];
	$shipping_cost = (empty($shipping_cost)) ? 0 : $shipping_cost;
	$additional_shipping_cost = (isset($_POST['additional_shipping_cost'])) ? $_POST['additional_shipping_cost'] : $_SESSION['SELL_additional_shipping_cost'];
	$additional_shipping_cost = (empty($additional_shipping_cost)) ? 0 : $additional_shipping_cost;
	$imgtype = (isset($_POST['imgtype'])) ? $_POST['imgtype'] : $_SESSION['SELL_file_uploaded'];
	$title = (isset($_POST['title'])) ? $_POST['title'] : $_SESSION['SELL_title'];
	$subtitle = (isset($_POST['subtitle'])) ? $_POST['subtitle'] : $_SESSION['SELL_subtitle'];
	$sdescription = (isset($_POST['sdescription'])) ? $_POST['sdescription'] : $_SESSION['SELL_description'];
	$pict_url = (isset($_POST['pict_url'])) ? $_POST['pict_url'] : $_SESSION['SELL_pict_url'];
	$atype = (isset($_POST['atype'])) ? $_POST['atype'] : $_SESSION['SELL_atype'];
	$iquantity = (int)(isset($_POST['iquantity'])) ? $_POST['iquantity'] : $_SESSION['SELL_iquantity'];
	$iquantity = (empty($iquantity)) ? 1 : round($iquantity);
	$buy_now = (isset($_POST['buy_now'])) ? $_POST['buy_now'] : $_SESSION['SELL_with_buy_now'];
	$buy_now_price = (isset($_POST['buy_now_price'])) ? $_POST['buy_now_price'] : $_SESSION['SELL_buy_now_price'];
	$duration = (isset($_POST['duration'])) ? $_POST['duration'] : $_SESSION['SELL_duration'];
	$relist = (isset($_POST['autorelist'])) ? $_POST['autorelist'] : $_SESSION['SELL_relist'];
	$increments = (isset($_POST['increments'])) ? $_POST['increments'] : $_SESSION['SELL_increments'];
	$customincrement = (isset($_POST['customincrement'])) ? $_POST['customincrement'] : $_SESSION['SELL_customincrement'];
	$shipping = (isset($_POST['shipping'])) ? $_POST['shipping'] : $_SESSION['SELL_shipping'];
	$shipping_terms = (isset($_POST['shipping_terms'])) ? $_POST['shipping_terms'] : $_SESSION['SELL_shipping_terms'];
	$payment = (isset($_POST['payment'])) ? $_POST['payment'] : $_SESSION['SELL_payment'];
	$payment = (is_array($payment)) ? $payment : array();
	$international = (isset($_POST['international'])) ? $_POST['international'] : false;
	$international = (isset($_SESSION['SELL_international']) && !isset($_POST['action'])) ? $_SESSION['SELL_international'] : $international;
	$sellcat1 = $_SESSION['SELL_sellcat1'];
	$_SESSION['SELL_sellcat2'] = (isset($_SESSION['SELL_sellcat2'])) ? $_SESSION['SELL_sellcat2'] : 0;
	$sellcat2 = $_SESSION['SELL_sellcat2'];
	$buy_now_only = (isset($_POST['buy_now_only'])) ? $_POST['buy_now_only'] : $_SESSION['SELL_buy_now_only'];
	$buy_now_only = (empty($buy_now_only)) ? 'n' : $buy_now_only;
	$a_starts = (isset($_POST['a_starts'])) ? $_POST['a_starts'] : $_SESSION['SELL_starts'];
	$is_bold = (isset($_POST['is_bold'])) ? 'y' : $_SESSION['SELL_is_bold'];
	$is_featured = (isset($_POST['is_featured'])) ? 'y' : $_SESSION['SELL_is_featured'];
	$is_highlighted = (isset($_POST['is_highlighted'])) ? 'y' : $_SESSION['SELL_is_highlighted'];
	if (isset($_POST['a_starts'])) {
		if (isset($_POST['start_now'])) {
			$start_now = 1;
		} else {
			$start_now = 0;
		}
	} else {
		$start_now = $_SESSION['SELL_start_now'];
	}
	$is_taxed = (isset($_POST['is_taxed'])) ? $_POST['is_taxed'] : $_SESSION['SELL_is_taxed'];
	$tax_included = (isset($_POST['tax_included'])) ? $_POST['tax_included'] : $_SESSION['SELL_tax_included'];
	if (isset($_POST['action']) && $_POST['action'] == 2)
	{
		$is_bold = (isset($_POST['is_bold'])) ? 'y' : 'n';
		$is_featured = (isset($_POST['is_featured'])) ? 'y' : 'n';
		$is_highlighted = (isset($_POST['is_highlighted'])) ? 'y' : 'n';
		$is_taxed = (isset($_POST['is_taxed'])) ? 'y' : 'n';
		$tax_included = (isset($_POST['tax_included'])) ? 'y' : 'n';
		$payment = (isset($_POST['payment'])) ? $payment : array();
	}
}

function makesessions()
{
	global $with_reserve, $reserve_price, $minimum_bid, $pict_url, $imgtype, $title, $subtitle, $sdescription, $pict_url, $atype, $iquantity, $buy_now, $buy_now_price, $is_taxed, $tax_included, $additional_shipping_cost;
	global $duration, $relist, $increments, $customincrement, $shipping, $shipping_terms, $payment, $international, $sendemail, $buy_now_only, $a_starts, $shipping_cost, $is_bold, $is_highlighted, $is_featured, $start_now, $_SESSION;

	$_SESSION['SELL_with_reserve'] = $with_reserve;
	$_SESSION['SELL_reserve_price'] = $reserve_price;
	$_SESSION['SELL_minimum_bid'] = $minimum_bid;
	$_SESSION['SELL_shipping_cost'] = $shipping_cost;
	$_SESSION['SELL_additional_shipping_cost'] = $additional_shipping_cost;
	$_SESSION['SELL_file_uploaded'] = $imgtype;
	$_SESSION['SELL_title'] = $title;
	$_SESSION['SELL_subtitle'] = $subtitle;
	$_SESSION['SELL_description'] = $sdescription;
	$_SESSION['SELL_pict_url'] = $pict_url;
	$_SESSION['SELL_atype'] = $atype;
	$_SESSION['SELL_iquantity'] = $iquantity;
	$_SESSION['SELL_with_buy_now'] = $buy_now;
	$_SESSION['SELL_buy_now_price'] = $buy_now_price;
	$_SESSION['SELL_duration'] = $duration;
	$_SESSION['SELL_relist'] = $relist;
	$_SESSION['SELL_increments'] = $increments;
	$_SESSION['SELL_customincrement'] = $customincrement;
	$_SESSION['SELL_shipping'] = $shipping;
	$_SESSION['SELL_shipping_terms'] = $shipping_terms;
	$_SESSION['SELL_payment'] = $payment;
	$_SESSION['SELL_international'] = $international;
	$_SESSION['SELL_buy_now_only'] = $buy_now_only;
	$_SESSION['SELL_starts'] = $a_starts;
	$_SESSION['SELL_is_bold'] = $is_bold;
	$_SESSION['SELL_is_highlighted'] = $is_highlighted;
	$_SESSION['SELL_is_featured'] = $is_featured;
	$_SESSION['SELL_start_now'] = $start_now;
	$_SESSION['SELL_is_taxed'] = $is_taxed;
	$_SESSION['SELL_tax_included'] = $tax_included;
}

function unsetsessions()
{
	global $_SESSION, $system;

	$_SESSION['SELL_with_reserve'] = '';
	$_SESSION['SELL_reserve_price'] = '';
	$_SESSION['SELL_minimum_bid'] = ($system->SETTINGS['moneyformat'] == 1) ? 0.99 : '0,99';
	$_SESSION['SELL_shipping_cost'] = 0;
	$_SESSION['SELL_additional_shipping_cost'] = 0;
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
	$_SESSION['SELL_payment'] = array();
	$_SESSION['SELL_international'] = false;
	$_SESSION['SELL_sendemail'] = '';
	$_SESSION['SELL_starts'] = '';
	$_SESSION['SELL_action'] = '';
	$_SESSION['SELL_is_bold'] = 'n';
	$_SESSION['SELL_is_highlighted'] = 'n';
	$_SESSION['SELL_is_featured'] = 'n';
	$_SESSION['SELL_start_now'] = '';
	$_SESSION['SELL_is_taxed'] = 'n';
	$_SESSION['SELL_tax_included'] = 'y';
}

function updateauction($type)
{
	global $_SESSION, $DBPrefix, $a_starts, $a_ends, $payment_text, $system, $fee, $db;
	$params = array();
	if ($type == 2)
	{
		$extraquery = ",relisted = relisted + 1,
		current_bid = 0,
		starts = :starts,
		num_bids = 0";
		$params[] = array(':starts', $a_starts, 'int');
	}
	else
	{
		$extraquery = '';
	}

	$query =
		"UPDATE " . $DBPrefix . "auctions SET
		title = :title,
		subtitle = :subtitle,
		description = :description,
		pict_url = :pict_url,
		category = :catone,
		secondcat = :cattwo,
		minimum_bid = :min_bid,
		shipping_cost = :shipping_cost,
		shipping_cost_additional = :shipping_cost_additional,
		reserve_price = :reserve_price,
		buy_now = :buy_now,
		bn_only = :bn_only,
		auction_type = :auction_type,
		duration = :duration,
		increment = :increment,
		shipping = :shipping,
		payment = :payment,
		international = :international,
		ends = :ends,
		photo_uploaded = :photo_uploaded,
		initial_quantity = :initial_quantity,
		quantity = :quantity,
		relist = :relist,
		shipping_terms = :shipping_terms,
		closed = 0,
		bold = :bold,
		highlighted = :highlighted,
		featured = :featured,
		tax = :tax,
		taxinc = :taxinc,
		current_fee = current_fee + :fee";
		$query .= $extraquery;
		$query .= " WHERE id = :auction_id";
	$params = array();
	$params[] = array(':title', $system->cleanvars($_SESSION['SELL_title']), 'str');
	$params[] = array(':subtitle', $system->cleanvars($_SESSION['SELL_subtitle']), 'str');
	$params[] = array(':description', $_SESSION['SELL_description'], 'str');
	$params[] = array(':pict_url', $_SESSION['SELL_pict_url'], 'str');
	$params[] = array(':catone', $_SESSION['SELL_sellcat1'], 'int');
	$params[] = array(':cattwo', $_SESSION['SELL_sellcat2'], 'int');
	$params[] = array(':min_bid', $system->input_money(($_SESSION['SELL_buy_now_only'] == 'n') ? $_SESSION['SELL_minimum_bid'] : $_SESSION['SELL_buy_now_price']), 'float');
	$params[] = array(':shipping_cost', $system->input_money($_SESSION['SELL_shipping_cost']), 'float');
	$params[] = array(':shipping_cost_additional', $system->input_money($_SESSION['SELL_additional_shipping_cost']), 'float');
	$params[] = array(':reserve_price', $system->input_money(($_SESSION['SELL_with_reserve'] == 'yes') ? $_SESSION['SELL_reserve_price'] : 0), 'float');
	$params[] = array(':buy_now', $system->input_money(($_SESSION['SELL_with_buy_now'] == 'yes') ? $_SESSION['SELL_buy_now_price'] : 0), 'float');
	$params[] = array(':bn_only', ynbool($_SESSION['SELL_buy_now_only']), 'str');
	$params[] = array(':auction_type', $_SESSION['SELL_atype'], 'int');
	$params[] = array(':duration', $_SESSION['SELL_duration'], 'int');
	$params[] = array(':increment', $system->input_money($_SESSION['SELL_customincrement']), 'float');
	$params[] = array(':shipping', $_SESSION['SELL_shipping'], 'int');
	$params[] = array(':payment', $payment_text, 'str');
	$params[] = array(':international', $_SESSION['SELL_international'], 'bool');
	$params[] = array(':ends', $a_ends, 'int');
	$params[] = array(':photo_uploaded', $_SESSION['SELL_file_uploaded'], 'bool');
	$params[] = array(':initial_quantity', $_SESSION['SELL_iquantity'], 'int');
	$params[] = array(':quantity', $_SESSION['SELL_iquantity'], 'int');
	$params[] = array(':relist', $_SESSION['SELL_relist'], 'int');
	$params[] = array(':shipping_terms', $system->cleanvars($_SESSION['SELL_shipping_terms']), 'str');
	$params[] = array(':bold', ynbool($_SESSION['SELL_is_bold']), 'str');
	$params[] = array(':highlighted', ynbool($_SESSION['SELL_is_highlighted']), 'str');
	$params[] = array(':featured', ynbool($_SESSION['SELL_is_featured']), 'str');
	$params[] = array(':tax', ynbool($_SESSION['SELL_is_taxed']), 'str');
	$params[] = array(':taxinc', ynbool($_SESSION['SELL_tax_included']), 'str');
	$params[] = array(':fee', $fee, 'float');
	$params[] = array(':auction_id', $_SESSION['SELL_auction_id'], 'int');
	$db->query($query, $params);
}

function addauction()
{
	global $DBPrefix, $_SESSION, $user, $a_starts, $a_ends, $payment_text, $system, $fee, $db;

	$query = "INSERT INTO " . $DBPrefix . "auctions (user,title,subtitle,starts,description,pict_url,category,secondcat,minimum_bid,shipping_cost,shipping_cost_additional,reserve_price,buy_now,auction_type,duration,increment,shipping,payment,international,ends,photo_uploaded,initial_quantity,quantity,relist,shipping_terms,bn_only,bold,highlighted,featured,current_fee,tax,taxinc) VALUES
	(:user_id, :title, :subtitle, :starts, :description, :pict_url, :catone, :cattwo, :min_bid, :shipping_cost, :shipping_cost_additional, :reserve_price, :buy_now, :auction_type, :duration, :increment, :shipping, :payment, :international, :ends, :photo_uploaded, :initial_quantity, :quantity, :relist, :shipping_terms, :bn_only, :bold, :highlighted, :featured, :fee, :tax, :taxinc)";

	$params = array();
	$params[] = array(':user_id', $user->user_data['id'], 'int');
	$params[] = array(':title', $system->cleanvars($_SESSION['SELL_title']), 'str');
	$params[] = array(':subtitle', $system->cleanvars($_SESSION['SELL_subtitle']), 'str');
	$params[] = array(':starts', $a_starts, 'int');
	$params[] = array(':description', $_SESSION['SELL_description'], 'str');
	$params[] = array(':pict_url', $system->cleanvars($_SESSION['SELL_pict_url']), 'str');
	$params[] = array(':catone', $_SESSION['SELL_sellcat1'], 'int');
	$params[] = array(':cattwo', $_SESSION['SELL_sellcat2'], 'int');
	$params[] = array(':min_bid', $system->input_money(($_SESSION['SELL_buy_now_only'] == 'n') ? $_SESSION['SELL_minimum_bid'] : $_SESSION['SELL_buy_now_price']), 'float');
	$params[] = array(':shipping_cost', $system->input_money($_SESSION['SELL_shipping_cost']), 'float');
	$params[] = array(':shipping_cost_additional', $system->input_money($_SESSION['SELL_additional_shipping_cost']), 'float');
	$params[] = array(':reserve_price', $system->input_money(($_SESSION['SELL_with_reserve'] == 'yes') ? $_SESSION['SELL_reserve_price'] : 0), 'float');
	$params[] = array(':buy_now', $system->input_money(($_SESSION['SELL_with_buy_now'] == 'yes') ? $_SESSION['SELL_buy_now_price'] : 0), 'float');
	$params[] = array(':auction_type', $_SESSION['SELL_atype'], 'int');
	$params[] = array(':duration', $_SESSION['SELL_duration'], 'int');
	$params[] = array(':increment', $system->input_money($_SESSION['SELL_customincrement']), 'float');
	$params[] = array(':shipping', $_SESSION['SELL_shipping'], 'int');
	$params[] = array(':payment', $payment_text, 'str');
	$params[] = array(':international', $_SESSION['SELL_international'], 'bool');
	$params[] = array(':ends', $a_ends, 'int');
	$params[] = array(':photo_uploaded', $_SESSION['SELL_file_uploaded'], 'bool');
	$params[] = array(':initial_quantity', $_SESSION['SELL_iquantity'], 'int');
	$params[] = array(':quantity', $_SESSION['SELL_iquantity'], 'int');
	$params[] = array(':relist', $_SESSION['SELL_relist'], 'int');
	$params[] = array(':shipping_terms', $system->cleanvars($_SESSION['SELL_shipping_terms']), 'str');
	$params[] = array(':bn_only', ynbool($_SESSION['SELL_buy_now_only']), 'str');
	$params[] = array(':bold', ynbool($_SESSION['SELL_is_bold']), 'str');
	$params[] = array(':highlighted', ynbool($_SESSION['SELL_is_highlighted']), 'str');
	$params[] = array(':featured', ynbool($_SESSION['SELL_is_featured']), 'str');
	$params[] = array(':fee', $fee, 'float');
	$params[] = array(':tax', ynbool($_SESSION['SELL_is_taxed']), 'str');
	$params[] = array(':taxinc', ynbool($_SESSION['SELL_tax_included']), 'str');
	$db->query($query, $params);
}

function addoutstanding()
{
	global $DBPrefix, $fee_data, $user, $system, $fee, $_SESSION, $db;

	$query = "INSERT INTO " . $DBPrefix . "useraccounts (auc_id,user_id,date,setup,featured,bold,highlighted,subtitle,relist,reserve,buynow,image,extcat,total,paid) VALUES
	(:auction_id, :user_id, :time, :setup, :hpfeat_fee, :bolditem_fee, :hlitem_fee, :subtitle_fee, :relist_fee, :rp_fee, :buyout_fee, :picture_fee, :excat_fee, :fee, 0)";

	$params[] = array(':auction_id', $_SESSION['SELL_auction_id'], 'int');
	$params[] = array(':time', time(), 'int');
	$params[] = array(':setup', $fee_data['setup'], 'float');
	$params[] = array(':hpfeat_fee', $fee_data['hpfeat_fee'], 'float');
	$params[] = array(':bolditem_fee', $fee_data['bolditem_fee'], 'float');
	$params[] = array(':hlitem_fee', $fee_data['hlitem_fee'], 'float');
	$params[] = array(':subtitle_fee', $fee_data['subtitle_fee'], 'float');
	$params[] = array(':relist_fee', $fee_data['relist_fee'], 'float');
	$params[] = array(':rp_fee', $fee_data['rp_fee'], 'float');
	$params[] = array(':buyout_fee', $fee_data['buyout_fee'], 'float');
	$params[] = array(':picture_fee', $fee_data['picture_fee'], 'float');
	$params[] = array(':excat_fee', $fee_data['excat_fee'], 'float');
	$params[] = array(':fee', $fee, 'float');
	$params[] = array(':user_id', $user->user_data['id'], 'int');
	$db->query($query, $params);
}

function remove_bids($auction_id)
{
	global $DBPrefix, $db;
	$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auction_id";
	$params = array();
	$params[] = array(':auction_id', $auction_id, 'int');
	$db->query($query, $params);
}

function get_fee($minimum_bid, $just_fee = true)
{
	global $system, $DBPrefix, $buy_now_price, $reserve_price, $is_bold, $is_highlighted, $is_featured, $_SESSION, $subtitle, $sellcat2, $relist, $db;

	$query = "SELECT * FROM " . $DBPrefix . "fees ORDER BY type, fee_from ASC";
	$db->direct_query($query);

	$fee_value = 0;
	$fee_data = array();
	while ($row = $db->fetch())
	{
		if ($minimum_bid >= $row['fee_from'] && $minimum_bid <= $row['fee_to'] && $row['type'] == 'setup')
		{
			if ($row['fee_type'] == 'flat')
			{
				$fee_data['setup'] = $row['value'];
				$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
			}
			else
			{
				$tmp = bcdiv($row['value'], '100', $system->SETTINGS['moneydecimals']);
				$tmp = bcmul($tmp, $minimum_bid, $system->SETTINGS['moneydecimals']);
				$fee_data['setup'] = $tmp;
				$fee_value = bcadd($fee_value, $tmp, $system->SETTINGS['moneydecimals']);
			}
		}
		if ($row['type'] == 'buyout_fee' && $buy_now_price > 0)
		{
			$fee_data['buyout_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'rp_fee' && $reserve_price > 0)
		{
			$fee_data['rp_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'bolditem_fee' && $is_bold == 'y')
		{
			$fee_data['bolditem_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'hlitem_fee' && $is_highlighted == 'y')
		{
			$fee_data['hlitem_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'hpfeat_fee' && $is_featured == 'y')
		{
			$fee_data['hpfeat_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'picture_fee' && count($_SESSION['UPLOADED_PICTURES']) > 0)
		{
			$tmp = bcmul(count($_SESSION['UPLOADED_PICTURES']), $row['value'], $system->SETTINGS['moneydecimals']);
			$fee_data['picture_fee'] = $tmp;
			$fee_value = bcadd($fee_value, $tmp, $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'subtitle_fee' && !empty($subtitle))
		{
			$fee_data['subtitle_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'excat_fee' && $sellcat2 > 0)
		{
			$fee_data['excat_fee'] = $row['value'];
			$fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
		}
		if ($row['type'] == 'relist_fee' && $relist > 0)
		{
			$fee_data['relist_fee'] = ($row['value'] * $relist);
			$fee_value = bcadd($fee_value, ($row['value'] * $relist), $system->SETTINGS['moneydecimals']);
		}
	}

	if ($_SESSION['SELL_action'] == 'edit')
	{
		global $user;

		$query = "SELECT * FROM " . $DBPrefix . "useraccounts WHERE auc_id = :auction_id AND user_id = :user_id";
		$params = array();
		$params[] = array(':auction_id', $_SESSION['SELL_auction_id'], 'int');
		$params[] = array(':user_id', $user->user_data['id'], 'int');
		$db->query($query, $params);
		// build an array full of everything the user has been charged for the auction do far
		// set defaults
		$past_fees = array(
			'setup' => 0,
			'bold' => 0,
			'highlighted' => 0,
			'subtitle' => 0,
			'relist' => 0,
			'reserve' => 0,
			'buynow' => 0,
			'image' => 0,
			'extcat' => 0,
			);
		while ($row = $db->fetch())
		{
			foreach ($row as $k => $v)
			{
				if (isset($past_fees[$k]))
				{
					$past_fees[$k] += $v;
				}
				else
				{
					$past_fees[$k] = $v;
				}
			}
		}

		$diff = 0; // difference from last payment
		$fee_data['setup'] = 0; // shouldn't have to pay setup for an edit...
		$diff = bcadd($diff, $past_fees['setup'], $system->SETTINGS['moneydecimals']);
		if (isset($fee_data['bolditem_fee']) && $past_fees['bold'] == $fee_data['bolditem_fee'])
		{
			$diff = bcadd($diff, $fee_data['bolditem_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['bolditem_fee'] = 0;
		}
		if (isset($fee_data['hlitem_fee']) && $past_fees['highlighted'] == $fee_data['hlitem_fee'])
		{
			$diff = bcadd($diff, $fee_data['hlitem_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['hlitem_fee'] = 0;
		}
		if (isset($fee_data['subtitle_fee']) && $past_fees['subtitle'] == $fee_data['subtitle_fee'])
		{
			$diff = bcadd($diff, $fee_data['subtitle_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['subtitle_fee'] = 0;
		}
		if (isset($fee_data['relist_fee']) && $past_fees['relist'] == $fee_data['relist_fee'])
		{
			$diff = bcadd($diff, $fee_data['relist_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['relist_fee'] = 0;
		}
		if (isset($fee_data['rp_fee']) && $past_fees['reserve'] == $fee_data['rp_fee'])
		{
			$diff = bcadd($diff, $fee_data['rp_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['rp_fee'] = 0;
		}
		if (isset($fee_data['buyout_fee']) && $past_fees['buynow'] == $fee_data['buyout_fee'])
		{
			$diff = bcadd($diff, $fee_data['buyout_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['buyout_fee'] = 0;
		}
		if (isset($fee_data['picture_fee']) && $past_fees['image'] == $fee_data['picture_fee'])
		{
			$diff = bcadd($diff, $fee_data['picture_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['picture_fee'] = 0;
		}
		if (isset($fee_data['excat_fee']) && $past_fees['extcat'] == $fee_data['excat_fee'])
		{
			$diff = bcadd($diff, $fee_data['excat_fee'], $system->SETTINGS['moneydecimals']);
			$fee_data['excat_fee'] = 0;
		}
		$fee_value = bcsub($fee_value, $diff, $system->SETTINGS['moneydecimals']);
		if ($fee_value < 0)
		{
			$fee_value = 0;
		}
	}

	if ($just_fee)
	{
		$return = $fee_value;
	}
	else
	{
		$return = array($fee_value, $fee_data);
	}

	return $return;
}

function update_cat_counters($add, $category, $second_category = 0)
{
	global $_SESSION, $DBPrefix, $system, $catscontrol, $db;

	// get the category crumbs
	$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
	$params = array();
	$params[] = array(':cat_id', $category, 'int');
	$db->query($query, $params);
	$parent_node = $db->result();
	$category_crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

	if ($second_category > 0)
	{
		// get the second category crumbs
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
		$params = array();
		$params[] = array(':cat_id', $second_category, 'int');
		$db->query($query, $params);
		$parent_node = $db->result();
		$second_category_crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

		// merge the arrays
		$crumbs = array_merge($category_crumbs, $second_category_crumbs);
	}
	else
	{
		$crumbs = $category_crumbs;
	}

	$addsub = ($add) ? '+' : '-';
	for ($i = 0; $i < count($crumbs); $i++)
	{
		$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter " . $addsub . " 1 WHERE cat_id = :cat_id";
		$params = array();
		$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
		$db->query($query, $params);
	}
}

function get_category_string($sellcat)
{
	global $DBPrefix, $system, $catscontrol, $category_names, $db;

	if (empty($sellcat) || !isset($sellcat))
		return '';

	$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
	$params = array();
	$params[] = array(':cat_id', $sellcat, 'int');
	$db->query($query, $params);
	$parent_node = $db->result();

	$TPL_categories_list = '';
	$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	for ($i = 0; $i < count($crumbs); $i++)
	{
		if ($crumbs[$i]['cat_id'] > 0)
		{
			if ($i > 0)
			{
				$TPL_categories_list .= ' &gt; ';
			}
			$TPL_categories_list .= $category_names[$crumbs[$i]['cat_id']];
		}
	}
	return $TPL_categories_list;
}

function check_gateway($gateway)
{
	global $user;
	if ($gateway == 'paypal' && !empty($user->user_data['paypal_email']))
		return true;
	if ($gateway == 'authnet' && !empty($user->user_data['authnet_id']) && !empty($user->user_data['authnet_pass']))
		return true;
	if ($gateway == 'worldpay' && !empty($user->user_data['worldpay_id']))
		return true;
	if ($gateway == 'moneybookers' && !empty($user->user_data['moneybookers_email']))
		return true;
	if ($gateway == 'toocheckout' && !empty($user->user_data['toocheckout_id']))
		return true;
	return false;
}
