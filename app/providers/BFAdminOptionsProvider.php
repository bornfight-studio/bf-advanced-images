<?php

namespace bfAdvancedImages\providers;

use bfAdvancedImages\core\BFConstants;
use bfAdvancedImages\core\BFImagesDirectoryOptions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFAdminOptionsProvider {
	public function delete_cached_images( array $post_data, BFImagesDirectoryOptions $bf_image_directory_options ): bool {
		if ( ! empty( $post_data['bfai_delete_all_cached_images'] ) ) {
			return $bf_image_directory_options->delete_all_bf_images();
		}

		return false;
	}

	public function remove_image_sizes( array $post_data ): bool {
		if ( ! empty( $post_data['bfai_unset_image_sizes_submit'] ) ) {
			$sanitized_data = filter_var_array( $post_data['bfai_unset_image_sizes'], FILTER_SANITIZE_STRING );
			$updated_option = update_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION, json_encode( $sanitized_data ) );

			return ! empty( $updated_option );
		}

		return false;
	}

	public function save_webp_conversion_option( array $post_data ): bool {
		if ( ! empty( $post_data['bfai_webp_conversion_submit'] ) ) {
			$webp_conversion = isset( $post_data['bfai_webp_conversion'] ) ? true : false;
			$webp_lossless = isset( $post_data['bfai_webp_lossless'] ) ? true : false;
			$webp_quality = isset( $post_data['bfai_webp_quality'] ) ? intval( $post_data['bfai_webp_quality'] ) : 80;

			// Ensure quality is between 0 and 100
			$webp_quality = max( 0, min( 100, $webp_quality ) );

			update_option( BFConstants::BFAI_WEBP_LOSSLESS_OPTION, $webp_lossless );
			update_option( BFConstants::BFAI_WEBP_QUALITY_OPTION, $webp_quality );
			return update_option( BFConstants::BFAI_WEBP_CONVERSION_OPTION, $webp_conversion );
		}

		return false;
	}
}