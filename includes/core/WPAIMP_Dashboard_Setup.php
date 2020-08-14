<?php

namespace wpAdvancedImagesPlugin\core;

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Dashboard_Setup {
	public $capability = 'manage_options';

	public function init(): void {
		add_action( 'admin_menu', array( $this, 'register_options_submenu_page' ) );
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
}
