<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit();
$NOW = time();

// Retrieve current counters
$query = "SELECT * FROM " . $DBPrefix . "counters";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$COUNTERS = mysql_fetch_array($res);
}

$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "users WHERE suspended = 0";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$USERS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE " . $DBPrefix . "counters set users=$USERS";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);

$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "users WHERE suspended <> 0";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$USERS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE " . $DBPrefix . "counters set inactiveusers = " . $USERS;
$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "auctions WHERE closed = 0 and suspended = 0 AND private = 'n' AND starts <= ".$NOW;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

$AUCTIONS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE " . $DBPrefix . "counters set auctions=$AUCTIONS";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);

$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "auctions WHERE closed<>0 AND private='n'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$AUCTIONS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE " . $DBPrefix . "counters set closedauctions=$AUCTIONS";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);

$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "auctions WHERE closed=0 and suspended<>0 AND private='n'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$AUCTIONS = mysql_result($res,0,"COUNTER");

#// Update counters table
$query = "UPDATE " . $DBPrefix . "counters set suspendedauction=$AUCTIONS";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);

$query = "SELECT a.id, a.auction, b.id
		  FROM " . $DBPrefix . "bids a, " . $DBPrefix . "auctions b
		  WHERE a.auction = b.id AND b.closed=0 AND b.suspended=0 AND private='n'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$BIDS = mysql_num_rows($res);

#// Update counters table
$query = "UPDATE " . $DBPrefix . "counters set bids=$BIDS";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);

@mysql_query("UPDATE " . $DBPrefix . "categories set counter=0, sub_counter=0");
$query = "SELECT cat_id, parent_id, sub_counter, counter FROM " . $DBPrefix . "categories ORDER BY cat_id";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res)) {
	$row['updated']=false;
	$categories[$row['cat_id']]=$row;
}

$query = "SELECT category FROM " . $DBPrefix . "auctions WHERE closed=0 AND suspended=0 AND starts<=".$NOW." AND private='n'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res))
{
	$cat_id = $row['category'];
	$root_cat = $cat_id;
	do {
		// update counter for this category
		$categories[$cat_id]['sub_counter']++;
		if ($cat_id == $root_cat)
		++$categories[$cat_id]['counter'];
		$categories[$cat_id]['updated']=true;
		$cat_id = $categories[$cat_id]['parent_id'];
	} while ($cat_id != 0 && isset($categories[$cat_id]));
}
if (count($categories) > 0){
	foreach ($categories as $cat_id=>$category) {
		if ($category['updated']) {
			$query = "UPDATE " . $DBPrefix . "categories SET
							counter=$category[counter],
							sub_counter=$category[sub_counter]
							WHERE cat_id=$cat_id";
			$res = mysql_query($query);
			$category['updated']=false;
		}
	}
}
@mysql_query("UPDATE " . $DBPrefix . "categories set counter=0, sub_counter=0");
$query = "SELECT cat_id, parent_id, sub_counter, counter FROM " . $DBPrefix . "categories ORDER BY cat_id";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res)) {
	$row['updated']=false;
	$categories[$row['cat_id']]=$row;
}
@mysql_query("UPDATE " . $DBPrefix . "categories set counter=0, sub_counter=0");
$query = "SELECT cat_id, parent_id, sub_counter, counter
			FROM " . $DBPrefix . "categories ORDER BY cat_id";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
while ($row = mysql_fetch_array($res)) {
	$row['updated']=false;
	$categories[$row['cat_id']]=$row;
}
$query = "SELECT category FROM " . $DBPrefix . "auctions WHERE closed=0 AND suspended=0 AND starts<=".$NOW." AND private='n'";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0){
	while ($row = mysql_fetch_array($res))
	{
		$cat_id = $row['category'];
		$root_cat = $cat_id;
		do {
			// update counter for this category
			$categories[$cat_id]['sub_counter']++;
			if ($cat_id == $root_cat)
			++$categories[$cat_id]['counter'];
			$categories[$cat_id]['updated']=true;
			$cat_id = $categories[$cat_id]['parent_id'];
		} while ($cat_id != 0 && isset($categories[$cat_id]));
	}
	foreach ($categories as $cat_id=>$category) {
		if ($category['updated']) {
			$query = "UPDATE " . $DBPrefix . "categories SET
							counter=$category[counter],
							sub_counter=$category[sub_counter]
							WHERE cat_id=$cat_id";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			$category['updated']=false;
		}
	}
}
?>