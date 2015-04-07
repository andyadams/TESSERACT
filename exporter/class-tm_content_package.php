<?php

class TM_Content_Package {
	protected $posts;

	function __construct() {
		$this->posts = array();
	}

	function addPost( $post_id ) {
		$this->posts[] = tm_export_post( $post_id );
	}

	function export() {
		$exported_package = array(
			'posts' => $this->posts
		);

		return $exported_package;
	}
}