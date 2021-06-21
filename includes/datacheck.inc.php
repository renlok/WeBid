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

function CheckFirstRegData()
{
	/*
	Checks the first data posted by the user
	in the registration process

	Return codes:   000 = data ok!
	002 = name missing
	003 = nick missing
	004 = password missing
	005 = second password missing
	006 = passwords do not match
	007 = email address missing
	008 = email address not valid
	009 = nick already exists
	010 = nick too short
	011 = password too short
	*/
	global $name, $nick, $password, $repeat_password, $email, $db;
	if (!isset($name) || empty($name))
	{
		return '002';
	}
	if (!isset($nick) || empty($nick))
	{
		return '003';
	}
	if (!isset($password) || empty($password))
	{
		return '004';
	}
	if (!isset($repeat_password) || empty($repeat_password))
	{
		return '005';
	}
	if ($password != $repeat_password)
	{
		return '006';
	}
	if (!isset($email) || empty($email))
	{
		return '007';
	}
	if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $email))
	{
		return '008';
	}
	if (strlen($nick) < 6)
	{
		return '010';
	}
	if (strlen($password) < 6)
	{
		return '011';
	}
	$query = "SELECT nick FROM " . $DBPrefix . "users WHERE nick = :user_nick";
	$params = array();
	$params[] = array(':user_nick', $nick, 'str');
	$db->query($query, $params);
	if ($db->numrows() == 0)
	{
		return '009';
	}
	return '000';
} //CheckFirstRegData()

function CheckSellData()
{
	/*
	return codes:
	017 = item title missing
	018 = item description missing
	019 = minimum bid missing
	020 = minimum bid not valid
	021 = reserve price missing
	022 = reserve price not valid
	023 = category missing
	024 = payment method missing
	025 = payment method missing
	060 = start time has already happened
	061 = buy now price inserted is not correct
	062 = may not set a reserve price in a Dutch Auction
	063 = may not use custom increments in a Dutch Auction
	064 =  may not use the Buy Now feature in a Dutch Auction
	600 = wrong auction type
	601 = wrong quantity of items
	*/

	global $title, $sdescription, $minimum_bid, $with_reserve, $reserve_price, $buy_now, $buy_now_only, $buy_now_price, $payment, $category;
	global $atype, $iquantity, $increments, $customincrement, $system, $_SESSION;
	global $payments, $num, $nnum, $a_starts, $a_ends, $start_now, $custom_end, $relist;
	global $additional_shipping_cost, $shipping_cost;

	if (empty($title))
	{
		return '017';
	}

	if (empty($sdescription))
	{
		return '018';
	}

	if (!$system->CheckMoney($minimum_bid) && $buy_now_only == 0)
	{
		return '058';
	}

	// format the info correctly
	$clean_minimum_bid = $system->input_money($minimum_bid);
	$clean_reserve_price = $system->input_money($reserve_price);
	$clean_buy_now_price = $system->input_money($buy_now_price);
	if ((empty($minimum_bid) || floatval($clean_minimum_bid) <= 0) && (!$buy_now_only))
	{
		return '019';
	}

	if (empty($reserve_price) && $with_reserve == 'yes' && $buy_now_only == 0)
	{
		return '021';
	}

	if ($increments == 2 && (empty($customincrement) || floatval($system->input_money($customincrement)) == 0))
	{
		return '056';
	}

	if (!(empty($customincrement) || floatval($system->input_money($customincrement)) == 0) && !$system->CheckMoney($customincrement))
	{
		return '057';
	}

	if ($with_reserve == 'yes' && !$system->CheckMoney($reserve_price))
	{
		return '022';
	}

	if ($buy_now_only == 1)
	{
		$buy_now = 'yes';
	}

	if ($buy_now == 'yes' && (!$system->CheckMoney($buy_now_price) || empty($buy_now_price)  || floatval($clean_buy_now_price) == 0))
	{
		return '061';
	}
	if (isset($shipping_cost) && !$system->CheckMoney($shipping_cost)) {

	return '079';

	}
	if (isset($additional_shipping_cost) && !$system->CheckMoney($additional_shipping_cost)) {


	return '080';

	}

	$numpay = count($payment);
	if ($numpay == 0)
	{
		return '024';
	}
	else
	{
		$payment_ok = 1;
	}

	if (!isset($system->SETTINGS['auction_types'][intval($atype)]))
	{
		return '600';
	}

	if (intval($iquantity) < 1)
	{
		return '601';
	}

	if ($atype == 2)
	{
		if ($with_reserve == 'yes')
		{
			$with_reserve = 'no';
			$reserve_price = '';
			return '062';
		}
		if ($increments == 2)
		{
			$increments = 1;
			$customincrement = '';
			return '063';
		}
		if ($buy_now == 'yes')
		{
			$buy_now = 'no';
			$buy_now_price = '';
			return '064';
		}
	}

	if ($with_reserve == 'yes' && $clean_reserve_price <= $clean_minimum_bid)
	{
		return '5045';
	}

	if ($buy_now == 'yes' && $buy_now_only == 0)
	{
		if (($with_reserve == 'yes' && $clean_buy_now_price <= $clean_reserve_price) || $clean_buy_now_price <= $clean_minimum_bid)
		{
			return '5046';
		}
	}

	if ($system->SETTINGS['autorelist'] == 'y')
	{
		if (!empty($relist) && !is_numeric($relist))
		{
			return '714';
		}
		elseif ($relist > $system->SETTINGS['autorelist_max'] && !empty($relist))
		{
			return '715';
		}
	}

	if (!(strpos($a_starts, '-') === false) && empty($start_now) && $_SESSION['SELL_action'] != 'edit')
	{
		$a_starts = _mktime(substr($a_starts, 11, 2),
			substr($a_starts, 14, 2),
			substr($a_starts, 17, 2),
			substr($a_starts, 0, 2),
			substr($a_starts, 3, 2),
			substr($a_starts, 6, 4));

		if ($a_starts < $system->ctime)
		{
			return '060';
		}
	}

	if (!(strpos($a_ends, '-') === false) && $custom_end == 1)
	{
		$a_ends = _mktime(substr($a_ends, 11, 2),
			substr($a_ends, 14, 2),
			substr($a_ends, 17, 2),
			substr($a_ends, 0, 2),
			substr($a_ends, 3, 2),
			substr($a_ends, 6, 4));
		if ($a_ends < $a_starts)
		{
			return '082';
		}
	}
}//--CheckSellData

function CheckBidData()
{
	global $bid, $next_bid, $atype, $qty, $Data, $bidder_id, $system;

	if ($Data['suspended'] > 0)
	{
		return '619';
	}

	if ($bidder_id == $Data['user'])
	{
		return '612';
	}

	if ($atype == 1) //normal auction
	{
		// have to use bccomp to check if bid is less than next_bid
		if (bccomp($bid, $next_bid, $system->SETTINGS['moneydecimals']) == -1)
		{
			return '607';
		}
		if ($qty > $Data['quantity'])
		{
			return '608';
		}
	}
	else //dutch auction
	{
		// cannot bid below min price
		if (bccomp($bid, $Data['minimum_bid'], $system->SETTINGS['moneydecimals']) == -1)
		{
			return '607';
		}
		if (($qty == 0) || ($qty > $Data['quantity']))
		{
			return '608';
		}
	}

	return 0;
}
