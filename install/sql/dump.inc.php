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
# Table structure for table `" . $DBPrefix . "adminusers`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "adminusers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "adminusers` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `hash` varchar(5) NOT NULL default '',
  `created` varchar(8) NOT NULL default '',
  `lastlogin` varchar(14) NOT NULL default '',
  `status` int(2) NOT NULL default '0',
  KEY `id` (`id`)
) AUTO_INCREMENT=1 ;";

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
  `starts` varchar(14) default NULL,
  `description` text,
  `pict_url` tinytext,
  `category` int(11) default NULL,
  `minimum_bid` double(16,4) default '0.00',
  `shipping_cost` double(16,4) default NULL,
  `reserve_price` double(16,4) default NULL,
  `buy_now` double(16,4) default NULL,
  `auction_type` char(1) default NULL,
  `duration` varchar(7) default NULL,
  `increment` double(8,4) NOT NULL default '0.0000',
  `shipping` char(1) default NULL,
  `payment` tinytext,
  `international` char(1) default NULL,
  `ends` varchar(14) default NULL,
  `current_bid` double(16,4) default NULL,
  `closed` char(2) default NULL,
  `photo_uploaded` tinyint(1) default NULL,
  `quantity` int(11) default NULL,
  `suspended` int(1) default '0',
  `private` enum('y','n') NOT NULL default 'n',
  `relist` int(11) NOT NULL default '0',
  `relisted` int(11) NOT NULL default '0',
  `num_bids` int(11) NOT NULL default '0',
  `sold` enum('y','n','s') NOT NULL default 'n',
  `shipping_terms` tinytext NOT NULL,
  `bn_only` enum('y','n') NOT NULL default 'n',
  `adultonly` enum('y','n') NOT NULL default 'n',
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
) AUTO_INCREMENT=1 ;";

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
) AUTO_INCREMENT=1 ;";

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
  `bid` double(16,4) default NULL,
  `bidwhen` varchar(14) default NULL,
  `quantity` int(11) default '0',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1 ;";

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
  `sub_counter` int(11) default NULL,
  `counter` int(11) default NULL,
  `cat_colour` tinytext NOT NULL,
  `cat_image` tinytext NOT NULL,
  PRIMARY KEY  (`cat_id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "categories`
# 

if ($_GET['cats'] == 1)
{
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(0, -1, 1, 390, -1, 'All', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 2, 55, 0, 'Art &amp; Antiques', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 7, 8, 1, 'Ancient World', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 5, 6, 1, 'Amateur Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 13, 32, 1, 'Ceramics &amp; Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 4, 14, 31, 2, 'Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 15, 16, 3, '40s, 50s &amp; 60s', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 17, 18, 3, 'Art Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 19, 20, 3, 'Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 25, 26, 3, 'Contemporary Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 29, 30, 3, 'Porcelain', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 21, 22, 3, 'Chalkware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 23, 24, 3, 'Chintz &amp; Shelley', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 5, 27, 28, 3, 'Decorative', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 33, 34, 1, 'Fine Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 35, 36, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 41, 42, 1, 'Painting', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 43, 44, 1, 'Photographic Images', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 49, 50, 1, 'Prints', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 9, 10, 1, 'Books &amp; Manuscripts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 11, 12, 1, 'Cameras', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 37, 38, 1, 'Musical Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 39, 40, 1, 'Orientalia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 45, 46, 1, 'Post-1900', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 47, 48, 1, 'Pre-1900', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 51, 52, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 1, 53, 54, 1, 'Silver &amp; Silver Plate', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 3, 4, 1, 'Textiles &amp; Linens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 56, 133, 0, 'Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 59, 60, 1, 'Arts, Architecture &amp; Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 61, 62, 1, 'Audiobooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 63, 64, 1, 'Biographies &amp; Memoirs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 65, 66, 1, 'Business &amp; Investing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 71, 72, 1, 'Computers &amp; Internet', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 75, 76, 1, 'Cooking, Food &amp; Wine', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 77, 78, 1, 'Entertainment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 79, 80, 1, 'Foreign Language Instruction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 81, 82, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 83, 84, 1, 'Health, Mind &amp; Body', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 87, 88, 1, 'History', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 89, 90, 1, 'Home &amp; Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 91, 92, 1, 'Horror', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 95, 96, 1, 'Literature &amp; Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 57, 58, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 67, 68, 1, 'Catalogs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 69, 70, 1, 'Children', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 93, 94, 1, 'Illustrated', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 97, 98, 1, 'Men', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 101, 102, 1, 'News', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 121, 122, 1, 'Sports', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 131, 132, 1, 'Women', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 99, 100, 1, 'Mystery &amp; Thrillers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 103, 104, 1, 'Nonfiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 105, 106, 1, 'Parenting &amp; Families', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 107, 108, 1, 'Poetry', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 109, 110, 1, 'Rare', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 111, 112, 1, 'Reference', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 115, 116, 1, 'Religion &amp; Spirituality', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 73, 74, 1, 'Contemporary', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 85, 86, 1, 'Historical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 113, 114, 1, 'Regency', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 117, 118, 1, 'Science &amp; Nature', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 119, 120, 1, 'Science Fiction &amp; Fantasy', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 123, 124, 1, 'Sports &amp; Outdoors', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 125, 126, 1, 'Teens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 127, 128, 1, 'Textbooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 28, 129, 130, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 134, 141, 0, 'Clothing &amp; Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 69, 135, 136, 1, 'Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 69, 137, 138, 1, 'Clothing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 69, 139, 140, 1, 'Watches', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 142, 147, 0, 'Coins &amp; Stamps', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 73, 143, 144, 1, 'Coins', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 73, 145, 146, 1, 'Philately', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 148, 223, 0, 'Collectibles', 1, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 149, 150, 1, 'Advertising', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 151, 152, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 153, 154, 1, 'Animation', 1, 1, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 155, 156, 1, 'Antique Reproductions', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 157, 158, 1, 'Autographs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 159, 160, 1, 'Barber Shop', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 161, 162, 1, 'Bears', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 163, 164, 1, 'Bells', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 165, 166, 1, 'Bottles &amp; Cans', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 167, 168, 1, 'Breweriana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 169, 170, 1, 'Cars &amp; Motorcycles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 171, 172, 1, 'Cereal Boxes &amp; Premiums', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 173, 174, 1, 'Character', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 175, 176, 1, 'Circus &amp; Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 177, 178, 1, 'Collector Plates', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 179, 180, 1, 'Dolls', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 181, 182, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 183, 184, 1, 'Historical &amp; Cultural', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 185, 186, 1, 'Holiday &amp; Seasonal', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 187, 188, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 189, 190, 1, 'Kitsch', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 191, 192, 1, 'Knives &amp; Swords', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 193, 194, 1, 'Lunchboxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 195, 196, 1, 'Magic &amp; Novelty Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 197, 198, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 199, 200, 1, 'Militaria', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 201, 202, 1, 'Music Boxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 203, 204, 1, 'Oddities', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 205, 206, 1, 'Paper', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 207, 208, 1, 'Pinbacks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 209, 210, 1, 'Porcelain Figurines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 211, 212, 1, 'Railroadiana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 213, 214, 1, 'Religious', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 215, 216, 1, 'Rocks, Minerals &amp; Fossils', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 217, 218, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 219, 220, 1, 'Textiles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 76, 221, 222, 1, 'Tobacciana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 224, 241, 0, 'Comics, Cards &amp; Science Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 225, 226, 1, 'Anime &amp; Manga', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 227, 228, 1, 'Comic Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 229, 230, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 231, 232, 1, 'Godzilla', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 233, 234, 1, 'Star Trek', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 235, 236, 1, 'The X-Files', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 237, 238, 1, 'Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 114, 239, 240, 1, 'Trading Cards', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 242, 251, 0, 'Computers &amp; Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 123, 243, 244, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 123, 245, 246, 1, 'Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 123, 247, 248, 1, 'Internet Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 123, 249, 250, 1, 'Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 252, 263, 0, 'Electronics &amp; Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 128, 253, 254, 1, 'Consumer Electronics', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 128, 255, 256, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 128, 257, 258, 1, 'Photo Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 128, 259, 260, 1, 'Recording Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 128, 261, 262, 1, 'Video Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 264, 283, 0, 'Home &amp; Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 265, 266, 1, 'Baby Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 267, 268, 1, 'Crafts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 269, 270, 1, 'Furniture', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 271, 272, 1, 'Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 273, 274, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 275, 276, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 277, 278, 1, 'Pet Supplies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 279, 280, 1, 'Tools &amp; Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 149, 281, 282, 1, 'Weddings', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 284, 293, 0, 'Movies &amp; Video', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 159, 285, 286, 1, 'DVD', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 159, 287, 288, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 159, 289, 290, 1, 'Laser Discs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 159, 291, 292, 1, 'VHS', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 294, 307, 0, 'Music', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 164, 295, 296, 1, 'CDs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 164, 297, 298, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 164, 299, 300, 1, 'Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 164, 301, 302, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 164, 303, 304, 1, 'Records', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 164, 305, 306, 1, 'Tapes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 308, 317, 0, 'Office &amp; Business', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 171, 309, 310, 1, 'Briefcases', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 171, 311, 312, 1, 'Fax Machines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 171, 313, 314, 1, 'General Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 171, 315, 316, 1, 'Pagers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 318, 333, 0, 'Other Goods &amp; Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 319, 320, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 321, 322, 1, 'Metaphysical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 323, 324, 1, 'Property', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 325, 326, 1, 'Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 327, 328, 1, 'Tickets &amp; Events', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 329, 330, 1, 'Transportation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 176, 331, 332, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 334, 341, 0, 'Sports &amp; Recreation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 184, 335, 336, 1, 'Apparel &amp; Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 184, 337, 338, 1, 'Exercise Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 184, 339, 340, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 0, 342, 389, 0, 'Toys &amp; Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 343, 344, 1, 'Action Figures', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 345, 346, 1, 'Beanie Babies &amp; Beanbag Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 347, 348, 1, 'Diecast', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 349, 350, 1, 'Fast Food', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 351, 352, 1, 'Fisher-Price', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 353, 354, 1, 'Furby', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 355, 356, 1, 'Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 357, 358, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 359, 360, 1, 'Giga Pet &amp; Tamagotchi', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 361, 362, 1, 'Hobbies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 363, 364, 1, 'Marbles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 365, 366, 1, 'My Little Pony', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 367, 368, 1, 'Peanuts Gang', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 369, 370, 1, 'Pez', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 371, 372, 1, 'Plastic Models', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 373, 374, 1, 'Plush Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 375, 376, 1, 'Puzzles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 377, 378, 1, 'Slot Cars', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 379, 380, 1, 'Teletubbies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 381, 382, 1, 'Toy Soldiers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 385, 386, 1, 'Vintage Tin', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 387, 388, 1, 'Vintage Vehicles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, 188, 383, 384, 1, 'Vintage', 0, 0, '', '');";
}
else
{
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(0, -1, 1, 2, -1, 'All', 0, 0, '', '');";
}

# ############################

# 
# Table structure for table `" . $DBPrefix . "closedrelisted`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "closedrelisted`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "closedrelisted` (
  `auction` int(32) default '0',
  `relistdate` varchar(8) NOT NULL default '',
  `newauction` int(32) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "closedrelisted`
# 

# Table structure for table `" . $DBPrefix . "comm_messages`

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

# Dumping data for table `" . $DBPrefix . "comm_messages`


# Table structure for table `" . $DBPrefix . "community`

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

# Dumping data for table `" . $DBPrefix . "community`

$query[] = "INSERT INTO `" . $DBPrefix . "community` VALUES (1, 'Selling', 0, '', 30, 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "community` VALUES (2, 'Buying', 0, '20050823103800', 30, 1);";

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
  `country` varchar(35) NOT NULL default '',
  PRIMARY KEY  (`country`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "countries`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Afghanistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Albania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Algeria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('American Samoa');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Andorra');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Angola');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Anguilla');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Antarctica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Antigua And Barbuda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Argentina');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Armenia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Aruba');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Australia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Austria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Azerbaijan Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bahamas');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bahrain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bangladesh');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Barbados');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Belarus');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Belgium');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Belize');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Benin');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bermuda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bhutan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bolivia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bosnia and Herzegowina');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Botswana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bouvet Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Brazil');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('British Indian Ocean Territory');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Brunei Darussalam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bulgaria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Burkina Faso');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Burma');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Burundi');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cambodia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cameroon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Canada');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cape Verde');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cayman Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Central African Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Chad');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Chile');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('China');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Christmas Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cocos &#40;Keeling&#41; Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Colombia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Comoros');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Congo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Congo, the Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cook Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Costa Rica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cote d&#39;Ivoire');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Croatia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cyprus');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Czech Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Denmark');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Djibouti');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Dominica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Dominican Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('East Timor');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ecuador');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Egypt');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('El Salvador');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Equatorial Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Eritrea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Estonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ethiopia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Falkland Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Faroe Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Fiji');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Finland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('France');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('French Guiana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('French Polynesia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('French Southern Territories');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Gabon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Gambia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Georgia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Germany');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ghana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Gibraltar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Great Britain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Greece');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Greenland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Grenada');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guadeloupe');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guatemala');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guinea-Bissau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guyana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Haiti');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Heard and Mc Donald Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Honduras');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Hong Kong');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Hungary');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Iceland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('India');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Indonesia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ireland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Israel');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Italy');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Jamaica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Japan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Jordan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kazakhstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kenya');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kiribati');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Korea &#40;South&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kuwait');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kyrgyzstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lao People&#39;s Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Latvia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lebanon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lesotho');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Liberia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Liechtenstein');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lithuania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Luxembourg');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Macau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Macedonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Madagascar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Malawi');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Malaysia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Maldives');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mali');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Malta');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Marshall Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Martinique');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mauritania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mauritius');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mayotte');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mexico');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Micronesia, Federated States of');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Moldova, Republic of');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Monaco');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mongolia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Montserrat');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Morocco');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mozambique');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Namibia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nauru');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nepal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Netherlands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Netherlands Antilles');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('New Caledonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('New Zealand');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nicaragua');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Niger');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nigeria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Niuev');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Norfolk Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Northern Mariana Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Norway');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Oman');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Pakistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Palau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Panama');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Papua New Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Paraguay');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Peru');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Philippines');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Pitcairn');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Poland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Portugal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Puerto Rico');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Qatar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Reunion');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Romania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Russian Federation');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Rwanda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saint Kitts and Nevis');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saint Lucia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saint Vincent and the Grenadin');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Samoa &#40;Independent&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('San Marino');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sao Tome and Principe');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saudi Arabia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Senegal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Seychelles');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sierra Leone');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Singapore');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Slovakia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Slovenia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Solomon Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Somalia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('South Africa');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('South Georgia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Spain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sri Lanka');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('St. Helena');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('St. Pierre and Miquelon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Suriname');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Svalbard and Jan Mayen Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Swaziland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sweden');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Switzerland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Taiwan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tajikistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tanzania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Thailand');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Togo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tokelau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tonga');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Trinidad and Tobago');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tunisia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Turkey');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Turkmenistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Turks and Caicos Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tuvalu');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Uganda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ukraine');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('United Arab Emiratesv');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('United Kingdom');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('United States');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Uruguay');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Uzbekistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Vanuatu');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Venezuela');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Viet Nam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Virgin Islands &#40;British&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Virgin Islands &#40;U.S.&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Wallis and Futuna Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Western Sahara');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Yemen');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Zambia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Zimbabwe');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "currencies`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currencies`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currencies` (
  `id` int(11) NOT NULL auto_increment,
  `currency` varchar(100) NOT NULL default '',
  KEY `id` (`id`)
) AUTO_INCREMENT=1 ;";

# 
# Dumping data for table `" . $DBPrefix . "currencies`
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
  `browser` varchar(50) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "currentbrowsers`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "currentdomains`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentdomains`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentdomains` (
  `month` char(2) NOT NULL default '0',
  `year` varchar(4) NOT NULL default '0',
  `domain` varchar(100) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "currentdomains`
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
  `days` int(11) NOT NULL default '0',
  `description` varchar(30) default NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "durations`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (1, '1 day');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (2, '2 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (3, '3 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (7, '1 week');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (14, '2 weeks');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (21, '3 weeks');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (30, '1 month');";

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
  `id` int(11) NOT NULL auto_increment,
  `lang` char(2) NOT NULL default '',
  `question` varchar(200) NOT NULL default '',
  `answer` text NOT NULL,
  KEY `id` (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "faqs_translated`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (2, 'EN', 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (2, 'ES', 'Registrarse', 'Para registrar un nuevo usuario, haz click en <B>Reg&iacute;Â­strate</B> en la parte superior de la pantalla. Se te preguntar&aacute;n tus datos personales, un nombre de usuario, una contrase&ntilde;a e informacion de contacto como la direccion e-mail.\r\n\r\n<B>�Tienes que ser mayor de edad para poder registrarte!</B>');";
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
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `fee_from` double(16, 4) NOT NULL ,
  `fee_to` double(6, 4) NOT NULL ,
  `fee_type` enum('flat', 'perc') NOT NULL,
  `value` double(8,4) NOT NULL ,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "fees`
# 

$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'signup_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'setup');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'endauction');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hpfeat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'bolditem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hlitem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'rp_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'picture_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'relist_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyout_fee');";

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
# Table structure for table `" . $DBPrefix . "fontsandcolors`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fontsandcolors`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "fontsandcolors` (
  `err_font` int(2) NOT NULL default '0',
  `err_font_size` int(2) default NULL,
  `err_font_color` varchar(7) default NULL,
  `err_font_bold` enum('y','n') default NULL,
  `err_font_italic` enum('y','n') default NULL,
  `std_font` int(2) NOT NULL default '0',
  `std_font_size` int(2) default NULL,
  `std_font_color` varchar(7) default NULL,
  `std_font_bold` enum('y','n') default NULL,
  `std_font_italic` enum('y','n') default NULL,
  `sml_font` int(2) NOT NULL default '0',
  `sml_font_size` int(2) NOT NULL default '0',
  `sml_font_color` varchar(7) NOT NULL default '',
  `sml_font_bold` enum('y','n') NOT NULL default 'y',
  `sml_font_italic` enum('y','n') NOT NULL default 'y',
  `tlt_font` int(2) NOT NULL default '0',
  `tlt_font_size` int(2) default NULL,
  `tlt_font_color` varchar(7) default NULL,
  `tlt_font_bold` enum('y','n') default NULL,
  `tlt_font_italic` enum('y','n') default NULL,
  `nav_font` int(2) NOT NULL default '0',
  `nav_font_size` int(2) NOT NULL default '0',
  `nav_font_color` varchar(7) NOT NULL default '',
  `nav_font_bold` enum('y','n') NOT NULL default 'y',
  `nav_font_italic` enum('y','n') NOT NULL default 'y',
  `footer_font` int(2) NOT NULL default '0',
  `footer_font_size` int(2) NOT NULL default '0',
  `footer_font_color` varchar(7) NOT NULL default '',
  `footer_font_bold` enum('y','n') NOT NULL default 'y',
  `footer_font_italic` enum('y','n') NOT NULL default 'y',
  `bordercolor` varchar(7) NOT NULL default '0',
  `headercolor` varchar(7) NOT NULL default '0',
  `tableheadercolor` varchar(7) NOT NULL default '0000',
  `linkscolor` varchar(7) NOT NULL default '0',
  `vlinkscolor` varchar(7) NOT NULL default '0',
  `highlighteditems` varchar(7) NOT NULL default ''
) ;";

# 
# Dumping data for table `" . $DBPrefix . "fontsandcolors`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "fontsandcolors` VALUES (1, 3, '#FF9900', 'y', 'n', 1, 2, '#000000', 'n', 'n', 1, 1, '#000000', 'n', 'n', 2, 4, '#3300CC', 'y', 'n', 1, 3, '#3366CC', 'y', 'n', 1, 1, '#aaaaaa', 'n', 'n', '3366cc', '#ffffff', '#888888', '003399', '#333333', 'd8ebff');";

# ############################

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "messages`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "messages` (
`id` int( 50 ) NOT NULL AUTO_INCREMENT ,
`sentto` int( 25 ) NOT NULL default '0',
`from` int( 25 ) NOT NULL default '0',
`when` varchar( 20 ) NOT NULL default '',
`message` text NOT NULL ,
`read` int( 1 ) NOT NULL default '0',
`subject` varchar( 50 ) NOT NULL default '',
`replied` int( 1 ) NOT NULL default '0',
`noticed` int( 1 ) NOT NULL default '0',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;";

# ############################

# 
# Table structure for table `" . $DBPrefix . "increments`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "increments`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "increments` (
  `id` char(3) default NULL,
  `low` double(16,4) default NULL,
  `high` double(16,4) default NULL,
  `increment` double(16,4) default NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "increments`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('1', 0.0000, 0.9900, 0.2800);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('2', 1.0000, 9.9900, 0.5000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('3', 10.0000, 29.9900, 1.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('4', 30.0000, 99.9900, 2.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('5', 100.0000, 249.9900, 5.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('6', 250.0000, 499.9900, 10.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES ('7', 500.0000, 999.9900, 25.0000);";

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

$query[] = "INSERT INTO `" . $DBPrefix . "maintainance` VALUES (1, 'n', 'renlok', '<br>\r\n<center>\r\n<b>Under maintainance!!!!!!!</b>\r\n</center>');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "membertypes`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "membertypes`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "membertypes` (
  `id` int(11) NOT NULL auto_increment,
  `feedbacks` int(11) NOT NULL default '0',
  `membertype` varchar(30) NOT NULL default '',
  `discount` tinyint(4) NOT NULL default '0',
  `icon` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "membertypes`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (24, 9, '', 0, 'transparent.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (22, 999999, '100000', 0, 'starFR.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (21, 99999, '50000', 0, 'starFV.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (20, 49999, '25000', 0, 'starFT.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (19, 24999, '10000', 0, 'starFY.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (23, 9999, '5000', 0, 'starG.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (17, 4999, '1000', 0, 'starR.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (16, 999, '100', 0, 'starT.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (15, 99, '50', 0, 'starB.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (14, 49, '10', 0, 'starY.gif');";

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
# Table structure for table `" . $DBPrefix . "payments`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "payments`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "payments` (
  `id` int(2) default NULL,
  `description` varchar(30) default NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "payments`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "payments` VALUES (1, 'Paypal');";
$query[] = "INSERT INTO `" . $DBPrefix . "payments` VALUES (2, 'Wire Transfer');";

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
  `bid` double(16,4) default NULL
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

$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (1, 'United States', 'U.S. Dollar', 'USD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (2, 'Argentina', 'Argentinian Peso', 'ARS');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (3, 'Australia', 'Australian Dollar ', 'AUD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (5, 'Brazil', 'Brazilian Real ', 'BRL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (6, 'Chile', 'Chilean Peso ', 'CLP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (7, 'China', 'Chinese Renminbi ', 'CNY');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (8, 'Colombia', 'Colombian Peso ', 'COP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (10, 'Czech. Republic', 'Czech. Republic Koruna ', 'CZK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (11, 'Denmark', 'Danish Krone ', 'DKK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (12, 'European Union', 'EURO', 'EUR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (13, 'Fiji', 'Fiji Dollar ', 'FJD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (16, 'Hong Kong', 'Hong Kong Dollar', 'HKD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (18, 'Iceland', 'Icelandic Krona ', 'INR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (19, 'India', 'Indian Rupee', 'INR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (20, 'Indonesia', 'Indonesian Rupiah ', 'IDR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (21, 'Israel', 'Israeli New Shekel ', 'ILS');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (22, 'Japan', 'Japanese Yen', 'JPY');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (23, 'Malaysia', 'Malaysian Ringgit', 'MYR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (24, 'Mexico', 'New Peso', 'MXN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (25, 'Morocco', 'Moroccan Dirham ', 'MAD');";
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
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (47, 'Tunisia', 'Tunisisan Dinar', 'TND');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (48, 'Turkey', 'Turkish Lira', 'TRL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (49, 'Great Britain', 'Pound Sterling ', 'GBP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (50, 'Venezuela', 'Bolivar ', 'VEB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (51, 'Bahamas', 'Bahamian Dollar', 'BSD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (52, 'Croatia', 'Croatian Kuna', 'HRK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (53, 'East Caribe', 'East Caribbean Dollar', 'XCD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (54, 'CFA Franc (African Financial Community)', 'African Financial Community Franc', 'CFA');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (55, 'Pacific Financial Community', 'Pacific Financial Community Franc', 'CFP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (56, 'Ghana', 'Ghanaian Cedi', 'GHC');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (57, 'Honduras', 'Honduras Lempira', 'HNL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (58, 'Hungaria', 'Hungarian Forint', 'HUF');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (59, 'Jamaica', 'Jamaican Dollar', 'JMD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (60, 'Burma', 'Myanmar (Burma) Kyat', 'MMK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (61, 'Neth. Antilles', 'Neth. Antilles Guilder', 'ANG');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (62, 'Trinidad & Tobago', 'Trinidad & Tobago Dollar', 'TTD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (63, 'Canadian', 'Canadian Dollar', 'CAD');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "rememberme`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "rememberme`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "rememberme` (
  `userid` int(11) NOT NULL default '0',
  `hashkey` char(32) NOT NULL default ''
) ;";

# 
# Dumping data for table `" . $DBPrefix . "rememberme`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "settings`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "settings` (
  `sitename` varchar(255) NOT NULL default '',
  `siteurl` varchar(255) NOT NULL default '',
  `copyright` varchar(255) NOT NULL default '',
  `loginbox` int(1) NOT NULL default '0',
  `newsbox` int(1) NOT NULL default '0',
  `newstoshow` int(11) NOT NULL default '0',
  `moneyformat` int(1) NOT NULL default '0',
  `moneydecimals` int(11) NOT NULL default '0',
  `moneysymbol` int(1) NOT NULL default '0',
  `currency` varchar(10) NOT NULL default '',
  `showacceptancetext` int(1) NOT NULL default '0',
  `acceptancetext` longtext NOT NULL,
  `adminmail` varchar(100) NOT NULL default '',
  `banners` int(1) NOT NULL default '0',
  `newsletter` int(1) NOT NULL default '0',
  `logo` varchar(255) NOT NULL default '',
  `timecorrection` int(3) NOT NULL default '0',
  `cron` int(1) NOT NULL default '0',
  `archiveafter` int(11) NOT NULL default '0',
  `datesformat` enum('USA','EUR') NOT NULL default 'EUR',
  `errortext` text NOT NULL,
  `errormail` varchar(255) NOT NULL default '',
  `picturesgallery` int(1) NOT NULL default '0',
  `maxpictures` int(11) NOT NULL default '0',
  `maxpicturesize` int(11) NOT NULL default '0',
  `buy_now` int(1) NOT NULL default '1',
  `alignment` varchar(15) NOT NULL default '',
  `thumb_show` smallint(6) NOT NULL default '120',
  `lastitemsnumber` int(11) NOT NULL default '0',
  `higherbidsnumber` int(11) NOT NULL default '0',
  `endingsoonnumber` int(11) NOT NULL default '0',
  `boards` enum('y','n') NOT NULL default 'y',
  `boardslink` enum('y','n') NOT NULL default 'y',
  `wordsfilter` enum('y','n') NOT NULL default 'y',
  `aboutus` enum('y','n') NOT NULL default 'y',
  `aboutustext` text NOT NULL,
  `terms` enum('y','n') NOT NULL default 'y',
  `termstext` text NOT NULL,
  `privacypolicy` enum('y','n') NOT NULL default 'y',
  `privacypolicytext` text NOT NULL,
  `defaultcountry` varchar(30) NOT NULL default '0',
  `relisting` int(11) NOT NULL default '0',
  `defaultlanguage` char(2) NOT NULL default 'EN',
  `pagewidth` int(11) NOT NULL default '0',
  `pagewidthtype` enum('perc','fix') NOT NULL default 'perc',
  `accounttype` enum('sellerbuyer','unique') NOT NULL default 'unique',
  `catsorting` enum('alpha','counter') NOT NULL default 'alpha',
  `usersauth` enum('y','n') NOT NULL default 'y',
  `background` tinytext NOT NULL,
  `brepeat` enum('repeat','repeat-x','repeat-y','no-repeat','no') NOT NULL default 'no',
  `descriptiontag` text NOT NULL,
  `keywordstag` text NOT NULL,
  `maxuploadsize` int(11) NOT NULL default '0',
  `contactseller` enum('always','logged','never') NOT NULL default 'always',
  `theme` tinytext,
  `catstoshow` int(11) NOT NULL default '0',
  `uniqueseller` int(11) NOT NULL default '0',
  `bn_only` enum('y','n') NOT NULL default 'n',
  `adultonly` enum('y','n') NOT NULL default 'n',
  `winner_address` enum('y','n') NOT NULL default 'n',
  `boardsmsgs` int(11) NOT NULL default '0',
  `activationtype` INT(1) NOT NULL DEFAULT  '0',
  `https` enum('y','n') NOT NULL default 'n',
  `bn_only_disable` enum('y','n') NOT NULL default 'n',
  `bn_only_percent` int(3) NOT NULL default '50',
  `buyerprivacy` ENUM('y','n') NOT NULL default 'n',
  `cust_increment` INT(1) NOT NULL DEFAULT '0',
  `fees` ENUM('y','n') NOT NULL default 'n',
  `ae_status` enum('enabled','disabled') NOT NULL default 'disabled',
  `ae_timebefore` int(11) NOT NULL default '120',
  `ae_extend` int(11) NOT NULL default '300',
  `cache_theme` ENUM('y','n') NOT NULL default 'y',
  `hours_countdown` int(5) NOT NULL default '24',
  `edit_starttime` int(1) NOT NULL default '1',
  `banner_sizetype` enum('fix','any') NOT NULL default 'any',
  `banner_width` int(11) NOT NULL default '468',
  `banner_height` int(11) NOT NULL default '60',
  `counter_auctions` enum('y','n') NOT NULL default 'y',
  `counter_users` enum('y','n') NOT NULL default 'y',
  `counter_online` enum('y','n') NOT NULL default 'y',
  `banemail` text NOT NULL,
  `mandatory_fields` varchar(255) NOT NULL default '',
  `displayed_feilds` VARCHAR(255) NOT NULL default ''
);";

# 
# Dumping data for table `" . $DBPrefix . "settings`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES
('WeBid', '" . $siteURL . "', '', 1, 1, 5, 1, 2, 2, 'GBP', 1, 'By clicking below you agree to the terms of this website.', '".$siteEmail."', 1, 1, 'logo.gif', 0, 2, 30, 'EUR', 'An unexpected error occurred. Please report to the administrator at ', '".$siteEmail."', 1, 5, 100, 2, 'center', 120, 8, 8, 0, 'y', 'n', 'y', 'y', '', 'y', '', 'y', '', 'United Kingdom', 0, 'EN', 90, 'perc', 'unique', 'alpha', 'y', '', 'no', '', '', 51200, 'always', 'default', 20, 0, 'n', 'n', 'y', 0, 0, 'n', 'n', 50, 'n', 1, 'n', 'disabled', 120, 300, 'y', 24, 1, 'any', 468, 60, 'y', 'y', 'y', '', 'a:7:{s:9:\"birthdate\";s:1:\"y\";s:7:\"address\";s:1:\"y\";s:4:\"city\";s:1:\"y\";s:4:\"prov\";s:1:\"y\";s:7:\"country\";s:1:\"y\";s:3:\"zip\";s:1:\"y\";s:3:\"tel\";s:1:\"y\";}', 'a:7:{s:17:\"birthdate_regshow\";s:1:\"1\";s:15:\"address_regshow\";s:1:\"1\";s:12:\"city_regshow\";s:1:\"1\";s:12:\"prov_regshow\";s:1:\"1\";s:15:\"country_regshow\";s:1:\"1\";s:11:\"zip_regshow\";s:1:\"1\";s:11:\"tel_regshow\";s:1:\"1\";}');";


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

$query[] = "INSERT INTO `" . $DBPrefix . "statssettings` VALUES ('n', 'y', 'y', 'y');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "users`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "users`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "users` (
  `id` int(32) NOT NULL auto_increment,
  `nick` varchar(20) default NULL,
  `password` varchar(32) default NULL,
  `hash` varchar(5) default NULL,
  `name` tinytext,
  `address` tinytext,
  `city` varchar(25) default NULL,
  `prov` varchar(10) default NULL,
  `country` varchar(30) default NULL,
  `zip` varchar(10) default NULL,
  `phone` varchar(40) default NULL,
  `email` varchar(50) default NULL,
  `reg_date` int(15) default NULL,
  `rate_sum` int(11) default NULL,
  `rate_num` int(11) default NULL,
  `birthdate` int(8) default NULL,
  `suspended` int(1) default '0',
  `nletter` int(1) NOT NULL default '0',
  `balance` double NOT NULL default '0',
  `auc_watch` varchar(20) default '',
  `item_watch` text,
  `accounttype` enum('seller','buyer','buyertoseller','unique') NOT NULL default 'unique',
  `endemailmode` enum('one','cum','none') NOT NULL default 'one',
  `startemailmode` enum('yes','no') NOT NULL default 'yes',
  `emailtype` enum('html','text') NOT NULL default 'text',
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `payment_details` text,
  `bn_only` enum('y','n') NOT NULL default 'y',
  `timecorrection` int(3) NOT NULL default '0',
  `paypal_email` varchar(255) default NULL,
  `language` char(2) NOT NULL default '',
  PRIMARY KEY  (`id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "users`
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
  `bid` double NOT NULL default '0',
  `closingdate` int(15) NOT NULL default '0',
  `fee` double NOT NULL default '0',
  `feedback_win` tinyint(1) NOT NULL default '0',
  `feedback_sel` tinyint(1) NOT NULL default '0',
  `qty` int(11) NOT NULL default '1',
  KEY `id` (`id`)
) ;";

?>