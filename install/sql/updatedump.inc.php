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

if ($installed_version == '0.8')
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

if ($installed_version == '0.8.5' || $installed_version == '0.8.5P1')
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
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `subtitle` VARCHAR(70) AFTER `title`;";
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
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `nick` varchar(20) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `hash` varchar(5) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `city` varchar(25) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `prov` varchar(20) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `country` varchar(30) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `zip` varchar(10) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `phone` varchar(40) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `email` varchar(50) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `birthdate` int(8) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `paypal_email` varchar(50) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "increments` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "increments` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "categories` ADD INDEX (`left_id`, `right_id`, `level`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "categories` MODIFY `cat_colour` varchar(15) default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "categories` MODIFY `cat_image` varchar(150) default '';";
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
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `tax` enum('y','n') NOT NULL default 'n' AFTER `current_fee`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `taxinc` enum('y','n') NOT NULL default 'y' AFTER `tax`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `shipping_cost_additional` double(16,2) default '0' AFTER `shipping_cost`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `current_bid` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `closed` int(1) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` MODIFY `ae_status` enum('y','n') NOT NULL default 'n';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `tax` enum('y','n') NOT NULL default 'n' AFTER `fee_disable_acc`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `taxuser` enum('y','n') NOT NULL default 'n' AFTER `tax`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `invoice_yellow_line` varchar(255) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `invoice_thankyou` varchar(255) NOT NULL DEFAULT '';";
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
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `shipping_cost` double(16,2) default '0';";
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
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.1.0';";
	$new_version = '1.1.0';
}

if (in_array($installed_version, array('1.1.0', '1.1.1', '1.1.2', '1.1.2P1', '1.1.2P2')))
{
	//1.1.0 to 1.2.0
	$query[] = "ALTER TABLE `" . $DBPrefix . "accesseshistoric` CHANGE `uniquevisitiors` `uniquevisitors` int(11) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` CHANGE `username` `username` VARCHAR(32) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `password` varchar(60) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `status` tinyint(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `user` int(11) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `auction_type` int(1) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `duration` double(8,2) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `shipping` int(1) DEFAULT '1';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `shipping_terms` tinytext DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `closed` tinyint(1) DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `photo_uploaded` tinyint(1) DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `quantity` int(11) DEFAULT '1';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `international` tinyint(1) DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `initial_quantity` int(11) DEFAULT 1;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `bn_sale` tinyint(1) DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `current_bid_id` int(11) DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "banners` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "banners` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "bannersstats` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "bannersusers` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "bannersusers` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "bids` MODIFY `auction` int(11) DEFAULT NULL;";
 	$query[] = "ALTER TABLE `" . $DBPrefix . "bids` MODIFY `bidder` int(11) DEFAULT NULL;";
 	$query[] = "ALTER TABLE `" . $DBPrefix . "comm_messages` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "comm_messages` DROP INDEX `msg_id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "community` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "community` DROP INDEX `msg_id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "durations` MODIFY `days` double(8,2) NOT NULL DEFAULT '0.00';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "faqs` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "faqs` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "faqs_translated` MODIFY `id` int(11) NOT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "faqs_translated` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "faqscategories` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "faqscategories` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "feedbacks` MODIFY `rated_user_id` int(11) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "feedbacks` MODIFY `auction_id` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "groups` MODIFY `can_sell` tinyint(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "groups` MODIFY `can_buy` tinyint(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "groups` MODIFY `count` tinyint(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "groups` MODIFY `auto_join` tinyint(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `sentto` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `sentfrom` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `fromemail` varchar(255) NOT NULL DEFAULT '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `isread` tinyint(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `replied` tinyint(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `reply_of` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `question` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `public` tinyint(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "news` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "news` MODIFY `suspended` tinyint(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "proxybid` MODIFY `itemid` int(11) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "proxybid` MODIFY `userid` int(11) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "useraccounts` MODIFY `auc_id` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "useraccounts` MODIFY `user_id` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "useraccounts` MODIFY `date` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `reg_date` int(11) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "usersips` MODIFY `user` int(11) DEFAULT NULL;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` MODIFY `auction` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` MODIFY `seller` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` MODIFY `winner` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` MODIFY `closingdate` int(11) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD PRIMARY KEY (`id`);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` DROP INDEX `id`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `password` varchar(60) NOT NULL;";
	$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Serbia');";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "closedrelisted`;";
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
	$query[] = "ALTER TABLE `" . $DBPrefix . "countries` DROP PRIMARY KEY;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "countries` ADD `country_id` int(4) PRIMARY KEY AUTO_INCREMENT;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `paypal_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `authnet_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `worldpay_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `checkout_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `moneybookers_sandbox` INT(1) default 0;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "currentbrowsers` MODIFY `browser` varchar(255) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` CHANGE `worldpay_address` `worldpay_id` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` CHANGE `toocheckout_address` `toocheckout_id` varchar(50) NOT NULL default '';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `auc_title` varchar(70);";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `auc_shipping_cost` double(16,2) default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `auc_payment` tinytext;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `gateways` INT(1) default 'a:5:{s:6:\"paypal\";s:6:\"PayPal\";s:7:\"authnet\";s:13:\"Authorize.net\";s:8:\"worldpay\";s:8:\"WorldPay\";s:12:\"moneybookers\";s:12:\"Moneybookers\";s:11:\"toocheckout\";s:9:\"2Checkout\";}';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `status` tinyint(1) NOT NULL default '0';";
	$query[] = "UPDATE `" . $DBPrefix . "adminusers` SET status = 0 WHERE status = 2;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "community` MODIFY `active` tinyint(1) NOT NULL default '1';";
	$query[] = "UPDATE `" . $DBPrefix . "community` SET active = 0 WHERE active = 2;";
	$query[] = "UPDATE `" . $DBPrefix . "auctions` SET theme = IF (theme = 'default', 'classic', theme);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auction_types`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "auction_types` (
	  `id` int(2) NOT NULL auto_increment,
	  `key` varchar(32),
	  `language_string` varchar(32),
	  PRIMARY KEY  (`id`)
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
		`days` double(8,2) NOT NULL,
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
	$query[] = "INSERT INTO `" . $DBPrefix . "settingsv2` VALUES ('spam_blocked_email_enabled', 'bool', '1', UNIX_TIMESTAMP(), 1);";
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

if ($installed_version == '1.2.0')
{
	//1.2.0 to 1.2.1
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` ADD `password_type` INT(1) NOT NULL DEFAULT '0' AFTER `password`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `password_type` INT(1) NOT NULL DEFAULT '1';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `password_type` INT(1) NOT NULL DEFAULT '0' AFTER `password`;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `password_type` INT(1) NOT NULL DEFAULT '1';";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('auction_moderation', 'int', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('new_auction_moderation', 'int', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "maintainance`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "reportedauctions`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "reportedauctions` (
	  `id` int(11) NOT NULL,
	  `auction_id` int(11) NOT NULL DEFAULT '0',
	  `reason` int(11) NOT NULL DEFAULT '0',
	  `user_id` int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY(`id`)
	) ;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auction_moderation`;";
	$query[] = "CREATE TABLE `" . $DBPrefix . "auction_moderation` (
	  `id` int(11) NOT NULL auto_increment,
	  `auction_id` int(11) NOT NULL DEFAULT '0',
	  `reason` int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY(`id`)
	);";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `value` = 'logo.png' WHERE `fieldname` = 'logo';";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cust_increment', 'int', '2', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_reportitem', 'int', '1', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (NULL, 'Romanian', 'Romanian Leu', 'RON');";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('featuredperpage', 'int', '5', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('version_check', 'str', 'stable', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maintainance_mode_active', 'bool', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maintainance_text', 'string', '<p><strong>Under maintenance!!!!!!!</strong></p>', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('prune_unactivated_users', 'bool', '1', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('prune_unactivated_users_days', 'int', '30', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('shipping', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('superuser', 'string', 'renlok', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('googleanalytics', 'string', '', UNIX_TIMESTAMP(), 1);";
	$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('use_moderation', 'bool', '0', UNIX_TIMESTAMP(), 1);";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `value` = \"0-mail.com\n027168.com\n0815.ru\n0815.ry\n0815.su\n0845.ru\n0clickemail.com\n0wnd.net\n0wnd.org\n0x207.info\n1-8.biz\n100likers.com\n10mail.com\n10mail.org\n10minut.com.pl\n10minutemail.cf\n10minutemail.co.uk\n10minutemail.co.za\n10minutemail.com\n10minutemail.de\n10minutemail.ga\n10minutemail.gq\n10minutemail.ml\n10minutemail.net\n10minutesmail.com\n10x9.com\n123-m.com\n12houremail.com\n12minutemail.com\n12minutemail.net\n140unichars.com\n147.cl\n14n.co.uk\n1ce.us\n1chuan.com\n1fsdfdsfsdf.tk\n1mail.ml\n1pad.de\n1st-forms.com\n1to1mail.org\n1zhuan.com\n20email.eu\n20email.it\n20mail.in\n20mail.it\n20minutemail.com\n2120001.net\n21cn.com\n24hourmail.com\n24hourmail.net\n2fdgdfgdfgdf.tk\n2prong.com\n30minutemail.com\n33mail.com\n36ru.com\n3d-painting.com\n3l6.com\n3mail.ga\n3trtretgfrfe.tk\n4-n.us\n418.dk\n4gfdsgfdgfd.tk\n4mail.cf\n4mail.ga\n4warding.com\n4warding.net\n4warding.org\n5ghgfhfghfgh.tk\n5gramos.com\n5mail.cf\n5mail.ga\n5oz.ru\n5x25.com\n60minutemail.com\n672643.net\n675hosting.com\n675hosting.net\n675hosting.org\n6hjgjhgkilkj.tk\n6ip.us\n6mail.cf\n6mail.ga\n6mail.ml\n6paq.com\n6url.com\n75hosting.com\n75hosting.net\n75hosting.org\n7days-printing.com\n7mail.ga\n7mail.ml\n7tags.com\n80665.com\n8127ep.com\n8mail.cf\n8mail.ga\n8mail.ml\n99experts.com\n9mail.cf\n9ox.net\na-bc.net\na.asu.mx\na.betr.co\na.mailcker.com\na.vztc.com\na45.in\nabakiss.com\nabcmail.email\nabusemail.de\nabyssmail.com\nac20mail.in\nacademiccommunity.com\nacentri.com\nadd3000.pp.ua\nadobeccepdm.com\nadpugh.org\nadsd.org\nadvantimo.com\nadwaterandstir.com\naegia.net\naegiscorp.net\naeonpsi.com\nafrobacon.com\nag.us.to\nagedmail.com\nagtx.net\nahk.jp\najaxapp.net\nakapost.com\nakerd.com\nal-qaeda.us\naligamel.com\nalisongamel.com\nalivance.com\nalldirectbuy.com\nallen.nom.za\nallthegoodnamesaretaken.org\nalph.wtf\nama-trade.de\nama-trans.de\namail.com\namail4.me\namazon-aws.org\namelabs.com\namilegit.com\namiri.net\namiriindustries.com\nampsylike.com\nan.id.au\nanappfor.com\nanappthat.com\nandthen.us\nanimesos.com\nano-mail.net\nanon-mail.de\nanonbox.net\nanonmails.de\nanonymail.dk\nanonymbox.com\nanonymized.org\nanonymousness.com\nansibleemail.com\nanthony-junkmail.com\nantireg.com\nantireg.ru\nantispam.de\nantispam24.de\nantispammail.de\napfelkorps.de\naphlog.com\nappc.se\nappinventor.nl\nappixie.com\narmyspy.com\naron.us\narroisijewellery.com\nartman-conception.com\narvato-community.de\naschenbrandt.net\nasdasd.nl\nasdasd.ru\nashleyandrew.com\nass.pp.ua\nastroempires.info\nat0mik.org\natvclub.msk.ru\naugmentationtechnology.com\nauti.st\nautorobotica.com\nautotwollow.com\naver.com\naxiz.org\nazcomputerworks.com\nazmeil.tk\nb.kyal.pl\nb1of96u.com\nb2cmail.de\nbadgerland.eu\nbadoop.com\nbarryogorman.com\nbasscode.org\nbauwerke-online.com\nbaxomale.ht.cx\nbazaaboom.com\nbcast.ws\nbccto.me\nbearsarefuzzy.com\nbeddly.com\nbeefmilk.com\nbelljonestax.com\nbenipaula.org\nbestchoiceusedcar.com\nbidourlnks.com\nbig1.us\nbigprofessor.so\nbigstring.com\nbigwhoop.co.za\nbinkmail.com\nbio-muesli.info\nbio-muesli.net\nblackmarket.to\nbladesmail.net\nblip.ch\nblogmyway.org\nbluedumpling.info\nbluewerks.com\nbobmail.info\nbobmurchison.com\nbodhi.lawlita.com\nbofthew.com\nbonobo.email\nbookthemmore.com\nbootybay.de\nborged.com\nborged.net\nborged.org\nboun.cr\nbouncr.com\nboxformail.in\nboximail.com\nboxtemp.com.br\nbr.mintemail.com\nbrandallday.net\nbreakthru.com\nbrefmail.com\nbrennendesreich.de\nbriggsmarcus.com\nbroadbandninja.com\nbsnow.net\nbspamfree.org\nbspooky.com\nbst-72.com\nbtb-notes.com\nbtc.email\nbu.mintemail.com\nbuffemail.com\nbugmenever.com\nbugmenot.com\nbulrushpress.com\nbum.net\nbumpymail.com\nbunchofidiots.com\nbund.us\nbundes-li.ga\nbunsenhoneydew.com\nburnthespam.info\nburstmail.info\nbusinessbackend.com\nbusinesssuccessislifesuccess.com\nbuspad.org\nbuymoreplays.com\nbuyordie.info\nbuyusedlibrarybooks.org\nbyebyemail.com\nbyespm.com\nbyom.de\nc.lain.ch\nc2.hu\nc51vsgq.com\ncachedot.net\ncaliforniafitnessdeals.com\ncam4you.cc\ncard.zp.ua\ncasualdx.com\ncbair.com\ncc.liamria\nce.mintemail.com\ncek.pm\ncellurl.com\ncentermail.com\ncentermail.net\nchacuo.net\nchammy.info\ncheatmail.de\nchielo.com\nchildsavetrust.org\nchilkat.com\nchithinh.com\nchogmail.com\nchoicemail1.com\nchong-mail.com\nchong-mail.net\nchong-mail.org\nchumpstakingdumps.com\ncigar-auctions.com\nckiso.com\ncl-cl.org\ncl0ne.net\nclandest.in\nclipmail.eu\nclixser.com\nclrmail.com\ncmail.com\ncmail.net\ncmail.org\ncnamed.com\ncnmsg.net\ncnsds.de\ncodeandscotch.com\ncodivide.com\ncoieo.com\ncoldemail.info\ncompareshippingrates.org\ncompletegolfswing.com\ncomwest.de\nconsumerriot.com\ncool.fr.nf\ncoolandwacky.us\ncoolimpool.org\ncorreo.blogos.net\ncosmorph.com\ncourriel.fr.nf\ncourrieltemporaire.com\ncrankhole.com\ncrapmail.org\ncrastination.de\ncrazespaces.pw\ncrazymailing.com\ncrossroadsmail.com\ncszbl.com\ncubiclink.com\ncurryworld.de\ncust.in\ncuvox.de\ncx.de-a.org\nd.cane.pw\nd.dialogus.com\nd3p.dk\ndacoolest.com\ndaemsteam.com\ndaintly.com\ndammexe.net\ndandikmail.com\ndarkharvestfilms.com\ndaryxfox.net\ndash-pads.com\ndataarca.com\ndatafilehost\ndatarca.com\ndatazo.ca\ndavidkoh.net\ndavidlcreative.com\ndayrep.com\ndbunker.com\ndcemail.com\ndeadaddress.com\ndeadchildren.org\ndeadfake.cf\ndeadfake.ga\ndeadfake.ml\ndeadfake.tk\ndeadspam.com\ndeagot.com\ndealja.com\ndealrek.com\ndeekayen.us\ndefomail.com\ndegradedfun.net\ndelayload.com\ndelayload.net\ndelikkt.de\nder-kombi.de\nderkombi.de\nderluxuswagen.de\ndespam.it\ndespammed.com\ndevnullmail.com\ndharmatel.net\ndiapaulpainting.com\ndigitalmariachis.com\ndigitalsanctuary.com\ndildosfromspace.com\ndingbone.com\ndiscard.cf\ndiscard.email\ndiscard.ga\ndiscard.gq\ndiscard.ml\ndiscard.tk\ndiscardmail.com\ndiscardmail.de\ndispo.in\ndispomail.eu\ndisposable-email.ml\ndisposable.cf\ndisposable.ga\ndisposable.ml\ndisposableaddress.com\ndisposableemailaddresses.com\ndisposableemailaddresses.emailmiser.com\ndisposableinbox.com\ndispose.it\ndisposeamail.com\ndisposemail.com\ndispostable.com\ndivermail.com\ndivismail.ru\ndlemail.ru\ndm.w3internet.co.uk\ndm.w3internet.co.ukexample.com\ndodgeit.com\ndodgemail.de\ndodgit.com\ndodgit.org\ndodsi.com\ndoiea.com\ndolphinnet.net\ndomforfb1.tk\ndomforfb18.tk\ndomforfb19.tk\ndomforfb2.tk\ndomforfb23.tk\ndomforfb27.tk\ndomforfb29.tk\ndomforfb3.tk\ndomforfb4.tk\ndomforfb5.tk\ndomforfb6.tk\ndomforfb7.tk\ndomforfb8.tk\ndomforfb9.tk\ndomozmail.com\ndonemail.ru\ndontreg.com\ndontsendmespam.de\ndoquier.tk\ndotman.de\ndotmsg.com\ndotslashrage.com\ndouchelounge.com\ndozvon-spb.ru\ndr.vankin.de\ndrdrb.com\ndrdrb.net\ndrivetagdev.com\ndroolingfanboy.de\ndropcake.de\ndroplar.com\ndropmail.me\ndspwebservices.com\nduam.net\ndudmail.com\ndukedish.com\ndump-email.info\ndumpandjunk.com\ndumpmail.de\ndumpyemail.com\ndurandinterstellar.com\nduskmail.com\ndw.now.im\ndx.abuser.eu\ndx.allowed.org\ndx.awiki.org\ndx.ez.lv\ndx.sly.io\ndx.soon.it\ndx.z86.ru\ndyceroprojects.com\ndz17.net\ne-mail.com\ne-mail.org\ne.brasx.org\ne.coza.ro\ne.ezfill.com\ne.hecat.es\ne.hpc.tw\ne.incq.com\ne.lee.mx\ne.ohi.tw\ne.runi.ca\ne.sino.tw\ne.spr.io\ne.ubm.md\ne3z.de\ne4ward.com\neasy-trash-mail.com\neasytrashmail.com\nebeschlussbuch.de\nebs.com.ar\necallheandi.com\nedinburgh-airporthotels.com\nedv.to\nee1.pl\nee2.pl\neelmail.com\neinmalmail.de\neinrot.com\neinrot.de\neintagsmail.de\nelearningjournal.org\nelectro.mn\nelitevipatlantamodels.com\nemail-fake.cf\nemail-fake.ga\nemail-fake.gq\nemail-fake.ml\nemail-fake.tk\nemail-jetable.fr\nemail.cbes.net\nemail.net\nemail60.com\nemailage.cf\nemailage.ga\nemailage.gq\nemailage.ml\nemailage.tk\nemaildienst.de\nemailgo.de\nemailias.com\nemailigo.de\nemailinfive.com\nemailisvalid.com\nemaillime.com\nemailmiser.com\nemailproxsy.com\nemailresort.com\nemails.ga\nemailsensei.com\nemailsingularity.net\nemailspam.cf\nemailspam.ga\nemailspam.gq\nemailspam.ml\nemailspam.tk\nemailtemporanea.com\nemailtemporanea.net\nemailtemporar.ro\nemailtemporario.com.br\nemailthe.net\nemailtmp.com\nemailto.de\nemailwarden.com\nemailx.at.hm\nemailxfer.com\nemailz.cf\nemailz.ga\nemailz.gq\nemailz.ml\nemeil.in\nemeil.ir\nemil.com\nemkei.cf\nemkei.ga\nemkei.gq\nemkei.ml\nemkei.tk\neml.pp.ua\nemz.net\nenterto.com\nephemail.net\nephemeral.email\ner.fir.hk\ner.moot.es\nericjohnson.ml\nero-tube.org\nesc.la\nescapehatchapp.com\nesemay.com\nesgeneri.com\nesprity.com\nest.une.victime.ninja\netranquil.com\netranquil.net\netranquil.org\nevanfox.info\nevopo.com\nexample.com\nexitstageleft.net\nexplodemail.com\nexpress.net.ua\nextremail.ru\neyepaste.com\nezstest.com\nf.fuirio.com\nf.fxnxs.com\nf.hmh.ro\nf4k.es\nfacebook-email.cf\nfacebook-email.ga\nfacebook-email.ml\nfacebookmail.gq\nfacebookmail.ml\nfadingemail.com\nfag.wf\nfailbone.com\nfaithkills.com\nfake-email.pp.ua\nfake-mail.cf\nfake-mail.ga\nfake-mail.ml\nfakedemail.com\nfakeinbox.cf\nfakeinbox.com\nfakeinbox.ga\nfakeinbox.ml\nfakeinbox.tk\nfakeinformation.com\nfakemail.fr\nfakemailgenerator.com\nfakemailz.com\nfammix.com\nfangoh.com\nfansworldwide.de\nfantasymail.de\nfarrse.co.uk\nfastacura.com\nfastchevy.com\nfastchrysler.com\nfasternet.biz\nfastkawasaki.com\nfastmazda.com\nfastmitsubishi.com\nfastnissan.com\nfastsubaru.com\nfastsuzuki.com\nfasttoyota.com\nfastyamaha.com\nfatflap.com\nfdfdsfds.com\nfer-gabon.org\nfettometern.com\nfictionsite.com\nfightallspam.com\nfigjs.com\nfigshot.com\nfiifke.de\nfilbert4u.com\nfilberts4u.com\nfilm-blog.biz\nfilzmail.com\nfivemail.de\nfixmail.tk\nfizmail.com\nfleckens.hu\nflemail.ru\nflowu.com\nflurred.com\nfly-ts.de\nflyinggeek.net\nflyspam.com\nfoobarbot.net\nfootard.com\nforecastertests.com\nforgetmail.com\nfornow.eu\nforspam.net\nfoxja.com\nfoxtrotter.info\nfr.ipsur.org\nfr33mail.info\nfrapmail.com\nfree-email.cf\nfree-email.ga\nfreebabysittercam.com\nfreeblackbootytube.com\nfreecat.net\nfreedompop.us\nfreefattymovies.com\nfreeletter.me\nfreemail.hu\nfreemail.ms\nfreemails.cf\nfreemails.ga\nfreemails.ml\nfreeplumpervideos.com\nfreeschoolgirlvids.com\nfreesistercam.com\nfreeteenbums.com\nfreundin.ru\nfriendlymail.co.uk\nfront14.org\nfuckedupload.com\nfuckingduh.com\nfudgerub.com\nfunnycodesnippets.com\nfurzauflunge.de\nfux0ringduh.com\nfw.moza.pl\nfyii.de\ng.airsi.de\ng.asu.su\ng.garizo.com\ng.hmail.us\ng.rbb.org\ng.tefl.ro\ng.tiv.cc\ng.vda.ro\ng4hdrop.us\ngalaxy.tv\ngamegregious.com\ngarbagecollector.org\ngarbagemail.org\ngardenscape.ca\ngarliclife.com\ngarrifulio.mailexpire.com\ngarrymccooey.com\ngav0.com\ngawab.com\ngehensiemirnichtaufdensack.de\ngeldwaschmaschine.de\ngelitik.in\ngenderfuck.net\ngeschent.biz\nget-mail.cf\nget-mail.ga\nget-mail.ml\nget-mail.tk\nget.pp.ua\nget1mail.com\nget2mail.fr\ngetairmail.cf\ngetairmail.com\ngetairmail.ga\ngetairmail.gq\ngetairmail.ml\ngetairmail.tk\ngetmails.eu\ngetonemail.com\ngetonemail.net\ngg.nh3.ro\nghosttexter.de\ngiaiphapmuasam.com\ngiantmail.de\nginzi.be\nginzi.co.uk\nginzi.es\nginzi.net\nginzy.co.uk\nginzy.eu\ngirlsindetention.com\ngirlsundertheinfluence.com\ngishpuppy.com\nglitch.sx\nglobaltouron.com\nglucosegrin.com\ngmal.com\ngmial.com\ngmx.us\ngnctr-calgary.com\ngo.arduino.hk\ngo.cdpa.cc\ngo.irc.so\ngo.jmail.ro\ngo.jwork.ru\ngoemailgo.com\ngomail.in\ngorillaswithdirtyarmpits.com\ngothere.biz\ngotmail.com\ngotmail.net\ngotmail.org\ngotti.otherinbox.com\ngowikibooks.com\ngowikicampus.com\ngowikicars.com\ngowikifilms.com\ngowikigames.com\ngowikimusic.com\ngowikinetwork.com\ngowikitravel.com\ngowikitv.com\ngrandmamail.com\ngrandmasmail.com\ngreat-host.in\ngreensloth.com\ngreggamel.com\ngreggamel.net\ngregorsky.zone\ngregorygamel.com\ngregorygamel.net\ngrr.la\ngs-arc.org\ngsredcross.org\ngsrv.co.uk\ngudanglowongan.com\nguerillamail.biz\nguerillamail.com\nguerillamail.de\nguerillamail.info\nguerillamail.net\nguerillamail.org\nguerillamailblock.com\nguerrillamail.biz\nguerrillamail.com\nguerrillamail.de\nguerrillamail.info\nguerrillamail.net\nguerrillamail.org\nguerrillamailblock.com\ngustr.com\ngynzi.co.uk\ngynzi.es\ngynzy.at\ngynzy.es\ngynzy.eu\ngynzy.gr\ngynzy.info\ngynzy.lt\ngynzy.mobi\ngynzy.pl\ngynzy.ro\ngynzy.sk\nh.mintemail.com\nh8s.org\nhabitue.net\nhacccc.com\nhackthatbit.ch\nhahawrong.com\nhaltospam.com\nharakirimail.com\nhartbot.de\nhat-geld.de\nhatespam.org\nhawrong.com\nhazelnut4u.com\nhazelnuts4u.com\nhazmatshipping.org\nheathenhammer.com\nheathenhero.com\nhellodream.mobi\nhelloricky.com\nhelpinghandtaxcenter.org\nherp.in\nherpderp.nl\nhiddentragedy.com\nhidemail.de\nhidzz.com\nhighbros.org\nhmamail.com\nhoanggiaanh.com\nhochsitze.com\nhopemail.biz\nhot-mail.cf\nhot-mail.ga\nhot-mail.gq\nhot-mail.ml\nhot-mail.tk\nhotmai.com\nhotmial.com\nhotpop.com\nhq.okzk.com\nhulapla.de\nhumaility.com\nhumn.ws.gy\nhungpackage.com\nhush.ai\nhush.com\nhushmail.com\nhushmail.me\nhuskion.net\nhvastudiesucces.nl\nhwsye.net\nibnuh.bz\nicantbelieveineedtoexplainthisshit.com\nicx.in\nieatspam.eu\nieatspam.info\nieh-mail.de\nignoremail.com\nihateyoualot.info\niheartspam.org\nikbenspamvrij.nl\nillistnoise.com\nilovespam.com\nimails.info\nimgof.com\nimgv.de\nimstations.com\ninbax.tk\ninbound.plus\ninbox.si\ninbox2.info\ninboxalias.com\ninboxclean.com\ninboxclean.org\ninboxdesign.me\ninboxed.im\ninboxed.pw\ninboxproxy.com\ninboxstore.me\ninclusiveprogress.com\nincognitomail.com\nincognitomail.net\nincognitomail.org\nindieclad.com\nindirect.ws\nineec.net\ninfocom.zp.ua\ninoutmail.de\ninoutmail.eu\ninoutmail.info\ninoutmail.net\ninsanumingeniumhomebrew.com\ninsorg-mail.info\ninstant-mail.de\ninstantemailaddress.com\ninternetoftags.com\ninterstats.org\nintersteller.com\niozak.com\nip.nm7.cc\nip4.pp.ua\nip6.li\nip6.pp.ua\nipoo.org\nirish2me.com\niroid.com\nironiebehindert.de\nirssi.tv\nis.af\nisukrainestillacountry.com\nit7.ovh\nitunesgiftcodegenerator.com\niwi.net\nj-p.us\nj.svxr.org\njafps.com\njdmadventures.com\njellyrolls.com\njetable.com\njetable.fr.nf\njetable.net\njetable.org\njetable.pp.ua\njnxjn.com\njobbikszimpatizans.hu\njobposts.net\njobs-to-be-done.net\njoelpet.com\njoetestalot.com\njopho.com\njourrapide.com\njp.ftp.sh\njsrsolutions.com\njungkamushukum.com\njunk.to\njunk1e.com\njunkmail.ga\njunkmail.gq\nk.aelo.es\nk.avls.pt\nk.bgx.ro\nk.cylab.org\nk.kaovo.com\nk.kon42.com\nk.vesa.pw\nkakadua.net\nkalapi.org\nkamsg.com\nkariplan.com\nkartvelo.com\nkasmail.com\nkaspop.com\nkcrw.de\nkeepmymail.com\nkeinhirn.de\nkeipino.de\nkemptvillebaseball.com\nkennedy808.com\nkillmail.com\nkillmail.net\nkimsdisk.com\nkingsq.ga\nkiois.com\nkir.ch.tc\nkismail.ru\nkisstwink.com\nkitnastar.com\nklassmaster.com\nklassmaster.net\nkloap.com\nkludgemush.com\nklzlk.com\nkmhow.com\nkommunity.biz\nkook.ml\nkopagas.com\nkopaka.net\nkosmetik-obatkuat.com\nkostenlosemailadresse.de\nkoszmail.pl\nkrypton.tk\nkuhrap.com\nkulturbetrieb.info\nkurzepost.de\nkwift.net\nkwilco.net\nl-c-a.us\nl.logular.com\nl33r.eu\nlabetteraverouge.at\nlackmail.net\nlags.us\nlakelivingstonrealestate.com\nlandmail.co\nlaoeq.com\nlastmail.co\nlastmail.com\nlavabit.com\nlawlita.com\nlazyinbox.com\nleeching.net\nlellno.gq\nletmeinonthis.com\nletthemeatspam.com\nlez.se\nlhsdv.com\nliamcyrus.com\nlifebyfood.com\nlifetotech.com\nligsb.com\nlilo.me\nlindenbaumjapan.com\nlink2mail.net\nlinuxmail.so\nlitedrop.com\nlkgn.se\nllogin.ru\nloadby.us\nlocomodev.net\nlogin-email.cf\nlogin-email.ga\nlogin-email.ml\nlogin-email.tk\nloh.pp.ua\nloin.in\nlol.meepsheep.eu\nlol.ovpn.to\nlolfreak.net\nlolmail.biz\nlookugly.com\nlopl.co.cc\nlortemail.dk\nlosemymail.com\nlovemeleaveme.com\nlpfmgmtltd.com\nlr7.us\nlr78.com\nlroid.com\nlru.me\nluckymail.org\nlukecarriere.com\nlukemail.info\nlukop.dk\nluv2.us\nlyfestylecreditsolutions.com\nm.ddcrew.com\nm21.cc\nm4ilweb.info\nma1l.bij.pl\nmaboard.com\nmac.hush.com\nmacromaid.com\nmagamail.com\nmagicbox.ro\nmaidlow.info\nmail-filter.com\nmail-owl.com\nmail-temporaire.com\nmail-temporaire.fr\nmail.bccto.me\nmail.by\nmail.mezimages.net\nmail.zp.ua\nmail114.net\nmail1a.de\nmail21.cc\nmail2rss.org\nmail2world.com\nmail333.com\nmail4trash.com\nmail666.ru\nmail707.com\nmail72.com\nmailback.com\nmailbidon.com\nmailbiz.biz\nmailblocks.com\nmailbucket.org\nmailcat.biz\nmailcatch.com\nmailchop.com\nmailde.de\nmailde.info\nmaildrop.cc\nmaildrop.cf\nmaildrop.ga\nmaildrop.gq\nmaildrop.ml\nmaildu.de\nmaildx.com\nmaileater.com\nmailed.in\nmailed.ro\nmaileimer.de\nmailexpire.com\nmailfa.tk\nmailforspam.com\nmailfree.ga\nmailfree.gq\nmailfree.ml\nmailfreeonline.com\nmailfs.com\nmailguard.me\nmailhazard.com\nmailhazard.us\nmailhz.me\nmailimate.com\nmailin8r.com\nmailinatar.com\nmailinater.com\nmailinator.co.uk\nmailinator.com\nmailinator.gq\nmailinator.info\nmailinator.net\nmailinator.org\nmailinator.us\nmailinator2.com\nmailincubator.com\nmailismagic.com\nmailita.tk\nmailjunk.cf\nmailjunk.ga\nmailjunk.gq\nmailjunk.ml\nmailjunk.tk\nmailmate.com\nmailme.gq\nmailme.ir\nmailme.lv\nmailme24.com\nmailmetrash.com\nmailmoat.com\nmailms.com\nmailnator.com\nmailnesia.com\nmailnull.com\nmailonaut.com\nmailorc.com\nmailorg.org\nmailpick.biz\nmailproxsy.com\nmailquack.com\nmailrock.biz\nmailsac.com\nmailscrap.com\nmailseal.de\nmailshell.com\nmailsiphon.com\nmailslapping.com\nmailslite.com\nmailtemp.info\nmailtemporaire.com\nmailtemporaire.fr\nmailtome.de\nmailtothis.com\nmailtrash.net\nmailtv.net\nmailtv.tv\nmailzi.ru\nmailzilla.com\nmailzilla.org\nmailzilla.orgmbx.cc\nmakemetheking.com\nmalahov.de\nmalayalamdtp.com\nmanifestgenerator.com\nmansiondev.com\nmanybrain.com\nmarkmurfin.com\nmbx.cc\nmcache.net\nmciek.com\nmega.zik.dj\nmeinspamschutz.de\nmeltmail.com\nmessagebeamer.de\nmesswiththebestdielikethe.rest\nmezimages.net\nmfsa.ru\nmiaferrari.com\nmidcoastcustoms.com\nmidcoastcustoms.net\nmidcoastsolutions.com\nmidcoastsolutions.net\nmidlertidig.com\nmidlertidig.net\nmidlertidig.org\nmierdamail.com\nmigmail.net\nmigmail.pl\nmigumail.com\nmijnhva.nl\nmildin.org.ua\nministry-of-silly-walks.de\nmintemail.com\nmisterpinball.de\nmjukglass.nu\nmkpfilm.com\nml8.ca\nmoakt.com\nmobi.web.id\nmobileninja.co.uk\nmoburl.com\nmockmyid.com\nmohmal.com\nmomentics.ru\nmoncourrier.fr.nf\nmonemail.fr.nf\nmoneypipe.net\nmonmail.fr.nf\nmonumentmail.com\nmoonwake.com\nmor19.uu.gl\nmoreawesomethanyou.com\nmoreorcs.com\nmotique.de\nmountainregionallibrary.net\nmox.pp.ua\nms9.mailslite.com\nmsa.minsmail.com\nmsb.minsmail.com\nmsgos.com\nmspeciosa.com\nmswork.ru\nmsxd.com\nmt2009.com\nmt2014.com\nmt2015.com\nmtmdev.com\nmuathegame.com\nmuchomail.com\nmucincanon.com\nmutant.me\nmwarner.org\nmx0.wwwnew.eu\nmxfuel.com\nmy.efxs.ca\nmy10minutemail.com\nmybitti.de\nmycard.net.ua\nmycleaninbox.net\nmycorneroftheinter.net\nmydemo.equipment\nmyecho.es\nmyemailboxy.com\nmykickassideas.com\nmymail-in.net\nmymailoasis.com\nmynetstore.de\nmyopang.com\nmypacks.net\nmypartyclip.de\nmyphantomemail.com\nmysamp.de\nmyspaceinc.com\nmyspaceinc.net\nmyspaceinc.org\nmyspacepimpedup.com\nmyspamless.com\nmytemp.email\nmytempemail.com\nmytempmail.com\nmytrashmail.com\nmywarnernet.net\nmyzx.com\nn.rabin.ca\nn1nja.org\nnabuma.com\nnakedtruth.biz\nnanonym.ch\nnationalgardeningclub.com\nnaver.com\nnegated.com\nneomailbox.com\nnepwk.com\nnervmich.net\nnervtmich.net\nnetmails.com\nnetmails.net\nnetricity.nl\nnetris.net\nnetviewer-france.com\nnetzidiot.de\nnevermail.de\nnew.apps.dj\nnextstopvalhalla.com\nnfast.net\nnguyenusedcars.com\nnice-4u.com\nnicknassar.com\nnincsmail.hu\nniwl.net\nnmail.cf\nnnh.com\nnnot.net\nno-spam.ws\nno-ux.com\nnoblepioneer.com\nnobugmail.com\nnobulk.com\nnobuma.com\nnoclickemail.com\nnodezine.com\nnogmailspam.info\nnokiamail.com\nnomail.pw\nnomail.xl.cx\nnomail2me.com\nnomorespamemails.com\nnonspam.eu\nnonspammer.de\nnoref.in\nnorseforce.com\nnospam.wins.com.br\nnospam.ze.tc\nnospam4.us\nnospamfor.us\nnospamthanks.info\nnothingtoseehere.ca\nnotmailinator.com\nnotrnailinator.com\nnotsharingmy.info\nnowhere.org\nnowmymail.com\nntlhelp.net\nnubescontrol.com\nnullbox.info\nnurfuerspam.de\nnus.edu.sg\nnuts2trade.com\nnwldx.com\nny7.me\no.cavi.mx\no.civx.org\no.cnew.ir\no.jpco.org\no.mm5.se\no.opp24.com\no.rma.ec\no.sin.cl\no.yedi.org\no2stk.org\no7i.net\nobfusko.com\nobjectmail.com\nobobbo.com\nobxpestcontrol.com\nodaymail.com\nodnorazovoe.ru\noerpub.org\noffshore-proxies.net\nohaaa.de\nokclprojects.com\nokrent.us\nolypmall.ru\nomail.pro\nomnievents.org\none-time.email\noneoffemail.com\noneoffmail.com\nonewaymail.com\nonlatedotcom.info\nonline.ms\nonlineidea.info\nonqin.com\nontyne.biz\noolus.com\noopi.org\nopayq.com\nordinaryamerican.net\noshietechan.link\notherinbox.com\nourklips.com\nourpreviewdomain.com\noutlawspam.com\novpn.to\nowlpic.com\nownsyou.de\noxopoha.com\np.mm.my\npa9e.com\npagamenti.tk\npancakemail.com\npaplease.com\npastebitch.com\npcusers.otherinbox.com\npenisgoes.in\npepbot.com\npeterdethier.com\npetrzilka.net\npfui.ru\nphotomark.net\nphpbb.uu.gl\npi.vu\npimpedupmyspace.com\npinehill-seattle.org\npingir.com\npisls.com\npjjkp.com\nplexolan.de\nplhk.ru\nplw.me\npo.bot.nu\npoczta.onet.pl\npoh.pp.ua\npojok.ml\npokiemobile.com\npolitikerclub.de\npooae.com\npoofy.org\npookmail.com\npoopiebutt.club\npopesodomy.com\npopgx.com\npostacin.com\npostonline.me\npoutineyourface.com\npowered.name\npowlearn.com\npp.ua\nprimabananen.net\nprivacy.net\nprivatdemail.net\nprivy-mail.com\nprivy-mail.de\nprivymail.de\npro-tag.org\nprocrackers.com\nprojectcl.com\npropscore.com\nproxymail.eu\nproxyparking.com\nprtnx.com\nprtz.eu\npub.ftpinc.ca\npunkass.com\npuk.us.to\npurcell.email\npurelogistics.org\nput2.net\nputthisinyourspamdatabase.com\npwrby.com\npx.dhm.ro\nq.awatum.de\nq.tic.ec\nqasti.com\nqipmail.net\nqisdo.com\nqisoa.com\nqoika.com\nqs.dp76.com\nqs.grish.de\nquadrafit.com\nquickinbox.com\nquickmail.nl\nqvy.me\nqwickmail.com\nr.ctos.ch\nr4nd0m.de\nradiku.ye.vc\nraetp9.com\nraketenmann.de\nrancidhome.net\nrandomail.net\nraqid.com\nrax.la\nraxtest.com\nrcpt.at\nrcs.gaggle.net\nreallymymail.com\nrealtyalerts.ca\nreceiveee.chickenkiller.com\nreceiveee.com\nrecipeforfailure.com\nrecode.me\nreconmail.com\nrecyclemail.dk\nredfeathercrow.com\nregbypass.com\nregbypass.comsafe-mail.net\nrejectmail.com\nreliable-mail.com\nremail.cf\nremail.ga\nremarkable.rocks\nremote.li\nreptilegenetics.com\nrevolvingdoorhoax.org\nrhyta.com\nriddermark.de\nrisingsuntouch.com\nrk9.chickenkiller.com\nrklips.com\nrmqkr.net\nrnailinator.com\nrobertspcrepair.com\nronnierage.net\nrotaniliam.com\nrowe-solutions.com\nroyal.net\nroyaldoodles.org\nrppkn.com\nrr.ige.es\nrtrtr.com\nruffrey.com\nrumgel.com\nrustydoor.com\nrx.dred.ru\nrx.qc.to\ns.sast.ro\ns.scay.net\ns0ny.net\ns33db0x.com\nsabrestlouis.com\nsackboii.com\nsafe-mail.net\nsafersignup.de\nsafetymail.info\nsafetypost.de\nsaharanightstempe.com\nsamsclass.info\nsandelf.de\nsandwhichvideo.com\nsanfinder.com\nsanim.net\nsanstr.com\nsatukosong.com\nsausen.com\nsaynotospams.com\nscatmail.com\nschachrol.com\nschafmail.de\nschmeissweg.tk\nschrott-email.de\nsd3.in\nsecmail.pw\nsecretemail.de\nsecure-mail.biz\nsecure-mail.cc\nsecured-link.net\nsecurehost.com.es\nseekapps.com\nsejaa.lv\nselfdestructingmail.com\nselfdestructingmail.org\nsendfree.org\nsendingspecialflyers.com\nsendspamhere.com\nsenseless-entertainment.com\nserver.ms\nservices391.com\nsexforswingers.com\nsexical.com\nsharedmailbox.org\nsharklasers.com\nshhmail.com\nshhuut.org\nshieldedmail.com\nshieldemail.com\nshiftmail.com\nshipfromto.com\nshiphazmat.org\nshipping-regulations.com\nshippingterms.org\nshitmail.de\nshitmail.me\nshitmail.org\nshitware.nl\nshmeriously.com\nshortmail.net\nshotmail.ru\nshowslow.de\nshrib.com\nshut.name\nshut.ws\nsibmail.com\nsify.com\nsimpleitsecurity.info\nsinfiltro.cl\nsinglespride.com\nsinnlos-mail.de\nsiteposter.net\nsizzlemctwizzle.com\nskeefmail.com\nskkk.edu.my\nsky-inbox.com\nsky-ts.de\nslapsfromlastnight.com\nslaskpost.se\nslave-auctions.net\nslopsbox.com\nslothmail.net\nslushmail.com\nsmapfree24.com\nsmapfree24.de\nsmapfree24.eu\nsmapfree24.info\nsmapfree24.org\nsmashmail.de\nsmellfear.com\nsmellrear.com\nsmtp99.com\nsmwg.info\nsnakemail.com\nsneakemail.com\nsneakmail.de\nsnkmail.com\nsocialfurry.org\nsofimail.com\nsofort-mail.de\nsofortmail.de\nsoftpls.asia\nsogetthis.com\nsohu.com\nsoisz.com\nsolvemail.info\nsolventtrap.wiki\nsoodmail.com\nsoodomail.com\nsoodonims.com\nspam-be-gone.com\nspam.la\nspam.org.es\nspam.su\nspam4.me\nspamail.de\nspamarrest.com\nspamavert.com\nspambob.com\nspambob.net\nspambob.org\nspambog.com\nspambog.de\nspambog.net\nspambog.ru\nspambooger.com\nspambox.info\nspambox.irishspringrealty.com\nspambox.org\nspambox.us\nspamcero.com\nspamcon.org\nspamcorptastic.com\nspamcowboy.com\nspamcowboy.net\nspamcowboy.org\nspamday.com\nspamdecoy.net\nspamex.com\nspamfighter.cf\nspamfighter.ga\nspamfighter.gq\nspamfighter.ml\nspamfighter.tk\nspamfree.eu\nspamfree24.com\nspamfree24.de\nspamfree24.eu\nspamfree24.info\nspamfree24.net\nspamfree24.org\nspamgoes.in\nspamherelots.com\nspamhereplease.com\nspamhole.com\nspamify.com\nspaminator.de\nspamkill.info\nspaml.com\nspaml.de\nspamlot.net\nspammotel.com\nspamobox.com\nspamoff.de\nspamsalad.in\nspamslicer.com\nspamspot.com\nspamstack.net\nspamthis.co.uk\nspamthisplease.com\nspamtrail.com\nspamtroll.net\nspeed.1s.fr\nspeedgaus.net\nspikio.com\nspoofmail.de\nspritzzone.de\nspybox.de\nsquizzy.de\nsr.ro.lt\nsry.li\nss.hi5.si\nss.icx.ro\nss.undo.it\nssoia.com\nstanfordujjain.com\nstarlight-breaker.net\nstartfu.com\nstartkeys.com\nstatdvr.com\nstathost.net\nstatiix.com\nsteambot.net\nstinkefinger.net\nstop-my-spam.cf\nstop-my-spam.com\nstop-my-spam.ga\nstop-my-spam.ml\nstop-my-spam.pp.ua\nstop-my-spam.tk\nstreetwisemail.com\nstuffmail.de\nstumpfwerk.com\nsub.internetoftags.com\nsuburbanthug.com\nsuckmyd.com\nsudolife.me\nsudolife.net\nsudomail.biz\nsudomail.com\nsudomail.net\nsudoverse.com\nsudoverse.net\nsudoweb.net\nsudoworld.com\nsudoworld.net\nsuioe.com\nsuper-auswahl.de\nsupergreatmail.com\nsupermailer.jp\nsuperplatyna.com\nsuperrito.com\nsuperstachel.de\nsuremail.info\nsvk.jp\nsweetxxx.de\nswift10minutemail.com\nsylvannet.com\nt.psh.me\ntafmail.com\ntafoi.gr\ntagmymedia.com\ntagyourself.com\ntalkinator.com\ntanukis.org\ntapchicuoihoi.com\ntb-on-line.net\nte.adiq.eu\ntechemail.com\ntechgroup.me\nteewars.org\ntelecomix.pl\nteleworm.com\nteleworm.us\ntemp-mail.com\ntemp-mail.de\ntemp-mail.org\ntemp-mail.ru\ntemp.bartdevos.be\ntemp.emeraldwebmail.com\ntemp.headstrong.de\ntempail.com\ntempalias.com\ntempe-mail.com\ntempemail.biz\ntempemail.co.za\ntempemail.com\ntempemail.net\ntempinbox.co.uk\ntempinbox.com\ntempmail.co\ntempmail.eu\ntempmail.it\ntempmail2.com\ntempmaildemo.com\ntempmailer.com\ntempmailer.de\ntempomail.fr\ntemporarily.de\ntemporarioemail.com.br\ntemporaryemail.net\ntemporaryemail.us\ntemporaryforwarding.com\ntemporaryinbox.com\ntemporarymailaddress.com\ntempsky.com\ntempthe.net\ntempymail.com\ntestudine.com\nth.edgex.ru\nthanksnospam.info\nthankyou2010.com\nthc.st\ntheaviors.com\nthebearshark.com\nthecloudindex.com\nthediamants.org\nthelimestones.com\nthembones.com.au\nthemostemail.com\nthereddoors.online\nthescrappermovie.com\ntheteastory.info\nthietbivanphong.asia\nthisisnotmyrealemail.com\nthismail.net\nthisurl.website\nthnikka.com\nthraml.com\nthrma.com\nthroam.com\nthrott.com\nthrowawayemailaddress.com\nthrowawaymail.com\nthunkinator.org\nthxmate.com\ntilien.com\ntimgiarevn.com\ntimkassouf.com\ntinyurl24.com\ntittbit.in\ntizi.com\ntlpn.org\ntm.tosunkaya.com\ntmail.com\ntmail.ws\ntmailinator.com\ntmpjr.me\ntoddsbighug.com\ntoiea.com\ntokem.co\ntokenmail.de\ntonymanso.com\ntoomail.biz\ntop101.de\ntop1mail.ru\ntop1post.ru\ntopofertasdehoy.com\ntopranklist.de\ntoprumours.com\ntormail.org\ntoss.pw\ntotalvista.com\ntotesmail.com\ntp-qa-mail.com\ntradermail.info\ntranceversal.com\ntrash-amil.com\ntrash-mail.at\ntrash-mail.cf\ntrash-mail.com\ntrash-mail.de\ntrash-mail.ga\ntrash-mail.gq\ntrash-mail.ml\ntrash-mail.tk\ntrash2009.com\ntrash2010.com\ntrash2011.com\ntrashcanmail.com\ntrashdevil.com\ntrashdevil.de\ntrashemail.de\ntrashinbox.com\ntrashmail.at\ntrashmail.com\ntrashmail.de\ntrashmail.me\ntrashmail.net\ntrashmail.org\ntrashmail.ws\ntrashmailer.com\ntrashymail.com\ntrashymail.net\ntrasz.com\ntrayna.com\ntrbvm.com\ntrbvn.com\ntrbvo.com\ntrialmail.de\ntrickmail.net\ntrillianpro.com\ntrollproject.com\ntropicalbass.info\ntrungtamtoeic.com\ntryalert.com\nttszuo.xyz\ntualias.com\nturoid.com\nturual.com\ntwinmail.de\ntwoweirdtricks.com\ntxtadvertise.com\nty.ceed.se\ntyldd.com\nu.42o.org\nu.duk33.com\nu.hs.vc\nu.jdz.ro\nu.mji.ro\nu.qibl.at\nu.oroki.de\nu.ozyl.de\nu.rvb.ro\nu.thex.ro\nu.tkitc.de\nu.wef.gr\nubismail.net\nufacturing.com\nuggsrock.com\nuguuchantele.com\nuhhu.ru\numail.net\nunimark.org\nunit7lahaina.com\nunmail.ru\nupliftnow.com\nuplipht.com\nuploadnolimit.com\nurfunktion.se\nuroid.com\nus.af\nusername.e4ward.com\nutiket.us\nuwork4.us\nux.dob.jp\nux.uk.to\nuyhip.com\nvaati.org\nvalemail.net\nvalhalladev.com\nvenompen.com\nverdejo.com\nveryday.ch\nveryday.eu\nveryday.info\nveryrealemail.com\nvfemail.net\nvg.dab.ro\nvictoriantwins.com\nvidchart.com\nviditag.com\nviewcastmedia.com\nviewcastmedia.net\nviewcastmedia.org\nvikingsonly.com\nvinernet.com\nvipmail.name\nvipmail.pw\nvipxm.net\nviralplays.com\nvixletdev.com\nvkcode.ru\nvmailing.info\nvmani.com\nvmpanda.com\nvo.yoo.ro\nvoidbay.com\nvomoto.com\nvorga.org\nvotiputox.org\nvoxelcore.com\nvp.ycare.de\nvpn.st\nvsimcard.com\nvubby.com\nvztc.com\nwakingupesther.com\nwalala.org\nwalkmail.net\nwalkmail.ru\nwasteland.rfc822.org\nwatch-harry-potter.com\nwatchever.biz\nwatchfull.net\nwatchironman3onlinefreefullmovie.com\nwbml.net\nwe.geteit.com\nwe.ldop.com\nwe.ldtp.com\nwe.qq.my\nwe.vrmtr.com\nwe.wallm.com\nweb-mail.pp.ua\nwebemail.me\nwebm4il.info\nwebtrip.ch\nwebuser.in\nwee.my\nwefjo.grn.cc\nweg-werf-email.de\nwegwerf-email-addressen.de\nwegwerf-email-adressen.de\nwegwerf-email.de\nwegwerf-email.net\nwegwerf-emails.de\nwegwerfadresse.de\nwegwerfemail.com\nwegwerfemail.de\nwegwerfemail.net\nwegwerfemail.org\nwegwerfemailadresse.com\nwegwerfmail.de\nwegwerfmail.info\nwegwerfmail.net\nwegwerfmail.org\nwegwerpmailadres.nl\nwegwrfmail.de\nwegwrfmail.net\nwegwrfmail.org\nwelikecookies.com\nwetrainbayarea.com\nwetrainbayarea.org\nwg0.com\nwh4f.org\nwhatiaas.com\nwhatifanalytics.com\nwhatpaas.com\nwhatsaas.com\nwhiffles.org\nwhopy.com\nwhtjddn.33mail.com\nwhyspam.me\nwibblesmith.com\nwickmail.net\nwidget.gg\nwilemail.com\nwillhackforfood.biz\nwillselfdestruct.com\nwimsg.com\nwinemaven.info\nwmail.cf\nwolfsmail.tk\nwollan.info\nworldspace.link\nwovz.cu.cc\nwr.moeri.org\nwralawfirm.com\nwriteme.us\nwronghead.com\nws.yodx.ro\nwuzup.net\nwuzupmail.net\nwww.bccto.me\nwww.e4ward.com\nwww.gishpuppy.com\nwww.mailinator.com\nwwwnew.eu\nx.ip6.li\nx1x.spb.ru\nx24.com\nxagloo.co\nxagloo.com\nxcompress.com\nxcpy.com\nxemaps.com\nxents.com\nxing886.uu.gl\nxjoi.com\nxmail.com\nxmaily.com\nxn--9kq967o.com\nxoxox.cc\nxrho.com\nxwaretech.com\nxwaretech.info\nxwaretech.net\nxww.ro\nxyzfree.net\ny.bcb.ro\ny.epb.ro\ny.gzb.ro\ny.tyhe.ro\nyanet.me\nyapped.net\nyaqp.com\nye.nonze.ro\nyep.it\nyert.ye.vc\nyhg.biz\nynmrealty.com\nyogamaven.com\nyomail.info\nyopmail.com\nyopmail.fr\nyopmail.gq\nyopmail.net\nyopmail.pp.ua\nyou-spam.com\nyougotgoated.com\nyoumail.ga\nyoumailr.com\nyouneedmore.info\nyourdomain.com\nyourewronghereswhy.com\nyourlms.biz\nypmail.webarnak.fr.eu.org\nyspend.com\nyugasandrika.com\nyui.it\nyuurok.com\nyxzx.net\nz1p.biz\nza.com\nze.gally.jp\nzebins.com\nzebins.eu\nzehnminuten.de\nzehnminutenmail.de\nzepp.dk\nzetmail.com\nzippymail.info\nzipsendtest.com\nzoaxe.com\nzoemail.com\nzoemail.net\nzoemail.org\nzoetropes.org\nzombie-hive.com\nzomg.info\nzumpul.com\nzxcv.com\nzxcvbnm.com\nzzz.com\" WHERE `fieldname` = 'spam_blocked_email_domains';";
	$new_version = '1.2.1';
}
