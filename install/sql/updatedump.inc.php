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
}

if ($myversion == '0.8.1')
{
	//0.8.1 to 0.8.2
	$query[] = "UPDATE `" . $DBPrefix . "gateways` SET gateways = 'paypal,authnet';";
	$query[] = "INSERT INTO `" . $DBPrefix . "fees` (value, type) VALUES (0, 'buyer_fee');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `bf_paid` INT(1) NOT NULL default '0';";
	$query[] = "ALTER TABLE `" . $DBPrefix . "auctions` ADD `current_fee` double(16,4) default '0.00';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.2';";
}

if ($myversion == '0.8.2')
{
	//0.8.2 to 0.8.3
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.3';";
}

if ($myversion == '0.8.3')
{
	//0.8.3 to 0.8.4
	$query[] = "ALTER TABLE `" . $DBPrefix . "messages` ADD `fromemail` varchar(50) NOT NULL default '';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.4';";
}

if ($myversion == '0.8.4')
{
	//0.8.4 to 0.8.5
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.5';";
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
}

if ($myversion == '1.0.0')
{
	//1.0.0 to 1.0.1
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.1';";
}

if ($myversion == '1.0.1')
{
	//1.0.1 to 1.0.2
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.2';";
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
}
?>