<?php

require 'import-functions.php';
require 'admin-page.php';

if ( ! defined( 'TESSERACT_PACKAGE_LIST_URL' ) ) {
	define( 'TESSERACT_PACKAGE_LIST_URL', 'http://wpmakr.com/api/package/list' );
}

function tesseract_enqueue_importer_scripts() {
	global $pagenow;

	if ( 'admin.php' == $pagenow && isset( $_GET['page'] ) && 'tesseract-importer' == $_GET['page'] ) {
		wp_enqueue_script( 'tesseract-importer-admin', get_template_directory_uri() . '/importer/js/importer-admin.js', array( 'jquery' ) );
	}
}

add_action( 'admin_enqueue_scripts', 'tesseract_enqueue_importer_scripts' );

function tesseract_get_packages() {
	$content = file_get_contents( TESSERACT_PACKAGE_LIST_URL );

	if ( false === $content ) {
		$content = file_get_contents( dirname( __FILE__ ) . '/data/packages.json' );
	}

	$data = json_decode( $content, true );
	$packages = $data['data']['packages'];

	return $packages;
}

function tesseract_get_import_package_url() {
	return admin_url( 'admin.php?page=tesseract-importer&import_package=1' );
}