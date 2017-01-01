<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
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

$yesterday = new DateTime('- 1 day', $dt->UTCtimezone);
$tomorrow = new DateTime('+ 1 day', $dt->UTCtimezone);
$catscontrol = new MPTTcategories();

$user_id = (isset($_REQUEST['user_id'])) ? intval($_REQUEST['user_id']) : 0;

$feed = (isset($_GET['feed'])) ? intval($_GET['feed']) : '';
$params = array();

switch ($feed) {
    case 1:
        $RSStitle = $MSG['924']; // items listed in the last 24 hours
        $postdate = 'starts';
        $sort = 'DESC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.starts > :starts';
        $params[] = array(':starts', $yesterday, 'str');
        break;

    case 2:
        $RSStitle = $MSG['925']; // items closing in 24 hours or less
        $postdate = 'ends';
        $sort = 'ASC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.ends <= :ends';
        $params[] = array(':ends', $tomorrow, 'str');
        break;

    case 3:
        $RSStitle = $MSG['926']; // items over 300.00
        $postdate = 'ends';
        $sort = 'ASC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND (a.current_bid >= 300 OR a.minimum_bid >= 300 OR a.buy_now >= 300)';
        break;

    case 4:
        $RSStitle = $MSG['927']; // items over 1000.00
        $postdate = 'ends';
        $sort = 'ASC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND (a.current_bid >= 1000 OR a.minimum_bid >= 1000 OR a.buy_now >= 1000)';
        break;

    case 5:
        $RSStitle = $MSG['928'];
        $postdate = 'starts';
        $sort = 'DESC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND (a.current_bid <= 10 OR a.buy_now <= 10)';
        break;

    case 6:
        $RSStitle = $MSG['929']; // items with 10 or more bids
        $postdate = 'starts';
        $sort = 'DESC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.num_bids >= 10';
        break;

    case 7:
        $RSStitle = $MSG['930']; // items with 25 or more bids
        $postdate = 'starts';
        $sort = 'DESC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.num_bids >= 25';
        break;

    case 8:
        $RSStitle = $MSG['931']; // item with a Buy Now
        $postdate = 'starts';
        $sort = 'DESC';
        $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.buy_now > 0';
        break;

    default:
        $postdate = 'starts';
        if ($user_id > 0) {
            $query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :user_id";
            $db->query($query, array(array(':user_id', $user_id, 'int')));
            $username = $db->result('nick');
            $sort = 'DESC';
            $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.ends > CURRENT_TIMESTAMP AND a.user = :user_id';
            $params[] = array(':user_id', $user_id, 'int');
            $RSStitle = sprintf($MSG['932'], $username);
        } else {
            $RSStitle = $MSG['924'];
            $sort = 'DESC';
            $subquery = 'a.starts <= CURRENT_TIMESTAMP AND a.starts > :starts';
            $params[] = array(':starts', $yesterday, 'str');
        }
        break;
}

$query = "SELECT a.*, u.nick from " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		WHERE a.closed = 0 AND a.suspended = 0 AND " . $subquery . "
		ORDER BY " . $postdate . " " . $sort . " LIMIT :perpage";
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$aution_data_all = $db->fetchall();

foreach ($aution_data_all as $auction_data) {
    $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
    $params = array(
        array(':cat_id', $auction_data['category'], 'int'),
    );
    $db->query($query, $params);
    $parent_node = $db->result();

    $cat_value = '';
    $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
    for ($i = 0; $i < count($crumbs); $i++) {
        if ($crumbs[$i]['cat_id'] > 0) {
            if ($i > 0) {
                $cat_value .= ' / ';
            }
            $cat_value .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';
        }
    }

    $template->assign_block_vars('rss', array(
            'PRICE' => str_replace(array('<b>', '</b>'), '', $system->print_money(($auction_data['num_bids'] == 0) ? $auction_data['minimum_bid'] : $auction_data['current_bid'], true, false)),
            'TITLE' => htmlspecialchars($auction_data['title']),
            'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $auction_data['id'],
            'DESC' => $auction_data['description'],
            'USER' => $auction_data['nick'],
            'POSTED' => $dt->formatDate($auction_data['starts'], 'Y-m-d\TH:i:s-00:00'),
            //'POSTED' => date('D, j M Y H:i:s \G\M\T', $auction_data['starts']),
            'CAT' => $cat_value
            ));
}

$template->assign_vars(array(
        'XML' => '<?xml version="1.0" encoding="' . $CHARSET . '"?>', //as the template parser doesnt like <? tags
        'PAGE_TITLE' => $system->SETTINGS['sitename'],
        'SITEURL' => $system->SETTINGS['siteurl'],
        'DESCRIPTIONTAG' => $system->SETTINGS['descriptiontag'],
        'FEED' => $feed,
        'RSSTITLE' => $RSStitle
        ));

header('Content-Type: application/rss+xml;charset= ' . $CHARSET);

$template->set_filenames(array(
        'body' => 'rss.tpl'
        ));
$template->display('body');
