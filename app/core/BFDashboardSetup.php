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
		add_action( 'admin_head', array( $this, 'add_admin_styles' ) );
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

	public function add_admin_styles(): void {
		?>
		<style>
			.bf-advanced-images-wrap .error {
				color: #d63638;
				padding: 10px;
				background: #f8d7da;
				border: 1px solid #f5c6cb;
				border-radius: 4px;
				margin: 10px 0;
			}
			.bf-advanced-images-wrap .success {
				color: #00a32a;
				padding: 10px;
				background: #d4edda;
				border: 1px solid #c3e6cb;
				border-radius: 4px;
				margin: 10px 0;
			}
			.bf-advanced-images-wrap .webp-debug-info {
				background: #f0f0f1;
				padding: 15px;
				border: 1px solid #c3c4c7;
				border-radius: 4px;
				margin: 15px 0;
			}
			.bf-advanced-images-wrap .webp-debug-info h3 {
				margin-top: 0;
				margin-bottom: 15px;
			}
			.bf-advanced-images-wrap .webp-debug-info p {
				margin: 5px 0;
			}
			.bf-advanced-images-wrap .webp-settings {
				background: #fff;
				padding: 20px;
				border: 1px solid #c3c4c7;
				border-radius: 4px;
				margin: 15px 0;
			}
			.bf-advanced-images-wrap .webp-setting-row {
				margin-bottom: 20px;
			}
			.bf-advanced-images-wrap .webp-setting-row:last-child {
				margin-bottom: 0;
			}
			.bf-advanced-images-wrap .webp-setting-row .description {
				color: #646970;
				font-style: italic;
				margin: 5px 0 0 0;
			}
			.bf-advanced-images-wrap input[type="range"] {
				width: 200px;
				margin: 0 10px;
				vertical-align: middle;
			}
			.bf-advanced-images-wrap output {
				display: inline-block;
				min-width: 40px;
				text-align: center;
				vertical-align: middle;
			}
		</style>
		<?php
	}
}
