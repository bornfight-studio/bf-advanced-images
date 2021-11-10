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

	public function disable_default_image_sizes( array $sizes ): array {
		$remove_image_sizes = get_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION );

		if ( ! empty( $remove_image_sizes ) ) {
			foreach ( $remove_image_sizes as $image_size ) {
				if ( in_array( $image_size, $sizes ) ) {
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
}