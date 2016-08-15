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

// time changes
$query = "DROP TABLE IF EXISTS `" . $DBPrefix . "temp_install`;";
$db->direct_query($query);
$query = "CREATE TABLE `" . $DBPrefix . "temp_install` (
  `id` int(11) NOT NULL auto_increment,
  `table` varchar(20) NOT NULL,
  `table_id` int(11) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);";
$db->direct_query($query);
/* tables changes
users.reg_date
users.lastlogin
adminusers.created
adminusers.lastlogin
accounts.paid_date
bids.bidwhen
comm_messages.msgdate
community.lastmessage
feedbacks.feedbackdate
logs.timestamp
messages.sentat
news.new_date
online.time
pendingnotif.thisdate
useraccounts.date
*/
$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `reg_date` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "users` MODIFY `lastlogin` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `created` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "adminusers` MODIFY `lastlogin` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "accounts` MODIFY `paid_date` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "bids` MODIFY `bidwhen` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "comm_messages` MODIFY `msgdate` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "feedbacks` MODIFY `feedbackdate` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "logs` MODIFY `timestamp` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "messages` MODIFY `sentat` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "news` MODIFY `new_date` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "online` MODIFY `time` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "pendingnotif` MODIFY `thisdate` datetime default CURRENT_TIMESTAMP;";
$query[] = "ALTER TABLE `" . $DBPrefix . "useraccounts` MODIFY `date` datetime default CURRENT_TIMESTAMP;";

// TODO: convert dates to new format and insert them into temp_install before changing dateformat
