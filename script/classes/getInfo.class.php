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
			case "yesterday":
				$query = "SELECT * FROM ".$config['db_prefix']."external_pages WHERE `date` >= (CURDATE()-1) AND `date` < CURDATE();";
				break;
			case "week":
				$query = "SELECT * FROM ".$config['db_prefix']."external_pages WHERE year(`date`) = year(now()) and week(`date`, 1) = week(now(), 1);";
				break;
			case "month":
				$query = "SELECT * FROM ".$config['db_prefix']."external_pages WHERE date_format(`date`, '%Y%m') = date_format(now(), '%Y%m');";
				break;
			case "all":
				$query = "SELECT * FROM ".$config['db_prefix']."external_pages";
				break;
		}
		$pages_res = $db->ExecQuery( $query );
		for ( $i = 0; $i < $pages_res['count']; $i++ ) {
			$pages[$pages_count]['Page'] = $pages_res['rows'][$i]['page'];
			//$pages[$pages_count++]['Priority'] = $pages_res['rows'][$i]['count'];
			$pages[$pages_count++]['Priority'] = rand( 1, $pages_res['rows'][$i]['count'] );
		}
		return $pages;		
	}
	
	function getReferers( $pages ) {
		global $config;
		$db = new db_e;
		$ref_count = 0;
		
		for ( $i = 0; $i < count( $pages ); $i++ ) {
			$page = $pages[$i]['Page'];
			$referers_res = array();
			$query = "SELECT * FROM ".$config['db_prefix']."external_referers WHERE pages LIKE '%\"".$this->Scr( $page )."\"%'";
			$referers_res = $db->ExecQuery( $query );
			$ref_count = 0;
			if ( $referers_res['count'] == 0 ) {
				$referers[$page] = array();
			} else {
				for ( $j = 0; $j < $referers_res['count']; $j++ ) {
					$referers[$page][$ref_count]['Referer'] = $referers_res['rows'][$j]['referer'];
					//$referers[$page][$ref_count++]['Priority'] = $referers_res['rows'][$j]['count'];
					$referers[$page][$ref_count++]['Priority'] = rand( 1, $referers_res['rows'][$j]['count'] );
				}
			}
		}
		return $referers;
	}
	
	function getExMasks() {
		global $config;
		$db = new db_e;
		
		$query = "SELECT exMasks FROM ".$config['db_prefix']."external_settings";
		$exMasks_res = $db->ExecQuery( $query );
		if ( $exMasks_res['rows'][0]['exMasks'] != '' ) {
			$exMasks_res['rows'][0]['exMasks'] = str_replace( "\r\n",'', $exMasks_res['rows'][0]['exMasks'] );
			$exMasks_res['rows'][0]['exMasks'] = str_replace( "\n",'', $exMasks_res['rows'][0]['exMasks'] );
			$exMasks = explode( ',', $exMasks_res['rows'][0]['exMasks'] );
		} else {
			$exMasks = array();
		}
		return $exMasks;
	}
}
?> 