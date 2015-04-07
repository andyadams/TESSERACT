<?php

class ExporterTest extends WP_UnitTestCase {

	function testPostExport() {
		// Create a post
		$post_id = $this->factory->post->create( array( 'post_title' => 'This is the title' ) );

		// Export that post
		$exported_post = tm_export_post( $post_id );

		// Assert that it matches the format we expect for a post
		$expected_output = get_post( $post_id, ARRAY_A );
		$this->assertEquals( $expected_output, $exported_post );
		$this->assertEquals( 'This is the title', $exported_post['post_title'] );
	}

}


function tm_export_post( $post_id ) {
	return get_post( $post_id, ARRAY_A );
}
