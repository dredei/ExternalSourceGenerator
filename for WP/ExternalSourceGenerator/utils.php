<?php
	require_once( '../../../wp-config.php' );
	require_once 'auth.php';
	require_once 'classes/checkInfo.class.php';
	require_once 'config.php';
	print( '<meta charset="UTF-8">' );
	
	switch ( $_GET['action'] ) {
		case 'deleteHttp':
			checkInfo::deleteHttp();
			print( 'Рефереры "http://" и "https://" очищены!' );
		break;
		
		default:
			print( 'O_o' );
		break;
	}
?>