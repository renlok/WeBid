<?php
function generate_id() {
	if(!isset($_SESSION['SELL_auction_id'])) {
		$auction_id = md5(uniqid(rand()));
		$_SESSION['SELL_auction_id'] = $auction_id;
	} else {
		$auction_id = $_SESSION['SELL_auction_id'];
	}
	return $auction_id;
}

function setvars(){
	global $with_reserve, $reserve_price, $minimum_bid, $pict_url, $imgtype, $title, $description, $pict_url, $atype, $adultonly, $iquantity, $buy_now, $buy_now_price, $duration, $relist, $increments, $customincrement, $shipping, $shipping_terms, $payment, $international, $sellcat, $private, $sendemail, $txt, $num, $buy_now_only, $a_starts, $shipping_cost;
	global $_POST, $_SESSION;
	
	$with_reserve = (isset($_POST['with_reserve'])) ? $_POST['with_reserve'] : $_SESSION['SELL_with_reserve'];
	$reserve_price = (isset($_POST['reserve_price'])) ? $_POST['reserve_price'] : $_SESSION['SELL_reserve_price'];
	$minimum_bid = (int)(isset($_POST['minimum_bid'])) ? $_POST['minimum_bid'] : $_SESSION['SELL_minimum_bid'];
	$minimum_bid = (empty($minimum_bid)) ? 0.99 : $minimum_bid;
	$shipping_cost = (int)(isset($_POST['shipping_cost'])) ? $_POST['shipping_cost'] : $_SESSION['SELL_shipping_cost'];
	$shipping_cost = (empty($shipping_cost)) ? 0 : $shipping_cost;
	$imgtype = (isset($_POST['imgtype'])) ? $_POST['imgtype'] : $_SESSION['SELL_file_uploaded'];
	$title = (isset($_POST['title'])) ? $_POST['title'] : $_SESSION['SELL_title'];
	$description = (isset($_POST['description'])) ? $_POST['description'] : $_SESSION['SELL_description'];
	$pict_url = (isset($_POST['pict_url'])) ? $_POST['pict_url'] : $_SESSION['SELL_pict_url'];
	$atype = (isset($_POST['atype'])) ? $_POST['atype'] : $_SESSION['SELL_atype'];
	$adultonly = (isset($_POST['adultonly'])) ? $_POST['adultonly'] : $_SESSION['SELL_adultonly'];
	$adultonly = (empty($adultonly)) ? 'n' : $adultonly;
	$iquantity = (int)(isset($_POST['iquantity'])) ? $_POST['iquantity'] : $_SESSION['SELL_iquantity'];
	$iquantity = (empty($iquantity)) ? 1 : round($iquantity);
	$buy_now = (isset($_POST['buy_now'])) ? $_POST['buy_now'] : $_SESSION['SELL_with_buy_now'];
	$buy_now_price = (isset($_POST['buy_now_price'])) ? $_POST['buy_now_price'] : $_SESSION['SELL_buy_now_price'];
	$duration = (isset($_POST['duration'])) ? $_POST['duration'] : $_SESSION['SELL_duration'];
	$relist = (isset($_POST['relist'])) ? $_POST['relist'] : $_SESSION['SELL_relist'];
	$increments = (isset($_POST['increments'])) ? $_POST['increments'] : $_SESSION['SELL_increments'];
	$customincrement = (isset($_POST['customincrement'])) ? $_POST['customincrement'] : $_SESSION['SELL_customincrement'];
	$shipping = (isset($_POST['shipping'])) ? $_POST['shipping'] : $_SESSION['SELL_shipping'];
	$shipping_terms = (isset($_POST['shipping_terms'])) ? $_POST['shipping_terms'] : $_SESSION['SELL_shipping_terms'];
	$payment = (isset($_POST['payment'])) ? $_POST['payment'] : $_SESSION['SELL_payment'];
	$payment = (is_array($payment)) ? $payment : array();
	$international = (isset($_POST['international'])) ? $_POST['international'] : $_SESSION['SELL_international'];
	$international = (!empty($international)) ? true : false;
	$sellcat = $_SESSION['SELL_sellcat'];
	$private = (isset($_POST['private'])) ? $_POST['private'] : $_SESSION['SELL_private'];
	if($private != 'y') $private = 'n';
	$sendemail = (isset($_POST['sendemail'])) ? $_POST['sendemail'] : $_SESSION['SELL_sendemail'];
	$buy_now_only = (isset($_POST['buy_now_only'])) ? $_POST['buy_now_only'] : $_SESSION['SELL_buy_now_only'];
	$buy_now_only = (empty($buy_now_only)) ? 'n' : $buy_now_only;
	$a_starts = (isset($_POST['a_starts'])) ? $_POST['a_starts'] : $_SESSION['SELL_starts'];
}

function makesessions(){
	global $with_reserve, $reserve_price, $minimum_bid, $pict_url, $imgtype, $title, $description, $pict_url, $atype, $adultonly, $iquantity, $buy_now, $buy_now_price, $duration, $relist, $increments, $customincrement, $shipping, $shipping_terms, $payment, $international, $sellcat, $private, $sendemail, $txt, $num, $buy_now_only, $a_starts, $shipping_cost, $_SESSION;
	
	$_SESSION['SELL_with_reserve'] = $with_reserve;
	$_SESSION['SELL_reserve_price'] = $reserve_price;
	$_SESSION['SELL_minimum_bid'] = $minimum_bid;
	$_SESSION['SELL_shipping_cost'] = $shipping_cost;
	$_SESSION['SELL_file_uploaded'] = $imgtype;
	$_SESSION['SELL_title'] = $title;
	$_SESSION['SELL_description'] = $description;
	$_SESSION['SELL_pict_url'] = $pict_url;
	$_SESSION['SELL_atype'] = $atype;
	$_SESSION['SELL_adultonly'] = $adultonly;
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
	$_SESSION['SELL_private'] = $private;
	$_SESSION['SELL_sendemail'] = $sendemail;
	$_SESSION['SELL_buy_now_only'] = $buy_now_only;
	$_SESSION['SELL_starts'] = $a_starts;
}

function unsetsessions(){
	global $_SESSION;
	
	$_SESSION['SELL_with_reserve'] = '';
	$_SESSION['SELL_reserve_price'] = '';
	$_SESSION['SELL_minimum_bid'] = 0.99;
	$_SESSION['SELL_shipping_cost'] = 0;
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
	$_SESSION['SELL_starts'] = '';
	$_SESSION['SELL_action'] = '';
}

function updateauction($type){
	global $_SESSION, $DBPrefix, $a_starts, $a_ends, $payment_text, $system;
	$extraquery = ($type == 2) ? 
		",relisted = relisted + 1,
		current_bid = 0,
		num_bids = 0" : '';
	$query =
		"UPDATE " . $DBPrefix . "auctions set
		title = '" . $system->cleanvars($_SESSION['SELL_title']) . "',
		starts = '" . $a_starts . "',
		description = '" . addslashes($_SESSION['SELL_description']) . "',
		pict_url = '" . $system->cleanvars($_SESSION['SELL_pict_url']) . "',
		category = " . $_SESSION['SELL_sellcat'] . ",
		minimum_bid = '" . $_SESSION['SELL_minimum_bid'] . "',
		shipping_cost = '" . $_SESSION['SELL_shipping_cost'] . "',
		reserve_price = '" . (($_SESSION['SELL_with_reserve'] == 'yes') ? $_SESSION['SELL_reserve_price'] : 0) . "',
		buy_now = '" . (($_SESSION['SELL_with_buy_now'] == 'yes') ? $_SESSION['SELL_buy_now_price'] : 0) . "',
		bn_only = '" . $_SESSION['SELL_buy_now_only'] . "',
		auction_type = '" . $_SESSION['SELL_atype'] . "',
		adultonly = '" . $_SESSION['SELL_adultonly'] . "',
		duration = '" . $_SESSION['SELL_duration'] . "',
		increment = " . floatval($_SESSION['SELL_customincrement']) . ",
		shipping = '" . $_SESSION['SELL_shipping'] . "',
		payment = '" . $payment_text . "',
		international = " . (($_SESSION['SELL_international']) ? 1 : 0) . ",
		ends = '" . $a_ends . "',
		photo_uploaded = " . (($_SESSION['SELL_file_uploaded'])? 1 : 0) . ",
		quantity = " . $_SESSION['SELL_iquantity'] . ",
		relist = " . intval($_SESSION['SELL_relist']) . ",
		private = 'n',
		shipping_terms = '" . $system->cleanvars($_SESSION['SELL_shipping_terms']) . "',
		closed = 0";
		$query .= $extraquery;
		$query .= " WHERE id = " . $_SESSION['SELL_auction_id'];
	return $query;
}

function addauction() {
	global $DBPrefix, $_SESSION, $userrec, $a_starts, $a_ends, $payment_text, $system;
	
	return "INSERT INTO " . $DBPrefix . "auctions VALUES (NULL, " . $userrec['id'] . ", '" . $system->cleanvars($_SESSION['SELL_title']) . "', '" .  $a_starts . "', '" . addslashes($_SESSION['SELL_description']) . "', '" . $system->cleanvars($_SESSION['SELL_pict_url']) . "', " . $_SESSION['SELL_sellcat'] . ", '" . $_SESSION['SELL_minimum_bid'] . "', '" . $_SESSION['SELL_shipping_cost'] . "', '" . (($_SESSION['SELL_with_reserve']=="yes")?$_SESSION['SELL_reserve_price']:"0") . "', '" . (($_SESSION['SELL_with_buy_now'] == 'yes') ? $_SESSION['SELL_buy_now_price'] : 0) . "', '" . $_SESSION['SELL_atype'] . "', '" . $_SESSION['SELL_duration'] . "', " . floatval($_SESSION['SELL_customincrement']) . ", '" . $_SESSION['SELL_shipping'] . "', '" . $payment_text . "', " . (($_SESSION['SELL_international']) ? 1 : 0) . ", '" . $a_ends . "', 0, 0, " . (($_SESSION['SELL_file_uploaded']) ? 1 : 0) . ", " . $_SESSION['SELL_iquantity'] . ", 0, 'n', " . intval($_SESSION['SELL_relist']) . ", 0, 0, 'n', '" . $system->cleanvars($_SESSION['SELL_shipping_terms']) . "', '" . $_SESSION['SELL_buy_now_only'] . "', '" . $_SESSION['SELL_adultonly'] . "')";
}
?>