<?php

#
# Table structure for table `" . $DBPrefix . "accesseshistoric`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "accesseshistoric`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "accesseshistoric` (
  `month` char(2) NOT NULL default '',
  `year` char(4) NOT NULL default '',
  `pageviews` int(11) NOT NULL default '0',
  `uniquevisitiors` int(11) NOT NULL default '0',
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
	`id` INT(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`nick` VARCHAR(20) NOT NULL,
	`name` TINYTEXT NOT NULL,
	`text` TEXT NOT NULL,
	`type` VARCHAR(15) NOT NULL,
	`paid_date` VARCHAR(16) NOT NULL,
	`amount` DOUBLE(6,2) NOT NULL,
	`day` INT(3) NOT NULL,
	`week` INT(2) NOT NULL,
	`month` INT(2) NOT NULL,
	`year` INT(4) NOT NULL
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
  `hash` varchar(5) NOT NULL default '',
  `created` varchar(8) NOT NULL default '',
  `lastlogin` varchar(14) NOT NULL default '',
  `status` int(2) NOT NULL default '0',
  `notes` text,
  KEY `id` (`id`)
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
  `id` int(32) NOT NULL auto_increment,
  `user` int(32) default NULL,
  `title` varchar(70),
  `subtitle` varchar(70),
  `starts` varchar(14) default NULL,
  `description` text,
  `pict_url` tinytext,
  `category` int(11) default NULL,
  `secondcat` int(11) default NULL,
  `minimum_bid` double(16,2) default '0',
  `shipping_cost` double(16,2) default '0',
  `shipping_cost_additional` double(16,2) default '0',
  `reserve_price` double(16,2) default '0',
  `buy_now` double(16,2) default '0',
  `auction_type` char(1) default NULL,
  `duration` double(8,2) default NULL,
  `increment` double(8,2) NOT NULL default '0',
  `shipping` char(1) default NULL,
  `payment` tinytext,
  `international` char(1) default NULL,
  `ends` varchar(14) default NULL,
  `current_bid` double(16,2) default '0',
  `current_bid_id` int(11) default '0',
  `closed` int(1) default '0',
  `photo_uploaded` tinyint(1) default NULL,
  `initial_quantity` int(11) default '1',
  `quantity` int(11) default '1',
  `suspended` int(1) default '0',
  `relist` int(11) NOT NULL default '0',
  `relisted` int(11) NOT NULL default '0',
  `num_bids` int(11) NOT NULL default '0',
  `sold` enum('y', 'n', 's') NOT NULL default 'n',
  `shipping_terms` tinytext,
  `bn_only` enum('y','n') NOT NULL default 'n',
  `bold` enum('y','n') NOT NULL default 'n',
  `highlighted` enum('y','n') NOT NULL default 'n',
  `featured` enum('y','n') NOT NULL default 'n',
  `current_fee` double(16,2) default '0',
  `tax`  enum('y','n') NOT NULL default 'n',
  `taxinc`  enum('y','n') NOT NULL default 'y',
  `bn_sale` int(1) default 0,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);";

#
# Dumping data for table `" . $DBPrefix . "auctions`
#


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
  KEY `id` (`id`)
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
  `clicks` int(11) default NULL,
  KEY `id` (`banner`)
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
  KEY `id` (`id`)
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
  `auction` int(32) default NULL,
  `bidder` int(32) default NULL,
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
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(2, 1, 340, 393, 0, 'Art &amp; Antiques', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(3, 2, 391, 392, 1, 'Textiles &amp; Linens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(4, 2, 389, 390, 1, 'Amateur Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(5, 2, 387, 388, 1, 'Ancient World', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(6, 2, 385, 386, 1, 'Books &amp; Manuscripts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(7, 2, 383, 384, 1, 'Cameras', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(8, 2, 363, 382, 1, 'Ceramics &amp; Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(9, 8, 364, 381, 2, 'Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(10, 9, 379, 380, 3, '40s, 50s &amp; 60s', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(11, 9, 377, 378, 3, 'Art Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(12, 9, 375, 376, 3, 'Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(13, 9, 373, 374, 3, 'Chalkware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(14, 9, 371, 372, 3, 'Chintz &amp; Shelley', 0, 0, '', '');";
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
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(28, 2, 341, 342, 1, 'Silver &amp; Silver Plate', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(29, 1, 262, 339, 0, 'Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(30, 29, 337, 338, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(31, 29, 335, 336, 1, 'Arts, Architecture &amp; Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(32, 29, 333, 334, 1, 'Audiobooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(33, 29, 331, 332, 1, 'Biographies &amp; Memoirs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(34, 29, 329, 330, 1, 'Business &amp; Investing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(35, 29, 327, 328, 1, 'Catalogs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(36, 29, 325, 326, 1, 'Children', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(37, 29, 323, 324, 1, 'Computers &amp; Internet', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(38, 29, 321, 322, 1, 'Contemporary', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(39, 29, 319, 320, 1, 'Cooking, Food &amp; Wine', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(40, 29, 317, 318, 1, 'Entertainment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(41, 29, 315, 316, 1, 'Foreign Language Instruction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(42, 29, 313, 314, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(43, 29, 311, 312, 1, 'Health, Mind &amp; Body', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(44, 29, 309, 310, 1, 'Historical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(45, 29, 307, 308, 1, 'History', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(46, 29, 305, 306, 1, 'Home &amp; Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(47, 29, 303, 304, 1, 'Horror', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(48, 29, 301, 302, 1, 'Illustrated', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(49, 29, 299, 300, 1, 'Literature &amp; Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(50, 29, 297, 298, 1, 'Men', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(51, 29, 295, 296, 1, 'Mystery &amp; Thrillers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(52, 29, 293, 294, 1, 'News', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(53, 29, 291, 292, 1, 'Nonfiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(54, 29, 289, 290, 1, 'Parenting &amp; Families', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(55, 29, 287, 288, 1, 'Poetry', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(56, 29, 285, 286, 1, 'Rare', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(57, 29, 283, 284, 1, 'Reference', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(58, 29, 281, 282, 1, 'Regency', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(59, 29, 279, 280, 1, 'Religion &amp; Spirituality', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(60, 29, 277, 278, 1, 'Science &amp; Nature', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(61, 29, 275, 276, 1, 'Science Fiction &amp; Fantasy', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(62, 29, 273, 274, 1, 'Sports', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(63, 29, 271, 272, 1, 'Sports &amp; Outdoors', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(64, 29, 269, 270, 1, 'Teens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(65, 29, 267, 268, 1, 'Textbooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(66, 29, 265, 266, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(67, 29, 263, 264, 1, 'Women', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(68, 1, 254, 261, 0, 'Clothing &amp; Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(69, 68, 259, 260, 1, 'Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(70, 68, 257, 258, 1, 'Clothing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(71, 68, 255, 256, 1, 'Watches', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(72, 1, 248, 253, 0, 'Coins &amp; Stamps', 0, 0, '', '');";
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
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(84, 75, 229, 230, 1, 'Bottles &amp; Cans', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(85, 75, 227, 228, 1, 'Breweriana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(86, 75, 225, 226, 1, 'Cars &amp; Motorcycles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(87, 75, 223, 224, 1, 'Cereal Boxes &amp; Premiums', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(88, 75, 221, 222, 1, 'Character', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(89, 75, 219, 220, 1, 'Circus &amp; Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(90, 75, 217, 218, 1, 'Collector Plates', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(91, 75, 215, 216, 1, 'Dolls', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(92, 75, 213, 214, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(93, 75, 211, 212, 1, 'Historical &amp; Cultural', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(94, 75, 209, 210, 1, 'Holiday &amp; Seasonal', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(95, 75, 207, 208, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(96, 75, 205, 206, 1, 'Kitsch', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(97, 75, 203, 204, 1, 'Knives &amp; Swords', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(98, 75, 201, 202, 1, 'Lunchboxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(99, 75, 199, 200, 1, 'Magic &amp; Novelty Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(100, 75, 197, 198, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(101, 75, 195, 196, 1, 'Militaria', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(102, 75, 193, 194, 1, 'Music Boxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(103, 75, 191, 192, 1, 'Oddities', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(104, 75, 189, 190, 1, 'Paper', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(105, 75, 187, 188, 1, 'Pinbacks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(106, 75, 185, 186, 1, 'Porcelain Figurines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(107, 75, 183, 184, 1, 'Railroadiana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(108, 75, 181, 182, 1, 'Religious', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(109, 75, 179, 180, 1, 'Rocks, Minerals &amp; Fossils', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(110, 75, 177, 178, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(111, 75, 175, 176, 1, 'Textiles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(112, 75, 173, 174, 1, 'Tobacciana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(113, 1, 154, 171, 0, 'Comics, Cards &amp; Science Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(114, 113, 169, 170, 1, 'Anime &amp; Manga', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(115, 113, 167, 168, 1, 'Comic Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(116, 113, 165, 166, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(117, 113, 163, 164, 1, 'Godzilla', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(118, 113, 161, 162, 1, 'Star Trek', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(119, 113, 159, 160, 1, 'The X-Files', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(120, 113, 157, 158, 1, 'Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(121, 113, 155, 156, 1, 'Trading Cards', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(122, 1, 144, 153, 0, 'Computers &amp; Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(123, 122, 151, 152, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(124, 122, 149, 150, 1, 'Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(125, 122, 147, 148, 1, 'Internet Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(126, 122, 145, 146, 1, 'Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(127, 1, 132, 143, 0, 'Electronics &amp; Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(128, 127, 141, 142, 1, 'Consumer Electronics', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(129, 127, 139, 140, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(130, 127, 137, 138, 1, 'Photo Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(131, 127, 135, 136, 1, 'Recording Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(132, 127, 133, 134, 1, 'Video Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(133, 1, 112, 131, 0, 'Home &amp; Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(134, 133, 129, 130, 1, 'Baby Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(135, 133, 127, 128, 1, 'Crafts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(136, 133, 125, 126, 1, 'Furniture', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(137, 133, 123, 124, 1, 'Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(138, 133, 121, 122, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(139, 133, 119, 120, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(140, 133, 117, 118, 1, 'Pet Supplies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(141, 133, 115, 116, 1, 'Tools &amp; Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(142, 133, 113, 114, 1, 'Weddings', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(143, 1, 98, 111, 0, 'Movies &amp; Video', 0, 0, '', '');";
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
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(157, 1, 74, 83, 0, 'Office &amp; Business', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(158, 157, 81, 82, 1, 'Briefcases', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(159, 157, 79, 80, 1, 'Fax Machines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(160, 157, 77, 78, 1, 'General Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(161, 157, 75, 76, 1, 'Pagers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(162, 1, 58, 73, 0, 'Other Goods &amp; Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(163, 162, 71, 72, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(164, 162, 69, 70, 1, 'Metaphysical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(165, 162, 67, 68, 1, 'Property', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(166, 162, 65, 66, 1, 'Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(167, 162, 63, 64, 1, 'Tickets &amp; Events', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(168, 162, 61, 62, 1, 'Transportation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(169, 162, 59, 60, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(170, 1, 50, 57, 0, 'Sports &amp; Recreation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(171, 170, 55, 56, 1, 'Apparel &amp; Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(172, 170, 53, 54, 1, 'Exercise Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(173, 170, 51, 52, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(174, 1, 2, 49, 0, 'Toys &amp; Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(175, 174, 47, 48, 1, 'Action Figures', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(176, 174, 45, 46, 1, 'Beanie Babies &amp; Beanbag Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(177, 174, 43, 44, 1, 'Diecast', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(178, 174, 41, 42, 1, 'Fast Food', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(179, 174, 39, 40, 1, 'Fisher-Price', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(180, 174, 37, 38, 1, 'Furby', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(181, 174, 35, 36, 1, 'Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(182, 174, 33, 34, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(183, 174, 31, 32, 1, 'Giga Pet &amp; Tamagotchi', 0, 0, '', '');";
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
  KEY `msg_id` (`id`)
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
  `active` int(1) NOT NULL default '1',
  KEY `msg_id` (`id`)
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
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cocos &#40;Keeling&#41; Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Colombia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Comoros');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Congo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Congo, the Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cook Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Costa Rica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Cote d&#39;Ivoire');";
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
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Korea &#40;South&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kuwait');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Kyrgyzstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Lao People&#39;s Democratic Republic');";
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
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Samoa &#40;Independent&#41;');";
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
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Virgin Islands &#40;British&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES (NULL, 'Virgin Islands &#40;U.S.&#41;');";
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
  KEY `id` (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "faqs`
#

$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (2, 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (4, 'Item Watch', '<b>Item watch</b> notifies you when someone bids on the auctions that you have added to your Item Watch. ', 3);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (5, 'What is a Dutch auction?', 'Dutch auction is a type of auction where the auctioneer begins with a high asking price which is lowered until some participant is willing to accept the auctioneer\'s price. The winning participant pays the last announced price.', 1);";

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
  KEY `id` (`id`)
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
  `rated_user_id` int(32) default NULL,
  `rater_user_nick` varchar(20) default NULL,
  `feedback` mediumtext,
  `rate` int(2) default NULL,
  `feedbackdate` INT(15) NOT NULL,
  `auction_id` int(32) NOT NULL default '0',
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
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'setup');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hpfeat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'bolditem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hlitem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'rp_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'picture_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'subtitle_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'excat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'relist_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyout_fee');";
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
# Table structure for table `" . $DBPrefix . "gateways`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "gateways`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "gateways` (
  `gateways` text,
  `paypal_address` varchar(50) NOT NULL default '',
  `paypal_required` int(1) NOT NULL default '0',
  `paypal_active` int(1) NOT NULL default '0',
  `authnet_address` varchar(50) NOT NULL default '',
  `authnet_password` varchar(50) NOT NULL default '',
  `authnet_required` int(1) NOT NULL default '0',
  `authnet_active` int(1) NOT NULL default '0',
  `worldpay_id` varchar(50) NOT NULL default '',
  `worldpay_required` int(1) NOT NULL default '0',
  `worldpay_active` int(1) NOT NULL default '0',
  `moneybookers_address` varchar(50) NOT NULL default '',
  `moneybookers_required` int(1) NOT NULL default '0',
  `moneybookers_active` int(1) NOT NULL default '0',
  `toocheckout_id` varchar(50) NOT NULL default '',
  `toocheckout_required` int(1) NOT NULL default '0',
  `toocheckout_active` int(1) NOT NULL default '0'
) ;";

#
# Dumping data for table `" . $DBPrefix . "gateways`
#

$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('paypal,authnet,worldpay,moneybookers,toocheckout', '', 0, 0, '', '', 0, 0, '', 0, 0, '', 0, 0, '', 0, 0);";

# ############################

#
# Table structure for table `" . $DBPrefix . "groups`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "groups`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "groups` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL default '',
  `can_sell` int(1) NOT NULL default '0',
  `can_buy` int(1) NOT NULL default '0',
  `count` int(15) NOT NULL default '0',
  `auto_join` int(15) NOT NULL default '0',
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
  `id` INT( 25 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `type` VARCHAR( 5 ) NOT NULL ,
  `message` TEXT NOT NULL ,
  `action_id` INT( 11 ) NOT NULL DEFAULT  '0',
  `user_id` INT( 32 ) NOT NULL DEFAULT  '0',
  `ip` VARCHAR( 45 ) NOT NULL,
  `timestamp` INT( 11 ) NOT NULL DEFAULT  '0'
);";

#
# Dumping data for table `" . $DBPrefix . "logs`
#


# ############################

#
# Table structure for table `" . $DBPrefix . "maintainance`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "maintainance`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "maintainance` (
  `id` int(11) NOT NULL auto_increment,
  `active` enum('y','n') default NULL,
  `superuser` varchar(32) default NULL,
  `maintainancetext` text,
  KEY `id` (`id`)
) ;";

#
# Dumping data for table `" . $DBPrefix . "maintainance`
#

$query[] = "INSERT INTO `" . $DBPrefix . "maintainance` VALUES (1, 'n', 'renlok', '<br>\r\n<center>\r\n<b>Under maintenance!!!!!!!</b>\r\n</center>');";

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
  `id` int(50) NOT NULL AUTO_INCREMENT ,
  `sentto` int(25) NOT NULL default '0',
  `sentfrom` int(25) NOT NULL default '0',
  `fromemail` varchar(50) NOT NULL default '',
  `sentat` varchar(20) NOT NULL default '',
  `message` text NOT NULL ,
  `isread` int(1) NOT NULL default '0',
  `subject` varchar(50) NOT NULL default '',
  `replied` int(1) NOT NULL default '0',
  `reply_of` INT(50) NOT NULL default '0',
  `question` int(15) NOT NULL default '0',
  `public` INT(1) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ;";

# ############################

#
# Table structure for table `" . $DBPrefix . "news`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "news`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "news` (
  `id` int(32) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `content` longtext NOT NULL,
  `new_date` int(8) NOT NULL default '0',
  `suspended` int(1) NOT NULL default '0',
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
  `itemid` int(32) default NULL,
  `userid` int(32) default NULL,
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
# Table structure for table `" . $DBPrefix . "settings`
#
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "settings` (
  `fieldname` VARCHAR(30) NOT NULL,
  `fieldtype` VARCHAR(10) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
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
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('authnet_sandbox', 'int', '0', UNIX_TIMESTAMP(), 1);";
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
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('checkout_sandbox', 'int', '0', UNIX_TIMESTAMP(), 1);";
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
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('endingsoonnumber', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('errortext', 'str', '<p>An unexpected error occurred. The error has been forwarded to our technical team and will be fixed shortly</p>', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('extra_cat', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_disable_acc', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_max_debt', 'str', '25.00', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_signup_bonus', 'str', '0.00', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_type', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fees', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('gateways', 'str', 'a:5:{s:6:\"paypal\";s:6:\"PayPal\";s:7:\"authnet\";s:13:\"Authorize.net\";s:8:\"worldpay\";s:8:\"WorldPay\";s:12:\"moneybookers\";s:12:\"Moneybookers\";s:11:\"toocheckout\";s:9:\"2Checkout\";}', UNIX_TIMESTAMP(), 1);";
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
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('loginbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('logo', 'str', 'logo.png', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mail_parameter', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mail_protocol', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mandatory_fields', 'str', 'a:7:{s:9:\"birthdate\";s:1:\"n\";s:7:\"address\";s:1:\"y\";s:4:\"city\";s:1:\"y\";s:4:\"prov\";s:1:\"y\";s:7:\"country\";s:1:\"y\";s:3:\"zip\";s:1:\"y\";s:3:\"tel\";s:1:\"n\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maxpictures', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maxuploadsize', 'int', '51200', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mod_queue', 'bool, 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneybookers_sandbox', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneydecimals', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneyformat', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneysymbol', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newsletter', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newsbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newstoshow', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('payment_options', 'str', 'a:2:{i:0;s:13:\"Wire Transfer\";i:1;s:6:\"Cheque\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('paypal_sandbox', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('perpage', 'int', '15', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('picturesgallery', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('privacypolicy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('privacypolicytext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('proxy_bidding', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
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
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('subtitle', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('tax', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('taxuser', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('terms', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('termstext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('theme', 'str', 'classic', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('thumb_list', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('thumb_show', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('timecorrection', 'str', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('users_email', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('usersauth', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('version', 'str', '". package_version() ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('wordsfilter', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('worldpay_sandbox', 'int', '0', UNIX_TIMESTAMP(), 1);";


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
  `id` int(32) NOT NULL auto_increment,
  `nick` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `hash` varchar(5) default '',
  `name` tinytext,
  `address` tinytext,
  `city` varchar(25) default '',
  `prov` varchar(20) default '',
  `country` varchar(30) default '',
  `zip` varchar(10) default '',
  `phone` varchar(40) default '',
  `email` varchar(50) default '',
  `reg_date` int(15) default NULL,
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
  `timecorrection` decimal(3,1) NOT NULL default '0',
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
  `auc_id` int(15) NOT NULL default '0',
  `user_id` int(15) NOT NULL default '0',
  `date` int(15) NOT NULL default '0',
  `setup` double(8,2) NOT NULL default '0',
  `featured` double(8,2) NOT NULL default '0',
  `bold` double(8,2) NOT NULL default '0',
  `highlighted` double(8,2) NOT NULL default '0',
  `subtitle` double(8,2) NOT NULL default '0',
  `relist` double(8,2) NOT NULL default '0',
  `reserve` double(8,2) NOT NULL default '0',
  `buynow` double(8,2) NOT NULL default '0',
  `image` double(8,2) NOT NULL default '0',
  `extcat` double(8,2) NOT NULL default '0',
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
  `user` int(32) default NULL,
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
# Table structure for table `" . $DBPrefix . "winners`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "winners`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "winners` (
  `id` int(11) NOT NULL auto_increment,
  `auction` int(32) NOT NULL default '0',
  `seller` int(32) NOT NULL default '0',
  `winner` int(32) NOT NULL default '0',
  `bid` double(16,2) NOT NULL default '0',
  `auc_title` varchar(70),
  `auc_shipping_cost` double(16,2) default '0',
  `auc_payment` tinytext,
  `closingdate` int(15) NOT NULL default '0',
  `feedback_win` tinyint(1) NOT NULL default '0',
  `feedback_sel` tinyint(1) NOT NULL default '0',
  `qty` int(11) NOT NULL default '1',
  `paid` int(1) NOT NULL default '0',
  `bf_paid` INT(1) NOT NULL DEFAULT  '0',
  `ff_paid` INT(1) NOT NULL DEFAULT '1',
  `shipped` INT(1) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ;";

?>
