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

require('includes/common.inc.php');
include $main_path . 'language/' . $language . '/categories.inc.php';

// Run cron according to SETTINGS
if ($system->SETTINGS['cron'] == 2) {
    include_once 'cron.php';
}

if ($system->SETTINGS['loginbox'] == 1 && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on') {
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
    header('Location: ' . $sslurl . 'index.php');
    exit;
}

$NOW = time();

function ShowFlags() {
    global $system, $LANGUAGES;
    $counter = 0;
    $flags = '';
    foreach($LANGUAGES as $lang => $value) {
        if ($counter > 3) {
            $flags .= '<br>';
            $counter = 0;
        }
        $flags .= '<a href="?lan=' . $lang . '"><img vspace="2" hspace="2" src="' . $system->SETTINGS['siteurl'] . 'includes/flags/' . $lang . '.gif" border="0" alt="' . $lang . '"></a>';
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
$TPL_categories_value = '';
$query = "SELECT distinct * FROM " . $DBPrefix . "categories
          WHERE parent_id = 0
          $catsorting";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_cat = mysql_num_rows($res);
$i = 0;
while ($i < $num_cat && $i < $system->SETTINGS['catstoshow']) {
    $catlink = '';
    $cat_id = mysql_result($res, $i, 'cat_id');
    $cat_name = $category_names[$cat_id];
    $sub_count = intval(mysql_result($res, $i, 'sub_counter'));
    $cat_colour = mysql_result($res, $i, 'cat_colour');
    $cat_image = mysql_result($res, $i, 'cat_image');
    $template->assign_block_vars('cat_list', array(
            'CATAUCNUM' => ($sub_count != 0) ? '(' . $sub_count . ')' : '',
            'ID' => $cat_id,
            'IMAGE' => (!empty($cat_image)) ? '<img src="' . $cat_image . '" border=0>' : '',
            'COLOUR' => (empty($cat_colour)) ? '#FFFFFF' : $cat_colour,
            'NAME' => $category_names[$cat_id]
            ));
    $i++;
}

// get last created auctions
$query = "SELECT id, title, starts from " . $DBPrefix . "auctions
         WHERE closed='0' AND suspended = 0 AND ";
if ($system->SETTINGS['adultonly'] == 'y' && !$user->logged_in) {
    $query .= "adultonly='n' AND ";
}
$query .= "starts<=" . $NOW . "
         ORDER BY starts DESC
         LIMIT " . $system->SETTINGS['lastitemsnumber'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_auction = mysql_num_rows($res);

$i = 0;
$bgcolor = '#FFFFFF';
while ($i < $num_auction) {
    if ($bgcolor == '#FFFFFF') {
        $bgcolor = '#FFFEEE';
    } else {
        $bgcolor = '#FFFFFF';
    }

    $date = mysql_result($res, $i, 'starts') + $system->tdiff;

    $template->assign_block_vars('auc_last', array(
            'BGCOLOUR' => $bgcolor,
            'DATE' => ArrangeDateNoCorrection($date),
            'ID' => mysql_result($res, $i, 'id'),
            'TITLE' => mysql_result($res, $i, 'title')
            ));
    $i++;
}
$auc_last = ($i > 0) ? true : false;
// get ending soon auctions
$query = "SELECT ends, id, title FROM " . $DBPrefix . "auctions
         WHERE closed = 0 AND suspended = 0 AND starts <= " . $NOW . "
         ORDER BY ends LIMIT " . $system->SETTINGS['endingsoonnumber'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_auction = mysql_num_rows($res);

$i = 0;
$bgcolor = '#FFFFFF';
while ($i < $num_auction) {
    if ($bgcolor == '#FFFFFF') {
        $bgcolor = '#FFFEEE';
    } else {
        $bgcolor = '#FFFFFF';
    }
    $ends = mysql_result($res, $i, 'ends');
    $difference = $ends - time();
    if ($difference > 0) {
        $ends_string = FormatTimeLeft($difference);
    } else {
        $ends_string = $MSG['911'];
    }
    $template->assign_block_vars('end_soon', array(
            'BGCOLOUR' => $bgcolor,
            'DATE' => $ends_string,
            'ID' => mysql_result($res, $i, 'id'),
            'TITLE' => mysql_result($res, $i, 'title')
            ));
    $i++;
}
$end_soon = ($i > 0) ? true : false;
// get higher bids
$query = "SELECT max(b.bid) AS max_bid, a.title, a.id FROM " . $DBPrefix . "bids b
LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = b.auction)
WHERE a.suspended = 0 AND a.closed = 0 AND a.starts <= '" . $NOW . "' GROUP BY b.bid, b.auction ORDER BY max_bid DESC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$num_auction = mysql_num_rows($res);

$i = 0;
$j = 0;
$bgcolor = '#FFFFFF';
$AU = array();
while ($i < $num_auction && $j < $system->SETTINGS['higherbidsnumber']) {
    if ($bgcolor == '#FFFFFF') {
        $bgcolor = '#FFFEEE';
    } else {
        $bgcolor = '#FFFFFF';
    }

    $max_bid = mysql_result($res, $i, 'max_bid');
    $id = mysql_result($res, $i, 'id');

    if (!in_array($id, $AU)) {
        $template->assign_block_vars('max_bids', array(
                'BGCOLOUR' => $bgcolor,
                'FBID' => $system->print_money($max_bid),
                'BID' => $max_bid,
                'ID' => $id,
                'TITLE' => mysql_result($res, $i, 'title')
                ));
        $AU[] = $id;
        $j++;
    }
    $i++;
}
$high_bids = ($j > 0) ? true : false;
// Build list of help topics
$query = "SELECT id, category FROM " . $DBPrefix . "faqscat_translated WHERE lang = '" . $language . "' ORDER BY category ASC";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$i = 0;
while ($faqscat = mysql_fetch_array($res)) {
    $template->assign_block_vars('helpbox', array(
            'ID' => $faqscat['id'],
            'TITLE' => $faqscat['category']
            ));
    $i++;
}
$helpbox = ($i > 0) ? true : false;
// -- Build news list
if ($system->SETTINGS['newsbox'] == 1) {
    $query = "SELECT n.title As t, n.new_date, t.* FROM " . $DBPrefix . "news n
			LEFT JOIN " . $DBPrefix . "news_translated t ON (t.id = n.id)
			WHERE t.lang = '" . $language . "' AND n.suspended = 0
			ORDER BY new_date DESC, id DESC LIMIT " . $system->SETTINGS['newstoshow'];
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);
    while ($new = mysql_fetch_array($res)) {
        if (!empty($new['title'])) {
            $title = stripslashes($new['title']);
        } else {
            $title = stripslashes($new['t']);
        }
        $template->assign_block_vars('newsbox', array(
                'ID' => $new['id'],
                'DATE' => FormatDate($new['new_date']),
                'TITLE' => $title
                ));
    }
}

$template->assign_vars(array(
        'FLAGS' => ShowFlags(),
        'LOGIN_ERROR' => (isset($_SESSION['loginerror'])) ? $_SESSION['loginerror'] : '',

        'B_AUC_LAST' => $auc_last,
        'B_HIGH_BIDS' => $high_bids,
        'B_AUC_ENDSOON' => $end_soon,
        'B_HELPBOX' => $helpbox,
        'B_MULT_LANGS' => (count($LANGUAGES) > 1),
        'B_LOGIN_BOX' => ($system->SETTINGS['loginbox'] == 1),
        'B_LOGIN_ERROR' => (isset($_SESSION['loginerror'])),
        'B_NEWS_BOX' => ($system->SETTINGS['newsbox'] == 1)
        ));

require('header.php');
$template->set_filenames(array(
        'body' => 'home.html'
        ));
$template->display('body');
require('footer.php');

unset($_SESSION['loginerror']);
?>