<?php

function tesseract_add_admin_menu() {
	add_menu_page( 'Tesseract', 'Tesseract', 'manage_options', 'tesseract-importer', 'tesseract_display_admin_page' );
}

add_action( 'admin_menu', 'tesseract_add_admin_menu' );

function tesseract_display_admin_page() {
	if ( tesseract_is_import_package_page() ) {
		load_template( dirname( __FILE__ ) . '/templates/importer-display-import.php' );
	} elseif ( tesseract_is_plugin_install_page() ) {
		load_template( dirname( __FILE__ ) . '/templates/importer-plugin-install.php' );
	} else {
		load_template( dirname( __FILE__ ) . '/templates/importer-home.php' );
	}
}

function tesseract_handle_package_import() {
	if ( tesseract_is_valid_package_import() ) {
		$packages = tesseract_get_packages();
		$package_id = intval( $_POST['package'] );

		if ( empty( $packages[$package_id] ) ) {
			tesseract_add_error_message( "Error: Invalid package. Try another?" );
			return;
		}

		if ( tesseract_needs_plugins_installed() ) {
			wp_redirect( tesseract_get_plugin_install_url( $package_id ) );
			exit;
		}

		$result = tesseract_import_package( $packages[$package_id] );

		if ( is_wp_error( $result ) ) {
			tesseract_add_error_message( "Error: Package import was incomplete: " . $result->get_error_message() );
		} else {
			global $tesseract_import_result;
			$tesseract_import_result = $result;
			tesseract_add_success_message( "Success! Imported '{$packages[$package_id]['name']}' Package." );
		}
	}
}

add_action( 'admin_init', 'tesseract_handle_package_import' );
