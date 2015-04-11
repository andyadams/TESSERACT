<?php

function tesseract_add_admin_menu() {
	add_menu_page( 'Tesseract', 'Tesseract', 'manage_options', 'tesseract-importer', 'tesseract_display_admin_page' );
}

add_action( 'admin_menu', 'tesseract_add_admin_menu' );

function tesseract_display_admin_page() {
	if ( isset( $_REQUEST['import_package'] ) ) {
		load_template( dirname( __FILE__ ) . '/templates/importer-display-import.php' );
	} else {
		load_template( dirname( __FILE__ ) . '/templates/importer-home.php' );
	}
}

function tesseract_handle_package_import() {
	$nonce = $_REQUEST['_wpnonce'];
	if ( isset( $_REQUEST['import_package'] ) && wp_verify_nonce( $nonce, 'tesseract_import_package' ) && $_POST['package'] ) {
		$packages = tesseract_get_packages();
		$package_id = intval( $_POST['package'] );

		if ( empty( $packages[$package_id] ) ) {
			tesseract_add_error_message( "Error: Invalid package. Try another?" );
			return;
		}

		$result = tesseract_import_package( $packages[$package_id] );

		if ( is_wp_error( $result ) ) {
			tesseract_add_error_message( "Error: Package import was incomplete: " . $result->get_error_message() );
		} else {
			global $tesseract_import_result;
			$tesseract_import_result = $result;
			tesseract_add_success_message( "Success! Imported Package $package_id." );
		}
	}
}

add_action( 'admin_init', 'tesseract_handle_package_import' );

function tesseract_add_error_message( $message ) {
	global $tesseract_messages;

	if ( empty( $tesseract_messages ) ) {
		$tesseract_messages = array();
	}

	if ( empty( $tesseract_messages['error'] ) ) {
		$tesseract_messages['error'] = array();
	}

	$tesseract_messages['error'][] = $message;
}

function tesseract_add_success_message( $message ) {
	global $tesseract_messages;

	if ( empty( $tesseract_messages ) ) {
		$tesseract_messages = array();
	}

	if ( empty( $tesseract_messages['error'] ) ) {
		$tesseract_messages['success'] = array();
	}

	$tesseract_messages['success'][] = $message;
}

function tesseract_has_error_messages() {
	$messages = tesseract_get_messages( 'error' );
	return ! empty( $messages );
}

function tesseract_has_success_messages() {
	$messages = tesseract_get_messages( 'success' );
	return ! empty( $messages );
}

function tesseract_get_messages( $key ) {
	global $tesseract_messages;

	if ( empty( $tesseract_messages ) || empty( $tesseract_messages[$key] ) ) {
		return array();
	} else {
		return $tesseract_messages[$key];
	}
}
