<?php

function tm_import_package( $package_array ) {
	foreach( $package_array['posts'] as $post ) {
		$result = wp_insert_post( $post, true );
	}
}