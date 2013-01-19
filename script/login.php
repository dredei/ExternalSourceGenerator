<?php
if ( $_POST['login'] == 'login' ) {
	require_once("config.php");
	require_once("classes/settings.class.php");
	
	$password = $_POST['password'];
	$st = new settings;
	$token = $st->login( $password );
	if ( $token !== FALSE ) {
		setcookie('token', $token, time() + 60 * 60 * 24 * 14);
		$_SESSION['lg'] = 'lg';
	}
	header("Location: ESG_admin.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>External Source Generator (WaspAce) - Логин</title>
		<link href="style.css" type="text/css" rel="stylesheet">
	</head>
<body>	
	<div class="content">	
		<div class="login">
			<div class="login">
				<form action="login.php" method="post">
					<span class="clickbox referers">Пароль:</span><br />
					<span><input name="password" type="password" value=""></span><br />
					<input name="ok" type="submit">
					<input type="hidden" value="login" name="login">
				</form>
			</div>
		</div>
	</div>
</body>
</html>