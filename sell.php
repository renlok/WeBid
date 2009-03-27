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
include $include_path . 'dates.inc.php';
include $include_path . 'auction_types.inc.php';
include $include_path . 'datacheck.inc.php';
include $include_path . 'converter.inc.php';
include $include_path . 'sellfunctions.inc.php';
include $main_path . "language/" . $language . "/categories.inc.php";
include $main_path . "fck/fckeditor.php";

$_SESSION['action'] = (!isset($_SESSION['action'])) ? 1 : $_SESSION['action'];
$_SESSION['action'] = (!isset($_POST['action'])) ? $_SESSION['action'] : $_POST['action'];
$ERR = "ERR_";

if (!isset($_SESSION['SELL_sellcat']) || !is_numeric($_SESSION['SELL_sellcat'])) {
    header("location: select_category.php");
    exit;
}

if (!$user->logged_in) {
    $_SESSION['REDIRECT_AFTER_LOGIN'] = "sell.php";
    header("location: user_login.php");
    exit;
}

if ($system->SETTINGS['accounttype'] == 'sellerbuyer' && $user->user_data['accounttype'] != 'seller') {
    header("location: user_menu.php?cptab=selling");
    exit;
}
// set variables
setvars();

if ($_GET['mode'] == 'recall')
    $_SESSION['action'] = 1;

switch ($_SESSION['action']) {
    case 3:
        if ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on') {
			$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
			header('Location: ' . $sslurl . 'sell.php');
			exit;
		}
        $query = "SELECT * FROM " . $DBPrefix . "payments";
        $res_payments = mysql_query($query);
        $system->check_mysql($res_payments, $query, __LINE__, __FILE__);
        $payment_text = '';
        while ($paym = mysql_fetch_assoc($res_payments)) {
            if (in_array($paym['description'], $payment))
                $payment_text .= $paym['description'] . "\n";
        }
        $query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
        $result = mysql_query($query);
        $system->check_mysql($result, $query, __LINE__, __FILE__);
        $userrec = mysql_fetch_assoc($result);
        if ((md5($MD5_PREFIX . $_POST['password']) != $userrec['password']) && $system->SETTINGS['usersauth'] == 'y')
            $ERR = 'ERR_026';
        else {
            if ($userrec['suspended'] > 0)
                $ERR = 'ERR_618';
        }
        if ($ERR != 'ERR_')
            $_SESSION['action'] = 2;
        else {
            // set time back to GMT
            $a_starts = $a_starts - $system->tdiff;
            $a_ends = $a_starts + ($duration * 24 * 60 * 60);
            // insert auction
            $query = addauction();
            if ($_SESSION['SELL_action'] == 'edit')
                $query = updateauction(1);
            if ($_SESSION['SELL_action'] == 'relist')
                $query = updateauction(2);
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            if ($_SESSION['SELL_action'] == "edit" || $_SESSION['SELL_action'] == "relist")
                $auction_id = $TPL_auction_id = $_SESSION['SELL_auction_id'];
            else {
                $sql = "SELECT LAST_INSERT_ID() as id";
                $res_ = mysql_query($sql);
                $system->check_mysql($res_, $sql, __LINE__, __FILE__);
                $auction_id = mysql_result($res_, 0, 'id');
                $TPL_auction_id = $_SESSION['SELL_auction_id'] = $auction_id;
            }
            $UPLOADED_PICTURES = $_SESSION['UPLOADED_PICTURES'];
            // remove old images if any
            if (is_dir($upload_path . $auction_id)) {
                if ($dir = opendir($upload_path . $auction_id)) {
                    while (($file = readdir($dir)) !== false) {
                        if (is_file($upload_path . $auction_id . '/' . $file))
                            unlink($upload_path . $auction_id . '/' . $file);
                    }
                    closedir($dir);
                }
            }
            // Create pictures gallery if any
            if ($system->SETTINGS['picturesgallery'] == 1 && count($UPLOADED_PICTURES) > 0) {
                // Create dirctory
                umask();
                if (!is_dir($upload_path . $auction_id)) {
                    mkdir($upload_path . $auction_id, 0777);
                }
                // Copy files
                while (list($k, $v) = each($UPLOADED_PICTURES)) {
                    copy($upload_path . session_id() . "/" . $v, $upload_path . $auction_id . "/" . $v);
                    chmod($upload_path . $auction_id . "/" . $v, 0777);
                    unlink($upload_path . session_id() . "/" . $v);
                }
                if (!empty($pict_url)) {
                    copy($upload_path . session_id() . "/" . $pict_url, $upload_path . $auction_id . "/" . $pict_url);
                    chmod($upload_path . $auction_id . "/" . $pict_url, 0777);
                    unlink($upload_path . session_id() . "/" . $pict_url);
                }
                // Delete files, using dir (to eliminate eventual odd files)
                if ($dir = opendir($upload_path . session_id())) {
                    while (($file = readdir($dir)) !== false) {
                        if (!is_dir($upload_path . session_id() . "/" . $file))
                            unlink($upload_path . session_id() . "/" . $file);
                    }
                    closedir($dir);
                }
                rmdir($upload_path . session_id());
            }
            if (!isset($_SESSION['SELL_action']) || empty($_SESSION['SELL_action'])) {
                // Send notification if users keyword matches (Auction Watch)
                $query = "SELECT auc_watch, email, nick, name, id FROM " . $DBPrefix . "users WHERE auc_watch != ''";
                $result = mysql_query($query);
                while ($row = mysql_fetch_assoc($result)) {
                    if (isset($match)) unset($match);
                    $w_title = explode(" ", strtolower($_SESSION['SELL_title']));
                    $w_descr = explode(" ", strtolower(str_replace(array('<br>', "\n"), '', $_SESSION['SELL_description'])));
                    $w_nick = strtolower($user->user_data['nick']);
                    $key = explode(" ", $row['auc_watch']);
                    if (is_array($key) && count($key) > 0) {
                        while (list($k, $v) = each($key)) {
                            $v = trim(strtolower($v));
                            if (in_array($v, $w_title) || in_array($v, $w_descr) || $v == $w_nick) {
								$emailer = new email_class();
								$emailer->assign_vars(array(
										'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $_SESSION['SELL_auction_id'],
										'SITENAME' =>  $system->SETTINGS['sitename'],
										'TITLE' => $_SESSION['SELL_title'],
										'REALNAME' => $row['name'],
										'KWORD' => $row['auc_watch']
										));
								$emailer->email_uid = $row['id'];
								$emailer->email_sender($row['email'], 'mail_auction_watchmail.inc.php', $system->SETTINGS['sitename'] . '  ' . $MSG['471']);
                            }
                        }
                    }
                }
                $EMAILMODE = $user->user_data['startemailmode'];
				$ubn_only = $user->user_data['bn_only'];
                if ($EMAILMODE == 'yes') {
                    include $include_path . 'auction_confirmation.inc.php';
                }
				if($system->SETTINGS['bn_only'] == 'y' && $system->SETTINGS['bn_only_disable'] == 'y' && $system->SETTINGS['bn_only_percent'] < 100) {
					$query = "SELECT COUNT(*) FROM " . $DBPrefix . "auctions
						 WHERE closed = 0 AND suspended = 0 AND user = " . $user->user_data['id'];
					$result = mysql_query($query);
					$system->check_mysql($result, $query, __LINE__, __FILE__);
					$totalaucs = mysql_result($result, 0);
					if($totalaucs > 0) {
						$query = "SELECT COUNT(*) FROM " . $DBPrefix . "auctions
							 WHERE closed = 0 AND suspended = 0 AND bn_only = 'y' AND user = " . $user->user_data['id'];
						$result = mysql_query($query);
						$system->check_mysql($result, $query, __LINE__, __FILE__);
						$totalbnaucs = mysql_result($result, 0);
						$percent = ($totalbnaucs * 100) / $totalaucs;
						if($ubn_only == 'y' && $system->SETTINGS['bn_only_percent'] <= $percent) {
							$query = "UPDATE " . $DBPrefix . "users SET bn_only = 'n' WHERE id = " . $user->user_data['id'];
							$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
						}
						if($ubn_only == 'n' && $system->SETTINGS['bn_only_percent'] > $percent) {
							$query = "UPDATE " . $DBPrefix . "users SET bn_only = 'y' WHERE id = " . $user->user_data['id'];
							$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
						}
					}
				}
            }
            unsetsessions();
            $template->assign_vars(array(
                    'TITLE' => $MSG['028'],
                    'PAGE' => 2,
                    'AUCTION_ID' => $TPL_auction_id
                    ));
            break;
        }
    case 2:
        $noerror = true;
        if ($with_reserve == 'no') $reserve_price = 0;
        if ($buy_now == 'no') $buy_now_price = 0;
        // run the word filter
        if ($system->SETTINGS['wordsfilter'] == 'y') {
            $TPL_title_value = $title = $system->filter($title);
            $TPL_description_shown_value = $description = $system->filter($description);
        }
        // check for errors
		if($ERR == "ERR_") {
			$ERR = "ERR_" . CheckSellData();
			if ($ERR != "ERR_") {
				$_SESSION['action'] = 1;
				$noerror = false;
			}
		}
        if ($noerror) {
            $auction_id = generate_id();
            if ($imgtype == 1 && !empty($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != "none") {
                $inf = getimagesize($_FILES['userfile']['tmp_name']);
                $er = false;
                if ($inf) {
                    $inf[2] = intval($inf[2]);
                    if ($inf[2] < 1 || $inf[2] > 3) {
                        $er = true;
                        $ERR = "ERR_602";
                    } elseif (intval($userfile_size) > $system->SETTINGS['maxuploadsize']) {
                        $er = true;
                        $ERR = "ERR_603";
                    } else {
                        switch ($inf[2]) {
                            case 1:
                                $ext = ".gif";
                                break;
                            case 2:
                                $ext = ".jpg";
                                break;
                            case 3:
                                $ext = ".png";
                                break;
                        }
                        $uploaded_filename = $auction_id . $ext;
                        $fname = $upload_path . $uploaded_filename;
                        if (file_exists($fname)) {
                            unlink($fname);
                        }
                        move_uploaded_file($_FILES['userfile']['tmp_name'], $fname);
                        chmod($fname, 0777);
                        $pict_url = $uploaded_filename;
                        $_SESSION['SELL_file_uploaded'] = $imgtype;
                    }
                } else {
                    $ERR = "ERR_602";
                    $er = true;
                }
            } elseif ($imgtype == 0 && !empty($pict_url)) {
                if ($_SESSION['SELL_file_uploaded']) {
                    unlink($upload_path . $_SESSION['SELL_pict_url']);
                }
                $ext = strtolower(substr($pict_url, - 3));
                if ($ext != "gif" && $ext != "jpg" && $ext != "png") {
                    $ERR = "ERR_602";
                }
            }
            if (!$er) {
                // payment methods
                $query = "SELECT * FROM " . $DBPrefix . "payments";
                $res_payments = mysql_query($query);
                $system->check_mysql($res_payments, $query, __LINE__, __FILE__);
                while ($pay = mysql_fetch_array($res_payments)) {
                    if (in_array($pay['description'], $payment)) {
                        $TPL_payment_methods .= $pay['description'] . "<br>";
                    }
                }
                // category name
                $row = mysql_fetch_assoc(mysql_query("SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=" . intval($sellcat)));
                $TPL_categories_list = $row['cat_name'];
                while ($row['parent_id'] != 0) {
                    $row = mysql_fetch_assoc(mysql_query("SELECT * FROM " . $DBPrefix . "categories WHERE cat_id=" . $row['parent_id']));
                    $TPL_categories_list = $row['cat_name'] . " &gt; " . $TPL_categories_list;
                }

                $query = "SELECT description FROM " . $DBPrefix . "durations WHERE days = " . $duration;
                $res = mysql_query($query);
                $system->check_mysql($res, $query, __LINE__, __FILE__);
                // built gallery
                if ($system->SETTINGS['picturesgallery'] == 1 && @count($_SESSION['UPLOADED_PICTURES']) > 0) {
                    while (list($k, $v) = each($_SESSION['UPLOADED_PICTURES'])) {
                        $template->assign_block_vars('gallery', array(
                                'K' => $k,
                                'IMAGE' => $uploaded_path . session_id() . '/' . $v
                                ));
                    }
                }

                $iquantity = ($atype == 2 || $buy_now_only == 'y') ? $iquantity : 1;
				
				if(!(strpos($a_starts, '-') === false)) {
					$a_starts = gmmktime(substr($a_starts, 11, 2),
						substr($a_starts, 14, 2),
						substr($a_starts, 17, 2),
						substr($a_starts, 5, 2),
						substr($a_starts, 8, 2),
						substr($a_starts, 0, 4), 0);
				}

                $template->assign_vars(array(
                        'TITLE' => $title,
                        'ERROR' => ($ERR == "ERR_") ? '' : $$ERR,
                        'PAGE' => 1,
                        'MINTEXT' => ($atype == 2) ? $MSG['038'] : $MSG['020'],

                        'AUC_DESCRIPTION' => stripslashes($description),
                        'PIC_URL' => (empty($pict_url)) ? $MSG['114'] : '<img src="' . $uploaded_path . session_id() . '/' . $pict_url . '" />',
                        'MIN_BID' => $system->print_money($minimum_bid),
                        'RESERVE' => $system->print_money($reserve_price),
                        'BN_PRICE' => $system->print_money($buy_now_price),
                        'SHIPPING_COST' => $system->print_money($shipping_cost),
                        'STARTDATE' => FormatDate($a_starts),
                        'DURATION' => mysql_result($res, 0, 'description'),
                        'INCREMENTS' => ($increments == 1) ? $MSG['614'] : $system->print_money($customincrement),
                        'ATYPE' => $auction_types[$atype],
                        'ATYPE_PLAIN' => $atype,
                        'ADULT_ONLY' => ($adultonly == 'y') ? $MSG['030'] : $MSG['029'],
                        'SHIPPING' => (intval($shipping) == 1) ? $MSG['031'] : $MSG['032'],
                        'INTERNATIONAL' => ($international) ? $MSG['033'] : $MSG['043'],
                        'SHIPPING_TERMS' => nl2br(stripslashes($shipping_terms)),
                        'PAYMENTS_METHODS' => $TPL_payment_methods,
                        'CAT_LIST' => $TPL_categories_list,

                        'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y'),
                        'B_ADULTONLY' => ($system->SETTINGS['adultonly'] == 'y'),
                        'B_BN_ONLY' => (!($system->SETTINGS['buy_now'] == 2 && $buy_now_only == 'y')),
                        'B_BN' => ($system->SETTINGS['buy_now'] == 2),
                        'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1 && @count($_SESSION['UPLOADED_PICTURES']) > 0),
						'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1)
                        ));
                break;
            }
        }
        if(!(strpos($a_starts, '-') === false)) {
			$a_starts = gmmktime(substr($a_starts, 11, 2),
				substr($a_starts, 14, 2),
				substr($a_starts, 17, 2),
				substr($a_starts, 5, 2),
				substr($a_starts, 8, 2),
				substr($a_starts, 0, 4), 0);
		}
    case 1:
        $query = "SELECT cat_name, parent_id FROM " . $DBPrefix . "categories WHERE cat_id=" . intval($sellcat);
        $res = mysql_query($query);
        $system->check_mysql($res, $query, __LINE__, __FILE__);
        $row = mysql_fetch_assoc($res);
        $TPL_categories_list = $category_names[$sellcat];

        while ($row['parent_id'] != 0) {
            $P = $row['parent_id'];
            $query = "SELECT cat_name, parent_id FROM " . $DBPrefix . "categories WHERE cat_id=" . $row['parent_id'];
            $res = mysql_query($query);
            $system->check_mysql($res, $query, __LINE__, __FILE__);
            $row = mysql_fetch_assoc($res);
            $TPL_categories_list = $category_names[$P] . " &gt; " . $TPL_categories_list;
        }
        // ------------------------------------- auction types
        $TPL_auction_type = "<select name=\"atype\" id=\"atype\">\n";
        while (list($key, $val) = each($auction_types)) {
            $TPL_auction_type .= "\t<option value=\"" . $key . "\" " . (($key == $atype)?"SELECTED":"") . ">" . $val . "</option>\n";
        }
        $TPL_auction_type .= "</select>\n";
        // ------------------------------------- duration
        $query = "select * from " . $DBPrefix . "durations order by days";
        $res = mysql_query($query);
        $system->check_mysql($res, $query, __LINE__, __FILE__);
        $TPL_durations_list = "<select name=\"duration\">\n";
        while ($row = mysql_fetch_assoc($res)) {
            $TPL_durations_list .= "\t<option value='" . $row['days'] . "' " . (($row['days'] == $duration)?"selected":"") . ">" . $row['description'] . "</option>\n";
        }
        $TPL_durations_list .= "</select>\n";
        // -------------------------------------- payment
        $query = "select * from " . $DBPrefix . "payments";
        $res = mysql_query($query);
        $system->check_mysql($res, $query, __LINE__, __FILE__);
        $TPL_payments_list = "";
        while ($row = mysql_fetch_assoc($res)) {
            $checked = (in_array(trim($row['description']), $payment)) ? 'checked' : '';
            $TPL_payments_list .= '<input type="checkbox" name="payment[]" value="' . $row['description'] . '" ' . $checked . '>' . $row['description'] . '<br>';
        }
        // make hour
        if ($_SESSION['SELL_action'] != 'edit') {
			if(empty($a_starts)) {
				$TPL_start_date = gmdate('Y-m-d H:i:s', $system->ctime);
			} else {
				if(strpos($a_starts, '-') === false) {
					$a_starts = gmdate('Y-m-d H:i:s', $a_starts);
				}
				$TPL_start_date = $a_starts;
			}
        } else {
			$TPL_start_date = gmdate('Y-m-d H:i:s', $a_starts);
        }
		
		$query = "SELECT bn_only FROM " . $DBPrefix . "users WHERE id = " . $user->user_data['id'];
		$result = mysql_query($query);
		$system->check_mysql($result, $query, __LINE__, __FILE__);

        $oFCKeditor = new FCKeditor('description') ;
        $oFCKeditor->BasePath = 'fck/';
        $oFCKeditor->Value = stripslashes($description);
        $oFCKeditor->Width = '90%';
        $oFCKeditor->Height = '400';

        $template->assign_vars(array(
                'TITLE' => $MSG['028'],
                'ERROR' => ($ERR == "ERR_") ? '' : $$ERR,
                'MAXPICS' => $system->SETTINGS['maxpictures'],
                'CAT_LIST' => $TPL_categories_list,
                'ATYPE' => $TPL_auction_type,
                'CURRENCY' => $system->SETTINGS['currency'],
                'DURATIONS' => $TPL_durations_list,
                'PAYMENTS' => $TPL_payments_list,
                'PAGE' => 0,
                'MINTEXT' => ($atype == 2) ? $MSG['038'] : $MSG['020'],
                // auction details
                'AUC_TITLE' => $title,
                'AUC_DESCRIPTION' => $oFCKeditor->CreateHtml(),
                'ADULTONLY_Y' => ($adultonly == 'y') ? 'checked' : '',
                'ADULTONLY_N' => ($adultonly == 'y') ? '' : 'checked',
                'ITEMQTY' => $iquantity,
                'MIN_BID' => $system->print_money_nosymbol($minimum_bid),
                'BN_ONLY' => ($buy_now_only == 'y') ? 'disabled' : '',
                'SHIPPING_COST' => $system->print_money_nosymbol($shipping_cost),
                'RESERVE_Y' => ($with_reserve == 'yes') ? 'checked' : '',
                'RESERVE_N' => ($with_reserve == 'yes') ? '' : 'checked',
                'RESERVE' => $system->print_money_nosymbol($reserve_price),
                'START_TIME' => $TPL_start_date,
                'BN_ONLY_Y' => ($buy_now_only == 'y') ? 'checked' : '',
                'BN_ONLY_N' => ($buy_now_only == 'y') ? '' : 'checked',
                'BN_Y' => ($buy_now == 'yes') ? 'checked' : '',
                'BN_N' => ($buy_now == 'yes') ? '' : 'checked',
                'BN' => ($buy_now == 'yes') ? '' : 'disabled',
                'BN_PRICE' => $system->print_money_nosymbol($buy_now_price),
                'INCREMENTS1' => ($increments == 1 || empty($increments)) ? 'checked' : '',
                'INCREMENTS2' => ($increments == 2) ? 'checked' : '',
                'CUSTOM_INC' => ($customincrement > 0) ? $system->print_money_nosymbol($customincrement) : '',
                'SHIPPING1' => (intval($shipping) == 1 || empty($shipping)) ? 'checked' : '',
                'SHIPPING2' => (intval($shipping) == 2) ? 'checked' : '',
                'INTERNATIONAL' => (!empty($international)) ? 'checked' : '',
                'SHIPPING_TERMS' => $shipping_terms,
                'ITEMQTYD' => ($atype == 2 || $buy_now_only == 'y') ? '' : 'disabled',

                'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1),
                'B_ADULTONLY' => ($system->SETTINGS['adultonly'] == 'y'),
                'B_BN_ONLY' => ($system->SETTINGS['buy_now'] == 2 && $system->SETTINGS['bn_only'] == 'y' && (($system->SETTINGS['bn_only_disable'] == 'y' && mysql_result($result, 0, 'bn_only') == 'y') || $system->SETTINGS['bn_only_disable'] == 'n')),
                'B_BN' => ($system->SETTINGS['buy_now'] == 2),
                'B_EDITING' => ($_SESSION['SELL_action'] == 'edit'),
				'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1)
                ));
        break;
}

include "header.php";
$template->set_filenames(array(
        'body' => 'sell.html'
        ));
$template->display('body');
include "footer.php";

if ($_SESSION['action'] != 3)
    makesessions();

?>