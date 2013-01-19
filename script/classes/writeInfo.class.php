<?php
require_once( 'browser.class.php' );

class WriteInfo {
	function writeUA( $curr_link, $userAgent ) {
		global $config;
		$db = new db_e;
	
		$browser = new BrowserExt();
		$browser->Browser( $userAgent );
		$browser_name = $browser->getBrowser();
		$browser_version = $browser->getVersion();
		if ( $browser_name == 'unknown' )
			return;
		$os = $browser->getPlatform();
		$ua = $browser->getUserAgent();
		$wr['browser_name'] = $browser_name;
		$wr['browser_version'] = $browser_version;
		$wr['os'] = $os;
		$wr['ua'] = $ua;		
		$query = "SELECT * FROM ".$config['db_prefix']."external_ua".$db->GenWhere( $wr, 'AND' )."";
		$ua_res = $db->ExecQuery( $query );
		$pages = array();
		if ( $ua_res['count'] > 0 ) {
			$ua_id = $ua_res['rows'][0]['id'];
			$pages = json_decode( $ua_res['rows'][0]['pages'] );
			if ( array_search( $curr_link, $pages ) === false ) {
				$pages[] = $curr_link;				
			}
			$pages_json = json_encode( $pages );
			$upd['count'] = $ua_res['rows'][0]['count'] + 1;
			$upd['pages'] = $pages_json;
			$upd['date'] = date( 'Y-m-d' );
			unset( $wr );
			$wr['id'] = $ua_id;
			$query = "UPDATE ".$config['db_prefix']."external_ua SET".$db->GenUpdate( $upd ).$db->GenWhere( $wr, 'AND' );	
		} else {
			$pages[] = $curr_link;
			$pages_json = json_encode( $pages );
			$ins['count'] = 1;
			$ins['browser_name'] = $browser_name;
			$ins['browser_version'] = $browser_version;
			$ins['os'] = $os;
			$ins['ua'] = $ua;	
			$ins['pages'] = $pages_json;
			$ins['date'] = date( 'Y-m-d' );
			$query = "INSERT INTO ".$config['db_prefix']."external_ua".$db->GenInsert( $ins );
		}
		$db->ExecQuery( $query );	
	}
	
	function writeReferer( $http_referer, $curr_link ) {
		if ( $http_referer != '' ) {		
			global $config;
			$db = new db_e;
			
			$ignore_links_arr = array( 'wp-admin\/', 'wp-content\/', '\/feed\/' );
			if ( ( strpos( $http_referer, $_SERVER['HTTP_HOST'] ) > 0 ) or ( preg_match( "/(".implode('|', $ignore_links_arr).")/is", $http_referer ) ) )
				return;

			$wr['referer'] = $http_referer;
			$query = "SELECT * FROM ".$config['db_prefix']."external_referers".$db->GenWhere( $wr, 'AND' );
			$referers_res = $db->ExecQuery( $query );
			$pages = array();
			if ( $referers_res['count'] > 0 ) {
				$referer_id = $referers_res['rows'][0]['id'];
				$pages = json_decode( $referers_res['rows'][0]['pages'] );
				if ( array_search( $curr_link, $pages ) === false ) {
					$pages[] = $curr_link;				
				}
				$pages_json = json_encode( $pages );
				$upd['count'] = $referers_res['rows'][0]['count'] + 1;
				$upd['pages'] = $pages_json;
				$upd['date'] = date( 'Y-m-d' );
				unset( $wr );
				$wr['id'] = $referer_id;
				$query = "UPDATE ".$config['db_prefix']."external_referers SET".$db->GenUpdate( $upd ).$db->GenWhere( $wr, 'AND' );				
			} else {
				$pages[] = $curr_link;
				$pages_json = json_encode( $pages );
				$ins['count'] = 1;
				$ins['referer'] = $http_referer;
				$ins['pages'] = $pages_json;
				$ins['date'] = date( 'Y-m-d' );
				$query = "INSERT INTO ".$config['db_prefix']."external_referers".$db->GenInsert( $ins );
			}
			$db->ExecQuery( $query );
		}
	}
	
	function writePage( $curr_link ) {
		global $config;
		$db = new db_e;
		
		$ignore_links_arr = array( 'wp-admin\/', 'wp-content\/' );			
		if ( ( preg_match( "/(".implode('|', $ignore_links_arr).")/is", $curr_link ) ) )
			return;

		$ins['count'] = 1;
		$ins['page'] = $curr_link;
		$ins['date'] = date( 'Y-m-d' );
		$query = "INSERT INTO ".$config['db_prefix']."external_pages".$db->GenInsert( $ins ).' ON DUPLICATE KEY UPDATE count = count + 1, `date` = NOW()';
		$db->ExecQuery( $query );
	}

}



?>