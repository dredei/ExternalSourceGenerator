<?php
class settings {	
	function writeSettings( $settings ) {
		global $config;	
		$db = new db_e;
		
		$query = "UPDATE ".$config['db_prefix']."external_settings SET ".$db->genUpdate($settings);
		$result = $db->ExecQuery( $query );
		return $result;
	}
	
	function getSettings() {
		global $config;
		$db = new db_e;
		
		$query = "SELECT * FROM ".$config['db_prefix']."external_settings";
		$result = $db->ExecQuery( $query );
		return $result;
	}
	
	function login( $password ) {
		global $config;
		$db = new db_e;
		
		$wr['password'] = md5( $password );
		$query = "SELECT id FROM ".$config['db_prefix']."external_settings".$db->genWhere( $wr );
		$res = $db->ExecQuery( $query );
		if ( $res['count'] > 0 ) {
			$token = md5( time().md5( $password ) );
			$upd['token'] = $token;
			$query = "UPDATE ".$config['db_prefix']."external_settings SET ".$db->genUpdate( $upd );
			$db->ExecQuery( $query );
			return $token;
		} else {
			return FALSE;
		}
	}
	
	function checkToken( $token ) {
		global $config;
		$db = new db_e;
	
		$wr['token'] = $token;
		$query = "SELECT id FROM ".$config['db_prefix']."external_settings".$db->genWhere( $wr );
		$res = $db->ExecQuery( $query );
		if ( $res['count'] > 0 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function changePassword( $oldPassword, $newPassword ) {
		global $config;
		$db = new db_e;
		
		$wr['password'] = md5( $oldPassword );
		$query = "SELECT id FROM ".$config['db_prefix']."external_settings".$db->genWhere( $wr );
		$res = $db->ExecQuery( $query );
		if ( $res['count'] > 0 ) {
			$upd['password'] = md5( $newPassword );
			$upd['token']    = md5( time() );
			$query = "UPDATE ".$config['db_prefix']."external_settings SET ".$db->genUpdate( $upd );
			$res = $db->ExecQuery( $query );
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>