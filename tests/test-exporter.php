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

	function testPackagePostExport() {
		// Create 2 posts
		$post_id_one = $this->factory->post->create( array( 'post_title' => 'ONE' ) );
		$post_id_two = $this->factory->post->create( array( 'post_title' => 'TWO' ) );

		// Create a package with those 2 posts
		$package = new TM_Content_Package;
		$package->addPost( $post_id_one );
		$package->addPost( $post_id_two );

		// Export the package
		$exported_package = $package->export();

		// Assert that the 2 posts are in the package
		$this->assertContains( get_post( $post_id_one, ARRAY_A ), $exported_package['posts'] );
		$this->assertContains( get_post( $post_id_two, ARRAY_A ), $exported_package['posts'] );
	}
}