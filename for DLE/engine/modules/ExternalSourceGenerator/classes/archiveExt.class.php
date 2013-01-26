<?php
class archiveExt {
	function archivation( $fileName, $path ) {
		$zip = new ZipArchive();
		$archiveName = $path.'external.zip';
		if ( $zip->open($archiveName, ZIPARCHIVE::CREATE) ) {
			$zip->deleteName( 'external.txt' );
			$zip->addFile( $path.'external.txt', 'external.txt' );
			$zip->close();
		}
	}
}
?>