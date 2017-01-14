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

if (!defined('InWeBid')) {
    exit();
}

function generate_id()
{
    global $_SESSION;
    if (!isset($_SESSION['SELL_auction_id'])) {
        $auction_id = md5(uniqid(rand()));
        $_SESSION['SELL_auction_id'] = $auction_id;
    } else {
        $auction_id = $_SESSION['SELL_auction_id'];
    }
    return $auction_id;
}

function setvars()
{
    global $with_reserve, $reserve_price, $minimum_bid, $pict_url, $imgtype, $title, $subtitle, $sdescription, $atype, $iquantity, $buy_now, $buy_now_price, $is_taxed, $tax_included, $additional_shipping_cost;
    global $duration, $relist, $increments, $customincrement, $shipping, $shipping_terms, $payment, $international, $sellcat1, $sellcat2, $buy_now_only, $a_starts, $shipping_cost, $is_bold, $is_highlighted, $is_featured, $start_now;
    global $_POST, $_SESSION, $system, $custom_end, $a_ends, $custom_end, $caneditstartdate, $dt;

    $with_reserve = (isset($_POST['with_reserve'])) ? $_POST['with_reserve'] : $_SESSION['SELL_with_reserve'];
    $reserve_price = (isset($_POST['reserve_price'])) ? $_POST['reserve_price'] : $_SESSION['SELL_reserve_price'];
    $minimum_bid = (isset($_POST['minimum_bid'])) ? $_POST['minimum_bid'] : $_SESSION['SELL_minimum_bid'];
    $default_minbid = ($system->SETTINGS['moneyformat'] == 1) ? 0.99 : '0,99';
    $minimum_bid = (empty($minimum_bid)) ? $default_minbid : $minimum_bid;
    $shipping_cost = (isset($_POST['shipping_cost'])) ? $_POST['shipping_cost'] : $_SESSION['SELL_shipping_cost'];
    $shipping_cost = (empty($shipping_cost)) ? 0 : $shipping_cost;
    $additional_shipping_cost = (isset($_POST['additional_shipping_cost'])) ? $_POST['additional_shipping_cost'] : $_SESSION['SELL_additional_shipping_cost'];
    $additional_shipping_cost = (empty($additional_shipping_cost)) ? 0 : $additional_shipping_cost;
    $imgtype = (isset($_POST['imgtype'])) ? $_POST['imgtype'] : $_SESSION['SELL_file_uploaded'];
    $title = (isset($_POST['title'])) ? $system->cleanvars($_POST['title']) : $_SESSION['SELL_title'];
    $subtitle = (isset($_POST['subtitle'])) ? $system->cleanvars($_POST['subtitle']) : $_SESSION['SELL_subtitle'];
    $sdescription = (isset($_POST['sdescription'])) ? $system->cleanvars($_POST['sdescription'], true) : $_SESSION['SELL_description'];
    $pict_url = (isset($_POST['pict_url'])) ? $_POST['pict_url'] : $_SESSION['SELL_pict_url'];
    $atype = (isset($_POST['atype'])) ? $_POST['atype'] : $_SESSION['SELL_atype'];
    $iquantity = (int)(isset($_POST['iquantity'])) ? $_POST['iquantity'] : $_SESSION['SELL_iquantity'];
    $iquantity = (empty($iquantity)) ? 1 : round($iquantity);
    $buy_now = (isset($_POST['buy_now'])) ? $_POST['buy_now'] : $_SESSION['SELL_with_buy_now'];
    $buy_now_price = (isset($_POST['buy_now_price'])) ? $_POST['buy_now_price'] : $_SESSION['SELL_buy_now_price'];
    $relist = (isset($_POST['autorelist'])) ? $_POST['autorelist'] : $_SESSION['SELL_relist'];
    $increments = (isset($_POST['increments'])) ? $_POST['increments'] : $_SESSION['SELL_increments'];
    $customincrement = (isset($_POST['customincrement'])) ? $_POST['customincrement'] : $_SESSION['SELL_customincrement'];
    $shipping = (isset($_POST['shipping'])) ? $_POST['shipping'] : $_SESSION['SELL_shipping'];
    $shipping_terms = (isset($_POST['shipping_terms'])) ? $system->cleanvars($_POST['shipping_terms']) : $_SESSION['SELL_shipping_terms'];
    $payment = (isset($_POST['payment'])) ? $_POST['payment'] : $_SESSION['SELL_payment'];
    $payment = (is_array($payment)) ? $payment : array();
    $sellcat1 = $_SESSION['SELL_sellcat1'];
    $_SESSION['SELL_sellcat2'] = (isset($_SESSION['SELL_sellcat2'])) ? $_SESSION['SELL_sellcat2'] : 0;
    $sellcat2 = $_SESSION['SELL_sellcat2'];
    $caneditstartdate = $_SESSION['SELL_caneditstartdate'];
    $buy_now_only = (isset($_POST['buy_now_only'])) ? $_POST['buy_now_only'] : $_SESSION['SELL_buy_now_only'];
    $buy_now_only = (empty($buy_now_only)) ? 0 : $buy_now_only;

    $a_starts = (isset($_POST['a_starts'])) ? $dt->convertToDatetime($_POST['a_starts']) : $_SESSION['SELL_starts'];
    $duration = (isset($_POST['duration'])) ? $_POST['duration'] : $_SESSION['SELL_duration'];
    $a_ends = (isset($_POST['a_ends'])) ? $dt->convertToDatetime($_POST['a_ends']) : $_SESSION['SELL_ends'];

    // deal with checkboxes
    if (isset($_POST['action']) && $_POST['action'] == 3) {
        $is_bold = (isset($_POST['is_bold'])) ? 1 : 0;
        $is_featured = (isset($_POST['is_featured'])) ? 1 : 0;
        $is_highlighted = (isset($_POST['is_highlighted'])) ? 1 : 0;
        $international = (isset($_POST['international'])) ? 1 : 0;
        $start_now = (isset($_POST['start_now'])) ? 1 : 0;
        $custom_end = (isset($_POST['custom_end'])) ? 1 : 0;
        // ignore duration for custom end date
        $duration = ($custom_end == 1) ? 0 : $duration;
    } else {
        $is_bold = $_SESSION['SELL_is_bold'];
        $is_featured = $_SESSION['SELL_is_featured'];
        $is_highlighted = $_SESSION['SELL_is_highlighted'];
        $international = $_SESSION['SELL_international'];
        $start_now = $_SESSION['SELL_start_now'];
        $custom_end = $_SESSION['SELL_custom_end'];
    }

    $is_taxed = (isset($_POST['is_taxed'])) ? $_POST['is_taxed'] : $_SESSION['SELL_is_taxed'];
    $tax_included = (isset($_POST['tax_included'])) ? $_POST['tax_included'] : $_SESSION['SELL_tax_included'];
    if (isset($_POST['action']) && $_POST['action'] == 2) {
        $is_bold = (isset($_POST['is_bold'])) ? 1 : 0;
        $is_featured = (isset($_POST['is_featured'])) ? 1 : 0;
        $is_highlighted = (isset($_POST['is_highlighted'])) ? 1 : 0;
        $is_taxed = (isset($_POST['is_taxed'])) ? 1 : 0;
        $tax_included = (isset($_POST['tax_included'])) ? 1 : 0;
        $payment = (isset($_POST['payment'])) ? $payment : array();
    }
}

function makesessions()
{
    global $with_reserve, $reserve_price, $minimum_bid, $pict_url, $imgtype, $title, $subtitle, $sdescription, $pict_url, $atype, $iquantity, $buy_now, $buy_now_price, $is_taxed, $tax_included, $additional_shipping_cost;
    global $duration, $relist, $increments, $customincrement, $shipping, $shipping_terms, $payment, $international, $sendemail, $buy_now_only, $a_starts, $shipping_cost, $is_bold, $is_highlighted, $is_featured, $start_now, $_SESSION;
    global $a_ends, $custom_end, $caneditstartdate;

    $_SESSION['SELL_with_reserve'] = $with_reserve;
    $_SESSION['SELL_reserve_price'] = $reserve_price;
    $_SESSION['SELL_minimum_bid'] = $minimum_bid;
    $_SESSION['SELL_shipping_cost'] = $shipping_cost;
    $_SESSION['SELL_additional_shipping_cost'] = $additional_shipping_cost;
    $_SESSION['SELL_file_uploaded'] = $imgtype;
    $_SESSION['SELL_title'] = $title;
    $_SESSION['SELL_subtitle'] = $subtitle;
    $_SESSION['SELL_description'] = $sdescription;
    $_SESSION['SELL_pict_url'] = $pict_url;
    $_SESSION['SELL_atype'] = $atype;
    $_SESSION['SELL_iquantity'] = $iquantity;
    $_SESSION['SELL_with_buy_now'] = $buy_now;
    $_SESSION['SELL_buy_now_price'] = $buy_now_price;
    $_SESSION['SELL_duration'] = $duration;
    $_SESSION['SELL_relist'] = $relist;
    $_SESSION['SELL_increments'] = $increments;
    $_SESSION['SELL_customincrement'] = $customincrement;
    $_SESSION['SELL_shipping'] = $shipping;
    $_SESSION['SELL_shipping_terms'] = $shipping_terms;
    $_SESSION['SELL_payment'] = $payment;
    $_SESSION['SELL_international'] = $international;
    $_SESSION['SELL_buy_now_only'] = $buy_now_only;
    $_SESSION['SELL_starts'] = $a_starts;
    $_SESSION['SELL_ends'] = $a_ends;
    $_SESSION['SELL_custom_end'] = $custom_end;
    $_SESSION['SELL_is_bold'] = $is_bold;
    $_SESSION['SELL_is_highlighted'] = $is_highlighted;
    $_SESSION['SELL_is_featured'] = $is_featured;
    $_SESSION['SELL_start_now'] = $start_now;
    $_SESSION['SELL_is_taxed'] = $is_taxed;
    $_SESSION['SELL_tax_included'] = $tax_included;
    $_SESSION['SELL_caneditstartdate'] = $caneditstartdate;
}

function unsetsessions()
{
    global $_SESSION, $system;

    $_SESSION['SELL_with_reserve'] = '';
    $_SESSION['SELL_reserve_price'] = '';
    $_SESSION['SELL_minimum_bid'] = ($system->SETTINGS['moneyformat'] == 1) ? 0.99 : '0,99';
    $_SESSION['SELL_shipping_cost'] = 0;
    $_SESSION['SELL_additional_shipping_cost'] = 0;
    $_SESSION['SELL_file_uploaded'] = false;
    $_SESSION['SELL_title'] = '';
    $_SESSION['SELL_subtitle'] = '';
    $_SESSION['SELL_description'] = '';
    $_SESSION['SELL_pict_url'] = '';
    $_SESSION['SELL_pict_url_temp'] = '';
    $_SESSION['SELL_atype'] = '';
    $_SESSION['SELL_iquantity'] = '';
    $_SESSION['SELL_with_buy_now'] = '';
    $_SESSION['SELL_buy_now_price'] = '';
    $_SESSION['SELL_duration'] = '';
    $_SESSION['SELL_relist'] = '';
    $_SESSION['SELL_increments'] = '';
    $_SESSION['SELL_customincrement'] = 0;
    $_SESSION['SELL_shipping'] = 1;
    $_SESSION['SELL_shipping_terms'] = '';
    $_SESSION['SELL_payment'] = array();
    $_SESSION['SELL_international'] = false;
    $_SESSION['SELL_sendemail'] = '';
    $_SESSION['SELL_starts'] = '';
    $_SESSION['SELL_ends'] = '';
    $_SESSION['SELL_custom_end'] = 0;
    $_SESSION['SELL_action'] = '';
    $_SESSION['SELL_is_bold'] = 0;
    $_SESSION['SELL_is_highlighted'] = 0;
    $_SESSION['SELL_is_featured'] = 0;
    $_SESSION['SELL_start_now'] = '';
    $_SESSION['SELL_is_taxed'] = 0;
    $_SESSION['SELL_tax_included'] = 0;
    $_SESSION['SELL_caneditstartdate'] = true;
}

function updateauction()
{
    global $_SESSION, $DBPrefix, $dt, $a_starts, $a_ends, $payment_text, $system, $fee, $db, $caneditstartdate;

    $query =
        "UPDATE " . $DBPrefix . "auctions SET
		title = :title,
		subtitle = :subtitle,
		description = :description,
		pict_url = :pict_url,
		category = :catone,
		secondcat = :cattwo,
		minimum_bid = :min_bid,
		shipping_cost = :shipping_cost,
		additional_shipping_cost = :additional_shipping_cost,
		reserve_price = :reserve_price,
		buy_now = :buy_now,
		bn_only = :bn_only,
		auction_type = :auction_type,
		duration = :duration,
		increment = :increment,
		shipping = :shipping,
		payment = :payment,
		international = :international,
		ends = :ends,
		photo_uploaded = :photo_uploaded,
		initial_quantity = :initial_quantity,
		quantity = :quantity,
		relist = :relist,
		shipping_terms = :shipping_terms,
		closed = 0,
		bold = :bold,
		highlighted = :highlighted,
		featured = :featured,
		tax = :tax,
		taxinc = :taxinc,
		current_fee = current_fee + :fee";
    $params = array();
    $params[] = array(':title', $_SESSION['SELL_title'], 'str');
    $params[] = array(':subtitle', $_SESSION['SELL_subtitle'], 'str');
    $params[] = array(':description', $_SESSION['SELL_description'], 'str');
    $params[] = array(':pict_url', $_SESSION['SELL_pict_url'], 'str');
    $params[] = array(':catone', $_SESSION['SELL_sellcat1'], 'int');
    $params[] = array(':cattwo', $_SESSION['SELL_sellcat2'], 'int');
    $params[] = array(':min_bid', $system->input_money(($_SESSION['SELL_buy_now_only'] == 0) ? $_SESSION['SELL_minimum_bid'] : $_SESSION['SELL_buy_now_price']), 'float');
    $params[] = array(':shipping_cost', $system->input_money($_SESSION['SELL_shipping_cost']), 'float');
    $params[] = array(':additional_shipping_cost', $system->input_money($_SESSION['SELL_additional_shipping_cost']), 'float');
    $params[] = array(':reserve_price', $system->input_money(($_SESSION['SELL_with_reserve'] == 'yes') ? $_SESSION['SELL_reserve_price'] : 0), 'float');
    $params[] = array(':buy_now', $system->input_money(($_SESSION['SELL_with_buy_now'] == 'yes') ? $_SESSION['SELL_buy_now_price'] : 0), 'float');
    $params[] = array(':bn_only', $_SESSION['SELL_buy_now_only'], 'bool');
    $params[] = array(':auction_type', $_SESSION['SELL_atype'], 'int');
    $params[] = array(':duration', $_SESSION['SELL_duration'], 'int');
    $params[] = array(':increment', $system->input_money($_SESSION['SELL_customincrement']), 'float');
    $params[] = array(':shipping', $_SESSION['SELL_shipping'], 'int');
    $params[] = array(':payment', $payment_text, 'str');
    $params[] = array(':international', $_SESSION['SELL_international'], 'bool');
    $params[] = array(':ends', $dt->convertToUTC($a_ends), 'str');
    $params[] = array(':photo_uploaded', $_SESSION['SELL_file_uploaded'], 'bool');
    $params[] = array(':initial_quantity', $_SESSION['SELL_iquantity'], 'int');
    $params[] = array(':quantity', $_SESSION['SELL_iquantity'], 'int');
    $params[] = array(':relist', $_SESSION['SELL_relist'], 'int');
    $params[] = array(':shipping_terms', $_SESSION['SELL_shipping_terms'], 'str');
    $params[] = array(':bold', $_SESSION['SELL_is_bold'], 'bool');
    $params[] = array(':highlighted', $_SESSION['SELL_is_highlighted'], 'bool');
    $params[] = array(':featured', $_SESSION['SELL_is_featured'], 'bool');
    $params[] = array(':tax', $_SESSION['SELL_is_taxed'], 'bool');
    $params[] = array(':taxinc', $_SESSION['SELL_tax_included'], 'bool');
    $params[] = array(':fee', $fee, 'float');
    $params[] = array(':auction_id', $_SESSION['SELL_auction_id'], 'int');
    if ($caneditstartdate) {
        $query .= ", starts = :starts";
        $params[] = array(':starts', $dt->convertToUTC($a_starts), 'str');
    }
    $query .= ' WHERE id = :auction_id';
    $db->query($query, $params);
}

function addauction()
{
    global $DBPrefix, $_SESSION, $user, $a_starts, $a_ends, $payment_text, $system, $fee, $db, $dt;

    $query = "INSERT INTO " . $DBPrefix . "auctions (user,title,subtitle,starts,description,pict_url,category,secondcat,minimum_bid,shipping_cost,additional_shipping_cost,reserve_price,buy_now,auction_type,duration,increment,shipping,payment,international,ends,photo_uploaded,initial_quantity,quantity,relist,shipping_terms,bn_only,bold,highlighted,featured,current_fee,tax,taxinc) VALUES
	(:user_id, :title, :subtitle, :starts, :description, :pict_url, :catone, :cattwo, :min_bid, :shipping_cost, :additional_shipping_cost, :reserve_price, :buy_now, :auction_type, :duration, :increment, :shipping, :payment, :international, :ends, :photo_uploaded, :initial_quantity, :quantity, :relist, :shipping_terms, :bn_only, :bold, :highlighted, :featured, :fee, :tax, :taxinc)";

    $params = array();
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $params[] = array(':title', $_SESSION['SELL_title'], 'str');
    $params[] = array(':subtitle', $_SESSION['SELL_subtitle'], 'str');
    $params[] = array(':starts', $dt->convertToUTC($a_starts), 'str');
    $params[] = array(':description', $_SESSION['SELL_description'], 'str');
    $params[] = array(':pict_url', $_SESSION['SELL_pict_url'], 'str');
    $params[] = array(':catone', $_SESSION['SELL_sellcat1'], 'int');
    $params[] = array(':cattwo', $_SESSION['SELL_sellcat2'], 'int');
    $params[] = array(':min_bid', $system->input_money(($_SESSION['SELL_buy_now_only'] == 0) ? $_SESSION['SELL_minimum_bid'] : $_SESSION['SELL_buy_now_price']), 'float');
    $params[] = array(':shipping_cost', $system->input_money($_SESSION['SELL_shipping_cost']), 'float');
    $params[] = array(':additional_shipping_cost', $system->input_money($_SESSION['SELL_additional_shipping_cost']), 'float');
    $params[] = array(':reserve_price', $system->input_money(($_SESSION['SELL_with_reserve'] == 'yes') ? $_SESSION['SELL_reserve_price'] : 0), 'float');
    $params[] = array(':buy_now', $system->input_money(($_SESSION['SELL_with_buy_now'] == 'yes') ? $_SESSION['SELL_buy_now_price'] : 0), 'float');
    $params[] = array(':auction_type', $_SESSION['SELL_atype'], 'int');
    $params[] = array(':duration', $_SESSION['SELL_duration'], 'int');
    $params[] = array(':increment', $system->input_money($_SESSION['SELL_customincrement']), 'float');
    $params[] = array(':shipping', $_SESSION['SELL_shipping'], 'int');
    $params[] = array(':payment', $payment_text, 'str');
    $params[] = array(':international', $_SESSION['SELL_international'], 'bool');
    $params[] = array(':ends', $dt->convertToUTC($a_ends), 'str');
    $params[] = array(':photo_uploaded', $_SESSION['SELL_file_uploaded'], 'bool');
    $params[] = array(':initial_quantity', $_SESSION['SELL_iquantity'], 'int');
    $params[] = array(':quantity', $_SESSION['SELL_iquantity'], 'int');
    $params[] = array(':relist', $_SESSION['SELL_relist'], 'int');
    $params[] = array(':shipping_terms', $_SESSION['SELL_shipping_terms'], 'str');
    $params[] = array(':bn_only', $_SESSION['SELL_buy_now_only'], 'bool');
    $params[] = array(':bold', $_SESSION['SELL_is_bold'], 'bool');
    $params[] = array(':highlighted', $_SESSION['SELL_is_highlighted'], 'bool');
    $params[] = array(':featured', $_SESSION['SELL_is_featured'], 'bool');
    $params[] = array(':fee', $fee, 'float');
    $params[] = array(':tax', $_SESSION['SELL_is_taxed'], 'bool');
    $params[] = array(':taxinc', $_SESSION['SELL_tax_included'], 'bool');
    $db->query($query, $params);
}

function addoutstanding()
{
    global $DBPrefix, $fee_data, $user, $system, $fee, $_SESSION, $db;

    $fee_data['total'] = $fee;

    if ($_SESSION['SELL_action'] == 'edit') {
        // set defaults
        $fee_colomns = array(
            'setup',
            'featured',
            'bold',
            'highlighted',
            'subtitle',
            'relist',
            'reserve',
            'buynow',
            'picture',
            'extracat',
            'total'
        );

        $query = "SELECT * FROM " . $DBPrefix . "useraccounts WHERE auc_id = :auction_id AND user_id = :user_id";
        $params = array();
        $params[] = array(':auction_id', $_SESSION['SELL_auction_id'], 'int');
        $params[] = array(':user_id', $user->user_data['id'], 'int');
        $db->query($query, $params);
        // build an array full of everything the user has been charged for the auction do far
        while ($past_fee_data = $db->fetch()) {
            foreach ($fee_colomns as $fee) {
                $fee_string = ($fee == 'total') ? '' : '_fee';
                $fee_data[$fee .  $fee_string] = bcsub($fee_data[$fee .  $fee_string],
                    $past_fee_data[$fee], $system->SETTINGS['moneydecimals']);
                if ($fee_data[$fee .  $fee_string] < 0) {
                    $fee_data[$fee .  $fee_string] = 0;
                }
            }
        }

    }

    $query = "INSERT INTO " . $DBPrefix . "useraccounts (auc_id,user_id,setup,featured,bold,highlighted,subtitle,relist,reserve,buynow,picture,extracat,total,paid) VALUES
	(:auction_id, :user_id, :setup_fee, :featured_fee, :bold_fee, :highlighted_fee, :subtitle_fee, :relist_fee, :reserve_fee, :buynow_fee, :picture_fee, :extracat_fee, :fee, 0)";

    $params[] = array(':auction_id', $_SESSION['SELL_auction_id'], 'int');
    $params[] = array(':setup_fee', $fee_data['setup_fee'], 'float');
    $params[] = array(':featured_fee', $fee_data['featured_fee'], 'float');
    $params[] = array(':bold_fee', $fee_data['bold_fee'], 'float');
    $params[] = array(':highlighted_fee', $fee_data['highlighted_fee'], 'float');
    $params[] = array(':subtitle_fee', $fee_data['subtitle_fee'], 'float');
    $params[] = array(':relist_fee', $fee_data['relist_fee'], 'float');
    $params[] = array(':reserve_fee', $fee_data['reserve_fee'], 'float');
    $params[] = array(':buynow_fee', $fee_data['buynow_fee'], 'float');
    $params[] = array(':picture_fee', $fee_data['picture_fee'], 'float');
    $params[] = array(':extracat_fee', $fee_data['extracat_fee'], 'float');
    $params[] = array(':fee', $fee_data['total'], 'float');
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);

    // reset fee value
    $fee = $fee_data['total'];
}

function remove_bids($auction_id)
{
    global $DBPrefix, $db;
    $query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auction_id";
    $params = array();
    $params[] = array(':auction_id', $auction_id, 'int');
    $db->query($query, $params);
}

function get_fee($minimum_bid, $just_fee = true)
{
    global $system, $DBPrefix, $buy_now_price, $reserve_price, $is_bold, $is_highlighted, $is_featured, $_SESSION, $subtitle, $sellcat2, $relist, $db;

    $query = "SELECT * FROM " . $DBPrefix . "fees ORDER BY type, fee_from ASC";
    $db->direct_query($query);

    $fee_value = 0;
    // set defaults
    $fee_data = array(
        'setup_fee' => 0,
        'featured_fee' => 0,
        'bold_fee' => 0,
        'highlighted_fee' => 0,
        'subtitle_fee' => 0,
        'relist_fee' => 0,
        'reserve_fee' => 0,
        'buynow_fee' => 0,
        'picture_fee' => 0,
        'extracat_fee' => 0
    );
    while ($row = $db->fetch()) {
        if ($minimum_bid >= $row['fee_from'] && $minimum_bid <= $row['fee_to'] && $row['type'] == 'setup') {
            if ($row['fee_type'] == 'flat') {
                $fee_data['setup_fee'] = $row['value'];
                $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
            } else {
                $tmp = bcdiv($row['value'], '100', $system->SETTINGS['moneydecimals']);
                $tmp = bcmul($tmp, $minimum_bid, $system->SETTINGS['moneydecimals']);
                $fee_data['setup_fee'] = $tmp;
                $fee_value = bcadd($fee_value, $tmp, $system->SETTINGS['moneydecimals']);
            }
        }
        if ($row['type'] == 'buynow_fee' && $buy_now_price > 0) {
            $fee_data['buynow_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'reserve_fee' && $reserve_price > 0) {
            $fee_data['reserve_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'bold_fee' && $is_bold) {
            $fee_data['bold_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'highlighted_fee' && $is_highlighted) {
            $fee_data['highlighted_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'featured_fee' && $is_featured) {
            $fee_data['featured_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'picture_fee' && count($_SESSION['UPLOADED_PICTURES']) > 0) {
            $tmp = bcmul(count($_SESSION['UPLOADED_PICTURES']), $row['value'], $system->SETTINGS['moneydecimals']);
            $fee_data['picture_fee'] = $tmp;
            $fee_value = bcadd($fee_value, $tmp, $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'subtitle_fee' && !empty($subtitle)) {
            $fee_data['subtitle_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'extracat_fee' && $sellcat2 > 0) {
            $fee_data['extracat_fee'] = $row['value'];
            $fee_value = bcadd($fee_value, $row['value'], $system->SETTINGS['moneydecimals']);
        }
        if ($row['type'] == 'relist_fee' && $relist > 0) {
            $fee_data['relist_fee'] = ($row['value'] * $relist);
            $fee_value = bcadd($fee_value, ($row['value'] * $relist), $system->SETTINGS['moneydecimals']);
        }
    }

    if ($just_fee) {
        $return = $fee_value;
    } else {
        $return = array($fee_value, $fee_data);
    }

    return $return;
}

function update_cat_counters($add, $category, $second_category = 0)
{
    global $_SESSION, $DBPrefix, $system, $catscontrol, $db;

    $addsub = ($add) ? '+' : '-';
    // change category counter
    $query = "UPDATE " . $DBPrefix . "categories SET counter = counter " . $addsub . " 1 WHERE cat_id = :cat_id";
    $params = array();
    $params[] = array(':cat_id', $category, 'int');
    $db->query($query, $params);
    // get the category crumbs
    $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
    $params = array();
    $params[] = array(':cat_id', $category, 'int');
    $db->query($query, $params);
    $parent_node = $db->result();
    $category_crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

    if ($second_category > 0) {
        // change secondary category counter
        $query = "UPDATE " . $DBPrefix . "categories SET counter = counter " . $addsub . " 1 WHERE cat_id = :cat_id";
        $params = array();
        $params[] = array(':cat_id', $second_category, 'int');
        $db->query($query, $params);
        // get the second category crumbs
        $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
        $params = array();
        $params[] = array(':cat_id', $second_category, 'int');
        $db->query($query, $params);
        $parent_node = $db->result();
        $second_category_crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

        // merge the arrays
        $crumbs = $category_crumbs + $second_category_crumbs;
    } else {
        $crumbs = $category_crumbs;
    }

    for ($i = 0; $i < count($crumbs); $i++) {
        $query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter " . $addsub . " 1 WHERE cat_id = :cat_id";
        $params = array();
        $params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
        $db->query($query, $params);
    }
}

function get_category_string($sellcat)
{
    global $DBPrefix, $system, $catscontrol, $category_names, $db;

    if (empty($sellcat) || !isset($sellcat)) {
        return '';
    }

    $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
    $params = array();
    $params[] = array(':cat_id', $sellcat, 'int');
    $db->query($query, $params);
    $parent_node = $db->result();

    $TPL_categories_list = '';
    $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
    for ($i = 0; $i < count($crumbs); $i++) {
        if ($crumbs[$i]['cat_id'] > 0) {
            if ($i > 0) {
                $TPL_categories_list .= ' &gt; ';
            }
            $TPL_categories_list .= $category_names[$crumbs[$i]['cat_id']];
        }
    }
    return $TPL_categories_list;
}

// TODO: this should be used when a user lists an item and selects gateways
function check_gateway($gateway)
{
    global $user, $db;
    $query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "usergateways
			WHERE user_id = :user_id
			AND gateway_id = (SELECT id FROM " . $DBPrefix . "payment_options WHERE is_gateway = 1 && name = :gateway_name)";
    $params = array();
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $params[] = array(':gateway_name', $gateway, 'str');
    $db->query($query, $params);
    if ($db->result('COUNT') > 0) {
        return true;
    }
    return false;
}

function alert_auction_watchers($id, $title, $description)
{
    global $user, $DBPrefix, $db;

    // Send notification if users keyword matches (Auction Watch)
    $query = "SELECT auc_watch, email, nick, name, id FROM " . $DBPrefix . "users WHERE auc_watch != '' AND id != :user_id";
    $params = array();
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);
    $sent_to = array();
    while ($row = $db->fetch()) {
        $w_title = explode(' ', strtolower($title));
        $w_descr = explode(' ', strtolower(str_replace(array('<br>', "\n"), '', strip_tags($description))));
        $w_nick = strtolower($user->user_data['nick']);
        $key = explode(' ', $row['auc_watch']);
        if (is_array($key) && count($key) > 0) {
            foreach ($key as $k => $v) {
                $v = trim(strtolower($v));
                if ((in_array($v, $w_title) || in_array($v, $w_descr) || $v == $w_nick) && !in_array($row['id'], $sent_to)) {
                    $emailer = new email_handler();
                    $emailer->assign_vars(array(
                            'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $id,
                            'SITENAME' =>  $system->SETTINGS['sitename'],
                            'TITLE' => $title,
                            'REALNAME' => $row['name'],
                            'KWORD' => $row['auc_watch']
                            ));
                    $emailer->email_uid = $row['id'];
                    $emailer->email_sender($row['email'], 'auction_watchmail.inc.php', $system->SETTINGS['sitename'] . '  ' . $MSG['471']);
                    $sent_to[] = $row['id'];
                }
            }
        }
    }
}
