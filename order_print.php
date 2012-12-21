<?php 
/*************** AVTAR UPLOAD SCRIPT ******************************/
//By nay27uk
// License: Free
/***********************************************/
include 'common.php';

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	header('location: user_login.php');
	exit;
}

function getAddressseller($user_id) {

global $_SESSION, $system, $DBPrefix;
		$address_data = array();
		
		$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = '" . (int)$user_id . "'";
		$result = mysql_query($query);
		$system->check_mysql($result, $query, __LINE__, __FILE__);
		$result = mysql_fetch_array($result); 
	
		$address_data = array(
		//Just remove the  // to enable to show on page
				//'user_id'   => $result['id'],
				'nick'      => $result['nick'],
				//'name'      => $result['name'],
				//'company'   => (isset($result['company'])) ? $result['company'] : '',
				//'address'   => $result['address'],
				//'city'      => $result['city'],
				//'prov'      => $result['prov'],
				//'postcode'  => $result['zip'],
				//'country'   => $result['country'],
				//'email'     => $result['email'],
			);
			return $address_data;
}	
function getAddresswinner($user_id) {

global $_SESSION, $system, $DBPrefix;
		$address_data = array();
		
		$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = '" . (int)$user_id . "'";
		$result = mysql_query($query);
		$system->check_mysql($result, $query, __LINE__, __FILE__);
		$result = mysql_fetch_array($result); 
	//print_r($result);
		$address_data = array(
		       //Just remove the  // to enable to show on page
				//'user_id'   => $result['id'],
				//'nick'      => $result['nick'],
				'name'      => $result['name'],
				'company'   => (isset($result['company'])) ? $result['company'] : '',
				'address'   => $result['address'],
				'city'      => $result['city'],
				'prov'      => $result['prov'],
				'postcode'  => $result['zip'],
				'country'   => $result['country'],
				//'email'     => $result['email'],
			);
			return $address_data;
}	




$query = "SELECT w.id, w.winner, w.closingdate, a.id AS auctid, a.title, a.subtitle, a.shipping_cost, a.shipping,   w.bid, w.qty,	u.id As uid, u.rate_sum 
				FROM " . $DBPrefix . "auctions a
				LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
				LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)
				WHERE a.id = " . intval($_POST['pfval']) . " AND w.id = " . intval($_POST['pfwon']) ;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		// check its real
		if (mysql_num_rows($res) < 1)
		{
			header('location: outstanding.php');
			exit;
		}
		
        $data = mysql_fetch_assoc($res);
		$sendadd = '';
		$sender = getAddressseller(intval($data['uid']));
foreach($sender as $k => $v)
{
if ($v !== ''){
$sendadd .= "$v<br />";}
}       
        $winneradd = '';
        $winner = getAddresswinner(intval($_POST['user_id']));
		foreach($winner as $k => $v)
        {
        if ($v !== ''){
        $winneradd .= "$v<br />";}
        }
		$item_quantity = $data['qty'];
		$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];
		$sale = intval($_POST['pfwon']);
		$payvalue = ($data['shipping'] == 1) ? $data['shipping_cost'] + ($data['bid']* $data['qty']) : ($data['bid']* $data['qty']);
		$payvalueperitem = $data['bid'];
		$paysubtotal = ($data['bid']* $data['qty']);
		$shipping_cost = ($data['shipping'] == 1) ? $data['shipping_cost'] : '0';
//-----------rating	start	
include 'includes/' . 'membertypes.inc.php';
foreach ($membertypes as $idm => $memtypearr)
{$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;}
ksort($memtypesarr, SORT_NUMERIC);
$TPL_rate_ratio_value = '';
	foreach ($memtypesarr as $k => $l)
	{
		if ($k >= $data['rate_sum'] || $l++ == (count($memtypesarr) - 1))
		{
			$TPL_rate_ratio_value = "images/icons/" . $l['icon'] ."";
			break;
		}
	} 
//------------rating end	
//---------------------tax calculations start (experimental)
$vat = 20;
function vat($price,$vat=20) {
    $price_with_vat=0;
    $price_with_vat = $price + ($vat*($price/100));
    $price_with_vat = round($price_with_vat, 2);
    return $price_with_vat;
}
function vatexcluding($gross){

$nett = $gross/1.2;

return number_format($nett,2);
}

$data['shippingtaxable'] = 'n';
$potageinclvat = 0;

if ($data['shippingtaxable'] == 'y')
{
$potageinclvat = vat($shipping_cost);
$postagevat = $potageinclvat - $shipping_cost;
$postageexclvat = $shipping_cost;


} else { 
         $potageinclvat = $shipping_cost;
		 $postagevat =  0;
}
$totalvat = $payvalue / 6;
$vattotalinc = $totalvat - $postagevat;
$subtotal = $payvalue - $vattotalinc - $potageinclvat;
$totalinc = vat($subtotal);
$unitpriceincl = $totalinc / $data['qty'];
$unitexcl = $subtotal / $data['qty'];

//----------------------tax calculations end

$template->assign_vars(array(
		'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
         'LANGUAGE' => $language,
		 'SENDER' => $sendadd,
		 'WINNER' => $winneradd,
		 'AUCTION_TITLE' => strtoupper($title),
		 'AUCTION_ID' => $data['auctid'],
		 'RATE_SUM' => $data['rate_sum'],
		 'RATE_RATIO' => $TPL_rate_ratio_value,
		 'SHIPPING_METHOD' => "N/A",
		 'PAYMENT_METHOD' => "N/A",
		 'SALE_DATE' => "N/A",
		 'SUBTITLE' => $data['subtitle'],
		 'CLOSING_DATE' => ArrangeDateNoCorrection($data['closingdate']),
		 'INVOICE_DATE' => gmdate('d/m/Y', $data['closingdate'] + $system->tdiff),
		 'ITEM_QUANTITY' => $data['qty'],
		 'SALE_ID' => intval($_POST['pfwon']),
		 'BIDSINGLE' => $system->print_money($data['bid']),
		 // tax start
		 'TAX' => "20%",    
		 'UNIT_PRICE' => $system->print_money($unitexcl),
		 'UNIT_PRICE_WITH_TAX' => $system->print_money($unitpriceincl),
		 'TOTAL' => $system->print_money($subtotal),
		 'TOTAL_WITH_TAX' => $system->print_money($totalinc),
		 'SHIPPING_COST' => $system->print_money($shipping_cost),
		 'VAT_TOTAL' => $system->print_money($totalvat),
		 'TOTAL_SUM' => $system->print_money($payvalue),
		 // tax end
         'ORDERS' => 1,   //can link to an if statment or something to show else part in html

));

$template->set_filenames(array(
		'body' => 'order_invoice.tpl'
		));
$template->display('body');

  
?> 

