<?php

function tm_export_post( $post_id ) {
	return get_post( $post_id, ARRAY_A );
}
