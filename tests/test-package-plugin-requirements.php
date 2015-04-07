<?php

class PackagePluginRequirementsTest extends WP_UnitTestCase {
	function testPackagePluginsInstalled() {
		$required_plugin = 'required-plugin/test.php';
		$all_plugins = get_plugins();

		// Assert that a plugin is not installed
		$this->assertNotContains( $required_plugin, $all_plugins );

		// Create a package with that plugin requirement
		$package = new TM_Content_Package;
		$package->add_plugin_requirement( $required_plugin );

		// Try to import the package
		tm_import_package( $package->export() );

		// Assert that the package tells us that the plugin isn't installed
		$this->assertFalse( $package->requirements_met() );
		$this->assertNotEmpty( $package->missing_plugins() );

		// Install the plugin
		$this->fakePluginInstall( $required_plugin );

		// Assert plugin was installed
		// Clear the plugin cache...silly but necessary
		wp_cache_set( 'plugins', NULL, 'plugins' );
		$all_plugins = get_plugins();
		$this->assertArrayHasKey( $required_plugin, $all_plugins );

		// Assert the package tells us the plugin isn't activated
		$this->assertFalse( $package->requirements_met() );
		$this->assertNotEmpty( $package->inactive_required_plugins() );

		// Activate the plugin
		$this->fakeActivatePlugin( $required_plugin );

		// Assert the package requirements are met
		$this->assertTrue( $package->requirements_met() );
		$this->assertEmpty( $package->missing_plugins() );
		$this->assertEmpty( $package->inactive_required_plugins() );
	}

	function setUp() {
		$required_plugin = 'required-plugin/test.php';

		$this->installedPlugins = array(
			WP_PLUGIN_DIR . '/'. $required_plugin
		);

		$this->uninstallPlugins();
	}

	function tearDown() {
		$this->uninstallPlugins();
	}

	function fakePluginInstall( $name ) {
		$path = WP_PLUGIN_DIR . '/'. $name;

		if ( ! file_exists( dirname( $path ) ) ) {
			mkdir( dirname( $path ), 0777 );
		}

		file_put_contents( $path, "<?php /*\nPlugin Name: Test Plugin */" );

		if ( empty( $this->installedPlugins ) ) {
			$this->installedPlugins = array();
		}
	}

	function fakeActivatePlugin( $name ) {
		$existing_active_plugins = get_option( 'active_plugins' );
		$existing_active_plugins[] = $name;

		update_option( 'active_plugins', $existing_active_plugins );
	}

	function uninstallPlugins() {
		foreach ( $this->installedPlugins as $plugin_name ) {
			if ( file_exists( $plugin_name ) ) {
				$deleted = unlink( $plugin_name );
				$dirgone = rmdir( dirname( $plugin_name ) );
			}
		}
	}
}