<?php

/**
 * On success, returns an array with details about the import results.
 * On failure, returns a WP_Error
 */
function tesseract_import_package( $package_array ) {
	$results = array(
		'post_ids' => array(),
		'options' => array(),
		'name' => $package_array['name']
	);

	if ( ! empty( $package_array['posts'] ) ) {
		foreach ( $package_array['posts'] as $post ) {
			$post_id = wp_insert_post( $post, true );
			if ( is_wp_error( $post_id ) ) {
				return $post_id;
			} else {
				$results['post_ids'][] = $post_id;
				if ( ! empty( $post['meta'] ) ) {
					foreach ( $post['meta'] as $meta_key => $meta_value ) {
						update_post_meta( $post_id, $meta_key, maybe_unserialize( $meta_value[0] ) );
					}
				}
			}
		}
	}

	if ( ! empty( $package_array['options'] ) ) {
		foreach ( $package_array['options'] as $option_array ) {
			if ( NULL != $option_array['option_name'] && NULL != $option_array['option_value'] ) {
				update_option( $option_array['option_name'], $option_array['option_value'] );
				$results['options'][] = $option_array;
			}
		}
	}

	// Clear out the option for 'required plugins', because the package has completed importing.
	// All plugins should have been installed/activated by now.
	delete_option( 'tesseract_required_plugins' );
	delete_option( 'tesseract_plugin_install_return_url' );

	update_option( 'tesseract_imported_package_' . intval( $package_array['id'] ), 1 );

	return $results;
}