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
	
2. Скопировать папку engine в корень сайта, подтвердить замену .
3. Переименовать файл external.txt.new в external.txt (если до копирования его не существовало!) , выставить права на запись (666).
4. Переименовать config.php.new в config.php (если до копирования его не существовало!) и указать в нем настройки подключения к бд.
5. Запустить install.php , который находится в папке engine/modules/ExternalSourceGenerator/ .
6. После установки/обновления удалите install.php и update.php !