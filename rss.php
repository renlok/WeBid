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
include $main_path . 'language/' . $language . '/categories.inc.php';

$NOW = time();
$p24h = time() + (24 * 60 * 60);
$m24h = time() - (24 * 60 * 60);

$user_id = intval($_REQUEST['user_id']);

$feed = intval($_REQUEST['feed']);
$feed = (!$feed) ? 1 : $feed;
		
switch ($feed)
{
	case 1: 
		$RSStitle = $MSG['924']; // items listed in the last 24 hours
		$postdate = 'starts';
		$sort = 'DESC';
		$subquery = 'a.starts <= ' . $NOW . ' AND a.starts > ' . $m24h;
		break;

	case 2: 
		$RSStitle = $MSG['925']; // items closing in 24 hours or less
		$postdate = 'ends';
		$sort = 'ASC';
		$subquery = 'a.starts <= ' . $NOW . ' AND a.ends <= ' . $p24h;
		break;

	case 3: 
		$RSStitle = $MSG['926']; // items over 300.00
		$postdate = 'ends';
		$sort = 'ASC';
		$subquery = 'a.starts <= ' . $NOW . ' AND (a.current_bid >= 300 OR a.minimum_bid >= 300 OR a.buy_now >= 300)';
		break;

	case 4: 
		$RSStitle = $MSG['927']; // items over 1000.00
		$postdate = 'ends';
		$sort = 'ASC';
		$subquery = 'a.starts <= ' . $NOW . ' AND (a.current_bid >= 1000 OR a.minimum_bid >= 1000 OR a.buy_now >= 1000)';
		break;

	case 5: 
		$RSStitle = $MSG['928'];
		$postdate = 'starts';
		$sort = 'DESC';
		$subquery = 'a.starts <= ' . $NOW . ' AND (a.current_bid <= 10 AND a.starts <= 10)';
		break;

	case 6: 
		$RSStitle = $MSG['929']; // items with 10 or more bids
		$postdate = 'starts';
		$sort = 'DESC';
		$subquery = 'a.starts <= ' . $NOW . ' AND a.num_bids >= 10';
		break;

	case 7: 
		$RSStitle = $MSG['930']; // items with 25 or more bids
		$postdate = 'starts';
		$sort = 'DESC';
		$subquery = 'a.starts <= ' . $NOW . ' AND a.num_bids >= 25';
		break;

	case 8: 
		$RSStitle = $MSG['931']; // item with a Buy Now
		$postdate = 'starts';
		$sort = 'DESC';
		$subquery = 'a.starts <= ' . $NOW . ' AND a.buy_nowe > 0';
		break;

	default:
		$postdate = 'starts';
		if ($user_id > 0)
		{
			$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = " . $user_id;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$username = mysql_result($res, 0, 'nick');
			$sort = 'DESC';
			$subquery = 'a.starts <= ' . $NOW . ' AND a.ends > ' . $NOW . ' AND a.user = ' . $user_id;
			$RSStitle = sprintf($MSG['932'], $username);
		}
		else
		{
			$RSStitle = $MSG['924'];
			$sort = 'DESC';
			$subquery = 'a.starts <= ' . $NOW . ' AND a.starts > ' . $m24h;
		}
		break;
}

$template->assign_vars(array(
		'XML' => '<?xml version="1.0" encoding="' . $CHARSET . '"?>', //as the template parser doesnt like <? tags
		'PAGE_TITLE' => $system->SETTINGS['sitename'],
		'SITEURL' => $system->SETTINGS['siteurl'],
		'RSSTITLE' => $RSStitle
		));

$query = "SELECT a.*, u.nick from " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		WHERE a.closed = 0 AND a.suspended = 0 AND " . $subquery . "
		ORDER BY " . $postdate . " " . $sort . " " . $limit;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($auction_data = mysql_fetch_array($res))
{
	$query = "SELECT cat_id, parent_id, cat_name FROM " . $DBPrefix . "categories WHERE cat_id = " . $auction_data['category'];
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	
	$result = mysql_fetch_array ($result);
	$parent_id = $result['parent_id'];
	$cat_id = $categories;
	
	$j = $auction_data['category'];
	$i = 0;
	do
	{
		$query = "SELECT cat_id, parent_id, cat_name FROM " . $DBPrefix . "categories WHERE cat_id = '$j'";
		$result = mysql_query($query);
		$system->check_mysql($result, $query, __LINE__, __FILE__);
		$catarr = mysql_fetch_array ($result);
		$parent_id = $catarr['parent_id'];
		$c_name[$i] = $category_names[$catarr['cat_id']];
		$c_id[$i] = $catarr['cat_id'];
		$i++;
		$j = $parent_id;
	} while ($parent_id != 0);
	
	for ($j = $i - 1; $j >= 0; $j--)
	{
		if ($j == 0)
		{
			$cat_value .= "<a href='" . $system->SETTINGS['siteurl'] . "browse.php?id=" . $c_id[$j] . "'>" . $c_name[$j] . "</a>";
		}
		else
		{
			$cat_value .= "<a href='" . $system->SETTINGS['siteurl'] . "browse.php?id=" . $c_id[$j] . "'>" . $c_name[$j] . "</a> / ";
		}
	}
	
	$template->assign_block_vars('rss', array(
			'PRICE' => str_replace(array('<b>', '</b>'), '', $system->print_money(($auction_data['num_bids'] == 0) ? $auction_data['minimum_bid'] : $auction_data['current_bid'], false)),
			'TITLE' => $auction_data['title'],
			'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $auction_data['id'],
			'DESC' => $auction_data['description'],
			'USER' => $auction_data['nick'],
			'POSTED' => gmdate('D, j M Y H:i:s \G\M\T', $auction_data['starts']),
			'CAT' => $cat_value
			));
}

$template->set_filenames(array(
		'body' => 'rss.tpl'
		));
$template->display('body');
?>
