<?php

class TM_Content_Package {
	protected $posts;
	protected $required_plugins;

	public function __construct() {
		$this->posts = array();
		$this->required_plugins = array();
	}

	public function add_post( $post_array_or_id ) {
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

	public function add_plugin_requirement( $plugin_slug ) {
		$this->required_plugins[] = $plugin_slug;
	}

	public function export() {
		$exported_package = array(
			'posts' => $this->posts
		);

		return $exported_package;
	}

	public function requirements_met() {
		if ( ! empty( $this->required_plugins ) ) {
			return empty( $this->missing_plugins() ) && empty( $this->inactive_required_plugins() );
		}

		return true;
	}

	/**
	 * Returns a list of plugins that need to be installed for this package
	 */
	public function missing_plugins() {
		$installed_plugins = get_plugins();
		$missing_plugins = array();

		foreach ( $this->required_plugins as $required_plugin ) {
			// If the required plugin isn't in the list of installed plugins
			if ( ! isset( $installed_plugins[$required_plugin] ) ) {
				$missing_plugins[] = $required_plugin;
			}
		}

		return $missing_plugins;
	}

	/**
	 * Returns a list of installed plugins that need to be activated for this package
	 */
	public function inactive_required_plugins() {
		$active_plugins = get_option( 'active_plugins' );
		$inactive_plugins = array();

		foreach ( $this->required_plugins as $required_plugin ) {
			// If the required plugin isn't in the list of installed plugins
			if ( ! in_array( $required_plugin, $active_plugins ) ) {
				$inactive_plugins[] = $required_plugin;
			}
		}

		return $inactive_plugins;
	}
}