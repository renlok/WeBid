<?php
//0.8.0 to 0.8.1
$query[] = "ALTER TABLE `" . $DBPrefix . "gateways` ADD `authnet_address` varchar(50) NOT NULL default '' ADD `authnet_password` varchar(50) NOT NULL default ''
			ADD `authnet_required` int(1) NOT NULL default '0' ADD `authnet_active` int(1) NOT NULL default '0'";
$query[] = "INSERT INTO `" . $DBPrefix . "payments` VALUES (3, 'Authorize.net');";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` ADD `authnet_email` varchar(50) default NULL";

?>