CREATE TABLE IF NOT EXISTS  `ext_external_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(255) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_dup` (`page`)
) ENGINE=MyISAM AUTO_INCREMENT=747 DEFAULT CHARSET=utf8;

CREATE TABLE  IF NOT EXISTS `ext_external_referers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `pages` text,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=530 DEFAULT CHARSET=utf8;

CREATE TABLE  IF NOT EXISTS `ext_external_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auto_gen_time` int(10) unsigned DEFAULT NULL,
  `auto_last_gen` datetime DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE  IF NOT EXISTS `ext_external_ua` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned DEFAULT NULL,
  `browser_name` varchar(30) DEFAULT NULL,
  `browser_version` varchar(50) DEFAULT NULL,
  `os` varchar(10) DEFAULT NULL,
  `ua` text,
  `pages` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=434 DEFAULT CHARSET=utf8;