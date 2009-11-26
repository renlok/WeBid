<?php
//0.8.3 to 0.8.4
$query[] = "ALTER TABLE  `" . $DBPrefix . "messages` ADD `fromemail` varchar(50) NOT NULL default '';";

?>