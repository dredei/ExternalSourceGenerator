<?php
require_once 'config.php';

$db = new db_e;

$tables[] = "DROP TABLE IF EXISTS `".$config['db_prefix']."external_pages`";
$tables[] = "CREATE TABLE IF NOT EXISTS  `".$config['db_prefix']."external_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(255) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_dup` (`page`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

$tables[] = "DROP TABLE IF EXISTS `".$config['db_prefix']."external_referers`";
$tables[] = "CREATE TABLE  IF NOT EXISTS `".$config['db_prefix']."external_referers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `pages` text,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

$tables[] = "DROP TABLE IF EXISTS `".$config['db_prefix']."external_settings`";
$tables[] = "CREATE TABLE  IF NOT EXISTS `".$config['db_prefix']."external_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auto_gen_time` int(10) unsigned DEFAULT '24',
  `auto_last_gen` datetime DEFAULT NULL,
  `pathsCount` int(10) unsigned DEFAULT '3',
  `depthsRange` varchar(45) DEFAULT '{\"Min\": 2, \"Max\": 6}',
  `password` varchar(50) DEFAULT '21232f297a57a5a743894a0e4a801fc3',
  `token` varchar(50) DEFAULT 'lol',
  `exMasks` text,
  `scriptVersion` float DEFAULT '102.04',
  `archivation` enum('yes','no') DEFAULT 'no',
  `blackRefs` text,
  `dataPeriod` varchar(45) DEFAULT 'all',
  `whiteRefs` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

$tables[] = "DROP TABLE IF EXISTS `".$config['db_prefix']."external_ua`";
$tables[] = "CREATE TABLE  IF NOT EXISTS `".$config['db_prefix']."external_ua` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned DEFAULT NULL,
  `browser_name` varchar(30) DEFAULT NULL,
  `browser_version` varchar(50) DEFAULT NULL,
  `os` varchar(10) DEFAULT NULL,
  `ua` text,
  `pages` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
print( 'Начинаем создание таблиц...<br />' );

$i = 1;
foreach ($tables as $table) {
	$db->ExecQuery( $table );
	print( 'Шаг '.$i.'/'.count( $tables ).'<br />' );
	$i++;
}

print( 'Таблицы успешно созданы! <br />Установка завершена!<br>' );
print( '<b><font color="red">Удалите файлы update.php и install.php !!!</font></b>' );
?>