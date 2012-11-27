<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require('./wp-blog-header.php');

require_once( 'wp-admin/includes/plugin.php' );
require_once( 'wp-includes/plugin.php' );
if ( is_plugin_active( 'ExternalSourceGenerator/external_source_generator.php' ) ) {	
	require_once( 'wp-content/plugins/ExternalSourceGenerator/config.php' );
	require_once( 'wp-content/plugins/ExternalSourceGenerator/classes/writeInfo.class.php' );
	require_once( 'wp-content/plugins/ExternalSourceGenerator/classes/generate.class.php' );

    $writeInfo = new WriteInfo;
	$generate = new Generate;

	$writeInfo->writeUA( $_SERVER['REQUEST_URI'], $_SERVER['HTTP_USER_AGENT'] );
	$writeInfo->writeReferer( $_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI'] );
	$writeInfo->writePage( $_SERVER['REQUEST_URI'] );
	
	$generate->autoGenerate( 'wp-content/plugins/ExternalSourceGenerator/', 'wp-content/plugins/ExternalSourceGenerator/' );
}