<?php

namespace bfAdvancedImages\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFCore {
	public function init(): void {
		$this->init_classes();

		add_action( 'intermediate_image_sizes_advanced', array( $this, 'disable_default_image_sizes' ) );
	}

	public function disable_default_image_sizes( array $sizes ) {
		foreach ( $sizes as $size_name => $size ) {
			unset( $sizes[ $size_name ] );
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
}