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
    exit('Access denied');
}

function getSeller($user_id)
{
    global $DBPrefix, $db;

    $query = "SELECT nick, country FROM " . $DBPrefix . "users WHERE id = :user_id";
    $params = array();
    $params[] = array(':user_id', $user_id, 'int');
    $db->query($query, $params);
    $result = $db->result();
    $address_data = array(
        'nick'      => $result['nick'],
        'country'   => $result['country'],
    );
    return $address_data;
}

function getAddressWinner($user_id)
{
    global $DBPrefix, $db;

    $query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
    $params = array();
    $params[] = array(':user_id', $user_id, 'int');
    $db->query($query, $params);
    $result = $db->result();
    $address_data = array(
        //'user_id'   => $result['id'],
        'nick'      => $result['nick'],
        'name'      => $result['name'],
        'company'   => (isset($result['company'])) ? $result['company'] : '',
        'address'   => $result['address'],
        'city'      => $result['city'],
        'prov'      => $result['prov'],
        'zip'        => $result['zip'],
        'country'   => $result['country'],
        //'email'     => $result['email'],
    );
    return $address_data;
}

function getTax($is_auction, $buyer_from, $seller_from = '')
{
    global $DBPrefix, $db;

    // build the query
    $query = "SELECT tax_rate FROM " . $DBPrefix . "tax WHERE countries_buyer LIKE '" . $buyer_from . "'";
    $query .= ($is_auction) ? " AND fee_tax = 0" : " AND fee_tax = 1";
    $query .= (!empty($seller_from)) ? " AND countries_seller LIKE '" . $seller_from . "'" : '';
    $db->direct_query($query);

    if ($db->numrows() == 0) {
        $tax_rate = 0;
    } else {
        $tax_rate = $db->result('tax_rate');
    }

    return $tax_rate;
}

function setfeetemplate($data)
{
    global $template, $system, $MSG;

    $feenames = array(
        'signup' => $MSG['430'],
        'buyer' => $MSG['775'],
        'setup' => $MSG['432'],
        'featured' => $MSG['433'],
        'bold' => $MSG['439'],
        'highlighted' => $MSG['434'],
        'subtitle' => $MSG['803'],
        'extracat' => $MSG['804'],
        'reserve' => $MSG['440'],
        'picture' => $MSG['435'],
        'relist' => $MSG['437'],
        'buynow' => $MSG['436'],
        'finalval' => $MSG['791'],
        'balance' => $MSG['935']
        );
    $total = 0;
    $total_exculding = 0;
    foreach ($data as $k => $v) {
        if (isset($feenames[$k])) {
            if ($v > 0) {
                $excluding = vatexcluding($v);
                $total += $v;
                $total_exculding += $excluding;
                $template->assign_block_vars('fees', array(
                        'FEE' => $feenames[$k],
                        'UNIT_PRICE' => $system->print_money($excluding),
                        'UNIT_PRICE_WITH_TAX' => $system->print_money($v),
                        'TOTAL' => $system->print_money($total_exculding),
                        'TOTAL_WITH_TAX' => $system->print_money($total)
                        ));
            }
        }
    }
    return array($total, $total_exculding);
}

// add vat
function vat($price)
{
    global $system, $vat;
    $price_with_vat = $price + ($vat * ($price / 100));
    $price_with_vat = round($price_with_vat, $system->SETTINGS['moneydecimals']);
    return $price_with_vat;
}

// remove vat
function vatexcluding($gross)
{
    global $system, $vat;
    $multiplier = ($vat + 100) / 100;
    $net = $gross / $multiplier;
    return number_format($net, $system->SETTINGS['moneydecimals']);
}

function invalidinvoice($packingslip = false)
{
    global $template, $system;

    $template->assign_vars(array(
            'LOGO' => $system->SETTINGS['siteurl'] . 'uploaded/logo/' . $system->SETTINGS['logo'],
            'LANGUAGE' => $language,
            'SALE_ID' => 0,
            'B_INVOICE' => false
            ));

    $file = ($packingslip) ? 'order_packingslip.tpl' : 'order_invoice.tpl';

    $template->set_filenames(array(
            'body' => $file
            ));
    $template->display('body');
    exit;
}
