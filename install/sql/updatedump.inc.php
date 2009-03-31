<?php
//0.7.3 to 0.8.0
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `hash` VARCHAR(5) NOT NULL AFTER `password` ";
$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` ADD `hash` VARCHAR(5) NOT NULL AFTER `password` ";

//0.7.2 to 0.7.3
/*
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP `feetype`, DROP `sellersetupfee`, DROP `sellersetuptype`, DROP `sellerfinalfee`, DROP `sellerfinaltype`, DROP `sellersetupvalue`, DROP `sellerfinalvalue`, DROP `buyerfinalfee`, DROP `buyerfinaltype`, DROP `buyerfinalvalue`, DROP `paypaladdress`, DROP `picturesgalleryfee`, DROP `picturesgalleryvalue`, DROP `featureditemsnumber`, DROP `featuredcolumns`, DROP `thimbnailswidth`, DROP `catfeatureditemsnumber`, DROP `catthumbnailswidth`, DROP `reservefee`, DROP `reservetype`, DROP `reservevalue`, DROP `freecatstext`, DROP `sitemap`, DROP `wanted`";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `https` enum('y','n') NOT NULL default 'n'";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `bn_only_disable` enum('y','n') NOT NULL default 'n'";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `bn_only_percent` int(3) NOT NULL default '50'";
$query[] = "ALTER TABLE `" . $DBPrefix . "rates` DROP `rate`, DROP `sifra`";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "lastupdate`;";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `bn_only` enum('y','n') NOT NULL default 'y'";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` CHANGE `reg_date` `reg_date` INT(15) NOT NULL";
$query[] = "ALTER TABLE `" . $DBPrefix . "feedbacks` CHANGE `feedbackdate` `feedbackdate` INT(15) NOT NULL";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `buyerprivacy` ENUM( 'y', 'n' ) NOT NULL default 'n'";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `cust_increment` INT(1) NOT NULL DEFAULT '1'";
$query[] = "ALTER TABLE `" . $DBPrefix . "usersettings` ADD `displayed_feilds` VARCHAR(255) NOT NULL";
$query[] = "ALTER TABLE `" . $DBPrefix . "winners` CHANGE `closingdate` `closingdate` INT(15) NOT NULL";

//update times
$q = mysql_query("SELECT id, created, lastlogin FROM " . $DBPrefix . "adminusers") or die(mysql_error());
while ($a = mysql_fetch_assoc($q)){
	$t = gmmktime(0, 0, 0, substr($a['created'], 4, 2), substr($a['created'], 6, 2), substr($a['created'], 0, 4));
	$t2 = gmmktime(substr($a['lastlogin'], 8, 2), substr($a['lastlogin'], 10, 2), substr($a['lastlogin'], 12, 2), substr($a['lastlogin'], 4, 2), substr($a['lastlogin'], 6, 2), substr($a['lastlogin'], 0, 4));
	mysql_query("UPDATE " . $DBPrefix . "adminusers SET created = '" . $t . "', lastlogin = '" . $t2 . "' WHERE id = ".$a['id']);
}
$q = mysql_query("SELECT id, starts, ends FROM " . $DBPrefix . "auctions") or die(mysql_error());
while ($a = mysql_fetch_assoc($q)){
	$t = gmmktime(substr($a['starts'], 8, 2), substr($a['starts'], 10, 2), substr($a['starts'], 12, 2), substr($a['starts'], 4, 2), substr($a['starts'], 6, 2), substr($a['starts'], 0, 4));
	$t2 = gmmktime(substr($a['ends'], 8, 2), substr($a['ends'], 10, 2), substr($a['ends'], 12, 2), substr($a['ends'], 4, 2), substr($a['ends'], 6, 2), substr($a['ends'], 0, 4));
	mysql_query("UPDATE " . $DBPrefix . "auctions SET starts = '" . $t . "', ends  = '" . $t2 . "' WHERE id = ".$a['id']);
}
$q = mysql_query("SELECT id, bidwhen FROM " . $DBPrefix . "bids") or die(mysql_error());
while ($a = mysql_fetch_assoc($q)){
	$t = gmmktime(substr($a['bidwhen'], 8, 2), substr($a['bidwhen'], 10, 2), substr($a['bidwhen'], 12, 2), substr($a['bidwhen'], 4, 2), substr($a['bidwhen'], 6, 2), substr($a['bidwhen'], 0, 4));
	mysql_query("UPDATE " . $DBPrefix . "bids SET bidwhen = '" . $t . "' WHERE id = ".$a['id']);
}
$q = mysql_query("SELECT id, lastmessage FROM " . $DBPrefix . "community") or die(mysql_error());
while ($a = mysql_fetch_assoc($q)){
	$t = gmmktime(substr($a['lastmessage'], 8, 2), substr($a['lastmessage'], 10, 2), substr($a['lastmessage'], 12, 2), substr($a['lastmessage'], 4, 2), substr($a['lastmessage'], 6, 2), substr($a['lastmessage'], 0, 4));
	mysql_query("UPDATE " . $DBPrefix . "community SET lastmessage = '" . $t . "' WHERE id = ".$a['id']);
}
$q = mysql_query("SELECT id, msgdate FROM " . $DBPrefix . "comm_messages") or die(mysql_error());
while ($a = mysql_fetch_assoc($q)){
	$t = gmmktime(substr($a['msgdate'], 8, 2), substr($a['msgdate'], 10, 2), substr($a['msgdate'], 12, 2), substr($a['msgdate'], 4, 2), substr($a['msgdate'], 6, 2), substr($a['msgdate'], 0, 4));
	mysql_query("UPDATE " . $DBPrefix . "comm_messages SET msgdate = '" . $t . "' WHERE id = ".$a['id']);
}
$q = mysql_query("SELECT id, new_date FROM " . $DBPrefix . "news") or die(mysql_error());
while ($a = mysql_fetch_assoc($q)){
	$t = gmmktime(substr($a['new_date'], 8, 2), substr($a['new_date'], 10, 2), substr($a['new_date'], 12, 2), substr($a['new_date'], 4, 2), substr($a['new_date'], 6, 2), substr($a['new_date'], 0, 4));
	mysql_query("UPDATE " . $DBPrefix . "news SET new_date = '" . $t . "' WHERE id = ".$a['id']);
}
*/

//0.7.1 to 0.7.2
//$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `qty` INT( 11 ) NOT NULL DEFAULT '0'";
?>