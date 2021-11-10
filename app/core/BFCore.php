<?php

namespace bfAdvancedImages\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFCore {
	public function init(): void {
		$this->init_classes();

		add_action( 'intermediate_image_sizes_advanced', array( $this, 'disable_default_image_sizes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
	}

	public function disable_default_image_sizes( array $sizes ): array {
		$remove_image_sizes = ! empty( get_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION ) ) ? json_decode( get_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION ) ) : array();

		if ( ! empty( $remove_image_sizes ) ) {
			foreach ( $remove_image_sizes as $image_size ) {
				if ( isset( $sizes[ $image_size ] ) ) {
					unset( $sizes[ $image_size ] );
				}
			}
		}

		return $sizes;
	}

	private function init_classes(): void {
		$dashboard_setup = new BFDashboardSetup();
		$dashboard_setup->init();

		$directory_options = new BFImagesDirectoryOptions();
		$directory_options->init();

		require_once BFAI_LOCAL_PLUGIN_PATH . 'app/global-helper-functions.php';
	}

	public function add_admin_scripts(): void {
		wp_enqueue_script( 'bfai-admin-js', BFAI_LOCAL_PLUGIN_URL . 'static/js/index.js', array(), '1.0' );
	}
}