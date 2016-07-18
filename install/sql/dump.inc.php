<?php

#
# Table structure for table `" . $DBPrefix . "accesseshistoric`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "accesseshistoric`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "accesseshistoric` (
  `month` char(2) NOT NULL default '',
  `year` char(4) NOT NULL default '',
  `pageviews` int(11) NOT NULL default '0',
  `uniquevisitors` int(11) NOT NULL default '0',
  `usersessions` int(11) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "accesseshistoric`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "accounts`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "accounts`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "accounts` (
	`id` INT(7) NOT NULL AUTO_INCREMENT,
	`nick` VARCHAR(20) NOT NULL,
	`name` TINYTEXT NOT NULL,
	`text` TEXT NOT NULL,
	`type` VARCHAR(15) NOT NULL,
	`paid_date` VARCHAR(16) NOT NULL,
	`amount` DOUBLE(6,2) NOT NULL,
	`day` INT(3) NOT NULL,
	`week` INT(2) NOT NULL,
	`month` INT(2) NOT NULL,
	`year` INT(4) NOT NULL,
    PRIMARY KEY  (`id`)
)";

#
# Dumping data for table `" . $DBPrefix . "accounts`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "adminusers`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "adminusers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "adminusers` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_type` INT(1) NOT NULL DEFAULT '1',
  `hash` varchar(5) NOT NULL default '',
  `created` varchar(8) NOT NULL default '',
  `lastlogin` varchar(14) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `notes` text,
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "adminusers`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "auccounter`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auccounter`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "auccounter` (
  `auction_id` int(11) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`auction_id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "auccounter`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "auctions`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auctions`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "auctions` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) default NULL,
  `title` varchar(70),
  `subtitle` varchar(70),
  `starts` varchar(14) default NULL,
  `description` text,
  `pict_url` tinytext,
  `category` int(11) default NULL,
  `secondcat` int(11) default NULL,
  `minimum_bid` double(16,2) default '0',
  `shipping_cost` double(16,2) default '0',
  `additional_shipping_cost` double(16,2) default '0',
  `reserve_price` double(16,2) default '0',
  `buy_now` double(16,2) default '0',
  `auction_type` int(1),
  `duration` double(8,2),
  `increment` double(8,2) NOT NULL default '0',
  `shipping` int(1) default 1,
  `payment` tinytext,
  `international` tinyint(1) default 0,
  `ends` varchar(14) default NULL,
  `current_bid` double(16,2) default '0',
  `current_bid_id` int(11) default '0',
  `closed` tinyint(1) default '0',
  `photo_uploaded` tinyint(1) default 0,
  `initial_quantity` int(11) default '1',
  `quantity` int(11) default '1',
  `suspended` int(1) default '0',
  `relist` int(11) NOT NULL default '0',
  `relisted` int(11) NOT NULL default '0',
  `num_bids` int(11) NOT NULL default '0',
  `sold` enum('y', 'n', 's') NOT NULL default 'n',
  `shipping_terms` tinytext,
  `bn_only` tinyint(1) default 0,
  `bold` tinyint(1) default 0,
  `highlighted` tinyint(1) default 0,
  `featured` tinyint(1) default 0,
  `current_fee` double(16,2) default '0',
  `tax` tinyint(1) default 0,
  `taxinc` tinyint(1) default 0,
  `bn_sale` tinyint(1) default 0,
  PRIMARY KEY  (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "auctions`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "auction_moderation`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auction_moderation`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "auction_moderation` (
  `id` int(11) NOT NULL auto_increment,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `reason` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY(`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "auction_moderation`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "auction_types`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auction_types`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "auction_types` (
  `id` int(2) NOT NULL auto_increment,
  `key` varchar(32),
  `language_string` varchar(32),
  PRIMARY KEY  (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "auction_types`
#

$query[] = "INSERT INTO `" . $DBPrefix . "auction_types` VALUES(1, 'standard', 1021);";
$query[] = "INSERT INTO `" . $DBPrefix . "auction_types` VALUES(2, 'dutch', 1020);";


# ############################

#
# Table structure for table `" . $DBPrefix . "banners`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "banners`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "banners` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `type` enum('gif','jpg','png','swf') default NULL,
  `views` int(11) default NULL,
  `clicks` int(11) default NULL,
  `url` varchar(255) default NULL,
  `sponsortext` varchar(255) default NULL,
  `alt` varchar(255) default NULL,
  `purchased` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `user` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "banners`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "bannerscategories`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannerscategories`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannerscategories` (
  `banner` int(11) NOT NULL default '0',
  `category` int(11) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "bannerscategories`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "bannerskeywords`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannerskeywords`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannerskeywords` (
  `banner` int(11) NOT NULL default '0',
  `keyword` varchar(255) NOT NULL default ''
) ;";

#
# Dumping data for table `" . $DBPrefix . "bannerskeywords`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "bannersstats`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannersstats`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannersstats` (
  `banner` int(11) default NULL,
  `purchased` int(11) default NULL,
  `views` int(11) default NULL,
  `clicks` int(11) default NULL
) ;";

#
# Dumping data for table `" . $DBPrefix . "bannersstats`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "bannersusers`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannersusers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannersusers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `company` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "bannersusers`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "bids`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bids`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bids` (
  `id` int(11) NOT NULL auto_increment,
  `auction` int(11) default NULL,
  `bidder` int(11) default NULL,
  `bid` double(16,2) default NULL,
  `bidwhen` varchar(14) default NULL,
  `quantity` int(11) default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "bids`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "categories`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "categories`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "categories` (
  `cat_id` int(4) NOT NULL auto_increment,
  `parent_id` int(4) default NULL,
  `left_id` INT(8) NOT NULL,
  `right_id` INT(8) NOT NULL,
  `level` INT(1) NOT NULL,
  `cat_name` tinytext,
  `sub_counter` int(11) default 0,
  `counter` int(11) default 0,
  `cat_colour` varchar(15) default '',
  `cat_image` varchar(150) default '',
  PRIMARY KEY  (`cat_id`),
  INDEX (`left_id`, `right_id`, `level`)
);";

#
# Dumping data for table `" . $DBPrefix . "categories`
#

if ($_GET['cats'] == 1)
{
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(1, -1, 1, 394, -1, 'All', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(2, 1, 340, 393, 0, 'Art & Antiques', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(3, 2, 391, 392, 1, 'Textiles & Linens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(4, 2, 389, 390, 1, 'Amateur Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(5, 2, 387, 388, 1, 'Ancient World', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(6, 2, 385, 386, 1, 'Books & Manuscripts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(7, 2, 383, 384, 1, 'Cameras', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(8, 2, 363, 382, 1, 'Ceramics & Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(9, 8, 364, 381, 2, 'Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(10, 9, 379, 380, 3, '40s, 50s & 60s', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(11, 9, 377, 378, 3, 'Art Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(12, 9, 375, 376, 3, 'Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(13, 9, 373, 374, 3, 'Chalkware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(14, 9, 371, 372, 3, 'Chintz & Shelley', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(15, 9, 369, 370, 3, 'Contemporary Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(16, 9, 367, 368, 3, 'Decorative', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(17, 9, 365, 366, 3, 'Porcelain', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(18, 2, 361, 362, 1, 'Fine Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(19, 2, 359, 360, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(20, 2, 357, 358, 1, 'Musical Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(21, 2, 355, 356, 1, 'Orientalia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(22, 2, 353, 354, 1, 'Painting', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(23, 2, 351, 352, 1, 'Photographic Images', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(24, 2, 349, 350, 1, 'Post-1900', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(25, 2, 347, 348, 1, 'Pre-1900', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(26, 2, 345, 346, 1, 'Prints', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(27, 2, 343, 344, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(28, 2, 341, 342, 1, 'Silver & Silver Plate', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(29, 1, 262, 339, 0, 'Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(30, 29, 337, 338, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(31, 29, 335, 336, 1, 'Arts, Architecture & Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(32, 29, 333, 334, 1, 'Audiobooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(33, 29, 331, 332, 1, 'Biographies & Memoirs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(34, 29, 329, 330, 1, 'Business & Investing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(35, 29, 327, 328, 1, 'Catalogs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(36, 29, 325, 326, 1, 'Children', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(37, 29, 323, 324, 1, 'Computers & Internet', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(38, 29, 321, 322, 1, 'Contemporary', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(39, 29, 319, 320, 1, 'Cooking, Food & Wine', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(40, 29, 317, 318, 1, 'Entertainment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(41, 29, 315, 316, 1, 'Foreign Language Instruction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(42, 29, 313, 314, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(43, 29, 311, 312, 1, 'Health, Mind & Body', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(44, 29, 309, 310, 1, 'Historical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(45, 29, 307, 308, 1, 'History', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(46, 29, 305, 306, 1, 'Home & Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(47, 29, 303, 304, 1, 'Horror', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(48, 29, 301, 302, 1, 'Illustrated', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(49, 29, 299, 300, 1, 'Literature & Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(50, 29, 297, 298, 1, 'Men', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(51, 29, 295, 296, 1, 'Mystery & Thrillers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(52, 29, 293, 294, 1, 'News', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(53, 29, 291, 292, 1, 'Nonfiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(54, 29, 289, 290, 1, 'Parenting & Families', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(55, 29, 287, 288, 1, 'Poetry', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(56, 29, 285, 286, 1, 'Rare', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(57, 29, 283, 284, 1, 'Reference', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(58, 29, 281, 282, 1, 'Regency', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(59, 29, 279, 280, 1, 'Religion & Spirituality', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(60, 29, 277, 278, 1, 'Science & Nature', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(61, 29, 275, 276, 1, 'Science Fiction & Fantasy', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(62, 29, 273, 274, 1, 'Sports', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(63, 29, 271, 272, 1, 'Sports & Outdoors', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(64, 29, 269, 270, 1, 'Teens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(65, 29, 267, 268, 1, 'Textbooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(66, 29, 265, 266, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(67, 29, 263, 264, 1, 'Women', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(68, 1, 254, 261, 0, 'Clothing & Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(69, 68, 259, 260, 1, 'Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(70, 68, 257, 258, 1, 'Clothing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(71, 68, 255, 256, 1, 'Watches', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(72, 1, 248, 253, 0, 'Coins & Stamps', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(73, 72, 251, 252, 1, 'Coins', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(74, 72, 249, 250, 1, 'Philately', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(75, 1, 172, 247, 0, 'Collectibles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(76, 75, 245, 246, 1, 'Advertising', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(77, 75, 243, 244, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(78, 75, 241, 242, 1, 'Animation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(79, 75, 239, 240, 1, 'Antique Reproductions', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(80, 75, 237, 238, 1, 'Autographs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(81, 75, 235, 236, 1, 'Barber Shop', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(82, 75, 233, 234, 1, 'Bears', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(83, 75, 231, 232, 1, 'Bells', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(84, 75, 229, 230, 1, 'Bottles & Cans', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(85, 75, 227, 228, 1, 'Breweriana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(86, 75, 225, 226, 1, 'Cars & Motorcycles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(87, 75, 223, 224, 1, 'Cereal Boxes & Premiums', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(88, 75, 221, 222, 1, 'Character', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(89, 75, 219, 220, 1, 'Circus & Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(90, 75, 217, 218, 1, 'Collector Plates', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(91, 75, 215, 216, 1, 'Dolls', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(92, 75, 213, 214, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(93, 75, 211, 212, 1, 'Historical & Cultural', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(94, 75, 209, 210, 1, 'Holiday & Seasonal', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(95, 75, 207, 208, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(96, 75, 205, 206, 1, 'Kitsch', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(97, 75, 203, 204, 1, 'Knives & Swords', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(98, 75, 201, 202, 1, 'Lunchboxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(99, 75, 199, 200, 1, 'Magic & Novelty Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(100, 75, 197, 198, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(101, 75, 195, 196, 1, 'Militaria', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(102, 75, 193, 194, 1, 'Music Boxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(103, 75, 191, 192, 1, 'Oddities', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(104, 75, 189, 190, 1, 'Paper', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(105, 75, 187, 188, 1, 'Pinbacks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(106, 75, 185, 186, 1, 'Porcelain Figurines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(107, 75, 183, 184, 1, 'Railroadiana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(108, 75, 181, 182, 1, 'Religious', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(109, 75, 179, 180, 1, 'Rocks, Minerals & Fossils', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(110, 75, 177, 178, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(111, 75, 175, 176, 1, 'Textiles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(112, 75, 173, 174, 1, 'Tobacciana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(113, 1, 154, 171, 0, 'Comics, Cards & Science Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(114, 113, 169, 170, 1, 'Anime & Manga', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(115, 113, 167, 168, 1, 'Comic Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(116, 113, 165, 166, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(117, 113, 163, 164, 1, 'Godzilla', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(118, 113, 161, 162, 1, 'Star Trek', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(119, 113, 159, 160, 1, 'The X-Files', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(120, 113, 157, 158, 1, 'Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(121, 113, 155, 156, 1, 'Trading Cards', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(122, 1, 144, 153, 0, 'Computers & Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(123, 122, 151, 152, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(124, 122, 149, 150, 1, 'Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(125, 122, 147, 148, 1, 'Internet Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(126, 122, 145, 146, 1, 'Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(127, 1, 132, 143, 0, 'Electronics & Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(128, 127, 141, 142, 1, 'Consumer Electronics', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(129, 127, 139, 140, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(130, 127, 137, 138, 1, 'Photo Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(131, 127, 135, 136, 1, 'Recording Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(132, 127, 133, 134, 1, 'Video Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(133, 1, 112, 131, 0, 'Home & Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(134, 133, 129, 130, 1, 'Baby Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(135, 133, 127, 128, 1, 'Crafts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(136, 133, 125, 126, 1, 'Furniture', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(137, 133, 123, 124, 1, 'Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(138, 133, 121, 122, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(139, 133, 119, 120, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(140, 133, 117, 118, 1, 'Pet Supplies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(141, 133, 115, 116, 1, 'Tools & Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(142, 133, 113, 114, 1, 'Weddings', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(143, 1, 98, 111, 0, 'Movies & Video', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(144, 143, 109, 110, 1, 'Blueray', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(145, 143, 107, 108, 1, 'DVD', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(146, 143, 105, 106, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(147, 143, 103, 104, 1, 'HD-DVD', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(148, 143, 101, 102, 1, 'Laser Discs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(149, 143, 99, 100, 1, 'VHS', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(150, 1, 84, 97, 0, 'Music', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(151, 150, 95, 96, 1, 'CDs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(152, 150, 93, 94, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(153, 150, 91, 92, 1, 'Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(154, 150, 89, 90, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(155, 150, 87, 88, 1, 'Records', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(156, 150, 85, 86, 1, 'Tapes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(157, 1, 74, 83, 0, 'Office & Business', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(158, 157, 81, 82, 1, 'Briefcases', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(159, 157, 79, 80, 1, 'Fax Machines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(160, 157, 77, 78, 1, 'General Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(161, 157, 75, 76, 1, 'Pagers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(162, 1, 58, 73, 0, 'Other Goods & Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(163, 162, 71, 72, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(164, 162, 69, 70, 1, 'Metaphysical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(165, 162, 67, 68, 1, 'Property', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(166, 162, 65, 66, 1, 'Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(167, 162, 63, 64, 1, 'Tickets & Events', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(168, 162, 61, 62, 1, 'Transportation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(169, 162, 59, 60, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(170, 1, 50, 57, 0, 'Sports & Recreation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(171, 170, 55, 56, 1, 'Apparel & Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(172, 170, 53, 54, 1, 'Exercise Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(173, 170, 51, 52, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(174, 1, 2, 49, 0, 'Toys & Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(175, 174, 47, 48, 1, 'Action Figures', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(176, 174, 45, 46, 1, 'Beanie Babies & Beanbag Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(177, 174, 43, 44, 1, 'Diecast', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(178, 174, 41, 42, 1, 'Fast Food', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(179, 174, 39, 40, 1, 'Fisher-Price', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(180, 174, 37, 38, 1, 'Furby', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(181, 174, 35, 36, 1, 'Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(182, 174, 33, 34, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(183, 174, 31, 32, 1, 'Giga Pet & Tamagotchi', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(184, 174, 29, 30, 1, 'Hobbies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(185, 174, 27, 28, 1, 'Marbles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(186, 174, 25, 26, 1, 'My Little Pony', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(187, 174, 23, 24, 1, 'Peanuts Gang', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(188, 174, 21, 22, 1, 'Pez', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(189, 174, 19, 20, 1, 'Plastic Models', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(190, 174, 17, 18, 1, 'Plush Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(191, 174, 15, 16, 1, 'Puzzles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(192, 174, 13, 14, 1, 'lot Cars', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(193, 174, 11, 12, 1, 'Teletubbies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(194, 174, 9, 10, 1, 'Toy Soldiers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(195, 174, 7, 8, 1, 'Vintage', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(196, 174, 5, 6, 1, 'Vintage Tin', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(197, 174, 3, 4, 1, 'Vintage Vehicles', 0, 0, '', '');";
}
else
{
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, -1, 1, 2, -1, 'All', 0, 0, '', '');";
}


# ############################

#
# Table structure for table `" . $DBPrefix . "categories_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "categories_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "categories_translated` (
  `cat_id` int(4) NOT NULL,
  `lang` char(2) NOT NULL default '',
  `category` varchar(200) NOT NULL default ''
);";

#
# Dumping data for table `" . $DBPrefix . "categories_translated`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "comm_messages`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "comm_messages`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "comm_messages` (
  `id` int(11) NOT NULL auto_increment,
  `boardid` int(11) NOT NULL default '0',
  `msgdate` varchar(14) NOT NULL default '',
  `user` int(11) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "comm_messages`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "community`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "community`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "community` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '0',
  `messages` int(11) NOT NULL default '0',
  `lastmessage` varchar(14) NOT NULL default '0',
  `msgstoshow` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "community`
#

$query[] = "INSERT INTO `" . $DBPrefix . "community` VALUES (1, 'Selling', 0, '', 30, 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "community` VALUES (2, 'Buying', 0, '', 30, 1);";


# ############################

#
# Table structure for table `" . $DBPrefix . "community_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "community_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "community_translated` (
  `id` int(4) NOT NULL,
  `lang` char(2) NOT NULL default '',
  `name` varchar(255) NOT NULL default ''
);";

#
# Dumping data for table `" . $DBPrefix . "community_translated`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "counters`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "counters`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "counters` (
  `users` int(11) default '0',
  `inactiveusers` int(11) NOT NULL default '0',
  `auctions` int(11) default '0',
  `closedauctions` int(11) NOT NULL default '0',
  `bids` int(11) NOT NULL default '0',
  `suspendedauctions` int(11) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "counters`
#

$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES (0, 0, 0, 0, 0, 0);";

# ############################

#
# Table structure for table `" . $DBPrefix . "countries`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "countries`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "countries` (
  `country_id` int(4) NOT NULL auto_increment,
  `country` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`country_id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "countries`
#

$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Afghanistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Albania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Algeria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'American Samoa');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Andorra');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Angola');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Anguilla');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Antarctica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Antigua And Barbuda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Argentina');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Armenia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Aruba');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Australia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Austria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Azerbaijan Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bahamas');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bahrain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bangladesh');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Barbados');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Belarus');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Belgium');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Belize');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Benin');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bermuda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bhutan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bolivia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bosnia and Herzegowina');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Botswana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bouvet Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Brazil');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'British Indian Ocean Territory');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Brunei Darussalam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Bulgaria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Burkina Faso');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Burma');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Burundi');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cambodia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cameroon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Canada');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cape Verde');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cayman Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Central African Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Chad');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Chile');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'China');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Christmas Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cocos (Keeling) Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Colombia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Comoros');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Congo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Congo, the Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cook Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Costa Rica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cote d''Ivoire');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Croatia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cyprus');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Czech Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Denmark');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Djibouti');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Dominica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Dominican Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'East Timor');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Ecuador');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Egypt');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'El Salvador');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Equatorial Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Eritrea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Estonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Ethiopia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Falkland Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Faroe Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Fiji');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Finland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'France');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'French Guiana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'French Polynesia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'French Southern Territories');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Gabon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Gambia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Georgia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Germany');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Ghana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Gibraltar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Great Britain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Greece');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Greenland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Grenada');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Guadeloupe');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Guam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Guatemala');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Guinea-Bissau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Guyana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Haiti');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Heard and Mc Donald Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Honduras');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Hong Kong');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Hungary');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Iceland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'India');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Indonesia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Ireland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Israel');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Italy');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Jamaica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Japan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Jordan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kazakhstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kenya');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kiribati');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Korea (South)');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kuwait');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kyrgyzstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Lao People''s Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Latvia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Lebanon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Lesotho');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Liberia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Liechtenstein');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Lithuania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Luxembourg');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Macau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Macedonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Madagascar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Malawi');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Malaysia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Maldives');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mali');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Malta');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Marshall Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Martinique');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mauritania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mauritius');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mayotte');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mexico');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Micronesia, Federated States of');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Moldova, Republic of');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Monaco');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mongolia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Montserrat');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Morocco');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Mozambique');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Namibia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Nauru');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Nepal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Netherlands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Netherlands Antilles');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'New Caledonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'New Zealand');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Nicaragua');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Niger');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Nigeria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Niuev');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Norfolk Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Northern Mariana Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Norway');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Oman');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Pakistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Palau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Panama');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Papua New Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Paraguay');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Peru');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Philippines');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Pitcairn');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Poland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Portugal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Puerto Rico');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Qatar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Reunion');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Romania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Russian Federation');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Rwanda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Saint Kitts and Nevis');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Saint Lucia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Saint Vincent and the Grenadin');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Samoa (Independent)');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'San Marino');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Sao Tome and Principe');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Saudi Arabia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Senegal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Serbia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Seychelles');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Sierra Leone');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Singapore');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Slovakia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Slovenia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Solomon Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Somalia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'South Africa');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'South Georgia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Spain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Sri Lanka');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'St. Helena');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'St. Pierre and Miquelon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Suriname');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Svalbard and Jan Mayen Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Swaziland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Sweden');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Switzerland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Taiwan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Tajikistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Tanzania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Thailand');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Togo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Tokelau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Tonga');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Trinidad and Tobago');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Tunisia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Turkey');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Turkmenistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Turks and Caicos Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Tuvalu');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Uganda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Ukraine');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'United Arab Emiratesv');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'United Kingdom');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'United States');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Uruguay');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Uzbekistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Vanuatu');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Venezuela');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Viet Nam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Virgin Islands (British)');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Virgin Islands (U.S.)');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Wallis and Futuna Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Western Sahara');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Yemen');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Zambia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Zimbabwe');";

# ############################

#
# Table structure for table `" . $DBPrefix . "countries_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "countries_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "countries_translated` (
  `country_id` int(4) NOT NULL,
  `lang` char(2) NOT NULL default '',
  `country` varchar(255) NOT NULL default ''
);";

#
# Dumping data for table `" . $DBPrefix . "countries_translated`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "currentaccesses`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentaccesses`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentaccesses` (
  `day` char(2) NOT NULL default '0',
  `month` char(2) NOT NULL default '0',
  `year` char(4) NOT NULL default '0',
  `pageviews` int(11) NOT NULL default '0',
  `uniquevisitors` int(11) NOT NULL default '0',
  `usersessions` int(11) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "currentaccesses`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "currentbrowsers`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentbrowsers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentbrowsers` (
  `month` char(2) NOT NULL default '0',
  `year` varchar(4) NOT NULL default '0',
  `browser` varchar(255) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "currentbrowsers`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "currentplatforms`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentplatforms`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentplatforms` (
  `month` char(2) NOT NULL default '0',
  `year` varchar(4) NOT NULL default '0',
  `platform` varchar(50) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "currentplatforms`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "durations`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "durations`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "durations` (
  `days` double(8,2) NOT NULL default '0',
  `description` varchar(30) default NULL
) ;";

#
# Dumping data for table `" . $DBPrefix . "durations`
#

$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (1, '1 day');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (2, '2 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (2.5, '2.5 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (3, '3 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (7, '1 week');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (14, '2 weeks');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (21, '3 weeks');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (30, '1 month');";

# ############################

#
# Table structure for table `" . $DBPrefix . "durations_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "durations_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "durations_translated` (
  `days` double(8,2) NOT NULL,
  `lang` char(2) NOT NULL default '',
  `description` varchar(255) NOT NULL default ''
);";

#
# Dumping data for table `" . $DBPrefix . "durations_translated`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "faqs`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqs`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqs` (
  `id` int(11) NOT NULL auto_increment,
  `question` varchar(200) NOT NULL default '',
  `answer` text NOT NULL,
  `category` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "faqs`
#

$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (2, 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (4, 'Item Watch', '<b>Item watch</b> notifies you when someone bids on the auctions that you have added to your Item Watch. ', 3);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (5, 'What is a Dutch auction?', 'Dutch auction is a type of auction where the auctioneer begins with a high asking price which is lowered until some participant is willing to accept the auctioneer''s price. The winning participant pays the last announced price.', 1);";

# ############################

#
# Table structure for table `" . $DBPrefix . "faqs_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqs_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqs_translated` (
  `id` int(11) NOT NULL,
  `lang` char(2) NOT NULL default '',
  `question` varchar(200) NOT NULL default '',
  `answer` text NOT NULL
) ;";

#
# Dumping data for table `" . $DBPrefix . "faqs_translated`
#

$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (2, 'EN', 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (2, 'ES', 'Registrarse', 'Para registrar un nuevo usuario, haz click en <B>Reg&iacute;ÃÂ­strate</B> en la parte superior de la pantalla. Se te preguntar&aacute;n tus datos personales, un nombre de usuario, una contrase&ntilde;a e informacion de contacto como la direccion e-mail.\r\n\r\n<B>¡Tienes que ser mayor de edad para poder registrarte!</B>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (4, 'EN', 'Item Watch', '<b>Item watch</b> notifies you when someone bids on the auctions that you have added to your Item Watch. ');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (4, 'ES', 'En la Mira', '<i><b>En la Mira</b></i> te env&iacute;a una notificacion por e-mail, cada vez que alguien puja en una de las subastas que has a&ntilde;adido a tu lista <i>En la Mira</i>. ');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (6, 'ES', 'Auction Watch', '<i><B>Auction Watch</b></i> es tu asistente para saber cuando se abre una subasta cuya descripcion contiene palabras clave de tu interes.\r\n\r\nPara usar esta opcion inserta las palabras clave en las que est&aacute;s interesado en la lista de <i>Auction Watch</i>. Todas las palabras claves deben estar separadas por un espacio. Cuando estas palabras claves aparezcan en alg&uacute;n t&iacute;tulo o descripcion de subasta, recibir&aacute;s un e-mail con la informacion de que una subasta que contiene tus palabras claves ha sido creada. Tambi&aacute;n puedas agregar el nombre del usuario como palabra clave. ');";

# ############################

#
# Table structure for table `" . $DBPrefix . "faqscat_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqscat_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqscat_translated` (
  `id` int(11) NOT NULL default '0',
  `lang` char(2) NOT NULL default '',
  `category` varchar(255) NOT NULL default ''
) ;";

#
# Dumping data for table `" . $DBPrefix . "faqscat_translated`
#

$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (3, 'EN', 'Buying');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (3, 'ES', 'Comprar');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (1, 'EN', 'General');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (1, 'ES', 'General');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (2, 'EN', 'Selling');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (2, 'ES', 'Vender');";

# ############################

#
# Table structure for table `" . $DBPrefix . "faqscategories`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqscategories`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqscategories` (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "faqscategories`
#

$query[] = "INSERT INTO `" . $DBPrefix . "faqscategories` VALUES (1, 'General');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscategories` VALUES (2, 'Selling');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscategories` VALUES (3, 'Buying');";

# ############################

#
# Table structure for table `" . $DBPrefix . "feedbacks`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "feedbacks`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "feedbacks` (
  `id` int(11) NOT NULL auto_increment,
  `rated_user_id` int(11) default NULL,
  `rater_user_nick` varchar(20) default NULL,
  `feedback` mediumtext,
  `rate` int(2) default NULL,
  `feedbackdate` INT(15) NOT NULL,
  `auction_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "feedbacks`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "fees`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fees`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "fees` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `fee_from` double(16,2) NOT NULL default '0',
  `fee_to` double(16,2) NOT NULL default '0',
  `fee_type` enum('flat', 'perc') NOT NULL default 'flat',
  `value` double(8,2) NOT NULL default '0',
  `type` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "fees`
#

$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'signup_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyer_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'setup_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'featured_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'bold_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'highlighted_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'reserve_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'picture_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'subtitle_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'extracat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'relist_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buynow_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'endauc_fee');";

# ############################

#
# Table structure for table `" . $DBPrefix . "filterwords`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "filterwords`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "filterwords` (
  `word` varchar(255) NOT NULL default ''
) ;";

#
# Dumping data for table `" . $DBPrefix . "filterwords`
#

$query[] = "INSERT INTO `" . $DBPrefix . "filterwords` VALUES ('');";

# ############################

#
# Table structure for table `" . $DBPrefix . "payment_options`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "payment_options`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "payment_options` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL default '',
  `displayname` varchar(50) NOT NULL default '',
  `is_gateway` tinyint(1) NOT NULL default '0',
  `gateway_admin_address` varchar(50) NOT NULL default '',
  `gateway_admin_password` varchar(50) NOT NULL default '',
  `gateway_required` tinyint(1) NOT NULL default '0',
  `gateway_active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY(`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "payment_options`
#

$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('banktransfer', 'Bank Transfer', 0);";
$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('cheque', 'Cheque', 0);";
$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('paypal', 'PayPal', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('authnet', 'Authorize.net', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('worldpay', 'WorldPay', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('moneybookers', 'Moneybookers', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "payment_options` (`name`, `displayname`, `is_gateway`) VALUES ('toocheckout', '2Checkout', 1);";

# ############################

#
# Table structure for table `" . $DBPrefix . "groups`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "groups`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "groups` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL default '',
  `can_sell` tinyint(1) NOT NULL default '0',
  `can_buy` tinyint(1) NOT NULL default '0',
  `count` tinyint(11) NOT NULL default '0',
  `auto_join` tinyint(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "groups`
#

$query[] = "INSERT INTO `" . $DBPrefix . "groups` VALUES (NULL, 'Sellers', 1, 0, 0, 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "groups` VALUES (NULL, 'Buyers', 0, 1, 0, 1);";

# ############################

#
# Table structure for table `" . $DBPrefix . "groups_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "groups_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "groups_translated` (
  `id` int(5) NOT NULL,
  `lang` char(2) NOT NULL default '',
  `group_name` varchar(255) NOT NULL default ''
);";

#
# Dumping data for table `" . $DBPrefix . "groups_translated`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "increments`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "increments`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "increments` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `low` double(16,2) default '0',
  `high` double(16,2) default '0',
  `increment` double(16,2) default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "increments`
#

$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 0.0000, 0.9900, 0.2800);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 1.0000, 9.9900, 0.5000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 10.0000, 29.9900, 1.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 30.0000, 99.9900, 2.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 100.0000, 249.9900, 5.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 250.0000, 499.9900, 10.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 500.0000, 999.9900, 25.0000);";

# ############################

#
# Table structure for table `" . $DBPrefix . "logs`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "logs`;";
$query[] = "CREATE TABLE  `" . $DBPrefix . "logs` (
  `id` INT( 25 ) NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR( 5 ) NOT NULL ,
  `message` TEXT NOT NULL ,
  `action_id` INT( 11 ) NOT NULL DEFAULT  '0',
  `user_id` INT( 32 ) NOT NULL DEFAULT  '0',
  `ip` VARCHAR( 45 ) NOT NULL,
  `timestamp` INT( 11 ) NOT NULL DEFAULT  '0',
  PRIMARY KEY  (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "logs`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "membertypes`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "membertypes`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "membertypes` (
  `id` int(11) NOT NULL auto_increment,
  `feedbacks` int(11) NOT NULL default '0',
  `icon` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "membertypes`
#

$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (24, 9, 'transparent.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (22, 999999, 'starFR.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (21, 99999, 'starFV.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (20, 49999, 'starFT.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (19, 24999, 'starFY.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (23, 9999, 'starG.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (17, 4999, 'starR.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (16, 999, 'starT.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (15, 99, 'starB.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (14, 49, 'starY.gif');";

# ############################

#
# Table structure for table `" . $DBPrefix . "messages`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "messages`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `sentto` int(11) NOT NULL default '0',
  `sentfrom` int(11) NOT NULL default '0',
  `fromemail` varchar(255) NOT NULL default '',
  `sentat` varchar(20) NOT NULL default '',
  `message` text NOT NULL ,
  `isread` tinyint(1) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `replied` tinyint(1) NOT NULL default '0',
  `reply_of` int(11) NOT NULL default '0',
  `question` int(11) NOT NULL default '0',
  `public` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ;";

# ############################

#
# Table structure for table `" . $DBPrefix . "news`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "news`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `content` longtext NOT NULL,
  `new_date` int(8) NOT NULL default '0',
  `suspended` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "news`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "news_translated`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "news_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "news_translated` (
  `id` int(11) NOT NULL default '0',
  `lang` char(2) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL
) ;";

#
# Dumping data for table `" . $DBPrefix . "news_translated`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "online`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "online`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "online` (
  `ID` bigint(21) NOT NULL auto_increment,
  `SESSION` varchar(32) NOT NULL default '',
  `time` bigint(21) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "online`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "pendingnotif`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "pendingnotif`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "pendingnotif` (
  `id` int(11) NOT NULL auto_increment,
  `auction_id` int(11) NOT NULL default '0',
  `seller_id` int(11) NOT NULL default '0',
  `winners` text NOT NULL,
  `auction` text NOT NULL,
  `seller` text NOT NULL,
  `thisdate` varchar(8) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "pendingnotif`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "proxybid`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "proxybid`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "proxybid` (
  `itemid` int(11) default NULL,
  `userid` int(11) default NULL,
  `bid` double(16,2) default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "proxybid`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "rates`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "rates`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "rates` (
  `id` int(11) NOT NULL auto_increment,
  `ime` tinytext NOT NULL,
  `valuta` tinytext NOT NULL,
  `symbol` char(3) NOT NULL default '',
  KEY `id` (`id`)
) AUTO_INCREMENT=64 ;";

#
# Dumping data for table `" . $DBPrefix . "rates`
#

$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (1, 'Great Britain', 'Pound Sterling ', 'GBP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (2, 'Argentina', 'Argentinian Peso', 'ARS');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (3, 'Australia', 'Australian Dollar ', 'AUD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (4, 'Burma', 'Myanmar (Burma) Kyat', 'MMK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (5, 'Brazil', 'Brazilian Real ', 'BRL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (6, 'Chile', 'Chilean Peso ', 'CLP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (7, 'China', 'Chinese Renminbi ', 'CNY');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (8, 'Colombia', 'Colombian Peso ', 'COP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (9, 'Neth. Antilles', 'Neth. Antilles Guilder', 'ANG');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (10, 'Czech. Republic', 'Czech. Republic Koruna ', 'CZK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (11, 'Denmark', 'Danish Krone ', 'DKK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (12, 'European Union', 'EURO', 'EUR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (13, 'Fiji', 'Fiji Dollar ', 'FJD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (14, 'Jamaica', 'Jamaican Dollar', 'JMD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (15, 'Trinidad & Tobago', 'Trinidad & Tobago Dollar', 'TTD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (16, 'Hong Kong', 'Hong Kong Dollar', 'HKD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (17, 'Ghana', 'Ghanaian Cedi', 'GHC');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (18, 'Iceland', 'Icelandic Krona ', 'INR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (19, 'India', 'Indian Rupee', 'INR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (20, 'Indonesia', 'Indonesian Rupiah ', 'IDR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (21, 'Israel', 'Israeli New Shekel ', 'ILS');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (22, 'Japan', 'Japanese Yen', 'JPY');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (23, 'Malaysia', 'Malaysian Ringgit', 'MYR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (24, 'Mexico', 'New Peso', 'MXN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (25, 'Morocco', 'Moroccan Dirham ', 'MAD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (26, 'Honduras', 'Honduras Lempira', 'HNL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (27, 'Hungaria', 'Hungarian Forint', 'HUF');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (28, 'New Zealand', 'New Zealand Dollar', 'NZD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (29, 'Norway', 'Norwege Krone', 'NOK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (30, 'Pakistan', 'Pakistan Rupee ', 'PKR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (31, 'Panama', 'Panamanian Balboa ', 'PAB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (32, 'Peru', 'Peruvian New Sol', 'PEN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (33, 'Philippine', 'Philippine Peso ', 'PHP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (34, 'Poland', 'Polish Zloty', 'PLN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (35, 'Russian', 'Russian Rouble', 'RUR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (36, 'Singapore', 'Singapore Dollar ', 'SGD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (37, 'Slovakia', 'Koruna', 'SKK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (38, 'Slovenia', 'Slovenian Tolar', 'SIT');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (39, 'South Africa', 'South African Rand', 'ZAR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (40, 'South Korea', 'South Korean Won', 'KRW');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (41, 'Sri Lanka', 'Sri Lanka Rupee ', 'LKR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (42, 'Sweden', 'Swedish Krona', 'SEK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (43, 'Switzerland', 'Swiss Franc', 'CHF');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (44, 'Taiwan', 'Taiwanese New Dollar ', 'TWD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (45, 'Thailand', 'Thailand Thai Baht ', 'THB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (46, 'Pacific Financial Community', 'Pacific Financial Community Franc', 'CFP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (47, 'Tunisia', 'Tunisisan Dinar', 'TND');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (48, 'Turkey', 'Turkish Lira', 'TRL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (49, 'United States', 'U.S. Dollar', 'USD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (50, 'Venezuela', 'Bolivar ', 'VEB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (51, 'Bahamas', 'Bahamian Dollar', 'BSD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (52, 'Croatia', 'Croatian Kuna', 'HRK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (53, 'East Caribe', 'East Caribbean Dollar', 'XCD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (54, 'CFA Franc (African Financial Community)', 'African Financial Community Franc', 'CFA');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (55, 'Canadian', 'Canadian Dollar', 'CAD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (56, 'Romanian', 'Romanian Leu', 'RON');";

# ############################

#
# Table structure for table `" . $DBPrefix . "rememberme`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "rememberme`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "rememberme` (
  `userid` int(11) NOT NULL default '0',
  `hashkey` char(32) NOT NULL default ''
) ;";

# ############################

#
# Table structure for table `" . $DBPrefix . "reportedauctions`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "reportedauctions`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "reportedauctions` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `reason` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY(`id`)
) ;";

# ############################

#
# Table structure for table `" . $DBPrefix . "settings`
#
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "settings` (
  `fieldname` VARCHAR(30) NOT NULL,
  `fieldtype` VARCHAR(10) NOT NULL,
  `value` text NOT NULL,
  `modifieddate` INT(11) NOT NULL,
  `modifiedby` INT(32) NOT NULL,
  PRIMARY KEY(`fieldname`)
);";

#
# Dumping data for table `" .DBPrefix . "settings`
#
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('aboutus', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('aboutustext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('activationtype', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('adminmail', 'str', '". $siteEmail ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ae_extend', 'int', '300', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ae_status', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ae_timebefore', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('alert_emails', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ao_bi_enabled', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ao_hi_enabled', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ao_hpf_enabled', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('archiveafter', 'int', 30, UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('auction_moderation', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('new_auction_moderation', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('autorelist', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('autorelist_max', 'int', '10', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banemail', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banner_height', 'int', '60', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banner_width', 'int', '468', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banners', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bn_only', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bn_only_disable', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bn_only_percent', 'str', '50', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('boards', 'str', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('boardsmsgs', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('buy_now', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('buyerprivacy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cache_theme', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('catsorting', 'str', 'alpha', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('catstoshow', 'int', '20', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('contactseller', 'str', 'always', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cookiespolicy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cookiespolicytext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('copyright', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_auctions', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_online', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_users', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cron', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('currency', 'str', 'GBP', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cust_increment', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('datesformat', 'str', 'EUR', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('defaultcountry', 'str', 'United Kingdom', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('defaultlanguage', 'str', 'EN', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('descriptiontag', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('displayed_feilds', 'str', 'a:7:{s:17:\"birthdate_regshow\";s:1:\"y\";s:15:\"address_regshow\";s:1:\"y\";s:12:\"city_regshow\";s:1:\"y\";s:12:\"prov_regshow\";s:1:\"y\";s:15:\"country_regshow\";s:1:\"y\";s:11:\"zip_regshow\";s:1:\"y\";s:11:\"tel_regshow\";s:1:\"y\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('edit_starttime', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('edit_endtime', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('endingsoonnumber', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('errortext', 'str', '<p>An unexpected error occurred. The error has been forwarded to our technical team and will be fixed shortly</p>', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('extra_cat', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('featuredperpage', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_disable_acc', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_max_debt', 'str', '25.00', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_signup_bonus', 'str', '0.00', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_type', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fees', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('googleanalytics', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('helpbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('hotitemsnumber', 'int', '8', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('hours_countdown', 'int', '24', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('https', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('https_url', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('invoice_thankyou', 'str', 'Thank you for shopping with us and we hope to see you return soon!', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('invoice_yellow_line', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('keywordstag', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('lastitemsnumber', 'int', '8', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('homefeaturednumber', 'int', '12', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('loginbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('logo', 'str', 'logo.png', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mail_parameter', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mail_protocol', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maintainance_mode_active', 'bool', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maintainance_text', 'string', '<p><strong>Under maintenance!!!!!!!</strong></p>', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mandatory_fields', 'str', 'a:7:{s:9:\"birthdate\";s:1:\"n\";s:7:\"address\";s:1:\"y\";s:4:\"city\";s:1:\"y\";s:4:\"prov\";s:1:\"y\";s:7:\"country\";s:1:\"y\";s:3:\"zip\";s:1:\"y\";s:3:\"tel\";s:1:\"n\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maxpictures', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maxuploadsize', 'int', '51200', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mod_queue', 'bool, 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneydecimals', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneyformat', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneysymbol', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newsletter', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newsbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newstoshow', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('perpage', 'int', '15', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('picturesgallery', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('privacypolicy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('privacypolicytext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('proxy_bidding', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('prune_unactivated_users', 'bool', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('prune_unactivated_users_days', 'int', '30', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('recaptcha_private', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('recaptcha_public', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('shipping', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('sitename', 'str', 'WeBid', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('siteurl', 'str', '". $siteURL ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_authentication', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_host', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_password', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_port', 'int', '25', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_security', 'str', 'none', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_username', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_register', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_sendtofriend', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_reportitem', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('subtitle', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('superuser', 'string', 'renlok', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('tax', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('taxuser', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('terms', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('termstext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('theme', 'str', 'modern', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('admin_theme', 'str', 'adminClassic', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('thumb_list', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('thumb_show', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('timezone', 'str', 'Europe/London', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('use_moderation', 'bool', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('users_email', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('usersauth', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('version', 'str', '". package_version() ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('version_check', 'str', 'stable', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('wordsfilter', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bidding_visable_to_guest', 'bool', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('email_admin_on_signup', 'bool', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('user_request_seller_permission', 'bool', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_blocked_email_enabled', 'bool', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_blocked_email_domains', 'str', \"0-mail.com\n027168.com\n0815.ru\n0815.ry\n0815.su\n0845.ru\n0clickemail.com\n0wnd.net\n0wnd.org\n0x207.info\n1-8.biz\n100likers.com\n10mail.com\n10mail.org\n10minut.com.pl\n10minutemail.cf\n10minutemail.co.uk\n10minutemail.co.za\n10minutemail.com\n10minutemail.de\n10minutemail.ga\n10minutemail.gq\n10minutemail.ml\n10minutemail.net\n10minutesmail.com\n10x9.com\n123-m.com\n12houremail.com\n12minutemail.com\n12minutemail.net\n140unichars.com\n147.cl\n14n.co.uk\n1ce.us\n1chuan.com\n1fsdfdsfsdf.tk\n1mail.ml\n1pad.de\n1st-forms.com\n1to1mail.org\n1zhuan.com\n20email.eu\n20email.it\n20mail.in\n20mail.it\n20minutemail.com\n2120001.net\n21cn.com\n24hourmail.com\n24hourmail.net\n2fdgdfgdfgdf.tk\n2prong.com\n30minutemail.com\n33mail.com\n36ru.com\n3d-painting.com\n3l6.com\n3mail.ga\n3trtretgfrfe.tk\n4-n.us\n418.dk\n4gfdsgfdgfd.tk\n4mail.cf\n4mail.ga\n4warding.com\n4warding.net\n4warding.org\n5ghgfhfghfgh.tk\n5gramos.com\n5mail.cf\n5mail.ga\n5oz.ru\n5x25.com\n60minutemail.com\n672643.net\n675hosting.com\n675hosting.net\n675hosting.org\n6hjgjhgkilkj.tk\n6ip.us\n6mail.cf\n6mail.ga\n6mail.ml\n6paq.com\n6url.com\n75hosting.com\n75hosting.net\n75hosting.org\n7days-printing.com\n7mail.ga\n7mail.ml\n7tags.com\n80665.com\n8127ep.com\n8mail.cf\n8mail.ga\n8mail.ml\n99experts.com\n9mail.cf\n9ox.net\na-bc.net\na.asu.mx\na.betr.co\na.mailcker.com\na.vztc.com\na45.in\nabakiss.com\nabcmail.email\nabusemail.de\nabyssmail.com\nac20mail.in\nacademiccommunity.com\nacentri.com\nadd3000.pp.ua\nadobeccepdm.com\nadpugh.org\nadsd.org\nadvantimo.com\nadwaterandstir.com\naegia.net\naegiscorp.net\naeonpsi.com\nafrobacon.com\nag.us.to\nagedmail.com\nagtx.net\nahk.jp\najaxapp.net\nakapost.com\nakerd.com\nal-qaeda.us\naligamel.com\nalisongamel.com\nalivance.com\nalldirectbuy.com\nallen.nom.za\nallthegoodnamesaretaken.org\nalph.wtf\nama-trade.de\nama-trans.de\namail.com\namail4.me\namazon-aws.org\namelabs.com\namilegit.com\namiri.net\namiriindustries.com\nampsylike.com\nan.id.au\nanappfor.com\nanappthat.com\nandthen.us\nanimesos.com\nano-mail.net\nanon-mail.de\nanonbox.net\nanonmails.de\nanonymail.dk\nanonymbox.com\nanonymized.org\nanonymousness.com\nansibleemail.com\nanthony-junkmail.com\nantireg.com\nantireg.ru\nantispam.de\nantispam24.de\nantispammail.de\napfelkorps.de\naphlog.com\nappc.se\nappinventor.nl\nappixie.com\narmyspy.com\naron.us\narroisijewellery.com\nartman-conception.com\narvato-community.de\naschenbrandt.net\nasdasd.nl\nasdasd.ru\nashleyandrew.com\nass.pp.ua\nastroempires.info\nat0mik.org\natvclub.msk.ru\naugmentationtechnology.com\nauti.st\nautorobotica.com\nautotwollow.com\naver.com\naxiz.org\nazcomputerworks.com\nazmeil.tk\nb.kyal.pl\nb1of96u.com\nb2cmail.de\nbadgerland.eu\nbadoop.com\nbarryogorman.com\nbasscode.org\nbauwerke-online.com\nbaxomale.ht.cx\nbazaaboom.com\nbcast.ws\nbccto.me\nbearsarefuzzy.com\nbeddly.com\nbeefmilk.com\nbelljonestax.com\nbenipaula.org\nbestchoiceusedcar.com\nbidourlnks.com\nbig1.us\nbigprofessor.so\nbigstring.com\nbigwhoop.co.za\nbinkmail.com\nbio-muesli.info\nbio-muesli.net\nblackmarket.to\nbladesmail.net\nblip.ch\nblogmyway.org\nbluedumpling.info\nbluewerks.com\nbobmail.info\nbobmurchison.com\nbodhi.lawlita.com\nbofthew.com\nbonobo.email\nbookthemmore.com\nbootybay.de\nborged.com\nborged.net\nborged.org\nboun.cr\nbouncr.com\nboxformail.in\nboximail.com\nboxtemp.com.br\nbr.mintemail.com\nbrandallday.net\nbreakthru.com\nbrefmail.com\nbrennendesreich.de\nbriggsmarcus.com\nbroadbandninja.com\nbsnow.net\nbspamfree.org\nbspooky.com\nbst-72.com\nbtb-notes.com\nbtc.email\nbu.mintemail.com\nbuffemail.com\nbugmenever.com\nbugmenot.com\nbulrushpress.com\nbum.net\nbumpymail.com\nbunchofidiots.com\nbund.us\nbundes-li.ga\nbunsenhoneydew.com\nburnthespam.info\nburstmail.info\nbusinessbackend.com\nbusinesssuccessislifesuccess.com\nbuspad.org\nbuymoreplays.com\nbuyordie.info\nbuyusedlibrarybooks.org\nbyebyemail.com\nbyespm.com\nbyom.de\nc.lain.ch\nc2.hu\nc51vsgq.com\ncachedot.net\ncaliforniafitnessdeals.com\ncam4you.cc\ncard.zp.ua\ncasualdx.com\ncbair.com\ncc.liamria\nce.mintemail.com\ncek.pm\ncellurl.com\ncentermail.com\ncentermail.net\nchacuo.net\nchammy.info\ncheatmail.de\nchielo.com\nchildsavetrust.org\nchilkat.com\nchithinh.com\nchogmail.com\nchoicemail1.com\nchong-mail.com\nchong-mail.net\nchong-mail.org\nchumpstakingdumps.com\ncigar-auctions.com\nckiso.com\ncl-cl.org\ncl0ne.net\nclandest.in\nclipmail.eu\nclixser.com\nclrmail.com\ncmail.com\ncmail.net\ncmail.org\ncnamed.com\ncnmsg.net\ncnsds.de\ncodeandscotch.com\ncodivide.com\ncoieo.com\ncoldemail.info\ncompareshippingrates.org\ncompletegolfswing.com\ncomwest.de\nconsumerriot.com\ncool.fr.nf\ncoolandwacky.us\ncoolimpool.org\ncorreo.blogos.net\ncosmorph.com\ncourriel.fr.nf\ncourrieltemporaire.com\ncrankhole.com\ncrapmail.org\ncrastination.de\ncrazespaces.pw\ncrazymailing.com\ncrossroadsmail.com\ncszbl.com\ncubiclink.com\ncurryworld.de\ncust.in\ncuvox.de\ncx.de-a.org\nd.cane.pw\nd.dialogus.com\nd3p.dk\ndacoolest.com\ndaemsteam.com\ndaintly.com\ndammexe.net\ndandikmail.com\ndarkharvestfilms.com\ndaryxfox.net\ndash-pads.com\ndataarca.com\ndatafilehost\ndatarca.com\ndatazo.ca\ndavidkoh.net\ndavidlcreative.com\ndayrep.com\ndbunker.com\ndcemail.com\ndeadaddress.com\ndeadchildren.org\ndeadfake.cf\ndeadfake.ga\ndeadfake.ml\ndeadfake.tk\ndeadspam.com\ndeagot.com\ndealja.com\ndealrek.com\ndeekayen.us\ndefomail.com\ndegradedfun.net\ndelayload.com\ndelayload.net\ndelikkt.de\nder-kombi.de\nderkombi.de\nderluxuswagen.de\ndespam.it\ndespammed.com\ndevnullmail.com\ndharmatel.net\ndiapaulpainting.com\ndigitalmariachis.com\ndigitalsanctuary.com\ndildosfromspace.com\ndingbone.com\ndiscard.cf\ndiscard.email\ndiscard.ga\ndiscard.gq\ndiscard.ml\ndiscard.tk\ndiscardmail.com\ndiscardmail.de\ndispo.in\ndispomail.eu\ndisposable-email.ml\ndisposable.cf\ndisposable.ga\ndisposable.ml\ndisposableaddress.com\ndisposableemailaddresses.com\ndisposableemailaddresses.emailmiser.com\ndisposableinbox.com\ndispose.it\ndisposeamail.com\ndisposemail.com\ndispostable.com\ndivermail.com\ndivismail.ru\ndlemail.ru\ndm.w3internet.co.uk\ndm.w3internet.co.ukexample.com\ndodgeit.com\ndodgemail.de\ndodgit.com\ndodgit.org\ndodsi.com\ndoiea.com\ndolphinnet.net\ndomforfb1.tk\ndomforfb18.tk\ndomforfb19.tk\ndomforfb2.tk\ndomforfb23.tk\ndomforfb27.tk\ndomforfb29.tk\ndomforfb3.tk\ndomforfb4.tk\ndomforfb5.tk\ndomforfb6.tk\ndomforfb7.tk\ndomforfb8.tk\ndomforfb9.tk\ndomozmail.com\ndonemail.ru\ndontreg.com\ndontsendmespam.de\ndoquier.tk\ndotman.de\ndotmsg.com\ndotslashrage.com\ndouchelounge.com\ndozvon-spb.ru\ndr.vankin.de\ndrdrb.com\ndrdrb.net\ndrivetagdev.com\ndroolingfanboy.de\ndropcake.de\ndroplar.com\ndropmail.me\ndspwebservices.com\nduam.net\ndudmail.com\ndukedish.com\ndump-email.info\ndumpandjunk.com\ndumpmail.de\ndumpyemail.com\ndurandinterstellar.com\nduskmail.com\ndw.now.im\ndx.abuser.eu\ndx.allowed.org\ndx.awiki.org\ndx.ez.lv\ndx.sly.io\ndx.soon.it\ndx.z86.ru\ndyceroprojects.com\ndz17.net\ne-mail.com\ne-mail.org\ne.brasx.org\ne.coza.ro\ne.ezfill.com\ne.hecat.es\ne.hpc.tw\ne.incq.com\ne.lee.mx\ne.ohi.tw\ne.runi.ca\ne.sino.tw\ne.spr.io\ne.ubm.md\ne3z.de\ne4ward.com\neasy-trash-mail.com\neasytrashmail.com\nebeschlussbuch.de\nebs.com.ar\necallheandi.com\nedinburgh-airporthotels.com\nedv.to\nee1.pl\nee2.pl\neelmail.com\neinmalmail.de\neinrot.com\neinrot.de\neintagsmail.de\nelearningjournal.org\nelectro.mn\nelitevipatlantamodels.com\nemail-fake.cf\nemail-fake.ga\nemail-fake.gq\nemail-fake.ml\nemail-fake.tk\nemail-jetable.fr\nemail.cbes.net\nemail.net\nemail60.com\nemailage.cf\nemailage.ga\nemailage.gq\nemailage.ml\nemailage.tk\nemaildienst.de\nemailgo.de\nemailias.com\nemailigo.de\nemailinfive.com\nemailisvalid.com\nemaillime.com\nemailmiser.com\nemailproxsy.com\nemailresort.com\nemails.ga\nemailsensei.com\nemailsingularity.net\nemailspam.cf\nemailspam.ga\nemailspam.gq\nemailspam.ml\nemailspam.tk\nemailtemporanea.com\nemailtemporanea.net\nemailtemporar.ro\nemailtemporario.com.br\nemailthe.net\nemailtmp.com\nemailto.de\nemailwarden.com\nemailx.at.hm\nemailxfer.com\nemailz.cf\nemailz.ga\nemailz.gq\nemailz.ml\nemeil.in\nemeil.ir\nemil.com\nemkei.cf\nemkei.ga\nemkei.gq\nemkei.ml\nemkei.tk\neml.pp.ua\nemz.net\nenterto.com\nephemail.net\nephemeral.email\ner.fir.hk\ner.moot.es\nericjohnson.ml\nero-tube.org\nesc.la\nescapehatchapp.com\nesemay.com\nesgeneri.com\nesprity.com\nest.une.victime.ninja\netranquil.com\netranquil.net\netranquil.org\nevanfox.info\nevopo.com\nexample.com\nexitstageleft.net\nexplodemail.com\nexpress.net.ua\nextremail.ru\neyepaste.com\nezstest.com\nf.fuirio.com\nf.fxnxs.com\nf.hmh.ro\nf4k.es\nfacebook-email.cf\nfacebook-email.ga\nfacebook-email.ml\nfacebookmail.gq\nfacebookmail.ml\nfadingemail.com\nfag.wf\nfailbone.com\nfaithkills.com\nfake-email.pp.ua\nfake-mail.cf\nfake-mail.ga\nfake-mail.ml\nfakedemail.com\nfakeinbox.cf\nfakeinbox.com\nfakeinbox.ga\nfakeinbox.ml\nfakeinbox.tk\nfakeinformation.com\nfakemail.fr\nfakemailgenerator.com\nfakemailz.com\nfammix.com\nfangoh.com\nfansworldwide.de\nfantasymail.de\nfarrse.co.uk\nfastacura.com\nfastchevy.com\nfastchrysler.com\nfasternet.biz\nfastkawasaki.com\nfastmazda.com\nfastmitsubishi.com\nfastnissan.com\nfastsubaru.com\nfastsuzuki.com\nfasttoyota.com\nfastyamaha.com\nfatflap.com\nfdfdsfds.com\nfer-gabon.org\nfettometern.com\nfictionsite.com\nfightallspam.com\nfigjs.com\nfigshot.com\nfiifke.de\nfilbert4u.com\nfilberts4u.com\nfilm-blog.biz\nfilzmail.com\nfivemail.de\nfixmail.tk\nfizmail.com\nfleckens.hu\nflemail.ru\nflowu.com\nflurred.com\nfly-ts.de\nflyinggeek.net\nflyspam.com\nfoobarbot.net\nfootard.com\nforecastertests.com\nforgetmail.com\nfornow.eu\nforspam.net\nfoxja.com\nfoxtrotter.info\nfr.ipsur.org\nfr33mail.info\nfrapmail.com\nfree-email.cf\nfree-email.ga\nfreebabysittercam.com\nfreeblackbootytube.com\nfreecat.net\nfreedompop.us\nfreefattymovies.com\nfreeletter.me\nfreemail.hu\nfreemail.ms\nfreemails.cf\nfreemails.ga\nfreemails.ml\nfreeplumpervideos.com\nfreeschoolgirlvids.com\nfreesistercam.com\nfreeteenbums.com\nfreundin.ru\nfriendlymail.co.uk\nfront14.org\nfuckedupload.com\nfuckingduh.com\nfudgerub.com\nfunnycodesnippets.com\nfurzauflunge.de\nfux0ringduh.com\nfw.moza.pl\nfyii.de\ng.airsi.de\ng.asu.su\ng.garizo.com\ng.hmail.us\ng.rbb.org\ng.tefl.ro\ng.tiv.cc\ng.vda.ro\ng4hdrop.us\ngalaxy.tv\ngamegregious.com\ngarbagecollector.org\ngarbagemail.org\ngardenscape.ca\ngarliclife.com\ngarrifulio.mailexpire.com\ngarrymccooey.com\ngav0.com\ngawab.com\ngehensiemirnichtaufdensack.de\ngeldwaschmaschine.de\ngelitik.in\ngenderfuck.net\ngeschent.biz\nget-mail.cf\nget-mail.ga\nget-mail.ml\nget-mail.tk\nget.pp.ua\nget1mail.com\nget2mail.fr\ngetairmail.cf\ngetairmail.com\ngetairmail.ga\ngetairmail.gq\ngetairmail.ml\ngetairmail.tk\ngetmails.eu\ngetonemail.com\ngetonemail.net\ngg.nh3.ro\nghosttexter.de\ngiaiphapmuasam.com\ngiantmail.de\nginzi.be\nginzi.co.uk\nginzi.es\nginzi.net\nginzy.co.uk\nginzy.eu\ngirlsindetention.com\ngirlsundertheinfluence.com\ngishpuppy.com\nglitch.sx\nglobaltouron.com\nglucosegrin.com\ngmal.com\ngmial.com\ngmx.us\ngnctr-calgary.com\ngo.arduino.hk\ngo.cdpa.cc\ngo.irc.so\ngo.jmail.ro\ngo.jwork.ru\ngoemailgo.com\ngomail.in\ngorillaswithdirtyarmpits.com\ngothere.biz\ngotmail.com\ngotmail.net\ngotmail.org\ngotti.otherinbox.com\ngowikibooks.com\ngowikicampus.com\ngowikicars.com\ngowikifilms.com\ngowikigames.com\ngowikimusic.com\ngowikinetwork.com\ngowikitravel.com\ngowikitv.com\ngrandmamail.com\ngrandmasmail.com\ngreat-host.in\ngreensloth.com\ngreggamel.com\ngreggamel.net\ngregorsky.zone\ngregorygamel.com\ngregorygamel.net\ngrr.la\ngs-arc.org\ngsredcross.org\ngsrv.co.uk\ngudanglowongan.com\nguerillamail.biz\nguerillamail.com\nguerillamail.de\nguerillamail.info\nguerillamail.net\nguerillamail.org\nguerillamailblock.com\nguerrillamail.biz\nguerrillamail.com\nguerrillamail.de\nguerrillamail.info\nguerrillamail.net\nguerrillamail.org\nguerrillamailblock.com\ngustr.com\ngynzi.co.uk\ngynzi.es\ngynzy.at\ngynzy.es\ngynzy.eu\ngynzy.gr\ngynzy.info\ngynzy.lt\ngynzy.mobi\ngynzy.pl\ngynzy.ro\ngynzy.sk\nh.mintemail.com\nh8s.org\nhabitue.net\nhacccc.com\nhackthatbit.ch\nhahawrong.com\nhaltospam.com\nharakirimail.com\nhartbot.de\nhat-geld.de\nhatespam.org\nhawrong.com\nhazelnut4u.com\nhazelnuts4u.com\nhazmatshipping.org\nheathenhammer.com\nheathenhero.com\nhellodream.mobi\nhelloricky.com\nhelpinghandtaxcenter.org\nherp.in\nherpderp.nl\nhiddentragedy.com\nhidemail.de\nhidzz.com\nhighbros.org\nhmamail.com\nhoanggiaanh.com\nhochsitze.com\nhopemail.biz\nhot-mail.cf\nhot-mail.ga\nhot-mail.gq\nhot-mail.ml\nhot-mail.tk\nhotmai.com\nhotmial.com\nhotpop.com\nhq.okzk.com\nhulapla.de\nhumaility.com\nhumn.ws.gy\nhungpackage.com\nhush.ai\nhush.com\nhushmail.com\nhushmail.me\nhuskion.net\nhvastudiesucces.nl\nhwsye.net\nibnuh.bz\nicantbelieveineedtoexplainthisshit.com\nicx.in\nieatspam.eu\nieatspam.info\nieh-mail.de\nignoremail.com\nihateyoualot.info\niheartspam.org\nikbenspamvrij.nl\nillistnoise.com\nilovespam.com\nimails.info\nimgof.com\nimgv.de\nimstations.com\ninbax.tk\ninbound.plus\ninbox.si\ninbox2.info\ninboxalias.com\ninboxclean.com\ninboxclean.org\ninboxdesign.me\ninboxed.im\ninboxed.pw\ninboxproxy.com\ninboxstore.me\ninclusiveprogress.com\nincognitomail.com\nincognitomail.net\nincognitomail.org\nindieclad.com\nindirect.ws\nineec.net\ninfocom.zp.ua\ninoutmail.de\ninoutmail.eu\ninoutmail.info\ninoutmail.net\ninsanumingeniumhomebrew.com\ninsorg-mail.info\ninstant-mail.de\ninstantemailaddress.com\ninternetoftags.com\ninterstats.org\nintersteller.com\niozak.com\nip.nm7.cc\nip4.pp.ua\nip6.li\nip6.pp.ua\nipoo.org\nirish2me.com\niroid.com\nironiebehindert.de\nirssi.tv\nis.af\nisukrainestillacountry.com\nit7.ovh\nitunesgiftcodegenerator.com\niwi.net\nj-p.us\nj.svxr.org\njafps.com\njdmadventures.com\njellyrolls.com\njetable.com\njetable.fr.nf\njetable.net\njetable.org\njetable.pp.ua\njnxjn.com\njobbikszimpatizans.hu\njobposts.net\njobs-to-be-done.net\njoelpet.com\njoetestalot.com\njopho.com\njourrapide.com\njp.ftp.sh\njsrsolutions.com\njungkamushukum.com\njunk.to\njunk1e.com\njunkmail.ga\njunkmail.gq\nk.aelo.es\nk.avls.pt\nk.bgx.ro\nk.cylab.org\nk.kaovo.com\nk.kon42.com\nk.vesa.pw\nkakadua.net\nkalapi.org\nkamsg.com\nkariplan.com\nkartvelo.com\nkasmail.com\nkaspop.com\nkcrw.de\nkeepmymail.com\nkeinhirn.de\nkeipino.de\nkemptvillebaseball.com\nkennedy808.com\nkillmail.com\nkillmail.net\nkimsdisk.com\nkingsq.ga\nkiois.com\nkir.ch.tc\nkismail.ru\nkisstwink.com\nkitnastar.com\nklassmaster.com\nklassmaster.net\nkloap.com\nkludgemush.com\nklzlk.com\nkmhow.com\nkommunity.biz\nkook.ml\nkopagas.com\nkopaka.net\nkosmetik-obatkuat.com\nkostenlosemailadresse.de\nkoszmail.pl\nkrypton.tk\nkuhrap.com\nkulturbetrieb.info\nkurzepost.de\nkwift.net\nkwilco.net\nl-c-a.us\nl.logular.com\nl33r.eu\nlabetteraverouge.at\nlackmail.net\nlags.us\nlakelivingstonrealestate.com\nlandmail.co\nlaoeq.com\nlastmail.co\nlastmail.com\nlavabit.com\nlawlita.com\nlazyinbox.com\nleeching.net\nlellno.gq\nletmeinonthis.com\nletthemeatspam.com\nlez.se\nlhsdv.com\nliamcyrus.com\nlifebyfood.com\nlifetotech.com\nligsb.com\nlilo.me\nlindenbaumjapan.com\nlink2mail.net\nlinuxmail.so\nlitedrop.com\nlkgn.se\nllogin.ru\nloadby.us\nlocomodev.net\nlogin-email.cf\nlogin-email.ga\nlogin-email.ml\nlogin-email.tk\nloh.pp.ua\nloin.in\nlol.meepsheep.eu\nlol.ovpn.to\nlolfreak.net\nlolmail.biz\nlookugly.com\nlopl.co.cc\nlortemail.dk\nlosemymail.com\nlovemeleaveme.com\nlpfmgmtltd.com\nlr7.us\nlr78.com\nlroid.com\nlru.me\nluckymail.org\nlukecarriere.com\nlukemail.info\nlukop.dk\nluv2.us\nlyfestylecreditsolutions.com\nm.ddcrew.com\nm21.cc\nm4ilweb.info\nma1l.bij.pl\nmaboard.com\nmac.hush.com\nmacromaid.com\nmagamail.com\nmagicbox.ro\nmaidlow.info\nmail-filter.com\nmail-owl.com\nmail-temporaire.com\nmail-temporaire.fr\nmail.bccto.me\nmail.by\nmail.mezimages.net\nmail.zp.ua\nmail114.net\nmail1a.de\nmail21.cc\nmail2rss.org\nmail2world.com\nmail333.com\nmail4trash.com\nmail666.ru\nmail707.com\nmail72.com\nmailback.com\nmailbidon.com\nmailbiz.biz\nmailblocks.com\nmailbucket.org\nmailcat.biz\nmailcatch.com\nmailchop.com\nmailde.de\nmailde.info\nmaildrop.cc\nmaildrop.cf\nmaildrop.ga\nmaildrop.gq\nmaildrop.ml\nmaildu.de\nmaildx.com\nmaileater.com\nmailed.in\nmailed.ro\nmaileimer.de\nmailexpire.com\nmailfa.tk\nmailforspam.com\nmailfree.ga\nmailfree.gq\nmailfree.ml\nmailfreeonline.com\nmailfs.com\nmailguard.me\nmailhazard.com\nmailhazard.us\nmailhz.me\nmailimate.com\nmailin8r.com\nmailinatar.com\nmailinater.com\nmailinator.co.uk\nmailinator.com\nmailinator.gq\nmailinator.info\nmailinator.net\nmailinator.org\nmailinator.us\nmailinator2.com\nmailincubator.com\nmailismagic.com\nmailita.tk\nmailjunk.cf\nmailjunk.ga\nmailjunk.gq\nmailjunk.ml\nmailjunk.tk\nmailmate.com\nmailme.gq\nmailme.ir\nmailme.lv\nmailme24.com\nmailmetrash.com\nmailmoat.com\nmailms.com\nmailnator.com\nmailnesia.com\nmailnull.com\nmailonaut.com\nmailorc.com\nmailorg.org\nmailpick.biz\nmailproxsy.com\nmailquack.com\nmailrock.biz\nmailsac.com\nmailscrap.com\nmailseal.de\nmailshell.com\nmailsiphon.com\nmailslapping.com\nmailslite.com\nmailtemp.info\nmailtemporaire.com\nmailtemporaire.fr\nmailtome.de\nmailtothis.com\nmailtrash.net\nmailtv.net\nmailtv.tv\nmailzi.ru\nmailzilla.com\nmailzilla.org\nmailzilla.orgmbx.cc\nmakemetheking.com\nmalahov.de\nmalayalamdtp.com\nmanifestgenerator.com\nmansiondev.com\nmanybrain.com\nmarkmurfin.com\nmbx.cc\nmcache.net\nmciek.com\nmega.zik.dj\nmeinspamschutz.de\nmeltmail.com\nmessagebeamer.de\nmesswiththebestdielikethe.rest\nmezimages.net\nmfsa.ru\nmiaferrari.com\nmidcoastcustoms.com\nmidcoastcustoms.net\nmidcoastsolutions.com\nmidcoastsolutions.net\nmidlertidig.com\nmidlertidig.net\nmidlertidig.org\nmierdamail.com\nmigmail.net\nmigmail.pl\nmigumail.com\nmijnhva.nl\nmildin.org.ua\nministry-of-silly-walks.de\nmintemail.com\nmisterpinball.de\nmjukglass.nu\nmkpfilm.com\nml8.ca\nmoakt.com\nmobi.web.id\nmobileninja.co.uk\nmoburl.com\nmockmyid.com\nmohmal.com\nmomentics.ru\nmoncourrier.fr.nf\nmonemail.fr.nf\nmoneypipe.net\nmonmail.fr.nf\nmonumentmail.com\nmoonwake.com\nmor19.uu.gl\nmoreawesomethanyou.com\nmoreorcs.com\nmotique.de\nmountainregionallibrary.net\nmox.pp.ua\nms9.mailslite.com\nmsa.minsmail.com\nmsb.minsmail.com\nmsgos.com\nmspeciosa.com\nmswork.ru\nmsxd.com\nmt2009.com\nmt2014.com\nmt2015.com\nmtmdev.com\nmuathegame.com\nmuchomail.com\nmucincanon.com\nmutant.me\nmwarner.org\nmx0.wwwnew.eu\nmxfuel.com\nmy.efxs.ca\nmy10minutemail.com\nmybitti.de\nmycard.net.ua\nmycleaninbox.net\nmycorneroftheinter.net\nmydemo.equipment\nmyecho.es\nmyemailboxy.com\nmykickassideas.com\nmymail-in.net\nmymailoasis.com\nmynetstore.de\nmyopang.com\nmypacks.net\nmypartyclip.de\nmyphantomemail.com\nmysamp.de\nmyspaceinc.com\nmyspaceinc.net\nmyspaceinc.org\nmyspacepimpedup.com\nmyspamless.com\nmytemp.email\nmytempemail.com\nmytempmail.com\nmytrashmail.com\nmywarnernet.net\nmyzx.com\nn.rabin.ca\nn1nja.org\nnabuma.com\nnakedtruth.biz\nnanonym.ch\nnationalgardeningclub.com\nnaver.com\nnegated.com\nneomailbox.com\nnepwk.com\nnervmich.net\nnervtmich.net\nnetmails.com\nnetmails.net\nnetricity.nl\nnetris.net\nnetviewer-france.com\nnetzidiot.de\nnevermail.de\nnew.apps.dj\nnextstopvalhalla.com\nnfast.net\nnguyenusedcars.com\nnice-4u.com\nnicknassar.com\nnincsmail.hu\nniwl.net\nnmail.cf\nnnh.com\nnnot.net\nno-spam.ws\nno-ux.com\nnoblepioneer.com\nnobugmail.com\nnobulk.com\nnobuma.com\nnoclickemail.com\nnodezine.com\nnogmailspam.info\nnokiamail.com\nnomail.pw\nnomail.xl.cx\nnomail2me.com\nnomorespamemails.com\nnonspam.eu\nnonspammer.de\nnoref.in\nnorseforce.com\nnospam.wins.com.br\nnospam.ze.tc\nnospam4.us\nnospamfor.us\nnospamthanks.info\nnothingtoseehere.ca\nnotmailinator.com\nnotrnailinator.com\nnotsharingmy.info\nnowhere.org\nnowmymail.com\nntlhelp.net\nnubescontrol.com\nnullbox.info\nnurfuerspam.de\nnus.edu.sg\nnuts2trade.com\nnwldx.com\nny7.me\no.cavi.mx\no.civx.org\no.cnew.ir\no.jpco.org\no.mm5.se\no.opp24.com\no.rma.ec\no.sin.cl\no.yedi.org\no2stk.org\no7i.net\nobfusko.com\nobjectmail.com\nobobbo.com\nobxpestcontrol.com\nodaymail.com\nodnorazovoe.ru\noerpub.org\noffshore-proxies.net\nohaaa.de\nokclprojects.com\nokrent.us\nolypmall.ru\nomail.pro\nomnievents.org\none-time.email\noneoffemail.com\noneoffmail.com\nonewaymail.com\nonlatedotcom.info\nonline.ms\nonlineidea.info\nonqin.com\nontyne.biz\noolus.com\noopi.org\nopayq.com\nordinaryamerican.net\noshietechan.link\notherinbox.com\nourklips.com\nourpreviewdomain.com\noutlawspam.com\novpn.to\nowlpic.com\nownsyou.de\noxopoha.com\np.mm.my\npa9e.com\npagamenti.tk\npancakemail.com\npaplease.com\npastebitch.com\npcusers.otherinbox.com\npenisgoes.in\npepbot.com\npeterdethier.com\npetrzilka.net\npfui.ru\nphotomark.net\nphpbb.uu.gl\npi.vu\npimpedupmyspace.com\npinehill-seattle.org\npingir.com\npisls.com\npjjkp.com\nplexolan.de\nplhk.ru\nplw.me\npo.bot.nu\npoczta.onet.pl\npoh.pp.ua\npojok.ml\npokiemobile.com\npolitikerclub.de\npooae.com\npoofy.org\npookmail.com\npoopiebutt.club\npopesodomy.com\npopgx.com\npostacin.com\npostonline.me\npoutineyourface.com\npowered.name\npowlearn.com\npp.ua\nprimabananen.net\nprivacy.net\nprivatdemail.net\nprivy-mail.com\nprivy-mail.de\nprivymail.de\npro-tag.org\nprocrackers.com\nprojectcl.com\npropscore.com\nproxymail.eu\nproxyparking.com\nprtnx.com\nprtz.eu\npub.ftpinc.ca\npunkass.com\npuk.us.to\npurcell.email\npurelogistics.org\nput2.net\nputthisinyourspamdatabase.com\npwrby.com\npx.dhm.ro\nq.awatum.de\nq.tic.ec\nqasti.com\nqipmail.net\nqisdo.com\nqisoa.com\nqoika.com\nqs.dp76.com\nqs.grish.de\nquadrafit.com\nquickinbox.com\nquickmail.nl\nqvy.me\nqwickmail.com\nr.ctos.ch\nr4nd0m.de\nradiku.ye.vc\nraetp9.com\nraketenmann.de\nrancidhome.net\nrandomail.net\nraqid.com\nrax.la\nraxtest.com\nrcpt.at\nrcs.gaggle.net\nreallymymail.com\nrealtyalerts.ca\nreceiveee.chickenkiller.com\nreceiveee.com\nrecipeforfailure.com\nrecode.me\nreconmail.com\nrecyclemail.dk\nredfeathercrow.com\nregbypass.com\nregbypass.comsafe-mail.net\nrejectmail.com\nreliable-mail.com\nremail.cf\nremail.ga\nremarkable.rocks\nremote.li\nreptilegenetics.com\nrevolvingdoorhoax.org\nrhyta.com\nriddermark.de\nrisingsuntouch.com\nrk9.chickenkiller.com\nrklips.com\nrmqkr.net\nrnailinator.com\nrobertspcrepair.com\nronnierage.net\nrotaniliam.com\nrowe-solutions.com\nroyal.net\nroyaldoodles.org\nrppkn.com\nrr.ige.es\nrtrtr.com\nruffrey.com\nrumgel.com\nrustydoor.com\nrx.dred.ru\nrx.qc.to\ns.sast.ro\ns.scay.net\ns0ny.net\ns33db0x.com\nsabrestlouis.com\nsackboii.com\nsafe-mail.net\nsafersignup.de\nsafetymail.info\nsafetypost.de\nsaharanightstempe.com\nsamsclass.info\nsandelf.de\nsandwhichvideo.com\nsanfinder.com\nsanim.net\nsanstr.com\nsatukosong.com\nsausen.com\nsaynotospams.com\nscatmail.com\nschachrol.com\nschafmail.de\nschmeissweg.tk\nschrott-email.de\nsd3.in\nsecmail.pw\nsecretemail.de\nsecure-mail.biz\nsecure-mail.cc\nsecured-link.net\nsecurehost.com.es\nseekapps.com\nsejaa.lv\nselfdestructingmail.com\nselfdestructingmail.org\nsendfree.org\nsendingspecialflyers.com\nsendspamhere.com\nsenseless-entertainment.com\nserver.ms\nservices391.com\nsexforswingers.com\nsexical.com\nsharedmailbox.org\nsharklasers.com\nshhmail.com\nshhuut.org\nshieldedmail.com\nshieldemail.com\nshiftmail.com\nshipfromto.com\nshiphazmat.org\nshipping-regulations.com\nshippingterms.org\nshitmail.de\nshitmail.me\nshitmail.org\nshitware.nl\nshmeriously.com\nshortmail.net\nshotmail.ru\nshowslow.de\nshrib.com\nshut.name\nshut.ws\nsibmail.com\nsify.com\nsimpleitsecurity.info\nsinfiltro.cl\nsinglespride.com\nsinnlos-mail.de\nsiteposter.net\nsizzlemctwizzle.com\nskeefmail.com\nskkk.edu.my\nsky-inbox.com\nsky-ts.de\nslapsfromlastnight.com\nslaskpost.se\nslave-auctions.net\nslopsbox.com\nslothmail.net\nslushmail.com\nsmapfree24.com\nsmapfree24.de\nsmapfree24.eu\nsmapfree24.info\nsmapfree24.org\nsmashmail.de\nsmellfear.com\nsmellrear.com\nsmtp99.com\nsmwg.info\nsnakemail.com\nsneakemail.com\nsneakmail.de\nsnkmail.com\nsocialfurry.org\nsofimail.com\nsofort-mail.de\nsofortmail.de\nsoftpls.asia\nsogetthis.com\nsohu.com\nsoisz.com\nsolvemail.info\nsolventtrap.wiki\nsoodmail.com\nsoodomail.com\nsoodonims.com\nspam-be-gone.com\nspam.la\nspam.org.es\nspam.su\nspam4.me\nspamail.de\nspamarrest.com\nspamavert.com\nspambob.com\nspambob.net\nspambob.org\nspambog.com\nspambog.de\nspambog.net\nspambog.ru\nspambooger.com\nspambox.info\nspambox.irishspringrealty.com\nspambox.org\nspambox.us\nspamcero.com\nspamcon.org\nspamcorptastic.com\nspamcowboy.com\nspamcowboy.net\nspamcowboy.org\nspamday.com\nspamdecoy.net\nspamex.com\nspamfighter.cf\nspamfighter.ga\nspamfighter.gq\nspamfighter.ml\nspamfighter.tk\nspamfree.eu\nspamfree24.com\nspamfree24.de\nspamfree24.eu\nspamfree24.info\nspamfree24.net\nspamfree24.org\nspamgoes.in\nspamherelots.com\nspamhereplease.com\nspamhole.com\nspamify.com\nspaminator.de\nspamkill.info\nspaml.com\nspaml.de\nspamlot.net\nspammotel.com\nspamobox.com\nspamoff.de\nspamsalad.in\nspamslicer.com\nspamspot.com\nspamstack.net\nspamthis.co.uk\nspamthisplease.com\nspamtrail.com\nspamtroll.net\nspeed.1s.fr\nspeedgaus.net\nspikio.com\nspoofmail.de\nspritzzone.de\nspybox.de\nsquizzy.de\nsr.ro.lt\nsry.li\nss.hi5.si\nss.icx.ro\nss.undo.it\nssoia.com\nstanfordujjain.com\nstarlight-breaker.net\nstartfu.com\nstartkeys.com\nstatdvr.com\nstathost.net\nstatiix.com\nsteambot.net\nstinkefinger.net\nstop-my-spam.cf\nstop-my-spam.com\nstop-my-spam.ga\nstop-my-spam.ml\nstop-my-spam.pp.ua\nstop-my-spam.tk\nstreetwisemail.com\nstuffmail.de\nstumpfwerk.com\nsub.internetoftags.com\nsuburbanthug.com\nsuckmyd.com\nsudolife.me\nsudolife.net\nsudomail.biz\nsudomail.com\nsudomail.net\nsudoverse.com\nsudoverse.net\nsudoweb.net\nsudoworld.com\nsudoworld.net\nsuioe.com\nsuper-auswahl.de\nsupergreatmail.com\nsupermailer.jp\nsuperplatyna.com\nsuperrito.com\nsuperstachel.de\nsuremail.info\nsvk.jp\nsweetxxx.de\nswift10minutemail.com\nsylvannet.com\nt.psh.me\ntafmail.com\ntafoi.gr\ntagmymedia.com\ntagyourself.com\ntalkinator.com\ntanukis.org\ntapchicuoihoi.com\ntb-on-line.net\nte.adiq.eu\ntechemail.com\ntechgroup.me\nteewars.org\ntelecomix.pl\nteleworm.com\nteleworm.us\ntemp-mail.com\ntemp-mail.de\ntemp-mail.org\ntemp-mail.ru\ntemp.bartdevos.be\ntemp.emeraldwebmail.com\ntemp.headstrong.de\ntempail.com\ntempalias.com\ntempe-mail.com\ntempemail.biz\ntempemail.co.za\ntempemail.com\ntempemail.net\ntempinbox.co.uk\ntempinbox.com\ntempmail.co\ntempmail.eu\ntempmail.it\ntempmail2.com\ntempmaildemo.com\ntempmailer.com\ntempmailer.de\ntempomail.fr\ntemporarily.de\ntemporarioemail.com.br\ntemporaryemail.net\ntemporaryemail.us\ntemporaryforwarding.com\ntemporaryinbox.com\ntemporarymailaddress.com\ntempsky.com\ntempthe.net\ntempymail.com\ntestudine.com\nth.edgex.ru\nthanksnospam.info\nthankyou2010.com\nthc.st\ntheaviors.com\nthebearshark.com\nthecloudindex.com\nthediamants.org\nthelimestones.com\nthembones.com.au\nthemostemail.com\nthereddoors.online\nthescrappermovie.com\ntheteastory.info\nthietbivanphong.asia\nthisisnotmyrealemail.com\nthismail.net\nthisurl.website\nthnikka.com\nthraml.com\nthrma.com\nthroam.com\nthrott.com\nthrowawayemailaddress.com\nthrowawaymail.com\nthunkinator.org\nthxmate.com\ntilien.com\ntimgiarevn.com\ntimkassouf.com\ntinyurl24.com\ntittbit.in\ntizi.com\ntlpn.org\ntm.tosunkaya.com\ntmail.com\ntmail.ws\ntmailinator.com\ntmpjr.me\ntoddsbighug.com\ntoiea.com\ntokem.co\ntokenmail.de\ntonymanso.com\ntoomail.biz\ntop101.de\ntop1mail.ru\ntop1post.ru\ntopofertasdehoy.com\ntopranklist.de\ntoprumours.com\ntormail.org\ntoss.pw\ntotalvista.com\ntotesmail.com\ntp-qa-mail.com\ntradermail.info\ntranceversal.com\ntrash-amil.com\ntrash-mail.at\ntrash-mail.cf\ntrash-mail.com\ntrash-mail.de\ntrash-mail.ga\ntrash-mail.gq\ntrash-mail.ml\ntrash-mail.tk\ntrash2009.com\ntrash2010.com\ntrash2011.com\ntrashcanmail.com\ntrashdevil.com\ntrashdevil.de\ntrashemail.de\ntrashinbox.com\ntrashmail.at\ntrashmail.com\ntrashmail.de\ntrashmail.me\ntrashmail.net\ntrashmail.org\ntrashmail.ws\ntrashmailer.com\ntrashymail.com\ntrashymail.net\ntrasz.com\ntrayna.com\ntrbvm.com\ntrbvn.com\ntrbvo.com\ntrialmail.de\ntrickmail.net\ntrillianpro.com\ntrollproject.com\ntropicalbass.info\ntrungtamtoeic.com\ntryalert.com\nttszuo.xyz\ntualias.com\nturoid.com\nturual.com\ntwinmail.de\ntwoweirdtricks.com\ntxtadvertise.com\nty.ceed.se\ntyldd.com\nu.42o.org\nu.duk33.com\nu.hs.vc\nu.jdz.ro\nu.mji.ro\nu.qibl.at\nu.oroki.de\nu.ozyl.de\nu.rvb.ro\nu.thex.ro\nu.tkitc.de\nu.wef.gr\nubismail.net\nufacturing.com\nuggsrock.com\nuguuchantele.com\nuhhu.ru\numail.net\nunimark.org\nunit7lahaina.com\nunmail.ru\nupliftnow.com\nuplipht.com\nuploadnolimit.com\nurfunktion.se\nuroid.com\nus.af\nusername.e4ward.com\nutiket.us\nuwork4.us\nux.dob.jp\nux.uk.to\nuyhip.com\nvaati.org\nvalemail.net\nvalhalladev.com\nvenompen.com\nverdejo.com\nveryday.ch\nveryday.eu\nveryday.info\nveryrealemail.com\nvfemail.net\nvg.dab.ro\nvictoriantwins.com\nvidchart.com\nviditag.com\nviewcastmedia.com\nviewcastmedia.net\nviewcastmedia.org\nvikingsonly.com\nvinernet.com\nvipmail.name\nvipmail.pw\nvipxm.net\nviralplays.com\nvixletdev.com\nvkcode.ru\nvmailing.info\nvmani.com\nvmpanda.com\nvo.yoo.ro\nvoidbay.com\nvomoto.com\nvorga.org\nvotiputox.org\nvoxelcore.com\nvp.ycare.de\nvpn.st\nvsimcard.com\nvubby.com\nvztc.com\nwakingupesther.com\nwalala.org\nwalkmail.net\nwalkmail.ru\nwasteland.rfc822.org\nwatch-harry-potter.com\nwatchever.biz\nwatchfull.net\nwatchironman3onlinefreefullmovie.com\nwbml.net\nwe.geteit.com\nwe.ldop.com\nwe.ldtp.com\nwe.qq.my\nwe.vrmtr.com\nwe.wallm.com\nweb-mail.pp.ua\nwebemail.me\nwebm4il.info\nwebtrip.ch\nwebuser.in\nwee.my\nwefjo.grn.cc\nweg-werf-email.de\nwegwerf-email-addressen.de\nwegwerf-email-adressen.de\nwegwerf-email.de\nwegwerf-email.net\nwegwerf-emails.de\nwegwerfadresse.de\nwegwerfemail.com\nwegwerfemail.de\nwegwerfemail.net\nwegwerfemail.org\nwegwerfemailadresse.com\nwegwerfmail.de\nwegwerfmail.info\nwegwerfmail.net\nwegwerfmail.org\nwegwerpmailadres.nl\nwegwrfmail.de\nwegwrfmail.net\nwegwrfmail.org\nwelikecookies.com\nwetrainbayarea.com\nwetrainbayarea.org\nwg0.com\nwh4f.org\nwhatiaas.com\nwhatifanalytics.com\nwhatpaas.com\nwhatsaas.com\nwhiffles.org\nwhopy.com\nwhtjddn.33mail.com\nwhyspam.me\nwibblesmith.com\nwickmail.net\nwidget.gg\nwilemail.com\nwillhackforfood.biz\nwillselfdestruct.com\nwimsg.com\nwinemaven.info\nwmail.cf\nwolfsmail.tk\nwollan.info\nworldspace.link\nwovz.cu.cc\nwr.moeri.org\nwralawfirm.com\nwriteme.us\nwronghead.com\nws.yodx.ro\nwuzup.net\nwuzupmail.net\nwww.bccto.me\nwww.e4ward.com\nwww.gishpuppy.com\nwww.mailinator.com\nwwwnew.eu\nx.ip6.li\nx1x.spb.ru\nx24.com\nxagloo.co\nxagloo.com\nxcompress.com\nxcpy.com\nxemaps.com\nxents.com\nxing886.uu.gl\nxjoi.com\nxmail.com\nxmaily.com\nxn--9kq967o.com\nxoxox.cc\nxrho.com\nxwaretech.com\nxwaretech.info\nxwaretech.net\nxww.ro\nxyzfree.net\ny.bcb.ro\ny.epb.ro\ny.gzb.ro\ny.tyhe.ro\nyanet.me\nyapped.net\nyaqp.com\nye.nonze.ro\nyep.it\nyert.ye.vc\nyhg.biz\nynmrealty.com\nyogamaven.com\nyomail.info\nyopmail.com\nyopmail.fr\nyopmail.gq\nyopmail.net\nyopmail.pp.ua\nyou-spam.com\nyougotgoated.com\nyoumail.ga\nyoumailr.com\nyouneedmore.info\nyourdomain.com\nyourewronghereswhy.com\nyourlms.biz\nypmail.webarnak.fr.eu.org\nyspend.com\nyugasandrika.com\nyui.it\nyuurok.com\nyxzx.net\nz1p.biz\nza.com\nze.gally.jp\nzebins.com\nzebins.eu\nzehnminuten.de\nzehnminutenmail.de\nzepp.dk\nzetmail.com\nzippymail.info\nzipsendtest.com\nzoaxe.com\nzoemail.com\nzoemail.net\nzoemail.org\nzoetropes.org\nzombie-hive.com\nzomg.info\nzumpul.com\nzxcv.com\nzxcvbnm.com\nzzz.com\", UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('payment_gateway_sandbox', 'bool', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('gallery_max_width_height', 'int', '1500', UNIX_TIMESTAMP(), 1);";


# ############################

#
# Table structure for table `" . $DBPrefix . "statssettings`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "statssettings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "statssettings` (
  `activate` enum('y','n') NOT NULL default 'y',
  `accesses` enum('y','n') NOT NULL default 'y',
  `browsers` enum('y','n') NOT NULL default 'y',
  `domains` enum('y','n') NOT NULL default 'y'
) ;";

#
# Dumping data for table `" . $DBPrefix . "statssettings`
#

$query[] = "INSERT INTO `" . $DBPrefix . "statssettings` VALUES ('y', 'y', 'y', 'y');";


# ############################

#
# Table structure for table `" . $DBPrefix . "tax`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "tax`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "tax` (
  `id` INT(2) NOT NULL AUTO_INCREMENT,
  `tax_name` VARCHAR(30) NOT NULL ,
  `tax_rate` DOUBLE(16, 2) NOT NULL ,
  `countries_seller` TEXT NOT NULL ,
  `countries_buyer` TEXT NOT NULL ,
  `fee_tax` INT(1) NOT NULL DEFAULT  '0',
  PRIMARY KEY (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "tax`
#

$query[] = "INSERT INTO `" . $DBPrefix . "tax` VALUES (NULL, 'Site Fees', '0', '', '', '1');";

# ############################

#
# Table structure for table `" . $DBPrefix . "users`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "users`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "users` (
  `id` int(11) NOT NULL auto_increment,
  `nick` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_type` INT(1) NOT NULL DEFAULT '1',
  `hash` varchar(5) default '',
  `name` tinytext,
  `address` tinytext,
  `city` varchar(25) default '',
  `prov` varchar(20) default '',
  `country` varchar(30) default '',
  `zip` varchar(10) default '',
  `phone` varchar(40) default '',
  `email` varchar(50) default '',
  `reg_date` int(11) default NULL,
  `rate_sum` int(11) NOT NULL default '0',
  `rate_num` int(11) NOT NULL default '0',
  `birthdate` int(8) default '0',
  `suspended` int(1) default '0',
  `nletter` int(1) NOT NULL default '0',
  `balance` double(16,2) NOT NULL default '0',
  `auc_watch` text,
  `item_watch` text,
  `endemailmode` enum('one','cum','none') NOT NULL default 'one',
  `startemailmode` enum('yes','no') NOT NULL default 'yes',
  `emailtype` enum('html','text') NOT NULL default 'html',
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `payment_details` text,
  `groups` text,
  `bn_only` enum('y','n') NOT NULL default 'y',
  `timezone` varchar(50) NOT NULL default 'Europe/London',
  `paypal_email` varchar(50) default '',
  `authnet_id` varchar(50) default '',
  `authnet_pass` varchar(50) default '',
  `worldpay_id` varchar(50) default '',
  `moneybookers_email` varchar(50) default '',
  `toocheckout_id` varchar(50) default '',
  `language` char(2) NOT NULL default '',
  PRIMARY KEY  (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "users`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "useraccounts`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "useraccounts`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "useraccounts` (
  `useracc_id` int(11) NOT NULL AUTO_INCREMENT,
  `auc_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  `setup` double(8,2) NOT NULL default '0',
  `featured` double(8,2) NOT NULL default '0',
  `bold` double(8,2) NOT NULL default '0',
  `highlighted` double(8,2) NOT NULL default '0',
  `subtitle` double(8,2) NOT NULL default '0',
  `relist` double(8,2) NOT NULL default '0',
  `reserve` double(8,2) NOT NULL default '0',
  `buynow` double(8,2) NOT NULL default '0',
  `picture` double(8,2) NOT NULL default '0',
  `extracat` double(8,2) NOT NULL default '0',
  `signup` double(8,2) NOT NULL default '0',
  `buyer` double(8,2) NOT NULL default '0',
  `finalval` double(8,2) NOT NULL default '0',
  `balance` double(8,2) NOT NULL default '0',
  `total` double(8,2) NOT NULL,
  `paid` int(1) NOT NULL default '0',
  PRIMARY KEY (`useracc_id`)
);";

#
# Dumping data for table `" . $DBPrefix . "useraccounts`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "usersips`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "usersips`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "usersips` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) default NULL,
  `ip` varchar(15) default NULL,
  `type` enum('first','after') NOT NULL default 'first',
  `action` enum('accept','deny') NOT NULL default 'accept',
  PRIMARY KEY  (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "usersips`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "usergateways`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "usergateways`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "usergateways` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `gateway_id` int(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  PRIMARY KEY(`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "usergateways`
#

# ############################

#
# Table structure for table `" . $DBPrefix . "winners`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "winners`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "winners` (
  `id` int(11) NOT NULL auto_increment,
  `auction` int(11) NOT NULL default '0',
  `seller` int(11) NOT NULL default '0',
  `winner` int(11) NOT NULL default '0',
  `bid` double(16,2) NOT NULL default '0',
  `auc_title` varchar(70),
  `auc_shipping_cost` double(16,2) default '0',
  `auc_payment` tinytext,
  `closingdate` int(11) NOT NULL default '0',
  `feedback_win` tinyint(1) NOT NULL default '0',
  `feedback_sel` tinyint(1) NOT NULL default '0',
  `qty` int(11) NOT NULL default '1',
  `paid` int(1) NOT NULL default '0',
  `bf_paid` INT(1) NOT NULL DEFAULT  '0',
  `ff_paid` INT(1) NOT NULL DEFAULT '1',
  `shipped` INT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ;";
