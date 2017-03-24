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

// Get parameters from the URL
$id = (isset($_SESSION['CURRENT_ITEM'])) ? intval($_SESSION['CURRENT_ITEM']) : 0;
$id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

$bidderarray = array();
$bidderarraynum = 1;
$catscontrol = new MPTTcategories();

$_SESSION['CURRENT_ITEM'] = $id;
$_SESSION['REDIRECT_AFTER_LOGIN'] = $system->SETTINGS['siteurl'] . 'item.php?id=' . $id;

// get auction all needed data
$query = "SELECT a.*, ac.counter, u.nick, u.reg_date, u.city, u.country, u.zip FROM " . $DBPrefix . "auctions a
	        LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
	        LEFT JOIN " . $DBPrefix . "auccounter ac ON (ac.auction_id = a.id)
	        WHERE a.id = :auction_id LIMIT 1";
$params = array();
$params[] = array(':auction_id', $id, 'int');
$db->query($query, $params);
if ($db->numrows() == 0) {
    $_SESSION['msg_title'] = $ERR_622;
    $_SESSION['msg_body'] = $ERR_623;
    header('location: message.php');
    exit;
}
$auction_data = $db->result();
$category = $auction_data['category'];
$auction_type = $auction_data['auction_type'];
$ends = $auction_data['ends'];
$start = $auction_data['starts'];
$user_id = $auction_data['user'];
$minimum_bid = $auction_data['minimum_bid'];
$high_bid = $auction_data['current_bid'];
$customincrement = $auction_data['increment'];
$seller_reg = $dt->formatDate($auction_data['reg_date']);

// sort out counter
if (empty($auction_data['counter'])) {
    $query = "INSERT INTO `" . $DBPrefix . "auccounter` (`auction_id`, `counter`) VALUES (:counter, 1)";
    $params = array();
    $params[] = array(':counter', $id, 'int');
    $db->query($query, $params);
    $auction_data['counter'] = 1;
} else {
    if (!isset($_SESSION['WEBID_VIEWED_AUCTIONS'])) {
        $_SESSION['WEBID_VIEWED_AUCTIONS'] = array();
    }
    if (!in_array($id, $_SESSION['WEBID_VIEWED_AUCTIONS'])) {
        $query = "UPDATE " . $DBPrefix . "auccounter set counter = counter + 1 WHERE auction_id = :auction_id";
        $params = array();
        $params[] = array(':auction_id', $id, 'int');
        $db->query($query, $params);
        $_SESSION['WEBID_VIEWED_AUCTIONS'][] = $id;
    }
}

// get watch item data
if ($user->logged_in) {
    // Check if this item is not already added
    $query = "SELECT item_watch FROM " . $DBPrefix . "users WHERE id = :user_id";
    $params = array();
    $params[] = array(':user_id', $user->user_data['id'], 'int');
    $db->query($query, $params);
    $watcheditems = trim($db->result('item_watch'));
    $auc_ids = explode(' ', $watcheditems);

    if (in_array($id, $auc_ids)) {
        $watch_var = 'delete';
        $watch_string = $MSG['5202_0'];
    } else {
        $watch_var = 'add';
        $watch_string = $MSG['5202'];
    }
} else {
    $watch_var = '';
    $watch_string = '';
}

// get ending time
$showendtime = false;
$has_ended = false;
$difference = null;
if (strtotime($start) > time()) {
    $ending_time = '<span class="errfont">' . $MSG['668'] . '</span>';
} elseif (strtotime($ends) - time() > 0) {
    $current_time = new DateTime('now', $dt->UTCtimezone);
    $end_time = new DateTime($ends, $dt->UTCtimezone);
    $difference = $current_time->diff($end_time);
    $ending_time = '';
    $date_elements = 0;
    if ($difference->d > 0) {
        $daymsg = ($difference->d == 1) ? $MSG['126b'] : $MSG['126'];
        $ending_time .= $difference->d . ' ' . $daymsg . ' ';
        $date_elements++;
    }
    if ($difference->h > 0) {
        $ending_time .= $difference->h . $MSG['25_0037'] . ' ';
        $date_elements++;
    }
    if ($difference->m > 0 && $date_elements < 2) {
        $ending_time .= $difference->m . $MSG['25_0032'] . ' ';
        $date_elements++;
    }
    if ($difference->s > 0 && $date_elements < 2) {
        $ending_time .= $difference->s . $MSG['25_0033'];
    }
    $showendtime = true;
} else {
    $ending_time = '<span class="errfont">' . $MSG['911'] . '</span>';
    $has_ended = true;
}

// build bread crumbs
$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
$params = array();
$params[] = array(':cat_id', $auction_data['category'], 'int');
$db->query($query, $params);
$parent_node = $db->result();

$cat_value = '';
$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
for ($i = 0; $i < count($crumbs); $i++) {
    if ($crumbs[$i]['cat_id'] > 0) {
        if ($i > 0) {
            $cat_value .= ' > ';
        }
        $cat_value .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';
    }
}

$secondcat_value = '';
if ($system->SETTINGS['extra_cat'] == 'y' && intval($auction_data['secondcat']) > 0) {
    $query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :sec_cat_id";
    $params = array();
    $params[] = array(':sec_cat_id', $auction_data['secondcat'], 'int');
    $db->query($query, $params);
    $parent_node = $db->result();

    $crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
    for ($i = 0; $i < count($crumbs); $i++) {
        if ($crumbs[$i]['cat_id'] > 0) {
            if ($i > 0) {
                $secondcat_value .= ' > ';
            }
            $secondcat_value .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';
        }
    }
}

// history
$query = "SELECT b.*, u.nick, u.rate_sum FROM " . $DBPrefix . "bids b
	        LEFT JOIN " . $DBPrefix . "users u ON (u.id = b.bidder)
	        WHERE b.auction = :auc_id";
if ($auction_data['bn_only'] || $auction_type == 2) {
    $query .= " ORDER BY b.bidwhen DESC";
} else {
    $query .= " ORDER BY b.bid DESC, b.quantity DESC, b.id DESC";
}
$params = array();
$params[] = array(':auc_id', $id, 'int');
$db->query($query, $params);
$num_bids = $db->numrows();
$i = 0;
$left = $auction_data['quantity'];
$hbidder_data = array();
foreach ($db->fetchall() as $bidrec) {
    if (!isset($bidderarray[$bidrec['nick']])) {
        if ($system->SETTINGS['buyerprivacy'] == 'y' && (!$user->logged_in || ($user->user_data['id'] != $auction_data['user'] && $user->user_data['id'] != $bidrec['bidder']))) {
            $bidderarray[$bidrec['nick']] = $MSG['176'] . ' ' . $bidderarraynum;
            $bidderarraynum++;
        } else {
            $bidderarray[$bidrec['nick']] = $bidrec['nick'];
        }
    }
    if ($left > 0 && !in_array($bidrec['bidder'], $hbidder_data)) { //store highest bidder details
        $hbidder_data[] = $bidrec['bidder'];
        $fb_pos = $fb_neg = 0;
        // get seller feebacks
        $query = "SELECT rate FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :rate_users_id";
        $params = array();
        $params[] = array(':rate_users_id', $bidrec['bidder'], 'int');
        $db->query($query, $params);
        // count numbers
        $fb_pos = $fb_neg = 0;
        while ($fb_arr = $db->fetch()) {
            if ($fb_arr['rate'] == 1) {
                $fb_pos++;
            } elseif ($fb_arr['rate'] == - 1) {
                $fb_neg++;
            }
        }

        $total_rate = $fb_pos - $fb_neg;
        $query = "SELECT icon FROM " . $DBPrefix . "membertypes WHERE feedbacks <= :feedback ORDER BY feedbacks DESC LIMIT 1;";
        $params = array();
        $params[] = array(':feedback', $bidrec['rate_sum'], 'int');
        $db->query($query, $params);
        $feedback_icon = $db->result('icon');
        $template->assign_block_vars('high_bidders', array(
                'BUYER_ID' => $bidrec['bidder'],
                'BUYER_NAME' => $bidderarray[$bidrec['nick']],
                'BUYER_FB' => $bidrec['rate_sum'],
                'BUYER_FB_ICON' => $feedback_icon
                ));
    }
    $template->assign_block_vars('bidhistory', array(
            'BGCOLOUR' => (!($i % 2)) ? '' : 'class="alt-row"',
            'ID' => $bidrec['bidder'],
            'NAME' => $bidderarray[$bidrec['nick']],
            'BID' => $system->print_money($bidrec['bid']),
            'WHEN' => $dt->formatDate($bidrec['bidwhen'], 'd F Y - H:i:s'),
            'QTY' => $bidrec['quantity']
            ));
    $left -= $bidrec['quantity'];
    $i++;
}

$userbid = false;
if ($user->logged_in && $num_bids > 0) {
    // check if youve bid on this before
    $query = "SELECT bid FROM " . $DBPrefix . "bids WHERE auction = :auction AND bidder = :bidder LIMIT 1";
    $params = array();
    $params[] = array(':auction', $id, 'int');
    $params[] = array(':bidder', $user->user_data['id'], 'int');
    $db->query($query, $params);
    if ($db->numrows() > 0) {
        if (in_array($user->user_data['id'], $hbidder_data)) {
            $yourbidmsg = $MSG['25_0088'];
            $yourbidclass = 'yourbidwin';
            if ($difference->invert && $auction_data['reserve_price'] > 0 && $auction_data['current_bid'] < $auction_data['reserve_price']) {
                $yourbidmsg = $MSG['514'];
                $yourbidclass = 'yourbidloss';
            } elseif ($difference->invert || $auction_data['bn_only']) {
                $yourbidmsg = $MSG['25_0089'];
            }
        } elseif ($auction_data['bn_only']) {
            $yourbidmsg = $MSG['25_0089'];
            $yourbidclass = 'yourbidwin';
        } else {
            $yourbidmsg = $MSG['25_0087'];
            $yourbidclass = 'yourbidloss';
        }
        $userbid = true;
    }
}

// sort out user questions
$query = "SELECT id FROM " . $DBPrefix . "messages WHERE reply_of = 0 AND public = 1 AND question = :question_id";
$params = array();
$params[] = array(':question_id', $id, 'int');
$db->query($query, $params);
$num_questions = $db->numrows();
foreach ($db->fetchall() as $row) {
    $template->assign_block_vars('questions', array()); // just need to create the block
    $query = "SELECT sentfrom, message FROM " . $DBPrefix . "messages WHERE question = :id AND reply_of = :reply_of OR id = :message_id ORDER BY sentat ASC";
    $params = array();
    $params[] = array(':id', $id, 'int');
    $params[] = array(':reply_of', $row['id'], 'int');
    $params[] = array(':message_id', $row['id'], 'int');
    $db->query($query, $params);
    while ($row_ = $db->fetch()) {
        $template->assign_block_vars('questions.conv', array(
                'MESSAGE' => $row_['message'],
                'BY_WHO' => ($user_id == $row_['sentfrom']) ? $MSG['125'] : $MSG['555']
                ));
    }
}

$high_bid = ($num_bids == 0) ? $minimum_bid : $high_bid;

if ($customincrement == 0) {
    // Get bid increment for current bid and calculate minimum bid
    $query = "SELECT increment FROM " . $DBPrefix . "increments WHERE
              ((low <= :val0 AND high >= :val1) OR
              (low < :val2 AND high < :val3)) ORDER BY increment DESC";
    $params = array();
    $params[] = array(':val0', $high_bid, 'float');
    $params[] = array(':val1', $high_bid, 'float');
    $params[] = array(':val2', $high_bid, 'float');
    $params[] = array(':val3', $high_bid, 'float');
    $db->query($query, $params);
    if ($db->numrows() != 0) {
        $increment = $db->result('increment');
    }
} else {
    $increment = $customincrement;
}

if ($auction_type == 2) {
    $increment = 0;
}

if ($customincrement > 0) {
    $increment = $customincrement;
}

if ($num_bids == 0 || $auction_type == 2) {
    $next_bidp = $minimum_bid;
} else {
    $next_bidp = $high_bid + $increment;
}

$view_history = '';
if ($num_bids > 0 && !isset($_GET['history'])) {
    $view_history = '(<a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $id . '&history=view#history">' . $MSG['105'] . '</a>)';
} elseif (isset($_GET['history'])) {
    $view_history = '(<a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $id . '">' . $MSG['507'] . '</a>)';
}
$min_bid = $system->print_money($minimum_bid);
$high_bid = $system->print_money($high_bid);
if ($difference != null && !$difference->invert) {
    $next_bid = $system->print_money($next_bidp);
} else {
    $next_bid = '--';
}

// get seller feebacks
$query = "SELECT rate FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :user_id";
$params = array();
$params[] = array(':user_id', $user_id, 'int');
$db->query($query, $params);
$num_feedbacks = $db->numrows();
// count numbers
$fb_pos = $fb_neg = 0;
while ($fb_arr = $db->fetch()) {
    if ($fb_arr['rate'] == 1) {
        $fb_pos++;
    } elseif ($fb_arr['rate'] == - 1) {
        $fb_neg++;
    }
}

$total_rate = $fb_pos - $fb_neg;

$query = "SELECT icon FROM " . $DBPrefix . "membertypes WHERE feedbacks <= :feedback ORDER BY feedbacks DESC LIMIT 1;";
$params = array();
$params[] = array(':feedback', $total_rate, 'int');
$db->query($query, $params);
$seller_feedback_icon = $db->result('icon');

// Pictures Gellery
$K = 0;
$UPLOADED_PICTURES = array();
if (is_dir(UPLOAD_PATH . $id)) {
    $dir = opendir(UPLOAD_FOLDER . $id);
    if ($dir) {
        while ($file = @readdir($dir)) {
            if ($file != '.' && $file != '..' && strpos($file, 'thumb-') === false) {
                $UPLOADED_PICTURES[$K] = $file;
                $K++;
            }
        }
        closedir($dir);
    }
    $GALLERY_DIR = $id;

    if (is_array($UPLOADED_PICTURES)) {
        foreach ($UPLOADED_PICTURES as $k => $v) {
            $TMP = @getimagesize(UPLOAD_FOLDER . $id . '/' . $v);
            if ($TMP[2] >= 1 && $TMP[2] <= 3) {
                $template->assign_block_vars('gallery', array(
                        'V' => $v
                        ));
            }
        }
    }
}

// payment methods
$payment = explode(', ', $auction_data['payment']);
$payment_methods = '';
$query = "SELECT gateway_active, is_gateway, name, displayname FROM " . $DBPrefix . "payment_options";
$db->direct_query($query);
$p_first = true;
while ($payment_method = $db->fetch()) {
    if ($payment_method['gateway_active'] == 1 || $payment_method['is_gateway'] == 0) {
        if (in_array($payment_method['name'], $payment)) {
            if (!$p_first) {
                $payment_methods .= ', ';
            } else {
                $p_first = false;
            }
            $payment_methods .= $payment_method['displayname'];
        }
    }
}

$bn_link = (!$has_ended) ? ' <a href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $id . '"><img border="0" align="absbottom" alt="' . $MSG['496'] . '" src="' . get_lang_img('buy_it_now.gif') . '"></a>' : '';

$page_title = htmlspecialchars($auction_data['title']);

$shipping = '';
if ($auction_data['shipping'] == 1) {
    $shipping = $MSG['031'];
} elseif ($auction_data['shipping'] == 2) {
    $shipping = $MSG['032'];
} elseif ($auction_data['shipping'] == 3) {
    $shipping = $MSG['867'];
}

$template->assign_vars(array(
        'ID' => $auction_data['id'],
        'TITLE' => htmlspecialchars($auction_data['title']),
        'SUBTITLE' => htmlspecialchars($auction_data['subtitle']),
        'AUCTION_DESCRIPTION' => $auction_data['description'],
        'PIC_URL' => UPLOAD_FOLDER . $id . '/' . $auction_data['pict_url'],
        'SHIPPING_COST' => ($auction_data['shipping_cost'] > 0) ? $system->print_money($auction_data['shipping_cost']) : $MSG['1152'],
        'ADDITIONAL_SHIPPING_COST' => $system->print_money($auction_data['additional_shipping_cost']),
        'COUNTRY' => $auction_data['country'],
        'CITY' => $auction_data['city'],
        'ZIP' => $auction_data['zip'],
        'QTY' => $auction_data['quantity'],
        'ENDS' => $ending_time,
        'ENDS_IN' => (strtotime($ends) - time()),
        'STARTTIME' => $dt->printDateTz($start),
        'ENDTIME' => $dt->printDateTz($ends),
        'BUYNOW1' => $auction_data['buy_now'],
        'BUYNOW2' => ($auction_data['buy_now'] > 0) ? $system->print_money($auction_data['buy_now']) . $bn_link : $system->print_money($auction_data['buy_now']),
        'NUMBIDS' => $num_bids,
        'MINBID' => $min_bid,
        'MAXBID' => $high_bid,
        'NEXTBID' => $next_bid,
        'INTERNATIONAL' => ($auction_data['international']) ? $MSG['033'] : $MSG['043'],
        'SHIPPING' => $shipping,
        'SHIPPINGTERMS' => nl2br(htmlspecialchars($auction_data['shipping_terms'])),
        'PAYMENTS' => $payment_methods,
        'AUCTION_VIEWS' => $auction_data['counter'],
        'AUCTION_TYPE' => ($auction_data['bn_only'] == 0) ? $system->SETTINGS['auction_types'][$auction_type] : $MSG['933'],
        'ATYPE' => $auction_type,
        'THUMBWIDTH' => $system->SETTINGS['thumb_show'],
        'VIEW_HISTORY1' => (empty($view_history)) ? '' : $view_history . ' | ',
        'VIEW_HISTORY2' => $view_history,
        'TOPCATSPATH' => ($system->SETTINGS['extra_cat'] == 'y' && isset($_SESSION['browse_id']) && $_SESSION['browse_id'] == $auction_data['secondcat']) ? $secondcat_value : $cat_value,
        'CATSPATH' => $cat_value,
        'SECCATSPATH' => $secondcat_value,
        'CAT_ID' => $auction_data['category'],
        'UPLOADEDPATH' => UPLOAD_FOLDER,
        'BNIMG' => get_lang_img('buy_it_now.gif'),

        'SELLER_REG' => $seller_reg,
        'SELLER_ID' => $auction_data['user'],
        'SELLER_NICK' => $auction_data['nick'],
        'SELLER_TOTALFB' => $total_rate,
        'SELLER_FB_ICON' => $seller_feedback_icon,
        'SELLER_NUMFB' => $num_feedbacks,
        'SELLER_FBPOS' => ($num_feedbacks > 0) ? '(' . ceil($fb_pos * 100 / $num_feedbacks) . '%)' : $MSG['000'],
        'SELLER_FBNEG' => ($fb_neg > 0 && $total_rate != 0) ? $MSG['5507'] . ' (' . ceil($fb_neg * 100 / $total_rate) . '%)' : '0',

        'WATCH_VAR' => $watch_var,
        'WATCH_STRING' => $watch_string,

        'YOURBIDMSG' => (isset($yourbidmsg)) ? $yourbidmsg : '',
        'YOURBIDCLASS' => (isset($yourbidclass)) ? $yourbidclass : '',

        'B_HASENDED' => $has_ended,
        'B_CANEDIT' => ($user->logged_in && $user->user_data['id'] == $auction_data['user'] && $num_bids == 0 && !($difference == null || $difference->invert)),
        'B_CANCONTACTSELLER' => (($system->SETTINGS['contactseller'] == 'always' || ($system->SETTINGS['contactseller'] == 'logged' && $user->logged_in)) && (!$user->logged_in || $user->user_data['id'] != $auction_data['user'])),
        'B_HASIMAGE' => (!empty($auction_data['pict_url'])),
        'B_NOTBNONLY' => ($auction_data['bn_only'] == 0),
        'B_HASRESERVE' => ($auction_data['reserve_price'] > 0 && $auction_data['reserve_price'] > $auction_data['current_bid']),
        'B_BNENABLED' => ($system->SETTINGS['buy_now'] == 2),
        'B_HASGALELRY' => (count($UPLOADED_PICTURES) > 0),
        'B_SHOWHISTORY' => (isset($_GET['history']) && $num_bids > 0),
        'B_BUY_NOW' => ($auction_data['buy_now'] > 0 && ($auction_data['bn_only'] || $auction_data['bn_only'] == 0 && ($auction_data['num_bids'] == 0 || ($auction_data['reserve_price'] > 0 && $auction_data['current_bid'] < $auction_data['reserve_price'])))),
        'B_BUY_NOW_ONLY' => ($auction_data['bn_only']),
        'B_ADDITIONAL_SHIPPING_COST' => ($auction_data['auction_type'] == '2'),
        'B_USERBID' => $userbid,
        'B_BIDDERPRIV' => ($system->SETTINGS['buyerprivacy'] == 'y' && (!$user->logged_in || ($user->logged_in && $user->user_data['id'] != $auction_data['user']))),
        'B_HASBUYER' => (count($hbidder_data) > 0),
        'B_COUNTDOWN' => ($system->SETTINGS['hours_countdown'] > ((strtotime($ends) - time()) / 3600)),
        'B_HAS_QUESTIONS' => ($num_questions > 0),
        'B_CAN_BUY' => ($user->permissions['can_buy'] || (!$user->logged_in && $system->SETTINGS['bidding_visable_to_guest'])) && !(strtotime($start) > time()),
        'B_SHIPPING' => ($system->SETTINGS['shipping'] == 'y'),
        'B_SHOWENDTIME' => $showendtime,
        'B_SHOW_ADDITIONAL_SHIPPING_COST' => ($auction_data['additional_shipping_cost'] > 0)
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'item.tpl'
        ));
$template->display('body');
include 'footer.php';
unset($_SESSION['browse_id']);
