<?php

namespace bfAdvancedImages\controller;

use bfAdvancedImages\core\BFImagesDirectoryOptions;
use bfAdvancedImages\providers\BFImageProvider;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFImageController {
	private $bf_images_directory_options = null;

	public function __construct() {
		$this->bf_images_directory_options = new BFImagesDirectoryOptions();
	}

	public function get_attachment_image_by_size_name( ?int $attachment_id, string $size_name, BFImageProvider $bf_image_provider, bool $crop = false ): ?string {
		if ( empty( $attachment_id ) || empty( $size_name ) ) {
			return '';
		}

		$image_size = $bf_image_provider->get_image_size( $size_name );
		if ( ! isset( $image_size['size'][0] ) || ! isset( $image_size['size'][1] ) ) {
			return '';
		}

		return $this->get_image( $attachment_id, array(
			intval( $image_size['size'][0] ),
			intval( $image_size['size'][1] )
		), $crop );
	}

	public function get_attachment_image_by_custom_size( ?int $attachment_id = null, array $size = array(), bool $crop = false ): string {
		if ( empty( $attachment_id ) || empty( $size ) ) {
			return '';
		}

		return $this->get_image( $attachment_id, array( $size[0], $size[1] ), $crop );
	}

	public function get_image( int $attachment_id, array $size = array(), bool $crop = false ): string {
		if ( empty( $size[0] ) ) {
			return '';
		}

		$image_meta_data = wp_get_attachment_metadata( $attachment_id );
		// Get file path
		$bf_images_path = $this->bf_images_directory_options->get_bf_images_path( $attachment_id );

		if ( ! empty( $image_meta_data['file'] ) ) {
			$bf_images_file_path = $bf_images_path . DIRECTORY_SEPARATOR . $this->bf_images_directory_options->get_bf_images_file_name( basename( $image_meta_data['file'] ), $size[0], $size[1], $crop );
		}

		// If image exists return image url
		if ( ! empty( $bf_images_file_path ) && file_exists( $bf_images_file_path ) ) {
			return $this->bf_images_directory_options->get_bf_images_full_path( $bf_images_file_path );
		}

		// Check if images directory is writeable
		if ( ! $this->bf_images_directory_options->is_advanced_images_dir_writable() ) {
			return '';
		}

		// Get WP Image Editor Instance
		$image_path   = get_attached_file( $attachment_id );
		$image_editor = wp_get_image_editor( $image_path );
		if ( ! is_wp_error( $image_editor ) && ! empty( $bf_images_file_path ) ) {
			// Create new image
			$image_editor->resize( $size[0], $size[1], $crop );
			$image_editor->save( $bf_images_file_path );

			return $this->bf_images_directory_options->get_bf_images_full_path( $bf_images_file_path );
		}

		return wp_get_attachment_url( $attachment_id );
	}
}
