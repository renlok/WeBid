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

if ($installed_version == '0.8.0')
{
	//0.8.0 to 0.8.1
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `authnet_address` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `authnet_password` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `authnet_required` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `authnet_active` int(1) NOT NULL default '0';";
	$query[] = "INSERT INTO `" . $DBPrefix . "payments` VALUES (3, 'Authorize.net');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `authnet_id` varchar(50) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `authnet_pass` varchar(50) default '';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.1';";
	$new_version = '0.8.1';
}

if ($installed_version == '0.8.1')
{
	//0.8.1 to 0.8.2
	$query[] = "UPDATE `" . $DBPrefix . "gateways` SET gateways = 'paypal,authnet';";
	$query[] = "INSERT INTO `" . $DBPrefix . "fees` (value, type) VALUES (0, 'buyer_fee');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `bf_paid` INT(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `current_fee` double(16,4) default '0.00';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.2';";
	$new_version = '0.8.2';
}

if ($installed_version == '0.8.2')
{
	//0.8.2 to 0.8.3
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.3';";
	$new_version = '0.8.3';
}

if ($installed_version == '0.8.3')
{
	//0.8.3 to 0.8.4
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` ADD `fromemail` varchar(50) NOT NULL default '';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.4';";
	$new_version = '0.8.4';
}

if ($installed_version == '0.8.4')
{
	//0.8.4 to 0.8.5
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.5';";
	$new_version = '0.8.5';
}

if ($installed_version == '0.8.5' || $installed_version == '0.8.5 P1')
{
	//0.8.5 to 1.0.0
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP uniqueseller;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP pagewidth;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP alignment;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP pagewidthtype;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP background;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP brepeat;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP banner_sizetype;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP relisting;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `perpage` int(10) NOT NULL default '15';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `subtitle` ENUM('y','n') NOT NULL default 'y';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `extra_cat` ENUM('y','n') NOT NULL default 'n';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `mod_queue` ENUM('y','n') NOT NULL default 'n';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `thumb_list` INT( 6 ) NOT NULL default '120';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `https_url` varchar(255) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `payment_options` text NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `autorelist` ENUM('y','n') NOT NULL default 'y';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `autorelist_max` int(3) NOT NULL default '10';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `payment_options` = 'a:2:{i:0;s:13:\"Wire Transfer\";i:1;s:6:\"Cheque\";}'";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fontsandcolors`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "tmp_closed_edited`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currencies`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentdomains`;";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'endauc_fee');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `ff_paid` int(1) NOT NULL default '1'";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'subtitle_fee');";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'excat_fee');";
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `secondcat` int(11) default NULL AFTER `category`;";
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `subtitle` VARCHAR(70) NOT NULL AFTER `title`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "payments`;";
	$query[] = "UPDATE `" . $DBPrefix . "gateways` SET gateways = CONCAT(gateways, ',worldpay,moneybookers,toocheckout');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `worldpay_address` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `worldpay_required` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `worldpay_active` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `moneybookers_address` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `moneybookers_required` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `moneybookers_active` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `toocheckout_address` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `toocheckout_required` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `toocheckout_active` int(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `worldpay_id` varchar(50) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `moneybookers_email` varchar(50) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `toocheckout_id` varchar(50) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` CHANGE `auc_watch` `auc_watch` text;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "increments` ADD PRIMARY KEY (`id`) ;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "categories` ADD INDEX (`left_id`, `right_id`, `level`);";
	$query[] = "CREATE TABLE `" . $DBPrefix . "accounts` (
		`id` INT(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`nick` VARCHAR(20) NOT NULL,
		`name` TINYTEXT NOT NULL,
		`text` TEXT NOT NULL,
		`type` VARCHAR(15) NOT NULL,
		`paid_date` VARCHAR(16) NOT NULL,
		`amount` DOUBLE(6, 4) NOT NULL,
		`day` INT(3) NOT NULL,
		`week` INT(2) NOT NULL,
		`month` INT(2) NOT NULL,
		`year` INT(4) NOT NULL
	)";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.0'";
	$new_version = '1.0.0';
}

if ($installed_version == '1.0.0')
{
	//1.0.0 to 1.0.1
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.1';";
	$new_version = '1.0.1';
}

if ($installed_version == '1.0.1')
{
	//1.0.1 to 1.0.2
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.2';";
	$new_version = '1.0.2';
}

if ($installed_version == '1.0.2')
{
	//1.0.2 to 1.0.3
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `helpbox` int(1) NOT NULL default '1';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `hotitemsnumber` int(1) NOT NULL default '8';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP `higherbidsnumber`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP `showacceptancetext`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP `acceptancetext`;";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.3';";
	$new_version = '1.0.3';
}

if ($installed_version == '1.0.3')
{
	//1.0.3 to 1.0.4
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.4';";
	$new_version = '1.0.4';
}

if ($installed_version == '1.0.4')
{
	//1.0.4 to 1.0.5
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.5';";
	$new_version = '1.0.5';
}

if ($installed_version == '1.0.5')
{
	//1.0.5 to 1.0.6
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.6';";
	$new_version = '1.0.6';
}

if ($installed_version == '1.0.6')
{
	//1.0.6 to 1.1.0
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.1.0';";
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `tax` enum('y','n') NOT NULL default 'n' AFTER `current_fee`;";
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `taxinc` enum('y','n') NOT NULL default 'y' AFTER `tax`;";
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `shipping_cost_additional` double(16,2) default '0' AFTER `shipping_cost`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `current_bid` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `closed` int(1) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` MODIFY `ae_status` enum('y','n') NOT NULL default 'n';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `tax` enum('y','n') NOT NULL default 'n' AFTER `fee_disable_acc`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `taxuser` enum('y','n') NOT NULL default 'n' AFTER `tax`;"; // can the user tax his buyers
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `invoice_yellow_line` varchar(255) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `invoice_thankyou` varchar(255) NOT NULL default 'Thank you for shopping with us and we hope to see you return soon!';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` ADD `notes` text;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "userfees`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "useraccounts` (
		`useracc_id` int(11) NOT NULL AUTO_INCREMENT,
		`auc_id` int(11) NOT NULL default '0',
		`user_id` int(11) NOT NULL default '0',
		`date` int(11) NOT NULL default '0',
		`setup` double(8,2) NOT NULL default '0',
		`featured` double(8,2) NOT NULL default '0',
		`bold` double(8,2) NOT NULL default '0',
		`highlighted` double(8,2) NOT NULL default '0',
		`subtitle` double(8,2) NOT NULL default '0',
		`relist` double(8,2) NOT NULL default '0',
		`reserve` double(8,2) NOT NULL default '0',
		`buynow` double(8,2) NOT NULL default '0',
		`image` double(8,2) NOT NULL default '0',
		`extcat` double(8,2) NOT NULL default '0',
		`signup` double(8,2) NOT NULL default '0',
		`buyer` double(8,2) NOT NULL default '0',
		`finalval` double(8,2) NOT NULL default '0',
		`balance` double(8,2) NOT NULL default '0',
		`total` double(8,2) NOT NULL,
		`paid` int(1) NOT NULL default '0',
		PRIMARY KEY (`useracc_id`)
	);";
	$query[] = "CREATE TABLE `" . $DBPrefix . "tax` (
		`id` INT(2) NOT NULL AUTO_INCREMENT,
		`tax_name` VARCHAR(30) NOT NULL ,
		`tax_rate` DOUBLE(16, 2) NOT NULL ,
		`countries_seller` TEXT NOT NULL ,
		`countries_buyer` TEXT NOT NULL ,
		`fee_tax` INT(1) NOT NULL DEFAULT  '0',
		PRIMARY KEY (`id`)
	);";
	$query[] = "INSERT INTO `" . $DBPrefix . "tax` VALUES (NULL, 'Site Fees', '0', '', '', '1');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` DROP `winner_address`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `users_email` enum('y','n') NOT NULL default 'y';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "membertypes` DROP `membertype`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "membertypes` DROP `discount`;";
	$query[] = "CREATE TABLE  `" . $DBPrefix . "logs` (
		`id` INT( 25 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`type` VARCHAR( 5 ) NOT NULL ,
		`message` TEXT NOT NULL ,
		`action_id` INT( 11 ) NOT NULL DEFAULT  '0',
		`user_id` INT( 32 ) NOT NULL DEFAULT  '0',
		`ip` VARCHAR( 45 ) NOT NULL,
		`timestamp` INT( 11 ) NOT NULL DEFAULT  '0'
	);";


	$query[] = "ALTER TABLE `" . $DBPrefix . "accounts` MODIFY `amount` DOUBLE(6,2) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `minimum_bid` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `shipping_cost` double(16,2) default NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `shipping_cost_additional` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `reserve_price` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `buy_now` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `increment` double(8,2) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `current_fee` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "bids` MODIFY `bid` double(16,2) default NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "fees` MODIFY `fee_from` double(16,2) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "fees` MODIFY `fee_to` double(16,2) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "fees` MODIFY `value` double(8,2) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "increments` MODIFY `low` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "increments` MODIFY `high` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "increments` MODIFY `increment` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "proxybid` MODIFY `bid` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` MODIFY `fee_max_debt` double(16,2) NOT NULL default '25.00';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` MODIFY `fee_signup_bonus` double(16,2) NOT NULL default '0.00';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `balance` double(16,2) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` MODIFY `bid` double(16,2) NOT NULL default '0';";
	$new_version = '1.1.0';
}

if (in_array($installed_version, array('1.1.0', '1.1.1', '1.1.2', '1.1.2P1', '1.1.2P2')))
{
	//1.1.0 to 1.2.0
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `password` varchar(60) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `password` varchar(60) NOT NULL;";
	$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Serbia');";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "closedrelisted`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `shipping_terms` tinytext;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `shipped` INT(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `cookiespolicy` enum('y','n') NOT NULL default 'y';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `cookiespolicytext` text NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `mail_protocol` VARCHAR(128) NOT NULL DEFAULT 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `mail_parameter` VARCHAR(128) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `smtp_authentication`  enum('y', 'n') NOT NULL DEFAULT 'n';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `smtp_security` enum('none', 'tls', 'ssl') NOT NULL DEFAULT 'none';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `smtp_port`  VARCHAR(128) NOT NULL DEFAULT 25;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `smtp_host` VARCHAR(128) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `smtp_username`  VARCHAR(128) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `smtp_password`  VARCHAR(128) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `alert_emails`  VARCHAR(128) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` CHANGE `timecorrection` `timezone` varchar(50) NOT NULL default 'Europe/London';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` CHANGE `timecorrection` `timezone` varchar(50) NOT NULL default 'Europe/London';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "countries` ADD `country_id` int(4) NOT NULL auto_increment;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `paypal_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `authnet_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `worldpay_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `checkout_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `moneybookers_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `initial_quantity` int(11) default 1;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `bn_sale` int(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "currentbrowsers` MODIFY `browser` varchar(255) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` CHANGE `worldpay_address` `worldpay_id` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` CHANGE `toocheckout_address` `toocheckout_id` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `current_bid_id` int(11) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `auc_title` varchar(70);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `auc_shipping_cost` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `auc_payment` tinytext;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `auction_type` int(2);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `international` tinyint(1);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY  `closed` tinyint(1);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `gateways` INT(1) default 'a:5:{s:6:\"paypal\";s:6:\"PayPal\";s:7:\"authnet\";s:13:\"Authorize.net\";s:8:\"worldpay\";s:8:\"WorldPay\";s:12:\"moneybookers\";s:12:\"Moneybookers\";s:11:\"toocheckout\";s:9:\"2Checkout\";}';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `status` tinyint(1) NOT NULL default '1';";
	$query[] = "UPDATE `" . $DBPrefix . "adminusers` SET status = 0 WHERE status = 2;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "community` MODIFY `active` tinyint(1) NOT NULL default '1';";
	$query[] = "UPDATE `" . $DBPrefix . "community` SET active = 0 WHERE active = 2;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "maintainance` MODIFY `active` tinyint(1) NOT NULL default '0';";
	$query[] = "UPDATE `" . $DBPrefix . "auctions` SET theme = IF (theme = 'default', 'classic', theme);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auction_types`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "auction_types` (
	  `id` int(2) NOT NULL auto_increment,
	  `key` varchar(32),
	  `language_string` varchar(32),
	  PRIMARY KEY  (`id`),
	  KEY `id` (`id`)
	);";
	$query[] = "INSERT INTO `" . $DBPrefix . "auction_types` VALUES(1, 'standard', 1021);";
	$query[] = "INSERT INTO `" . $DBPrefix . "auction_types` VALUES(2, 'dutch', 1020);";
	// add translation tables
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "categories_translated`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "categories_translated` (
		`cat_id` int(4) NOT NULL,
		`lang` char(2) NOT NULL default '',
		`category` varchar(200) NOT NULL default ''
	);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "community_translated`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "community_translated` (
		`id` int(4) NOT NULL,
		`lang` char(2) NOT NULL default '',
		`name` varchar(255) NOT NULL default ''
	);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "countries_translated`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "countries_translated` (
		`country_id` int(4) NOT NULL,
		`lang` char(2) NOT NULL default '',
		`country` varchar(255) NOT NULL default ''
	);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "durations_translated`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "durations_translated` (
		`country_id` int(4) NOT NULL,
		`lang` char(2) NOT NULL default '',
		`description` varchar(255) NOT NULL default ''
	);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "groups_translated`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "groups_translated` (
		`id` int(5) NOT NULL,
		`lang` char(2) NOT NULL default '',
		`group_name` varchar(255) NOT NULL default ''
	);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settingsv2`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "settingsv2` (
		`fieldname` VARCHAR(30) NOT NULL,
		`fieldtype` VARCHAR(10) NOT NULL,
		`value` text NOT NULL,
		`modifieddate` INT(11) NOT NULL,
		`modifiedby` INT(32) NOT NULL,
		PRIMARY KEY(`fieldname`)
		)";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "payment_options`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "payment_options` (
	  `id` int(5) NOT NULL AUTO_INCREMENT,
	  `name` varchar(50) NOT NULL default '',
	  `displayname` varchar(50) NOT NULL default '',
	  `is_gateway` tinyint(1) NOT NULL default '0',
	  `gateway_admin_address` varchar(50) NOT NULL default '',
	  `gateway_admin_password` varchar(50) NOT NULL default '',
	  `gateway_required` tinyint(1) NOT NULL default '0',
	  `gateway_active` tinyint(1) NOT NULL default '0',
	  PRIMARY KEY(`id`)
	) ;";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('banktransfer', 'Bank Transfer', 0);";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('cheque', 'Cheque', 0);";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('paypal', 'PayPal', 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('authnet', 'Authorize.net', 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('worldpay', 'WorldPay', 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('moneybookers', 'Moneybookers', 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('toocheckout', '2Checkout', 1);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "usergateways`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "usergateways` (
	  `id` int(5) NOT NULL AUTO_INCREMENT,
	  `gateway_id` int(5) NOT NULL,
	  `user_id` int(11) NOT NULL,
	  `address` varchar(50) NOT NULL default '',
	  `password` varchar(50) NOT NULL default '',
	  PRIMARY KEY(`id`)
	) ;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "gateways`;";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('bidding_visable_to_guest', 'bool', '1', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('email_admin_on_signup', 'bool', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('user_request_seller_permission', 'bool', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_blocked_email_enabled', 'bool', '1', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('spam_blocked_email_domains', 'str', \"0-mail.com\n0815.ru\n0clickemail.com\n0wnd.net\n0wnd.org\n10minutemail.com\n20minutemail.com\n2prong.com\n30minutemail.com\n3d-painting.com\n4warding.com\n4warding.net\n4warding.org\n60minutemail.com\n675hosting.com\n675hosting.net\n675hosting.org\n6url.com\n75hosting.com\n75hosting.net\n75hosting.org\n7tags.com\n9ox.net\na-bc.net\nafrobacon.com\najaxapp.net\namilegit.com\namiri.net\namiriindustries.com\nanonbox.net\nanonymbox.com\nantichef.com\nantichef.net\nantispam.de\nbaxomale.ht.cx\nbeefmilk.com\nbinkmail.com\nbio-muesli.net\nbobmail.info\nbodhi.lawlita.com\nbofthew.com\nbrefmail.com\nbroadbandninja.com\nbsnow.net\nbugmenot.com\nbumpymail.com\ncasualdx.com\ncentermail.com\ncentermail.net\nchogmail.com\nchoicemail1.com\ncool.fr.nf\ncorreo.blogos.net\ncosmorph.com\ncourriel.fr.nf\ncourrieltemporaire.com\ncubiclink.com\ncurryworld.de\ncust.in\ndacoolest.com\ndandikmail.com\ndayrep.com\ndeadaddress.com\ndeadspam.com\ndespam.it\ndespammed.com\ndevnullmail.com\ndfgh.net\ndigitalsanctuary.com\ndiscardmail.com\ndiscardmail.de\nDisposableemailaddresses:emailmiser.com\ndisposableaddress.com\ndisposeamail.com\ndisposemail.com\ndispostable.com\ndm.w3internet.co.ukexample.com\ndodgeit.com\ndodgit.com\ndodgit.org\ndonemail.ru\ndontreg.com\ndontsendmespam.de\ndump-email.info\ndumpandjunk.com\ndumpmail.de\ndumpyemail.com\ne4ward.com\nemail60.com\nemaildienst.de\nemailias.com\nemailigo.de\nemailinfive.com\nemailmiser.com\nemailsensei.com\nemailtemporario.com.br\nemailto.de\nemailwarden.com\nemailx.at.hm\nemailxfer.com\nemz.net\nenterto.com\nephemail.net\netranquil.com\netranquil.net\netranquil.org\nexplodemail.com\nfakeinbox.com\nfakeinformation.com\nfastacura.com\nfastchevy.com\nfastchrysler.com\nfastkawasaki.com\nfastmazda.com\nfastmitsubishi.com\nfastnissan.com\nfastsubaru.com\nfastsuzuki.com\nfasttoyota.com\nfastyamaha.com\nfilzmail.com\nfizmail.com\nfr33mail.info\nfrapmail.com\nfront14.org\nfux0ringduh.com\ngarliclife.com\nget1mail.com\nget2mail.fr\ngetonemail.com\ngetonemail.net\nghosttexter.de\ngirlsundertheinfluence.com\ngishpuppy.com\ngowikibooks.com\ngowikicampus.com\ngowikicars.com\ngowikifilms.com\ngowikigames.com\ngowikimusic.com\ngowikinetwork.com\ngowikitravel.com\ngowikitv.com\ngreat-host.in\ngreensloth.com\ngsrv.co.uk\nguerillamail.biz\nguerillamail.com\nguerillamail.net\nguerillamail.org\nguerrillamail.biz\nguerrillamail.com\nguerrillamail.de\nguerrillamail.net\nguerrillamail.org\nguerrillamailblock.com\nh.mintemail.com\nh8s.org\nhaltospam.com\nhatespam.org\nhidemail.de\nhochsitze.com\nhotpop.com\nhulapla.de\nieatspam.eu\nieatspam.info\nihateyoualot.info\niheartspam.org\nimails.info\ninboxclean.com\ninboxclean.org\nincognitomail.com\nincognitomail.net\nincognitomail.org\ninsorg-mail.info\nipoo.org\nirish2me.com\niwi.net\njetable.com\njetable.fr.nf\njetable.net\njetable.org\njnxjn.com\njunk1e.com\nkasmail.com\nkaspop.com\nkeepmymail.com\nkillmail.com\nkillmail.net\nkir.ch.tc\nklassmaster.com\nklassmaster.net\nklzlk.com\nkulturbetrieb.info\nkurzepost.de\nletthemeatspam.com\nlhsdv.com\nlifebyfood.com\nlink2mail.net\nlitedrop.com\nlol.ovpn.to\nlookugly.com\nlopl.co.cc\nlortemail.dk\nlr78.com\nm4ilweb.info\nmaboard.com\nmail-temporaire.fr\nmail.by\nmail.mezimages.net\nmail2rss.org\nmail333.com\nmail4trash.com\nmailbidon.com\nmailblocks.com\nmailcatch.com\nmaileater.com\nmailexpire.com\nmailfreeonline.com\nmailin8r.com\nmailinater.com\nmailinator.com\nmailinator.net\nmailinator2.com\nmailincubator.com\nmailme.ir\nmailme.lv\nmailmetrash.com\nmailmoat.com\nmailnator.com\nmailnesia.com\nmailnull.com\nmailshell.com\nmailsiphon.com\nmailslite.com\nmailzilla.com\nmailzilla.org\nmbx.cc\nmega.zik.dj\nmeinspamschutz.de\nmeltmail.com\nmessagebeamer.de\nmierdamail.com\nmintemail.com\nmoburl.com\nmoncourrier.fr.nf\nmonemail.fr.nf\nmonmail.fr.nf\nmsa.minsmail.com\nmt2009.com\nmx0.wwwnew.eu\nmycleaninbox.net\nmypartyclip.de\nmyphantomemail.com\nmyspaceinc.com\nmyspaceinc.net\nmyspaceinc.org\nmyspacepimpedup.com\nmyspamless.com\nmytrashmail.com\nneomailbox.com\nnepwk.com\nnervmich.net\nnervtmich.net\nnetmails.com\nnetmails.net\nnetzidiot.de\nneverbox.com\nno-spam.ws\nnobulk.com\nnoclickemail.com\nnogmailspam.info\nnomail.xl.cx\nnomail2me.com\nnomorespamemails.com\nnospam.ze.tc\nnospam4.us\nnospamfor.us\nnospamthanks.info\nnotmailinator.com\nnowmymail.com\nnurfuerspam.de\nnus.edu.sg\nnwldx.com\nobjectmail.com\nobobbo.com\noneoffemail.com\nonewaymail.com\nonline.ms\noopi.org\nordinaryamerican.net\notherinbox.com\nourklips.com\noutlawspam.com\novpn.to\nowlpic.com\npancakemail.com\npimpedupmyspace.com\npjjkp.com\npolitikerclub.de\npoofy.org\npookmail.com\nprivacy.net\nproxymail.eu\nprtnx.com\npunkass.com\nPutThisInYourSpamDatabase.com\nqq.com\nquickinbox.com\nrcpt.at\nrecode.me\nrecursor.net\nregbypass.com\nregbypass.comsafe-mail.net\nrejectmail.com\nrklips.com\nrmqkr.net\nrppkn.com\nrtrtr.com\ns0ny.net\nsafe-mail.net\nsafersignup.de\nsafetymail.info\nsafetypost.de\nsandelf.de\nsaynotospams.com\nselfdestructingmail.com\nSendSpamHere.com\nsharklasers.com\nshiftmail.com\nshitmail.me\nshortmail.net\nsibmail.com\nskeefmail.com\nslaskpost.se\nslopsbox.com\nsmellfear.com\nsnakemail.com\nsneakemail.com\nsofimail.com\nsofort-mail.de\nsogetthis.com\nsoodonims.com\nspam.la\nspam.su\nspamavert.com\nspambob.com\nspambob.net\nspambob.org\nspambog.com\nspambog.de\nspambog.ru\nspambox.info\nspambox.irishspringrealty.com\nspambox.us\nspamcannon.com\nspamcannon.net\nspamcero.com\nspamcon.org\nspamcorptastic.com\nspamcowboy.com\nspamcowboy.net\nspamcowboy.org\nspamday.com\nspamex.com\nspamfree24.com\nspamfree24.de\nspamfree24.eu\nspamfree24.info\nspamfree24.net\nspamfree24.org\nspamgourmet.com\nspamgourmet.net\nspamgourmet.org\nSpamHereLots.com\nSpamHerePlease.com\nspamhole.com\nspamify.com\nspaminator.de\nspamkill.info\nspaml.com\nspaml.de\nspammotel.com\nspamobox.com\nspamoff.de\nspamslicer.com\nspamspot.com\nspamthis.co.uk\nspamthisplease.com\nspamtrail.com\nspeed.1s.fr\nsupergreatmail.com\nsupermailer.jp\nsuremail.info\nteewars.org\nteleworm.com\ntempalias.com\ntempe-mail.com\ntempemail.biz\ntempemail.com\nTempEMail.net\ntempinbox.co.uk\ntempinbox.com\ntempmail.it\ntempmail2.com\ntempomail.fr\ntemporarily.de\ntemporarioemail.com.br\ntemporaryemail.net\ntemporaryforwarding.com\ntemporaryinbox.com\nthanksnospam.info\nthankyou2010.com\nthisisnotmyrealemail.com\nthrowawayemailaddress.com\ntilien.com\ntmailinator.com\ntradermail.info\ntrash-amil.com\ntrash-mail.at\ntrash-mail.com\ntrash-mail.de\ntrash2009.com\ntrashemail.de\ntrashmail.at\ntrashmail.com\ntrashmail.de\ntrashmail.me\ntrashmail.net\ntrashmail.org\ntrashmail.ws\ntrashmailer.com\ntrashymail.com\ntrashymail.net\ntrillianpro.com\nturual.com\ntwinmail.de\ntyldd.com\nuggsrock.com\nupliftnow.com\nuplipht.com\nvenompen.com\nveryrealemail.com\nviditag.com\nviewcastmedia.com\nviewcastmedia.net\nviewcastmedia.org\nwebm4il.info\nwegwerfadresse.de\nwegwerfemail.de\nwegwerfmail.de\nwegwerfmail.net\nwegwerfmail.org\nwetrainbayarea.com\nwetrainbayarea.org\nwh4f.org\nwhyspam.me\nwillselfdestruct.com\nwinemaven.info\nwronghead.com\nwuzup.net\nwuzupmail.net\nwww.e4ward.com\nwww.gishpuppy.com\nwww.mailinator.com\nwwwnew.eu\nxagloo.com\nxemaps.com\nxents.com\nxmaily.com\nxoxy.net\nyep.it\nyogamaven.com\nyopmail.com\nyopmail.fr\nyopmail.net\nypmail.webarnak.fr.eu.org\nyuurok.com\nzehnminutenmail.de\nzippymail.info\nzoaxe.com\nzoemail.org\", UNIX_TIMESTAMP(), 1);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` CHANGE `shipping_cost_additional` `additional_shipping_cost` double(16,2) default '0';";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('payment_gateway_sandbox', 'bool', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "useraccounts` CHANGE `extcat` `extracat` double(8,2) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "useraccounts` CHANGE `image` `picture` double(8,2) NOT NULL default '0';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'setup_fee' WHERE type = 'setup';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'featured_fee' WHERE type = 'hpfeat_fee';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'bold_fee' WHERE type = 'bolditem_fee';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'highlighted_fee' WHERE type = 'hlitem_fee';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'reserve_fee' WHERE type = 'rp_fee';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'extracat_fee' WHERE type = 'excat_fee';";
	$query[] = "UPDATE `" . $DBPrefix . "fees` SET type = 'buynow_fee' WHERE type = 'buyout_fee';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` CHANGE `subject` `subject` varchar(255) NOT NULL default '';";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('gallery_max_width_height', 'int', '1500', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('edit_endtime', 'int', '1', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('homefeaturednumber', 'int', '12', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('admin_theme', 'str', 'adminClassic', UNIX_TIMESTAMP(), 1);";
	$new_version = '1.2.0';
}
