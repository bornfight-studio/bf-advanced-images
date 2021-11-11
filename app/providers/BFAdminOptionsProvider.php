<?php

namespace bfAdvancedImages\providers;

use bfAdvancedImages\core\BFConstants;
use bfAdvancedImages\core\BFImagesDirectoryOptions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFAdminOptionsProvider {
	public function delete_cached_images( array $post_data, BFImagesDirectoryOptions $bf_image_directory_options ): bool {
		if ( isset( $post_data['bfai_delete_all_cached_images'] ) ) {
			return $bf_image_directory_options->delete_all_bf_images();
		}

		return false;
	}

	public function remove_image_sizes( array $post_data ): bool {
		if ( isset( $post_data['bfai_unset_image_sizes_submit'] ) ) {
			$sanitized_data = array();
			if ( isset( $post_data['bfai_unset_image_sizes'] ) ) {
				$sanitized_data = filter_var_array( $post_data['bfai_unset_image_sizes'], FILTER_SANITIZE_STRING );
			}

			update_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION, json_encode( $sanitized_data ) );

			return true;
		}

		return false;
	}
}