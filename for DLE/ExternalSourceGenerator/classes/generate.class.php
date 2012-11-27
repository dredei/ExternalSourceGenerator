<?php
class Generate {
	function generateItems( $pages, $referers ) { // генерирует итэм для каждой страницы - отдельный
		$items['Items'] = array();
		for ( $i = 0; $i < count( $pages ); $i++ ) {
			$page = $pages[$i]['Page'];
			$page_referers = $referers[$page];
			$item['Pages'][0] = $pages[$i];
			if ( count( $page_referers ) > 0 ) {
				$item['Referers'] = $page_referers;
			}
			$items['Items'][] = $item;
		}
		$items_json = json_encode( $items );
		return $items_json;
	}
	
	function autoGenerate( $path, $fpath ) {
		require_once( $fpath.'classes/getInfo.class.php' );
	
		global $config;
		$db = new db_e;
		$getInfo = new GetInfo;		
		
		$query = "SELECT * FROM ".$config['db_prefix']."external_settings LIMIT 1";
		$settings_res = $db->ExecQuery( $query );
		if ( $settings_res['count'] == 0 ) {
			$query = "INSERT INTO ".$config['db_prefix']."external_settings (auto_gen_time, auto_last_gen) VALUES (24, NOW())";
			$db->ExecQuery( $query );
		} else {
			$query = "SELECT * FROM ".$config['db_prefix']."external_settings WHERE ( auto_last_gen + INTERVAL auto_gen_time HOUR ) < NOW()";
			$gen_res = $db->ExecQuery( $query );
			if ( $gen_res['count'] == 1 ) {
				$getInfo = new GetInfo;
				
				$query = "UPDATE ".$config['db_prefix']."external_settings SET auto_last_gen = NOW()";				
				$db->ExecQuery( $query );
				$pages = $getInfo->getPages( 'all' );
				$referers = $getInfo->getReferers( $pages );
				$external = $this->generateItems( $pages, $referers );
				$fp = fopen( $path.'external.txt', 'w+' );
				$resWrite = fwrite( $fp, $external );
			}
		}
	}
}

?>