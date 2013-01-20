<?php
class statistics {
	function getReferersCount() {
		global $config;
		$db = new db_e;
		
		$query = "SELECT COUNT(id) FROM".$config['db_prefix']."external_referers";
		$res = $db->ExecQuery( $query );
		$count = $res['count'];
		return $count;
	}
	
	function getPagesCount() {
		global $config;
		$db = new db_e;
		
		$query = "SELECT COUNT(id) FROM".$config['db_prefix']."external_pages";
		$res = $db->ExecQuery( $query );
		$count = $res['count'];
		return $count;
	}
	
	function getUaCount() {
		global $config;
		$db = new db_e;
		
		$query = "SELECT COUNT(id) FROM".$config['db_prefix']."external_ua";
		$res = $db->ExecQuery( $query );
		$count = $res['count'];
		return $count;
	}
}
?>