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

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

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
			$query .= "country = :country" . $i;
			$params[] = array(':country' . $i, $_POST['delete'][$i], 'str');
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
			$params[] = array(':country_new', $_POST['new_countries'][$i], 'str');
			$params[] = array(':country_old', $_POST['old_countries'][$i], 'str');
			$db->query($query, $params);
		}
	}

	// If a new country was added, insert it into database
	if (!empty($_POST['new_countries'][(count($_POST['new_countries']) - 1)]))
	{
		$query = "INSERT INTO " . $DBPrefix . "countries (country) VALUES (:country)";
		$params = array();
		$params[] = array(':country', $_POST['new_countries'][(count($_POST['new_countries']) - 1)], 'str');
		$db->query($query, $params);
	}

	$template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['1028']));
}

$query = "SELECT country_id, c.country, count(u.id) AS user_count 
		FROM " . $DBPrefix . "countries c
		LEFT JOIN " . $DBPrefix . "users u ON (c.country = u.country)
		GROUP BY country_id, c.country";
$db->direct_query($query);
$countries = $db->fetchall();

foreach($countries as $country)
{
	$can_delete = true;
	if ($country['user_count'] != 0 || $country['country'] == $system->SETTINGS['defaultcountry']) {
		$can_delete = false;
	}

	$template->assign_block_vars('countries', array(
			'COUNTRY' => $country['country'],
			'SELECTBOX' => ($can_delete) ? '<input type="checkbox" name="delete[]" value="' . $country['country'] . '">' : '<img src="../images/nodelete.gif" alt="You cannot delete this">'
			));
}

include 'header.php';
$template->set_filenames(array(
		'body' => 'countries.tpl'
		));
$template->display('body');

include 'footer.php';
?>
