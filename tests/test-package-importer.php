<?php

class PackageImporterTest extends WP_UnitTestCase {
	function testPostPackageImport() {
		// Create a package with 2 posts (not in DB)
		$package = new TM_Content_Package;
		$this->assertTrue( $package->add_post( array( 'post_title' => 'One Title!' ) ) );
		$this->assertTrue( $package->add_post( array( 'post_title' => 'Two Title!' ) ) );

		// Assert those 2 posts aren't in the DB
		$post = get_page_by_title( 'One Title!' );
		$this->assertEmpty( $post );
		$post = get_page_by_title( 'Two Title!' );
		$this->assertEmpty( $post );

		// Import the package
		tesseract_import_package( $package->export() );

		// Assert those 2 posts are in the DB
		$post = get_page_by_title( 'One Title!', OBJECT, 'post' );
		$this->assertNotEmpty( $post );
		$post = get_page_by_title( 'Two Title!', OBJECT, 'post' );
		$this->assertNotEmpty( $post );
	}
}