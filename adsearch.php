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
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';

unset($ERR);

// set default variables
$page_title = $MSG['464'];
$catscontrol = new MPTTcategories();
$NOW = time();
$searching = false;
$userjoin = '';
$ora = '';
$wher = ''; // added to search query - defines what to search for
$asparams = array(); // the browse query parameters
$payment = (isset($_POST['payment'])) ? $_POST['payment'] : array();

// so paginations work
if (!empty($_POST))
{
	$_SESSION['advs'] = $_POST;
}
elseif (!isset($_GET['PAGE']) && empty($_POST))
{
	unset($_SESSION['advs']);
}

if (isset($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
}
else
{
	$PAGE = 1;
}

if (isset($_SESSION['advs']) && is_array($_SESSION['advs']))
{
	$searching = true;
	if (!empty($_SESSION['advs']['title']))
	{
		$wher .= '(';
		if (isset($_SESSION['advs']['desc']))
		{
			$wher .= "(au.description LIKE :likedescription) OR ";
			$asparams[] = array(':likedescription', '%' . $system->cleanvars($_SESSION['advs']['title']) . '%', 'str');
		}
		$wher .= "(au.title like :liketitle OR au.id = :idtitle)) AND ";
		$asparams[] = array(':idtitle', intval($_SESSION['advs']['title']), 'int');
		$asparams[] = array(':liketitle', '%' . $system->cleanvars($_SESSION['advs']['title']) . '%', 'str');
	}

	if (!empty($_SESSION['advs']['seller']))
	{
		$query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = :seller_nick";
		$params = array();
		$params[] = array(':seller_nick', $system->cleanvars($_SESSION['advs']['seller']), 'str');
		$db->query($query, $params);

		if ($db->numrows() > 0)
		{
			$SELLER_ID = $db->result('id');
			$wher .= "(au.user = :seller_id) AND ";
			$asparams[] = array(':seller_id', $SELLER_ID, 'int');
		}
		else
		{
			$ERR = $ERR_100;
		}
	}

	if (!empty($_SESSION['advs']['groups']))
	{
		$userjoin = "LEFT JOIN " . $DBPrefix . "users u ON (u.id = au.user)";
		$wher .= "(u.groups RLIKE :user_group) AND ";
			$asparams[] = array(':user_group', '[[:<:]]' . $system->cleanvars($_SESSION['advs']['groups']) . '[[:>:]]', 'str');
	}

	if (isset($_SESSION['advs']['buyitnow']))
	{
		$wher .= "(au.buy_now > 0 AND (au.bn_only = 1 OR au.bn_only = 0 && (au.num_bids = 0 OR (au.reserve_price > 0 AND au.current_bid < au.reserve_price)))) AND ";
	}

	if (isset($_SESSION['advs']['buyitnowonly']))
	{
		$wher .= "(au.bn_only = 1) AND ";
	}

	if (!empty($_SESSION['advs']['zipcode']))
	{
		$userjoin = "LEFT JOIN " . $DBPrefix . "users u ON (u.id = au.user)";
		$wher .= "(u.zip LIKE :user_zip) AND ";
		$asparams[] = array(':user_zip', $system->cleanvars($_SESSION['advs']['zipcode']), 'str');
	}

	if (!isset($_SESSION['advs']['closed']))
	{
		$wher .= "(au.closed = 0) AND ";
	}

	if (!empty($_SESSION['advs']['type']))
	{
		$wher .= "(au.auction_type = :auc_type) AND ";
		$asparams[] = array(':auc_type', $_SESSION['advs']['type'], 'int');
	}

	if (!empty($_SESSION['advs']['category']))
	{
		$query = "SELECT right_id, left_id FROM " . $DBPrefix . "categories WHERE cat_id = " . intval($_SESSION['advs']['category']);
		$params = array();
		$params[] = array(':cat_id', $_SESSION['advs']['category'], 'int');
		$db->query($query, $params);
		$parent_node = $db->result();
		$children = $catscontrol->get_children_list($parent_node['left_id'], $parent_node['right_id']);
		$childarray = array($_SESSION['advs']['category']);
		foreach ($children as $k => $v)
		{
			$childarray[] = $v['cat_id'];
		}
		$catalist = '(';
		$catalist .= implode(',', $childarray);
		$catalist .= ')';
		$wher .= "(au.category IN " . $catalist;
		if ($system->SETTINGS['extra_cat'] == 'y')
		{
			$wher .= " OR au.secondcat IN " . $catalist;
		}
		$wher .= ") AND ";
	}

	if (!empty($_SESSION['advs']['maxprice']))
	{
		$wher .= "(au.minimum_bid <= :max_price) AND ";
		$asparams[] = array(':max_price', $system->input_money($_SESSION['advs']['maxprice']), 'float');
	}
	if (!empty($_SESSION['advs']['minprice']))
	{
		$wher .= "(au.minimum_bid >= :min_price) AND ";
		$asparams[] = array(':min_price', $system->input_money($_SESSION['advs']['minprice']), 'float');
	}

	if (!empty($_SESSION['advs']['ending']) && ($_SESSION['advs']['ending'] == '1' || $_SESSION['advs']['ending'] == '2' || $_SESSION['advs']['ending'] == '4' || $_SESSION['advs']['ending'] == '6'))
	{
		$wher .= "(au.ends <= :auc_ending) AND ";
		$asparams[] = array(':auc_ending', time() + ($_SESSION['advs']['ending'] * 86400), 'int');
	}

	if (!empty($_SESSION['advs']['country']))
	{
		$userjoin = "LEFT JOIN " . $DBPrefix . "users u ON (u.id = au.user)";
		$wher .= "(u.country = :user_country) AND ";
		$asparams[] = array(':user_country', $system->cleanvars($_SESSION['advs']['country']), 'str');
	}

	if (isset($_SESSION['advs']['payment']))
	{
		if (is_array($_SESSION['advs']['payment']) && count($_SESSION['advs']['payment']) > 1)
		{
			$pri = false;
			$i = 0;
			foreach ($payment as $key => &$val)
			{
				if (!$pri)
				{
					$ora = "((au.payment LIKE :payment" . ($i) . ")";
					$asparams[] = array(":payment" . ($i), '%' . $system->cleanvars($val) . '%', 'str');
				}
				else
				{
					$ora .= " OR (au.payment LIKE :payment" . ($i) . ") AND ";
					$asparams[] = array(":payment" . ($i), '%' . $system->cleanvars($val) . '%', 'str');
				}
				$pri = true;
				$i++;
			}
			$ora .= ") ";
		}
		else
		{
			$ora = "(au.payment LIKE :payment) AND ";
			$asparams[] = array(':payment', '%' . $system->cleanvars($_SESSION['advs']['payment'][0]) . '%', 'str');
		}
	}

	if (isset($_SESSION['advs']['SortProperty']) && $_SESSION['advs']['SortProperty'] == 'starts')
	{
		$by = 'au.starts DESC';
	}
	elseif (isset($_SESSION['advs']['SortProperty']) && $_SESSION['advs']['SortProperty'] == 'min_bid')
	{
		$by = 'au.minimum_bid ASC';
	}
	elseif (isset($_SESSION['advs']['SortProperty']) && $_SESSION['advs']['SortProperty'] == 'max_bid')
	{
		$by = 'au.minimum_bid DESC';
	}
	else
	{
		$by = 'au.ends ASC';
	}
}

if ($searching && !isset($ERR))
{
	// retrieve records corresponding to passed page number
	if ($PAGE <= 0) $PAGE = 1;

	// determine limits for SQL query
	$left_limit = ($PAGE - 1) * $system->SETTINGS['perpage'];
	$asparams[] = array(':time', $NOW, 'int');

	// get total number of records
	$query = "SELECT count(*) AS total FROM " . $DBPrefix . "auctions au
			" . $userjoin . "
			WHERE au.suspended = 0
			AND " . $wher . $ora . "
			au.starts <= :time
			ORDER BY ". $by;
	$db->query($query, $asparams);
	$total = $db->result('total');

	// get number of pages
	$PAGES = intval($total / $system->SETTINGS['perpage']);
	if (($total % $system->SETTINGS['perpage']) > 0)
		++$PAGES;

	// get records corresponding to this page
	$query = "SELECT au.* FROM " . $DBPrefix . "auctions au
			" . $userjoin . "
			WHERE au.suspended = 0
			AND " . $wher . $ora . "
			au.starts <= :time
			ORDER BY " . $by . " LIMIT :offset, :perpage";
	$params = $asparams;
	$params[] = array(':offset', $left_limit, 'int');
	$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');

	// get featured items
	$query_feat = "SELECT au.* FROM " . $DBPrefix . "auctions au
			" . $userjoin . "
			WHERE au.suspended = 0
			AND " . $wher . $ora . "
			featured = 1
			AND	au.starts <= :time
			ORDER BY " . $by . " LIMIT :offset, 5";
	$params_feat = $asparams;
	$params_feat[] = array(':offset',(($PAGE - 1) * 5), 'int');

	if ($total > 0)
	{
		include INCLUDE_PATH . 'browseitems.inc.php';
		browseItems($query, $params, $query_feat, $params_feat, $total, 'adsearch.php');

		include 'header.php';
		$template->set_filenames(array(
				'body' => 'asearch_result.tpl'
				));
		$template->display('body');
		include 'footer.php';
		exit;
	}
	else
	{
		$ERR = $ERR_122;
	}
}

// payments
$payment_methods = '';
$query = "SELECT * FROM " . $DBPrefix . "payment_options";
$db->direct_query($query);
while ($payment_method = $db->fetch())
{
	if ($payment_method['gateway_active'] == 1 || $payment_method['is_gateway'] == 0)
	{
		$checked = (in_array($payment_method['name'], $payment)) ? 'checked' : '';
		$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $payment_method['name'] . '" ' . $checked . '> ' . $payment_method['displayname'] . '</p>';
	}
}

// category
$TPL_categories_list = '<select name="category">' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	$category = (isset($_SESSION['advs']['category'])) ? $_SESSION['advs']['category'] : '';
	foreach ($category_plain as $k => $v)
	{
		$TPL_categories_list .= "\t\t" . '<option value="' . $k . '" ' . (($k == $category) ? ' selected="true"' : '') . '>' . $v . '</option>' . "\n";
	}
}
$TPL_categories_list .= '</select>' . "\n";
// variant fields construction
$cattree = array();
// country
$TPL_countries_list = '<select name="country">' . "\n";

$query = "SELECT country_id, country FROM " . $DBPrefix . "countries";
$db->direct_query($query);
$countries = $db->fetchall();
$country = (isset($_SESSION['advs']['country'])) ? $_SESSION['advs']['country'] : '';
$TPL_countries_list .= "\t" . '<option value="">' . $MSG['any_country'] . '</option>' . "\n";
foreach($countries as $country)
{
	$TPL_countries_list .= "\t" . '<option value="' . $country['country'] . '"' . (($country['country'] == $country) ? ' selected="true"' : '') . '>' . $country['country'] . '</option>' . "\n";
}
$TPL_countries_list .= '</select>' . "\n";

// user groups
$TPL_user_group_list = '';
$user_group = (isset($_SESSION['advs']['groups'])) ? $_SESSION['advs']['groups'] : '';
$query = "SELECT id, group_name  FROM ". $DBPrefix . "groups";
$db->direct_query($query);
while ($row = $db->fetch())
{
	$TPL_user_group_list .= "\t" . '<option value="' . $row['id'] . '"' . (($row['id'] == $user_group) ? ' selected' : '') . '>' . $row['group_name'] . '</option>' . "\n";
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'CATEGORY_LIST' => $TPL_categories_list,
		'CURRENCY' => $system->SETTINGS['currency'],
		'PAYMENTS_LIST' => $payment_methods,
		'COUNTRY_LIST' => $TPL_countries_list,
		'USER_GROUP_LIST' => $TPL_user_group_list
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'advanced_search.tpl'
		));
$template->display('body');
include 'footer.php';
