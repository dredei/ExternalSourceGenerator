<?php
require_once 'config.php';
require_once 'classes/version.class.php';
$db = new db_e;
$version = new version;

function update( $oldVersion ) {
	global $config;
	$tables = array();
	switch ( $oldVersion ) {
		case '102.00':
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ADD COLUMN `exMasks` text";
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ADD COLUMN `scriptVersion` float";
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ALTER COLUMN `scriptVersion` SET DEFAULT '102.01'";
			$tables[] = "UPDATE ".$config['db_prefix']."external_settings SET scriptVersion = 102.01";
			$tables2 = update( 102.01 );
			$tables = array_merge( $tables, $tables2 );
			break;
		case '102.01':
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ADD COLUMN `archivation` ENUM('yes','no')";
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ADD COLUMN `blackRefs` text";
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ALTER COLUMN `archivation` SET DEFAULT 'no'";
			$tables[] = "UPDATE ".$config['db_prefix']."external_settings SET archivation = 'no'";
			$tables[] = "UPDATE ".$config['db_prefix']."external_settings SET scriptVersion = 102.02";
			$tables2 = update( 102.02 );
			$tables = array_merge( $tables, $tables2 );
			break;
		case '102.02':
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ADD COLUMN `dataPeriod` varchar(45)";
			$tables[] = "ALTER TABLE ".$config['db_prefix']."external_settings ALTER COLUMN `dataPeriod` SET DEFAULT 'all'";
			$tables[] = "UPDATE ".$config['db_prefix']."external_settings SET dataPeriod = 'all'";
			$tables[] = "UPDATE ".$config['db_prefix']."external_settings SET scriptVersion = 102.03";
			/*$tables2 = update( 102.03 );
			$tables = array_merge( $tables, $tables2 );*/
			break;
	}
	return $tables;
}

if ( isset($_GET['oldVersion']) ) {
	$oldVersion = $_GET['oldVersion'];	
} else {
	$oldVersion = $version->getVersion();
}
$tables = update( $oldVersion );
print( 'Начинаем обновление БД...<br />' );
for ( $i = 0; $i < count( $tables ); $i++ ) {
	$db->ExecQuery( $tables[$i] );
	print( ($i + 1).'/'.count( $tables ).'<br />' );
}
print( 'Обновление завершено!<br />' );
print( '<b><font color="red">Удалите файлы update.php и install.php !!!</font></b>' );
?>