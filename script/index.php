<?php
require_once( 'config.php' );
require_once( 'classes/writeInfo.class.php' );
require_once( 'classes/getInfo.class.php' );
require_once( 'classes/generate.class.php' );

$writeInfo = new WriteInfo;
$getInfo = new GetInfo;
$generate = new Generate;

//$writeInfo->writeUA( /*$_SERVER['REQUEST_URI']*/'/ppp/', $_SERVER['HTTP_USER_AGENT'] );
//$writeInfo->writeReferer( 'http://site.ru/', '/ppp/' );
//$writeInfo->writePage( '/ppp/' );

//print_r( $getInfo->getPages( 'all' ) );
$pages = $getInfo->getPages( 'all' );
$referers = $getInfo->getReferers( $pages );
//$pages_json = $generate->generatePages( $pages );
$p = $generate->generateItems( $pages, $referers );
print_r( $p );

?>