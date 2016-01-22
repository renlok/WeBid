<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
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
include $include_path . 'datacheck.inc.php';
include $include_path . 'functions_sell.php';
include $main_path . 'language/' . $language . '/categories.inc.php';
include $main_path . 'ckeditor/ckeditor.php';
include $include_path . 'htmLawed.php';

$_SESSION['action'] = (!isset($_SESSION['action'])) ? 1 : $_SESSION['action'];
$_SESSION['action'] = (!isset($_POST['action'])) ? $_SESSION['action'] : $_POST['action'];
$ERR = 'ERR_';
$_SESSION['SELL_editing_category'] = false;
$catscontrol = new MPTTcategories();

if (!isset($_SESSION['SELL_sellcat1']) || !is_numeric($_SESSION['SELL_sellcat1']))
{
	header('location: select_category.php');
	exit;
}

if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'sell.php';
	header('location: user_login.php');
	exit;
}

if (in_array($user->user_data['suspended'], array(5, 6, 7)))
{
	header('location: message.php');
	exit;
}

if (!$user->can_sell)
{
	$_SESSION['TMP_MSG'] = $MSG['818'];
	header('location: user_menu.php?cptab=selling');
	exit;
}

// check if user skiped adding second category
if (isset($_POST['act']) && $_POST['act'] == 'skipexcat')
{
	$_SESSION['SELL_sellcat2'] = 0;
}

// GALLERY FUNCTIONS
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['img'])) // Process delete photos
{
	if ($_SESSION['SELL_pict_url_temp'] == $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])])
	{
		unlink($upload_path . session_id() . '/' . $_SESSION['SELL_pict_url']);
		unset($_SESSION['SELL_pict_url']);
	}
	unlink($upload_path . session_id() . '/' . $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]);
	unset($_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]);
	unset($_SESSION['UPLOADED_PICTURES_SIZE'][intval($_GET['img'])]);
}

if (isset($_GET['action']) && $_GET['action'] == 'makedefault')
{
	$_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $_GET['img'];
}

// set variables
setvars();

if (isset($_GET['mode']) && $_GET['mode'] == 'recall')
	$_SESSION['action'] = 1;

switch ($_SESSION['action'])
{
	case 4: // finalise auction (submit to db)
		if ($system->SETTINGS['usersauth'] == 'y' && $system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
		{
			$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
			$sslurl = (!empty($system->SETTINGS['https_url'])) ? $system->SETTINGS['https_url'] : $sslurl;
			header('location: ' . $sslurl . 'sell.php');
			exit;
		}
		// does the user need to login before they can submit the auction?
		if ($system->SETTINGS['usersauth'] == 'y')
		{
			// hash and check the password
			include $include_path . 'PasswordHash.php';
			$phpass = new PasswordHash(8, false);
			if (!($phpass->CheckPassword($_POST['password'], $user->user_data['password'])))
			{
				$ERR = 'ERR_026';
			}
		}
		if ($ERR != 'ERR_')
		{
			$_SESSION['action'] = 2;
		}
		else
		{
			// clean up sell description
			$conf = array();
			$conf['safe'] = 1;
			$conf['deny_attribute'] = 'style';
			$_SESSION['SELL_description'] = htmLawed($_SESSION['SELL_description'], $conf);

			$payment_text = implode(', ', $payment);
			// set time back to GMT
			$a_starts = (empty($start_now) || $_SESSION['SELL_action'] == 'edit') ? ($a_starts - $system->tdiff) : time();
			$a_ends = $a_starts + ($duration * 24 * 60 * 60);
			// get fee
			$fee_data = get_fee($minimum_bid, false);
			$fee = $fee_data[0];
			$fee_data = $fee_data[1];

			if ($_SESSION['SELL_action'] == 'edit')
				updateauction(1);
			if ($_SESSION['SELL_action'] == 'relist')
			{
				remove_bids($_SESSION['SELL_auction_id']); // incase they've not already been removed
				updateauction(2);
			}
			if ($_SESSION['SELL_action'] == 'edit' || $_SESSION['SELL_action'] == 'relist')
			{
				$auction_id = $_SESSION['SELL_auction_id'];
			}
			else
			{
				// insert auction
				addauction();
				$auction_id = $db->lastInsertId();
				//print_r($db);
				$_SESSION['SELL_auction_id'] = $auction_id;
			}

			$addcounter = true;

			// work out & add fee
			if ($system->SETTINGS['fees'] == 'y')
			{
				$feeupdate = false;
				// attach the new invoice to users account
				addoutstanding();

				// deal with the auction
				if ($system->SETTINGS['fee_type'] == 2 && $fee > 0)
				{
					$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 9 WHERE id = :auction_id";
					$params = array();
					$params[] = array(':auction_id', $auction_id, 'int');
					$db->query($query, $params);
					$addcounter = false;
				}
				else
				{
					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :user_id";
					$params = array();
					$params[] = array(':fee', $fee, 'float');
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$db->query($query, $params);
				}
			}

			if ($addcounter && $_SESSION['SELL_action'] != 'edit')
			{
				$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions + 1";
				$db->direct_query($query);
			}
			elseif (!$addcounter && $_SESSION['SELL_action'] == 'edit')
			{
				$query = "UPDATE " . $DBPrefix . "counters SET auctions = auctions - 1";
				$db->direct_query($query);
			}

			// no fees are due and your not editing the auction so add to the auction count
			if (!($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0) && $_SESSION['SELL_action'] != 'edit')
			{
				// update recursive categories
				update_cat_counters(true, $_SESSION['SELL_sellcat1'], $_SESSION['SELL_sellcat2']);
			}

			// fees are due and you are editing the auction so remove the auction count
			if (!$addcounter && $_SESSION['SELL_action'] == 'edit')
			{
				// update recursive categories
				update_cat_counters(false, $_SESSION['SELL_sellcat1'], $_SESSION['SELL_sellcat2']);
			}

			// if editing the auction and the categories have been changed
			if ($_SESSION['SELL_action'] == 'edit' && ($_SESSION['SELL_sellcat1'] != $_SESSION['SELL_original_sellcat1'] || $_SESSION['SELL_sellcat2'] != $_SESSION['SELL_original_sellcat2']))
			{
				if ($_SESSION['SELL_sellcat1'] != $_SESSION['SELL_original_sellcat1'] || $_SESSION['SELL_sellcat2'] != $_SESSION['SELL_original_sellcat2'])
				{
					// remove the old category count and add to the new one
					update_cat_counters(false, $_SESSION['SELL_sellcat1'], $_SESSION['SELL_sellcat2']);
					update_cat_counters(true, $_SESSION['SELL_original_sellcat1'], $_SESSION['SELL_original_sellcat2']);
				}
			}

			$UPLOADED_PICTURES = (isset($_SESSION['UPLOADED_PICTURES'])) ? $_SESSION['UPLOADED_PICTURES'] : array();
			// remove old images if any
			if (is_dir($upload_path . $auction_id))
			{
				if ($dir = opendir($upload_path . $auction_id))
				{
					while (($file = readdir($dir)) !== false)
					{
						if (is_file($upload_path . $auction_id . '/' . $file))
							unlink($upload_path . $auction_id . '/' . $file);
					}
					closedir($dir);
				}
			}
			// Create pictures gallery if any
			if ($system->SETTINGS['picturesgallery'] == 1 && count($UPLOADED_PICTURES) > 0)
			{
				// Create dirctory
				umask();
				if (!is_dir($upload_path . $auction_id))
				{
					mkdir($upload_path . $auction_id, 0777);
				}
				// Copy files
				foreach ($UPLOADED_PICTURES as $k => $v)
				{
					$system->move_file($upload_path . session_id() . '/' . $v, $upload_path . $auction_id . '/' . $v);
					chmod($upload_path . $auction_id . '/' . $v, 0777);
				}
				if (!empty($pict_url))
				{
					$system->move_file($upload_path . session_id() . '/' . $pict_url, $upload_path . $auction_id . '/' . $pict_url);
					chmod($upload_path . $auction_id . '/' . $pict_url, 0777);
				}
				// Delete files, using dir (to eliminate eventual odd files)
				if ($dir = opendir($upload_path . session_id()))
				{
					while (($file = readdir($dir)) !== false)
					{
						if (!is_dir($upload_path . session_id() . '/' . $file))
							unlink($upload_path . session_id() . '/' . $file);
					}
					closedir($dir);
				}
				rmdir($upload_path . session_id());
			}
			if (!isset($_SESSION['SELL_action']) || empty($_SESSION['SELL_action']))
			{
				// Send notification if users keyword matches (Auction Watch)
				$query = "SELECT auc_watch, email, nick, name, id FROM " . $DBPrefix . "users WHERE auc_watch != '' AND id != :user_id";
				$params = array();
				$params[] = array(':user_id', $user->user_data['id'], 'int');
				$db->query($query, $params);
				$sent_to = array();
				while ($row = $db->fetch())
				{
					if (isset($match)) unset($match);
					$w_title = explode(' ', strtolower($_SESSION['SELL_title']));
					$w_descr = explode(' ', strtolower(str_replace(array('<br>', "\n"), '', strip_tags($_SESSION['SELL_description']))));
					$w_nick = strtolower($user->user_data['nick']);
					$key = explode(' ', $row['auc_watch']);
					if (is_array($key) && count($key) > 0)
					{
						foreach ($key as $k => $v)
						{
							$v = trim(strtolower($v));
							if ((in_array($v, $w_title) || in_array($v, $w_descr) || $v == $w_nick) && !in_array($row['id'], $sent_to))
							{
								$emailer = new email_handler();
								$emailer->assign_vars(array(
										'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $_SESSION['SELL_auction_id'],
										'SITENAME' =>  $system->SETTINGS['sitename'],
										'TITLE' => $_SESSION['SELL_title'],
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

				if ($user->user_data['startemailmode'] == 'yes')
				{
					include $include_path . 'email_auction_confirmation.php';
				}
				if ($system->SETTINGS['bn_only'] == 'y' && $system->SETTINGS['bn_only_disable'] == 'y' && $system->SETTINGS['bn_only_percent'] < 100)
				{
					$query = "SELECT COUNT(*) as count FROM " . $DBPrefix . "auctions
							WHERE closed = 0 AND suspended = 0 AND user = :user_id";
					$params = array();
					$params[] = array(':user_id', $user->user_data['id'], 'int');
					$db->query($query, $params);
					$totalaucs = $db->result('count');
					if ($totalaucs > 0)
					{
						$query = "SELECT COUNT(*) as count FROM " . $DBPrefix . "auctions
								WHERE closed = 0 AND suspended = 0 AND bn_only = 'y' AND user = :user_id";
						$params = array();
						$params[] = array(':user_id', $user->user_data['id'], 'int');
						$db->query($query, $params);
						$totalbnaucs = $db->result('count');
						$percent = ($totalbnaucs * 100) / $totalaucs;
						if ($user->user_data['bn_only'] == 'y' && $system->SETTINGS['bn_only_percent'] <= $percent)
						{
							$query = "UPDATE " . $DBPrefix . "users SET bn_only = 'n' WHERE id = :user_id";
							$params = array();
							$params[] = array(':user_id', $user->user_data['id'], 'int');
							$db->query($query, $params);
						}
						if ($user->user_data['bn_only'] == 'n' && $system->SETTINGS['bn_only_percent'] > $percent)
						{
							$query = "UPDATE " . $DBPrefix . "users SET bn_only = 'y' WHERE id = :user_id";
							$params = array();
							$params[] = array(':user_id', $user->user_data['id'], 'int');
							$db->query($query, $params);
						}
					}
				}
			}
			unsetsessions();
			if (defined('TrackUserIPs'))
			{
				// log auction setup IP
				$system->log('user', 'List Item', $user->user_data['id'], $auction_id);
			}
			if ($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0)
			{
				$_SESSION['auction_id'] = $auction_id;
				header('location: pay.php?a=4');
				exit;
			}
			$template->assign_vars(array(
					'TITLE' => $MSG['028'],
					'PAGE' => 3,
					'AUCTION_ID' => $auction_id,
					'MESSAGE' => sprintf($MSG['102'], $auction_id, date('D j M \a\t g:ia', $a_ends + $system->tdiff))
					));
			break;
		}
	case 3: // confirm auction
		$noerror = true;
		if ($with_reserve == 'no') $reserve_price = 0;
		if ($buy_now == 'no') $buy_now_price = 0;
		// run the word filter
		if ($system->SETTINGS['wordsfilter'] == 'y')
		{
			$title = $system->filter($title);
			$subtitle = $system->filter($subtitle);
			$sdescription = $system->filter($sdescription);
		}
		// check for errors
		if ($ERR == 'ERR_')
		{
			if (count($_SESSION['UPLOADED_PICTURES']) > $system->SETTINGS['maxpictures'])
			{
				$ERR = sprintf($MSG['674'], $system->SETTINGS['maxpictures']);
			}
			$ERR = 'ERR_' . CheckSellData();
			if ($ERR != 'ERR_')
			{
				$_SESSION['action'] = 2;
				$noerror = false;
			}
		}
		if ($noerror)
		{
			// payment methods
			$payment_methods = '';
			$query = "SELECT * FROM " . $DBPrefix . "gateways";
			$db->direct_query($query);
			$gateways_data = $db->result();
			$gateway_list = explode(',', $gateways_data['gateways']);
			foreach ($gateway_list as $v)
			{
				$v = strtolower($v);
				if ($gateways_data[$v . '_active'] == 1 && _in_array($v, $payment))
				{
					$payment_methods .= '<p>' . $system->SETTINGS['gateways'][$v] . '</p>';
				}
			}

			$payment_options = unserialize($system->SETTINGS['payment_options']);
			foreach ($payment_options as $k => $v)
			{
				if (_in_array($k, $payment))
				{
					$payment_methods .= '<p>' . $v . '</p>';
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
			if ($system->SETTINGS['picturesgallery'] == 1 && isset($_SESSION['UPLOADED_PICTURES']) && count($_SESSION['UPLOADED_PICTURES']) > 0)
			{
				foreach ($_SESSION['UPLOADED_PICTURES'] as $k => $v)
				{
					$template->assign_block_vars('gallery', array(
							'K' => $k,
							'IMAGE' => $uploaded_path . session_id() . '/' . $v
							));
				}
			}

			$iquantity = ($atype == 2 || $buy_now_only == 'y') ? $iquantity : 1;

			if (!(strpos($a_starts, '-') === false))
			{
				$a_starts = _mktime(substr($a_starts, 11, 2),
					substr($a_starts, 14, 2),
					substr($a_starts, 17, 2),
					substr($a_starts, 0, 2),
					substr($a_starts, 3, 2),
					substr($a_starts, 6, 4), 0);
			}

			$shippingtext = '';
			if ($shipping == 1)
				$shippingtext = $MSG['033'];
			elseif ($shipping == 2)
				$shippingtext = $MSG['032'];
			elseif ($shipping == 3)
				$shippingtext = $MSG['867'];

			$template->assign_vars(array(
					'TITLE' => $title,
					'SUBTITLE' => $subtitle,
					'ERROR' => ($ERR == 'ERR_') ? '' : $$ERR,
					'PAGE' => 2,
					'MINTEXT' => ($atype == 2) ? $MSG['038'] : $MSG['020'],

					'AUC_DESCRIPTION' => stripslashes($sdescription),
					'PIC_URL' => (empty($pict_url)) ? $MSG['114'] : '<img src="' . $uploaded_path . session_id() . '/' . $pict_url . '" style="max-width:100%; max-height:100%;">',
					'MIN_BID' => $system->print_money($minimum_bid, false),
					'RESERVE' => $system->print_money($reserve_price, false),
					'BN_PRICE' => $system->print_money($buy_now_price, false),
					'SHIPPING_COST' => $system->print_money($shipping_cost, false),
					'ADDITIONAL_SHIPPING_COST' => $system->print_money($additional_shipping_cost, false),
					'STARTDATE' => (empty($start_now)) ? FormatDate($a_starts) : FormatDate($system->ctime),
					'DURATION' => $duration_desc,
					'INCREMENTS' => ($increments == 1) ? $MSG['614'] : $system->print_money($customincrement, false),
					'ATYPE' => $system->SETTINGS['auction_types'][$atype],
					'ATYPE_PLAIN' => $atype,
					'SHIPPING' => $shippingtext,
					'INTERNATIONAL' => ($international) ? $MSG['033'] : $MSG['043'],
					'SHIPPING_TERMS' => nl2br(stripslashes($shipping_terms)),
					'PAYMENTS_METHODS' => $payment_methods,
					'CAT_LIST1' => $category_string1,
					'CAT_LIST2' => $category_string2,
					'FEE' => number_format(get_fee($minimum_bid), $system->SETTINGS['moneydecimals']),

					'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y'),
					'B_BN_ONLY' => (!($system->SETTINGS['buy_now'] == 2 && $buy_now_only == 'y')),
					'B_BN' => ($system->SETTINGS['buy_now'] == 2),
					'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1 && isset($_SESSION['UPLOADED_PICTURES']) && count($_SESSION['UPLOADED_PICTURES']) > 0),
					'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1),
					'B_FEES' => ($system->SETTINGS['fees'] == 'y'),
					'B_SHIPPING' => ($system->SETTINGS['shipping'] == 'y'),
					'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y')
					));
			break;
		}
	case 1:  // enter auction details
		// check time format is timestamp. If not change to timestamp
		if (!(strpos($a_starts, '-') === false))
		{
			$a_starts = _mktime(substr($a_starts, 11, 2),
				substr($a_starts, 14, 2),
				substr($a_starts, 17, 2),
				substr($a_starts, 0, 2),
				substr($a_starts, 3, 2),
				substr($a_starts, 6, 4), 0);
		}
		$category_string1 = get_category_string($sellcat1);
		$category_string2 = get_category_string($sellcat2);

		// auction types
		$TPL_auction_type = '<select name="atype" id="atype">' . "\n";
		foreach ($system->SETTINGS['auction_types'] as $key => $val)
		{
			$TPL_auction_type .= "\t" . '<option value="' . $key . '" ' . (($key == $atype) ? 'selected="true"' : '') . '>' . $val . '</option>' . "\n";
		}
		$TPL_auction_type .= '</select>' . "\n";

		// duration
		$time_passed = ($_SESSION['SELL_action'] != 'edit') ? 0 : (time() - $a_starts) / (3600 * 24); // get time passed in days
		$query = "SELECT * FROM " . $DBPrefix . "durations WHERE days > :days ORDER BY days";
		$params = array();
		$params[] = array(':days', floor($time_passed), 'int');
		$db->query($query, $params);
		$TPL_durations_list = '<select name="duration">' . "\n";
		while ($row = $db->fetch())
		{
			$selected = ($row['days'] == $duration) ? 'selected="true"' : '';
			$TPL_durations_list .= "\t" . '<option value="' . $row['days'] . '" ' . $selected . '>' . $row['description'] . '</option>' . "\n";
		}
		$TPL_durations_list .= '</select>' . "\n";

		// can seller charge tax
		$can_tax = false;
		if (!empty($user->user_data['country']))
		{
			$query = "SELECT id FROM " . $DBPrefix . "tax WHERE countries_seller LIKE :country";
			$params = array();
			$params[] = array(':country', $user->user_data['country'], 'str');
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$can_tax = true;
			}
		}

		// payments
		$payment_methods = '';
		$query = "SELECT * FROM " . $DBPrefix . "gateways";
		$db->direct_query($query);
		$gateways_data = $db->result();
		$gateway_list = explode(',', $gateways_data['gateways']);
		foreach ($gateway_list as $v)
		{
			if ($gateways_data[$v . '_active'] == 1 && check_gateway($v))
			{
				$v = strtolower($v);
				$checked = (_in_array($v, $payment)) ? 'checked' : '';
				$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $v . '" ' . $checked . '>' . $system->SETTINGS['gateways'][$v] . '</p>';
			}
		}

		$payment_options = unserialize($system->SETTINGS['payment_options']);
		foreach ($payment_options as $k => $v)
		{
			$checked = (_in_array($k, $payment)) ? 'checked' : '';
			$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $k . '" ' . $checked . '>' . $v . '</p>';
		}

		// make hour
		if ($system->SETTINGS['datesformat'] == 'USA')
		{
			$gmdate_string = 'm-d-Y H:i:s';
		}
		else
		{
			$gmdate_string = 'd-m-Y H:i:s';
		}
		if ($_SESSION['SELL_action'] != 'edit')
		{
			if (empty($a_starts))
			{
				$TPL_start_date = date($gmdate_string, $system->ctime);
			}
			else
			{
				if (strpos($a_starts, '-') === false)
				{
					$a_starts = date($gmdate_string, $a_starts);
				}
				$TPL_start_date = $a_starts;
			}
		}
		else
		{
			$TPL_start_date = date($gmdate_string, $a_starts);
		}

		$CKEditor = new CKEditor();
		$CKEditor->basePath = $main_path . 'ckeditor/';
		$CKEditor->returnOutput = true;

		// build the fees javascript
		$fees = array( //0 = single value, 1 = staged fees
			'setup' => 1,
			'hpfeat_fee' => 0,
			'bolditem_fee' => 0,
			'hlitem_fee' => 0,
			'rp_fee' => 0,
			'picture_fee' => 0,
			'buyout_fee' => 0,
			'subtitle_fee' => 0,
			'relist_fee' => 0
			);
		$feevarsset = array();
		$fee_javascript = '';
		$relist_fee = $subtitle_fee = $fee_rp = $fee_bn = $fee_min_bid = 0;
		$query = "SELECT * FROM " . $DBPrefix . "fees ORDER BY type, fee_from ASC";
		$db->direct_query($query);
		while ($row = $db->fetch())
		{
			if (isset($fees[$row['type']]) && $fees[$row['type']] == 0)
				$fee_javascript .= 'var ' . $row['type'] . ' = ' . $row['value'] . ';' . "\n";
			if (isset($fees[$row['type']]) && $fees[$row['type']] == 1)
			{
				if (!isset($feevarsset[$row['type']]))
				{
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
			if ($minimum_bid >= $row['fee_from'] && $minimum_bid <= $row['fee_to'] && $row['type'] == 'setup')
			{
				if ($row['fee_type'] == 'flat')
				{
					$fee_min_bid = $row['value'];
				}
				else
				{
					$fee_min_bid = ($row['value'] / 100) * $minimum_bid;
				}
			}
			if ($row['type'] == 'buyout_fee' && $buy_now_price > 0)
			{
				$fee_bn = $row['value'];
			}
			if ($row['type'] == 'rp_fee' && $reserve_price > 0)
			{
				$fee_rp = $row['value'];
			}
			if ($row['type'] == 'subtitle_fee' && strlen($subtitle) > 0)
			{
				$subtitle_fee = $row['value'];
			}
			if ($row['type'] == 'relist_fee' && strlen($relist) > 0)
			{
				$relist_fee = $row['value'];
			}
		}
		$fee_javascript .= 'var current_fee = ' . ((isset($_SESSION['SELL_current_fee'])) ? $_SESSION['SELL_current_fee'] : '0') . ';';
		$relist_options = '<select name="autorelist" id="autorelist">';
		for ($i = 0; $i <= $system->SETTINGS['autorelist_max']; $i++)
		{
			$relist_options .= '<option value="' . $i . '"' . (($relist == $i) ? ' selected="selected"' : '') . '>' . $i . '</option>';
		}
		$relist_options .= '</select>';

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
				'AUC_TITLE' => $title,
				'AUC_SUBTITLE' => $subtitle,
				'AUC_DESCRIPTION' => $CKEditor->editor('sdescription', stripslashes($sdescription)),
				'ITEMQTY' => $iquantity,
				'MIN_BID' => $system->print_money_nosymbol($minimum_bid, false),
				'BN_ONLY' => ($buy_now_only == 'y') ? 'disabled' : '',
				'SHIPPING_COST' => $system->print_money_nosymbol($shipping_cost, false),
				'ADDITIONAL_SHIPPING_COST' => $system->print_money_nosymbol($additional_shipping_cost, false),
				'RESERVE_Y' => ($with_reserve == 'yes') ? 'checked' : '',
				'RESERVE_N' => ($with_reserve == 'yes') ? '' : 'checked',
				'RESERVE' => $system->print_money_nosymbol($reserve_price, false),
				'START_TIME' => $TPL_start_date,
				'BN_ONLY_Y' => ($buy_now_only == 'y') ? 'checked' : '',
				'BN_ONLY_N' => ($buy_now_only == 'y') ? '' : 'checked',
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
				'SHIPPING_TERMS' => $shipping_terms,
				'ITEMQTYD' => ($atype == 2 || $buy_now_only == 'y') ? '' : 'disabled',
				'START_NOW' => (!empty($start_now)) ? 'checked' : '',
				'IS_BOLD' => ($is_bold == 'y') ? 'checked' : '',
				'IS_HIGHLIGHTED' => ($is_highlighted == 'y') ? 'checked' : '',
				'IS_FEATURED' => ($is_featured == 'y') ? 'checked' : '',
				'NUMIMAGES' => count($_SESSION['UPLOADED_PICTURES']),
				'RELIST' => $relist_options,
				'MAXRELIST' => $system->SETTINGS['autorelist_max'],
				'TAX_Y' => ($is_taxed == 'y') ? 'checked' : '',
				'TAX_N' => ($is_taxed == 'n' ) ? 'checked' : '',
				'TAXINC_Y' => ($tax_included == 'y') ? 'checked' : '',
				'TAXINC_N' => ($tax_included == 'n') ? 'checked' : '',
				'MAXPICS' => sprintf($MSG['673'], $system->SETTINGS['maxpictures'], $system->SETTINGS['maxuploadsize']/1024),

				'FEE_VALUE' => get_fee($minimum_bid),
				'FEE_VALUE_F' => number_format(get_fee($minimum_bid), $system->SETTINGS['moneydecimals']),
				'FEE_MIN_BID' => $fee_min_bid,
				'FEE_BN' => $fee_bn,
				'FEE_RP' => $fee_rp,
				'FEE_SUBTITLE' => $subtitle_fee,
				'FEE_RELIST' => $relist_fee,
				'FEE_DECIMALS' => $system->SETTINGS['moneydecimals'],

				'B_CAN_TAX' => $can_tax,
				'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1),
				'B_BN_ONLY' => ($system->SETTINGS['buy_now'] == 2 && $system->SETTINGS['bn_only'] == 'y' && (($system->SETTINGS['bn_only_disable'] == 'y' && $user->user_data['bn_only'] == 'y') || $system->SETTINGS['bn_only_disable'] == 'n')),
				'B_BN' => ($system->SETTINGS['buy_now'] == 2),
				'B_EDITING' => ($_SESSION['SELL_action'] == 'edit'),
				// options,
				'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1),
				'B_EDIT_STARTTIME' => ($system->SETTINGS['edit_starttime'] == 1),
				'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y'),
				'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y'),
				'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y'),
				'B_FEES' => ($system->SETTINGS['fees'] == 'y'),
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
