<?php

namespace bfAdvancedImages\controller;

use bfAdvancedImages\core\BFImagesDirectoryOptions;
use bfAdvancedImages\providers\BFImageProvider;
use bfAdvancedImages\core\BFConstants;

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

		// Check if WebP conversion is enabled
		$webp_enabled = get_option( BFConstants::BFAI_WEBP_CONVERSION_OPTION, false );
		
		// If WebP is enabled, check for WebP version first
		if ( $webp_enabled && ! empty( $bf_images_file_path ) ) {
			$webp_path = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $bf_images_file_path );
			if ( file_exists( $webp_path ) ) {
				return $this->bf_images_directory_options->get_bf_images_full_path( $webp_path );
			}
		}

		// If WebP not found or not enabled, check for original format
		if ( ! empty( $bf_images_file_path ) && file_exists( $bf_images_file_path ) ) {
			// If WebP is enabled but not found, try to convert
			if ( $webp_enabled ) {
				$webp_path = $this->convert_to_webp( $bf_images_file_path );
				if ( $webp_path ) {
					return $this->bf_images_directory_options->get_bf_images_full_path( $webp_path );
				}
			}
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

			// Convert to WebP if enabled
			if ( $webp_enabled ) {
				$webp_path = $this->convert_to_webp( $bf_images_file_path );
				if ( $webp_path ) {
					return $this->bf_images_directory_options->get_bf_images_full_path( $webp_path );
				}
			}

			return $this->bf_images_directory_options->get_bf_images_full_path( $bf_images_file_path );
		}

		return wp_get_attachment_url( $attachment_id );
	}

	private function convert_to_webp( string $image_path ): ?string {
		if ( ! function_exists( 'imagewebp' ) ) {
			error_log( 'BF Advanced Images: WebP function not available' );
			return null;
		}

		$webp_path = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $image_path );
		
		// Get image info
		$image_info = getimagesize( $image_path );
		if ( ! $image_info ) {
			error_log( 'BF Advanced Images: Could not get image info for: ' . $image_path );
			return null;
		}

		// Create image from file
		switch ( $image_info[2] ) {
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg( $image_path );
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng( $image_path );
				// Preserve transparency
				imagepalettetotruecolor( $image );
				imagealphablending( $image, true );
				imagesavealpha( $image, true );
				break;
			default:
				error_log( 'BF Advanced Images: Unsupported image type: ' . $image_info[2] );
				return null;
		}

		if ( ! $image ) {
			error_log( 'BF Advanced Images: Could not create image resource from: ' . $image_path );
			return null;
		}

		// Get WebP settings
		$lossless = get_option( BFConstants::BFAI_WEBP_LOSSLESS_OPTION, false );
		$quality = get_option( BFConstants::BFAI_WEBP_QUALITY_OPTION, 80 );

		// Save as WebP
		$success = imagewebp( $image, $webp_path, $lossless ? -1 : $quality );
		imagedestroy( $image );

		if ( ! $success ) {
			error_log( 'BF Advanced Images: Failed to save WebP image: ' . $webp_path );
			return null;
		}

		error_log( 'BF Advanced Images: Successfully converted to WebP: ' . $webp_path . ' (Lossless: ' . ($lossless ? 'Yes' : 'No') . ', Quality: ' . $quality . ')' );
		return $webp_path;
	}
}
