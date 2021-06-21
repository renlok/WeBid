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

function browseItems($query, $params, $query_feat, $params_feat, $total, $current_page, $extravar = '')
{
	global $system, $MSG, $ERR_114, $db;
	global $template, $PAGES, $PAGE;

	$feat_items = false;
	if ($query_feat != '')
	{
		$db->query($query_feat, $params_feat);
		$k = 0;
		while ($row = $db->fetch())
		{
			// get the data we need
			$row = build_items($row);

			// time left till the end of this auction
			$difference = $row['ends'] - time();
			$bgcolour = ($k % 2) ? 'bgcolor="#FFFEEE"' : '';

			$template->assign_block_vars('featured_items', array(
				'ID' => $row['id'],
				'ROWCOLOUR' => ($row['highlighted']) ? 'bgcolor="#fea100"' : $bgcolour,
				'IMAGE' => $row['pict_url'],
				'TITLE' => htmlspecialchars($row['title']),
				'SUBTITLE' => htmlspecialchars($row['subtitle']),
				'BUY_NOW' => ($difference < 0) ? '' : $row['buy_now'],
				'BID' => $row['current_bid'],
				'BIDFORM' => $system->print_money($row['current_bid']),
				'CLOSES' => ($difference < 1728000) ? FormatTimeLeft($difference) : ArrangeDateNoCorrection($row['ends'] + $system->tdiff),
				'NUMBIDS' => sprintf($MSG['950'], $row['num_bids']),

				'B_BOLD' => ($row['bold'])
			));
			$k++;
			$feat_items = true;
		}
	}

	$db->query($query, $params);
	$k = 0;
	while ($row = $db->fetch())
	{
		// get the data we need
		$row = build_items($row);

		// time left till the end of this auction
		$difference = $row['ends'] - time();
		$bgcolour = ($k % 2) ? 'bgcolor="#FFFEEE"' : '';

		$template->assign_block_vars('items', array(
			'ID' => $row['id'],
			'ROWCOLOUR' => ($row['highlighted']) ? 'bgcolor="#fea100"' : $bgcolour,
			'IMAGE' => $row['pict_url'],
			'TITLE' => htmlspecialchars($row['title']),
			'SUBTITLE' => htmlspecialchars($row['subtitle']),
			'BUY_NOW' => ($difference < 0) ? '' : $row['buy_now'],
			'BID' => $row['current_bid'],
			'BIDFORM' => $system->print_money($row['current_bid']),
			'CLOSES' => ($difference < 1728000) ? FormatTimeLeft($difference) : ArrangeDateNoCorrection($row['ends'] + $system->tdiff),
			'NUMBIDS' => sprintf($MSG['950'], $row['num_bids']),

			'B_BOLD' => ($row['bold'])
		));
		$k++;
	}

	$extravar = (empty($extravar)) ? '' : '&' . $extravar;
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $COUNTER . $extravar . '"><u>' . $COUNTER . '</u></a>'
			));
			$COUNTER++;
		}
	}

	$template->assign_vars(array(
		'B_FEATURED_ITEMS' => $feat_items,
		'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y'),

		'NUM_AUCTIONS' => ($total == 0) ? $ERR_114 : $total,
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $PREV . $extravar . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $NEXT . $extravar . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
	));
}

function build_items($row)
{
	global $system;

	// image icon
	if (!empty($row['pict_url']))
	{
		$row['pict_url'] = $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_list'] . '&fromfile=' . UPLOAD_FOLDER . $row['id'] . '/' . $row['pict_url'];
	}
	else
	{
		$row['pict_url'] = get_lang_img('nopicture.gif');
	}

	if ($row['current_bid'] == 0)
	{
		$row['current_bid'] = $row['minimum_bid'];
	}

	if ($row['buy_now'] > 0 && $row['bn_only'] == 0 && ($row['num_bids'] == 0 || ($row['reserve_price'] > 0 && $row['current_bid'] < $row['reserve_price'])))
	{
		$row['buy_now'] = '<a href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><img src="' . get_lang_img('buy_it_now.gif') . '" border=0 class="buynow"></a>' . $system->print_money($row['buy_now']);
	}
	elseif ($row['buy_now'] > 0 && $row['bn_only'])
	{
		$row['current_bid'] = $row['buy_now'];
		$row['buy_now'] = '<a href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><img src="' . get_lang_img('buy_it_now.gif') . '" border=0 class="buynow"></a>' . $system->print_money($row['buy_now']) . ' <img src="' . get_lang_img('bn_only.png') . '" border="0" class="buynow">';
	}
	else
	{
		$row['buy_now'] = '';
	}

	return $row;
}
