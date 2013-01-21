<?php
class version {
	function getVersion() {
		global $config;
		$db = new db_e;
		
		$query = "SELECT scriptVersion FROM ".$config['db_prefix']."external_settings";
		$res = $db->ExecQuery( $query );
		$version = $res['rows'][0]['scriptVersion'];		
		return $version;
	}
}
?>