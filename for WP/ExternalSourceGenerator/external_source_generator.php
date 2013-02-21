<?php
/*
Plugin Name: External Source Generator (WaspAce)
Plugin URI: http://softez.pp.ua/
Description: Генератор внешнего источника для системы WordPress.
Version: 1.0 Alpha 1
Author: dredei
Author URI: http://softez.pp.ua/
*/
/*  Copyright (c) 2012 dredei  (site: softez.pp.ua)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//add_action( 'admin_menu', 'external_source_generator_add_option_page');
//add_action( 'admin_menu', 'external_source_generator_add_sub_generate_page');

function external_source_generator_add_option_page() {
	add_menu_page( 'External Source Generator (WaspAce)', 'ExtSource Gen',  8, 'external_source_generator.php', 'external_source_generator_option_page' ); 
}

function external_source_generator_option_page() {
	print( 'ToDo: статистика' );
}

function external_source_generator_add_sub_generate_page() {
    add_submenu_page( 'external_source_generator.php', 'Генерация файла внешнего источника', 'Генерация файла внешнего источника', 8, __FILE__, 'external_source_generator_generate_page' );
}

function external_source_generator_generate_page() {
	require_once( plugin_dir_path( __FILE__ ).'config.php' );
	require_once( plugin_dir_path( __FILE__ ).'classes/getInfo.class.php' );
	require_once( plugin_dir_path( __FILE__ ).'classes/generate.class.php' );
	
	$getInfo = new GetInfo;
	$generate = new Generate;

	$pages = $getInfo->getPages( 'all' );
	$referers = $getInfo->getReferers( $pages );
	$external = $generate->generateItems( $pages, $referers );
	$fp = fopen( plugin_dir_path( __FILE__ ).'external.txt', 'w+' );
	$resWrite = fwrite( $fp, $external );
	if ( $resWrite ) {
		print( 'Сгенерировано успешно!' );
	} else {
		print( 'Ошибка при записи файла!' );
	}
}

?>