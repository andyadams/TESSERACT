<?php

function tesseract_get_import_package_url() {
	return admin_url( 'admin.php?page=tesseract-importer&import_package=1' );
}

function tesseract_get_plugin_install_url( $package_id ) {
	return admin_url( 'admin.php?page=tesseract-importer&importer_plugin_install=1&package=' . intval( $package_id ) );
}

function tesseract_is_import_package_page() {
	return $_GET['page'] == 'tesseract-importer' && isset( $_REQUEST['import_package'] );
}

function tesseract_is_plugin_install_page() {
	return $_GET['page'] == 'tesseract-importer' && isset( $_REQUEST['importer_plugin_install'] );
}

function tesseract_is_valid_package_import() {
	$nonce = $_REQUEST['_wpnonce'];
	return isset( $_REQUEST['import_package'] ) && wp_verify_nonce( $nonce, 'tesseract_import_package' ) && $_POST['package'];
}