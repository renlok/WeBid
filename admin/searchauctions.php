<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
$current_page = 'auctions';
//include '../includes/common.inc.php';
include '../common.php';
include $include_path . 'functions_admin.php';
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';

unset($ERR);

// Get the posted variables if this is a new search.
if (isset($_POST['auctionid'])) { $_SESSION['searchauctionsauctionid'] = filter_input(INPUT_POST, 'auctionid', FILTER_SANITIZE_NUMBER_INT); }
$auction_sql = $_SESSION['searchauctionsauctionid'] > 0 ? " AND a.id = " . $_SESSION['searchauctionsauctionid'] : '';
if (isset($_POST['usernick'])) { $_SESSION['usernick'] = filter_input(INPUT_POST, 'usernick', FILTER_SANITIZE_STRING); }
$usernick_sql = $_SESSION['usernick'] != '' ? " AND u.nick = '" . $_SESSION['usernick'] . "'" : '';
if (isset($_POST['userid'])) { $_SESSION['searchauctionsuid'] = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT); }
$user_sql = $_SESSION['searchauctionsuid'] > 0 ? " AND a.user = " . $_SESSION['searchauctionsuid'] : '';
if (isset($_POST['titlekeywords'])) { $_SESSION['searchauctionstitlekeywords'] = filter_input(INPUT_POST, 'titlekeywords', FILTER_SANITIZE_STRING); }
$titlekeywords_sql = $_SESSION['searchauctionstitlekeywords'] != '' ? " AND INSTR(LCASE(a.title), '" . strtolower($_SESSION['searchauctionstitlekeywords']) . "') > 0" : '';
if (isset($_POST['auctiontype'])) { $_SESSION['searchauctionsauctiontype'] = filter_input(INPUT_POST, 'auctiontype', FILTER_SANITIZE_NUMBER_INT); }
switch ($_SESSION['searchauctionsauctiontype']) {
	case 1:	// open auctions
		$auctiontype_sql = "a.closed = 0";
	break;
	case 2: // closed auctions
		$auctiontype_sql = "a.closed = 1";
	break;
	case 3:	// suspended auctions
		$auctiontype_sql = "a.suspended != 0";
	break;
	default:			// all auctions
		$auctiontype_sql = "a.closed >= 0";
} 

// If a new search is posted, you need to unset $_SESSION['RETURN_LIST_OFFSET'] to get page 1.
if (isset($_POST['auctionid'])) {
	unset($_SESSION['RETURN_LIST_OFFSET']);
}

// Set offset and limit for pagination
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'searchauctions.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'searchauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(a.id) As auctions FROM " . $DBPrefix . "auctions a INNER JOIN " . $DBPrefix . "users u 
	ON (u.id = a.user) WHERE " . $auctiontype_sql . $auction_sql . $usernick_sql . $user_sql . $titlekeywords_sql;
$db->direct_query($query);
$num_auctions = $db->result('auctions');
$PAGES = ($num_auctions == 0) ? 1 : ceil($num_auctions / $system->SETTINGS['perpage']);

$query = "SELECT a.id, u.nick, a.title, a.starts, a.ends, a.suspended, c.cat_name FROM " . $DBPrefix . "auctions a
		INNER JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = a.category)
		WHERE " . $auctiontype_sql . $auction_sql . $usernick_sql . $user_sql . $titlekeywords_sql . 
		" ORDER BY nick, starts, title LIMIT " . $OFFSET . ", " . $system->SETTINGS['perpage'];
//echo $query;

$db->direct_query($query);
$bg = '';
while ($row = $db->fetch())
{
	$template->assign_block_vars('auctions', array(
			'SUSPENDED' => $row['suspended'],
			'ID' => $row['id'],
			'TITLE' => $row['title'],
			'START_TIME' => ArrangeDateNoCorrection($row['starts']),
			'END_TIME' => ArrangeDateNoCorrection($row['ends']),
			'USERNAME' => $row['nick'],
			'CATEGORY' => $row['cat_name'],
			'B_HASWINNERS' => false,
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'a7iGX46hGrT/searchauctions.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

// Set the HTML for the auction type radio buttons.
/*
	This creates an array of the values for the radio buttons for each option type to the language file names for each.
	0 = all auctions
	1 = open auctions (includes suspended)
	2 = closed auctions (includes suspended)
	3 = suspended auctions
*/
$types = array(0=>'619a', 1=>619, 2=>204, 3=>'2__0056');
foreach ($types as $key => $val) {
	if ($key == $_SESSION['searchauctionsauctiontype']) {
		$auctiontypeshtml .= '<input type="radio" name="auctiontype" value="' . $key . '" checked="checked"> ' . str_ireplace('auctions', '', $MSG[$val]) . ' ';
	} else {
		$auctiontypeshtml .= '<input type="radio" name="auctiontype" value="' . $key . '"> ' . str_ireplace('auctions', '', $MSG[$val]) . ' ';
	}
}

$template->assign_vars(array(
		'PAGE_TITLE' => $MSG['067a'],
		'NUM_AUCTIONS' => $num_auctions,
		'B_SEARCHUSER' => ($_SESSION['searchauctionsuid'] > 0 || $_SESSION['usernick'] != '') ? true : false,
		'USERNICK' => $_SESSION['usernick'], 
		'AUCTIONID' => $_SESSION['searchauctionsauctionid'], 
		'USERID' => $_SESSION['searchauctionsuid'], 
		'TITLEKEYWORDS' => $_SESSION['searchauctionstitlekeywords'], 
		'AUCTIONTYPE' => $auctiontypeshtml, 
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'a7iGX46hGrT/searchauctions.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'a7iGX46hGrT/searchauctions.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

$template->set_filenames(array(
		'body' => 'searchauctions.tpl'
		));
$template->display('body');
?>
