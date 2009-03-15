ALTER TABLE `webid_settings` DROP `feetype`, DROP `sellersetupfee`, DROP `sellersetuptype`, DROP `sellerfinalfee`, DROP `sellerfinaltype`, DROP `sellersetupvalue`, DROP `sellerfinalvalue`, DROP `buyerfinalfee`, DROP `buyerfinaltype`, DROP `buyerfinalvalue`, DROP `paypaladdress`, DROP `picturesgalleryfee`, DROP `picturesgalleryvalue`, DROP `featureditemsnumber`, DROP `featuredcolumns`, DROP `thimbnailswidth`, DROP `catfeatureditemsnumber`, DROP `catthumbnailswidth`, DROP `reservefee`, DROP `reservetype`, DROP `reservevalue`, DROP `freecatstext`, DROP `sitemap`, DROP `wanted`;
ALTER TABLE `webid_settings` ADD `https` enum('y','n') NOT NULL default 'n';
ALTER TABLE `webid_settings` ADD `bn_only_disable` enum('y','n') NOT NULL default 'n';
ALTER TABLE `webid_settings` ADD `bn_only_percent` int(3) NOT NULL default '50';
ALTER TABLE `webid_rates` DROP `rate`, DROP `sifra`;
DROP TABLE IF EXISTS `webid_lastupdate`;
ALTER TABLE `webid_users` ADD `bn_only` enum('y','n') NOT NULL default 'y'