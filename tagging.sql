--
-- Table structure for table `tag_name`
--

CREATE TABLE IF NOT EXISTS `tag_name` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Table structure for table `tag_join`
--

CREATE TABLE IF NOT EXISTS `tag_join` (
  `id` int(8) NOT NULL auto_increment,
  `tag_id` int(8) NOT NULL,
  `table` varchar(255) collate utf8_unicode_ci NOT NULL,
  `table_id` int(8) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

