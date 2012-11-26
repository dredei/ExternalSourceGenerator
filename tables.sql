CREATE TABLE IF NOT EXISTS  `ext_external_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_dup` (`page`)
) ENGINE=MyISAM AUTO_INCREMENT=383 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `ext_external_referers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `pages` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=289 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `ext_external_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auto_gen_time` int(10) unsigned NOT NULL,
  `auto_last_gen` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `ext_external_ua` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned NOT NULL,
  `browser_name` varchar(30) NOT NULL,
  `browser_version` varchar(50) NOT NULL,
  `os` varchar(10) NOT NULL,
  `ua` text NOT NULL,
  `pages` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=284 DEFAULT CHARSET=utf8;