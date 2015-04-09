<?php

require 'import-functions.php';
require 'admin-page.php';

function tesseract_get_packages() {
	define( 'TESSERACT_PACKAGE_LIST_URL', 'http://tylermoore.dev/api/package/list' );

	$content = file_get_contents( dirname( __FILE__ ) . '/data/packages.json' );
	$content = file_get_contents( TESSERACT_PACKAGE_LIST_URL );
	$data = json_decode( $content, true );
	$packages = $data['data']['packages'];

	return $packages;
}

function tesseract_import_package_url( $package_id ) {
	return wp_nonce_url( admin_url( 'admin.php?page=tesseract-importer&import_package=' . intval( $package_id ) ), 'tesseract_import_package' );
}