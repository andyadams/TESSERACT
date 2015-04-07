<?php

class TM_Content_Package {
	protected $posts;

	function __construct() {
		$this->posts = array();
	}

	function addPost( $post_array_or_id ) {
		if ( is_array( $post_array_or_id ) ) {
			$post_array = $post_array_or_id;
			$this->posts[] = $post_array;
			return true;
		} elseif ( is_numeric( $post_array_or_id ) ) {
			$post_id = $post_array_or_id;
			$this->posts[] = tm_export_post( $post_id );
			return true;
		}

		return false;
	}

	function export() {
		$exported_package = array(
			'posts' => $this->posts
		);

		return $exported_package;
	}
}