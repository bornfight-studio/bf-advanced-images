<?php

namespace bfAdvancedImages\controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use bfAdvancedImages\core\BFConstants;
use bfAdvancedImages\core\BFImagesDirectoryOptions;
use \WP_CLI;
use \WP_CLI_Command;

class BFImagesControllerCLI extends WP_CLI_Command {
	public function delete_images(): void {
		$bf_images_directory_options = new BFImagesDirectoryOptions();
		if ( empty( $bf_images_directory_options->delete_all_bf_images() ) ) {
			WP_CLI::error( esc_html( 'Something went wrong' ) );
		}

		WP_CLI::success( esc_html( 'Images deleted successfully' ) );
	}

	public function is_dir_writable(): void {
		$bf_images_directory_options = new BFImagesDirectoryOptions();
		if ( ! $bf_images_directory_options->is_advanced_images_dir_writable() ) {
			WP_CLI::error( esc_html( 'Directory is not writable' ) );
		}

		WP_CLI::success( esc_html( 'Directory is writable' ) );
	}

	public function unset_default_image_sizes(): void {
		$default_image_sizes = get_intermediate_image_sizes();

		if ( empty( $default_image_sizes ) ) {
			WP_CLI::error( esc_html( 'There is no registered image sizes' ) );
		}

		$sanitized_data = filter_var_array( $default_image_sizes, FILTER_SANITIZE_STRING );
		$updated_option = update_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION, json_encode( $sanitized_data ) );
		if ( empty( $updated_option ) ) {
			WP_CLI::error( esc_html( 'Something went wrong, sizes were not saved' ) );
		}

		WP_CLI::success( esc_html( 'Sizes saved successfully' ) );
	}

	public function delete_default_image_sizes_option(): void {
		if ( get_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION ) ) {
			$delete_option = delete_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION );

			if ( empty( $delete_option ) ) {
				WP_CLI::error( esc_html( 'Something went wrong' ) );
			}
		}

		WP_CLI::success( esc_html( 'Sizes option deleted successfully' ) );
	}
}