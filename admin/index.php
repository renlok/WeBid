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
$current_page = 'home';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include INCLUDE_PATH . 'config/timezones.php';
include 'loggedin.inc.php';

if (isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'clearcache':
			if (is_dir(MAIN_PATH . 'cache'))
			{
				$dir = opendir(MAIN_PATH . 'cache');
				while (($myfile = readdir($dir)) !== false)
				{
					if ($myfile != '.' && $myfile != '..' && $myfile != 'index.php')
					{
						unlink(CACHE_PATH . $myfile);
					}
				}
				closedir($dir);
			}
			$errmsg = $MSG['30_0033'];
		break;

		case 'updatecounters':
			//update users counter
			$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "users WHERE suspended = 0";
			$db->direct_query($query);
			$USERS = $db->result('COUNT');
			$query = "UPDATE " . $DBPrefix . "counters SET users = :USERS";
			$params = array();
			$params[] = array(':USERS', $USERS, 'int');
			$db->query($query, $params);

			//update suspended users counter
			$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "users WHERE suspended != 0";
			$db->direct_query($query);
			$USERS = $db->result('COUNT');
			$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = :USERS";
			$params = array();
			$params[] = array(':USERS', $USERS, 'int');
			$db->query($query, $params);

			//update auction counter
			$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE closed = 0 AND suspended = 0";
			$db->direct_query($query);
			$AUCTIONS = $db->result('COUNT');
			$query = "UPDATE " . $DBPrefix . "counters SET auctions = :AUCTIONS";
			$params = array();
			$params[] = array(':AUCTIONS', $AUCTIONS, 'int');
			$db->query($query, $params);

			//update closed auction counter
			$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE closed = 1";
			$db->direct_query($query);
			$AUCTIONS = $db->result('COUNT');
			$query = "UPDATE " . $DBPrefix . "counters SET closedauctions = :AUCTIONS";
			$params = array();
			$params[] = array(':AUCTIONS', $AUCTIONS, 'int');
			$db->query($query, $params);

			//update suspended auctions counter
			$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE closed = 0 and suspended != 0";
			$db->direct_query($query);
			$AUCTIONS = $db->result('COUNT');
			$query = "UPDATE " . $DBPrefix . "counters SET suspendedauctions = :AUCTIONS";
			$params = array();
			$params[] = array(':AUCTIONS', $AUCTIONS, 'int');
			$db->query($query, $params);

			//update bids
			$query = "SELECT COUNT(b.id) As COUNT FROM " . $DBPrefix . "bids b
					LEFT JOIN " . $DBPrefix . "auctions a ON (b.auction = a.id)
					WHERE a.closed = 0 AND a.suspended = 0";
			$db->direct_query($query);
			$BIDS = $db->result('COUNT');
			$query = "UPDATE " . $DBPrefix . "counters SET bids = :BIDS";
			$params = array();
			$params[] = array(':BIDS', $BIDS, 'int');
			$db->query($query, $params);

			// update categories
			$catscontrol = new MPTTcategories();
			$query = "UPDATE " . $DBPrefix . "categories set counter = 0, sub_counter = 0";
			$db->direct_query($query);

			$query = "SELECT COUNT(*) AS COUNT, category FROM " . $DBPrefix . "auctions
					WHERE closed = 0 AND starts <= :time AND suspended = 0 GROUP BY category";
			$params = array();
			$params[] = array(':time', time(), 'int');
			$db->query($query, $params);

			$cat_data = $db->fetchall();
			foreach ($cat_data as $row)
			{
				$row['COUNT'] = $row['COUNT'] * 1; // force it to be a number
				if ($row['COUNT'] > 0 && !empty($row['category'])) // avoid some errors
				{
					$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
					$params = array();
					$params[] = array(':cat_id', $row['category'], 'int');
					$db->query($query, $params);
					$parent_node = $db->result();

					$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
					for ($i = 0; $i < count($crumbs); $i++)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :COUNT WHERE cat_id = :cat_id";
						$params = array();
						$params[] = array(':COUNT', $row['COUNT'], 'int');
						$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
						$db->query($query, $params);
					}
					$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + :COUNT WHERE cat_id = :cat_id";
					$params = array();
					$params[] = array(':COUNT', $row['COUNT'], 'int');
					$params[] = array(':cat_id', $row['category'], 'int');
					$db->query($query, $params);
				}
			}

			if ($system->SETTINGS['extra_cat'] == 'y')
			{
				$query = "SELECT COUNT(*) AS COUNT, secondcat FROM " . $DBPrefix . "auctions
						WHERE closed = 0 AND starts <= :time AND suspended = 0 AND secondcat != 0 GROUP BY secondcat";
				$params = array();
				$params[] = array(':time', time(), 'int');
				$db->query($query, $params);

				$cat_data = $db->fetchall();
				foreach ($cat_data as $row)
				{
					$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";
					$params = array();
					$params[] = array(':cat_id', $row['secondcat'], 'int');
					$db->query($query, $params);
					$parent_node = $db->result();

					$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
					for ($i = 0; $i < count($crumbs); $i++)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :COUNT WHERE cat_id = :cat_id";
						$params = array();
						$params[] = array(':COUNT', $row['COUNT'], 'int');
						$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
						$db->query($query, $params);
					}
					$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + :COUNT WHERE cat_id = :cat_id";
					$params = array();
					$params[] = array(':COUNT', $row['COUNT'], 'int');
					$params[] = array(':cat_id', $row['secondcat'], 'int');
					$db->query($query, $params);
				}
			}

			$errmsg = $MSG['1029'];
		break;
	}
}

$query = "SELECT * FROM " . $DBPrefix . "counters";
$db->direct_query($query);
$COUNTERS = $db->result();

$query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE year = :year AND month = :month AND day = :day";
$params = array();
$params[] = array(':year', date('Y'), 'str');
$params[] = array(':month', date('m'), 'str');
$params[] = array(':day', date('d'), 'str');
$db->query($query, $params);
$ACCESS = $db->result();
$ACCESS['pageviews'] = (!isset($ACCESS['pageviews']) || empty($ACCESS['pageviews'])) ? 0 : $ACCESS['pageviews'];
$ACCESS['uniquevisitors'] = (!isset($ACCESS['uniquevisitors']) || empty($ACCESS['uniquevisitors'])) ? 0 : $ACCESS['uniquevisitors'];
$ACCESS['usersessions'] = (!isset($ACCESS['usersessions']) || empty($ACCESS['usersessions'])) ? 0 : $ACCESS['usersessions'];

if ($system->SETTINGS['activationtype'] == 0)
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users WHERE suspended = 10";
	$db->direct_query($query);
	$uuser_count = $db->result('COUNT');
}

// version check
if (!($realversion = load_file_from_url('http://www.webidsupport.com/version.txt')))
{
	$ERR = $ERR_25_0002;
	$realversion = 'Unknown';
}

$template->assign_vars(array(
		'ERROR' => (isset($errmsg)) ? $errmsg : '',
		'SITENAME' => $system->SETTINGS['sitename'],
		'ADMINMAIL' => $system->SETTINGS['adminmail'],
		'CRON' => ($system->SETTINGS['cron'] == 1) ? '<b>' . $MSG['373'] . '</b><br>' . $MSG['25_0027'] : '<b>' . $MSG['374'] . '</b>',
		'GALLERY' => ($system->SETTINGS['picturesgallery'] == 1) ? '<b>' . $MSG['2__0066'] . '</b><br>' . $MSG['666'] . ': ' . $system->SETTINGS['maxpictures'] . '<br>' . $MSG['671'] . ': ' . $system->SETTINGS['maxuploadsize']/1024 . ' KB' : '<b>' . $MSG['2__0067'] . '</b>',
		'BUY_NOW' => ($system->SETTINGS['buy_now'] == 1) ? '<b>' . $MSG['2__0067'] . '</b>' : '<b>' . $MSG['2__0066'] . '</b>',
		'CURRENCY' => $system->SETTINGS['currency'],
		'TIMEZONE' => $timezones[$system->SETTINGS['timezone']],
		'DATEFORMAT' => $system->SETTINGS['datesformat'],
		'DATEEXAMPLE' => ($system->SETTINGS['datesformat'] == 'USA') ? $MSG['382'] : $MSG['383'],
		'DEFULTCONTRY' => $system->SETTINGS['defaultcountry'],
		'USERCONF' => $system->SETTINGS['activationtype'],

		'C_USERS' => $COUNTERS['users'],
		'C_IUSERS' => $COUNTERS['inactiveusers'],
		'C_UUSERS' => (isset($uuser_count)) ? $uuser_count : '',
		'C_AUCTIONS' => $COUNTERS['auctions'],
		'C_CLOSED' => $COUNTERS['closedauctions'],
		'C_BIDS' => $COUNTERS['bids'],

		'A_PAGEVIEWS' => $ACCESS['pageviews'],
		'A_UVISITS' => $ACCESS['uniquevisitors'],
		'A_USESSIONS' => $ACCESS['usersessions'],

		'THIS_VERSION' => $system->SETTINGS['version'],
		'CUR_VERSION' => $realversion
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'home.tpl'
		));
$template->display('body');
include 'footer.php';
?>
