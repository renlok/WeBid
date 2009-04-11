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
include $main_path . "language/" . $language . "/categories.inc.php";

if (!ini_get('register_globals')) {
    $superglobales = array($_SERVER, $_ENV,
        $_FILES, $_COOKIE, $_POST, $_GET);
    foreach ($superglobales as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
}
// Is the seller logged in?
if (!$user->logged_in)
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'select_category.php';
	header('location: user_login.php');
	exit;
}

if ($system->SETTINGS['uniqueseller'] > 0 && $user->user_data['id'] != $system->SETTINGS['uniqueseller'])
{
	header('location: index.php');
	exit;
}

// Process category selection
$ERR = '';
if (isset($_POST['action']) && $_POST['action'] == 'process' && isset($_POST['submitit'])) {
    $_SESSION['cat0'] = (isset($_POST['cat0'])) ? $_POST['cat0'] : '';
    $_SESSION['cat1'] = (isset($_POST['cat1'])) ? $_POST['cat1'] : '';
    $_SESSION['cat2'] = (isset($_POST['cat2'])) ? $_POST['cat2'] : '';
    $_SESSION['cat3'] = (isset($_POST['cat3'])) ? $_POST['cat3'] : '';
    $_SESSION['cat4'] = (isset($_POST['cat4'])) ? $_POST['cat4'] : '';
    $_SESSION['cat5'] = (isset($_POST['cat5'])) ? $_POST['cat5'] : '';
    $_SESSION['cat6'] = (isset($_POST['cat6'])) ? $_POST['cat6'] : '';
    $_SESSION['cat7'] = (isset($_POST['cat7'])) ? $_POST['cat7'] : '';
    $_SESSION['action'] = 1;

    $IDX = 7;
    while ($IDX >= 0) {
        $VARNAME = 'cat' . $IDX;
        if (isset($_POST[$VARNAME]) && !empty($_POST[$VARNAME])) {
            $_SESSION['SELL_sellcat'] = $_POST[$VARNAME];
            $numchild = mysql_result(mysql_query("SELECT count(cat_id) as childs FROM " . $DBPrefix . "categories
						WHERE parent_id=" . addslashes($_POST[$VARNAME])), 0, "childs");
            if ($numchild == 0) {
                header("location: sell.php");
                exit;
            } else {
                $_POST['box'] = $IDX + 1;
                $ERR = $ERR_25_0001;
                break;
            }
        }
        $IDX--;
    }
}

/**
 * NOTE: Process change mode
 */
if (isset($_GET['change']) && $_GET['change'] == 'yes') {
    for($i = 0; $i < 8; $i++) {
        $IDX = 'cat' . $i;
        $_POST[$IDX] = $_SESSION[$IDX];
        if ($_SESSION[$IDX] == '') {
            $_POST['box'] = $i + 1;
        }
    }
} elseif (count($_POST) == 0) {
    unset($_SESSION['cattree']);
    unset($_SESSION['RELISTEDAUCTION']);
    unset($_SESSION['FEATURED']);
    unset($_SESSION['UPLOADED_PICTURES']);
    unset($_SESSION['UPLOADED_PICTURES_SIZE']);
    unset($_SESSION['GALLERY_UPDATED']);
	unset($_SESSION['SELL_starts']);
    $_SESSION['SELL_with_reserve'] = '';
    $_SESSION['SELL_reserve_price'] = '';
    $_SESSION['SELL_minimum_bid'] = '';
    $_SESSION['SELL_file_uploaded'] = '';
    $_SESSION['SELL_title'] = '';
    $_SESSION['SELL_description'] = '';
    $_SESSION['SELL_pict_url'] = '';
    $_SESSION['SELL_atype'] = '';
    $_SESSION['SELL_adultonly'] = '';
    $_SESSION['SELL_iquantity'] = '';
    $_SESSION['SELL_with_buy_now'] = '';
    $_SESSION['SELL_buy_now_price'] = '';
    $_SESSION['SELL_duration'] = '';
    $_SESSION['SELL_relist'] = '';
    $_SESSION['SELL_increments'] = '';
    $_SESSION['SELL_customincrement'] = '';
    $_SESSION['SELL_shipping'] = '';
    $_SESSION['SELL_shipping_terms'] = '';
    $_SESSION['SELL_payment'] = '';
    $_SESSION['SELL_international'] = '';
    $_SESSION['SELL_private'] = '';
    $_SESSION['SELL_sendemail'] = '';
    $_SESSION['SELL_buy_now_only'] = '';
    $_SESSION['SELL_action'] = '';
    $_SESSION['SELL_shipping_cost'] = 0;
}
unset($_SESSION['CATSTRING']);
unset($_SESSION['CATEGORY']);

$_SESSION['cat0'] = (isset($_POST['cat0'])) ? $_POST['cat0'] : '';
$_SESSION['cat1'] = (isset($_POST['cat1'])) ? $_POST['cat1'] : '';
$_SESSION['cat2'] = (isset($_POST['cat2'])) ? $_POST['cat2'] : '';
$_SESSION['cat3'] = (isset($_POST['cat3'])) ? $_POST['cat3'] : '';
$_SESSION['cat4'] = (isset($_POST['cat4'])) ? $_POST['cat4'] : '';
$_SESSION['cat5'] = (isset($_POST['cat5'])) ? $_POST['cat5'] : '';
$_SESSION['cat6'] = (isset($_POST['cat6'])) ? $_POST['cat6'] : '';
$_SESSION['cat7'] = (isset($_POST['cat7'])) ? $_POST['cat7'] : '';

/**
 * NOTE: Build the categories arrays
 */
$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories WHERE parent_id = 0 ORDER BY cat_name";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0) {
    while ($row = mysql_fetch_assoc($res)) {
        // Check to see if this category has subcategoryes
        $CHILDRENS = mysql_num_rows(mysql_query("SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = " . $row['cat_id']));
        // Select the translated category name
        $row['cat_name'] = stripslashes($category_names[$row['cat_id']]);

        $CATS0[$row['cat_id']] = stripslashes($row['cat_name']);
        if (strlen($row['cat_name']) > $MAXLENGTH) $MAXLENGTH = strlen($row['cat_name']);
        if ($CHILDRENS > 0) {
            $CATS0[$row['cat_id']] .= "&nbsp;->";
            $DONTSUBMIT[$row['cat_id']] = 0;
        } else {
            $DONTSUBMIT[$row['cat_id']] = 1;
        }
    }
}

/**
 * NOTE: Build sub-boxes
 */
$TMP = "cat" . ($_POST['box'] - 1);
$YY = "S" . $$TMP;
$SHOWBUTTON = $$YY;
if ($_GET['change'] == 'yes') $SHOWBUTTON = 1;
if ($_POST['box'] > 0) {
    $I = 1;
    while ($I <= $_POST['box']) {
        $IDX = $I - 1;
        $NAME = "cat" . $IDX;

        if ($$NAME != '') {
            $query = "SELECT cat_id,cat_name FROM " . $DBPrefix . "categories WHERE parent_id=" . $$NAME . " ORDER BY cat_name";
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            if (mysql_num_rows($res) > 0) {
                unset($row);
                while ($row = mysql_fetch_assoc($res)) {
                    $ARRAYNAME = "CATS" . $I;
                    // Check to see if this category has subcategoryes
                    $CHILDRENS = mysql_num_rows(mysql_query("SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id=" . $row['cat_id']));
                    // Select the translated category name
                    $row['cat_name'] = stripslashes($category_names[$row['cat_id']]);
                    $ {
                        $ARRAYNAME}
                    [$row['cat_id']] = stripslashes($row['cat_name']);
                    if (strlen($row['cat_name']) > $MAXLENGTH) $MAXLENGTH = strlen($row['cat_name']);
                    if ($CHILDRENS > 0) {
                        $ {
                            $ARRAYNAME}
                        [$row['cat_id']] .= "&nbsp;->";
                        $DONTSUBMIT[$row['cat_id']] = 0;
                    } else {
                        $DONTSUBMIT[$row['cat_id']] = 1;
                    }
                }
            }
        }
        $I++;
    }
}

if (is_array($DONTSUBMIT)) {
    while (list($k, $v) = each($DONTSUBMIT)) {
        $template->assign_block_vars('dontsubmit', array(
                'V' => $v,
                'K' => $k
                ));
    }
}

for ($i = 0; $i < 8; $i++) {
    $catto = "CATS" . $i;
    $cattnext = "CATS" . ($i + 1);
    if (isset($$catto) && is_array($$catto)) {
        $template->assign_block_vars('boxes', array(
                'B_NOWLINE' => (($i % 2 == 0) && ($i > 0)),
                'I' => $i,
                'I2' => $i + 1
                ));
        while (list($k, $v) = each($$catto)) {
            $template->assign_block_vars('boxes.cats', array(
                    'K' => $k,
                    'CATNAME' => $v,
                    'SELECTED' => (isset($_POST['cat' . $i]) && $_POST['cat' . $i] == $k) ? ' selected' : ''
                    ));
            if (isset($_POST['cat' . $i]) && $_POST['cat' . $i] == $k && is_array($$cattnext)) $_SESSION['CATSTRING'] .= str_replace('&nbsp;->', '', $v) . ' > ';
        }
    }
}

$template->assign_vars(array(
        'B_SHOWBUTTON' => $SHOWBUTTON,
        'ERROR' => $ERR
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'select_category.html'
        ));
$template->display('body');
include "footer.php";

?>