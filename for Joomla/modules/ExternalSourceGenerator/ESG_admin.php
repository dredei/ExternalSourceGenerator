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
	$st->writeSettings( $settings );
	Exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>External Source Generator (WaspAce)</title>
		<link href="style.css" type="text/css" rel="stylesheet">
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
	function Succ() {
		$.noty.consumeAlert({layout: 'topCenter', type: 'success', dismissQueue: true});
		alert("Настройки сохранены!");
	}
	</script>
	
	<div class="content">	
		<div class="option">
			<div class="genTimeOpt">
				<span>Генерировать внешний источник каждые
				<input name="genTime" type="number" min="1" max="1000" value="24" required> часа (-ов)</span>
			</div>
			<div class="pathsCountOpt">
				<span>Количество путей (paths) для элемента (item): 
				<input name="pathsCount" type="number" min="1" max="100" value="3" required></span>
			</div>
			<div class="depthsRange">
				<span>Диапазон глубины для пути:</span><br />
				<span style="padding-left: 15px">От: <input name="depthsRangeMin" type="number" min="1" max="15" value="2" required></span><br />
				<span style="padding-left: 15px">До: <input name="depthsRangeMax" type="number" min="1" max="15" value="6" required></span>
			</div>
			<div class="exMasks">
				<span>Игнор. маски (разделять запятыми):</span><br />
				<span><textarea id="exMasks"></textarea></span>
			</div>
			<div class="newPass">
				<span>Старый пароль:</span><br />
				<span style="padding-left: 15px"><input name="oldPassword" type="password" value=""></span><br />
				<span>Новый пароль:</span><br />
				<span style="padding-left: 15px"><input name="newPassword" type="password" value=""></span>
			</div>			
			<div class="saveSett">
				<center>
					<button onClick="$.post( 'ESG_admin.php', { genTime: document.getElementsByName('genTime')[0].value, pathsCount: document.getElementsByName('pathsCount')[0].value, depthsRangeMin: document.getElementsByName('depthsRangeMin')[0].value, depthsRangeMax: document.getElementsByName('depthsRangeMax')[0].value, oldPassword: document.getElementsByName('oldPassword')[0].value, newPassword: document.getElementsByName('newPassword')[0].value, exMasks: document.getElementById('exMasks').value }, function() { Succ(); } );">Сохранить</button>
				</center>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	<?php	
		$res = $st->getSettings();
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