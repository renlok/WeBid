<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $include_path . 'functions_rebuild.php';

unset($ERR);

if (isset($_POST['act']))
{
	// remove any countries that need to be
	if (isset($_POST['delete']) && count($_POST['delete']) > 0)
	{
		// we use a single SQL query to quickly do ALL our deletes
		$query = "DELETE FROM " . $DBPrefix . "countries WHERE ";
		$params = array();

		// if this is the first country being deleted it don't
		// precede it with an " or " in the SQL string
		for ($i = 0; $i < count($_POST['delete']); $i++)
		{
			if ($i > 0)
			{
				$query .= " OR ";
			}
			$query .= "country = :country";
			$params[] = array(':country', $system->cleanvars($_POST['delete'][$i], 'str');
		}
		$db->query($query, $params);
	}

	//update countries with new names
	for ($i = 0; $i < count($_POST['old_countries']); $i++)
	{
		if ($_POST['old_countries'][$i] != $_POST['new_countries'][$i])
		{
			$query = "UPDATE " . $DBPrefix . "countries SET
					country = :country_new
					WHERE country = :country_old";
			$params = array();
			$params[] = array(':country_new', $system->cleanvars($_POST['new_countries'][$i]), 'str');
			$params[] = array(':country_old', $system->cleanvars($_POST['old_countries'][$i]), 'str');
			$db->query($query, $params);
		}
	}

	// If a new country was added, insert it into database
	if (!empty($_POST['new_countries'][(count($_POST['new_countries']) - 1)]))
	{
		$query = "INSERT INTO " . $DBPrefix . "countries (country) VALUES (:country)";
		$params = array();
		$params[] = array(':country', $system->cleanvars($_POST['new_countries'][(count($_POST['new_countries']) - 1)]), 'str');
		$db->query($query, $params);
	}
	rebuild_html_file('countries');
	$ERR = $MSG['1028'];
}

include $main_path . 'language/' . $language . '/countries.inc.php';

foreach($countries as $country) {
    // check if the country is being used by a user
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE country = :country LIMIT 1";
	$params = array();
	$params[] = array(':country', $country, 'str');
	$db->query($query, $params);
	$USEDINUSERS = $db->numrows();
	
	$template->assign_block_vars('countries', array(
			'COUNTRY' => $country,
			'SELECTBOX' => ($USEDINUSERS == 0) ? '<input type="checkbox" name="delete[]" value="' . $country . '">' : '<img src="../images/nodelete.gif" alt="You cannot delete this">'
			));
}

$template->assign_vars(array(
		'ERROR' => isset($ERR) ? $ERR : ''
		));

$template->set_filenames(array(
		'body' => 'countries.tpl'
		));
$template->display('body');

?>
