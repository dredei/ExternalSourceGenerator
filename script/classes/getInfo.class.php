<?php
class getInfo {
	function Scr( $str ) {
		$result = str_replace( '/', '\\\\\\\\/', $str );
		return $result;
	}

	function getPages( $period ) {
		global $config;
		$db = new db_e;
		$pages_count = 0;
		
		switch ( $period ) {
			case "week":
					$query = "";
				break;
			case "month":
					$query = "";
				break;
			case "all":
					$query = "SELECT * FROM ".$config['db_prefix']."external_pages";
				break;
		}
		$pages_res = $db->ExecQuery( $query );
		for ( $i = 0; $i < $pages_res['count']; $i++ ) {
			$pages[$pages_count]['Page'] = $pages_res['rows'][$i]['page'];
			$pages[$pages_count++]['Priority'] = $pages_res['rows'][$i]['count'];
		}
		return $pages;		
	}
	
	function getReferers( $pages ) {
		global $config;
		$db = new db_e;
		$ref_count = 0;
		
		for ( $i = 0; $i < count( $pages ); $i++ ) {
			$page = $pages[$i]['Page'];
			$query = "SELECT * FROM ".$config['db_prefix']."external_referers WHERE pages LIKE '%\"".$this->Scr( $page )."\"%'";
			$referers_res = $db->ExecQuery( $query );
			for ( $j = 0; $j < $referers_res['count']; $j++ ) {
				$referers[$page][$ref_count]['Referer'] = $referers_res['rows'][$j]['referer'];
				$referers[$page][$ref_count++]['Priority'] = $referers_res['rows'][$j]['count'];
			}
		}
		return $referers;
	}
}
?> 