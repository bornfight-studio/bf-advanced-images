<?php

namespace bfAdvancedImages\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFDashboardSetup {
	public $capability = 'manage_options';

	public function init(): void {
		add_action( 'admin_menu', array( $this, 'register_options_submenu_page' ) );
		add_filter( 'plugin_action_links_' . BFAI_PLUGIN_BASENAME, array( $this, 'add_settings_link' ), 10, 1 );
	}


	public function register_options_submenu_page(): void {
		add_submenu_page(
			'tools.php',
			'BF Advanced Images Options',
			'BF Advanced Images Options',
			'manage_options',
			'bf-advanced-images',
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
		load_template( BFAI_PLUGIN_PATH . '/templates/admin/bf-advanced-images-admin-display.php' );
	}

	public function add_settings_link( array $links ): array {
		$settings_link = 'tools.php?page=' . BFAI_PLUGIN_SLUG;
		$links[]       = sprintf( '<a href="%s">Settings</a>', $settings_link );

		return $links;
	}
}
