<?php

namespace bfAdvancedImages\cli;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use bfAdvancedImages\core\BFImagesDirectoryOptions;
use \WP_CLI;

class ImagesControllerCLI {
	public function delete_images(): string {
		$bf_images_directory_options = new BFImagesDirectoryOptions();

		if ( empty( $bf_images_directory_options->delete_all_bf_images() ) ) {
			WP_CLI::error( esc_html( 'Something went wrong' ) );
		}

		WP_CLI::success( esc_html( 'Images deleted successfully' ) );
	}
}