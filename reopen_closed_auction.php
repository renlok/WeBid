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
// // ################################################
// // Is the seller logged in?
if (!$user->logged_in) {
    $_SESSION['REDIRECT_AFTER_LOGIN'] = "select_category.php";
    header("Location: user_login.php");
    exit;
}
// // ################################################
if (!isset($_POST['action'])) { // already closed auctions
        // // Get Closed auctions data
        unset($_SESSION['RELISTEDAUCTION']);
    unset($_SESSION['FEATURED']);
    unset($_SESSION['UPLOADED_PICTURES']);
    unset($_SESSION['UPLOADED_PICTURES_SIZE']);
    unset($_SESSION['GALLERY_UPDATED']);
    $query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = " . intval($_GET['id']) . " AND user = " . $user->user_data['id'];
    $result = mysql_query($query);
    $system->check_mysql($result, $query, __LINE__, __FILE__);
    $RELISTEDAUCTION = mysql_fetch_array($result);

    $_SESSION['SELL_auction_id'] = $RELISTEDAUCTION['id'];
    $_SESSION['SELL_starts'] = '';
    $_SESSION['SELL_title'] = $RELISTEDAUCTION['title'];
    $_SESSION['SELL_description'] = stripslashes($RELISTEDAUCTION['description']);
    $_SESSION['SELL_atype'] = $RELISTEDAUCTION['auction_type'];
    $_SESSION['SELL_adultonly'] = $RELISTEDAUCTION['adultonly'];
    $_SESSION['SELL_buy_now_only'] = $RELISTEDAUCTION['bn_only'];
    $_SESSION['SELL_iquantity'] = $RELISTEDAUCTION['quantity'];

    $_SESSION['SELL_minimum_bid'] = floatval($RELISTEDAUCTION['minimum_bid']);
    if (floatval($RELISTEDAUCTION['reserve_price']) > 0) {
        $_SESSION['SELL_reserve_price'] = floatval($RELISTEDAUCTION['reserve_price']);
        $_SESSION['SELL_with_reserve'] = 'yes';
    } else {
        $_SESSION['SELL_reserve_price'] = '';
        $_SESSION['SELL_with_reserve'] = 'no';
    }

    $_SESSION['sellcat'] = $RELISTEDAUCTION['category'];
    $_SESSION['SELL_sellcat'] = $RELISTEDAUCTION['category'];

    $row = mysql_fetch_assoc(mysql_query("SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=" . intval($_SESSION['sellcat'])));
    while ($row['parent_id'] != 0) {
        // get info about this parent
        $row = mysql_fetch_assoc(mysql_query("SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=" . $row['parent_id']));
    }

    if (floatval($RELISTEDAUCTION['buy_now']) > 0) {
        $_SESSION['SELL_buy_now_price'] = floatval($RELISTEDAUCTION['buy_now']);
        $_SESSION['SELL_with_buy_now'] = 'yes';
    } else {
        $_SESSION['SELL_buy_now_price'] = '';
        $_SESSION['SELL_with_buy_now'] = 'no';
    }
    $_SESSION['SELL_duration'] = $RELISTEDAUCTION['duration'];
    $_SESSION['SELL_relist'] = $RELISTEDAUCTION['relist'];
    if (floatval($RELISTEDAUCTION['increment']) > 0) {
        $_SESSION['SELL_increment'] = "2";
        $_SESSION['SELL_customincrement'] = $RELISTEDAUCTION['increment'];
    } else {
        $_SESSION['SELL_increment'] = "1";
        $_SESSION['SELL_customincrement'] = '';
    }
    $_SESSION['SELL_country'] = $RELISTEDAUCTION['location'];
    $_SESSION['SELL_shipping_cost'] = $RELISTEDAUCTION['shipping_cost'];
    $_SESSION['SELL_location_zip'] = $RELISTEDAUCTION['location_zip'];
    $_SESSION['SELL_shipping'] = $RELISTEDAUCTION['shipping'];
    $_SESSION['SELL_shipping_terms'] = $RELISTEDAUCTION['shipping_terms'];
    $_SESSION['SELL_payment'] = explode("\n", $RELISTEDAUCTION['payment']);
    $_SESSION['SELL_international'] = $RELISTEDAUCTION['international'];
    $_SESSION['SELL_imgtype'] = $RELISTEDAUCTION['imgtype'];
    $_SESSION['SELL_file_uploaded'] = $RELISTEDAUCTION['photo_uploaded'];
    $_SESSION['SELL_pict_url'] = $RELISTEDAUCTION['pict_url'];
    $_SESSION['SELL_pict_url_temp'] = str_replace('thumb-', '', $RELISTEDAUCTION['pict_url']);
    $_SESSION['SELL_private'] = $RELISTEDAUCTION['private'];
    if ($private != 'y') $private = 'n';
    $_SESSION['SELL_sendemail'] = $RELISTEDAUCTION['sendemail'];
    $_SESSION['SELL_action'] = "reopen";
    header("Location: sell.php?mode=recall");
}

?>