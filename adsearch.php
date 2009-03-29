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
include $include_path . 'countries.inc.php';
include $include_path . 'dates.inc.php';
include $main_path . "language/" . $language . "/categories.inc.php";

$NOW = time();

if (isset($_POST['PAGE'])) {
    $page = $_POST['PAGE'];
} else {
    $page = 1;
}

/*
* Recursive categories tree visit;
* It returns a list of all not-labeled subcategories
*/
function getsubtree($catsubtree, $i)
{
    global $catlist, $DBPrefix, $system;
    $query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = " . intval($catsubtree[$i]);
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);
    while ($row = mysql_fetch_assoc($res)) {
        // get info about this parent
        $catlist[] = $row['cat_id'];
        $catsubtree[$i + 1] = $row['cat_id'];
        getsubtree($catsubtree, $i + 1);
    }
}

if (empty($_POST)) {
    unset($_SESSION['category']);
    unset($_SESSION['catlist']);
}

$wher = '';
$payment = (isset($_POST['payment'])) ? $_POST['payment'] : '';
if (!empty($_POST['title'])) {
    $wher .= "(";
    if (isset($_POST['desc'])) {
        $wher .= "(au.description like '%" . $system->cleanvars($_POST['title']) . "%') OR ";
    }
    $wher .= "(au.title like '%" . $system->cleanvars($_POST['title']) . "%' OR au.id = " . intval($_POST['title']) . ")) AND ";
}

if (!empty($_POST['seller'])) {
    $query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = '" . $system->cleanvars($_POST['seller']) . "'";
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);

    if (mysql_num_rows($res) > 0) {
        $SELLER_ID = mysql_result($res, 0, 'id');
        $wher .= "(au.user = '" . $SELLER_ID . "') AND ";
    } else {
        $wher .= "(au.user LIKE '%-------------%') AND ";
    }
}

if (isset($_POST['buyitnow'])) {
	$wher .= "(au.buy_now > 0 AND (au.bn_only = 'y' OR au.bn_only = 'n' && (au.num_bids = 0 OR (au.reserve_price > 0 AND au.current_bid < au.reserve_price)))) AND ";
}

if (isset($_POST['buyitnowonly'])) {
    $wher .= "(au.bn_only = 'y') AND ";
}

if (!empty($_POST['zipcode'])) {
    $userjoin = "LEFT JOIN " . $DBPrefix . "users u ON (u.id = au.user)";
    $wher .= "(u.zip LIKE '%" . addslashes($_POST['zipcode']) . "%') AND ";
}

if (!isset($_POST['closed'])) {
    $wher .= "(au.closed = '0') AND ";
}

if (!empty($_POST['category'])) {
    $catlist = array();
    $catsubtree[0] = $_POST['category'];
    $catlist[] = $catsubtree[0];
    getsubtree($catsubtree, 0);
    $catalist = "(";
    $catalist .= implode(',', $catlist);
    $catalist .= ")";
    $wher .= "(au.category IN $catalist) AND ";
}

if (!empty($_POST['maxprice'])) $wher .= "(au.minimum_bid <= " . floatval($_POST['maxprice']) . ") AND ";
if (!empty($_POST['minprice'])) $wher .= "(au.minimum_bid >= " . floatval($_POST['minprice']) . ") AND ";

if (!empty($_POST['ending']) && ($_POST['ending'] == '1' || $_POST['ending'] == '2' || $_POST['ending'] == '4' || $_POST['ending'] == '6')) {
    $data = time() + ($ending * 86400);
    $wher .= "(au.ends <= $data) AND";
}

if (!empty($_POST['country'])) {
    $userjoin = "LEFT JOIN " . $DBPrefix . "users u ON (u.id = au.user)";
    $wher .= "(u.country = '" . $system->cleanvars($_POST['country']) . "') AND ";
}

if (isset($_POST['payment'])) {
    if (is_array($_POST['payment']) && count($_POST['payment']) > 1) {
        $pri = false;
        foreach($payment as $key => $val) {
            if (!$pri) {
                $ora = "AND ((au.payment LIKE '%" . addslashes($val) . "%')";
            } else {
                $ora .= " OR (au.payment LIKE '%" . addslashes($val) . "%')";
            }
            $pri = true;
        }
        $ora .= ") ";
    } else {
        $ora = "AND (au.payment LIKE '%" . addslashes($_POST['payment'][0]) . "%')";
    }
}

if (isset($_POST['SortProperty']) && $_POST['SortProperty'] == 'starts') {
    $by = 'au.starts DESC';
} elseif (isset($_POST['SortProperty']) && $_POST['SortProperty'] == 'min_bid') {
    $by = 'au.minimum_bid';
} elseif (isset($_POST['SortProperty']) && $_POST['SortProperty'] == 'max_bid') {
    $by = 'au.minimum_bid DESC';
}else {
    $by = 'au.ends ASC';
}

if ((!empty($wher) || !isset($ora)) && isset($_POST['go'])) {
    /* retrieve records corresponding to passed page number */
    $PAGE = (int)$page;
    if (intval($PAGE) == 0) $PAGE = 1;
    $lines = (int)$lines;
    if ($lines == 0) $lines = 50;

    /* determine limits for SQL query */
    $left_limit = ($PAGE - 1) * $lines;

    /* get total number of records */
    $query = "SELECT count(*) AS total FROM " . $DBPrefix . "auctions au
			$userjoin
			WHERE (au.suspended='0')
			AND ($wher au.private = 'n' $ora)
			AND	au.starts <= " . $NOW . "
			ORDER BY $by";
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);

    $hash = mysql_fetch_array($res);
    $total = (int)$hash['total'];

    /* get number of pages */
    $PAGES = (int)($total / $lines);
    if (($total % $lines) > 0)
        ++$PAGES;

    /* get records corresponding to this page*/
    $query = "SELECT au.* FROM " . $DBPrefix . "auctions au
			$userjoin
			WHERE (au.suspended='0')
			AND ($wher au.private='n' $ora)
			AND	au.starts <= " . $NOW . "
			ORDER BY $by LIMIT " . intval($left_limit) . ", " . intval($lines);
    $res = mysql_query($query);
    $system->check_mysql($res, $query, __LINE__, __FILE__);

    if (mysql_num_rows($res) > 0) {
        include $include_path . "browseitems.inc.php";
        browseItems($res, 'adsearch.php');

        include "header.php";
        $template->set_filenames(array(
                'body' => 'asearch_result.html'
                ));
        $template->display('body');
        include "footer.php";
        exit;
    } else {
        $ERR = $ERR_122;
    }
}
// -------------------------------------- payment
$qurey = "SELECT * FROM " . $DBPrefix . "payments";
$res = mysql_query($qurey);
$system->check_mysql($res, $qurey, __LINE__, __FILE__);
$num_payments = mysql_num_rows($res);
$TPL_payments_list = '';
$i = 0;
while ($i < $num_payments) {
    $payment_descr = mysql_result($res, $i, "description");
    $TPL_payments_list .= '<input type="checkbox" name="payment[]" value="' . $payment_descr . '"';
    if ($payment_descr == $payment[$i]) {
        $TPL_payments_list .= ' checked=true';
    }
    $TPL_payments_list .= ' /> ' . $payment_descr . '<br>';
    $i++;
}
// -------------------------------------- category
$TPL_categories_list = '<select name="category" onChange="javascript:document.adsearch.submit()">' . "\n";
if (isset($category_plain) && count($category_plain) > 0) {
    $category = (isset($_POST['category'])) ? $_POST['category'] : '';
    foreach($category_plain as $k => $v) {
        $TPL_categories_list .= "\t\t" . '<option value="' . $k . '" ' . (($k == $category) ? ' selected=true' : '') . '>' . $v . "</option>\n";
    }
}
$TPL_categories_list .= "</select>\n";
// Variant fields construction
$cattree = array();
// -------------------------------------- country
$TPL_countries_list = "<select name=\"country\">\n";
reset($countries);
$country = (isset($_POST['country'])) ? $_POST['country'] : '';
foreach($countries as $key => $val) {
    $TPL_countries_list .= "\t<option value=\"" . $val . "\"" . (($val == $country)?" selected=true":"") . ">" . $val . "</option>\n";
}
$TPL_countries_list .= "</select>\n";

$template->assign_vars(array(
        'ERROR' => (isset($ERR)) ? $ERR : '',
        'CATEGORY_LIST' => $TPL_categories_list,
        'CURRENCY' => $system->SETTINGS['currency'],
        'PAYMENTS_LIST' => $TPL_payments_list,
        'COUNTRY_LIST' => $TPL_countries_list
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'advanced_search.html'
        ));
$template->display('body');
include "footer.php";

?>