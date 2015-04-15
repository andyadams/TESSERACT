<?php

require_once dirname( __FILE__ ) . '/vendor/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

function tesseract_register_required_plugins() {
	// When the user attempts to import a package, the required plugins for that package are
	// stored in the 'tesseract_required_plugins' option, so we can nag the user to install.
	$tesseract_required_plugins = get_option( 'tesseract_required_plugins' );

	if ( ! empty( $tesseract_required_plugins ) && is_array( $tesseract_required_plugins ) ) {
		$return_url = get_option( 'tesseract_plugin_install_return_url' );

		if ( empty( $return_url ) ) {
			$return_url = tesseract_get_import_home_url();
		}

		$config = array(
			'has_notices'  => false,					// Show admin notices or not.
			'dismissable'  => false,					// If false, a user cannot dismiss the nag message.
			'is_automatic' => true,				   // Automatically activate plugins after installation or not.
			'strings'	   => array(
				'notice_can_install_required'	  => _n_noop( 'This package requires the following plugin: %1$s.', 'This package requires the following plugins: %1$s.' ),
				'notice_can_install_recommended'  => _n_noop( 'This package recommends the following plugin: %1$s.', 'This package recommends the following plugins: %1$s.' ),
				'complete'						  => __( 'All plugins installed and activated successfully. <a href="' . esc_url( $return_url ) . '">Return to the content importer</a>.', 'tgmpa' ),
				'tesseract_return' => "<a href='" . esc_url( $return_url ) . "'>Continue importing your package</a>"
			)
		);


		tgmpa( $tesseract_required_plugins, $config );
	}
}

add_action( 'tgmpa_register', 'tesseract_register_required_plugins' );

/**
 * If the user is attempting to import a package with plugin requirements, those requirements
 * are stored in the 'tesseract_required_plugins' option.
 *
 * It's important this function is hooked before the TGM_Plugin_Activation class loads it's requirements.
 */
function tesseract_check_plugin_requirements() {
	if ( tesseract_is_import_package_page() && tesseract_is_valid_package_import() ) {
		$package_id = intval( $_POST['package'] );
		$packages = tesseract_get_packages();

		$required_plugins = array();

		if ( isset( $packages[$package_id]['required_plugins'] ) ) {
			foreach ( $packages[$package_id]['required_plugins'] as $required_plugin ) {
				$required_plugins[] = array(
					'name' => $required_plugin['name'],
					'slug' => $required_plugin['slug'],
					'required' => true
				);
			}
		}

		update_option( 'tesseract_required_plugins', $required_plugins );
	}
}

add_action( 'init', 'tesseract_check_plugin_requirements', 2 );

/**
 * Returns true if the TGM class tells us that there are notices
 */
function tesseract_needs_plugins_installed() {
	ob_start();
	$activator = TGM_Plugin_Activation::get_instance();
	$activator->notices();
	$messages = ob_get_contents();
	ob_end_clean();

	return ! empty( $messages );
}

/**
 * Super hacky workaround to the fact that TGMPA does processing after headers are sent.
 */
function tesseract_redirect_after_activation() {
	$return_url = get_option( 'tesseract_plugin_install_return_url' );

	if ( ! empty( $return_url ) ) {
		?>
		<script type="text/javascript">
			window.location.replace(<?php echo json_encode( $return_url ) ?>);
		</script>
		<?php
	}
}

add_action( 'tesseract_tgmpa_after_bulk_activate', 'tesseract_redirect_after_activation' );