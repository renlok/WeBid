<?php
/***************************************************************************
 *   copyright : (C) 2008 - 2021 WeBid
 *   site : http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'common.php';

$id = (int)$_GET['id'];

/**
 * Is the seller logged in?
 */
if (!$user->logged_in) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'select_category.php';
    header('location: user_login.php');
    exit;
}

if (Bids::ignoreBids($id)) {
    header('location: index.php');
    exit;
}
/** 
 * already closed auctions
 */
if (!isset($_POST['action'])) {
    /** 
     * Get Closed auctions data
     */
    unset($_SESSION['UPLOADED_PICTURES']);
    unset($_SESSION['UPLOADED_PICTURES_SIZE']);

    $relisted_auction = Auctions::forUserId($id, $user->user_data['id']);
    $difference = $relisted_auction['ends'] - $now;

    if ($user->user_data['id'] == $relisted_auction['user'] && $difference > 0) {
        $_SESSION['SELL_auction_id'] = $relisted_auction['id'];
        $_SESSION['SELL_starts'] = $relisted_auction['starts'] + $system->tdiff;
        $_SESSION['SELL_ends'] = $relisted_auction['ends'];
        $_SESSION['SELL_title'] = htmlspecialchars($relisted_auction['title']);
        $_SESSION['SELL_subtitle'] = htmlspecialchars($relisted_auction['subtitle']);
        $_SESSION['SELL_description'] = $relisted_auction['description'];
        $_SESSION['SELL_atype'] = $relisted_auction['auction_type'];
        $_SESSION['SELL_buy_now_only'] = $relisted_auction['bn_only'];
        $_SESSION['SELL_suspended'] = $relisted_auction['suspended'];
        $_SESSION['SELL_iquantity'] = $relisted_auction['quantity'];
        $_SESSION['SELL_is_bold'] = $relisted_auction['bold'];
        $_SESSION['SELL_is_highlighted'] = $relisted_auction['highlighted'];
        $_SESSION['SELL_is_featured'] = $relisted_auction['featured'];
        $_SESSION['SELL_is_taxed'] = $relisted_auction['tax'];
        $_SESSION['SELL_tax_included'] = $relisted_auction['taxinc'];
        $_SESSION['SELL_current_fee'] = $relisted_auction['current_fee'];

        if ($relisted_auction['bn_only'] == 0) {
            $_SESSION['SELL_minimum_bid'] = $system->print_money_nosymbol($relisted_auction['minimum_bid']);
        } else {
            $_SESSION['SELL_minimum_bid'] = 0;
        }

        if (floatval($relisted_auction['reserve_price']) > 0) {
            $_SESSION['SELL_reserve_price'] = $system->print_money_nosymbol($relisted_auction['reserve_price']);
            $_SESSION['SELL_with_reserve'] = 'yes';
        } else {
            $_SESSION['SELL_reserve_price'] = '';
            $_SESSION['SELL_with_reserve'] = 'no';
        }

        $_SESSION['SELL_original_sellcat1'] = $_SESSION['SELL_sellcat1'] = $relisted_auction['category'];
        $_SESSION['SELL_original_sellcat2'] = $_SESSION['SELL_sellcat2'] = $relisted_auction['secondcat'];

        if (floatval($relisted_auction['buy_now']) > 0) {
            $_SESSION['SELL_buy_now_price'] = $system->print_money_nosymbol($relisted_auction['buy_now']);
            $_SESSION['SELL_with_buy_now'] = 'yes';
        } else {
            $_SESSION['SELL_buy_now_price'] = '';
            $_SESSION['SELL_with_buy_now'] = 'no';
        }

        $_SESSION['SELL_duration'] = $relisted_auction['duration'];
        $_SESSION['SELL_relist'] = $relisted_auction['relist'];

        if (floatval($relisted_auction['increment']) > 0) {
            $_SESSION['SELL_increment'] = 2;
            $_SESSION['SELL_customincrement'] = $system->print_money_nosymbol($relisted_auction['increment']);
        } else { 
            $_SESSION['SELL_increment'] = 1;
            $_SESSION['SELL_customincrement'] = 0;
        }
        
        $_SESSION['SELL_shipping_cost'] = $system->print_money_nosymbol($relisted_auction['shipping_cost']);
        $_SESSION['SELL_additional_shipping_cost'] = $system->print_money_nosymbol(
            $relisted_auction['additional_shipping_cost']
        );
        $_SESSION['SELL_shipping'] = $relisted_auction['shipping'];
        $_SESSION['SELL_shipping_terms'] = $relisted_auction['shipping_terms'];
        $_SESSION['SELL_payment'] = explode(', ', $relisted_auction['payment']);
        $_SESSION['SELL_international'] = $relisted_auction['international'];
        $_SESSION['SELL_file_uploaded'] = $relisted_auction['photo_uploaded'];
        $_SESSION['SELL_pict_url'] = $relisted_auction['pict_url'];
        $_SESSION['SELL_pict_url_temp'] = str_replace('thumb-', '', $relisted_auction['pict_url']);

        /** 
         * get gallery images
         */
        $UPLOADED_PICTURES = array();
        $file_types = array('gif', 'jpg', 'jpeg', 'png');

        if (is_dir(UPLOAD_PATH . $id)) {
            $dir = opendir(UPLOAD_PATH.$id);
            while (($myfile = readdir($dir)) !== false) {
                if ($myfile <> '.' && $myfile != '..' && !is_file($myfile)) {
                    $file_ext = strtolower(substr($myfile, strrpos($myfile, '.') + 1));
                    if (in_array(
                            $file_ext,
                            $file_types
                        ) && (strstr(
                        $relisted_auction['pict_url'],
                            'thumb-'
                        ) === false || $relisted_auction['pict_url'] <> $myfile)) {
                        $UPLOADED_PICTURES[] = $myfile;
                    }
                }
            }
            closedir($dir);
        }

        $_SESSION['UPLOADED_PICTURES'] = $UPLOADED_PICTURES;

        if (count($UPLOADED_PICTURES) > 0) {
            if (!file_exists(UPLOAD_PATH.session_id())) {
                umask();
                mkdir(UPLOAD_PATH.session_id(), 0777);
            }
            foreach ($UPLOADED_PICTURES as $k => $v) {
                $system->move_file(
                    UPLOAD_FOLDER.(int)$_GET['id'].'/'.$v,
                    UPLOAD_FOLDER.session_id().'/'.$v,
                    false
                );
            }
            if (!empty($relisted_auction['pict_url'])) {
                $system->move_file(
                    UPLOAD_FOLDER.(int)$_GET['id'].'/'.$relisted_auction['pict_url'],
                    UPLOAD_FOLDER.session_id().'/'.$relisted_auction['pict_url'],
                    false
                );
            }
        }

        $_SESSION['SELL_action'] = 'edit';

        if ($relisted_auction['starts'] > $now) {
            $_SESSION['SELL_caneditstartdate'] = true;
        } else {
            $_SESSION['SELL_caneditstartdate'] = false;
        }
        header('location: sell.php?mode=recall');
    } else {
        header('location: index.php');
    }
}
