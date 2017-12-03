<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

// time changes
$query = "DROP TABLE IF EXISTS `" . $DBPrefix . "temp_install`;";
$db->direct_query($query);
$query = "CREATE TABLE `" . $DBPrefix . "temp_install` (
  `id` int(11) NOT NULL auto_increment,
  `table` varchar(20) NOT NULL,
  `table_colomn` varchar(20) NOT NULL,
  `table_id` int(11) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  `new_value` datetime default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
);";
$db->direct_query($query);

// adminusers.created date('Ymd')
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "adminusers', 'created', id, created, STR_TO_DATE(created, '%Y%m%d') FROM `" . $DBPrefix . "adminusers`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "adminusers` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "adminusers' AND table_colomn = 'created') src SET dest.created = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `created` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// adminusers.lastlogin time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "adminusers', 'lastlogin', id, lastlogin, FROM_UNIXTIME(lastlogin) FROM `" . $DBPrefix . "adminusers`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "adminusers` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "adminusers' AND table_colomn = 'lastlogin') src SET dest.lastlogin = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `lastlogin` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// accounts.paid_date time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "accounts', 'paid_date', id, paid_date, FROM_UNIXTIME(paid_date) FROM `" . $DBPrefix . "accounts`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "accounts` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "accounts' AND table_colomn = 'paid_date') src SET dest.paid_date = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "accounts` MODIFY `paid_date` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// auctions.starts time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "auctions', 'starts', id, starts, FROM_UNIXTIME(starts) FROM `" . $DBPrefix . "auctions`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "auctions` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "auctions' AND table_colomn = 'starts') src SET dest.starts = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `starts` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// auctions.ends time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "auctions', 'ends', id, ends, FROM_UNIXTIME(ends) FROM `" . $DBPrefix . "auctions`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "auctions` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "auctions' AND table_colomn = 'ends') src SET dest.ends = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `ends` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// bids.bidwhen time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "bids', 'bidwhen', id, bidwhen, FROM_UNIXTIME(bidwhen) FROM `" . $DBPrefix . "bids`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "bids` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "bids' AND table_colomn = 'bidwhen') src SET dest.bidwhen = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "bids` MODIFY `bidwhen` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// comm_messages.msgdate time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "comm_messages', 'msgdate', id, msgdate, FROM_UNIXTIME(msgdate) FROM `" . $DBPrefix . "comm_messages`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "comm_messages` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "comm_messages' AND table_colomn = 'msgdate') src SET dest.msgdate = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "comm_messages` MODIFY `msgdate` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// community.lastmessage time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "community', 'lastmessage', id, lastmessage, FROM_UNIXTIME(lastmessage) FROM `" . $DBPrefix . "community`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "community` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "community' AND table_colomn = 'lastmessage') src SET dest.lastmessage = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "community` MODIFY `lastmessage` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// feedbacks.feedbackdate time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "feedbacks', 'feedbackdate', id, feedbackdate, FROM_UNIXTIME(feedbackdate) FROM `" . $DBPrefix . "feedbacks`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "feedbacks` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "feedbacks' AND table_colomn = 'feedbackdate') src SET dest.feedbackdate = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "feedbacks` MODIFY `feedbackdate` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// logs.timestamp time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "logs', 'timestamp', id, timestamp, FROM_UNIXTIME(timestamp) FROM `" . $DBPrefix . "logs`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "logs` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "logs' AND table_colomn = 'timestamp') src SET dest.timestamp = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "logs` MODIFY `timestamp` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// messages.sentat time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "messages', 'sentat', id, sentat, FROM_UNIXTIME(sentat) FROM `" . $DBPrefix . "messages`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "messages` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "messages' AND table_colomn = 'sentat') src SET dest.sentat = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `sentat` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// news.new_date time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "news', 'new_date', id, new_date, FROM_UNIXTIME(new_date) FROM `" . $DBPrefix . "news`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "news` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "news' AND table_colomn = 'new_date') src SET dest.new_date = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "news` MODIFY `new_date` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// online.time time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "online', 'time', id, time, FROM_UNIXTIME(time) FROM `" . $DBPrefix . "online`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "online` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "online' AND table_colomn = 'time') src SET dest.time = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "online` MODIFY `time` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// pendingnotif.thisdate gmdate('Ymd')
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "pendingnotif', 'thisdate', id, thisdate, STR_TO_DATE(thisdate, '%Y%m%d') FROM `" . $DBPrefix . "pendingnotif`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "pendingnotif` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "pendingnotif' AND table_colomn = 'thisdate') src SET dest.thisdate = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "pendingnotif` MODIFY `thisdate` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// users.reg_date time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "users', 'reg_date', id, reg_date, FROM_UNIXTIME(reg_date) FROM `" . $DBPrefix . "users`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "users` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "users' AND table_colomn = 'reg_date') src SET dest.reg_date = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `reg_date` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// users.lastlogin date("Y-m-d H:i:s")
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "users', 'lastlogin', id, lastlogin, STR_TO_DATE(lastlogin, '%Y-%m-%d %H:%i:%s') FROM `" . $DBPrefix . "users`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "users` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "users' AND table_colomn = 'lastlogin') src SET dest.lastlogin = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `lastlogin` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// useraccounts.date time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "useraccounts', 'date', id, `date`, FROM_UNIXTIME(`date`) FROM `" . $DBPrefix . "useraccounts`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "useraccounts` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "useraccounts' AND table_colomn = 'date') src SET dest.`date` = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "useraccounts` MODIFY `date` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);
// winners.closingdate time()
$query = "INSERT INTO `" . $DBPrefix . "temp_install` (`table`, `table_colomn`, `table_id`, `old_value`, `new_value`)
        VALUES (SELECT '" . $DBPrefix . "winners', 'closingdate', id, closingdate, FROM_UNIXTIME(closingdate) FROM `" . $DBPrefix . "winners`);";
$db->direct_query($query);
$query = "UPDATE `" . $DBPrefix . "winners` dest, (SELECT * FROM `" . $DBPrefix . "temp_install` WHERE table = '" . $DBPrefix . "winners' AND table_colomn = 'closingdate') src SET dest.closingdate = src.new_value where dest.id = src.table_id;";
$db->direct_query($query);
$query = "ALTER TABLE `" . $DBPrefix . "winners` MODIFY `closingdate` datetime default CURRENT_TIMESTAMP;";
$db->direct_query($query);

$query = "DROP TABLE IF EXISTS `" . $DBPrefix . "temp_install`;";
$db->direct_query($query);

// remove unused files and folders from previous versions
rmf('../includes/functions_rebuild.php');
rmf('../includes/membertypes.inc.php');
