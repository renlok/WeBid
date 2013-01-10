<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

define('InAdmin', 1);
$current_page = 'fees';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

// add or edit a value
if (isset($_POST['action']) && $_POST['action'] == 'add')
{
	$seller_countries = implode(' ', $_POST['seller_countries']);
	$buyer_countries = implode(' ', $_POST['buyer_countries']);
	if ($_POST['tax_id'] != '')
	{
		$query = "UPDATE " . $DBPrefix . "tax SET
				tax_name = '" . $system->cleanvars($_POST['tax_name']) . "',
				tax_rate = '" . $system->cleanvars($_POST['tax_rate']) . "',
				countries_seller = '" . $system->cleanvars($seller_countries) . "',
				countries_buyer = '" . $system->cleanvars($buyer_countries) . "'
				WHERE id = " . intval($_POST['tax_id']);
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
	}
	else
	{
		$query = "INSERT INTO " . $DBPrefix . "tax (tax_name, tax_rate, countries_seller, countries_buyer) VALUES
				('" . $system->cleanvars($_POST['tax_name']) . "', '" . $system->cleanvars($_POST['tax_rate']) . "', '" . $system->cleanvars($seller_countries) . "', '" . $system->cleanvars($buyer_countries) . "')";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
	}
}

// update site fee
if (isset($_POST['action']) && $_POST['action'] == 'sitefee')
{
	$query = "UPDATE " . $DBPrefix . "tax SET fee_tax = 0";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$query = "UPDATE " . $DBPrefix . "tax SET fee_tax = 1 WHERE id = " . $_POST['site_fee'];
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
}

$tax_seller_data = array();
$tax_buyer_data = array();
if (isset($_GET['type']) && $_GET['type'] == 'edit')
{
	$query = "SELECT * FROM " . $DBPrefix . "tax WHERE id = " . intval($_GET['id']);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$data = mysql_fetch_assoc($res);
	$tax_seller_data = explode(' ', $data['countries_seller']);
	$tax_buyer_data = explode(' ', $data['countries_buyer']);
}

if (isset($_GET['type']) && $_GET['type'] == 'delete')
{
	$query = "DELETE FROM " . $DBPrefix . "tax WHERE id = " . intval($_GET['id']);
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	header('location: tax_levels.php');
}

// get tax levels
$query = "SELECT * FROM " . $DBPrefix . "tax";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while($row = mysql_fetch_assoc($res))
{
	$template->assign_block_vars('tax_rates', array(
			'ID' => $row['id'],
			'TAX_NAME' => $row['tax_name'],
			'TAX_RATE' => floatval($row['tax_rate']),
			'TAX_SELLER' => $row['countries_seller'],
			'TAX_BUYER' => $row['countries_buyer'],
			'TAX_SITE_RATE' => $row['fee_tax']
			));
}

// get countries and make a list
$query = "SELECT * FROM " . $DBPrefix . "countries";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$tax_seller = '';
$tax_buyer = '';
while($row = mysql_fetch_assoc($res))
{
	if (in_array($row['country'], $tax_seller_data))
		$tax_seller .= '<option value="' . $row['country'] . '" selected="selected">' . $row['country'] . '</option>';
	else
		$tax_seller .= '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';
	if (in_array($row['country'], $tax_buyer_data))
		$tax_buyer .= '<option value="' . $row['country'] . '" selected="selected">' . $row['country'] . '</option>';
	else
		$tax_buyer .= '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';

}

$template->assign_vars(array(
		'SITEURL' => $system->SETTINGS['siteurl'],
		'ERROR' => (isset($errmsg)) ? $errmsg : '',
		'TAX_ID' => (isset($data['id'])) ? $data['id'] : '',
		'TAX_NAME' => (isset($data['tax_name'])) ? $data['tax_name'] : '',
		'TAX_RATE' => (isset($data['tax_rate'])) ? $data['tax_rate'] : '',
		'TAX_SELLER' => $tax_seller,
		'TAX_BUYER' => $tax_buyer
		));

$template->set_filenames(array(
		'body' => 'tax_levels.tpl'
		));
$template->display('body');
?>
