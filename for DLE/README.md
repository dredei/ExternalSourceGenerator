WaspAce-Scripts
===============

Генератор ви для DataLife Engine.
В разработке.

Автор: dredei
Сайт: http://softez.pp.ua/


Установка:
1. Открыть index.php , перед @session_start (); добавить:
	require_once( 'engine/modules/ExternalSourceGenerator/config.php' );
	require_once( 'engine/modules/ExternalSourceGenerator/classes/writeInfo.class.php' );
	require_once( 'engine/modules/ExternalSourceGenerator/classes/generate.class.php' );

    $writeInfo = new WriteInfo;
	$generate = new Generate;

	$writeInfo->writeUA( $_SERVER['REQUEST_URI'], $_SERVER['HTTP_USER_AGENT'] );
	$writeInfo->writeReferer( $_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI'] );
	$writeInfo->writePage( $_SERVER['REQUEST_URI'] );
	
	$generate->autoGenerate( '', 'engine/modules/ExternalSourceGenerator/' );
2. Скопировать папку ExternalSourceGenerator в engine/modules .
3. Скопировать в корень сайта файл external.txt , выставить права на запись.
4. Выполнить tables.sql .
5. Переименовать config.php.new в config.php и указать в нем настройки подключения к бд.