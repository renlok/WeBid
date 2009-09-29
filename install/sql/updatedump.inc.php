<?php
//0.8.1 to 0.8.2
$query[] = "UPDATE `" . $DBPrefix . "gateways` SET gateways = 'paypal,authnet'";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyer_fee');";
$query[] = "ALTER TABLE  `" . $DBPrefix . "winners` ADD  `bf_paid` INT(1) NOT NULL DEFAULT '0';";

?>