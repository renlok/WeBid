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

if (!defined('InWeBid')) exit();

function browseItems($result, $current_page)
{
	global $system, $uploaded_path, $DBPrefix, $MSG, $ERR_114;
	global $id, $template, $PAGES, $PAGE;

	$k = 0;
	if ($result && mysql_num_rows($result))
	{
		while ($row = mysql_fetch_array($result))
		{
			// prepare some data
			$is_dutch = (intval($row['auction_type']) == 2) ? true : false;

			// image icon
			if (strlen($row['pict_url']) > 0)
			{
				$row['pict_url'] = 'getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&fromfile=' . $uploaded_path . $row['id'] . '/' . $row['pict_url'];
			}
			else
			{
				$row['pict_url'] = 'images/nopicture.gif';
			}

			$tplv['img'] = '<a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['id'] . '"><img src="' . $system->SETTINGS['siteurl'] . $row['pict_url'] . '" border=0 /></a>';

			// this subastas title and link to details
			$tplv['title'] = '<a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['id'] . '">' . $row['title'] . '</a>';

			if ($row['current_bid'] == 0)
			{
				$row['current_bid'] = $row['minimum_bid'];
			}

			if ($row['buy_now'] > 0 && $row['bn_only'] == 'n' && ($row['num_bids'] == 0 || ($row['reserve_price'] > 0 && $row['current_bid'] < $row['reserve_price'])))
			{
				$tplv['buy_now'] = '&nbsp;&nbsp;( <a href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><img src="' . $system->SETTINGS['siteurl'] . 'images/buy_it_now.gif" border=0 class="buynow"></a> ' . $system->print_money($row['buy_now']) . ')';
			}
			elseif ($row['buy_now'] > 0 && $row['bn_only'] == 'y')
			{
				$tplv['buy_now'] = '&nbsp;&nbsp;( <a href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><img src="' . $system->SETTINGS['siteurl'] . 'images/buy_it_now.gif" border=0 class="buynow"></a> ' . $system->print_money($row['buy_now']) . ') <img src="' . $system->SETTINGS['siteurl'] . 'images/bn_only.png" border="0" class="buynow">';
				$row['current_bid'] = $row['buy_now'];
			}
			else
			{
				$tplv['buy_now'] = '';
			}

			// number of bids for this auction
			$query = "SELECT bid FROM " . $DBPrefix . "bids WHERE auction = " . $row['id'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$num_bids = mysql_num_rows($res);

			// time left till the end of this auction 
			$s_difference = time() - $row['starts'];
			$difference = $row['ends'] - time();

			$template->assign_block_vars('items', array(
				'ID' => $row['id'],
				'ROWCOLOUR' => ($row['highlighted'] == 'y') ? 'bgcolor="#fea100"' : ($k % 2) ? 'bgcolor="#FFFEEE"' : '',
				'IMAGE' => $tplv['img'],
				'TITLE' => $tplv['title'],
				'BUY_NOW' => $tplv['buy_now'],
				'BID' => $row['current_bid'],
				'BIDFORM' => $system->print_money($row['current_bid']),
				'TIMELEFT' => FormatTimeLeft($difference),
				'NUMBIDS' => $num_bids,
				'RESERVE' => ($row['reserve_price'] > 0) ? ' <img src="images/r.gif">' : '',

				'B_BOLD' => ($row['bold'] == 'y')
			));
			$k++;
		}
		$PREV = intval($PAGE - 1);
		$NEXT = intval($PAGE + 1);
		if ($PAGES > 1)
		{
			$LOW = $PAGE - 5;
			if ($LOW <= 0) $LOW = 1;
			$COUNTER = $LOW;
			while ($COUNTER <= $PAGES && $COUNTER < ($PAGE+6))
			{
				$template->assign_block_vars('pages', array(
					'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $COUNTER . '&id=' . $id . '"><u>' . $COUNTER . '</u></a>'
				));
				$COUNTER++;
			}
		}
	}
	$template->assign_vars(array(
		'NUM_AUCTIONS' => ($k == 0) ? $ERR_114 : $k,
		'ID' => $id,
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $PREV . '&id=' . $id . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $NEXT . '&id=' . $id . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
	));
}
?>