<?php

namespace bfAdvancedImages\providers;

use bfAdvancedImages\core\BFImagesDirectoryOptions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFAdminOptionsProvider {
	public function delete_cached_images( array $post_data, BFImagesDirectoryOptions $bf_image_directory_options ): bool {
		if ( ! empty( $post_data['delete_all_cached_images'] ) ) {
			return $bf_image_directory_options->delete_all_bf_images();
		}

		return false;
	}
}