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

include 'includes/common.inc.php';

if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = "select_category.php";
	header('location: user_login.php');
	exit;
}

if (!isset($_POST['action']))
{
	// Get Closed auctions data
	unset($_SESSION['RELISTEDAUCTION']);
	unset($_SESSION['UPLOADED_PICTURES']);
	unset($_SESSION['UPLOADED_PICTURES_SIZE']);
	unset($_SESSION['GALLERY_UPDATED']);
	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = " . intval($_GET['id']) . " AND user = " . $user->user_data['id'];
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$RELISTEDAUCTION = mysql_fetch_array($result);

	$_SESSION['RELISTEDAUCTION']	= $RELISTEDAUCTION;
	$_SESSION['SELL_starts']		= '';
	$_SESSION['SELL_title']			= $RELISTEDAUCTION['title'];
	$_SESSION['SELL_description']	= $RELISTEDAUCTION['description'];
	$_SESSION['SELL_atype']			= $RELISTEDAUCTION['auction_type'];
	$_SESSION['SELL_iquantity']		= $RELISTEDAUCTION['quantity'];
	$_SESSION['SELL_shipping_cost']	= $RELISTEDAUCTION['shipping_cost'];
	$_SESSION['SELL_minimum_bid']	= $RELISTEDAUCTION['minimum_bid'];
	$_SESSION['sellcat']			= $RELISTEDAUCTION['category'];
	$_SESSION['SELL_sellcat']		= $RELISTEDAUCTION['category'];
	$_SESSION['SELL_duration']		= $RELISTEDAUCTION['duration'];
	$_SESSION['SELL_relist']		= $RELISTEDAUCTION['relist'];
	$_SESSION['SELL_shipping']		= $RELISTEDAUCTION['shipping'];
	$_SESSION['SELL_payment']		= explode("\n", $RELISTEDAUCTION['payment']);
	$_SESSION['SELL_international']	= $RELISTEDAUCTION['international'];
	$_SESSION['SELL_imgtype']		= $RELISTEDAUCTION['imgtype'];
	$_SESSION['SELL_file_uploaded']	= $RELISTEDAUCTION['photo_uploaded'];
	$_SESSION['SELL_pict_url']		= '';
	$_SESSION['SELL_sendemail']		= $RELISTEDAUCTION['sendemail'];
	$_SESSION['SELL_shipping_terms'] = $RELISTEDAUCTION['shipping_terms'];

	if (floatval($RELISTEDAUCTION['reserve_price']) > 0)
	{
		$_SESSION['SELL_reserve_price'] = $RELISTEDAUCTION['reserve_price'];
		$_SESSION['SELL_with_reserve']  = 'yes';
	}
	else
	{
		$_SESSION['SELL_reserve_price'] = '';
		$_SESSION['SELL_with_reserve']  = 'no';
	}

	if (floatval($RELISTEDAUCTION['buy_now']) > 0)
	{
		$_SESSION['SELL_buy_now_price'] = $RELISTEDAUCTION['buy_now'];
		$_SESSION['SELL_with_buy_now']  = 'yes';
	}
	else
	{
		$_SESSION['SELL_buy_now_price'] = '';
		$_SESSION['SELL_with_buy_now']  = 'no';
	}

	if (floatval($RELISTEDAUCTION['increment']) > 0)
	{
		$_SESSION['SELL_increment']			= 2;
		$_SESSION['SELL_customincrement']	= $RELISTEDAUCTION['increment'];
	}
	else
	{
		$_SESSION['SELL_increment']			= 1;
		$_SESSION['SELL_customincrement']	= '';
	}

	header('location: sell.php?mode=recall');
}
?>
