<?php 

include 'includes/common.inc.php';
include $main_path . 'language/' . $language . '/mods/packingslip.php';

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
	//print_r($result);
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


$sender = getAddressseller(intval($_POST['user_id']));
foreach($sender as $k => $v)
{
if ($v !== ''){
$sendadd .= "$v<br />";}
}

$query = "SELECT w.id, w.winner, w.closingdate, a.id AS auctid, a.title, a.subtitle, w.qty,	u.id As uid, u.rate_sum 
				FROM " . $DBPrefix . "auctions a
				LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)
				LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)
				WHERE a.id = " . intval($_POST['pfval']) . " AND w.id =". intval($_POST['pfwon']) ;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);

		// check its real
//		if (mysql_num_rows($res) < 1)
	//	{
	//		header('location: selling.php');
	//		exit;
	//	}
        $data = mysql_fetch_assoc($res);
        $winner = getAddresswinner(intval($data['winner']));
		foreach($winner as $k => $v)
        {
        if ($v !== ''){
        $winneradd .= "$v<br />";}
        }
		$item_quantity = $data['qty'];
		$title = $system->SETTINGS['sitename'] . ' - ' . $data['title'];
		$sale = intval($_POST['pfwon']);
//-----rating		
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
//----------rating end	
$template->assign_vars(array(
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
		 'PAYMENT' => $data['payment'],
		 'ITEM_QUANTITY' => $data['qty'],
		 'ORDERS' => 1,  //can link to an if statment or something to show else part in html

));



$template->set_filenames(array(
		'body' => 'order_packingslip.tpl'
		));
$template->display('body');

  
?> 

