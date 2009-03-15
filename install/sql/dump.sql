-- --------------------------------------------------------

--
-- Table structure for table `webid_accesseshistoric`
--

CREATE TABLE IF NOT EXISTS `webid_accesseshistoric` (
  `month` char(2) NOT NULL DEFAULT '',
  `year` char(4) NOT NULL DEFAULT '',
  `pageviews` int(11) NOT NULL DEFAULT '0',
  `uniquevisitiors` int(11) NOT NULL DEFAULT '0',
  `usersessions` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_accesseshistoric`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_adminusers`
--

CREATE TABLE IF NOT EXISTS `webid_adminusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `created` varchar(8) NOT NULL DEFAULT '',
  `lastlogin` varchar(14) NOT NULL DEFAULT '',
  `status` int(2) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `webid_adminusers`
--

INSERT INTO `webid_adminusers` (`id`, `username`, `password`, `created`, `lastlogin`, `status`) VALUES
(10, 'admin', '60b1edc96b37319708b92c85324f5f37', '20011224', '20090115005553', 1);

-- --------------------------------------------------------

--
-- Table structure for table `webid_altpayments`
--

CREATE TABLE IF NOT EXISTS `webid_altpayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `webid_altpayments`
--

INSERT INTO `webid_altpayments` (`id`, `title`, `description`) VALUES
(2, 'Bank Transfer', 'Test Bank\r<BR>123 Worthwood Road\r<BR>Miami USA'),
(3, 'Money Order', 'TEst text for\r\nMoney order');

-- --------------------------------------------------------

--
-- Table structure for table `webid_auccounter`
--

CREATE TABLE IF NOT EXISTS `webid_auccounter` (
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_auccounter`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_auctionextension`
--

CREATE TABLE IF NOT EXISTS `webid_auctionextension` (
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `timebefore` int(11) NOT NULL DEFAULT '0',
  `extend` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_auctionextension`
--

INSERT INTO `webid_auctionextension` (`status`, `timebefore`, `extend`) VALUES
('disabled', 120, 300);

-- --------------------------------------------------------

--
-- Table structure for table `webid_auctions`
--

CREATE TABLE IF NOT EXISTS `webid_auctions` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `user` int(32) DEFAULT NULL,
  `title` tinytext,
  `starts` varchar(14) DEFAULT NULL,
  `description` text,
  `pict_url` tinytext,
  `category` int(11) DEFAULT NULL,
  `minimum_bid` double(16,4) DEFAULT '0.0000',
  `shipping_cost` double(16,4) DEFAULT NULL,
  `reserve_price` double(16,4) DEFAULT NULL,
  `buy_now` double(16,4) DEFAULT NULL,
  `auction_type` char(1) DEFAULT NULL,
  `duration` varchar(7) DEFAULT NULL,
  `increment` double(8,4) NOT NULL DEFAULT '0.0000',
  `shipping` char(1) DEFAULT NULL,
  `payment` tinytext,
  `international` char(1) DEFAULT NULL,
  `ends` varchar(14) DEFAULT NULL,
  `current_bid` double(16,4) DEFAULT NULL,
  `closed` char(2) DEFAULT NULL,
  `photo_uploaded` tinyint(1) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `suspended` int(1) DEFAULT '0',
  `private` enum('y','n') NOT NULL DEFAULT 'n',
  `relist` int(11) NOT NULL DEFAULT '0',
  `relisted` int(11) NOT NULL DEFAULT '0',
  `num_bids` int(11) NOT NULL DEFAULT '0',
  `sold` enum('y','n','s') NOT NULL DEFAULT 'n',
  `shipping_terms` tinytext NOT NULL,
  `bn_only` enum('y','n') NOT NULL DEFAULT 'n',
  `adultonly` enum('y','n') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_auctions`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_banners`
--

CREATE TABLE IF NOT EXISTS `webid_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('gif','jpg','png','swf') DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sponsortext` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `purchased` int(11) NOT NULL DEFAULT '0',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_banners`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_bannerscategories`
--

CREATE TABLE IF NOT EXISTS `webid_bannerscategories` (
  `banner` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_bannerscategories`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_bannerskeywords`
--

CREATE TABLE IF NOT EXISTS `webid_bannerskeywords` (
  `banner` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_bannerskeywords`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_bannerssettings`
--

CREATE TABLE IF NOT EXISTS `webid_bannerssettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sizetype` enum('fix','any') DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `webid_bannerssettings`
--

INSERT INTO `webid_bannerssettings` (`id`, `sizetype`, `width`, `height`) VALUES
(1, 'any', 468, 60);

-- --------------------------------------------------------

--
-- Table structure for table `webid_bannersstats`
--

CREATE TABLE IF NOT EXISTS `webid_bannersstats` (
  `banner` int(11) DEFAULT NULL,
  `purchased` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  KEY `id` (`banner`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_bannersstats`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_bannersusers`
--

CREATE TABLE IF NOT EXISTS `webid_bannersusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_bannersusers`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_bidfind`
--

CREATE TABLE IF NOT EXISTS `webid_bidfind` (
  `bidfind` enum('enabled','disabled') NOT NULL DEFAULT 'enabled'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_bidfind`
--

INSERT INTO `webid_bidfind` (`bidfind`) VALUES
('disabled');

-- --------------------------------------------------------

--
-- Table structure for table `webid_bids`
--

CREATE TABLE IF NOT EXISTS `webid_bids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction` int(32) DEFAULT NULL,
  `bidder` int(32) DEFAULT NULL,
  `bid` double(16,4) DEFAULT NULL,
  `bidwhen` varchar(14) DEFAULT NULL,
  `quantity` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_bids`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_browsers`
--

CREATE TABLE IF NOT EXISTS `webid_browsers` (
  `month` char(2) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `browser` varchar(50) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_browsers`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_categories`
--

CREATE TABLE IF NOT EXISTS `webid_categories` (
  `cat_id` int(4) NOT NULL AUTO_INCREMENT,
  `parent_id` int(4) DEFAULT NULL,
  `cat_name` tinytext,
  `deleted` int(1) DEFAULT NULL,
  `sub_counter` int(11) DEFAULT NULL,
  `counter` int(11) DEFAULT NULL,
  `cat_colour` tinytext NOT NULL,
  `cat_image` tinytext NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=212 ;

--
-- Dumping data for table `webid_categories`
--

INSERT INTO `webid_categories` (`cat_id`, `parent_id`, `cat_name`, `deleted`, `sub_counter`, `counter`, `cat_colour`, `cat_image`) VALUES
(1, 0, 'Art &amp; Antiques', 0, 0, 0, '', ''),
(2, 1, 'Ancient World', 0, 0, 0, '', ''),
(3, 1, 'Amateur Art', 0, 0, 0, '', ''),
(4, 1, 'Ceramics &amp; Glass', 0, 0, 0, '', ''),
(5, 4, 'Glass', 0, 0, 0, '', ''),
(6, 5, '40s, 50s &amp; 60s', 0, 0, 0, '', ''),
(7, 5, 'Art Glass', 0, 0, 0, '', ''),
(8, 5, 'Carnival', 0, 0, 0, '', ''),
(9, 5, 'Contemporary Glass', 0, 0, 0, '', ''),
(10, 5, 'Porcelain', 0, 0, 0, '', ''),
(11, 5, 'Chalkware', 0, 0, 0, '', ''),
(12, 5, 'Chintz &amp; Shelley', 0, 0, 0, '', ''),
(13, 5, 'Decorative', 0, 0, 0, '', ''),
(14, 1, 'Fine Art', 0, 0, 0, '', ''),
(15, 1, 'General', 0, 0, 0, '', ''),
(16, 1, 'Painting', 0, 0, 0, '', ''),
(17, 1, 'Photographic Images', 0, 0, 0, '', ''),
(18, 1, 'Prints', 0, 0, 0, '', ''),
(19, 1, 'Books &amp; Manuscripts', 0, 0, 0, '', ''),
(20, 1, 'Cameras', 0, 0, 0, '', ''),
(21, 1, 'Musical Instruments', 0, 0, 0, '', ''),
(22, 1, 'Orientalia', 0, 0, 0, '', ''),
(23, 1, 'Post-1900', 0, 0, 0, '', ''),
(24, 1, 'Pre-1900', 0, 0, 0, '', ''),
(25, 1, 'Scientific Instruments', 0, 0, 0, '', ''),
(26, 1, 'Silver &amp; Silver Plate', 0, 0, 0, '', ''),
(27, 1, 'Textiles &amp; Linens', 0, 0, 0, '', ''),
(28, 0, 'Books', 0, 0, 0, '', ''),
(29, 28, 'Arts, Architecture &amp; Photography', 0, 0, 0, '', ''),
(30, 28, 'Audiobooks', 0, 0, 0, '', ''),
(31, 28, 'Biographies &amp; Memoirs', 0, 0, 0, '', ''),
(32, 28, 'Business &amp; Investing', 0, 0, 0, '', ''),
(34, 28, 'Computers &amp; Internet', 0, 0, 0, '', ''),
(35, 28, 'Cooking, Food &amp; Wine', 0, 0, 0, '', ''),
(36, 28, 'Entertainment', 0, 0, 0, '', ''),
(37, 28, 'Foreign Language Instruction', 0, 0, 0, '', ''),
(38, 28, 'General', 0, 0, 0, '', ''),
(39, 28, 'Health, Mind &amp; Body', 0, 0, 0, '', ''),
(40, 28, 'History', 0, 0, 0, '', ''),
(41, 28, 'Home &amp; Garden', 0, 0, 0, '', ''),
(42, 28, 'Horror', 0, 0, 0, '', ''),
(43, 28, 'Literature &amp; Fiction', 0, 0, 0, '', ''),
(44, 28, 'Animals', 0, 0, 0, '', ''),
(45, 28, 'Catalogs', 0, 0, 0, '', ''),
(46, 28, 'Children', 0, 0, 0, '', ''),
(47, 28, 'Illustrated', 0, 0, 0, '', ''),
(48, 28, 'Men', 0, 0, 0, '', ''),
(49, 28, 'News', 0, 0, 0, '', ''),
(51, 28, 'Sports', 0, 0, 0, '', ''),
(52, 28, 'Women', 0, 0, 0, '', ''),
(53, 28, 'Mystery &amp; Thrillers', 0, 0, 0, '', ''),
(54, 28, 'Nonfiction', 0, 0, 0, '', ''),
(55, 28, 'Parenting &amp; Families', 0, 0, 0, '', ''),
(56, 28, 'Poetry', 0, 0, 0, '', ''),
(57, 28, 'Rare', 0, 0, 0, '', ''),
(58, 28, 'Reference', 0, 0, 0, '', ''),
(59, 28, 'Religion &amp; Spirituality', 0, 0, 0, '', ''),
(60, 28, 'Contemporary', 0, 0, 0, '', ''),
(61, 28, 'Historical', 0, 0, 0, '', ''),
(62, 28, 'Regency', 0, 0, 0, '', ''),
(63, 28, 'Science &amp; Nature', 0, 0, 0, '', ''),
(64, 28, 'Science Fiction &amp; Fantasy', 0, 0, 0, '', ''),
(65, 28, 'Sports &amp; Outdoors', 0, 0, 0, '', ''),
(66, 28, 'Teens', 0, 0, 0, '', ''),
(67, 28, 'Textbooks', 0, 0, 0, '', ''),
(68, 28, 'Travel', 0, 0, 0, '', ''),
(69, 0, 'Clothing &amp; Accessories', 0, 0, 0, '', ''),
(70, 69, 'Accessories', 0, 0, 0, '', ''),
(71, 69, 'Clothing', 0, 0, 0, '', ''),
(72, 69, 'Watches', 0, 0, 0, '', ''),
(73, 0, 'Coins &amp; Stamps', 0, 1, 0, '', ''),
(74, 73, 'Coins', 0, 0, 0, '', ''),
(75, 73, 'Philately', 0, 1, 1, '', ''),
(76, 0, 'Collectibles', 0, 0, 0, '', ''),
(77, 76, 'Advertising', 0, 0, 0, '', ''),
(78, 76, 'Animals', 0, 0, 0, '', ''),
(79, 76, 'Animation', 0, 0, 0, '', ''),
(80, 76, 'Antique Reproductions', 0, 0, 0, '', ''),
(81, 76, 'Autographs', 0, 0, 0, '', ''),
(82, 76, 'Barber Shop', 0, 0, 0, '', ''),
(83, 76, 'Bears', 0, 0, 0, '', ''),
(84, 76, 'Bells', 0, 0, 0, '', ''),
(85, 76, 'Bottles &amp; Cans', 0, 0, 0, '', ''),
(86, 76, 'Breweriana', 0, 0, 0, '', ''),
(87, 76, 'Cars &amp; Motorcycles', 0, 0, 0, '', ''),
(88, 76, 'Cereal Boxes &amp; Premiums', 0, 0, 0, '', ''),
(89, 76, 'Character', 0, 0, 0, '', ''),
(90, 76, 'Circus &amp; Carnival', 0, 0, 0, '', ''),
(91, 76, 'Collector Plates', 0, 0, 0, '', ''),
(92, 76, 'Dolls', 0, 0, 0, '', ''),
(93, 76, 'General', 0, 0, 0, '', ''),
(94, 76, 'Historical &amp; Cultural', 0, 0, 0, '', ''),
(95, 76, 'Holiday &amp; Seasonal', 0, 0, 0, '', ''),
(96, 76, 'Household Items', 0, 0, 0, '', ''),
(97, 76, 'Kitsch', 0, 0, 0, '', ''),
(98, 76, 'Knives &amp; Swords', 0, 0, 0, '', ''),
(99, 76, 'Lunchboxes', 0, 0, 0, '', ''),
(100, 76, 'Magic &amp; Novelty Items', 0, 0, 0, '', ''),
(101, 76, 'Memorabilia', 0, 0, 0, '', ''),
(102, 76, 'Militaria', 0, 0, 0, '', ''),
(103, 76, 'Music Boxes', 0, 0, 0, '', ''),
(104, 76, 'Oddities', 0, 0, 0, '', ''),
(105, 76, 'Paper', 0, 0, 0, '', ''),
(106, 76, 'Pinbacks', 0, 0, 0, '', ''),
(107, 76, 'Porcelain Figurines', 0, 0, 0, '', ''),
(108, 76, 'Railroadiana', 0, 0, 0, '', ''),
(109, 76, 'Religious', 0, 0, 0, '', ''),
(110, 76, 'Rocks, Minerals &amp; Fossils', 0, 0, 0, '', ''),
(111, 76, 'Scientific Instruments', 0, 0, 0, '', ''),
(112, 76, 'Textiles', 0, 0, 0, '', ''),
(113, 76, 'Tobacciana', 0, 0, 0, '', ''),
(114, 0, 'Comics, Cards &amp; Science Fiction', 0, 0, 0, '', ''),
(115, 114, 'Anime &amp; Manga', 0, 0, 0, '', ''),
(116, 114, 'Comic Books', 0, 0, 0, '', ''),
(117, 114, 'General', 0, 0, 0, '', ''),
(118, 114, 'Godzilla', 0, 0, 0, '', ''),
(119, 114, 'Star Trek', 0, 0, 0, '', ''),
(120, 114, 'The X-Files', 0, 0, 0, '', ''),
(121, 114, 'Toys', 0, 0, 0, '', ''),
(122, 114, 'Trading Cards', 0, 0, 0, '', ''),
(123, 0, 'Computers &amp; Software', 0, 0, 0, '', ''),
(124, 123, 'General', 0, 0, 0, '', ''),
(125, 123, 'Hardware', 0, 0, 0, '', ''),
(126, 123, 'Internet Services', 0, 0, 0, '', ''),
(127, 123, 'Software', 0, 0, 0, '', ''),
(128, 0, 'Electronics &amp; Photography', 0, 0, 0, '', ''),
(129, 128, 'Consumer Electronics', 0, 0, 0, '', ''),
(130, 128, 'General', 0, 0, 0, '', ''),
(131, 128, 'Photo Equipment', 0, 0, 0, '', ''),
(132, 128, 'Recording Equipment', 0, 0, 0, '', ''),
(133, 128, 'Video Equipment', 0, 0, 0, '', ''),
(135, 134, 'Ancient', 0, 0, 0, '', ''),
(136, 134, 'Beaded Jewelry', 0, 0, 0, '', ''),
(137, 134, 'Beads', 0, 0, 0, '', ''),
(138, 134, 'Carved &amp; Cameo', 0, 0, 0, '', ''),
(139, 134, 'Contemporary', 0, 0, 0, '', ''),
(140, 134, 'Costume', 0, 0, 0, '', ''),
(141, 134, 'Fine', 0, 0, 0, '', ''),
(142, 134, 'Gemstones', 0, 0, 0, '', ''),
(143, 134, 'General', 0, 0, 0, '', ''),
(144, 134, 'Gold', 0, 0, 0, '', ''),
(145, 134, 'Necklaces', 0, 0, 0, '', ''),
(146, 134, 'Silver', 0, 0, 0, '', ''),
(147, 134, 'Victorian', 0, 0, 0, '', ''),
(148, 134, 'Vintage', 0, 0, 0, '', ''),
(149, 0, 'Home &amp; Garden', 0, 0, 0, '', ''),
(150, 149, 'Baby Items', 0, 0, 0, '', ''),
(151, 149, 'Crafts', 0, 0, 0, '', ''),
(152, 149, 'Furniture', 0, 0, 0, '', ''),
(153, 149, 'Garden', 0, 0, 0, '', ''),
(154, 149, 'General', 0, 0, 0, '', ''),
(155, 149, 'Household Items', 0, 0, 0, '', ''),
(156, 149, 'Pet Supplies', 0, 0, 0, '', ''),
(157, 149, 'Tools &amp; Hardware', 0, 0, 0, '', ''),
(158, 149, 'Weddings', 0, 0, 0, '', ''),
(159, 0, 'Movies &amp; Video', 0, 0, 0, '', ''),
(160, 159, 'DVD', 0, 0, 0, '', ''),
(161, 159, 'General', 0, 0, 0, '', ''),
(162, 159, 'Laser Discs', 0, 0, 0, '', ''),
(163, 159, 'VHS', 0, 0, 0, '', ''),
(164, 0, 'Music', 0, 0, 0, '', ''),
(165, 164, 'CDs', 0, 0, 0, '', ''),
(166, 164, 'General', 0, 0, 0, '', ''),
(167, 164, 'Instruments', 0, 0, 0, '', ''),
(168, 164, 'Memorabilia', 0, 0, 0, '', ''),
(169, 164, 'Records', 0, 0, 0, '', ''),
(170, 164, 'Tapes', 0, 0, 0, '', ''),
(171, 0, 'Office &amp; Business', 0, 0, 0, '', ''),
(172, 171, 'Briefcases', 0, 0, 0, '', ''),
(173, 171, 'Fax Machines', 0, 0, 0, '', ''),
(174, 171, 'General Equipment', 0, 0, 0, '', ''),
(175, 171, 'Pagers', 0, 0, 0, '', ''),
(176, 0, 'Other Goods &amp; Services', 0, 0, 0, '', ''),
(177, 176, 'General', 0, 0, 0, '', ''),
(178, 176, 'Metaphysical', 0, 0, 0, '', ''),
(179, 176, 'Property', 0, 0, 0, '', ''),
(180, 176, 'Services', 0, 0, 0, '', ''),
(181, 176, 'Tickets &amp; Events', 0, 0, 0, '', ''),
(182, 176, 'Transportation', 0, 0, 0, '', ''),
(183, 176, 'Travel', 0, 0, 0, '', ''),
(184, 0, 'Sports &amp; Recreation', 0, 0, 0, '', ''),
(185, 184, 'Apparel &amp; Equipment', 0, 0, 0, '', ''),
(186, 184, 'Exercise Equipment', 0, 0, 0, '', ''),
(187, 184, 'General', 0, 0, 0, '', ''),
(188, 0, 'Toys &amp; Games', 0, 0, 0, '', ''),
(189, 188, 'Action Figures', 0, 0, 0, '', ''),
(190, 188, 'Beanie Babies &amp; Beanbag Toys', 0, 0, 0, '', ''),
(191, 188, 'Diecast', 0, 0, 0, '', ''),
(192, 188, 'Fast Food', 0, 0, 0, '', ''),
(193, 188, 'Fisher-Price', 0, 0, 0, '', ''),
(194, 188, 'Furby', 0, 0, 0, '', ''),
(195, 188, 'Games', 0, 0, 0, '', ''),
(196, 188, 'General', 0, 0, 0, '', ''),
(197, 188, 'Giga Pet &amp; Tamagotchi', 0, 0, 0, '', ''),
(198, 188, 'Hobbies', 0, 0, 0, '', ''),
(199, 188, 'Marbles', 0, 0, 0, '', ''),
(200, 188, 'My Little Pony', 0, 0, 0, '', ''),
(201, 188, 'Peanuts Gang', 0, 0, 0, '', ''),
(202, 188, 'Pez', 0, 0, 0, '', ''),
(203, 188, 'Plastic Models', 0, 0, 0, '', ''),
(204, 188, 'Plush Toys', 0, 0, 0, '', ''),
(205, 188, 'Puzzles', 0, 0, 0, '', ''),
(206, 188, 'Slot Cars', 0, 0, 0, '', ''),
(207, 188, 'Teletubbies', 0, 0, 0, '', ''),
(208, 188, 'Toy Soldiers', 0, 0, 0, '', ''),
(209, 188, 'Vintage Tin', 0, 0, 0, '', ''),
(210, 188, 'Vintage Vehicles', 0, 0, 0, '', ''),
(211, 188, 'Vintage', 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `webid_closedrelisted`
--

CREATE TABLE IF NOT EXISTS `webid_closedrelisted` (
  `auction` int(32) DEFAULT '0',
  `relistdate` varchar(8) NOT NULL DEFAULT '',
  `newauction` int(32) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_closedrelisted`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_community`
--

CREATE TABLE IF NOT EXISTS `webid_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `messages` int(11) NOT NULL DEFAULT '0',
  `lastmessage` varchar(14) NOT NULL DEFAULT '0',
  `msgstoshow` int(11) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  KEY `msg_id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `webid_community`
--

INSERT INTO `webid_community` (`id`, `name`, `messages`, `lastmessage`, `msgstoshow`, `active`) VALUES
(1, 'Selling', 0, '', 30, 1),
(2, 'Buying', 0, '20050823103800', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `webid_comm_messages`
--

CREATE TABLE IF NOT EXISTS `webid_comm_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boardid` int(11) NOT NULL DEFAULT '0',
  `msgdate` varchar(14) NOT NULL DEFAULT '',
  `user` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  KEY `msg_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_comm_messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_counters`
--

CREATE TABLE IF NOT EXISTS `webid_counters` (
  `users` int(11) DEFAULT '0',
  `auctions` int(11) DEFAULT '0',
  `closedauctions` int(11) NOT NULL DEFAULT '0',
  `inactiveusers` int(11) NOT NULL DEFAULT '0',
  `bids` int(11) NOT NULL DEFAULT '0',
  `transactions` int(11) NOT NULL DEFAULT '0',
  `totalamount` double NOT NULL DEFAULT '0',
  `resetdate` varchar(8) NOT NULL DEFAULT '',
  `fees` double NOT NULL DEFAULT '0',
  `suspendedauction` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_counters`
--

INSERT INTO `webid_counters` (`users`, `auctions`, `closedauctions`, `inactiveusers`, `bids`, `transactions`, `totalamount`, `resetdate`, `fees`, `suspendedauction`) VALUES
(0, 0, 0, 0, 0, 0, 0, '20070101', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `webid_counterstoshow`
--

CREATE TABLE IF NOT EXISTS `webid_counterstoshow` (
  `auctions` enum('y','n') NOT NULL DEFAULT 'y',
  `users` enum('y','n') NOT NULL DEFAULT 'y',
  `online` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_counterstoshow`
--

INSERT INTO `webid_counterstoshow` (`auctions`, `users`, `online`) VALUES
('y', 'y', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `webid_countries`
--

CREATE TABLE IF NOT EXISTS `webid_countries` (
  `country` varchar(35) NOT NULL DEFAULT '',
  PRIMARY KEY (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_countries`
--

INSERT INTO `webid_countries` (`country`) VALUES
('Afghanistan'),
('Albania'),
('Algeria'),
('American Samoa'),
('Andorra'),
('Angola'),
('Anguilla'),
('Antarctica'),
('Antigua And Barbuda'),
('Argentina'),
('Armenia'),
('Aruba'),
('Australia'),
('Austria'),
('Azerbaijan Republic'),
('Bahamas'),
('Bahrain'),
('Bangladesh'),
('Barbados'),
('Belarus'),
('Belgium'),
('Belize'),
('Benin'),
('Bermuda'),
('Bhutan'),
('Bolivia'),
('Bosnia and Herzegowina'),
('Botswana'),
('Bouvet Island'),
('Brazil'),
('British Indian Ocean Territory'),
('Brunei Darussalam'),
('Bulgaria'),
('Burkina Faso'),
('Burma'),
('Burundi'),
('Cambodia'),
('Cameroon'),
('Canada'),
('Cape Verde'),
('Cayman Islands'),
('Central African Republic'),
('Chad'),
('Chile'),
('China'),
('Christmas Island'),
('Cocos &#40;Keeling&#41; Islands'),
('Colombia'),
('Comoros'),
('Congo'),
('Congo, the Democratic Republic'),
('Cook Islands'),
('Costa Rica'),
('Cote d&#39;Ivoire'),
('Croatia'),
('Cyprus'),
('Czech Republic'),
('Denmark'),
('Djibouti'),
('Dominica'),
('Dominican Republic'),
('East Timor'),
('Ecuador'),
('Egypt'),
('El Salvador'),
('Equatorial Guinea'),
('Eritrea'),
('Estonia'),
('Ethiopia'),
('Falkland Islands'),
('Faroe Islands'),
('Fiji'),
('Finland'),
('France'),
('French Polynesia'),
('French Southern Territories'),
('Gabon'),
('Gambia'),
('Georgia'),
('Germany'),
('Ghana'),
('Gibraltar'),
('Great Britain'),
('Greece'),
('Greenland'),
('Grenada'),
('Guadeloupe'),
('Guam'),
('Guatemala'),
('Guinea'),
('Guinea-Bissau'),
('Guyana'),
('Haiti'),
('Heard and Mc Donald Islands'),
('Honduras'),
('Hong Kong'),
('Hungary'),
('Iceland'),
('India'),
('Indonesia'),
('Ireland'),
('Israel'),
('Italy'),
('Jamaica'),
('Japan'),
('Jordan'),
('Kazakhstan'),
('Kenya'),
('Kiribati'),
('Korea &#40;South&#41;'),
('Kuwait'),
('Kyrgyzstan'),
('Lao People&#39;s Democratic Republi'),
('Latvia'),
('Lebanon'),
('Lesotho'),
('Liberia'),
('Liechtenstein'),
('Lithuania'),
('Luxembourg'),
('Macau'),
('Macedonia'),
('Madagascar'),
('Malawi'),
('Malaysia'),
('Maldives'),
('Mali'),
('Malta'),
('Marshall Islands'),
('Martinique'),
('Mauritania'),
('Mauritius'),
('Mayotte'),
('Mexico'),
('Micronesia, Federated States of'),
('Moldova, Republic of'),
('Monaco'),
('Mongolia'),
('Montserrat'),
('Morocco'),
('Mozambique'),
('Namibia'),
('Nauru'),
('Nepal'),
('Netherlands'),
('Netherlands Antilles'),
('New Caledonia'),
('New Zealand'),
('Nicaragua'),
('Niger'),
('Nigeria'),
('Niuev'),
('Norfolk Island'),
('Northern Mariana Islands'),
('Norway'),
('Oman'),
('Pakistan'),
('Palau'),
('Panama'),
('Papua New Guinea'),
('Paraguay'),
('Peru'),
('Philippines'),
('Pitcairn'),
('Poland'),
('Portugal'),
('Puerto Rico'),
('Qatar'),
('Reunion'),
('Romania'),
('Russian Federation'),
('Rwanda'),
('Saint Kitts and Nevis'),
('Saint Lucia'),
('Saint Vincent and the Grenadin'),
('Samoa &#40;Independent&#41;'),
('San Marino'),
('Sao Tome and Principe'),
('Saudi Arabia'),
('Senegal'),
('Seychelles'),
('Sierra Leone'),
('Singapore'),
('Slovakia'),
('Slovenia'),
('Solomon Islands'),
('Somalia'),
('South Africa'),
('South Georgia'),
('Spain'),
('Sri Lanka'),
('St. Helena'),
('St. Pierre and Miquelon'),
('Suriname'),
('Svalbard and Jan Mayen Islands'),
('Swaziland'),
('Sweden'),
('Switzerland'),
('Taiwan'),
('Tajikistan'),
('Tanzania'),
('Thailand'),
('Togo'),
('Tokelau'),
('Tonga'),
('Trinidad and Tobago'),
('Tunisia'),
('Turkey'),
('Turkmenistan'),
('Turks and Caicos Islands'),
('Tuvalu'),
('Uganda'),
('Ukraine'),
('United Arab Emiratesv'),
('United Kingdom'),
('United States'),
('Uruguay'),
('Uzbekistan'),
('Vanuatu'),
('Venezuela'),
('Viet Nam'),
('Virgin Islands &#40;British&#41;'),
('Virgin Islands &#40;U.S.&#41;'),
('Wallis and Futuna Islands'),
('Western Sahara'),
('Yemen'),
('Zambia'),
('Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `webid_currencies`
--

CREATE TABLE IF NOT EXISTS `webid_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(100) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_currencies`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_currentaccesses`
--

CREATE TABLE IF NOT EXISTS `webid_currentaccesses` (
  `day` char(2) NOT NULL DEFAULT '',
  `month` char(2) NOT NULL DEFAULT '',
  `year` char(4) NOT NULL DEFAULT '',
  `pageviews` int(11) NOT NULL DEFAULT '0',
  `uniquevisitors` int(11) NOT NULL DEFAULT '0',
  `usersessions` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_currentaccesses`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_currentbrowsers`
--

CREATE TABLE IF NOT EXISTS `webid_currentbrowsers` (
  `month` char(2) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `browser` varchar(50) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_currentbrowsers`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_currentdomains`
--

CREATE TABLE IF NOT EXISTS `webid_currentdomains` (
  `month` char(2) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `domain` varchar(100) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_currentdomains`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_currentplatforms`
--

CREATE TABLE IF NOT EXISTS `webid_currentplatforms` (
  `month` char(2) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `platform` varchar(50) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_currentplatforms`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_durations`
--

CREATE TABLE IF NOT EXISTS `webid_durations` (
  `days` int(11) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_durations`
--

INSERT INTO `webid_durations` (`days`, `description`) VALUES
(2, '2 days'),
(3, '3 days'),
(7, '1 week'),
(14, '2 weeks'),
(21, '3 weeks'),
(30, '1 month');

-- --------------------------------------------------------

--
-- Table structure for table `webid_faqs`
--

CREATE TABLE IF NOT EXISTS `webid_faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL DEFAULT '',
  `answer` text NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `webid_faqs`
--

INSERT INTO `webid_faqs` (`id`, `question`, `answer`, `category`) VALUES
(2, 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!', 1),
(4, 'Item Watch', '<b>Item watch</b> notifies you when someone bids on the auctions that you have added to your Item Watch. ', 3),
(5, 'What is a Dutch auction?', 'Dutch auction is a type of auction where the auctioneer begins with a high asking price which is lowered until some participant is willing to accept the auctioneer''s price. The winning participant pays the last announced price.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `webid_faqscategories`
--

CREATE TABLE IF NOT EXISTS `webid_faqscategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `webid_faqscategories`
--

INSERT INTO `webid_faqscategories` (`id`, `category`) VALUES
(1, 'General'),
(2, 'Selling'),
(3, 'Buying');

-- --------------------------------------------------------

--
-- Table structure for table `webid_faqscat_translated`
--

CREATE TABLE IF NOT EXISTS `webid_faqscat_translated` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lang` char(2) NOT NULL DEFAULT '',
  `category` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_faqscat_translated`
--

INSERT INTO `webid_faqscat_translated` (`id`, `lang`, `category`) VALUES
(3, 'EN', 'Buying'),
(3, 'ES', 'Comprar'),
(1, 'EN', 'General'),
(1, 'ES', 'General'),
(2, 'EN', 'Selling'),
(2, 'ES', 'Vender');

-- --------------------------------------------------------

--
-- Table structure for table `webid_faqs_translated`
--

CREATE TABLE IF NOT EXISTS `webid_faqs_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` char(2) NOT NULL DEFAULT '',
  `question` varchar(200) NOT NULL DEFAULT '',
  `answer` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `webid_faqs_translated`
--

INSERT INTO `webid_faqs_translated` (`id`, `lang`, `question`, `answer`) VALUES
(2, 'EN', 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!'),
(2, 'ES', 'Registrarse', 'Para registrar un nuevo usuario, haz click en <B>Reg&iacute;Â­strate</B> en la parte superior de la pantalla. Se te preguntar&aacute;n tus datos personales, un nombre de usuario, una contrase&ntilde;a e informacion de contacto como la direccion e-mail.\r\n\r\n<B>�Tienes que ser mayor de edad para poder registrarte!</B>'),
(4, 'EN', 'Item Watch', '<b>Item watch</b> notifies you when someone bids on the auctions that you have added to your Item Watch. '),
(4, 'ES', 'En la Mira', '<i><b>En la Mira</b></i> te env&iacute;a una notificacion por e-mail, cada vez que alguien puja en una de las subastas que has a&ntilde;adido a tu lista <i>En la Mira</i>. '),
(6, 'ES', 'Auction Watch', '<i><B>Auction Watch</b></i> es tu asistente para saber cuando se abre una subasta cuya descripcion contiene palabras clave de tu interes.\r\n\r\nPara usar esta opcion inserta las palabras clave en las que est&aacute;s interesado en la lista de <i>Auction Watch</i>. Todas las palabras claves deben estar separadas por un espacio. Cuando estas palabras claves aparezcan en alg&uacute;n t&iacute;tulo o descripcion de subasta, recibir&aacute;s un e-mail con la informacion de que una subasta que contiene tus palabras claves ha sido creada. Tambi&aacute;n puedas agregar el nombre del usuario como palabra clave. ');

-- --------------------------------------------------------

--
-- Table structure for table `webid_feedbacks`
--

CREATE TABLE IF NOT EXISTS `webid_feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rated_user_id` int(32) DEFAULT NULL,
  `rater_user_nick` varchar(20) DEFAULT NULL,
  `feedback` mediumtext,
  `rate` int(2) DEFAULT NULL,
  `feedbackdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `auction_id` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_feedbacks`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_feedforum`
--

CREATE TABLE IF NOT EXISTS `webid_feedforum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `seqnum` int(11) NOT NULL DEFAULT '0',
  `commentdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_feedforum`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_filterwords`
--

CREATE TABLE IF NOT EXISTS `webid_filterwords` (
  `word` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_filterwords`
--

INSERT INTO `webid_filterwords` (`word`) VALUES
('');

-- --------------------------------------------------------

--
-- Table structure for table `webid_fontsandcolors`
--

CREATE TABLE IF NOT EXISTS `webid_fontsandcolors` (
  `err_font` int(2) NOT NULL DEFAULT '0',
  `err_font_size` int(2) DEFAULT NULL,
  `err_font_color` varchar(7) DEFAULT NULL,
  `err_font_bold` enum('y','n') DEFAULT NULL,
  `err_font_italic` enum('y','n') DEFAULT NULL,
  `std_font` int(2) NOT NULL DEFAULT '0',
  `std_font_size` int(2) DEFAULT NULL,
  `std_font_color` varchar(7) DEFAULT NULL,
  `std_font_bold` enum('y','n') DEFAULT NULL,
  `std_font_italic` enum('y','n') DEFAULT NULL,
  `sml_font` int(2) NOT NULL DEFAULT '0',
  `sml_font_size` int(2) NOT NULL DEFAULT '0',
  `sml_font_color` varchar(7) NOT NULL DEFAULT '',
  `sml_font_bold` enum('y','n') NOT NULL DEFAULT 'y',
  `sml_font_italic` enum('y','n') NOT NULL DEFAULT 'y',
  `tlt_font` int(2) NOT NULL DEFAULT '0',
  `tlt_font_size` int(2) DEFAULT NULL,
  `tlt_font_color` varchar(7) DEFAULT NULL,
  `tlt_font_bold` enum('y','n') DEFAULT NULL,
  `tlt_font_italic` enum('y','n') DEFAULT NULL,
  `nav_font` int(2) NOT NULL DEFAULT '0',
  `nav_font_size` int(2) NOT NULL DEFAULT '0',
  `nav_font_color` varchar(7) NOT NULL DEFAULT '',
  `nav_font_bold` enum('y','n') NOT NULL DEFAULT 'y',
  `nav_font_italic` enum('y','n') NOT NULL DEFAULT 'y',
  `footer_font` int(2) NOT NULL DEFAULT '0',
  `footer_font_size` int(2) NOT NULL DEFAULT '0',
  `footer_font_color` varchar(7) NOT NULL DEFAULT '',
  `footer_font_bold` enum('y','n') NOT NULL DEFAULT 'y',
  `footer_font_italic` enum('y','n') NOT NULL DEFAULT 'y',
  `bordercolor` varchar(7) NOT NULL DEFAULT '0',
  `headercolor` varchar(7) NOT NULL DEFAULT '0',
  `tableheadercolor` varchar(7) NOT NULL DEFAULT '0000',
  `linkscolor` varchar(7) NOT NULL DEFAULT '0',
  `vlinkscolor` varchar(7) NOT NULL DEFAULT '0',
  `highlighteditems` varchar(7) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_fontsandcolors`
--

INSERT INTO `webid_fontsandcolors` (`err_font`, `err_font_size`, `err_font_color`, `err_font_bold`, `err_font_italic`, `std_font`, `std_font_size`, `std_font_color`, `std_font_bold`, `std_font_italic`, `sml_font`, `sml_font_size`, `sml_font_color`, `sml_font_bold`, `sml_font_italic`, `tlt_font`, `tlt_font_size`, `tlt_font_color`, `tlt_font_bold`, `tlt_font_italic`, `nav_font`, `nav_font_size`, `nav_font_color`, `nav_font_bold`, `nav_font_italic`, `footer_font`, `footer_font_size`, `footer_font_color`, `footer_font_bold`, `footer_font_italic`, `bordercolor`, `headercolor`, `tableheadercolor`, `linkscolor`, `vlinkscolor`, `highlighteditems`) VALUES
(1, 3, '#FF9900', 'y', 'n', 1, 2, '#000000', 'n', 'n', 1, 1, '#000000', 'n', 'n', 2, 4, '#3300CC', 'y', 'n', 1, 3, '#3366CC', 'y', 'n', 1, 1, '#aaaaaa', 'n', 'n', '3366cc', '#ffffff', '#888888', '003399', '#333333', 'd8ebff');

-- --------------------------------------------------------

--
-- Table structure for table `webid_freecategories`
--

CREATE TABLE IF NOT EXISTS `webid_freecategories` (
  `category` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_freecategories`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_increments`
--

CREATE TABLE IF NOT EXISTS `webid_increments` (
  `id` char(3) DEFAULT NULL,
  `low` double(16,4) DEFAULT NULL,
  `high` double(16,4) DEFAULT NULL,
  `increment` double(16,4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_increments`
--

INSERT INTO `webid_increments` (`id`, `low`, `high`, `increment`) VALUES
('1', 0.0000, 0.9900, 0.2800),
('2', 1.0000, 9.9900, 0.5000),
('3', 10.0000, 29.9900, 1.0000),
('4', 30.0000, 99.9900, 2.0000),
('5', 100.0000, 249.9900, 5.0000),
('6', 250.0000, 499.9900, 10.0000),
('7', 500.0000, 999.9900, 25.0000);

-- --------------------------------------------------------

--
-- Table structure for table `webid_lastupdate`
--

CREATE TABLE IF NOT EXISTS `webid_lastupdate` (
  `last_update` datetime DEFAULT NULL,
  `updateinterval` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_lastupdate`
--

INSERT INTO `webid_lastupdate` (`last_update`, `updateinterval`) VALUES
('2004-06-11 17:40:10', 100);

-- --------------------------------------------------------

--
-- Table structure for table `webid_maintainance`
--

CREATE TABLE IF NOT EXISTS `webid_maintainance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` enum('y','n') DEFAULT NULL,
  `superuser` varchar(32) DEFAULT NULL,
  `maintainancetext` text,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `webid_maintainance`
--

INSERT INTO `webid_maintainance` (`id`, `active`, `superuser`, `maintainancetext`) VALUES
(1, 'n', 'renlok', '<br>\r\n<center>\r\n<b>Under maintainance!!!!!!!</b>\r\n</center>');

-- --------------------------------------------------------

--
-- Table structure for table `webid_membertypes`
--

CREATE TABLE IF NOT EXISTS `webid_membertypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedbacks` int(11) NOT NULL DEFAULT '0',
  `membertype` varchar(30) NOT NULL DEFAULT '',
  `discount` tinyint(4) NOT NULL DEFAULT '0',
  `icon` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `webid_membertypes`
--

INSERT INTO `webid_membertypes` (`id`, `feedbacks`, `membertype`, `discount`, `icon`) VALUES
(24, 9, '', 0, 'transparent.gif'),
(22, 999999, '100000', 0, 'starFR.gif'),
(21, 99999, '50000', 0, 'starFV.gif'),
(20, 49999, '25000', 0, 'starFT.gif'),
(19, 24999, '10000', 0, 'starFY.gif'),
(23, 9999, '5000', 0, 'starG.gif'),
(17, 4999, '1000', 0, 'starR.gif'),
(16, 999, '100', 0, 'starT.gif'),
(15, 99, '50', 0, 'starB.gif'),
(14, 49, '10', 0, 'starY.gif');

-- --------------------------------------------------------

--
-- Table structure for table `webid_messages`
--

CREATE TABLE IF NOT EXISTS `webid_messages` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `sentto` int(25) NOT NULL DEFAULT '0',
  `from` int(25) NOT NULL DEFAULT '0',
  `when` varchar(20) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `subject` varchar(50) NOT NULL DEFAULT '',
  `replied` int(1) NOT NULL DEFAULT '0',
  `noticed` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_news`
--

CREATE TABLE IF NOT EXISTS `webid_news` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `new_date` int(8) NOT NULL DEFAULT '0',
  `suspended` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_news`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_news_translated`
--

CREATE TABLE IF NOT EXISTS `webid_news_translated` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lang` char(2) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_news_translated`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_online`
--

CREATE TABLE IF NOT EXISTS `webid_online` (
  `ID` bigint(21) NOT NULL AUTO_INCREMENT,
  `SESSION` varchar(255) NOT NULL DEFAULT '',
  `time` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_online`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_payments`
--

CREATE TABLE IF NOT EXISTS `webid_payments` (
  `id` int(2) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_payments`
--

INSERT INTO `webid_payments` (`id`, `description`) VALUES
(1, 'Paypal'),
(2, 'Wire Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `webid_pendingnotif`
--

CREATE TABLE IF NOT EXISTS `webid_pendingnotif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `seller_id` int(11) NOT NULL DEFAULT '0',
  `winners` text NOT NULL,
  `auction` text NOT NULL,
  `seller` text NOT NULL,
  `thisdate` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_pendingnotif`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_platforms`
--

CREATE TABLE IF NOT EXISTS `webid_platforms` (
  `month` char(2) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `browser` varchar(50) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_platforms`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_proxybid`
--

CREATE TABLE IF NOT EXISTS `webid_proxybid` (
  `itemid` int(32) DEFAULT NULL,
  `userid` int(32) DEFAULT NULL,
  `bid` double(16,4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_proxybid`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_rates`
--

CREATE TABLE IF NOT EXISTS `webid_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` tinytext NOT NULL,
  `valuta` tinytext NOT NULL,
  `rate` float(8,2) NOT NULL DEFAULT '0.00',
  `sifra` tinytext NOT NULL,
  `symbol` char(3) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `webid_rates`
--

INSERT INTO `webid_rates` (`id`, `ime`, `valuta`, `rate`, `sifra`, `symbol`) VALUES
(1, 'United States', 'U.S. Dollar', 1.00, 'U.S. Dollar ', 'USD'),
(2, 'Argentina', 'Argentinian Peso', 2.97, 'Argentine Peso ', 'ARS'),
(3, 'Australia', 'Australian Dollar ', 1.45, 'Australian Dollar ', 'AUD'),
(5, 'Brazil', 'Brazilian Real ', 3.15, 'Brazilian Real ', 'BRL'),
(6, 'Chile', 'Chilean Peso ', 649.86, 'Chilean Peso ', 'CLP'),
(7, 'China', 'Chinese Renminbi ', 8.28, 'Chinese Renminbi ', 'CNY'),
(8, 'Colombia', 'Colombian Peso ', 2734.87, 'Colombian Peso ', 'COP'),
(10, 'Czech. Republic', 'Czech. Republic Koruna ', 26.17, 'Czech. Republic Koruna ', 'CZK'),
(11, 'Denmark', 'Danish Krone ', 6.19, 'Danish Krone ', 'DKK'),
(12, 'European Union', 'EURO', 0.83, 'European Monetary Union EURO', 'EUR'),
(13, 'Fiji', 'Fiji Dollar ', 1.78, 'Fiji Dollar ', 'FJD'),
(16, 'Hong Kong', 'Hong Kong Dollar', 7.80, 'Hong Kong Dollar ', 'HKD'),
(18, 'Iceland', 'Icelandic Krona ', 72.47, 'Icelandic Krona ', 'INR'),
(19, 'India', 'Indian Rupee', 45.07, 'Indian Rupee ', 'INR'),
(20, 'Indonesia', 'Indonesian Rupiah ', 9411.72, 'Indonesian Rupiah ', 'IDR'),
(21, 'Israel', 'Israeli New Shekel ', 4.53, 'Israeli New Shekel ', 'ILS'),
(22, 'Japan', 'Japanese Yen', 110.08, 'Japanese Yen ', 'JPY'),
(23, 'Malaysia', 'Malaysian Ringgit ', 3.80, 'Malaysian Ringgit ', 'MYR'),
(24, 'Mexico', 'New Peso', 10.81, 'Mexican New Peso ', 'MXN'),
(25, 'Morocco', 'Moroccan Dirham ', 9.11, 'Moroccan Dirham ', 'MAD'),
(28, 'New Zealand', 'New Zealand Dollar', 1.59, 'New Zealand Dollar ', 'NZD'),
(29, 'Norway', 'Norwege Krone', 6.92, 'Norwegian Krone ', 'NOK'),
(30, 'Pakistan', 'Pakistan Rupee ', 57.83, 'Pakistan Rupee ', 'PKR'),
(31, 'Panama', 'Panamanian Balboa ', 1.00, 'Panamanian Balboa ', 'PAB'),
(32, 'Peru', 'Peruvian New Sol', 3.48, 'Peruvian New Sol ', 'PEN'),
(33, 'Philippine', 'Philippine Peso ', 55.79, 'Philippine Peso ', 'PHP'),
(34, 'Poland', 'Polish Zloty', 3.82, 'Polish Zloty ', 'PLN'),
(35, 'Russian', 'Russian Rouble', 29.02, 'Russian Rouble ', 'RUR'),
(36, 'Singapore', 'Singapore Dollar ', 1.72, 'Singapore Dollar ', 'SGD'),
(37, 'Slovakia', 'Koruna', 33.16, 'Slovak Koruna ', 'SKK'),
(38, 'Slovenia', 'Slovenian Tolar', 198.94, 'Slovenian Tolar ', 'SIT'),
(39, 'South Africa', 'South African Rand', 6.51, 'South African Rand ', 'ZAR'),
(40, 'South Korea', 'South Korean Won', 1164.42, 'South Korean Won ', 'KRW'),
(41, 'Sri Lanka', 'Sri Lanka Rupee ', 99.98, 'Sri Lanka Rupee ', 'LKR'),
(42, 'Sweden', 'Swedish Krona', 7.62, 'Swedish Krona ', 'SEK'),
(43, 'Switzerland', 'Swiss Franc', 1.26, 'Swiss Franc ', 'CHF'),
(44, 'Taiwan', 'Taiwanese New Dollar ', 33.46, 'Taiwanese New Dollar ', 'TWD'),
(45, 'Thailand', 'Thailand Thai Baht ', 40.69, 'Thai Baht ', 'THB'),
(47, 'Tunisia', 'Tunisisan Dinar', 1.27, 'Tunisian Dinar ', 'TND'),
(48, 'Turkey', 'Turkish Lira', 150.05, 'Turkish Lira (2) ', 'TRL'),
(49, 'Great Britain', 'Pound Sterling ', 0.57, 'Pound Sterling ', 'GBP'),
(50, 'Venezuela', 'Bolivar ', 1916.71, 'Venezuelan Bolivar ', 'VEB'),
(51, 'Bahamas', 'Bahamian Dollar', 1.00, 'Bahamian Dollar', 'BSD'),
(52, 'Croatia', 'Croatian Kuna', 6.16, 'Croatian Kuna', 'HRK'),
(53, 'East Caribe', 'East Caribbean Dollar', 0.00, 'East Caribbean Dollar', 'XCD'),
(54, 'CFA Franc (African Financial Community)', 'African Financial Community Franc', 0.00, 'African Financial Community Franc', 'CFA'),
(55, 'Pacific Financial Community', 'Pacific Financial Community Franc', 0.00, 'Pacific Financial Community', 'CFP'),
(56, 'Ghana', 'Ghanaian Cedi', 8978.29, 'Ghanaian Cedi', 'GHC'),
(57, 'Honduras', 'Honduras Lempira', 0.00, 'Honduras Lempira', 'HNL'),
(58, 'Hungaria', 'Hungarian Forint', 210.83, 'Hungarian Forint', 'HUF'),
(59, 'Jamaica', 'Jamaican Dollar', 60.52, 'Jamaican Dollar', 'JMD'),
(60, 'Burma', 'Myanmar (Burma) Kyat', 5.82, 'Myanmar (Burma) Kyat', 'MMK'),
(61, 'Neth. Antilles', 'Neth. Antilles Guilder', 1.78, 'Neth. Antilles Guilder', 'ANG'),
(62, 'Trinidad & Tobago', 'Trinidad & Tobago Dollar', 6.15, 'Trinidad & Tobago Dollar', 'TTD'),
(63, 'Canadian', 'Canadian Dollar', 1.31, 'Canadian Dollar', 'CAD');

-- --------------------------------------------------------

--
-- Table structure for table `webid_rememberme`
--

CREATE TABLE IF NOT EXISTS `webid_rememberme` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `hashkey` char(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_rememberme`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_settings`
--

CREATE TABLE IF NOT EXISTS `webid_settings` (
  `sitename` varchar(255) NOT NULL DEFAULT '',
  `siteurl` varchar(255) NOT NULL DEFAULT '',
  `cookiesprefix` varchar(100) NOT NULL DEFAULT '',
  `loginbox` int(1) NOT NULL DEFAULT '0',
  `newsbox` int(1) NOT NULL DEFAULT '0',
  `newstoshow` int(11) NOT NULL DEFAULT '0',
  `moneyformat` int(1) NOT NULL DEFAULT '0',
  `moneydecimals` int(11) NOT NULL DEFAULT '0',
  `moneysymbol` int(1) NOT NULL DEFAULT '0',
  `currency` varchar(10) NOT NULL DEFAULT '',
  `showacceptancetext` int(1) NOT NULL DEFAULT '0',
  `acceptancetext` longtext NOT NULL,
  `adminmail` varchar(100) NOT NULL DEFAULT '',
  `banners` int(1) NOT NULL DEFAULT '0',
  `newsletter` int(1) NOT NULL DEFAULT '0',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `timecorrection` int(11) NOT NULL DEFAULT '0',
  `cron` int(1) NOT NULL DEFAULT '0',
  `archiveafter` int(11) NOT NULL DEFAULT '0',
  `datesformat` enum('USA','EUR') NOT NULL DEFAULT 'EUR',
  `feetype` enum('prepay','pay') NOT NULL DEFAULT 'prepay',
  `sellersetupfee` int(1) NOT NULL DEFAULT '0',
  `sellersetuptype` int(11) NOT NULL DEFAULT '0',
  `sellerfinalfee` int(11) NOT NULL DEFAULT '0',
  `sellerfinaltype` tinyint(4) NOT NULL DEFAULT '0',
  `sellersetupvalue` double NOT NULL DEFAULT '0',
  `sellerfinalvalue` double NOT NULL DEFAULT '0',
  `buyerfinalfee` int(11) NOT NULL DEFAULT '0',
  `buyerfinaltype` int(11) NOT NULL DEFAULT '0',
  `buyerfinalvalue` double NOT NULL DEFAULT '0',
  `paypaladdress` varchar(255) NOT NULL DEFAULT '',
  `errortext` text NOT NULL,
  `errormail` varchar(255) NOT NULL DEFAULT '',
  `picturesgallery` int(1) NOT NULL DEFAULT '0',
  `maxpictures` int(11) NOT NULL DEFAULT '0',
  `maxpicturesize` int(11) NOT NULL DEFAULT '0',
  `picturesgalleryfee` int(11) NOT NULL DEFAULT '0',
  `picturesgalleryvalue` double NOT NULL DEFAULT '0',
  `buy_now` int(1) NOT NULL DEFAULT '1',
  `alignment` varchar(15) NOT NULL DEFAULT '',
  `featureditemsnumber` int(11) NOT NULL DEFAULT '0',
  `featuredcolumns` int(11) NOT NULL DEFAULT '2',
  `thimbnailswidth` int(11) NOT NULL DEFAULT '0',
  `thumb_show` smallint(6) NOT NULL DEFAULT '100',
  `catfeatureditemsnumber` int(11) NOT NULL DEFAULT '0',
  `catthumbnailswidth` int(11) NOT NULL DEFAULT '0',
  `lastitemsnumber` int(11) NOT NULL DEFAULT '0',
  `higherbidsnumber` int(11) NOT NULL DEFAULT '0',
  `endingsoonnumber` int(11) NOT NULL DEFAULT '0',
  `boards` enum('y','n') NOT NULL DEFAULT 'y',
  `boardslink` enum('y','n') NOT NULL DEFAULT 'y',
  `wordsfilter` enum('y','n') NOT NULL DEFAULT 'y',
  `aboutus` enum('y','n') NOT NULL DEFAULT 'y',
  `aboutustext` text NOT NULL,
  `terms` enum('y','n') NOT NULL DEFAULT 'y',
  `termstext` text NOT NULL,
  `defaultcountry` varchar(30) NOT NULL DEFAULT '0',
  `reservefee` int(1) NOT NULL DEFAULT '0',
  `reservetype` int(1) NOT NULL DEFAULT '0',
  `reservevalue` double NOT NULL DEFAULT '0',
  `relisting` int(11) NOT NULL DEFAULT '0',
  `defaultlanguage` char(2) NOT NULL DEFAULT 'EN',
  `pagewidth` int(11) NOT NULL DEFAULT '0',
  `pagewidthtype` enum('perc','fix') NOT NULL DEFAULT 'perc',
  `freecatstext` varchar(255) NOT NULL DEFAULT '',
  `accounttype` enum('sellerbuyer','unique') NOT NULL DEFAULT 'unique',
  `catsorting` enum('alpha','counter') NOT NULL DEFAULT 'alpha',
  `usersauth` enum('y','n') NOT NULL DEFAULT 'y',
  `background` tinytext NOT NULL,
  `brepeat` enum('repeat','repeat-x','repeat-y','no-repeat','no') NOT NULL DEFAULT 'no',
  `descriptiontag` text NOT NULL,
  `keywordstag` text NOT NULL,
  `maxuploadsize` int(11) NOT NULL DEFAULT '0',
  `contactseller` enum('always','logged','never') NOT NULL DEFAULT 'always',
  `theme` tinytext,
  `catstoshow` int(11) NOT NULL DEFAULT '0',
  `sitemap` enum('y','n') NOT NULL DEFAULT 'y',
  `uniqueseller` int(11) NOT NULL DEFAULT '0',
  `bn_only` enum('y','n') NOT NULL DEFAULT 'n',
  `adultonly` enum('y','n') NOT NULL DEFAULT 'n',
  `winner_address` enum('y','n') NOT NULL DEFAULT 'n',
  `wanted` enum('y','n') NOT NULL DEFAULT 'y',
  `boardsmsgs` int(11) NOT NULL DEFAULT '0',
  `activationtype` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_settings`
--

INSERT INTO `webid_settings` (`sitename`, `siteurl`, `cookiesprefix`, `loginbox`, `newsbox`, `newstoshow`, `moneyformat`, `moneydecimals`, `moneysymbol`, `currency`, `showacceptancetext`, `acceptancetext`, `adminmail`, `banners`, `newsletter`, `logo`, `timecorrection`, `cron`, `archiveafter`, `datesformat`, `feetype`, `sellersetupfee`, `sellersetuptype`, `sellerfinalfee`, `sellerfinaltype`, `sellersetupvalue`, `sellerfinalvalue`, `buyerfinalfee`, `buyerfinaltype`, `buyerfinalvalue`, `paypaladdress`, `errortext`, `errormail`, `picturesgallery`, `maxpictures`, `maxpicturesize`, `picturesgalleryfee`, `picturesgalleryvalue`, `buy_now`, `alignment`, `featureditemsnumber`, `featuredcolumns`, `thimbnailswidth`, `thumb_show`, `catfeatureditemsnumber`, `catthumbnailswidth`, `lastitemsnumber`, `higherbidsnumber`, `endingsoonnumber`, `boards`, `boardslink`, `wordsfilter`, `aboutus`, `aboutustext`, `terms`, `termstext`, `defaultcountry`, `reservefee`, `reservetype`, `reservevalue`, `relisting`, `defaultlanguage`, `pagewidth`, `pagewidthtype`, `freecatstext`, `accounttype`, `catsorting`, `usersauth`, `background`, `brepeat`, `descriptiontag`, `keywordstag`, `maxuploadsize`, `contactseller`, `theme`, `catstoshow`, `sitemap`, `uniqueseller`, `bn_only`, `adultonly`, `winner_address`, `wanted`, `boardsmsgs`, `activationtype`) VALUES
('WeBid', 'http://localhost/WeBid2/', 'WEBID', 1, 1, 5, 1, 2, 2, 'GBP', 1, 'By clicking below you agree to the terms of this website.', 'hopher10@googlemail.com', 1, 1, 'logo.gif', 0, 2, 30, 'EUR', 'pay', 2, 0, 2, 0, 0, 0, 2, 0, 0, 'hopher10@googlemail.com', 'An unexpected error occurred. Please report to the administrator at ', 'hopher10@googlemail.com', 1, 5, 100, 2, 1, 2, 'center', 5, 2, 100, 100, 0, 8, 8, 8, 0, 'y', 'n', 'y', 'y', 'y', 'y', 'n', 'United Kingdom', 2, 1, 0, 0, 'EN', 90, 'perc', 'unique', 'unique', 'alpha', 'y', '', 'no', '', '', 51200, 'always', 'default', 20, 'y', 0, 'n', 'n', 'y', 'y', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `webid_statssettings`
--

CREATE TABLE IF NOT EXISTS `webid_statssettings` (
  `activate` enum('y','n') NOT NULL DEFAULT 'y',
  `accesses` enum('y','n') NOT NULL DEFAULT 'y',
  `browsers` enum('y','n') NOT NULL DEFAULT 'y',
  `domains` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_statssettings`
--

INSERT INTO `webid_statssettings` (`activate`, `accesses`, `browsers`, `domains`) VALUES
('n', 'y', 'y', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `webid_tmp_closed_edited`
--

CREATE TABLE IF NOT EXISTS `webid_tmp_closed_edited` (
  `session` varchar(100) NOT NULL DEFAULT '',
  `auction` int(32) NOT NULL DEFAULT '0',
  `editdate` varchar(8) NOT NULL DEFAULT '',
  `seller` int(32) NOT NULL DEFAULT '0',
  `fee` enum('homefeatured','catfeatured','bold','highlighted','reserve') NOT NULL DEFAULT 'homefeatured',
  `amount` double NOT NULL DEFAULT '0',
  KEY `session` (`session`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_tmp_closed_edited`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_users`
--

CREATE TABLE IF NOT EXISTS `webid_users` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `name` tinytext,
  `address` tinytext,
  `city` varchar(25) DEFAULT NULL,
  `prov` varchar(10) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rate_sum` int(11) DEFAULT NULL,
  `rate_num` int(11) DEFAULT NULL,
  `birthdate` int(8) DEFAULT NULL,
  `suspended` int(1) DEFAULT '0',
  `nletter` int(1) NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `auc_watch` varchar(20) DEFAULT '',
  `item_watch` text,
  `accounttype` enum('seller','buyer','buyertoseller','unique') NOT NULL DEFAULT 'unique',
  `endemailmode` enum('one','cum','none') NOT NULL DEFAULT 'one',
  `startemailmode` enum('yes','no') NOT NULL DEFAULT 'yes',
  `trusted` enum('y','n') NOT NULL DEFAULT 'n',
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_details` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_usersettings`
--

CREATE TABLE IF NOT EXISTS `webid_usersettings` (
  `discount` double NOT NULL DEFAULT '0',
  `banemail` text NOT NULL,
  `mandatory_fields` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_usersettings`
--

INSERT INTO `webid_usersettings` (`discount`, `banemail`, `mandatory_fields`) VALUES
(0, '', 'a:6:{s:9:"birthdate";s:1:"y";s:7:"address";s:1:"y";s:4:"city";s:1:"y";s:4:"prov";s:1:"y";s:3:"zip";s:1:"y";s:3:"tel";s:1:"y";}');

-- --------------------------------------------------------

--
-- Table structure for table `webid_usersips`
--

CREATE TABLE IF NOT EXISTS `webid_usersips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(32) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `type` enum('first','after') NOT NULL DEFAULT 'first',
  `action` enum('accept','deny') NOT NULL DEFAULT 'accept',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_usersips`
--


-- --------------------------------------------------------

--
-- Table structure for table `webid_userslanguage`
--

CREATE TABLE IF NOT EXISTS `webid_userslanguage` (
  `user` int(32) NOT NULL DEFAULT '0',
  `language` char(2) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webid_userslanguage`
--

INSERT INTO `webid_userslanguage` (`user`, `language`) VALUES
(1, 'EN');

-- --------------------------------------------------------

--
-- Table structure for table `webid_winners`
--

CREATE TABLE IF NOT EXISTS `webid_winners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction` int(32) NOT NULL DEFAULT '0',
  `seller` int(32) NOT NULL DEFAULT '0',
  `winner` int(32) NOT NULL DEFAULT '0',
  `bid` double NOT NULL DEFAULT '0',
  `closingdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fee` double NOT NULL DEFAULT '0',
  `feedback_win` tinyint(1) NOT NULL DEFAULT '0',
  `feedback_sel` tinyint(1) NOT NULL DEFAULT '0',
  `qty` int(11) NOT NULL DEFAULT '1',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `webid_winners`
--

