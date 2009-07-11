<?php
//0.7.3/4 to 0.8.0
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `hash` VARCHAR(5) NOT NULL AFTER `password`, ADD `groups` text, DROP `accounttype`";
$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` ADD `hash` VARCHAR(5) NOT NULL AFTER `password` ";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fees`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "fees` (
  `id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `fee_from` double(16,4) NOT NULL ,
  `fee_to` double(6,4) NOT NULL ,
  `fee_type` enum('flat', 'perc') NOT NULL,
  `value` double(8,4) NOT NULL ,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ;";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'signup_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'setup');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'endauction');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hpfeat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'bolditem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hlitem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'rp_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'picture_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'relist_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyout_fee');";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `timecorrection` int(3) NOT NULL default '0';";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `emailtype` enum('html','text') NOT NULL default 'text';";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `paypal_email` varchar(255) default NULL";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `language` char(2) NOT NULL default ''";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `fees` enum('y','n') NOT NULL default 'n';";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "counters`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "counters` (
  `users` int(11) default '0',
  `inactiveusers` int(11) NOT NULL default '0',
  `auctions` int(11) default '0',
  `closedauctions` int(11) NOT NULL default '0',
  `bids` int(11) NOT NULL default '0',
  `suspendedauctions` int(11) NOT NULL default '0'
) ;";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES (0, 0, 0, 0, 0, 0);";
$query[] = "ALTER TABLE `" . $DBPrefix . "categories` ADD `left_id` INT(8) NOT NULL AFTER  `parent_id`,
			ADD `right_id` INT(8) NOT NULL AFTER `left_id`
			ADD `level` INT(1) NOT NULL AFTER `right_id`";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP `cookiesprefix`, ADD `copyright` varchar(255) NOT NULL default '' AFTER `siteurl`,
			ADD `privacypolicy` enum('y','n') NOT NULL default 'y' AFTER `termstext`, ADD `privacypolicytext` text NOT NULL AFTER `privacypolicy`,
			ADD `ae_status` enum('enabled','disabled') NOT NULL default 'disabled', ADD `ae_timebefore` int(11) NOT NULL default '120', ADD `ae_extend` int(11) NOT NULL default '300',
			ADD `cache_theme` enum('y','n') NOT NULL default 'y', ADD `hours_countdown` int(5) NOT NULL default '24', ADD `edit_starttime` int(1) NOT NULL default '1',
			ADD `banner_sizetype` enum('fix','any') NOT NULL default 'any', ADD `banner_width` int(11) NOT NULL default '468', ADD `banner_height` int(11) NOT NULL default '60',
			ADD `counter_auctions` enum('y','n') NOT NULL default 'y', ADD `counter_users` enum('y','n') NOT NULL default 'y', ADD `counter_online` enum('y','n') NOT NULL default 'y',
			ADD `banemail` text NOT NULL, ADD `mandatory_fields` varchar(255) NOT NULL default 'a:7:{s:9:\"birthdate\";s:1:\"y\";s:7:\"address\";s:1:\"y\";s:4:\"city\";s:1:\"y\";s:4:\"prov\";s:1:\"y\";s:7:\"country\";s:1:\"y\";s:3:\"zip\";s:1:\"y\";s:3:\"tel\";s:1:\"y\";}',
			ADD `displayed_feilds` VARCHAR(255) NOT NULL default 'a:7:{s:17:\"birthdate_regshow\";s:1:\"1\";s:15:\"address_regshow\";s:1:\"1\";s:12:\"city_regshow\";s:1:\"1\";s:12:\"prov_regshow\";s:1:\"1\";s:15:\"country_regshow\";s:1:\"1\";s:11:\"zip_regshow\";s:1:\"1\";s:11:\"tel_regshow\";s:1:\"1\";}'";
$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `ao_hpf_enabled` enum('y','n') NOT NULL default 'y', ADD `ao_hi_enabled` enum('y','n') NOT NULL default 'y',
			ADD `ao_bi_enabled` enum('y','n') NOT NULL default 'y', DROP `accounttype`";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "userslanguage`;";
$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `bold` enum('y','n') NOT NULL default 'n', ADD `highlighted` enum('y','n') NOT NULL default 'n',
			ADD `featured` enum('y','n') NOT NULL default 'n', DROP `adultonly`";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "gateways`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "gateways` (
  `gateways` text,
  `paypal_address` varchar(50) NOT NULL default '',
  `paypal_required` int(1) NOT NULL default '0',
  `paypal_active` int(1) NOT NULL default '0'
) ;";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('paypal', '', 0, 0);";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "groups`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "groups` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL default '',
  `can_sell` int(1) NOT NULL default '0',
  `can_buy` int(1) NOT NULL default '0',
  `count` int(15) NOT NULL default '0',
  `auto_join` int(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";
$query[] = "INSERT INTO `" . $DBPrefix . "groups` VALUES (NULL, 'Sellers', 1, 0, 0, 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "groups` VALUES (NULL, 'Buyers', 0, 1, 0, 1);";
$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `paid` int(1) NOT NULL default '0';";
$query[] = "ALTER TABLE `" . $DBPrefix . "messages` ADD `reply_of` INT(50) NOT NULL default '0', ADD `question` int(15) NOT NULL default '0', DROP `noticed`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "userfees` (
  `id` INT(15) NOT NULL AUTO_INCREMENT ,
  `auc_id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `amt` double(6,4) NOT NULL default '0',
  `paid` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";

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