<?php
class Generate {
	function generateFakeRefsGoogle( $phrases, $pagesRange ) { //array of ph; return - array of refs
		$zonesArr = array( 0 => 'ru', 'ua' );		
		$referers = array();
		for ( $i = 0; $i < count( $phrases ); $i++ ) {
			$zone = $zonesArr[ rand( 0, count( $zonesArr ) - 1 ) ];
			$link = 'http://google.'.$zone.'/url?q='.urlencode( $phrases[$i] ); //page start=10
			$referers[] = $link;
		}
		return $referers;
	}
	
	function generateFakeRefsYandex( $phrases, $pagesRange ) { //array of ph; return - array of refs
		$zonesArr = array( 0 => 'ru', 'ua' );		
		$referers = array();
		for ( $i = 0; $i < count( $phrases ); $i++ ) {
			$zone = $zonesArr[ rand( 0, count( $zonesArr ) - 1 ) ];
			$link = 'http://yandex.'.$zone.'/yandsearch?text='.urlencode( $phrases[$i] ); //page p=1
			$referers[] = $link;
		}
		return $referers;
	}
	
	function generateFakeRefsMailRu( $phrases, $pagesRange ) { //array of ph; return - array of refs
		$zonesArr = array( 0 => 'ru' );		
		$referers = array();
		for ( $i = 0; $i < count( $phrases ); $i++ ) {
			$zone = $zonesArr[ rand( 0, count( $zonesArr ) - 1 ) ];
			$link = 'http://go.mail.'.$zone.'/search?mailru=1&mg=1&q='.urlencode( $phrases[$i] ); //page num=10&rch=l&sf=20
			$referers[] = $link;
		}
		return $referers;
	}

	function generatePaths( $pathsCount, $pathRange ) {
		$paths = array();		
		for ( $i = 1; $i <= $pathsCount; $i++ ) {
			$count = rand( $pathRange['Min'], $pathRange['Max'] );
			$path = array();
			for ( $j = 1; $j <= $count; $j++ ) {
				$path['Path'][] = '/';
			}
			$path['Priority'] = 1;
			$paths[] = $path;
		}
		return $paths;
	}
	
	function generateItems( $pages, $referers, $pathsCount, $pathRange, $exMasks ) { // генерирует итэм для каждой страницы - отдельный
		$items['Items'] = array();
		for ( $i = 0; $i < count( $pages ); $i++ ) {
			$page = $pages[$i]['Page'];
			$page_referers = $referers[$page];
			$item['Pages'][0] = $pages[$i];
			if ( count( $page_referers ) > 0 ) {
				$item['Referers'] = $page_referers;
			}
			$item['Paths'] = $this->generatePaths( $pathsCount, $pathRange );
			$items['Items'][] = $item;
		}
		if ( count( $exMasks ) > 0 ) {
			$items['ExMasks'] = $exMasks;
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
				$pathsCount = $gen_res['rows'][0]['pathsCount'];
				$pathRange  = json_decode( $gen_res['rows'][0]['depthsRange'], TRUE );				
				
				$pages    = $getInfo->getPages( 'all' );
				$referers = $getInfo->getReferers( $pages );
				$exMasks  = $getInfo->getExMasks();
				$external = $this->generateItems( $pages, $referers, $pathsCount, $pathRange, $exMasks );
				$fp = fopen( $path.'external.txt', 'w+' );
				$resWrite = fwrite( $fp, $external );
				$query = "UPDATE ".$config['db_prefix']."external_settings SET auto_last_gen = NOW()";				
				$db->ExecQuery( $query );
			}
		}
	}	
}
?>