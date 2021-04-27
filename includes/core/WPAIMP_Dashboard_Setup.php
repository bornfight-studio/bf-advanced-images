<?php

namespace wpAdvancedImagesPlugin\core;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Dashboard_Setup {
	public $capability = 'manage_options';

	public function init(): void {
		add_action( 'admin_menu', array( $this, 'register_options_submenu_page' ) );
		add_action( 'intermediate_image_sizes_advanced', array( $this, 'disable_default_image_sizes' ) );
	}


	public function register_options_submenu_page(): void {
		add_submenu_page(
			'tools.php',
			'WP Advanced Images Options',
			'WP Advanced Images Options',
			'manage_options',
			'wp-advanced-images-plugin',
			array( $this, 'get_options_menu_page_html' )
		);
	}

	/**
	 * Options page.
	 */
	public function get_options_menu_page_html(): void {
		if ( ! current_user_can( $this->capability ) ) {
			exit;
		}

		// Show the template
		load_template( WPAIMP_PLUGIN_PATH . '/admin/wp-advanced-images-plugin-admin-display.php' );
	}

	public function disable_default_image_sizes( array $sizes ): array {
		$image_sizes = get_option( 'wpaimp_image_sizes' );

		if ( ! empty( $image_sizes ) ) {
			foreach ( $image_sizes as $image_size ) {
				unset( $sizes[ $image_size ] );
			}
		}

		return $sizes;
	}
}
