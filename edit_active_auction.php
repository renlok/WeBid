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

$NOW = time();

// Is the seller logged in?
if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'select_category.php';
	header('location: user_login.php');
	exit;
}

$query = "SELECT id FROM " . $DBPrefix . "bids WHERE auction = " . intval($_GET['id']);
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0) {
	header('location: index.php');
	exit;
}

if (!isset($_POST['action'])) // already closed auctions
{
	// Get Closed auctions data
	unset($_SESSION['RELISTEDAUCTION']);
	unset($_SESSION['FEATURED']);
	unset($_SESSION['UPLOADED_PICTURES']);
	unset($_SESSION['UPLOADED_PICTURES_SIZE']);
	unset($_SESSION['GALLERY_UPDATED']);
	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = " . intval($_GET['id']) . " AND user = " . $user->user_data['id'];
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	
	$RELISTEDAUCTION = mysql_fetch_array($result);
	$difference = $RELISTEDAUCTION['ends'] - time();

	if ($user->user_data['id'] == $RELISTEDAUCTION['user'] && $difference > 0)
	{
		$_SESSION['SELL_auction_id']	= $RELISTEDAUCTION['id'];
		$_SESSION['SELL_starts']		= $RELISTEDAUCTION['starts'] + $system->tdiff;
		$_SESSION['SELL_ends']			= $RELISTEDAUCTION['ends'];
		$_SESSION['SELL_title']			= $RELISTEDAUCTION['title'];
		$_SESSION['SELL_description']	= stripslashes($RELISTEDAUCTION['description']);
		$_SESSION['SELL_atype']			= $RELISTEDAUCTION['auction_type'];
		$_SESSION['SELL_adultonly']		= $RELISTEDAUCTION['adultonly'];
		$_SESSION['SELL_buy_now_only']	= $RELISTEDAUCTION['bn_only'];
		$_SESSION['SELL_suspended']		= $RELISTEDAUCTION['suspended'];
		$_SESSION['SELL_iquantity']		= $RELISTEDAUCTION['quantity'];

		$_SESSION['SELL_minimum_bid'] = floatval($RELISTEDAUCTION['minimum_bid']);
		if (floatval($RELISTEDAUCTION['reserve_price']) > 0)
		{
			$_SESSION['SELL_reserve_price'] = floatval($RELISTEDAUCTION['reserve_price']);
			$_SESSION['SELL_with_reserve'] 	= 'yes';
		}
		else
		{
			$_SESSION['SELL_reserve_price'] = '';
			$_SESSION['SELL_with_reserve'] 	= 'no';
		}

		$_SESSION['sellcat']		= $RELISTEDAUCTION['category'];
		$_SESSION['SELL_sellcat']	= $RELISTEDAUCTION['category'];

		if (floatval($RELISTEDAUCTION['buy_now']) > 0)
		{
			$_SESSION['SELL_buy_now_price'] = floatval($RELISTEDAUCTION['buy_now']);
			$_SESSION['SELL_with_buy_now']	= 'yes';
		}
		else
		{
			$_SESSION['SELL_buy_now_price'] = '';
			$_SESSION['SELL_with_buy_now'] 	= 'no';
		}
		$_SESSION['SELL_duration']	= $RELISTEDAUCTION['duration'];
		$_SESSION['SELL_relist']	= $RELISTEDAUCTION['relist'];
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
		$_SESSION['SELL_shipping_cost']	 = $RELISTEDAUCTION['shipping_cost'];
		$_SESSION['SELL_shipping']		 = $RELISTEDAUCTION['shipping'];
		$_SESSION['SELL_shipping_terms'] = $RELISTEDAUCTION['shipping_terms'];
		$_SESSION['SELL_payment']		 = explode("\n", $RELISTEDAUCTION['payment']);
		$_SESSION['SELL_international']	 = $RELISTEDAUCTION['international'];
		$_SESSION['SELL_file_uploaded']	 = $RELISTEDAUCTION['photo_uploaded'];
		$_SESSION['SELL_pict_url']		 = $RELISTEDAUCTION['pict_url'];
		$_SESSION['SELL_pict_url_temp']	 = str_replace('thumb-', '', $RELISTEDAUCTION['pict_url']);
		
		// get gallery images
		$UPLOADED_PICTURES = array();
		$file_types = array('gif', 'jpg', 'jpeg', 'png');
		if (is_dir($upload_path . intval($_GET['id'])))
		{
			$dir = opendir($upload_path . intval($_GET['id']));
			while (($myfile = readdir($dir)) !== false)
			{
				if ($myfile != '.' && $myfile != '..' && !is_file($myfile))
				{
					$file_ext = strtolower(substr($myfile, strrpos($myfile, '.') + 1));
					if (in_array($file_ext, $file_types) && (strstr($RELISTEDAUCTION['pict_url'], 'thumb-') === false || $RELISTEDAUCTION['pict_url'] != $myfile))
					{
						$UPLOADED_PICTURES[] = $myfile;
					}
				}
			}
			closedir($dir);
		}
		$_SESSION['UPLOADED_PICTURES'] = $UPLOADED_PICTURES;

		if (count($UPLOADED_PICTURES) > 0)
		{
			if (!file_exists($upload_path . session_id()))
			{
				umask();
				mkdir($upload_path . session_id(), 0777);
			}
			foreach ($UPLOADED_PICTURES as $k => $v)
			{
				copy($uploaded_path . intval($_GET['id']) . '/' . $v, $uploaded_path . session_id() . '/' . $v);
			}
			if (!empty($RELISTEDAUCTION['pict_url']))
			{
				copy($uploaded_path . intval($_GET['id']) . '/' . $RELISTEDAUCTION['pict_url'], $uploaded_path . session_id() . '/' . $RELISTEDAUCTION['pict_url']);
			}
		}

		$_SESSION['SELL_action'] = 'edit';
		if ($_SESSION['SELL_starts'] > $NOW)
		{
			$_SESSION['editstartdate'] = true;
		}
		else
		{
			$_SESSION['editstartdate'] = false;
		}
		header('location: sell.php?mode=recall');
	}
	else
	{
		header('location: index.php');
	}
}
?>
