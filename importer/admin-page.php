<?php

function tesseract_add_admin_menu() {
	add_menu_page( 'Tesseract', 'Tesseract', 'manage_options', 'tesseract-importer', 'tesseract_display_admin_page' );
}

add_action( 'admin_menu', 'tesseract_add_admin_menu' );

function tesseract_display_admin_page() {
	load_template( dirname( __FILE__ ) . '/templates/importer-home.php' );
}

function tesseract_handle_package_import() {
	$nonce = $_REQUEST['_wpnonce'];
	if ( isset( $_REQUEST['import_package'] ) && wp_verify_nonce( $nonce, 'tesseract_import_package' ) ) {
		$packages = tesseract_get_packages();
		tm_import_package( $packages[$_REQUEST['import_package']] );
		echo "Imported Package #{$_REQUEST['import_package']}";
	}
}

add_action( 'admin_init', 'tesseract_handle_package_import' );