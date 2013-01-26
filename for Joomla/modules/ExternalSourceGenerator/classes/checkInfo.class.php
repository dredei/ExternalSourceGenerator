<?php
class checkInfo {
	function checkRefsOnBlackRefs() {
		require_once 'settings.class.php';
		global $config;
		$db = new db_e;
		$st = new settings;
		
		$query = "SELECT * FROM ".$config['db_prefix']."external_referers";
		$referers_res = $db->ExecQuery( $query );
		$referers = $referers_res['rows'];
		
		$sett = $st->getSettings();
		$blackRefs = explode( "\n", $sett['rows'][0]['blackRefs'] );
	
		$query = "DELETE FROM ".$config['db_prefix']."external_referers WHERE ";
		$where = "";
		for ( $i = 0; $i < count( $blackRefs ); $i++ ) {
			for ( $j = 0; $j < count( $referers ); $j++ ) {
				if ( strpos( $referers[$j]['referer'], $blackRefs[$i] ) !== FALSE ) {
					if ( strlen( $where ) > 0 ) {
						$where .= " OR ";
					}
					$where .= "id=".$referers[$j]['id'];
				}
			}
		}
		if ( strlen( $where ) > 0 ) {
			$db->ExecQuery( $query.$where );
		}
	}
}
?>