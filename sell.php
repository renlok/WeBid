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
include INCLUDE_PATH . 'datacheck.inc.php';
include INCLUDE_PATH . 'functions_sell.php';
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';
include PACKAGE_PATH . 'ckeditor/ckeditor.php';

$_SESSION['action'] = (!isset($_SESSION['action'])) ? 1 : $_SESSION['action'];
$_SESSION['action'] = (!isset($_POST['action'])) ? $_SESSION['action'] : $_POST['action'];
$ERR = 'ERR_';
$_SESSION['SELL_editing_category'] = false;
$catscontrol = new MPTTcategories();

if (!isset($_SESSION['SELL_sellcat1']) || !is_numeric($_SESSION['SELL_sellcat1'])) {
    header('location: select_category.php');
    exit;
}

if (!$user->checkAuth()) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'sell.php';
    header('location: user_login.php');
    exit;
}

if (in_array($user->user_data['suspended'], array(5, 6, 7))) {
    header('location: message.php');
    exit;
}

if (!$user->permissions['can_sell']) {
    $_SESSION['TMP_MSG'] = $MSG['818'];
    header('location: user_menu.php?cptab=selling');
    exit;
}

// check if user skiped adding second category
if (isset($_POST['act']) && $_POST['act'] == 'skipexcat') {
    $_SESSION['SELL_sellcat2'] = 0;
}

// GALLERY FUNCTIONS
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['img'])) { // Process delete photos
    if ($_SESSION['SELL_pict_url_temp'] == $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]) {
        unlink(UPLOAD_PATH . session_id() . '/' . $_SESSION['SELL_pict_url']);
        unset($_SESSION['SELL_pict_url']);
    }
    unlink(UPLOAD_PATH . session_id() . '/' . $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]);
    unset($_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]);
    unset($_SESSION['UPLOADED_PICTURES_SIZE'][intval($_GET['img'])]);
}

if (isset($_GET['action']) && $_GET['action'] == 'makedefault') {
    $_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $_GET['img'];
}

// set variables
setvars();

if (isset($_GET['mode']) && $_GET['mode'] == 'recall') {
    $_SESSION['action'] = 1;
}

switch ($_SESSION['action']) {
    case 4: // finalise auction (submit to db)
        // does the user need to login before they can submit the auction?
        if ($system->SETTINGS['usersauth'] == 'y') {
            // hash and check the password
            include PACKAGE_PATH . 'PasswordHash.php';
            $phpass = new PasswordHash(8, false);
            if (!isset($_POST['password']) || !($phpass->CheckPassword($_POST['password'], $user->user_data['password']))) {
                $ERR = $ERR_006;
            }
        }
        if ($ERR != 'ERR_') {
            $_SESSION['action'] = 2;
        } else {
            // clean up sell description
            $_SESSION['SELL_description'] = $system->cleanvars($_SESSION['SELL_description'], true);

            $payment_text = implode(', ', $payment);
            // finalise start and end times
            $a_starts = (empty($start_now) || !$caneditstartdate) ? $a_starts : $dt->currentDatetime();
            if ($custom_end == 0) {
                $start_datetime = new DateTime($a_starts, $dt->timezone);
                $start_datetime->add(new DateInterval('P' . $duration . 'D'));
                $a_ends = $start_datetime->format('Y-m-d H:i:s');
            }
            // get fee
            $fee_data = get_fee($minimum_bid, false);
            $fee = $fee_data[0];
            $fee_data = $fee_data[1];

            $requires_premoderation = false;

            // check the auction has not been submitted already
            if (!isset($_SESSION['SELL_submitted'][$_SESSION['SELL_hash']]) || !$_SESSION['SELL_submitted'][$_SESSION['SELL_hash']]) {
                if ($_SESSION['SELL_action'] == 'edit') {
                    updateauction();
                    $auction_id = $_SESSION['SELL_auction_id'];
                } else {
                    // insert auction
                    addauction();
                    $auction_id = $db->lastInsertId();
                    //print_r($db);
                    $_SESSION['SELL_auction_id'] = $auction_id;

                    if ($system->SETTINGS['use_moderation'] && $system->SETTINGS['auction_moderation']) {
                        switch ($system->SETTINGS['new_auction_moderation']) {
                            case 1:
                                $requires_premoderation = true;

                                $query = "UPDATE `" . $DBPrefix . "auctions` SET `suspended` = 1 WHERE id = :auction_id";
                                $params = array();
                                $params[] = array(':auction_id', $auction_id, 'int');
                                $db->query($query, $params);
                            case 2:
                                $query = "INSERT INTO `" . $DBPrefix . "auction_moderation` (`auction_id`, `reason`) VALUES (:auction_id, '1')";
                                $params = array();
                                $params[] = array(':auction_id', $auction_id, 'int');
                                $db->query($query, $params);
                                break;
                        }
                    }
                }
                $_SESSION['SELL_submitted'][$_SESSION['SELL_hash']] = true;
            } else {
                $auction_id = $_SESSION['SELL_auction_id'];
            }

            $addcounter = true;

            // work out & add fee
            if ($system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees']) {
                $feeupdate = false;
                // attach the new invoice to users account
                addoutstanding();

                // deal with the auction
                if ($system->SETTINGS['fee_type'] == 2 && $fee > 0) {
                    $query = "UPDATE " . $DBPrefix . "auctions SET suspended = 9 WHERE id = :auction_id";
                    $params = array();
                    $params[] = array(':auction_id', $auction_id, 'int');
                    $db->query($query, $params);
                    $addcounter = false;
                } else {
                    $query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :user_id";
                    $params = array();
                    $params[] = array(':fee', $fee, 'float');
                    $params[] = array(':user_id', $user->user_data['id'], 'int');
                    $db->query($query, $params);
                }
            }

            if (!$requires_premoderation) {
                if ($addcounter && $_SESSION['SELL_action'] != 'edit') {
                    $query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
                    $db->direct_query($query);
                } elseif (!$addcounter && $_SESSION['SELL_action'] == 'edit') {
                    $query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions - 1";
                    $db->direct_query($query);
                }

                // no fees are due and your not editing the auction so add to the auction count
                if (!($system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees'] && $system->SETTINGS['fee_type'] == 2 && $fee > 0) && $_SESSION['SELL_action'] != 'edit') {
                    // update recursive categories
                    update_cat_counters(true, $_SESSION['SELL_sellcat1'], $_SESSION['SELL_sellcat2']);
                }

                // fees are due and you are editing the auction so remove the auction count
                if (!$addcounter && $_SESSION['SELL_action'] == 'edit') {
                    // update recursive categories
                    update_cat_counters(false, $_SESSION['SELL_sellcat1'], $_SESSION['SELL_sellcat2']);
                }

                // if editing the auction and the categories have been changed
                if ($_SESSION['SELL_action'] == 'edit' && ($_SESSION['SELL_sellcat1'] != $_SESSION['SELL_original_sellcat1'] || $_SESSION['SELL_sellcat2'] != $_SESSION['SELL_original_sellcat2'])) {
                    if ($_SESSION['SELL_sellcat1'] != $_SESSION['SELL_original_sellcat1'] || $_SESSION['SELL_sellcat2'] != $_SESSION['SELL_original_sellcat2']) {
                        // remove the old category count and add to the new one
                        update_cat_counters(false, $_SESSION['SELL_sellcat1'], $_SESSION['SELL_sellcat2']);
                        update_cat_counters(true, $_SESSION['SELL_original_sellcat1'], $_SESSION['SELL_original_sellcat2']);
                    }
                }
            }

            $UPLOADED_PICTURES = (isset($_SESSION['UPLOADED_PICTURES'])) ? $_SESSION['UPLOADED_PICTURES'] : array();
            // remove old images if any
            if (is_dir(UPLOAD_PATH . $auction_id)) {
                if ($dir = opendir(UPLOAD_PATH . $auction_id)) {
                    while (($file = readdir($dir)) !== false) {
                        if (is_file(UPLOAD_PATH . $auction_id . '/' . $file)) {
                            unlink(UPLOAD_PATH . $auction_id . '/' . $file);
                        }
                    }
                    closedir($dir);
                }
            }

            // Create pictures gallery if any
            if ($system->SETTINGS['picturesgallery'] == 1 && count($UPLOADED_PICTURES) > 0) {
                // Create directory
                umask();
                if (!is_dir(UPLOAD_PATH . $auction_id)) {
                    mkdir(UPLOAD_PATH . $auction_id, 0777);
                }
                // Copy files
                foreach ($UPLOADED_PICTURES as $k => $v) {
                    $system->move_file(UPLOAD_PATH . session_id() . '/' . $v, UPLOAD_PATH . $auction_id . '/' . $v);
                    chmod(UPLOAD_PATH . $auction_id . '/' . $v, 0777);
                }
                if (!empty($pict_url)) {
                    $system->move_file(UPLOAD_PATH . session_id() . '/' . $pict_url, UPLOAD_PATH . $auction_id . '/' . $pict_url);
                    chmod(UPLOAD_PATH . $auction_id . '/' . $pict_url, 0777);
                }
                // Delete files, using dir (to eliminate eventual odd files)
                if (is_dir(UPLOAD_PATH . session_id())) {
                    if ($dir = opendir(UPLOAD_PATH . session_id())) {
                        while (($file = readdir($dir)) !== false) {
                            if (!is_dir(UPLOAD_PATH . session_id() . '/' . $file)) {
                                unlink(UPLOAD_PATH . session_id() . '/' . $file);
                            }
                        }
                        closedir($dir);
                    }
                    rmdir(UPLOAD_PATH . session_id());
                }
            }

            if (!isset($_SESSION['SELL_action']) || empty($_SESSION['SELL_action'])) {
                if (!$requires_premoderation) {
                    alert_auction_watchers($auction_id, $_SESSION['SELL_title'], $_SESSION['SELL_description']);
                }

                if ($user->user_data['startemailmode'] == 'yes' && $addcounter) {
                    if (!$requires_premoderation) {
                        include INCLUDE_PATH . 'email/auction_confirmation.php';
                    } else {
                        include INCLUDE_PATH . 'email/auction_pending_moderation.php';
                    }
                } elseif ($user->user_data['startemailmode'] == 'yes') {
                    // awaiting payment
                    include INCLUDE_PATH . 'auction_pending.php';
                }

                if ($system->SETTINGS['bn_only'] && $system->SETTINGS['bn_only_disable'] == 'y' && $system->SETTINGS['bn_only_percent'] < 100) {
                    $query = "SELECT COUNT(*) as count FROM " . $DBPrefix . "auctions
							WHERE closed = 0 AND suspended = 0 AND user = :user_id";
                    $params = array();
                    $params[] = array(':user_id', $user->user_data['id'], 'int');
                    $db->query($query, $params);
                    $totalaucs = $db->result('count');
                    if ($totalaucs > 0) {
                        $query = "SELECT COUNT(*) as count FROM " . $DBPrefix . "auctions
								WHERE closed = 0 AND suspended = 0 AND bn_only = 1 AND user = :user_id";
                        $params = array();
                        $params[] = array(':user_id', $user->user_data['id'], 'int');
                        $db->query($query, $params);
                        $totalbnaucs = $db->result('count');
                        $percent = ($totalbnaucs * 100) / $totalaucs;
                        if ($user->user_data['bn_only'] && $system->SETTINGS['bn_only_percent'] <= $percent) {
                            $query = "UPDATE " . $DBPrefix . "users SET bn_only = 0 WHERE id = :user_id";
                            $params = array();
                            $params[] = array(':user_id', $user->user_data['id'], 'int');
                            $db->query($query, $params);
                        }
                        if ($user->user_data['bn_only'] == 0 && $system->SETTINGS['bn_only_percent'] > $percent) {
                            $query = "UPDATE " . $DBPrefix . "users SET bn_only = 1 WHERE id = :user_id";
                            $params = array();
                            $params[] = array(':user_id', $user->user_data['id'], 'int');
                            $db->query($query, $params);
                        }
                    }
                }
            }

            unsetsessions();
            if (defined('TrackUserIPs')) {
                // log auction setup IP
                $system->log('user', 'List Item', $user->user_data['id'], $auction_id);
            }

            if ($system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees'] && $system->SETTINGS['fee_type'] == 2 && $fee > 0) {
                $_SESSION['auction_id'] = $auction_id;
                header('location: pay.php?a=4');
                exit;
            }

            $template->assign_vars(array(
                    'ATYPE_PLAIN' => null,
                    'ERROR' => null,
                    'TITLE' => $MSG['028'],
                    'PAGE' => 3,
                    'AUCTION_ID' => $auction_id,
                    'MESSAGE' => sprintf($MSG['102'], $auction_id, $dt->formatDate($a_ends, 'D j M \a\t g:ia'))
                    ));
            break;
        }
    case 3: // confirm auction
        $noerror = true;
        if ($with_reserve == 'no') {
            $reserve_price = 0;
        }
        if ($buy_now == 'no') {
            $buy_now_price = 0;
        }
        // run the word filter
        if ($system->SETTINGS['wordsfilter'] == 'y') {
            $title = $system->filter($title);
            $subtitle = $system->filter($subtitle);
            $sdescription = $system->filter($sdescription);
        }
        // check for errors
        if ($ERR == 'ERR_') {
            if (count($_SESSION['UPLOADED_PICTURES']) > $system->SETTINGS['maxpictures']) {
                $ERR = sprintf($MSG['674'], $system->SETTINGS['maxpictures']);
            }
            $ERR = 'ERR_' . CheckSellData();
            if ($ERR != 'ERR_') {
                $_SESSION['action'] = 2;
                $noerror = false;
            }
        }
        if ($noerror) {
            // payment methods
            $payment_methods = '';
            $query = "SELECT * FROM " . $DBPrefix . "payment_options";
            $db->direct_query($query);
            while ($payment_method = $db->fetch()) {
                if ($payment_method['gateway_active'] == 1 || $payment_method['is_gateway'] == 0) {
                    if (in_array($payment_method['name'], $payment)) {
                        $payment_methods .= '<p>' . $payment_method['displayname'] . '</p>';
                    }
                }
            }

            // category name
            $category_string1 = get_category_string($sellcat1);
            $category_string2 = get_category_string($sellcat2);

            $query = "SELECT description FROM " . $DBPrefix . "durations WHERE days = :duration";
            $params = array();
            $params[] = array(':duration', $duration, 'int');
            $db->query($query, $params);
            $duration_desc = $db->result('description');
            // built gallery
            if ($system->SETTINGS['picturesgallery'] == 1 && isset($_SESSION['UPLOADED_PICTURES']) && count($_SESSION['UPLOADED_PICTURES']) > 0) {
                foreach ($_SESSION['UPLOADED_PICTURES'] as $k => $v) {
                    $template->assign_block_vars('gallery', array(
                            'K' => $k,
                            'IMAGE' => UPLOAD_FOLDER . session_id() . '/' . $v
                            ));
                }
            }

            $iquantity = ($atype == 2 || $buy_now_only) ? $iquantity : 1;

            $shippingtext = '';
            if ($shipping == 1) {
                $shippingtext = $MSG['033'];
            } elseif ($shipping == 2) {
                $shippingtext = $MSG['032'];
            } elseif ($shipping == 3) {
                $shippingtext = $MSG['867'];
            }

            $current_fee = ((isset($_SESSION['SELL_current_fee'])) ? $_SESSION['SELL_current_fee'] : '0');
            $corrected_fee = bcsub(get_fee($minimum_bid), $current_fee, $system->SETTINGS['moneydecimals']);
            if ($corrected_fee < 0) {
                $corrected_fee = 0;
            }

            $template->assign_vars(array(
                    'TITLE' => htmlspecialchars($title),
                    'SUBTITLE' => htmlspecialchars($subtitle),
                    'ERROR' => ($ERR == 'ERR_') ? '' : $ERR,
                    'PAGE' => 2,
                    'MINTEXT' => ($atype == 2) ? $MSG['038'] : $MSG['020'],

                    'AUC_DESCRIPTION' => $sdescription,
                    'PIC_URL' => (empty($pict_url)) ? $MSG['114'] : '<img src="' . UPLOAD_FOLDER . session_id() . '/' . $pict_url . '" style="max-width:100%; max-height:100%;">',
                    'MIN_BID' => $system->print_money($minimum_bid, false),
                    'RESERVE' => $system->print_money($reserve_price, false),
                    'BN_PRICE' => $system->print_money($buy_now_price, false),
                    'SHIPPING_COST' => $system->print_money($shipping_cost, false),
                    'ADDITIONAL_SHIPPING_COST' => $system->print_money($additional_shipping_cost, false),
                    'STARTDATE' => (empty($start_now)) ? $dt->formatDate($a_starts) : $dt->formatDate('now'),
                    'END_TIME' => $dt->formatDate($a_ends),
                    'CUSTOM_END' => $custom_end,
                    'DURATION' => $duration_desc,
                    'INCREMENTS' => ($increments == 1) ? $MSG['614'] : $system->print_money($customincrement, false),
                    'ATYPE' => $system->SETTINGS['auction_types'][$atype],
                    'ATYPE_PLAIN' => $atype,
                    'SHIPPING' => $shippingtext,
                    'INTERNATIONAL' => ($international) ? $MSG['033'] : $MSG['043'],
                    'SHIPPING_TERMS' => nl2br($shipping_terms),
                    'PAYMENTS_METHODS' => $payment_methods,
                    'CAT_LIST1' => $category_string1,
                    'CAT_LIST2' => $category_string2,
                    'FEE' => number_format($corrected_fee, $system->SETTINGS['moneydecimals']),

                    'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y'),
                    'B_BN_ONLY' => (!($system->SETTINGS['buy_now'] == 2 && $buy_now_only)),
                    'B_BN' => ($system->SETTINGS['buy_now'] == 2),
                    'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1 && isset($_SESSION['UPLOADED_PICTURES']) && count($_SESSION['UPLOADED_PICTURES']) > 0),
                    'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1),
                    'B_FEES' => ($system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees']),
                    'B_SHIPPING' => ($system->SETTINGS['shipping'] == 'y'),
                    'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y')
                    ));
            break;
        }
    case 1:  // enter auction details
        $category_string1 = get_category_string($sellcat1);
        $category_string2 = get_category_string($sellcat2);

        // auction types
        $TPL_auction_type = '<select name="atype" id="atype">' . "\n";
        foreach ($system->SETTINGS['auction_types'] as $key => $val) {
            $TPL_auction_type .= "\t" . '<option value="' . $key . '" ' . (($key == $atype) ? 'selected="true"' : '') . '>' . $val . '</option>' . "\n";
        }
        $TPL_auction_type .= '</select>' . "\n";

        // get time passed in days
        if ($_SESSION['SELL_action'] != 'edit') {
            $days_passed = 0;
        } else {
            $current_time = new DateTime('now', $dt->timezone);
            $start_time = new DateTime($a_starts, $dt->timezone);
            $difference = $start_time->diff($current_time);
            $days_passed = $difference->d;
        }
        // get valid durations
        $query = "SELECT * FROM " . $DBPrefix . "durations WHERE days > :days ORDER BY days";
        $params = array();
        $params[] = array(':days', floor($days_passed), 'int');
        $db->query($query, $params);
        $TPL_durations_list = '<select name="duration">' . "\n";
        while ($row = $db->fetch()) {
            $selected = ($row['days'] == $duration) ? 'selected="true"' : '';
            $TPL_durations_list .= "\t" . '<option value="' . $row['days'] . '" ' . $selected . '>' . $row['description'] . '</option>' . "\n";
        }
        $TPL_durations_list .= '</select>' . "\n";

        // can seller charge tax
        $can_tax = false;
        if (!empty($user->user_data['country'])) {
            $query = "SELECT id FROM " . $DBPrefix . "tax WHERE countries_seller LIKE :country";
            $params = array();
            $params[] = array(':country', $user->user_data['country'], 'str');
            $db->query($query, $params);
            if ($db->numrows() > 0) {
                $can_tax = true;
            }
        }

        // payments
        $payment_methods = '';
        $query = "SELECT * FROM " . $DBPrefix . "payment_options";
        $db->direct_query($query);
        while ($payment_method = $db->fetch()) {
            if ($payment_method['gateway_active'] == 1 || $payment_method['is_gateway'] == 0) {
                $checked = (in_array($payment_method['name'], $payment)) ? 'checked' : '';
                $payment_methods .= '<p><label><input type="checkbox" name="payment[]" value="' . $payment_method['name'] . '" ' . $checked . '> ' . $payment_method['displayname'] . '</label></p>';
            }
        }

        // make hour
        $TPL_start_date = $a_starts;
        $TPL_end_date = $a_ends;
        if ($_SESSION['SELL_action'] != 'edit') {
            if (empty($a_starts)) {
                $TPL_start_date = $dt->currentDatetime();
                $end_date = new DateTime('+1 day', $dt->timezone);
                $TPL_end_date = $end_date->format('Y-m-d H:i:s');
            }
        }

        // can edit start date check
        $caneditstartdate = false;
        $starting_date = new DateTime($a_starts);
        $current_date = new DateTime();
        if ($system->SETTINGS['edit_starttime'] && ($_SESSION['SELL_action'] != 'edit' ||
            ($starting_date > $current_date && $_SESSION['SELL_action'] == 'edit'))) {
            $caneditstartdate = true;
        }

        $CKEditor = new CKEditor();
        $CKEditor->basePath = 'js/ckeditor/';
        $CKEditor->returnOutput = true;

        // build the fees javascript
        $fees = array( //0 = single value, 1 = staged fees
            'setup_fee' => 1,
            'featured_fee' => 0,
            'bold_fee' => 0,
            'highlighted_fee' => 0,
            'reserve_fee' => 0,
            'picture_fee' => 0,
            'buynow_fee' => 0,
            'subtitle_fee' => 0,
            'relist_fee' => 0
            );
        $feevarsset = array();
        $fee_javascript = '';
        $relist_fee = $subtitle_fee = $fee_rp = $fee_bn = $fee_min_bid = 0;
        $query = "SELECT * FROM " . $DBPrefix . "fees ORDER BY type, fee_from ASC";
        $db->direct_query($query);
        while ($row = $db->fetch()) {
            if (isset($fees[$row['type']]) && $fees[$row['type']] == 0) {
                $fee_javascript .= 'var ' . $row['type'] . ' = ' . $row['value'] . ';' . "\n";
            }
            if (isset($fees[$row['type']]) && $fees[$row['type']] == 1) {
                if (!isset($feevarsset[$row['type']])) {
                    $fee_javascript .= 'var ' . $row['type'] . ' = new Array();' . "\n";
                    $feevarsset[$row['type']] = 0;
                }
                $fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '] = new Array();' . "\n";
                $fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][0] = ' . $row['fee_from'] . ';' . "\n";
                $fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][1] = ' . $row['fee_to'] . ';' . "\n";
                $fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][2] = ' . $row['value'] . ';' . "\n";
                $fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][3] = \'' . $row['fee_type'] . '\';' . "\n";
                $feevarsset[$row['type']]++;
            }
            if ($minimum_bid >= $row['fee_from'] && $minimum_bid <= $row['fee_to'] && $row['type'] == 'setup_fee') {
                if ($row['fee_type'] == 'flat') {
                    $fee_min_bid = $row['value'];
                } else {
                    $fee_min_bid = ($row['value'] / 100) * $minimum_bid;
                }
            }
            if ($row['type'] == 'buynow_fee' && $buy_now_price > 0) {
                $fee_bn = $row['value'];
            }
            if ($row['type'] == 'reserve_fee' && $reserve_price > 0) {
                $fee_rp = $row['value'];
            }
            if ($row['type'] == 'subtitle_fee' && strlen($subtitle) > 0) {
                $subtitle_fee = $row['value'];
            }
            if ($row['type'] == 'relist_fee' && strlen($relist) > 0) {
                $relist_fee = $row['value'];
            }
        }
        $current_fee = ((isset($_SESSION['SELL_current_fee'])) ? $_SESSION['SELL_current_fee'] : '0');
        $fee_javascript .= 'var current_fee = ' . $current_fee . ';';
        $relist_options = '<select name="autorelist" id="autorelist">';
        for ($i = 0; $i <= $system->SETTINGS['autorelist_max']; $i++) {
            $relist_options .= '<option value="' . $i . '"' . (($relist == $i) ? ' selected="selected"' : '') . '>' . $i . '</option>';
        }
        $relist_options .= '</select>';
        $fee_value = get_fee($minimum_bid);
        $corrected_fee = bcsub($fee_value, $current_fee, $system->SETTINGS['moneydecimals']);
        if ($corrected_fee < 0) {
            $corrected_fee = 0;
        }

        $template->assign_vars(array(
                'TITLE' => $MSG['028'],
                'ERROR' => ($ERR == 'ERR_') ? '' : $$ERR,
                'CAT_LIST1' => $category_string1,
                'CAT_LIST2' => $category_string2,
                'ATYPE' => $TPL_auction_type,
                'ATYPE_PLAIN' => $atype,
                'CURRENCY' => $system->SETTINGS['currency'],
                'DURATIONS' => $TPL_durations_list,
                'PAYMENTS' => $payment_methods,
                'PAGE' => 0,
                'MINTEXT' => ($atype == 2) ? $MSG['038'] : $MSG['020'],
                'FEE_JS' => $fee_javascript,
                // auction details
                'AUC_TITLE' => htmlspecialchars($title),
                'AUC_SUBTITLE' => htmlspecialchars($subtitle),
                'AUC_DESCRIPTION' => $CKEditor->editor('sdescription', $sdescription),
                'ITEMQTY' => $iquantity,
                'MIN_BID' => $system->print_money_nosymbol($minimum_bid, false),
                'BN_ONLY' => ($buy_now_only) ? 'disabled' : '',
                'SHIPPING_COST' => $system->print_money_nosymbol($shipping_cost, false),
                'ADDITIONAL_SHIPPING_COST' => $system->print_money_nosymbol($additional_shipping_cost, false),
                'RESERVE_Y' => ($with_reserve == 'yes') ? 'checked' : '',
                'RESERVE_N' => ($with_reserve == 'yes') ? '' : 'checked',
                'RESERVE' => $system->print_money_nosymbol($reserve_price, false),
                'START_TIME' => $dt->formatDate($TPL_start_date),
                'END_TIME' => $dt->formatDate($TPL_end_date),
                'CUSTOM_END' => (!empty($custom_end)) ? 'checked' : '',
                'BN_ONLY_Y' => ($buy_now_only) ? 'checked' : '',
                'BN_ONLY_N' => ($buy_now_only) ? '' : 'checked',
                'BN_Y' => ($buy_now == 'yes') ? 'checked' : '',
                'BN_N' => ($buy_now == 'yes') ? '' : 'checked',
                'BN_PRICE' => $system->print_money_nosymbol($buy_now_price, false),
                'INCREMENTS1' => ($increments == 1 || empty($increments)) ? 'checked' : '',
                'INCREMENTS2' => ($increments == 2) ? 'checked' : '',
                'CUSTOM_INC' => ($customincrement > 0) ? $system->print_money_nosymbol($customincrement, false) : '',
                'SHIPPING1' => (intval($shipping) == 1) ? 'checked' : '',
                'SHIPPING2' => (intval($shipping) == 2 || empty($shipping)) ? 'checked' : '',
                'SHIPPING3' => (intval($shipping) == 3) ? 'checked' : '',
                'INTERNATIONAL' => (!empty($international)) ? 'checked' : '',
                'SHIPPING_TERMS' => htmlspecialchars($shipping_terms),
                'ITEMQTYD' => ($atype == 2 || $buy_now_only) ? '' : 'disabled',
                'START_NOW' => (!empty($start_now)) ? 'checked' : '',
                'IS_BOLD' => ($is_bold) ? 'checked' : '',
                'IS_HIGHLIGHTED' => ($is_highlighted) ? 'checked' : '',
                'IS_FEATURED' => ($is_featured) ? 'checked' : '',
                'NUMIMAGES' => count($_SESSION['UPLOADED_PICTURES']),
                'RELIST' => $relist_options,
                'MAXRELIST' => $system->SETTINGS['autorelist_max'],
                'TAX_Y' => ($is_taxed == 1) ? 'checked' : '',
                'TAX_N' => ($is_taxed == 0) ? 'checked' : '',
                'TAXINC_Y' => ($tax_included == 1) ? 'checked' : '',
                'TAXINC_N' => ($tax_included == 0) ? 'checked' : '',
                'MAXPICS' => sprintf($MSG['673'], $system->SETTINGS['maxpictures'], $system->SETTINGS['maxuploadsize']/1024),

                'FEE_VALUE' => $fee_value,
                'FEE_VALUE_F' => number_format($corrected_fee, $system->SETTINGS['moneydecimals']),
                'FEE_MIN_BID' => $fee_min_bid,
                'FEE_BN' => $fee_bn,
                'FEE_RP' => $fee_rp,
                'FEE_SUBTITLE' => $subtitle_fee,
                'FEE_RELIST' => $relist_fee,
                'FEE_DECIMALS' => $system->SETTINGS['moneydecimals'],

                'B_CAN_TAX' => $can_tax,
                'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1),
                'B_BN_ONLY' => ($system->SETTINGS['buy_now'] == 2 && $system->SETTINGS['bn_only'] && (($system->SETTINGS['bn_only_disable'] == 'y' && $user->user_data['bn_only']) || $system->SETTINGS['bn_only_disable'] == 'n')),
                'B_BN' => ($system->SETTINGS['buy_now'] == 2),
                'B_EDITING' => ($_SESSION['SELL_action'] == 'edit'),
                'B_CANEDITSTARTDATE' => $caneditstartdate,
                // options,
                'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1),
                'B_EDIT_STARTTIME' => ($system->SETTINGS['edit_starttime'] == 1),
                'B_EDIT_ENDTIME' => ($system->SETTINGS['edit_endtime'] == 1),
                'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y'),
                'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y'),
                'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y'),
                'B_FEES' => ($system->SETTINGS['fees'] == 'y' && !$user->permissions['no_fees']),
                'B_SHIPPING' => ($system->SETTINGS['shipping'] == 'y'),
                'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y'),
                'B_AUTORELIST' => ($system->SETTINGS['autorelist'] == 'y')
                ));
        break;
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'sell.tpl'
        ));
$template->display('body');
include 'footer.php';

//if ($_SESSION['action'] != 3)
    makesessions();
