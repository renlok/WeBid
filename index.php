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

// Run cron according to SETTINGS
if ($system->SETTINGS['cron'] == 2) {
    include_once 'cron.php';
}

function ShowFlags()
{
    global $system, $LANGUAGES;
    $counter = 0;
    $flags = '';
    foreach ($LANGUAGES as $lang => $value) {
        if ($counter > 3) {
            $flags .= '<br>';
            $counter = 0;
        }
        $flags .= '<a href="?lan=' . $lang . '"><img vspace="2" hspace="2" src="' . $system->SETTINGS['siteurl'] . 'images/flags/' . $lang . '.gif" border="0" alt="' . $lang . '"></a>';
        $counter++;
    }
    return $flags;
}

// prepare categories list for templates/template
// Prepare categories sorting
if ($system->SETTINGS['catsorting'] == 'alpha') {
    $catsorting = ' ORDER BY cat_name ASC';
} else {
    $catsorting = ' ORDER BY sub_counter DESC';
}

$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -1";
$db->direct_query($query);
$parent_id = $db->result('cat_id');

$query = "SELECT * FROM " . $DBPrefix . "categories
			WHERE parent_id = :parent_id
			" . $catsorting . "
			LIMIT :limit";
$params = array();
$params[] = array(':parent_id', $parent_id, 'int');
$params[] = array(':limit', $system->SETTINGS['catstoshow'], 'int');
$db->query($query, $params);

$cat_strings = [];
$categories = [];
while ($row = $db->fetch()) {
    $cat_strings[$row['cat_id']] = $category_names[$row['cat_id']];
    $categories[$row['cat_id']] = $row;
}
// sort the categories
if ($system->SETTINGS['catsorting'] == 'alpha') {
    asort($cat_strings);
}
foreach ($cat_strings as $cat_id => $category_name) {
    $row = $categories[$cat_id];
    $template->assign_block_vars('cat_list', array(
            'CATAUCNUM' => ($row['sub_counter'] != 0) ? $row['sub_counter'] : '',
            'ID' => $row['cat_id'],
            'IMAGE' => (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '',
            'COLOUR' => (empty($row['cat_colour'])) ? '#FFFFFF' : $row['cat_colour'],
            'NAME' => $category_names[$row['cat_id']]
            ));
}

// get featured items
$query = "SELECT id, title, current_bid, pict_url, ends, num_bids, minimum_bid, bn_only, buy_now
		FROM " . $DBPrefix . "auctions
		WHERE closed = 0 AND suspended = 0 AND starts <= CURRENT_TIMESTAMP
		AND featured = 1
		ORDER BY RAND() DESC LIMIT :limit";
$params = array();
$params[] = array(':limit', $system->SETTINGS['homefeaturednumber'], 'int');
$db->query($query, $params);

$i = 0;
while ($row = $db->fetch()) {
    if (strtotime($row['ends']) - time() > 0) {
        $current_time = new DateTime('now', $dt->UTCtimezone);
        $end_time = new DateTime($row['ends'], $dt->UTCtimezone);
        $difference = $current_time->diff($end_time);
        $ends_string = $dt->formatTimeLeft($difference);
    } else {
        $ends_string = $MSG['911'];
    }
    $high_bid = ($row['num_bids'] == 0) ? $row['minimum_bid'] : $row['current_bid'];
    $high_bid = ($row['bn_only']) ? $row['buy_now'] : $high_bid;
    $template->assign_block_vars('featured', array(
            'ENDS' => $ends_string,
            'ID' => $row['id'],
            'BID' => $system->print_money($high_bid),
            'IMAGE' => (!empty($row['pict_url'])) ? 'getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&amp;fromfile=' . UPLOAD_FOLDER . $row['id'] . '/' . $row['pict_url'] : 'images/email_alerts/default_item_img.jpg',
            'TITLE' => htmlspecialchars($row['title'])
            ));
    $i++;
}

$featured_items = ($i > 0) ? true : false;

// get last created auctions
$query = "SELECT id, title, starts from " . $DBPrefix . "auctions
			WHERE closed = 0 AND suspended = 0
			AND starts <= CURRENT_TIMESTAMP
			ORDER BY starts DESC
			LIMIT :limit";
$params = array();
$params[] = array(':limit', $system->SETTINGS['lastitemsnumber'], 'int');
$db->query($query, $params);

$i = 0;
while ($row = $db->fetch()) {
    $template->assign_block_vars('auc_last', array(
            'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
            'DATE' => $dt->printDateTz($row['starts']),
            'ID' => $row['id'],
            'TITLE' => htmlspecialchars($row['title'])
            ));
    $i++;
}

$auc_last = ($i > 0) ? true : false;
// get ending soon auctions
$query = "SELECT ends, id, title FROM " . $DBPrefix . "auctions
			WHERE closed = 0 AND suspended = 0 AND starts <= CURRENT_TIMESTAMP
			ORDER BY ends LIMIT :limit";
$params = array();
$params[] = array(':limit', $system->SETTINGS['endingsoonnumber'], 'int');
$db->query($query, $params);

$i = 0;
while ($row = $db->fetch()) {
    if (strtotime($row['ends']) - time() > 0) {
        $current_time = new DateTime('now', $dt->UTCtimezone);
        $end_time = new DateTime($row['ends'], $dt->UTCtimezone);
        $difference = $current_time->diff($end_time);
        $ends_string = $dt->formatTimeLeft($difference);
    } else {
        $ends_string = $MSG['911'];
    }
    $template->assign_block_vars('end_soon', array(
            'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
            'DATE' => $ends_string,
            'ID' => $row['id'],
            'TITLE' => htmlspecialchars($row['title'])
            ));
    $i++;
}

$end_soon = ($i > 0) ? true : false;
// get hot items
$query = "SELECT a.id, a.title, a.current_bid, a.pict_url, a.ends, a.num_bids, a.minimum_bid
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "auccounter c ON (a.id = c.auction_id)
		WHERE closed = 0 AND suspended = 0 AND starts <= CURRENT_TIMESTAMP
		ORDER BY c.counter DESC LIMIT :limit";
$params = array();
$params[] = array(':limit', $system->SETTINGS['hotitemsnumber'], 'int');
$db->query($query, $params);

$i = 0;
while ($row = $db->fetch()) {
    $i++;
    if (strtotime($row['ends']) - time() > 0) {
        $current_time = new DateTime('now', $dt->UTCtimezone);
        $end_time = new DateTime($row['ends'], $dt->UTCtimezone);
        $difference = $current_time->diff($end_time);
        $ends_string = $dt->formatTimeLeft($difference);
    } else {
        $ends_string = $MSG['911'];
    }
    $high_bid = ($row['num_bids'] == 0) ? $row['minimum_bid'] : $row['current_bid'];
    $template->assign_block_vars('hotitems', array(
            'ENDS' => $ends_string,
            'ID' => $row['id'],
            'BID' => $system->print_money($high_bid),
            'IMAGE' => (!empty($row['pict_url'])) ? 'getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&amp;fromfile=' . UPLOAD_FOLDER . $row['id'] . '/' . $row['pict_url'] : 'images/email_alerts/default_item_img.jpg',
            'TITLE' => htmlspecialchars($row['title'])
            ));
}
$hot_items = ($i > 0) ? true : false;

// Build list of help topics
$query = "SELECT id, category FROM " . $DBPrefix . "faqscat_translated WHERE lang = :language ORDER BY category ASC";
$params = array();
$params[] = array(':language', $language, 'str');
$db->query($query, $params);

$i = 0;
while ($faqscat = $db->fetch()) {
    $template->assign_block_vars('helpbox', array(
            'ID' => $faqscat['id'],
            'TITLE' => $faqscat['category']
            ));
    $i++;
}

$helpbox = ($i > 0) ? true : false;
// Build news list
if ($system->SETTINGS['newsbox'] == 1) {
    $query = "SELECT n.title As t, n.new_date, t.* FROM " . $DBPrefix . "news n
			LEFT JOIN " . $DBPrefix . "news_translated t ON (t.id = n.id)
			WHERE t.lang = :language AND n.suspended = 0
			ORDER BY new_date DESC, id DESC LIMIT :limit";
    $params = array();
    $params[] = array(':language', $language, 'str');
    $params[] = array(':limit', $system->SETTINGS['newstoshow'], 'int');
    $db->query($query, $params);
    while ($new = $db->fetch()) {
        $template->assign_block_vars('newsbox', array(
                'ID' => $new['id'],
                'DATE' => $dt->formatDate($new['new_date']),
                'TITLE' => (!empty($new['title'])) ? htmlspecialchars($new['title']) : htmlspecialchars($new['t'])
                ));
    }
}

$template->assign_vars(array(
        'FLAGS' => ShowFlags(),
        'B_FEATURED_ITEMS' => $featured_items,
        'B_AUC_LAST' => $auc_last,
        'B_HOT_ITEMS' => $hot_items,
        'B_AUC_ENDSOON' => $end_soon,
        'B_HELPBOX' => ($helpbox && $system->SETTINGS['helpbox'] == 1),
        'B_MULT_LANGS' => (count($LANGUAGES) > 1),
        'B_LOGIN_BOX' => ($system->SETTINGS['loginbox'] == 1),
        'B_NEWS_BOX' => ($system->SETTINGS['newsbox'] == 1)
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'home.tpl'
        ));
$template->display('body');
include 'footer.php';

unset($_SESSION['loginerror']);
