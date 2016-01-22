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

$query = "SELECT * FROM settings;"
$db->direct_query($query);
$settings_data = $db->fetchall();
$settings = array_combine(array_keys($settings_data), $settings_data);
foreach ($settings as $setting_name => $setting_value)
{
    switch($setting_name)
    {
        // str
        case "cust_increment":
        case "ao_hpf_enabled":
        case "ao_hi_enabled":
        case "ao_bi_enabled":
        case "subtitle":
        case "extra_cat":
        case "autorelist":
        case "ae_status":
        case "ao_bi_enabled":
        case "ao_bi_enabled":

            $type = 'str';
            break;
        // int
        case "autorelist_max":
        case "edit_starttime":
        case "cust_increment":
        case "hours_countdown":
        case "autorelist_max":
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
    $query = "INSERT INTO " . $DBPrefix . "settings (fieldname, fieldtype, value, modifieddate, modifiedby) VALUES
            ($setting_name, :$type, :$setting_value, UNIX_TIMESTAMP(), 1);";
    $db->direct_query($query);
}

// drop old table
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
$db->direct_query($query);
// rename new table
$query[] = "RENAME TABLE `" . $DBPrefix . "settings` TO `" . $DBPrefix . "settings`;;";
$db->direct_query($query);
