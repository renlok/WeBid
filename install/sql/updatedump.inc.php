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

if ($myversion == '0.8.0')
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

if ($myversion == '0.8.1')
{
	//0.8.1 to 0.8.2
	$query[] = "UPDATE `" . $DBPrefix . "gateways` SET gateways = 'paypal,authnet';";
	$query[] = "INSERT INTO `" . $DBPrefix . "fees` (value, type) VALUES (0, 'buyer_fee');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `bf_paid` INT(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `current_fee` double(16,4) default '0.00';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.2';";
	$new_version = '0.8.2';
}

if ($myversion == '0.8.2')
{
	//0.8.2 to 0.8.3
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.3';";
	$new_version = '0.8.3';
}

if ($myversion == '0.8.3')
{
	//0.8.3 to 0.8.4
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` ADD `fromemail` varchar(50) NOT NULL default '';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.4';";
	$new_version = '0.8.4';
}

if ($myversion == '0.8.4')
{
	//0.8.4 to 0.8.5
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.5';";
	$new_version = '0.8.5';
}

if ($myversion == '0.8.5' || $myversion == '0.8.5 P1')
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

if ($myversion == '1.0.0')
{
	//1.0.0 to 1.0.1
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.1';";
	$new_version = '1.0.1';
}

if ($myversion == '1.0.1')
{
	//1.0.1 to 1.0.2
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.2';";
	$new_version = '1.0.2';
}

if ($myversion == '1.0.2')
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

if ($myversion == '1.0.3')
{
	//1.0.3 to 1.0.4
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.4';";
	$new_version = '1.0.4';
}

if ($myversion == '1.0.4')
{
	//1.0.4 to 1.0.5
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.5';";
	$new_version = '1.0.5';
}

if ($myversion == '1.0.5')
{
	//1.0.5 to 1.0.6
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.6';";
	$new_version = '1.0.6';
}

if ($myversion == '1.0.6')
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
		`auc_id` int(15) NOT NULL default '0',
		`user_id` int(15) NOT NULL default '0',
		`date` int(15) NOT NULL default '0',
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

if (in_array($myversion, array('1.1.0', '1.1.1', '1.1.2', '1.1.2P1', '1.1.2P2')))
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
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` MODIFY `timecorrection` decimal(3,1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `timecorrection` decimal(3,1) NOT NULL default '0';";
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
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
	$query[] = "CREATE TABLE `".$DBprefix ."settings`
		`fieldname` VARCHAR(30) NOT NULL,
		`fieldtype` VARCHAR(10) NOT NULL,
		`value` VARCHAR(255) NOT NULL,
		`modifieddate` INT(11) NOT NULL,
		`modifiedby` INT(32) NOT NULL,
		PRIMARY KEY(`fieldname`)
		)";
	$new_version = '1.2.0';
}
