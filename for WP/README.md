WaspAce-Scripts
===============

Генератор ви для WordPress.
В разработке.

Автор: dredei
Сайт: http://softez.pp.ua/

Установка:
1. Скопировать папку ExternalSourceGenerator в wp-content/plugins/ .
2. Открыть index.php (в корне сайта), после (с новой строки) require('./wp-blog-header.php'); добавить:
require_once( 'wp-admin/includes/plugin.php' );
require_once( 'wp-includes/plugin.php' );
if ( is_plugin_active( 'ExternalSourceGenerator/external_source_generator.php' ) ) {	
	require_once( 'wp-content/plugins/ExternalSourceGenerator/config.php' );
	require_once( 'wp-content/plugins/ExternalSourceGenerator/classes/writeInfo.class.php' );
	require_once( 'wp-content/plugins/ExternalSourceGenerator/classes/generate.class.php' );

    $writeInfo = new WriteInfo;
	$generate = new Generate;

	$writeInfo->writeUA( $_SERVER['REQUEST_URI'], $_SERVER['HTTP_USER_AGENT'] );
	$writeInfo->writeReferer( $_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI'] );
	$writeInfo->writePage( $_SERVER['REQUEST_URI'] );
	
	$generate->autoGenerate( 'wp-content/plugins/ExternalSourceGenerator/' );
}
3. Выставить права на запись файлу ExternalSourceGenerator/external.txt .
4. Активировать плагин External Source Generator (WaspAce) в админке.
5. Выполнить tables.sql .
6. Переименовать config.php.new в config.php и указать в нем настройки подключения к бд.