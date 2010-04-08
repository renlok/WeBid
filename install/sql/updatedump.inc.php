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
	$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `authnet_address` varchar(50) NOT NULL default '' ADD `authnet_password` varchar(50) NOT NULL default ''
				ADD `authnet_required` int(1) NOT NULL default '0' ADD `authnet_active` int(1) NOT NULL default '0'";
	$query[] = "INSERT INTO `" . $DBPrefix . "payments` VALUES (3, 'Authorize.net');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `authnet_id` varchar(50) default '' ADD `authnet_pass` varchar(50) default ''";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.1'";
}

if ($myversion == '0.8.1')
{
	//0.8.1 to 0.8.2
	$query[] = "UPDATE `" . $DBPrefix . "gateways` SET gateways = 'paypal,authnet'";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyer_fee');";
	$query[] = "ALTER TABLE  `" . $DBPrefix . "winners` ADD `bf_paid` INT(1) NOT NULL DEFAULT '0';";
	$query[] = "ALTER TABLE  `" . $DBPrefix . "auctions` ADD `current_fee` double(16,4) default '0.00';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.2'";
}

if ($myversion == '0.8.2')
{
	//0.8.2 to 0.8.3
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.3'";
}

if ($myversion == '0.8.3')
{
	//0.8.3 to 0.8.4
	$query[] = "ALTER TABLE  `" . $DBPrefix . "messages` ADD `fromemail` varchar(50) NOT NULL default '';";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.4'";
}

if ($myversion == '0.8.4')
{
	//0.8.4 to 0.8.5
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '0.8.5'";
}

if ($myversion == '0.8.5')
{
	//0.8.5 to 1.0.0
	$query[] = "ALTER TABLE  `" . $DBPrefix . "settings` DROP uniqueseller DROP pagewidth DROP alignment DROP pagewidthtype DROP background DROP brepeat
				ADD `perpage` int(10) NOT NULL default '15' DROP banner_sizetype DROP picturesgallery;";
	$query[] = "ALTER TABLE `" . $DBPrefix . "settings` ADD `subtitle` ENUM('y','n') NOT NULL DEFAULT 'y'
				ADD `extra_cat` ENUM('y','n') NOT NULL DEFAULT 'n'
				ADD `mod_queue` ENUM('y','n') NOT NULL DEFAULT 'n'
				ADD `thumb_list` INT( 6 ) NOT NULL DEFAULT '120'
				ADD `https_url` varchar(255) NOT NULL default ''";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fontsandcolors`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "tmp_closed_edited`;";
	$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currencies`;";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'endauc_fee');";
	$query[] = "ALTER TABLE `" . $DBPrefix . "winners` ADD `ff_paid` int(1) NOT NULL DEFAULT '1'";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'subtitle_fee');";
	$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'excat_fee');";
	$query[] = "ALTER TABLE " . $DBPrefix . "auctions ADD `secondcat` int(11) default NULL AFTER `category`
				ADD `subtitle` VARCHAR(70) NOT NULL AFTER `title`";
	$query[] = "UPDATE `" . $DBPrefix . "settings` SET `version` = '1.0.0'";
}
?>