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

$query = "SELECT * FROM " . $DBPrefix . "settings;";
$db->direct_query($query);
$settings_data = $db->result();
$settings = array_combine(array_keys($settings_data), $settings_data);
foreach ($settings as $setting_name => $setting_value)
{
    switch($setting_name)
    {
        // str
        case "ao_hpf_enabled":
        case "ao_hi_enabled":
        case "ao_bi_enabled":
        case "subtitle":
        case "extra_cat":
        case "autorelist":
        case "ae_status":

            $type = 'str';
            break;
        // int
        case "autorelist_max":
        case "edit_starttime":
        case "cust_increment":
        case "hours_countdown":
        case "ae_timebefore":
        case "ae_extend":
        case "picturesgallery":
        case "maxpictures":
        case "maxuploadsize":
        case "thumb_show":
            $type = 'int';
            break;
        //     bool
        case "aboutus":
        case "proxy_bidding":
            $type = 'bool';
            break;
        // float
        /*
        case "":

            $type = 'float';
            break;

        */

        default:
        $type = 'string';
            break;
    }
    if ($setting_name == 'timezone')
    {
        $setting_value = 'Europe/London';
    }
    $query = "INSERT INTO " . $DBPrefix . "settingsv2 (fieldname, fieldtype, value, modifieddate, modifiedby) VALUES
            ('$setting_name', '$type', '$setting_value', UNIX_TIMESTAMP(), 1);";
    $db->direct_query($query);
}

// drop old table
$query = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
$db->direct_query($query);
// rename new table
$query = "RENAME TABLE `" . $DBPrefix . "settingsv2` TO `" . $DBPrefix . "settings`;";
$db->direct_query($query);

// convert database values to bools
$query = "SELECT id, bn_only, bold, highlighted, featured, tax, taxinc FROM " . $DBPrefix . "auctions;";
$db->direct_query($query);
$auctions_data = $db->fetchall();
// convert
$query = "ALTER TABLE `" . $DBPrefix . "auctions` MODIFY `bn_only` tinyint(1) DEFAULT 0, MODIFY `bold` tinyint(1) DEFAULT 0, MODIFY `highlighted` tinyint(1) DEFAULT 0, MODIFY `featured` tinyint(1) DEFAULT 0, MODIFY `tax` tinyint(1) DEFAULT 0, MODIFY `taxinc` tinyint(1) DEFAULT 0;";
$db->direct_query($query);
if (count($auctions_data) > 0)
{
    foreach ($auctions_data as $auction)
    {
        $query = "UPDATE `" . $DBPrefix . "auctions`
                SET bn_only = " . intval($auction['bn_only'] == 'y') . ",
                bold = " . intval($auction['bold'] == 'y') . ",
                highlighted = " . intval($auction['highlighted'] == 'y') . ",
                featured = " . intval($auction['featured'] == 'y') . ",
                tax = " . intval($auction['tax'] == 'y') . ",
                taxinc = " . intval($auction['taxinc'] == 'y') . ",
                WHERE id = " . $auction['id'];
        $db->direct_query($query);
    }
}

// fix payments options
