<?php

/**
 * On success, returns an array with details about the import results.
 * On failure, returns a WP_Error
 */
function tesseract_import_package( $package_array ) {
	$results = array(
		'post_ids' => array(),
	);

	foreach ( $package_array['posts'] as $post ) {
		$post_id = wp_insert_post( $post, true );
		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		} else {
			$results['post_ids'][] = $post_id;
		}
	}

	return $results;
}