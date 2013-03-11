<?php
require_once 'auth.php';
require_once 'classes/settings.class.php';
require_once 'config.php';

$st = new settings;

if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
	if ( ( isset($_POST['oldPassword']) ) and ( isset($_POST['newPassword']) ) ) {
		$oldPassword = $_POST['oldPassword'];
		$newPassword = $_POST['newPassword'];
		$st->changePassword( $oldPassword, $newPassword );
	}
	$settings['auto_gen_time'] = (int)$_POST['genTime'];
	$settings['pathsCount']    = (int)$_POST['pathsCount'];
	$depthsRange['Min'] 	   = $_POST['depthsRangeMin'];
	$depthsRange['Max']		   = $_POST['depthsRangeMax'];
	$settings['depthsRange']   = (string)json_encode( $depthsRange );;
	$settings['exMasks']       = (string)$_POST['exMasks'];
	$settings['blackRefs']     = (string)$_POST['blackRefs'];
	$settings['whiteRefs']     = (string)$_POST['whiteRefs'];
	$settings['dataPeriod']    = (string)$_POST['dataPeriod'];
	if ( $_POST['archivation'] == 'true' ) {
		$settings['archivation'] = (string)'yes';
	} else {
		$settings['archivation'] = (string)'no';
	}
	$st->writeSettings( $settings );
	if ( $_POST['startRefsFilter'] === 'true' ) {
		require_once 'classes/checkInfo.class.php';
		
		checkInfo::checkRefsOnBlackRefs();
	}
	Exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>External Source Generator (WaspAce)</title>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="buttons.css"/>
		<script src="http://code.jquery.com/jquery-1.9.0.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/noty/jquery.noty.js"></script>
		<script type="text/javascript" src="js/noty/layouts/center.js"></script>
		<script type="text/javascript" src="js/noty/themes/default.js"></script>
		<script type="text/javascript" src="js/noty/layouts/bottom.js"></script>
		<script type="text/javascript" src="js/noty/layouts/bottomCenter.js"></script>
		<script type="text/javascript" src="js/noty/layouts/bottomLeft.js"></script>
		<script type="text/javascript" src="js/noty/layouts/bottomRight.js"></script>
		<script type="text/javascript" src="js/noty/layouts/center.js"></script>
		<script type="text/javascript" src="js/noty/layouts/centerLeft.js"></script>
		<script type="text/javascript" src="js/noty/layouts/centerRight.js"></script>
		<script type="text/javascript" src="js/noty/layouts/inline.js"></script>
		<script type="text/javascript" src="js/noty/layouts/top.js"></script>
		<script type="text/javascript" src="js/noty/layouts/topCenter.js"></script>
		<script type="text/javascript" src="js/noty/layouts/topLeft.js"></script>
		<script type="text/javascript" src="js/noty/layouts/topRight.js"></script>
	</head>
<body>
	<script type="text/javascript">
	var refsFilter = false;
	
	function error(layout, message) {
		var n = noty({
			text: message,
			type: 'error',
			dismissQueue: true,
			layout: layout,
			theme: 'defaultTheme'
		});
	}
	
	function filtersMsg(layout) {		
		if ( document.getElementsByName('blackRefs')[0].value.length > 0 ) {
			var n = noty({
			text: 'Применить фильтр к существующим http-реферерам?',
			type: 'alert',
			dismissQueue: true,
			layout: layout,
			theme: 'defaultTheme',
			buttons: [
				{addClass: 'btn btn-primary', text: 'Да', onClick: function($noty) {
					$noty.close();
					refsFilter = true;
					saveSettings();
				}
				},
				{addClass: 'btn btn-danger', text: 'Нет', onClick: function($noty) {
					$noty.close();
					refsFilter = false;
					saveSettings();
					}
					}
				]
			});
		} else {
			saveSettings();
		}
	}
	
	function Succ(message) {
		$.noty.consumeAlert({layout: 'topCenter', type: 'success', dismissQueue: true});
		alert(message);
	}
	
	function saveSettings() {
		$.post( 'ESG_admin.php',
		{ genTime: document.getElementsByName('genTime')[0].value,
		  pathsCount: document.getElementsByName('pathsCount')[0].value,
		  depthsRangeMin: document.getElementsByName('depthsRangeMin')[0].value,
		  depthsRangeMax: document.getElementsByName('depthsRangeMax')[0].value,
		  oldPassword: document.getElementsByName('oldPassword')[0].value,
		  newPassword: document.getElementsByName('newPassword')[0].value,
		  exMasks: document.getElementsByName('exMasks')[0].value,
		  archivation: document.getElementsByName('enableArchivation')[0].checked,
		  blackRefs: document.getElementsByName('blackRefs')[0].value,
		  whiteRefs: document.getElementsByName('whiteRefs')[0].value,
		  startRefsFilter: refsFilter,
		  dataPeriod: document.getElementsByName('dataPeriod')[0].value },
		function() { Succ("Настройки сохранены!"); } );
	}
	
	function strlen(obj) {
	 return document.getElementsByName( obj )[0].value.length;
	}
	
	function disableEnableObj(objName, disableObjName) {
		if ( strlen( objName ) ) {
			document.getElementsByName(disableObjName)[0].disabled = true;
		} else {
			document.getElementsByName(disableObjName)[0].disabled = false;
		}
	}
	<?php
		if ( (file_exists( 'install.php' )) or (file_exists( 'update.php' )) ) {
			print( 'error("topLeft", "Удалите файлы <u>update.php</u> и <u>install.php</u> !!!");' );
		}
	?>
	</script>
	<?php
		$res = $st->getSettings();
		$arch = '';
		if ( $res['rows'][0]['archivation'] == 'yes' ) {
			$arch = 'checked';
		}
		$period[$res['rows'][0]['dataPeriod']] = 'selected';
	?>
	<div align="right">v<?php print( $res['rows'][0]['scriptVersion'] ); ?></div>
	<div class="content">	
		<div>
			<div>
				Генерировать внешний источник каждые
				<input name="genTime" type="number" min="1" max="1000" value="24" required> часа (-ов)
			</div>
			<div>
				Количество путей (paths) для элемента (item): 
				<input name="pathsCount" type="number" min="1" max="100" value="3" required>
			</div>
			<div>
				Диапазон глубины для пути:<br />
				<span style="padding-left: 15px">От: <input name="depthsRangeMin" type="number" min="1" max="15" value="2" required></span><br />
				<span style="padding-left: 15px">До: <input name="depthsRangeMax" type="number" min="1" max="15" value="6" required></span>
			</div>
			<div>
				<label><input type="checkbox" name="enableArchivation" value="yes" <?php print( $arch ); ?>>Архивировать файл внешнего источника</label><br />
			</div>
			<div>
				Период, за который выбирать данные:<br />
				<select name="dataPeriod">
					<option <?php print( $period['yesterday'] ); ?> value="yesterday">За вчера</option>
					<option <?php print( $period['week'] ); ?> value="week">За неделю</option>
					<option <?php print( $period['month'] ); ?> value="month">За месяц</option>
					<option <?php print( $period['all'] ); ?> value="all">За все время</option>
				</select>
			</div>
			<div>
				Не добавлять http-рефереры, в которых содержится (по одной маске на строку):<br />
				<textarea name="blackRefs" style="height: 150px; width: 200px;" onChange="javascript: disableEnableObj( 'blackRefs', 'whiteRefs' )"><?php print( $res['rows'][0]['blackRefs'] ); ?></textarea>
			</div>
			<div>
				<center><font color="red"><u>ИЛИ</u></font></center>
			</div>
			<div>
				Добавлять http-рефереры, в которых содержится (по одной маске на строку):<br />
				<textarea name="whiteRefs" style="height: 150px; width: 200px;" onChange="javascript: disableEnableObj( 'whiteRefs', 'blackRefs' )"><?php print( $res['rows'][0]['whiteRefs'] ); ?></textarea>
			</div>
			<div>
				Игнор. маски (разделять запятыми):<br />
				<textarea name="exMasks" style="height: 150px; width: 200px;"><?php print( $res['rows'][0]['exMasks'] ); ?></textarea>
			</div>
			<div>
				Старый пароль:<br />
				<span style="padding-left: 15px"><input name="oldPassword" type="password" value=""></span><br />
				Новый пароль:<br />
				<span style="padding-left: 15px"><input name="newPassword" type="password" value=""></span>
			</div>			
			<div>
				<center>
					<button onClick="filtersMsg( 'center' ); void(0);">Сохранить</button>
				</center>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	<?php	
		if ( $res['count'] > 0 ) {
			$pathRange = json_decode( $res['rows'][0]['depthsRange'], TRUE );
		
			print( "document.getElementsByName('genTime')[0].value = ".$res['rows'][0]['auto_gen_time'].';' );
			print( "document.getElementsByName('pathsCount')[0].value = ".$res['rows'][0]['pathsCount'].';' );
			print( "document.getElementsByName('depthsRangeMin')[0].value = ".$pathRange['Min'].';' );
			print( "document.getElementsByName('depthsRangeMax')[0].value = ".$pathRange['Max'].';' );
		}
	?>
	</script>
</body>
</html>