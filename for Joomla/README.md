WaspAce-Scripts
===============

Генератор ви для Joomla.
В разработке.

Автор: dredei
Сайт: http://softez.pp.ua/

Установка:
1. Открыть index.php , в конце файла добавить:
	require_once( 'modules/ExternalSourceGenerator/config.php' );
	require_once( 'modules/ExternalSourceGenerator/classes/writeInfo.class.php' );
	require_once( 'modules/ExternalSourceGenerator/classes/generate.class.php' );

    $writeInfo = new WriteInfo;
	$generate = new Generate;

	$resP = $writeInfo->writePage( $_SERVER['REQUEST_URI'] );
	if ( $resP == TRUE ) {
		$writeInfo->writeUA( $_SERVER['REQUEST_URI'], $_SERVER['HTTP_USER_AGENT'] );
		$writeInfo->writeReferer( $_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI'] );
	}
	
	$generate->autoGenerate( '', 'modules/ExternalSourceGenerator/' );
	mysql_close();
	
2. Скопировать папку modules в корень сайта, подтвердить замену .
3. Переименовать файл external.txt.new в external.txt (если до копирования его не существовало!) , выставить права на запись (666).
4. Переименовать config.php.new в config.php (если до копирования его не существовало!) и указать в нем настройки подключения к бд.
5. Запустить install.php , который находится modules/ExternalSourceGenerator/ .
6. После установки/обновления удалите install.php и update.php !
7. Админка: ESG_admin.php , пароль: admin .

Обновление:
1. Скопировать папку modules в корень сайта (подтвердить замену).
2. Запустить update.php .
3. После обновления удалить install.php и update.php !