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

if (!defined('InWeBid')) {
    exit('Access denied');
}

$timezones = array(
        'Pacific/Midway' => '(UTC-11:00) Midway Island, Samoa',
        'Pacific/Honolulu' => '(UTC-10:00) Hawaii-Aleutian',
        'Pacific/Marquesas' => '(UTC-09:30) Marquesas Islands',
        'Pacific/Gambier' => '(UTC-09:00) Gambier Islands',
        'America/Anchorage' => '(UTC-09:00) Alaska',
        'America/Ensenada' => '(UTC-08:00) Tijuana, Baja California',
        'Etc/GMT+8' => '(UTC-08:00) Pitcairn Islands',
        'America/Los_Angeles' => '(UTC-08:00) Pacific Time (US & Canada)',
        'America/Denver' => '(UTC-07:00) Mountain Time (US & Canada)',
        'America/Chihuahua' => '(UTC-07:00) Chihuahua, La Paz, Mazatlan',
        'America/Dawson_Creek' => '(UTC-07:00) Arizona',
        'America/Belize' => '(UTC-06:00) Saskatchewan, Central America',
        'America/Cancun' => '(UTC-06:00) Guadalajara, Mexico City, Monterrey',
        'Chile/EasterIsland' => '(UTC-06:00) Easter Island',
        'America/Chicago' => '(UTC-06:00) Central Time (US & Canada)',
        'America/New_York' => '(UTC-05:00) Eastern Time (US & Canada)',
        'America/Havana' => '(UTC-05:00) Cuba',
        'America/Bogota' => '(UTC-05:00) Bogota, Lima, Quito, Rio Branco',
        'America/Caracas' => '(UTC-04:30) Caracas',
        'America/Santiago' => '(UTC-04:00) Santiago',
        'America/La_Paz' => '(UTC-04:00) La Paz',
        'Atlantic/Stanley' => '(UTC-04:00) Falkland Islands',
        'America/Campo_Grande' => '(UTC-04:00) Brazil',
        'America/Goose_Bay' => '(UTC-04:00) Atlantic Time (Goose Bay)',
        'America/Glace_Bay' => '(UTC-04:00) Atlantic Time (Canada)',
        'America/St_Johns' => '(UTC-03:30) Newfoundland',
        'America/Araguaina' => '(UTC-03:00) UTC-3',
        'America/Montevideo' => '(UTC-03:00) Montevideo',
        'America/Miquelon' => '(UTC-03:00) Miquelon, St. Pierre',
        'America/Godthab' => '(UTC-03:00) Greenland',
        'America/Argentina/Buenos_Aires' => '(UTC-03:00) Buenos Aires',
        'America/Sao_Paulo' => '(UTC-03:00) Brasilia',
        'America/Noronha' => '(UTC-02:00) Mid-Atlantic',
        'Atlantic/Cape_Verde' => '(UTC-01:00) Cape Verde Is.',
        'Atlantic/Azores' => '(UTC-01:00) Azores',
        'Europe/Dublin' => '(UTC) Irish Standard Time : Dublin',
        'Europe/Lisbon' => '(UTC) Western European Time : Lisbon',
        'Europe/London' => '(GMT) Greenwich Mean Time : London, Belfast',
        'Africa/Abidjan' => '(GMT) Monrovia, Reykjavik',
        'Europe/Amsterdam' => '(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
        'Europe/Belgrade' => '(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
        'Europe/Brussels' => '(UTC+01:00) Brussels, Copenhagen, Madrid, Paris',
        'Africa/Algiers' => '(UTC+01:00) West Central Africa',
        'Africa/Windhoek' => '(UTC+01:00) Windhoek',
        'Asia/Beirut' => '(UTC+02:00) Beirut',
        'Africa/Cairo' => '(UTC+02:00) Cairo',
        'Asia/Gaza' => '(UTC+02:00) Gaza',
        'Africa/Johannesburg' => '(UTC+02:00) Johannesburg, Harare, Pretoria',
        'Asia/Jerusalem' => '(UTC+02:00) Jerusalem',
        'Europe/Athens' => '(UTC+02:00) Athens',
        'Europe/Minsk' => '(UTC+02:00) Minsk',
        'Asia/Damascus' => '(UTC+02:00) Syria',
        'Europe/Moscow' => '(UTC+03:00) Moscow, St. Petersburg, Volgograd',
        'Africa/Addis_Ababa' => '(UTC+03:00) Nairobi',
        'Asia/Tehran' => '(UTC+03:30) Tehran',
        'Asia/Dubai' => '(UTC+04:00) Abu Dhabi, Muscat',
        'Asia/Yerevan' => '(UTC+04:00) Yerevan',
        'Asia/Kabul' => '(UTC+04:30) Kabul',
        'Asia/Yekaterinburg' => '(UTC+05:00) Ekaterinburg',
        'Asia/Tashkent' => '(UTC+05:00) Tashkent',
        'Asia/Kolkata' => '(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi',
        'Asia/Katmandu' => '(UTC+05:45) Kathmandu',
        'Asia/Dhaka' => '(UTC+06:00) Astana, Dhaka',
        'Asia/Novosibirsk' => '(UTC+06:00) Novosibirsk',
        'Asia/Rangoon' => '(UTC+06:30) Yangon (Rangoon)',
        'Asia/Bangkok' => '(UTC+07:00) Bangkok, Hanoi, Jakarta',
        'Asia/Krasnoyarsk' => '(UTC+07:00) Krasnoyarsk',
        'Asia/Hong_Kong' => '(UTC+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
        'Asia/Irkutsk' => '(UTC+08:00) Irkutsk, Ulaan Bataar',
        'Australia/Perth' => '(UTC+08:00) Perth',
        'Australia/Eucla' => '(UTC+08:45) Eucla',
        'Asia/Tokyo' => '(UTC+09:00) Osaka, Sapporo, Tokyo',
        'Asia/Seoul' => '(UTC+09:00) Seoul',
        'Asia/Yakutsk' => '(UTC+09:00) Yakutsk',
        'Australia/Adelaide' => '(UTC+09:30) Adelaide',
        'Australia/Darwin' => '(UTC+09:30) Darwin',
        'Australia/Sydney' => '(UTC+10:00) Sydney, Canberra, Melbourne, Hobart',
        'Australia/Brisbane' => '(UTC+10:00) Brisbane',
        'Asia/Vladivostok' => '(UTC+10:00) Vladivostok',
        'Australia/Lord_Howe' => '(UTC+10:30) Lord Howe Island',
        'Etc/GMT-11' => '(UTC+11:00) Solomon Is., New Caledonia',
        'Asia/Magadan' => '(UTC+11:00) Magadan',
        'Pacific/Norfolk' => '(UTC+11:30) Norfolk Island',
        'Asia/Anadyr' => '(UTC+12:00) Anadyr, Kamchatka',
        'Pacific/Auckland' => '(UTC+12:00) Auckland, Wellington',
        'Etc/GMT-12' => '(UTC+12:00) Fiji, Kamchatka, Marshall Is.',
        'Pacific/Chatham' => '(UTC+12:45) Chatham Islands',
        'Pacific/Tongatapu' => '(UTC+13:00) Nuku Alofa',
        'Pacific/Kiritimati' => '(UTC+14:00) Kiritimati'
    );
