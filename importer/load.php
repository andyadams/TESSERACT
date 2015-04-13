<?php

require 'import-functions.php';
require 'admin-page.php';
require_once dirname( __FILE__ ) . '/vendor/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

define( 'TESSERACT_PACKAGE_LIST_URL', 'http://tylermoore.dev/api/package/list' );
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

function tesseract_get_plugin_install_url( $package_id ) {
	return admin_url( 'admin.php?page=tesseract-importer&importer_plugin_install=1&package=' . intval( $package_id ) );
}


add_action( 'tgmpa_register', 'tesseract_register_required_plugins' );

function tesseract_register_required_plugins() {
	if ( tesseract_is_import_package_page() || tesseract_is_plugin_install_page() ) {
		$package_id = intval( $_REQUEST['package'] );
		$packages = tesseract_get_packages();

		$required_plugins = array();

		if ( isset( $packages[$package_id]['required_plugins'] ) ) {
			foreach ( $packages[$package_id]['required_plugins'] as $required_plugin ) {
				$required_plugins[] = array(
					'name' => $required_plugin['slug'],
					'slug' => $required_plugin['slug'],
					'required' => true
				);
			}
		}
	}

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'default_path' => '',					   // Default absolute path to pre-packaged plugins.
		'menu'		   => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => false,					// Show admin notices or not.
		'dismissable'  => false,					// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',					   // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,				   // Automatically activate plugins after installation or not.
		'message'	   => '',					   // Message to output right before the plugins table.
		'strings'	   => array(
			'page_title'					  => __( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'					  => __( 'Install Plugins', 'tgmpa' ),
			'installing'					  => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
			'oops'							  => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'	  => _n_noop( 'This package requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This package recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'			  => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'	  => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'		  => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'			  => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'			  => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'					  => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'					  => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'						  => __( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'				  => __( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'						  => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
			'nag_type'						  => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $required_plugins, $config );

}